<link rel="stylesheet" type="text/css" href="css/homeStyle.css" />
<?php
$dir = "images";
	if (is_dir($dir)) {
	    if ($dh = opendir($dir)) {
	        while (($file = readdir($dh)) !== false) {
	            if($file == '.' || $file == '..' || $file == 'Thumbs.db' || $file == 'desktop.ini'){ echo""; }
	            else {
	                echo "<img src=".$dir.'/'.$file." />";  
	            }
	        }
	        closedir($dh);
	    }
	} else {
		echo "No directory called images";
	}
?>
