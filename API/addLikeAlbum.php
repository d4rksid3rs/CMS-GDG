<?php
require('../Config.php');
require('db.class.php');

$id = $_GET['id'];

if (is_numeric($id) && $id > 0) {
	
	try {
		$sql = "update user_blog_album set plus_count=plus_count+100 where id=${id}";
		$db->exec($sql);
		
		echo "{\"status\":1,\"message\":\"Cộng likes thành công!\"}";		
	} catch (Exception $e) {
		echo "{\"status\":0,\"message\":\"" . $e->getMessage() . "\"}";
	}
} else {
	echo "{\"status\":0,\"message\":\"Tham số không hợp lệ\"}";
}
?>
