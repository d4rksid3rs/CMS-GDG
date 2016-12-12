<?php
$username = $_GET["username"];

require('socket1.php');
$service = 0xF904;
$input = "{\"username\":\"" . $username . "\"}";

echo sendMessage($service, $input);
echo sendMessage1($service, $input);
?>
