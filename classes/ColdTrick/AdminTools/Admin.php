<?php

namespace ColdTrick\AdminTools;

class Admin {
	
	/**
	 * listen to the make admin event to unset the toggle admin flag
	 *
	 * @param string     $event  the event
	 * @param string     $type   the type of the event
	 * @param ElggEntity $entity the affected entity
	 *
	 * @return void
	 */
	public static function makeAdmin($event, $type, $entity) {
		
		if (!($entity instanceof \ElggUser)) {
			return;
		}
		
		elgg_unset_plugin_user_setting('switched_admin', $entity->getGUID(), 'admin_tools');
	}
	
	/**
	 * listen to the remove admin event to unset the toggle admin flag
	 *
	 * @param string     $event  the event
	 * @param string     $type   the type of the event
	 * @param ElggEntity $entity the affected entity
	 *
	 * @return void
	 */
	public static function removeAdmin($event, $type, $entity) {
		
		if (!($entity instanceof \ElggUser)) {
			return;
		}
		
		elgg_unset_plugin_user_setting('switched_admin', $entity->getGUID(), 'admin_tools');
	}
	
	/**
	 * Add a menu item to the topbar
	 *
	 * @param string          $hook         the name of the hook
	 * @param string          $type         the type of the hook
	 * @param \ElggMenuItem[] $return_value current menu items
	 * @param array           $params       supplied params
	 *
	 * @return void|\ElggMenuItem[]
	 */
	public static function registerTopbar($hook, $type, $return_value, $params) {
		
		$user = elgg_get_logged_in_user_entity();
		if (empty($user)) {
			return;
		}
		
		// check if the user is an admin
		if (!admin_tools_is_admin_user($user)) {
			return;
		}
		
		if ($user->isAdmin()) {
			$text = elgg_echo('admin_tools:switch_to_user');
		} else {
			$text = elgg_echo('admin_tools:switch_to_admin');
		}
		
		$return_value[] = \ElggMenuItem::factory([
			'name' => 'switch_admin',
			'text' => $text,
			'href' => 'action/admin_tools/toggle_admin?user_guid=' . $user->getGUID(),
			'is_action' => true,
			'is_trusted' => true,
			'section' => 'alt',
			'parent_name' => elgg_is_active_plugin('aalborg_theme') ? 'account' : '',
		]);
		
		return $return_value;
	}
}
