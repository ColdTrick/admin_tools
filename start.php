<?php

	require_once(dirname(__FILE__) . '/lib/functions.php');

	function admin_tools_init() {
		error_reporting(E_ALL);
		ini_set('display_errors', 1);

		if(elgg_is_active_plugin('developers')) {
			set_error_handler('admin_tools_error_handler');
		}

		if($user = elgg_get_logged_in_user_entity()) {
			if(elgg_is_admin_logged_in() || 
			(get_private_setting($user->getGUID(), 'admin_tools_switch_admin') == md5($user->getGUID() . $user->salt))) {
				
				if(!elgg_in_context('admin')) {
					if(elgg_get_plugin_setting('show', 'admin_tools') == 'yes') {
						elgg_extend_view('page/elements/header', 	'admin_tools/tools');
						elgg_extend_view('footer/analytics', 		'admin_tools/footer', 999);
					}
				}
			}
		}

		elgg_extend_view('css/elgg', 'admin_tools/css');
		elgg_extend_view('admin/statistics/server', 	'admin_tools/admin/statistics/server');
		elgg_extend_view('admin/statistics/server/php', 'admin_tools/admin/statistics/server/php');

		elgg_register_page_handler('phpinfo', 'admin_tools_page_handler');

		elgg_register_admin_menu_item('administer', 'elgg', 'statistics');
	} 

	function admin_tools_page_handler($page, $handler) {
		include(dirname(__FILE__) . '/pages/phpinfo.php');
	}

	function admin_tools_error_handler($errno, $errstr, $errfile = '', $errline = 0, $vars = array()) {
		switch ($errno) {
			case 2:
				$error_level = 'Warning';
				break;
			case 8:
				$error_level = 'Notice';
				break;
			case 256:
				$error_level = 'User error';
				break;
			case 512:
				$error_level = 'User warning';
				break;
			case 1024:
				$error_level = 'User notice';
				break;
		}

		elgg_dump("$error_level: $errstr in $errfile on line ($errline)", true, $errno);

		_elgg_php_error_handler($errno, $errstr, $errfile, $errline, $vars);
	}

	elgg_register_event_handler('init', 'system', 'admin_tools_init');

	elgg_register_action('admin_tools/switch_admin', dirname(__FILE__) . '/actions/switch_admin.php');
	elgg_register_action('admin_tools/plugin_action', dirname(__FILE__) . '/actions/plugin_action.php', 'admin');