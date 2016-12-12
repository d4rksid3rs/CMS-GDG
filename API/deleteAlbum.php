<?php
require('../Config.php');
require('db.class.php');

$id = $_GET['id'];

if (is_numeric($id) && $id > 0) {
	
	try {
		// Xóa album
		$sql = "delete from user_blog_album where id=${id}";
		$db->exec($sql);
		
		// Lấy danh sách ảnh trong album
		$sql = "select id, status_id from user_blog_album_image where album_id=${id}";
		$listId = "";
		$listStatusId = "";
		foreach ($db->query($sql) as $row) {
			$listId .= ",".$row['id'];
			if ($row['status_id'] >0) {
				$listStatusId .= ",".$row['status_id'];
			}
		}
		if (strlen($listId) > 0 )  {
			$listId = substr($listId,1);
			// Xóa danh sách ảnh trong album
			$sql = "delete from user_blog_album_image where album_id=${id}";
			$db->exec($sql);
			
			// Xóa danh sách comment liên quan tới album
			$sql = "delete from user_blog_album_image_comment where image_id in (${listId})";
			$db->exec($sql);
		}
		
		// Xóa danh sách status liên quan tới album
		if (strlen($listStatusId) > 0 )  {
			$listStatusId = substr($listStatusId,1);
			$sql = "delete from user_blog_wall where id in (${listStatusId})";
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
