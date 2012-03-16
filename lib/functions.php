<?php 

	function admin_tools_add_folder_to_zip($dir, $zipArchive, $zipdir = '') {
		static $ignored_files;

		if(!isset($ignored_files)) {
			$ignored_files = array("..", ".", ".settings", ".git", ".gitignore", ".project", ".buildpath", ".svn");
		}

		if (is_dir($dir)) {
			if ($dh = opendir($dir)) {
				while (($file = readdir($dh)) !== false) {
					if(!in_array($file, $ignored_files)) {
						if(!is_file($dir . $file)) {
							admin_tools_add_folder_to_zip($dir . $file . "/", $zipArchive, $zipdir . $file . "/");
						} else {
							$zipArchive->addFile($dir . $file, $zipdir . $file);
						}
					}
				}
			}
		}
	}