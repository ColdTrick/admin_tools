<?php

/**
 * Special user class for additional features
 */
class AdminToolsUser extends \ElggUser {
	
	/**
	 * {@inheritdoc}
	 */
	public function isAdmin(): bool {
		if (!\Elgg\Application::isCli() && !empty($this->getPluginSetting('admin_tools', 'switched_admin'))) {
			return false;
		}
		
		return parent::isAdmin();
	}
}
