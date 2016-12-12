<?php
/*
require('socket1.php');
$service = 0xF90C;
$input = "{}";
echo sendMessage($service, $input);
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
