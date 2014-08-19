<?php
/**
 * All plugin hooks are bundled here
 */

/**
 * Add a menu item to the topbar
 *
 * @param string         $hook         the name of the hook
 * @param string         $type         the type of the hook
 * @param ElggMenuItem[] $return_value current menu items
 * @param array          $params       supplied params
 *
 * @return ElggMenuItem[]
 */
function admin_tools_register_topbar_menu_hook($hook, $type, $return_value, $params) {
	
	$user = elgg_get_logged_in_user_entity();
	if (empty($user)) {
		return $return_value;
	}
	
	// check if the user is an admin
	if (!admin_tools_is_admin_user($user)) {
		return $return_value;
	}
	
	if ($user->isAdmin()) {
		$text = elgg_echo("admin_tools:switch_to_user");
	} else {
		$text = elgg_echo("admin_tools:switch_to_admin");
	}
	
	$return_value[] = ElggMenuItem::factory(array(
		"name" => "switch_admin",
		"text" => $text,
		"href" => "action/admin_tools/toggle_admin?user_guid=" . $user->getGUID(),
		"is_action" => true,
		"is_trusted" => true,
		"section" => "alt",
		"parent_name" => elgg_is_active_plugin("aalborg_theme") ? "account" : ""
	));
	
	return $return_value;
}