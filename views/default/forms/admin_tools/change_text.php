<?php

elgg_require_js('admin/administer_utilities/change_text');

echo elgg_view_field([
	'#type' => 'fieldset',
	'align' => 'horizontal',
	'fields' => [
		[
			'#html' => elgg_format_element('span', [
				'class' => 'mrl',
			], elgg_echo('admin_tools:change_text:change')),
		],
		[
			'#type' => 'text',
			'name' => 'from',
			'required' => true,
		],
		[
			'#html' => elgg_format_element('span', [
				'class' => 'mrl',
			], elgg_echo('admin_tools:change_text:into')),
		],
		[
			'#type' => 'text',
			'#class' => 'mlm',
			'name' => 'to',
			'required' => true,
		],
		[
			'#type' => 'button',
			'text' => elgg_echo('preview'),
			'id' => 'change-text-preview-button',
		],
	],
]);

echo elgg_format_element('div', [
	'id' => 'change-text-preview',
]);
