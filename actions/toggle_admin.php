<?php
/**
 * Toggle admin on/off for admins
 */

$user_guid = (int) get_input('user_guid');
if (empty($user_guid) || ($user_guid != elgg_get_logged_in_user_guid())) {
	register_error(elgg_echo('actionunauthorized'));
	forward(REFERER);
}

$user = get_user($user_guid);
if (empty($user)) {
	forward(REFERER);
}

if (!admin_tools_is_admin_user($user)) {
	register_error(elgg_echo('actionunauthorized'));
	forward(REFERER);
}

if ($user->isAdmin()) {
	// make the user a normal user
	$secret = admin_tools_make_switch_admin_secret($user);
	if (!empty($secret)) {
		$user->removeAdmin();
		
		elgg_set_plugin_user_setting('switched_admin', $secret, $user->getGUID(), 'admin_tools');
		
		system_message(elgg_echo('admin_tools:action:toggle_admin:success:user'));
	} else {
		register_error(elgg_echo('save:fail'));
	}
} else {
	// make the user an admin
	$user->makeAdmin();
	
	elgg_unset_plugin_user_setting('switched_admin', $user->getGUID(), 'admin_tools');
	
	system_message(elgg_echo('admin_tools:action:toggle_admin:success:admin'));
	
}

forward(REFERER);