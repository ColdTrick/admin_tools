<?php

use ColdTrick\AdminTools\Replacement;

$from = get_input('from');
$to = get_input('to');
if (elgg_is_empty($from) || elgg_is_empty($to)) {
	return elgg_error_response(elgg_echo('error:missing_data'));
}

$replacement = new Replacement($from, $to);

$rows_affected = $replacement->run();

return elgg_ok_response('', elgg_echo('admin_tools:action:change_text:success', [$rows_affected]));
