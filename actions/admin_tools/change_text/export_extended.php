<?php

use ColdTrick\AdminTools\Replacement;

$from = get_input('from');
$table = get_input('type');

if (empty($from) || empty($table)) {
	return elgg_error_response(elgg_echo('error:missing_data'));
}

$replacement = new Replacement($from, 'dummy');
$results = false;
switch ($table) {
	case 'metadata':
	case 'annotations':
		$results = $replacement->getExportResults($table);
		break;
	default:
		return elgg_error_response(elgg_echo('error:missing_data'));
}

// may take a while
set_time_limit(0);

// use temp file for correct CSV formatting
$file = elgg_get_temp_file();
$fh = $file->open('write');

// header row
fputcsv($fh, [
	'GUID',
	'Type',
	'Subtype',
	'URL',
	'Owner name',
	'Owner URL',
	'Owner e-mail',
	'ID',
	'Name',
	'Value',
], ';', '"', '\\');

_elgg_services()->queryCache->disable();

// contents
foreach ($results as $row) {
	$entity = get_entity($row->entity_guid);
	
	$entity_url = '';
	$owner = false;
	if ($entity instanceof \ElggEntity) {
		$entity_url = $entity->getURL();
		$owner = $entity->getOwnerEntity();
	}
	
	fputcsv($fh, [
		(int) $row->entity_guid,
		$row->type,
		$row->subtype,
		$entity_url,
		$owner ? $owner->getDisplayName() : '',
		$owner ? $owner->getURL() : '',
		$owner ? $owner->email : '',
		(int) $row->id,
		$row->name,
		$row->value,
	], ';', '"', '\\');
}

$file->close();

// download
$contents = $file->grabFile();
$file->delete();

header('Content-Type: text/csv');
header('Content-Disposition: Attachment; filename="' . $table . '-extended.csv"');
header('Content-Length: ' . strlen($contents));
header('Pragma: public');

echo $contents;

exit();
