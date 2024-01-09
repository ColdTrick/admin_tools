<?php

use ColdTrick\AdminTools\Upgrades\RestoreAdminRights;

require_once(dirname(__FILE__) . '/lib/functions.php');

return [
	'plugin' => [
		'version' => '8.0',
	],
	'settings' => [
		'deadlink_enabled' => 'disabled',
		'deadlink_include_skipped_domains' => 1,
	],
	'actions' => [
		'admin_tools/toggle_admin' => [],
		'admin_tools/change_text' => ['access' => 'admin'],
		'admin_tools/change_text/export' => ['access' => 'admin'],
		'admin_tools/change_text/export_extended' => ['access' => 'admin'],
		'admin_tools/deadlinks/delete' => ['access' => 'admin'],
	],
	'entities' => [
		[
			'type' => 'user',
			'subtype' => 'user',
			'class' => 'AdminToolsUser',
			'capabilities' => [
				'searchable' => true,
			],
		],
	],
	'events' => [
		'commands' => [
			'cli' => [
				'\ColdTrick\AdminTools\CLI::registerCommand' => [],
			],
		],
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
		'make_admin' => [
			'user' => [
				'\ColdTrick\AdminTools\Admin::removeTempUserSwitch' => [],
			],
		],
		'register' => [
			'menu:admin_header' => [
				'\ColdTrick\AdminTools\Menus\AdminHeader::register' => [],
			],
			'menu:topbar' => [
				'\ColdTrick\AdminTools\Admin::registerTopbar' => [],
			],
		],
		'remove_admin' => [
			'user' => [
				'\ColdTrick\AdminTools\Admin::removeTempUserSwitch' => [],
			],
		],
		'setting' => [
			'plugin' => [
				'\ColdTrick\AdminTools\PluginSettings::save' => [],
			],
		],
	],
	'upgrades' => [
		RestoreAdminRights::class,
	],
	'view_extensions' => [
		'notifications/settings/records' => [
			'admin_tools/notifications/deadlinks' => [],
		],
	],
	'view_options' => [
		'admin_tools/change_text_preview' => [
			'ajax' => true,
		],
	],
];
