<?php
include_once('FileHandler.php');

$download_path = (new FileHandler())->get_downloads_folder();
$url = $_GET['url'];
$format = $_GET['format'];
$message = "URL: ".$url." Format: ".$format;
error_log($message);

/* Get video filename */
$cmd = "youtube-dl";
$cmd .= " -o ";
if ($format === "mp3") { // If format is mp3, manually add .mp3 extension
	$cmd .= escapeshellarg("%(title)s-%(uploader)s.mp3");
	$cmd .= " -x --audio-format mp3";
} else {
	$cmd .= escapeshellarg("%(title)s-%(uploader)s.%(ext)s");
	$cmd .= " -f ".escapeshellarg($format);
}
$cmd .= " ".escapeshellarg($url);
$cmd .= " --restrict-filenames"; 
$cmd .= " --get-filename "; // get video filename

error_log($cmd);
$filename = shell_exec($cmd);
error_log($filename);
$escaped_filename = str_replace("\n", '', $filename); // Remove newline characters
if ($format === "mp3") {
	$escaped_filename = substr_replace($escaped_filename, "mp3", -3);
}
error_log($escaped_filename);
$fullpath = $download_path."/".$escaped_filename; // Combine download path and filename to get full path

error_log($fullpath);

if (file_exists($fullpath)) {
	echo json_encode(array("exists" => "yes", "filename" => $escaped_filename));
} else {
	echo json_encode(array("exists" => "no", "filename" => $escaped_filename));
}

?>
