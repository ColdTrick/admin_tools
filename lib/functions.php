<?php
/**
 * All helper functions are bundled here
 */

/**
 * Check if the user is an admin
 *
 * @param \ElggUser|null $user the user to check (default: current user)
 *
 * @return bool
 */
function admin_tools_is_admin_user(\ElggUser $user = null): bool {
	// no param, check current logged-in user
	if (empty($user)) {
		$user = elgg_get_logged_in_user_entity();
	}
	
	// no user to check
	if (!$user instanceof \ElggUser) {
		return false;
	}
	
	// user is admin
	if ($user->isAdmin()) {
		return true;
	}
	
	// is user a hidden admin?
	$setting = $user->getPluginSetting('admin_tools', 'switched_admin');
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
 * @param \ElggUser|null $user the user to create the secret for (default: current user)
 *
 * @return null|string
 */
function admin_tools_make_switch_admin_secret(\ElggUser $user = null): ?string {
	// no param, check current logged-in user
	if (empty($user)) {
		$user = elgg_get_logged_in_user_entity();
	}
	
	// no user to check
	if (!$user instanceof \ElggUser) {
		return null;
	}
	
	return elgg_build_hmac([
		$user->time_created,
	])->getToken();
}

/**
 * Validate the secret of a user to switch to the real thing
 *
 * @param string         $secret the string to validate
 * @param \ElggUser|null $user   the user to validate for (default: current user)
 *
 * @return bool
 */
function admin_tools_validate_switch_admin_secret(string $secret, \ElggUser $user = null): bool {
	if (empty($secret)) {
		return false;
	}
	
	// no param, check current logged-in user
	if (empty($user)) {
		$user = elgg_get_logged_in_user_entity();
	}
	
	// no user to check
	if (!$user instanceof \ElggUser) {
		return false;
	}
	
	return admin_tools_make_switch_admin_secret($user) === $secret;
}
