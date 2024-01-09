<?php
/**
 * Toggle admin on/off for admins
 */

$user_guid = (int) get_input('user_guid');
if (empty($user_guid) || ($user_guid !== elgg_get_logged_in_user_guid())) {
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
		// store secret in order to be able to switch back
		$user->setPluginSetting('admin_tools', 'switched_admin', $secret);
		
		return elgg_ok_response('', elgg_echo('admin_tools:action:toggle_admin:success:user'));
	}
} else {
	// clear secret
	$user->removePluginSetting('admin_tools', 'switched_admin');
	
	return elgg_ok_response('', elgg_echo('admin_tools:action:toggle_admin:success:admin'));
}

return elgg_error_response(elgg_echo('save:fail'));
