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

// temporarily disable security notifications
$prevent_notification = function(\Elgg\Hook $hook) use ($user) {
	
	if (!$hook->getValue()) {
		// already prevented
	}
	
	$object = $hook->getParam('object');
	if (!$object instanceof ElggUser || $object->guid !== $user->guid) {
		return;
	}
	
	if (!in_array($hook->getParam('action'), ['make_admin', 'remove_admin'])) {
		// not our event notification
		return;
	}
	
	return false;
};

elgg_register_plugin_hook_handler('enqueue', 'notification', $prevent_notification);

// restore security notifications
$restore_notifications = function() use (&$prevent_notification) {
	elgg_unregister_plugin_hook_handler('enqueue', 'notification', $prevent_notification);
};

if ($user->isAdmin()) {
	// make the user a normal user
	$secret = admin_tools_make_switch_admin_secret($user);
	if (!empty($secret)) {
		
		// remove the admin role from the user
		$user->removeAdmin();
		
		$restore_notifications();
		
		// store secret in order to be able to switch back
		$user->setPluginSetting('admin_tools', 'switched_admin', $secret);
		
		return elgg_ok_response('', elgg_echo('admin_tools:action:toggle_admin:success:user'));
	}
} else {
	// make the user an admin
	$user->makeAdmin();
	
	$restore_notifications();
	
	// clear secret
	$user->removePluginSetting('admin_tools', 'switched_admin');
	
	return elgg_ok_response('', elgg_echo('admin_tools:action:toggle_admin:success:admin'));
}

return elgg_error_response(elgg_echo('save:fail'));
