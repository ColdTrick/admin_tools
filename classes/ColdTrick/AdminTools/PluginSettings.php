<?php

namespace ColdTrick\AdminTools;

class PluginSettings {
	
	/**
	 * Change the value of some plugin settings before saving
	 *
	 * @param \Elgg\Hook $hook 'setting', 'plugin'
	 *
	 * @return null|string
	 */
	public static function save(\Elgg\Hook $hook): ?string {
		if ($hook->getParam('plugin_id') !== 'admin_tools') {
			return null;
		}
		
		$value = $hook->getValue();
		if (is_array($value)) {
			return json_encode($value);
		}
		
		return null;
	}
}
