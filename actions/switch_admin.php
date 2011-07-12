<?php 
	if($user = get_loggedin_user()){
		$admin_tools_switch_admin = get_private_setting($user->guid, "admin_tools_switch_admin");
		
		if(isadminloggedin() || $admin_tools_switch_admin == md5($user->guid . $user->salt)){
			if(empty($admin_tools_switch_admin)){
				set_private_setting($user->guid, "admin_tools_switch_admin", md5($user->guid . $user->salt));
				system_message(elgg_echo("admin_tools:switch_admin:normal"));
				$user->removeAdmin();
			} else {
				remove_private_setting($user->guid, "admin_tools_switch_admin");
				system_message(elgg_echo("admin_tools:switch_admin:admin"));
				$user->makeAdmin();
			}
		}
	}
	forward($_SERVER["HTTP_REFERER"]);
?>