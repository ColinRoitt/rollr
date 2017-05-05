<?php
$die = $_GET['die'];
$file = $_GET['file'];
//
// $current = file_get_contents($file);
// $current .= $name . ": " . $msg . "\n \n";
file_put_contents($file, $die);



?>
