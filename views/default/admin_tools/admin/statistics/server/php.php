<?php 
	$error_log_lines = implode('<hr />', admin_tools_read_file($php_log, 15));
?>

<script type="text/javascript">
	$(function() {
		$('.admin_tools_show_php_info').click(function() {
			$('.admin_tools_php_info').toggle();
		});	
		$('.admin_tools_show_error_log').click(function() {
			$('.admin_tools_error_log').toggle();
		});	
	});	
</script>
<table class="elgg-table-alt" style="border-top: 0px;">
	<tr class="even">
		<td><b><?php echo elgg_echo('admin_tools:server:label:php_info'); ?> :</b></td>
		<td>
			<a href="javascript: void(0);" class="admin_tools_show_php_info"><?php echo elgg_echo('admin_tools:server:label:show_php_info'); ?></a>
			<div class="hidden admin_tools_php_info">
				<iframe style="width: 100%; height: 300px;" src="<?php echo elgg_get_site_url(); ?>phpinfo"></iframe>
			</div>
		</td>
	</tr>
	<tr class="odd">
		<td><b><?php echo elgg_echo('admin_tools:server:label:error_log'); ?> :</b></td>
		<td>
			<a href="javascript: void(0);" class="admin_tools_show_error_log"><?php echo elgg_echo('admin_tools:server:label:show_error_log');?></a>
			<div class="hidden admin_tools_error_log" style="font-size: 10px;">
				<?php echo $error_log_lines; ?>
			</div>
		</td>
	</tr>
</table>
