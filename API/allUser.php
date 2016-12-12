<?php
require('socket.php');
$service = 0xF90A;
$input = "{}";
sendMessage($service, $input);
?>
