<?php
require('../Config.php');
require('db.class.php');
$fromDate = $_GET['fromDate'];
$toDate = $_GET['toDate'];
$page = $_GET['page'];
if (!is_numeric($page)) {
	$page = 1;
}
if ($page < 1 ) {
	$page = 1;
}
try {
	$start = ($page-1) * 50;
	$end = $page * 50;
	$sql = "select * from user_blog_album_image where date(date_created) >= '".$fromDate."' and date(date_created) <= '".$toDate."' order by plus_count desc limit {$start},{$end}";
	$found = false;
	$output = "[";
	foreach ($db->query($sql) as $row) {
		$img = $row['image'];
		$img = str_replace("_", "/", $img);
		$img = "http://avatar.trachanhquan.com/".$img;
		if ($found == false) {
			$output .= "{\"statusId\":\"".$row['status_id']."\",\"id\":\"".$row['id']."\",\"albumId\":\"".$row['album_id']."\",\"owner\":\"".$row['owner']."\",\"plusCount\":\"".$row['plus_count']."\",\"image\":\"".$img."\",\"dateCreated\":\"".$row['date_created']."\"}";
		} else {
			$output .= ",{\"statusId\":\"".$row['status_id']."\",\"id\":\"".$row['id']."\",\"albumId\":\"".$row['album_id']."\",\"owner\":\"".$row['owner']."\",\"plusCount\":\"".$row['plus_count']."\",\"image\":\"".$img."\",\"dateCreated\":\"".$row['date_created']."\"}";
		}
		$found = true;
	}
	$output .= "]";
	if ($found == false) {
		echo "{\"status\":0,\"message\":\"Không có dữ liệu\"}";
	} else {
		echo "{\"status\":1,\"picture\":".$output."}";
	}
} catch (Exception $e) {
	echo "{\"status\":0,\"message\":\"" . $e->getMessage() . "\"}";
}

?>
