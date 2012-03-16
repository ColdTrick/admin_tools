<?php
	
	// Make sure action is secure
	admin_gatekeeper();
		
	global $CONFIG;
	
	$plugin_name = get_input('plugin');
	$plugin_action = get_input('plugin_action');
	if(!empty($plugin_name))
	{
		switch($plugin_action)
		{
			case elgg_echo("enable"):
				if (($plugin = elgg_get_plugin_from_id($plugin_name)) && $plugin->activate())
				{
					system_message(sprintf(elgg_echo('admin:plugins:enable:yes'), $plugin_name));
				} 
				else
				{
					register_error(sprintf(elgg_echo('admin:plugins:enable:no'), $plugin_name));
				}
				break;
			case elgg_echo("disable"):
				if (($plugin = elgg_get_plugin_from_id($plugin_name)) && $plugin->deactivate())
				{
					system_message(sprintf(elgg_echo('admin:plugins:disable:yes'), $plugin_name));
				}
				else
				{
					register_error(sprintf(elgg_echo('admin:plugins:disable:no'), $plugin_name));
				}
				break;
			case elgg_echo("export"):
				$plugin = elgg_get_plugin_from_id($plugin_name);
				if($manifest = $plugin->getManifest())
				{
					$postfix = "_v" . $manifest->getVersion();
				} 
				$plugin_folder = $CONFIG->pluginspath . $plugin_name . "/";
				
				if($plugin_name && file_exists($plugin_folder)){
					
					$filename = $plugin_name . $postfix . ".zip";
					
					$destination = tempnam($CONFIG->dataroot, "EXPORT");
					
					$zip = new ZipArchive();
					$res = $zip->open($destination, ZipArchive::CREATE);
					
					if ($res === TRUE) {
						admin_tools_add_folder_to_zip($plugin_folder, $zip, $plugin_name . "/");
						$zip->close();
						
						$zipData = file_get_contents($destination);
						
						unlink($destination); // remove file
						
						header('Content-type: application/zip');
						header('Content-Disposition: filename="' . $filename . '"');
			
						echo $zipData;
						exit();
					} else {   
						register_error(elgg_echo('admin_tools:plugin_action:export:error'));		
					}
				} else {
					register_error(elgg_echo('admin_tools:plugin_action:export:noplugin'));		
				}
				break;				
		} 
	}
	forward(REFERER);
	