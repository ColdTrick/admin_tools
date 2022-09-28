<?php

$directory = get_input('dir');
$filename = get_input('filename');

if (empty($directory) && empty($filename)) {
	return elgg_error_response(elgg_echo('error:missing_data'));
}

$plugin = elgg_get_plugin_from_id('admin_tools');
$file = new \ElggFile();
$file->owner_guid = $plugin->guid;

if (!empty($directory)) {
	$file->setFilename('deadlinks/' . $directory);
} else {
	$file->setFilename('deadlinks/' . $filename);
}

if (!$file->exists()) {
	return elgg_error_response(elgg_echo('admin_tools:action:deadlink:delete:not_exists'));
}

if (!empty($directory) && is_dir($file->getFilenameOnFilestore())) {
	if (elgg_delete_directory($file->getFilenameOnFilestore())) {
		return elgg_ok_response('', elgg_echo('admin_tools:action:deadlink:delete:success:directory', [$directory]));
	}
} elseif (!empty($filename)) {
	if ($file->delete()) {
		return elgg_ok_response('', elgg_echo('admin_tools:action:deadlink:delete:success:file', [$filename]));
	}
}

return elgg_error_response(elgg_echo('admin_tools:action:deadlink:delete:fail'));
