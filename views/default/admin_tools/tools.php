<?php 
	
	$plugins = get_installed_plugins();
	ksort($plugins);
	foreach($plugins as $pluginname => $plugindata){
		if($plugindata['active'] == 1){
			$class = "plugin_active";
		} else {
			$class = "plugin_inactive";
		}
		$options .= "<option class='" . $class . "' value='" . $pluginname . "'>" . $pluginname . "</option>";
	}

?>

<div id="admin_tools_toggle_tools">
	<div id="admin_tools_info_container">
		<?php if(isadminloggedin()){ ?>
		<div id="admin_tools_plugins">
			
			<form action="<?php echo $vars["url"]; ?>action/admin_tools/plugin_action" method="post">
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
				<tr><td>Context</td><td><?php echo get_context();?></td></tr>
				<tr><td>PageOwner</td><td><?php echo page_owner_entity()->name;?></td></tr>
				<tr><td>PageOwnerId</td><td><?php echo page_owner();?></td></tr>
				<tr><td>UserId</td><td><?php echo get_loggedin_userid();?></td></tr>
			</table>
		</div>	
		<div>
			<a href="<?php echo elgg_add_action_tokens_to_url($vars["url"] . "action/admin_tools/switch_admin"); ?>">Switch</a>
		</div>
	</div>
	<a href="javascript:void(0);">+</a>
</div>