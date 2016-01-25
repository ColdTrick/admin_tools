<?php
/**
 * Main plugin file
 */

require_once(dirname(__FILE__) . '/lib/functions.php');

// register default Elgg events
elgg_register_event_handler('init', 'system', 'admin_tools_init');

/**
 * Gets called during system initialization
 *
 * @return void
 */
function admin_tools_init() {
	
	elgg_extend_view('admin/users/admins', 'admin_tools/hidden_admins');
	
	// register events
	elgg_register_event_handler('make_admin', 'user', '\ColdTrick\AdminTools\Admin::makeAdmin');
	elgg_register_event_handler('remove_admin', 'user', '\ColdTrick\AdminTools\Admin::removeAdmin');
	
	// register plugin hooks
	elgg_register_plugin_hook_handler('register', 'menu:topbar', '\ColdTrick\AdminTools\Admin::registerTopbar');
	
	// register actions
	elgg_register_action('admin_tools/toggle_admin', dirname(__FILE__) . '/actions/toggle_admin.php');
}
