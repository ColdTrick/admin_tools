<?php

namespace ColdTrick\AdminTools;

class Admin {
	
	/**
	 * Listen to the make admin event to unset the toggle admin flag
	 *
	 * @param \Elgg\Event $event 'make_admin' 'user'
	 *
	 * @return void
	 */
	public static function makeAdmin(\Elgg\Event $event) {
		
		$entity = $event->getObject();
		if (!($entity instanceof \ElggUser)) {
			return;
		}
		
		elgg_unset_plugin_user_setting('switched_admin', $entity->guid, 'admin_tools');
	}
	
	/**
	 * Listen to the remove admin event to unset the toggle admin flag
	 *
	 * @param \Elgg\Event $event 'remove_admin' 'user'
	 *
	 * @return void
	 */
	public static function removeAdmin(\Elgg\Event $event) {
		
		$entity = $event->getObject();
		if (!($entity instanceof \ElggUser)) {
			return;
		}
		
		elgg_unset_plugin_user_setting('switched_admin', $entity->guid, 'admin_tools');
	}
	
	/**
	 * Add a menu item to the topbar
	 *
	 * @param \Elgg\Hook $hook 'register', 'menu:topbar'
	 *
	 * @return void|\ElggMenuItem[]
	 */
	public static function registerTopbar(\Elgg\Hook $hook) {
		
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
		
		$return_value = $hook->getValue();
		
		$return_value[] = \ElggMenuItem::factory([
			'name' => 'switch_admin',
			'text' => $text,
			'icon' => 'refresh',
			'href' => elgg_http_add_url_query_elements('action/admin_tools/toggle_admin', [
				'user_guid' => $user->guid,
			]),
			'is_action' => true,
			'is_trusted' => true,
			'section' => 'alt',
			'parent_name' => 'account',
		]);
		
		return $return_value;
	}
}
