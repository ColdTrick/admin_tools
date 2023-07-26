<?php

require_once(dirname(__FILE__) . '/lib/functions.php');

return [
	'plugin' => [
		'version' => '7.0.1',
	],
	'settings' => [
		'deadlink_include_skipped_domains' => 1,
	],
	'actions' => [
		'admin_tools/toggle_admin' => [],
		'admin_tools/change_text' => ['access' => 'admin'],
		'admin_tools/change_text/export' => ['access' => 'admin'],
		'admin_tools/change_text/export_extended' => ['access' => 'admin'],
		'admin_tools/deadlinks/delete' => ['access' => 'admin'],
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
				'\ColdTrick\AdminTools\Admin::makeAdmin' => [],
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
				'\ColdTrick\AdminTools\Admin::removeAdmin' => [],
			],
		],
		'setting' => [
			'plugin' => [
				'\ColdTrick\AdminTools\PluginSettings::save' => [],
			],
		],
	],
	'view_extensions' => [
		'admin/users/admins' => [
			'admin_tools/hidden_admins' => [],
		],
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
