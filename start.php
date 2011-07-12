<?php
	
	// load global functions
	require_once(dirname(__FILE__) . "/lib/functions.php");

	function admin_tools_init(){
		if($user = get_loggedin_user()){
			if(isadminloggedin() || get_private_setting($user->guid, "admin_tools_switch_admin") == md5($user->guid . $user->salt)){
				elgg_extend_view("page_elements/header", "admin_tools/tools");
				elgg_extend_view("admin/plugins","admin_tools/plugins",400);
			}
		}
		
		elgg_extend_view("css", "admin_tools/css");
	}
	
	// register default elgg event
	register_elgg_event_handler("init", "system", "admin_tools_init");
	
	// register actions
	register_action("admin_tools/switch_admin", false, dirname(__FILE__) . "/actions/switch_admin.php"); // don't make admin only!!!
	register_action("admin_tools/plugin_action", false, dirname(__FILE__) . "/actions/plugin_action.php", true);
?>
