<?php
require('Config.php');
require('API/db.class.php');
$allowMaxKoin = 10000000;
$user = $_REQUEST['user'];
$pass = $_POST['pass'];
$koin = $_REQUEST['koin'];
$cause = $_POST['cause'];
//$user = mysql_escape_string($user);
//$pass = mysql_escape_string($pass);
	try {
				$db->query("SET NAMES 'UTF8'");
				$sql = "select * from auth_user where `username` = '" . $user . "' limit 0,1";
		$found = false;			
		foreach ($db->query($sql) as $row) {
				
				$found = true;

		}		
		if ($found == true) {
			//$sql1 = "insert into admin_add_koin(username, admin_pass, koin, cause) values('{$user}','{$pass}','{$koin}', '{$cause}')";
			//$db->exec($sql1);
			
			$sql2 = "update auth_user set koin=koin+{$koin} where username='$user'";
			$db->exec($sql2);
			
			echo "{\"status\":0,\"message\":\"Cộng koin thành công\"}";
			try {
				$redis = new Redis();
				$redis->connect('local.redis');
				$obj = new stdClass();
				$obj->username = $user; 
				$obj->type = 3;
				$obj->koinAdded = $koin;
				$redis->publish('GameChannel', "500@".json_encode($obj));
				$redis->close();
			} catch (Exception $e){
				echo $e->getMessage();
			}
		}
		
		if ($found == false) {
			echo "{\"status\":0,\"message\":\"Không tìm thấy username trong DB\"}";
		}
	} catch (Exception $e) {
		echo "{\"status\":0,\"message\":\"" . $e->getMessage() . "\"}";
	} 
?>
