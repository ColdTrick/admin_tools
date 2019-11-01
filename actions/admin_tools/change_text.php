<?php

use ColdTrick\AdminTools\Replacement;

$from = get_input('from');
$to = get_input('to');

$replacement = new Replacement($from, $to);

$rows_affected = $replacement->run();

return elgg_ok_response('', elgg_echo('admin_tools:action:change_text:success', [$rows_affected]));
