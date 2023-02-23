<?php

namespace ColdTrick\AdminTools;

use Elgg\Menu\MenuItems;

/**
 * Admin related helpers
 */
class Admin {
	
	/**
	 * Listen to the make admin event to unset the toggle admin flag
	 *
	 * @param \Elgg\Event $event 'make_admin' 'user'
	 *
	 * @return void
	 */
	public static function makeAdmin(\Elgg\Event $event): void {
		
		$entity = $event->getObject();
		if (!$entity instanceof \ElggUser) {
			return;
		}
		
		$entity->removePluginSetting('admin_tools', 'switched_admin');
	}
	
	/**
	 * Listen to the remove admin event to unset the toggle admin flag
	 *
	 * @param \Elgg\Event $event 'remove_admin' 'user'
	 *
	 * @return void
	 */
	public static function removeAdmin(\Elgg\Event $event): void {
		
		$entity = $event->getObject();
		if (!$entity instanceof \ElggUser) {
			return;
		}
		
		$entity->removePluginSetting('admin_tools', 'switched_admin');
	}
	
	/**
	 * Add a menu item to the topbar
	 *
	 * @param \Elgg\Event $event 'register', 'menu:topbar'
	 *
	 * @return null|MenuItems
	 */
	public static function registerTopbar(\Elgg\Event $event): ?MenuItems {
		$user = elgg_get_logged_in_user_entity();
		if (empty($user)) {
			return null;
		}
		
		// check if the user is an admin
		if (!admin_tools_is_admin_user($user)) {
			return null;
		}
		
		if ($user->isAdmin()) {
			$text = elgg_echo('admin_tools:switch_to_user');
		} else {
			$text = elgg_echo('admin_tools:switch_to_admin');
		}
		
		/* @var $return_value MenuItems */
		$return_value = $event->getValue();
		
		$return_value[] = \ElggMenuItem::factory([
			'name' => 'switch_admin',
			'icon' => 'refresh',
			'text' => $text,
			'href' => elgg_generate_action_url('admin_tools/toggle_admin', [
				'user_guid' => $user->guid,
			]),
			'section' => 'alt',
			'parent_name' => 'account',
		]);
		
		return $return_value;
	}
}
