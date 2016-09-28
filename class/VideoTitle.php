<?php

$url = $_POST['url'];
$cmd = "youtube-dl";
$cmd .= " -o ";
$cmd .= escapeshellarg("%(title)s-%(uploader)s.%(ext)s");
$cmd .= " ".escapeshellarg($url);
$cmd .= " --get-filename "; // get video title
$cmd .= "--restrict-filenames "; // prevent special characters

print shell_exec($cmd);

?>
