<?php
require('socket.php');
$type = $_GET["type"];
if ($type == 'start') {
	$service = 0xF90E;
} else if ($type == 'end') {
	$service = 0xF90F;
}
$input = "{}";
echo sendMessage($service, $input);
?>
