<?php

require_once(dirname(__FILE__) . '/lib/functions.php');

use ColdTrick\AdminTools\Bootstrap;

return [
	'plugin' => [
		'version' => '6.0',
	],
	'bootstrap' => Bootstrap::class,
	'actions' => [
		'admin_tools/toggle_admin' => [],
		'admin_tools/change_text' => ['access' => 'admin'],
		'admin_tools/change_text/export' => ['access' => 'admin'],
		'admin_tools/change_text/export_extended' => ['access' => 'admin'],
	],
];
