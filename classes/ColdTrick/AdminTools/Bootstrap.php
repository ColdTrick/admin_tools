<?php

namespace ColdTrick\AdminTools;

use Elgg\DefaultPluginBootstrap;

class Bootstrap extends DefaultPluginBootstrap {
	
	/**
	 * {@inheritDoc}
	 */
	public function init() {
		
		elgg_register_ajax_view('admin_tools/change_text_preview');
		
		elgg_extend_view('admin/users/admins', 'admin_tools/hidden_admins');
	
		// register events
		elgg_register_event_handler('make_admin', 'user', '\ColdTrick\AdminTools\Admin::makeAdmin');
		elgg_register_event_handler('remove_admin', 'user', '\ColdTrick\AdminTools\Admin::removeAdmin');
		
		// register plugin hooks
		elgg_register_plugin_hook_handler('register', 'menu:topbar', '\ColdTrick\AdminTools\Admin::registerTopbar');
		elgg_register_plugin_hook_handler('commands', 'cli', '\ColdTrick\AdminTools\CLI::registerCommand');
		
		elgg_register_menu_item('page', [
			'name' => 'administer_utilities:change_text',
			'text' => elgg_echo('admin:administer_utilities:change_text'),
			'href' => 'admin/administer_utilities/change_text',
			'context' => 'admin',
			'parent_name' => 'administer_utilities',
			'section' => 'administer',
		]);
	}
}
