<?php

/* @var $plugin \ElggPlugin */
$plugin = elgg_extract('entity', $vars);

// deadlink detection settings
$deadlink = elgg_view_field([
	'#type' => 'select',
	'#label' => elgg_echo('admin_tools:settings:deadlink:enabled'),
	'name' => 'params[deadlink_enabled]',
	'value' => $plugin->deadlink_enabled,
	'options_values' => [
		'disabled' => elgg_echo('status:disabled'),
		'daily' => elgg_echo('interval:daily'),
		'weekly' => elgg_echo('interval:weekly'),
		'monthly' => elgg_echo('interval:monthly'),
	],
]);

$deadlink .= elgg_view_field([
	'#type' => 'number',
	'#label' => elgg_echo('admin_tools:settings:deadlink:created_before'),
	'name' => 'params[deadlink_created_before]',
	'value' => $plugin->deadlink_created_before,
	'min' => 0,
]);

$deadlink .= elgg_view_field([
	'#type' => 'number',
	'#label' => elgg_echo('admin_tools:settings:deadlink:rescan'),
	'name' => 'params[deadlink_rescan]',
	'value' => $plugin->deadlink_rescan,
	'min' => 0,
]);

$deadlink .= elgg_view_field([
	'#type' => 'plaintext',
	'#label' => elgg_echo('admin_tools:settings:deadlink:skipped_domains'),
	'#help' => elgg_echo('admin_tools:settings:deadlink:skipped_domains:help'),
	'name' => 'params[deadlink_skipped_domains]',
	'value' => $plugin->deadlink_skipped_domains,
]);

$deadlink .= elgg_view_field([
	'#type' => 'email',
	'#label' => elgg_echo('admin_tools:settings:deadlink:report_email'),
	'#help' => elgg_echo('admin_tools:settings:deadlink:report_email:help'),
	'name' => 'params[deadlink_report_email]',
	'value' => $plugin->deadlink_report_email,
]);

$searchable = elgg_entity_types_with_capability('searchable');
$options = [];
foreach ($searchable as $type => $subtypes) {
	foreach ($subtypes as $subtype) {
		$label = $subtype;
		if (elgg_language_key_exists("collection:{$type}:{$subtype}")) {
			$label = elgg_echo("collection:{$type}:{$subtype}");
		} elseif (elgg_language_key_exists("item:{$type}:{$subtype}")) {
			$label = elgg_echo("item:{$type}:{$subtype}");
		}
		
		$options["{$type}.{$subtype}"] = $label;
	}
}

natcasesort($options);

$deadlink .= elgg_view_field([
	'#type' => 'checkboxes',
	'#label' => elgg_echo('admin_tools:settings:deadlink:type_subtype'),
	'name' => 'params[deadlink_type_subtype]',
	'options_values' => $options,
	'value' => $plugin->deadlink_type_subtype ? json_decode($plugin->deadlink_type_subtype, true) : [],
	'switch' => true,
]);

echo elgg_view_module('info', elgg_echo('admin_tools:settings:deadlink:title'), $deadlink);
