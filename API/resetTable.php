<?php
require('socket.php');
$roomId = $_GET["roomId"];
$tableId = $_GET["tableId"];
$service = 0xF90D;
$input = "{\"roomId\":".$roomId.",\"tableId\":".$tableId."}";
echo sendMessage($service, $input);
?>
