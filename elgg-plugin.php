<?php

require_once(dirname(__FILE__) . '/lib/functions.php');

use ColdTrick\AdminTools\Bootstrap;

return [
	'plugin' => [
		'version' => '6.0.2',
	],
	'settings' => [
		'deadlink_include_skipped_domains' => 1,
	],
	'bootstrap' => Bootstrap::class,
	'actions' => [
		'admin_tools/toggle_admin' => [],
		'admin_tools/change_text' => ['access' => 'admin'],
		'admin_tools/change_text/export' => ['access' => 'admin'],
		'admin_tools/change_text/export_extended' => ['access' => 'admin'],
		'admin_tools/deadlinks/delete' => ['access' => 'admin'],
	],
	'hooks' => [
		'cron' => [
			'daily' => [
				'\ColdTrick\AdminTools\Cron::detectDeadlinks' => [],
			],
			'weekly' => [
				'\ColdTrick\AdminTools\Cron::detectDeadlinks' => [],
			],
			'monthly' => [
				'\ColdTrick\AdminTools\Cron::detectDeadlinks' => [],
			],
		],
		'setting' => [
			'plugin' => [
				'\ColdTrick\AdminTools\PluginSettings::save' => [],
			],
		],
	],
	'view_extensions' => [
		'notifications/settings/records' => [
			'admin_tools/notifications/deadlinks' => [],
		],
	],
];
