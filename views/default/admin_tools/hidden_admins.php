<?php
/**
 * Show a list of the admin's who switched to normal user
 */

$list = elgg_list_entities([
	'type' => 'user',
	'limit' => false,
	'metadata_names' => 'plugin:user_setting:admin_tools:switched_admin',
	'pagination' => false,
	'no_results' => elgg_echo('admin_tools:switched_admins:none'),
]);

echo elgg_view_module('info', elgg_echo('admin_tools:switched_admins:title'), $list);
