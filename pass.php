<?php
require('_login.php');

require('Config.php');
require('./API/db.class.php');
$username = $_GET['username'];
$pass = array(
	'1234',
	'5678',
	'3456',
	'0913',
	'0904',
	'0978',
	'0123',
	'0122',
	'0934',
	'0164',
	'0983'	
);
if (isset($username) && strlen($username) > 0) {
    try {
        $sql = "select * from auth_user where username='" . $username . "' limit 0,1";
        $found = false;
        foreach ($db->query($sql) as $row) {
            $found = true;
			$koin = number_format($row['koin'],0);
			$mobile = $row['mobile'];
			$pass = $pass[array_rand($pass,1)];
			$pass_hash = md5($pass);
			$sql = "update auth_user set password_hash='$pass_hash' where username='" . $username . "'";
			$db->query($sql);
			echo "$pass<br />";
			//{\"status\":1,\"password\":\"$pass\",\"koin\":\"" . $koin . "\",\"mobile\":\"" . $mobile . "\"}";
			break;
        }
        if ($found == false) {
            echo "{\"status\":0,\"message\":\"Không tìm thấy username trong DB\"}";
        }
    } catch (Exception $e) {
        echo "{\"status\":0,\"message\":\"" . $e->getMessage() . "\"}";
    }
} else {
    echo "{\"status\":0,\"message\":\"Chưa nhập username\"}";
}
?>
