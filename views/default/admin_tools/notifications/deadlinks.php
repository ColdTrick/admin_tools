<?php
/**
 * Add a notification setting for admins on the notification settings page
 *
 * @uses $vars['entity'] the user for which to set the settings
 */

$user = elgg_extract('entity', $vars);
if (!$user instanceof \ElggUser || !$user->isAdmin()) {
	return;
}

$params = $vars;
$params['description'] = elgg_echo('admin_tools:notification:deadlinks:setting');
$params['purpose'] = 'admin_tools:deadlinks';

echo elgg_view('notifications/settings/record', $params);
