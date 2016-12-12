<?php
$username = $_GET["username"];
require('API/socket.php');
$service = 0xF903;
$input = "{\"username\":\"" . $username . "\"}";
echo sendMessage($service, $input);
//$jsonData = json_decode(sendMessage($service, $input));
?>
