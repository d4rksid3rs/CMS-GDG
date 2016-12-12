<?php
$type = $_REQUEST["type"];
$msg = $_REQUEST["message"];
$username = $_REQUEST["username"];
require('socket1.php');
$service = 63770;
$input = "{\"type\":$type,\"username\":\"" . $username . "\",\"message\":\"".$msg."\"}";
//echo $input;
echo sendMessage($service, $input);
echo sendMessage1($service, $input);
?>
