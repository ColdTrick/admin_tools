<?php

namespace ColdTrick\AdminTools;

use Elgg\Database\QueryBuilder;
use Elgg\Email;
use Elgg\Exceptions\UnexpectedValueException;
use Elgg\Values;

/**
 * Cron handlers
 */
class Cron {
	
	protected const URL_PATTERN = '~(?xi)
              (?:
                ((ht|f)tps?://)                      # scheme://
                |                                    #   or
                www\d{0,3}\.                         # "www.", "www1.", "www2." ... "www999."
                |                                    #   or
                www\-                                # "www-"
                |                                    #   or
                [a-z0-9.\-]+\.[a-z]{2,4}(?=/)        # looks like domain name followed by a slash
              )
              (?:                                    # Zero or more:
                [^\s()<>]+                           # Run of non-space, non-()<>
                |                                    #   or
                \((?>[^\s()<>]+|(\([^\s()<>]+\)))*\) # balanced parens, up to 2 levels
              )*
              (?:                                    # End with:
                \((?>[^\s()<>]+|(\([^\s()<>]+\)))*\) # balanced parens, up to 2 levels
                |                                    #   or
                [^\s`!\-()\[\]{};:\'".,<>?Â«Â»â€œâ€�â€˜â€™]    # not a space or one of these punct chars
              )
        ~u';
	
	/**
	 * Detect deadlinks
	 *
	 * @param \Elgg\Event $event 'cron', 'daily'|'weekly'|'monthly'
	 *
	 * @return void
	 * @throws UnexpectedValueException
	 */
	public static function detectDeadlinks(\Elgg\Event $event): void {
		$plugin = elgg_get_plugin_from_id('admin_tools');
		if ($plugin->deadlink_enabled !== $event->getType()) {
			return;
		}
		
		$setting_type_subtype = $plugin->deadlink_type_subtype;
		if (empty($setting_type_subtype)) {
			return;
		}
		
		$setting_type_subtype = json_decode($setting_type_subtype, true);
		$type_subtypes = [];
		foreach ($setting_type_subtype as $type_subtype) {
			$split = explode('.', $type_subtype);
			$type = array_shift($split);
			$subtype = implode('.', $split);
			
			if (!isset($type_subtypes[$type])) {
				$type_subtypes[$type] = [];
			}
			
			$type_subtypes[$type][] = $subtype;
		}
		
		$options = [
			'type_subtype_pairs' => $type_subtypes,
			'metadata_names' => [
				'description',
			],
			'limit' => false,
			'batch' => true,
			'batch_inc_offset' => false,
			'wheres' => [
				function(QueryBuilder $qb, $main_alias) {
					// must contain a link
					return $qb->merge([
						$qb->compare("{$main_alias}.value", 'LIKE', '%http://%', ELGG_VALUE_STRING),
						$qb->compare("{$main_alias}.value", 'LIKE', '%https://%', ELGG_VALUE_STRING),
					], 'OR');
				},
				function(QueryBuilder $qb, $main_alias) {
					// no private content
					$e = $qb->joinEntitiesTable($main_alias, 'entity_guid');
					return $qb->compare("{$e}.access_id", '!=', ACCESS_PRIVATE, ELGG_VALUE_INTEGER);
				}
			],
			'sort_by' => [
				'property' => 'time_created',
				'direction' => 'ASC',
			],
		];
		
		$created_before = (int) $plugin->deadlink_created_before;
		if ($created_before > 0) {
			$options['created_before'] = "-{$created_before} days";
		}
		
		$rescan = (int) $plugin->deadlink_rescan;
		if ($rescan > 0) {
			$options['wheres'][] = function(QueryBuilder $qb, $main_alias) use ($rescan) {
				$not_scanned = $qb->subquery('metadata');
				$not_scanned->select('entity_guid')
					->where($qb->compare('name', '=', 'admin_tools_deadlink_scanned', ELGG_VALUE_STRING));
				
				$rescanned = $qb->subquery('metadata');
				$rescanned->select('entity_guid')
					->where($qb->compare('name', '=', 'admin_tools_deadlink_scanned', ELGG_VALUE_STRING))
					->andWhere($qb->compare('value', '<', Values::normalizeTimestamp("-{$rescan} days"), ELGG_VALUE_TIMESTAMP));
				
				return $qb->merge([
					$qb->compare("{$main_alias}.entity_guid", 'NOT IN', $not_scanned->getSQL()),
					$qb->compare("{$main_alias}.entity_guid", 'IN', $rescanned->getSQL()),
				], 'OR');
			};
		}
		
		$cron_start = $event->getParam('dt');
		switch ($event->getType()) {
			case 'monthly':
				$max_runtime = 2 * 60 * 60; // 2 hours
				break;
			case 'weekly':
				$max_runtime = 60 * 60; // 1 hour
				break;
			case 'daily':
			default:
				$max_runtime = 30 * 60; // 30 minutes
				break;
		}
		
		set_time_limit(0);
		_elgg_services()->queryCache->disable(false);
		
		try {
			$found = elgg_call(ELGG_IGNORE_ACCESS, function() use ($options, $max_runtime, $cron_start, $plugin) {
				$start = microtime(true);
				
				$file = new \ElggFile();
				$file->owner_guid = $plugin->guid;
				$file->setFilename('deadlinks/' . $cron_start->format('Y/m/d') . '.csv');
				
				$fh = $file->open('write');
				fputcsv($fh, [
					'URL',
					'Host',
					'Entity URL',
					'Entity time updated',
					'Owner name',
					'Owner URL',
					'Owner e-mail',
					'Status',
				], ';', '"', '\\');
				
				$deadlinks_found = 0;
				$links_logged = 0;
				
				/* @var $batch \ElggBatch */
				$batch = elgg_get_metadata($options);
				/* @var $metadata \ElggMetadata */
				foreach ($batch as $metadata) {
					if ((microtime(true) - $start) > $max_runtime) {
						break;
					}
					
					$matches = [];
					preg_match_all(self::URL_PATTERN, html_entity_decode($metadata->value), $matches);
					$urls = array_unique($matches[0]);
					if (empty($urls)) {
						continue;
					}
					
					$entity = $metadata->getEntity();
					$owner = elgg_trigger_event_results('deadlink_owner', 'admin_tools', [
						'metadata' => $metadata,
						'entity' => $entity,
					], $entity->getOwnerEntity());
					if (!$owner instanceof \ElggEntity) {
						throw new UnexpectedValueException("The 'deadlink_owner', 'admin_tools' event should return an \ElggEntity");
					}
					
					foreach ($urls as $url) {
						$host = parse_url($url, PHP_URL_HOST);
						if (empty($host)) {
							continue;
						}
						
						$log_result = true;
						$status = self::checkURLStatus($url);
						switch ($status) {
							case ELGG_HTTP_OK:
								// link still works
								$log_result = (bool) $plugin->deadlink_include_success_results;
								break;
							case 'skipped':
								// host was in a skipped domain
								$log_result = (bool) $plugin->deadlink_include_skipped_domains;
								break;
							case ELGG_HTTP_NOT_FOUND:
							case 0: // unable to resolve host
								$deadlinks_found++;
								break;
						}
						
						if (!$log_result) {
							continue;
						}
						
						$links_logged++;
						
						fputcsv($fh, [
							$url,
							$host,
							$entity->getURL(),
							date(DATE_ISO8601, $entity->time_updated),
							$owner->getDisplayName(),
							$owner->getURL(),
							$owner->email,
							$status,
						], ';', '"', '\\');
					}
					
					// don't scan again until rescan is required
					$entity->admin_tools_deadlink_scanned = time();
					
					$entity->invalidateCache();
					$owner->invalidateCache();
				}
				
				$file->close();
				if (empty($links_logged)) {
					$file->delete();
				}
				
				if (!empty($deadlinks_found)) {
					self::sendNotifications($file, $deadlinks_found);
				}
				
				return $deadlinks_found;
			});
		} catch (\Error $e) {
			_elgg_services()->queryCache->enable();
			throw $e;
		}
		
		_elgg_services()->queryCache->enable();
		
		$event->getParam('logger')->notice("Found {$found} deadlinks");
	}
	
	/**
	 * Get the URL status to see if it's a deadlink
	 *
	 * @param string $url the URL to check
	 *
	 * @return mixed
	 */
	protected static function checkURLStatus(string $url) {
		$host = parse_url($url, PHP_URL_HOST);
		if (empty($host)) {
			return null;
		} elseif (self::isSkippedDomain($host)) {
			return 'skipped';
		}
		
		// create a new cURL resource
		$ch = curl_init();
		
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		
		// This changes the request method to HEAD
		curl_setopt($ch, CURLOPT_NOBODY, true);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5); // connect timeout
		curl_setopt($ch, CURLOPT_TIMEOUT, 10); // curl timeout
		curl_setopt($ch, CURLOPT_URL, $url);
		
		$result = curl_exec($ch) ? curl_getinfo($ch, CURLINFO_HTTP_CODE) : 0;
		
		curl_close($ch);
		
		return $result;
	}
	
	/**
	 * Check if a hostname should be skipped for checking
	 *
	 * @param string $host the hostname to check
	 *
	 * @return bool
	 */
	protected static function isSkippedDomain(string $host): bool {
		static $pattern;
		if (!isset($pattern)) {
			$pattern = false;
			$setting = elgg_get_plugin_setting('deadlink_skipped_domains', 'admin_tools');
			if (!empty($setting)) {
				$skipped_domains = elgg_string_to_array($setting);
				
				$pattern = '';
				foreach ($skipped_domains as $domain) {
					$pattern .= preg_quote($domain) . '|';
				}
				
				$pattern = trim($pattern, '|');
				$pattern = '/(?>^|\W)?(?>' . $pattern . ')$/';
			}
		}
		
		if (empty($pattern)) {
			return false;
		}
		
		return (bool) preg_match($pattern, $host);
	}
	
	/**
	 * Send a notification to all admins and an additional e-mail address
	 *
	 * @param \ElggFile $csv       file with the results
	 * @param int       $deadlinks number of dead links found
	 *
	 * @return void
	 */
	protected static function sendNotifications(\ElggFile $csv, int $deadlinks): void {
		$path = str_ireplace('deadlinks/', '', $csv->getFilename());
		$path = explode('/', $path);
		array_pop($path);
		$path = implode('/', $path);
		
		$url = elgg_normalize_url(elgg_http_add_url_query_elements('admin/administer_utilities/deadlinks', [
			'dir' => $path,
		]));
		
		$notification_params = [
			'action' => 'admin_tools:deadlinks',
			'url' => $url,
		];
		
		/* @var $batch \ElggBatch */
		$batch = elgg_get_entities([
			'type' => 'user',
			'limit' => false,
			'batch' => true,
			'metadata_name_value_pairs' => [
				'admin' => 'yes',
			],
		]);
		
		/* @var $user \ElggUser */
		foreach ($batch as $user) {
			$settings = $user->getNotificationSettings('admin_tools:deadlinks');
			$methods = array_keys(array_filter($settings));
			if (empty($methods)) {
				continue;
			}
			
			$subject = elgg_echo('admin_tools:notification:deadlinks:subject', [], $user->language);
			$summary = elgg_echo('admin_tools:notification:deadlinks:summary', [], $user->language);
			$body = elgg_echo('admin_tools:notification:deadlinks:body', [
				$deadlinks,
				$url,
			], $user->language);
			$notification_params['summary'] = $summary;
			
			notify_user($user->guid, 0, $subject, $body, $notification_params, $methods);
		}
		
		$email = elgg_get_plugin_setting('deadlink_report_email', 'admin_tools');
		if (!empty($email) && elgg_is_valid_email($email)) {
			$subject = elgg_echo('admin_tools:notification:deadlinks:subject');
			$summary = elgg_echo('admin_tools:notification:deadlinks:summary');
			$body = elgg_echo('admin_tools:notification:deadlinks:body', [
				$deadlinks,
				$url,
			]);
			$notification_params['summary'] = $summary;
			
			elgg_send_email(Email::factory([
				'to' => $email,
				'subject' => $subject,
				'body' => $body,
				'params' => $notification_params,
			]));
		}
	}
}
