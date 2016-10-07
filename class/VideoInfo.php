<?php

$url = $_GET['url'];

/* Get video title */
$cmd = "youtube-dl";
$cmd .= " -f mp4 "; // To get proper title
$cmd .= " ".escapeshellarg($url);
$cmd .= " --get-title ";

$result = shell_exec($cmd);
$videotitle = str_replace("\n", '', $result);

/* Get video thumbnail */
$cmd = "youtube-dl";
$cmd .= " ".escapeshellarg($url);
$cmd .= " --get-thumbnail";

$result = shell_exec($cmd);
$videothumb = str_replace("\n", '', $result);

/* Get available formats */
$cmd = "youtube-dl";
$cmd .= " ".escapeshellarg($url);
$cmd .= " -F"; // Get formats option

$result = shell_exec($cmd);

//error_log($result);
preg_match_all("#\b(3gp|aac|flv|m4a|mp4|ogg|webm)\b#", $result, $matches); // Find any instances of the file extensions and add them to the 'matches' array
$formats = array_unique($matches[0], SORT_REGULAR); // preg_match_all returns an array for each submatch, so only take values from the first array
//error_log( print_r($formats, true) );

// Enter results into an array
$data = array();
$data["vidinfo"] = array($videotitle, $videothumb);
$data["vidformats"] = $formats;

/* Return JSON encoded array */
echo json_encode($data);

?>
