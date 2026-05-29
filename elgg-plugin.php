<?php

use ColdTrick\AdminTools\Controllers\Actions\ChangeText;
use ColdTrick\AdminTools\Controllers\Actions\ChangeTextExport;
use ColdTrick\AdminTools\Controllers\Actions\ChangeTextExportExtended;
use ColdTrick\AdminTools\Notifications\DeadLinks;
use ColdTrick\AdminTools\Upgrades\RestoreAdminRights;

require_once(dirname(__FILE__) . '/lib/functions.php');

return [
	'plugin' => [
		'version' => '11.0',
	],
	'settings' => [
		'deadlink_enabled' => 'disabled',
		'deadlink_include_skipped_domains' => 1,
	],
	'actions' => [
		'admin_tools/toggle_admin' => [],
		'admin_tools/change_text' => ['access' => 'admin', 'controller' => ChangeText::class],
		'admin_tools/change_text/export' => ['access' => 'admin', 'controller' => ChangeTextExport::class],
		'admin_tools/change_text/export_extended' => ['access' => 'admin', 'controller' => ChangeTextExportExtended::class],
		'admin_tools/deadlinks/delete' => ['access' => 'admin'],
	],
	'entities' => [
		[
			'type' => 'user',
			'subtype' => 'user',
			'class' => \AdminToolsUser::class,
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
				'\ColdTrick\AdminTools\Menus\Topbar::register' => [],
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
	'notifications' => [
		'user' => [
			'user' => [
				'admin_tools:deadlinks' => [
					DeadLinks::class => [],
				],
			],
		],
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
