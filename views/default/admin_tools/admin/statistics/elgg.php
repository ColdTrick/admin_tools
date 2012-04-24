<?php
	global $CONFIG;
?>
<table class="elgg-table-alt">
	<tr>
		<td><strong><?php echo elgg_echo('admin_tools:server:label:db_user'); ?>: </strong></td>
		<td><?php echo $CONFIG->dbuser; ?></td>
	</tr>
	<tr>
		<td><strong><?php echo elgg_echo('admin_tools:server:label:db_pass'); ?>: </strong></td>
		<td><span title="<?php echo $CONFIG->dbpass; ?>">********</span></td>
	</tr>
	<tr>
		<td><strong><?php echo elgg_echo('admin_tools:server:label:db_name'); ?>: </strong></td>
		<td><?php echo $CONFIG->dbname; ?></td>
	</tr>
	<tr>
		<td><strong><?php echo elgg_echo('admin_tools:server:label:db_host'); ?>: </strong></td>
		<td><?php echo $CONFIG->dbhost; ?></td>
	</tr>
	<tr>
		<td><strong><?php echo elgg_echo('admin_tools:server:label:db_prefix'); ?>: </strong></td>
		<td><?php echo $CONFIG->dbprefix; ?></td>
	</tr>
	<tr>
		<td><strong><?php echo elgg_echo('admin_tools:server:label:broken_mta'); ?>: </strong></td>
		<td><?php echo elgg_echo('admin_tools:server:label:' . (($CONFIG->broken_mta)?'enabled':'disabled')); ?></td>
	</tr>
	<tr>
		<td><strong><?php echo elgg_echo('admin_tools:server:label:query_cache'); ?>: </strong></td>
		<td><?php echo elgg_echo('admin_tools:server:label:' . (($CONFIG->db_disable_query_cache)?'enabled':'disabled')); ?></td>
	</tr>
	<tr>
		<td><strong><?php echo elgg_echo('admin_tools:server:label:min_pass_lng'); ?>: </strong></td>
		<td><?php echo $CONFIG->min_password_length; ?></td>
	</tr>
</table>