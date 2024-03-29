<?php

namespace ColdTrick\AdminTools\Menus;

use Elgg\Menu\MenuItems;

/**
 * Add menu items to the admin header menu
 */
class AdminHeader {
	
	/**
	 * Register menu items
	 *
	 * @param \Elgg\Event $event 'register', 'menu:admin_header'
	 *
	 * @return MenuItems|null
	 */
	public static function register(\Elgg\Event $event): ?MenuItems {
		if (!elgg_in_context('admin')) {
			return null;
		}
		
		/* @var $result MenuItems */
		$result = $event->getValue();
		
		$result[] = \ElggMenuItem::factory([
			'name' => 'administer_utilities:change_text',
			'text' => elgg_echo('admin:administer_utilities:change_text'),
			'href' => 'admin/administer_utilities/change_text',
			'parent_name' => 'utilities',
		]);
		
		if (elgg_get_plugin_setting('deadlink_enabled', 'admin_tools') !== 'disabled') {
			$result[] = \ElggMenuItem::factory([
				'name' => 'administer_utilities:deadlinks',
				'text' => elgg_echo('admin:administer_utilities:deadlinks'),
				'href' => 'admin/administer_utilities/deadlinks',
				'parent_name' => 'utilities',
			]);
		}
		
		return $result;
	}
}
