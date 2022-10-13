<?php

use Elgg\Project\Paths;

$plugin = elgg_get_plugin_from_id('admin_tools');
$subdirectory = get_input('dir');
$subdirectory = $subdirectory ? Paths::sanitize($subdirectory) : null;

// add a breadcrumb to navigate back
$breadcrumb = [];
$breadcrumb[] = \ElggMenuItem::factory([
	'name' => 'root',
	'text' => elgg_echo('admin:administer_utilities:deadlinks'),
	'href' => 'admin/administer_utilities/deadlinks',
]);
if (!empty($subdirectory)) {
	$parts = explode('/', trim($subdirectory, '/'));
	$sub = '';
	foreach ($parts as $part) {
		$breadcrumb[] = \ElggMenuItem::factory([
			'name' => $sub . $part,
			'text' => $part,
			'href' => elgg_http_add_url_query_elements('admin/administer_utilities/deadlinks', [
				'dir' => $sub . $part,
			]),
		]);
		
		$sub .= "{$part}/";
	}
}

echo elgg_view_menu('admin_tools:deadlinks', [
	'items' => $breadcrumb,
	'class' => [
		'elgg-menu-hz',
		'elgg-breadcrumbs',
	],
]);

// start listing directories and files
$file = new \ElggFile();
$file->owner_guid = $plugin->guid;
$file->setFilename('deadlinks/dummy.log');

$directory_name = str_ireplace('dummy.log', '', $file->getFilenameOnFilestore());
$directory_name = Paths::sanitize($directory_name . $subdirectory);
if (!is_dir($directory_name)) {
	echo elgg_view('page/components/no_results', [
		'no_results' => true,
	]);
	return;
}

// separate files and directories
$files = [];
$dirs = [];
$dh = new \DirectoryIterator($directory_name);
foreach ($dh as $fileinfo) {
	$filename = $fileinfo->getFilename();
	
	if ($fileinfo->isDot()) {
		continue;
	} elseif ($fileinfo->isDir()) {
		$row = [];
		$row[] = elgg_format_element('td', [], elgg_view_url(elgg_http_add_url_query_elements('admin/administer_utilities/deadlinks', [
			'dir' => Paths::sanitize($subdirectory . $filename),
		]), $filename, [
			'icon' => 'folder',
		]));
		$row[] = elgg_format_element('td', [], date(elgg_echo('friendlytime:date_format'), $fileinfo->getMTime()));
		$row[] = elgg_format_element('td', [], '&nbsp;'); // size
		$row[] = elgg_format_element('td', ['class' => 'center'], elgg_view_url(elgg_generate_action_url('admin_tools/deadlinks/delete', [
			'dir' => $subdirectory . $filename,
		]), false, [
			'icon' => 'delete',
			'title' => elgg_echo('delete'),
			'confirm' => elgg_echo('deleteconfirm'),
		]));
		
		$dirs[$filename] = elgg_format_element('tr', [], implode(PHP_EOL, $row));
	} elseif ($fileinfo->isFile()) {
		// make a download link
		$tmp = new \ElggFile();
		$tmp->owner_guid = $plugin->guid;
		$tmp->setFilename('deadlinks/' . $subdirectory . $filename);
		
		$row = [];
		$row[] = elgg_format_element('td', [], elgg_view_url($tmp->getDownloadURL(), $filename, [
			'icon' => 'file-regular',
		]));
		$row[] = elgg_format_element('td', [], date(elgg_echo('friendlytime:date_format'), $fileinfo->getMTime()));
		$row[] = elgg_format_element('td', [], $fileinfo->getSize() ? elgg_format_bytes($fileinfo->getSize()) : 0);
		$row[] = elgg_format_element('td', ['class' => 'center'], elgg_view_url(elgg_generate_action_url('admin_tools/deadlinks/delete', [
			'filename' => $subdirectory . $filename,
		]), false, [
			'icon' => 'delete',
			'title' => elgg_echo('delete'),
			'confirm' => elgg_echo('deleteconfirm'),
		]));
		
		$files[$filename] = elgg_format_element('tr', [], implode(PHP_EOL, $row));
	}
}

if (empty($files) && empty($dirs)) {
	echo elgg_view('page/components/no_results', [
		'no_results' => true,
	]);
	return;
}

// sort dirs and files
uksort($dirs, 'strnatcasecmp');
uksort($files, 'strnatcasecmp');

$header = [
	elgg_format_element('th', [], elgg_echo('table_columns:fromProperty:name')),
	elgg_format_element('th', [], elgg_echo('table_columns:fromView:time_updated')),
	elgg_format_element('th', [], elgg_echo('admin_tools:deadlinks:size')),
	elgg_format_element('th', ['class' => 'center'], elgg_echo('delete')),
];

$header = elgg_format_element('tr', [], implode(PHP_EOL, $header));
$header = elgg_format_element('thead', [], $header);

echo elgg_format_element('table', ['class' => 'elgg-table-alt'], $header . implode(PHP_EOL, $dirs) . implode(PHP_EOL, $files));
