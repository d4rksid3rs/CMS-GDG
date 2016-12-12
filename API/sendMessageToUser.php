<?php
$username = $_GET["username"];
$msg = $_GET["message"];
require('socket.php');
//$service = 0xF905;
$service = 63764;
$input = "{\"username\":\"" . $username . "\",\"message\":\"".$msg."\"}";
echo sendMessage($service, $input);
echo sendMessage1($service, $input);

?>
