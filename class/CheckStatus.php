<?php
include_once('FileHandler.php');

$download_path = (new FileHandler())->get_downloads_folder();
$filename = trim($_POST['title']);
$escaped_filename = str_replace("../","",$filename);
$fullpath = $download_path."/".$escaped_filename;

//error_log($fullpath);
if (file_exists($fullpath)) {
	echo "Exists";
} else {
	echo "Doesn't Exist";
}

?>
