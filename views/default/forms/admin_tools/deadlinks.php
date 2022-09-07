<?php


echo elgg_view_field([
	'#type' => 'select',
	'#label' => elgg_echo('types'),
	'name' => 'types',
	'required' => true,
	'options_values' => elgg_extract('types', $vars),
	'value' => elgg_extract('selected_types', $vars),
]);

echo elgg_view_field([
	'#type' => 'text',
	'#label' => elgg_echo('limit'),
	'name' => 'limit',
	'value' => get_input('limit', 1000),
]);

echo elgg_view_field([
	'#type' => 'text',
	'#label' => elgg_echo('domain'),
	'name' => 'domain',
	'value' => get_input('domain'),
]);

echo elgg_view_field([
	'#type' => 'submit',
	'value' => elgg_echo('search'),
]);
