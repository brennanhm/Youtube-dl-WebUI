<?php

$url = $_POST['url'];
$cmd = "youtube-dl";
$cmd .= " ".escapeshellarg($url);
$cmd .= " --get-thumbnail"; // get video thumbnail

print shell_exec($cmd);

?>
