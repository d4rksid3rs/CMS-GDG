<?php
require('../Config.php');
require('db.class.php');
$user = $_POST['user'];
$fb = $_POST['feedback'];
$user = mysql_escape_string($user);
$fb = mysql_escape_string($fb);

			try {
					$sql1 = "insert into feedback_call(username, feedback) values('{$user}','{$fb}')";
					$db->exec($sql1);
					echo "{\"status\":1,\"username\":\"{$user}\",\"message\":\"Đã gọi: ".$fb."\"}";
			} catch (Exception $e) {
				echo "{\"status\":0,\"message\":\"" . $e->getMessage() . "\"}";
			} 
?>
