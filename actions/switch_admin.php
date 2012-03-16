<?php 
	if($user = elgg_get_logged_in_user_entity()) {
		$admin_tools_switch_admin = get_private_setting($user->guid, "admin_tools_switch_admin");

		if(elgg_is_admin_logged_in() || $admin_tools_switch_admin == md5($user->getGUID() . $user->salt)) {
			if(empty($admin_tools_switch_admin)) {
				set_private_setting($user->getGUID(), "admin_tools_switch_admin", md5($user->getGUID() . $user->salt));
				system_message(elgg_echo("admin_tools:switch_admin:normal"));
				$user->removeAdmin();
			} else {
				remove_private_setting($user->getGUID(), "admin_tools_switch_admin");
				system_message(elgg_echo("admin_tools:switch_admin:admin"));
				$user->makeAdmin();
			}
		}
	}

	forward(REFERER);