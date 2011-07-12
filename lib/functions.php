<?php 

	// Function to recursively add a directory,
	// sub-directories and files to a zip archive
	function admin_tools_add_folder_to_zip($dir, $zipArchive, $zipdir = ''){
		
		static $ignored_files;
		
		if(!isset($ignored_files)){
			$ignored_files = array("..", ".", ".settings", ".git", ".gitignore", ".project", ".buildpath", ".svn");
		}
		
		if (is_dir($dir)) {
			if ($dh = opendir($dir)) {

				// Loop through all the files
				while (($file = readdir($dh)) !== false) {
					
					// check if we need to ignore the file
					if(!in_array($file, $ignored_files)){
						
						if(!is_file($dir . $file)){
							// If it's a folder, run the function again!
							admin_tools_add_folder_to_zip($dir . $file . "/", $zipArchive, $zipdir . $file . "/");
						} else {
							// Add the files
							$zipArchive->addFile($dir . $file, $zipdir . $file);
						}
					}
				}
			}
		}
	}

?>