<?php
require('socket1.php');
$service = 0xF90C;
$input = "{}";
echo sendMessage($service, $input);
echo "<br>";
echo sendMessage1($service, $input);
?>
