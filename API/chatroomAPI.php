<?php
require('../Config.php');
require('db.class.php');
require('socket.php');

$id = $_GET['id'];
$type = $_GET['type'];
if (is_numeric($id) && $id > 0) {
	if ($type === "get") {
		$sql = "select * from room where id=${id}";
		foreach ($db->query($sql) as $row) {
			$tmp = explode("@@", $row['name']);
			$img = str_replace("_", "/", $tmp[2]);
			$img = "http://avatar.trachanhquan.com/".$img.".png";
			echo "{\"status\":1,\"tmp1\":\"".$tmp[0]."\",\"tmp2\":\"".$tmp[1]."\",\"tmp3\":\"".$img."\"}";
			break;
		}
	} else {
		$title = $_GET['title'];
		$desp = $_GET['desp'];
		$image = $_GET['image'];
		if (strpos($image, "avatar") === false || strpos($image, "trachanhquan") === false || strpos($image, "png") === false) {
			echo "{\"status\":0,\"message\":\"Link ảnh không hợp lệ\"}";
		} else {
			try {
				$image = substr($image, strpos($image, "/upload") + 1);
				$image = substr($image, 0, strrpos($image, "."));
				$image = str_replace("/","_",$image);
				$update = $title."@@".$desp."@@".$image;
				$update = mysql_escape_string($update);
				$sql = "update room set name=\"${update}\" where id=${id}";
				$db->exec($sql);
				echo "{\"status\":1,\"message\":\"Sửa room thành công!\"}";		
				sendMessage(63767, "{\"id\":${id},\"name\":\"${update}\"}");
			} catch (Exception $e) {
				echo "{\"status\":0,\"message\":\"" . $e->getMessage() . "\"}";
			}
		}
	}
} else {
	echo "{\"status\":0,\"message\":\"Tham số không hợp lệ\"}";
}
?>
