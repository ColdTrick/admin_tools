<?php

namespace ColdTrick\AdminTools\Upgrades;

use Elgg\Upgrade\Result;
use Elgg\Upgrade\SystemUpgrade;

/**
 * Restore the admin rights for the admins that are currently switched to normal user
 */
class RestoreAdminRights extends SystemUpgrade {
	
	/**
	 * {@inheritdoc}
	 */
	public function getVersion(): int {
		return 2024010901;
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function shouldBeSkipped(): bool {
		return empty($this->countItems());
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function needsIncrementOffset(): bool {
		return false;
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function countItems(): int {
		return elgg_count_entities($this->getOptions());
	}
	
	/**
	 * {@inheritdoc}
	 */
	public function run(Result $result, $offset): Result {
		/* @var $users \ElggBatch */
		$users = elgg_get_entities($this->getOptions([
			'offset' => $offset,
		]));
		/* @var $user \AdminToolsUser */
		foreach ($users as $user) {
			// can't use magic setter because not allowed
			// can't use makeAdmin() because we don't want the events
			if (!$user->setMetadata('admin', 'yes')) {
				$result->addFailures();
				$users->reportFailure();
				continue;
			}
			
			$result->addSuccesses();
		}
		
		return $result;
	}
	
	/**
	 * Get options for elgg_get_entities()
	 *
	 * @param array $options additional options
	 *
	 * @return array
	 * @see elgg_get_entities()
	 */
	protected function getOptions(array $options = []): array {
		$defaults = [
			'type' => 'user',
			'limit' => 25,
			'batch' => true,
			'batch_inc_offset' => $this->needsIncrementOffset(),
			'metadata_name_value_pairs' => [
				[
					'name' => 'admin',
					'value' => 'no',
				],
				[
					'name' => 'plugin:user_setting:admin_tools:switched_admin',
					'operand' => 'is not null',
				],
			],
		];
		
		return array_merge($defaults, $options);
	}
}