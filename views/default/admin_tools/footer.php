<?php
	global $dbcalls, $START_MICROTIME;
	$num_included_files = count(get_included_files());
	$max_mem = number_format(memory_get_peak_usage(true), 0, ",", ".");
	$time = number_format(microtime(true) - $START_MICROTIME, 5, ",", ".");
	
?>
<div id="admin_tools_stats_box">
	<table>
		<tr>
			<td><?php echo elgg_echo('admin_tools:overview:php_servertime');?>: </td>
			<td><?php echo $time; ?></td>
		</tr>
		<tr>
			<td><?php echo elgg_echo('admin_tools:overview:db_calls');?>: </td>
			<td><?php echo $dbcalls; ?></td>
		</tr>
		<tr>
			<td><?php echo elgg_echo('admin_tools:overview:included_files');?>: </td>
			<td><?php echo $num_included_files; ?></td>
		</tr>
		<tr>
			<td><?php echo elgg_echo('admin_tools:overview:max_memory_used');?>: </td>
			<td><?php echo $max_mem; ?> bytes</td>
		</tr>
	</table>
</div>