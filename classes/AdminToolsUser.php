<?php

/**
 * Special user class for additional features
 */
class AdminToolsUser extends \ElggUser {
	
	/**
	 * {@inheritdoc}
	 */
	public function isAdmin(): bool {
		$switched = elgg_call(ELGG_IGNORE_ACCESS, function() {
			return !empty($this->getPluginSetting('admin_tools', 'switched_admin'));
		});
		
		if (!\Elgg\Application::isCli() && $switched) {
			return false;
		}
		
		return parent::isAdmin();
	}
}
