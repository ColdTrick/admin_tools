<?php
/**
 * MySQL PHP info
 */
?>
<script type="text/javascript">
	$(function()
	{
		$('.admin_tools_show_mysql_tables').click(function()
		{
			$('.admin_tools_mysql_tables').toggle();
		});	
	});	
</script>
<style type="text/css">
.admin_tools_count_field {
	width:45px;
	text-align: right; 
}

.admin_tools_right {
	text-align: right; 
}
</style>
<a class="admin_tools_show_mysql_tables" href="javascript: void(0);"><?php echo elgg_echo('admin_tools:server:label:show_table_info'); ?></a><br />
<div class="hidden admin_tools_mysql_tables">
	<table class="elgg-table-alt">
		<thead>
			<tr>
				<th><?php echo elgg_echo('admin_tools:server:label:table_name');?></th>
				<th class="admin_tools_count_field"><?php echo elgg_echo('admin_tools:server:label:record_count');?></th>
				<th class="admin_tools_count_field"><?php echo elgg_echo('admin_tools:server:label:data_size');?></th>
				<th class="admin_tools_count_field"><?php echo elgg_echo('admin_tools:server:label:overhead');?></th>
			</tr>
		</thead>
		<tbody>
	<?php	
		$total_table_size = 0;
		$total_table_overhead = 0;
		$total_table_rows = 0;
		
		foreach(admin_tools_get_db_info() as $table) {
			$total_table_size = ($total_table_size + $table->Data_length);
			$total_table_overhead = ($total_table_overhead + $table->Data_free);
			$total_table_rows = ($total_table_rows + $table->Rows); ?>
			<tr>
				<td><b><?php echo $table->Name; ?></b></td>
				<td class="admin_tools_right"><?php echo number_format($table->Rows, 0, ',', '.'); ?></td>
				<td class="admin_tools_right"><?php echo admin_tools_format_data_size($table->Data_length); ?></td>
				<td class="admin_tools_right"><?php echo admin_tools_format_data_size($table->Data_free); ?></td>
			</tr>
			<?php 
		}
	?>
		</tbody>
		<tfoot>
			<tr>
				<th><?php echo elgg_echo('total'); ?>:</th>
				<th class="admin_tools_right"><?php echo number_format($total_table_rows, 0, ',', '.'); ?></th>
				<th class="admin_tools_right"><?php echo admin_tools_format_data_size($total_table_size);?></th>
				<th class="admin_tools_right"><?php echo admin_tools_format_data_size($total_table_overhead);?></th>
			</tr>
		</tfoot>
	</table> 
</div>