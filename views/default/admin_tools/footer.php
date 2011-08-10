<?php
	global $dbcalls, $START_MICROTIME;
	$num_included_files = count(get_included_files());
	
?>
<div id="admin_tools_stats_box">
	<table>
		<tr>
			<td>PHP servertime: </td>
			<td><?php echo (microtime(true) - $START_MICROTIME); ?></td>
		</tr>
		<tr>
			<td>DB calls: </td>
			<td><?php echo $dbcalls; ?></td>
		</tr>
		<tr>
			<td>included files: </td>
			<td><?php echo $num_included_files; ?></td>
		</tr>
	</table>
</div>