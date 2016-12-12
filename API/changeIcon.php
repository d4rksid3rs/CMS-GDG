<?php
require('socket.php');
require('../Config.php');
require('db.class.php');
$guild_name = $_POST['guild_name'];
$icon_id = $_POST['icon_id'];

	if (isset($guild_name) && strlen($guild_name) > 0) {
		try {
			$sql = "select * from guild where name='" . $guild_name . "' limit 0,1";
			$found = false;
			foreach ($db->query($sql) as $row) {

				$found = true;				
				$sqlChangeIcon = "update guild set icon = 'guild_{$icon_id}' where id = ".$row['id'];
				$db->query($sqlChangeIcon);
				
			}
			if ($found == false) {
				echo "{\"status\":0,\"message\":\"Không tìm thấy bang hội này trong DB\"}";
			}else {
				echo "{\"status\":0,\"message\":\"Thành công\"}";
				$input = "{}";
				$service = 63761;
				sendMessage6868($service, $input);
			}
		} catch (Exception $e) {
			echo "{\"status\":0,\"message\":\"" . $e->getMessage() . "\"}";
		}
	} else {
		echo "{\"status\":0,\"message\":\"Chưa nhập bang hội\"}";
	}
//} else {
//	echo "{\"status\":0,\"message\":\"Thời gian chưa chính xác\"}";
//}

?>
