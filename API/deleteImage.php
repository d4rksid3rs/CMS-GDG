<?php
require('../Config.php');
require('db.class.php');

$id = $_GET['id'];
$status = $_GET['status'];

if (is_numeric($id) && is_numeric($status)) {
	
	try {
		if ($id > 0) {
			$sql = "delete from user_blog_album_image_comment where image_id=${id}";
			$db->exec($sql);
			
			$sql = "delete from user_blog_album_image where id=${id}";
			$db->exec($sql);
		}
		
		if (status > 0) {
			$sql = "delete from user_blog_wall_comment where status_id=${status}";
			$db->exec($sql);
			
			$sql = "delete from user_blog_wall where id=${status}";
			$db->exec($sql);
		}
		
		echo "{\"status\":1,\"message\":\"Xóa ảnh thành công!\"}";
		
	} catch (Exception $e) {
		echo "{\"status\":0,\"message\":\"" . $e->getMessage() . "\"}";
	} 
	
} else {
	echo "{\"status\":0,\"message\":\"Tham số không hợp lệ\"}";
}
?>
