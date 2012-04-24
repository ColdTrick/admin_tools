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
	
	function admin_tools_get_db_info() {
		global $CONFIG;
		
		try {
			$result = get_data("SHOW TABLE STATUS FROM {$CONFIG->dbname}");
			 if (is_array($result) && !empty($result)) {
			 	return $result;
			 }
		} catch (DatabaseException $d) {
			// Likely we can't handle an exception here, so just return false.
			var_dump($d);
			return FALSE;
		}
	}
	
	function admin_tools_format_data_size($size) {
		$bytes = $size;
		$kilo_bytes = 0;
		
		if($bytes == 0) {
			return '-';
		}
		
		if($bytes > 1024) {
			$kilo_bytes = ($bytes/1024);
			$result = number_format($kilo_bytes, 1, ',', '.') . ' KB';
		} else {
			$result = number_format($bytes, 1, ',', '.') . ' B';
		}
		
		if($kilo_bytes > 1024) {
			$mega_bytes = ($bytes/1024);
			$result = number_format($kilo_bytes, 1, ',', '.') . ' MB';
		}
		
		return $result;
	}
	
	function admin_tools_read_file($file, $lines = 10) {
	    //global $fsize;
	    $handle = fopen($file, "r");
	    $linecounter = $lines;
	    $pos = -2;
	    $beginning = false;
	    $text = array();
	    
	    while ($linecounter > 0) {
	        $t = " ";
	        while ($t != "\n") {
	            if(fseek($handle, $pos, SEEK_END) == -1) {
	                $beginning = true;
	                break;
	            }
	            $t = fgetc($handle);
	            $pos --;
	        }
	        $linecounter --;
	        if ($beginning) {
	            rewind($handle);
	        }
	        $text[$lines-$linecounter-1] = fgets($handle);
	        if ($beginning) break;
	    }
	    fclose ($handle);
	    return array_reverse($text);
	}