<?php

require('../Config.php');
require('db.class.php');
$current_user = $_COOKIE['username'];
//$allowMaxKoin = 10000000;
$user = $_POST['user'];
$pass = $_POST['pass'];
$koin = $_POST['koin'];
$cause = $_POST['cause'];
$user = mysql_escape_string($user);
$user = strtolower($user);
$pass = mysql_escape_string($pass);
$cause = mysql_escape_string($cause);
if (is_numeric($koin) && strlen($pass) > 0 && strlen($user) > 0) {
    if ($koin >= 0) {
        $koin = $koin * (-1);
        if ($pass == "gdgonline@2017") {
            try {
                $db->query("SET NAMES 'UTF8'");
                $sql = "select * from auth_user where username='" . $user . "' limit 0,1";
                $found = false;
                foreach ($db->query($sql) as $row) {

                    $found = true;
                }
                if ($found == true) {
                    $sql1 = "insert into admin_add_chip (username, chip, created_by, cause) values('{$user}', '{$koin }','{$current_user}', '{$cause}')";
                    $db->exec($sql1);

                    $sql2 = "update auth_user set koin_vip=koin_vip+{$koin} where username='{$user}'";
                    $db->exec($sql2);

                    echo "{\"status\":0,\"message\":\"Trừ Chip thành công\"}";
                    try {
                        $redis = new Redis();
                        $redis->connect('local.redis');
                        $obj = new stdClass();
                        $obj->username = $user;
                        $obj->type = 3;
                        $obj->type_money = 1;
                        $obj->koinAdded = $koin;
                        $redis->publish('GameChannel', "500@" . json_encode($obj));
                        $redis->close();
                    } catch (Exception $e) {
                        echo $e->getMessage();
                    }
                }

                if ($found == false) {
                    echo "{\"status\":0,\"message\":\"Không tìm thấy username trong DB\"}";
                }
            } catch (Exception $e) {
                echo "{\"status\":0,\"message\":\"" . $e->getMessage() . "\"}";
            }
        } else {
            echo "{\"status\":0,\"message\":\"Sai mật khẩu Cộng Xu\"}";
        }
    } else {
        echo "{\"status\":0,\"message\":\"Không được nhập số âm\"}";
    }
} else {
    echo "{\"status\":0,\"message\":\"Tham số không hợp lệ\"}";
}
?>
