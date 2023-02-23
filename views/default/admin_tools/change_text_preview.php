<?php

use ColdTrick\AdminTools\Replacement;

$from = elgg_extract('from', $vars);
$to = elgg_extract('to', $vars);

$replacement = new Replacement($from, $to);

// stats
$title = elgg_echo('admin_tools:change_text:preview', [$from]) . ':';

// metadata
$md_count = $replacement->getMetadataCount();
$md_url = '&nbsp;';
$md_url_extended = '&nbsp;';
if ($md_count > 0) {
	$md_url = elgg_view('output/url', [
		'text' => elgg_echo('export'),
		'icon' => 'download',
		'href' => elgg_generate_action_url('admin_tools/change_text/export', [
			'from' => $from,
			'type' => 'metadata',
		]),
	]);
	$md_url_extended = elgg_view('output/url', [
		'text' => elgg_echo('admin_tools:change_text:export:extended'),
		'icon' => 'download',
		'href' => elgg_generate_action_url('admin_tools/change_text/export_extended', [
			'from' => $from,
			'type' => 'metadata',
		]),
	]);
}

// annotations
$an_count = $replacement->getAnnotationsCount();
$an_url = '&nbsp;';
$an_url_extended = '&nbsp;';
if ($an_count > 0) {
	$an_url = elgg_view('output/url', [
		'text' => elgg_echo('export'),
		'icon' => 'download',
		'href' => elgg_generate_action_url('admin_tools/change_text/export', [
			'from' => $from,
			'type' => 'annotations',
		]),
	]);
	$an_url_extended = elgg_view('output/url', [
		'text' => elgg_echo('admin_tools:change_text:export:extended'),
		'icon' => 'download',
		'href' => elgg_generate_action_url('admin_tools/change_text/export_extended', [
			'from' => $from,
			'type' => 'annotations',
		]),
	]);
}


$table = '<table class="elgg-table">';
$table .= "<tr><th>Metadata</th><td class='center'>{$md_count}</td><td class='center'>{$md_url}</td><td class='center'>{$md_url_extended}</td></tr>";
$table .= "<tr><th>Annotations</th><td class='center'>{$an_count}</td><td class='center'>{$an_url}</td><td class='center'>{$an_url_extended}</td></tr>";
$table .= '</table>';

$table .= elgg_view('output/longtext', [
	'value' => elgg_echo('admin_tools:change_text:export'),
	'class' => 'elgg-subtext',
]);

echo elgg_view_module('info', $title, $table);

echo elgg_view_field([
	'#type' => 'submit',
	'value' => elgg_echo('admin_tools:change_text:execute'),
	'data-confirm' => elgg_echo('question:areyousure'),
]);
