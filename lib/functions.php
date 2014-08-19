<?php
/**
 * All helper functions are bundled here
 */

/**
 * Check if the user is an admin
 *
 * @param ElggUser $user the user to check (default is current logged in user)
 *
 * @return bool
 */
function admin_tools_is_admin_user(ElggUser $user = null) {
	$result = false;
	
	// no param, check current logged in user
	if (empty($user)) {
		$user = elgg_get_logged_in_user_entity();
	}
	
	// no user to check
	if (empty($user) || !elgg_instanceof($user, "user")) {
		return $result;
	}
	
	if ($user->isAdmin()) {
		$result = true;
	} elseif ($setting = elgg_get_plugin_user_setting("switched_admin", $user->getGUID(), "admin_tools")) {
		
		if (admin_tools_validate_switch_admin_secret($setting, $user)) {
			$result = true;
		}
	}
	
	return $result;
}

/**
 * Create a secret code to toggle admin/normal user
 *
 * @param ElggUser $user the user to create the secret for
 *
 * @return bool|string
 */
function admin_tools_make_switch_admin_secret(ElggUser $user = null) {
	
	// no param, check current logged in user
	if (empty($user)) {
		$user = elgg_get_logged_in_user_entity();
	}
	
	// no user to check
	if (empty($user) || !elgg_instanceof($user, "user")) {
		return false;
	}
	
	return hash_hmac("sha256", $user->time_created, get_site_secret());
}

function admin_tools_validate_switch_admin_secret($secret, ElggUser $user = null) {
	$result = false;
	
	if (empty($secret)) {
		return $result;
	}
	
	// no param, check current logged in user
	if (empty($user)) {
		$user = elgg_get_logged_in_user_entity();
	}
	
	// no user to check
	if (empty($user) || !elgg_instanceof($user, "user")) {
		return false;
	}
	
	$correct_secret = admin_tools_make_switch_admin_secret($user);
	if (!empty($correct_secret) && ($correct_secret === $secret)) {
		$result = true;
	}
	
	return $result;
}
