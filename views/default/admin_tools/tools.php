<?php 
	
	$plugins = elgg_get_plugins('all');
	
	$plugin_options = array();
	foreach($plugins as $plugin) {
		if($plugin->isActive()){
			$class = "plugin_active";
		} else {
			$class = "plugin_inactive";
		}
		
		$plugin_options[$plugin->title] = "<option class='" . $class . "' value='" . $plugin->title . "'>" . $plugin->title . "</option>";
	}
	
	ksort($plugin_options);
	
	$options = "";
	foreach($plugin_options as $option) {
		$options .= $option;
	}

?>
<div id="admin_tools_toggle_tools">
	<div id="admin_tools_info_container">
		<?php if(elgg_is_admin_logged_in()){ ?>
		<div id="admin_tools_plugins">
			<form action="<?php echo elgg_get_site_url(); ?>action/admin_tools/plugin_action" method="post">
				<?php echo elgg_view("input/securitytoken"); ?>
				Plugins
				<select name="plugin">
					<?php echo $options;?>
				</select> 
				
				<input type="submit" name="plugin_action" value="<?php echo elgg_echo("enable"); ?>" />
				<input type="submit" name="plugin_action" value="<?php echo elgg_echo("disable"); ?>" />
				<input type="submit" name="plugin_action" value="<?php echo elgg_echo("export"); ?>" />
			</form>		
		</div>
		<?php } ?>
		<div>
			<table>
				<tr><td><?php echo elgg_echo('admin_tools:overview:context');?></td><td><?php echo elgg_get_context();?></td></tr>
				<tr><td><?php echo elgg_echo('admin_tools:overview:pageowner');?></td><td><?php echo elgg_get_page_owner_entity()->name;?></td></tr>
				<tr><td><?php echo elgg_echo('admin_tools:overview:pageownerid');?></td><td><?php echo elgg_get_page_owner_guid();?></td></tr>
				<tr><td><?php echo elgg_echo('admin_tools:overview:userid');?></td><td><?php echo elgg_get_logged_in_user_guid();?></td></tr>
			</table>
		</div>	
		<div>
			<a href="<?php echo elgg_add_action_tokens_to_url(elgg_get_site_url() . "action/admin_tools/switch_admin"); ?>"><?php echo elgg_echo('admin_tools:overview:switch');?></a>
		</div>
	</div>
	<a href="javascript:void(0);">+</a>
</div>