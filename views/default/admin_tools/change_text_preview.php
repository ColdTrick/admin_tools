<?php

use ColdTrick\AdminTools\Replacement;

$from = elgg_extract('from', $vars);
$to = elgg_extract('to', $vars);

$replacement = new Replacement($from, $to);

// stats

$title = elgg_echo('admin_tools:change_text:preview', [$from]) . ':';

$table = '<table class="elgg-table">';
$table .= "<tr><th>Metadata</th><td>{$replacement->getMetadataCount()}</td></tr>";
$table .= "<tr><th>Private Settings</th><td>{$replacement->getPrivateSettingsCount()}</td></tr>";
$table .= "<tr><th>Annotations</th><td>{$replacement->getAnnotationsCount()}</td></tr>";
$table .= '</table>';

echo elgg_view_module('info', $title, $table);

echo elgg_view_field([
	'#type' => 'submit',
	'value' => elgg_echo('admin_tools:change_text:execute'),
	'data-confirm' => elgg_echo('question:areyousure'),
]);
