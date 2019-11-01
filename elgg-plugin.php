<?php

require_once(dirname(__FILE__) . '/lib/functions.php');

use ColdTrick\AdminTools\Bootstrap;

return [
	'bootstrap' => Bootstrap::class,
	'actions' => [
		'admin_tools/toggle_admin' => [],
		'admin_tools/change_text' => ['access' => 'admin'],
	],
];
