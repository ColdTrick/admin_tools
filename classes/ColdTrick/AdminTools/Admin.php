<?php

namespace ColdTrick\AdminTools;

/**
 * Admin related helpers
 */
class Admin {
	
	/**
	 * Listen to the make/remove admin event to unset the toggle admin flag
	 *
	 * @param \Elgg\Event $event 'make_admin|remove_admin' 'user'
	 *
	 * @return void
	 */
	public static function removeTempUserSwitch(\Elgg\Event $event): void {
		$entity = $event->getObject();
		if (!$entity instanceof \ElggUser) {
			return;
		}
		
		$entity->removePluginSetting('admin_tools', 'switched_admin');
	}
}
