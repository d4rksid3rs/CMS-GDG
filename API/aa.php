<?php
require('../Config.php');
try {
	$redis = new Redis();
	$redis->connect('local.redis');
	$redis->del("obatigol82");
	$redis->del("ochoapp");
	$redis->close();
} catch (Exception $e){
	echo $e->getMessage();
}
?>
