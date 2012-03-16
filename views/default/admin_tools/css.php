<?php 
	$always = false;
	if(elgg_get_plugin_setting("always_show", "admin_tools") == "yes"){
		$always = true;
	}
?>
#admin_tools_toggle_tools {
	position: fixed;
	right: 0px;
	bottom: 0px;
	text-align: right;
}

#admin_tools_toggle_tools > a{
	color: white;
	font-size: 16px;
	background: black;
	font-weight: bold;
	text-decoration: none;
	padding: 2px;
}

<?php if(!$always) { ?>
#admin_tools_toggle_tools:hover #admin_tools_info_container {
	display: block;
}

#admin_tools_info_container {
	display: none;
}
<?php } ?>
	
#admin_tools_info_container {
	color: white;
	background: black;
	padding: 5px;
	width: 150px;
}

#admin_tools_info_container a {
	color: green;
}

#admin_tools_plugins {
	text-align: left;
	margin: 0 0 2px;
	padding: 0 0 5px;
	border-bottom: 1px dotted white;
}

#admin_tools_plugins select{
	width: 100%;
}

#admin_tools_plugins input[type="submit"] {
	font-size: 11px;
    height: 17px;
    margin: 0;
    padding: 0;
}

.plugin_active {
	color:green;
}

.plugin_inactive {
	color:red;
}

#admin_tools_stats_box {
	width: 250px;
	border: 1px solid black;
	position: fixed;
	top: 50%;
	right: 5px;
	padding: 5px;
	background-color: #FFFFFF;
}

#admin_tools_stats_box table {
	width: 100%;
}