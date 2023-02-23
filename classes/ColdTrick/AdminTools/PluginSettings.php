<?php

namespace ColdTrick\AdminTools;

/**
 * Modify plugin settings
 */
class PluginSettings {
	
	/**
	 * Change the value of some plugin settings before saving
	 *
	 * @param \Elgg\Event $event 'setting', 'plugin'
	 *
	 * @return null|string
	 */
	public static function save(\Elgg\Event $event): ?string {
		if ($event->getParam('plugin_id') !== 'admin_tools') {
			return null;
		}
		
		$value = $event->getValue();
		if (is_array($value)) {
			return json_encode($value);
		}
		
		return null;
	}
}
