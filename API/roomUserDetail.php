<?php
$roomId = $_GET["roomId"];
require('socket.php');
$service = 0xF909;
$input = "{\"roomId\":".$roomId."}";
sendMessage($service, $input);
?>
