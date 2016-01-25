<?php
/**
 * All helper functions are bundled here
 */

/**
 * Check if the user is an admin
 *
 * @param ElggUser $user the user to check (default: current user)
 *
 * @return bool
 */
function admin_tools_is_admin_user(ElggUser $user = null) {
	
	// no param, check current logged in user
	if (empty($user)) {
		$user = elgg_get_logged_in_user_entity();
	}
	
	// no user to check
	if (!($user instanceof ElggUser)) {
		return false;
	}
	
	// user is admin
	if ($user->isAdmin()) {
		return true;
	}
	
	// is user a hidden admin?
	$setting = elgg_get_plugin_user_setting('switched_admin', $user->getGUID(), 'admin_tools');
	if (empty($setting)) {
		return false;
	}
	
	// validate setting
	if (admin_tools_validate_switch_admin_secret($setting, $user)) {
		return true;
	}
	
	return false;
}

/**
 * Create a secret code to toggle admin/normal user
 *
 * @param ElggUser $user the user to create the secret for (default: current user)
 *
 * @return false|string
 */
function admin_tools_make_switch_admin_secret(ElggUser $user = null) {
	
	// no param, check current logged in user
	if (empty($user)) {
		$user = elgg_get_logged_in_user_entity();
	}
	
	// no user to check
	if (!($user instanceof ElggUser)) {
		return false;
	}
	
	return hash_hmac('sha256', $user->time_created, get_site_secret());
}

/**
 * Validate the secret of a user to switch to the real thing
 *
 * @param string   $secret the string to validate
 * @param ElggUser $user   the user to validate for (default: current user)
 *
 * @return bool
 */
function admin_tools_validate_switch_admin_secret($secret, ElggUser $user = null) {
	
	if (empty($secret)) {
		return false;
	}
	
	// no param, check current logged in user
	if (empty($user)) {
		$user = elgg_get_logged_in_user_entity();
	}
	
	// no user to check
	if (!($user instanceof ElggUser)) {
		return false;
	}
	
	$correct_secret = admin_tools_make_switch_admin_secret($user);
	
	return ($correct_secret === $secret);
}
