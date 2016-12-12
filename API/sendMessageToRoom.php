<?php
$room = $_GET["roomId"];
$msg = $_GET["message"];
require('socket.php');
$service = 0xF908;
$input = "{\"message\":\"".$msg."\",\"roomId\":".$room."}";
echo $input;
$jsonData = json_decode(sendMessage($service, $input));
?>