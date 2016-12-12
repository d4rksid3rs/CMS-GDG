<?php
require('socket.php');
$service = 0xF90C;
$input = "{}";
echo sendMessage($service, $input);
?>
