<?php
/**
 * Show a list of the admin's who switched to normal user
 */

$options = [
	'type' => 'user',
	'limit' => false,
	'plugin_id' => 'admin_tools',
	'plugin_user_setting_name' => 'switched_admin',
	'pagination' => false,
	'no_results' => elgg_echo('admin_tools:switched_admins:none'),
];

$list = elgg_list_entities($options, 'elgg_get_entities_from_plugin_user_settings');

echo elgg_view_module('inline', elgg_echo('admin_tools:switched_admins:title'), $list);
