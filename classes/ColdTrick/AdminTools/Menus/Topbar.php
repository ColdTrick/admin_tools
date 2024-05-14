<?php

namespace ColdTrick\AdminTools\Menus;

use Elgg\Menu\MenuItems;

/**
 * Add menu items to the topbar menu
 */
class Topbar {
	
	/**
	 * Add the switch admin/user topbar menu item
	 *
	 * @param \Elgg\Event $event 'register', 'menu:topbar'
	 *
	 * @return null|MenuItems
	 */
	public static function register(\Elgg\Event $event): ?MenuItems {
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
