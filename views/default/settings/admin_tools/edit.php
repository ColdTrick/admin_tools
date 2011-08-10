<?php 

	$plugin = $vars["entity"];
	
	$noyes_options = array(
		"no" => elgg_echo("option:no"),
		"yes" => elgg_echo("option:yes")
	);

	echo "<div>";
	echo elgg_echo("admin_tools:settings:always_show");
	echo "&nbsp;" . elgg_view("input/pulldown", array("internalname" => "params[always_show]", "value" => $plugin->always_show, "options_values" => $noyes_options));
	echo "</div>";


?>