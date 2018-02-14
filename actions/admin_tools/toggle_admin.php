<?php
/**
 * Toggle admin on/off for admins
 */

$user_guid = (int) get_input('user_guid');
if (empty($user_guid) || ($user_guid != elgg_get_logged_in_user_guid())) {
	return elgg_error_response(elgg_echo('actionunauthorized'));
}

$user = get_user($user_guid);
if (empty($user)) {
	return elgg_error_response(elgg_echo('error:missing_data'));
}

if (!admin_tools_is_admin_user($user)) {
	return elgg_error_response(elgg_echo('actionunauthorized'));
}

if ($user->isAdmin()) {
	// make the user a normal user
	$secret = admin_tools_make_switch_admin_secret($user);
	if (!empty($secret)) {
		
		// temporarily disable security tools notifications
		$unregister = elgg_unregister_event_handler('remove_admin', 'user', 'security_tools_remove_admin_handler');
		
		// remove the admin role from the user
		$user->removeAdmin();
		
		// re-enable security tools
		if ($unregister) {
			elgg_register_event_handler('remove_admin', 'user', 'security_tools_remove_admin_handler');
		}
		
		// store secret in order to be able to switch back
		elgg_set_plugin_user_setting('switched_admin', $secret, $user->getGUID(), 'admin_tools');
		
		return elgg_ok_response('', elgg_echo('admin_tools:action:toggle_admin:success:user'), REFERER);
	}
} else {
	
	// temporarily disable security tools notifications
	$unregister = elgg_unregister_event_handler('make_admin', 'user', 'security_tools_make_admin_handler');
	
	// make the user an admin
	$user->makeAdmin();
	
	// re-enable security tools
	if ($unregister) {
		elgg_register_event_handler('make_admin', 'user', 'security_tools_make_admin_handler');
	}
	
	// clear secret
	elgg_unset_plugin_user_setting('switched_admin', $user->getGUID(), 'admin_tools');
	
	return elgg_ok_response('', elgg_echo('admin_tools:action:toggle_admin:success:admin'), REFERER);
}

return elgg_error_response(elgg_echo('save:fail'));
