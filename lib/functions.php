<?php

	function admin_tools_put_action_error_message($message = '', $action, $errrono) {
		if($message) {
			$_SESSION['admin_tools']['action_errors'][$action][$message] = array('message' => $message, 'errorno' => $errrono);
		}
	}

	function admin_tools_get_action_error_messages() {
		if(isset($_SESSION['admin_tools'])) {		
			foreach($_SESSION['admin_tools']['action_errors'] as $action => $error_message) {
				elgg_dump('<strong>Page URI: '.$action.'</strong>', true);

				foreach($error_message as $message) {
					elgg_dump($message['message'], true, $message['errorno']);
				}

				elgg_dump('----------------------------', true);
			}

			unset($_SESSION['admin_tools']);
		}
	}

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
		$result = false;

		try {
			$data = get_data("SHOW TABLE STATUS FROM " . elgg_get_config("dbname"));

			 if (!empty($data)) {
			 	$result = $data;
			 }
		} catch (DatabaseException $d) {}
		
		return $result;
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