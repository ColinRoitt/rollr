<?php
$url = $_GET['url'];
$file = $_GET['file'];
//
// $current = file_get_contents($file);
// $current .= $name . ": " . $msg . "\n \n";
file_put_contents($file, $url);



?>
