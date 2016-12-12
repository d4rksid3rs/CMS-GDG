<?php
$roomId = $_GET["roomId"];
$tableId = $_GET["tableId"];
require('socket.php');
$service = 0xF902;
$input = "{\"roomId\":".$roomId.",\"tableId\":".$tableId."}";
echo sendMessage($service, $input);
?>
