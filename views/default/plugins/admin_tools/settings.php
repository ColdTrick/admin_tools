<?php 

	$plugin = $vars["entity"];
	
	$noyes_options = array(
		"no" => elgg_echo("option:no"),
		"yes" => elgg_echo("option:yes")
	);
?>
<script type="text/javascript">
	$(function()
	{
		$('#admin_tools_setting_show').change(function()
		{
			if($(this).val() == 'yes') {
				$('.admin_tools_setting_always_show').show();
			} else {
				$('.admin_tools_setting_always_show').hide();
			}
		});
	});
</script>
<div>
	<?php 
		echo elgg_echo("admin_tools:settings:show");
		echo "&nbsp;" . elgg_view("input/dropdown", array(
			"id" => "admin_tools_setting_show", 
			"name" => "params[show]", 
			"value" => $plugin->show, 
			"options_values" => $noyes_options));
	?>
	<div class="admin_tools_setting_always_show" style="<?php echo (($plugin->show == 'yes')?'':'display: none;'); ?>">
		<?php 
			echo elgg_echo("admin_tools:settings:always_show");
			echo "&nbsp;" . elgg_view("input/dropdown", array(
				"name" => "params[always_show]", 
				"value" => $plugin->always_show, 
				"options_values" => $noyes_options));
		?>
	</div>
</div>