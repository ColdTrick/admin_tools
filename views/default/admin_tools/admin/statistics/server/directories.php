<?php
	global $CONFIG;
	
	$dataroot = substr(sprintf('%o', fileperms($CONFIG->dataroot)), -4);
	$wwwroot = substr(sprintf('%o', fileperms($CONFIG->path)), -4);
	$settings = substr(sprintf('%o', fileperms($CONFIG->path . 'engine/settings.php')), -4);
	$install = substr(sprintf('%o', fileperms($CONFIG->path . 'install.php')), -4);
	$start = substr(sprintf('%o', fileperms($CONFIG->path . 'engine/start.php')), -4);
?>
<style type="text/css">
.elgg-table-alt td:first-child {
    width: 300px !important;
}
</style>
<table class="elgg-table-alt" width="400">
	<tr class="even">
		<td><b>Dataroot :</b> <br />(<?php echo $CONFIG->dataroot; ?>)</td>
		<td><span style="background-color:<?php echo (((int)$dataroot <= 755)?'green':'red');?>;"><?php echo $dataroot	; ?></span></td>
	</tr>
	<tr>
		<td><b>WWWRoot :</b> <br />(<?php echo $CONFIG->path; ?>)</td>
		<td><span style="background-color:<?php echo (((int)$wwwroot <= 755)?'green':'red');?>;"><?php echo $wwwroot; ?></span></td>
	</tr>
	<tr>
		<td><b>Settings.php :</b> <br />(<?php echo $CONFIG->path . 'engine/settings.php'; ?>)</td>
		<td><span style="background-color:<?php echo (((int)$settings <= 644)?'green':'red');?>;"><?php echo $settings; ?></span></td>
	</tr>
	<tr>
		<td><b>Install.php :</b> <br />(<?php echo $CONFIG->path . 'install.php'; ?>)</td>
		<td><span style="background-color:<?php echo (((int)$install <= 644)?'green':'red');?>;"><?php echo $install; ?></span></td>
	</tr>
	<tr>
		<td><b>Start.php :</b> <br />(<?php echo $CONFIG->path . 'engine/start.php'; ?>)</td>
		<td><span style="background-color:<?php echo (((int)$start <= 644)?'green':'red');?>;"><?php echo $start; ?></span></td>
	</tr>
</table>