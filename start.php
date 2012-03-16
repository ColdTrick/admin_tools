<?php

	require_once(dirname(__FILE__) . "/lib/functions.php");

	function admin_tools_init(){
		if($user = elgg_get_logged_in_user_entity()){
			if(elgg_is_admin_logged_in() || (get_private_setting($user->getGUID(), "admin_tools_switch_admin") == md5($user->getGUID() . $user->salt))){
				
				if(!elgg_in_context("admin")){
					elgg_extend_view("page/elements/header", "admin_tools/tools");
					elgg_extend_view("footer/analytics", "admin_tools/footer", 999);
				}
			}
		}

		elgg_extend_view("css/elgg", "admin_tools/css");
	}

	elgg_register_event_handler("init", "system", "admin_tools_init");
	
	elgg_register_action("admin_tools/switch_admin", dirname(__FILE__) . "/actions/switch_admin.php"); // don"t make admin only!!!
	elgg_register_action("admin_tools/plugin_action", dirname(__FILE__) . "/actions/plugin_action.php", "admin");