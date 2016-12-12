<?php
$msg = $_GET["message"];
/*
require('socket1.php');
//$service = 0xF908;
$service = 63765;
$input = "{\"message\":\"".$msg."\"}";
echo sendMessage($service, $input);
echo sendMessage1($service, $input);
*/
try {
	$obj = new stdClass();
	$obj->type = 1;
	$obj->msgType = 2;
	$obj->msg = $msg;

	$redis = new Redis();
	$redis->connect('local.redis');
	$redis->publish("GameChannel", "1003@".json_encode($obj));
	$redis->close();

	echo "{'status':1}";
} catch (Exception $e){
	echo $e->getMessage();
}

?>
