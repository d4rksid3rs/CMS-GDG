<?php

require('../Config.php');
require('db.class.php');
$allowMaxKoin = 1000000000;
$user = $_POST['user'];
$pass = $_POST['pass'];
$koin = $_POST['koin'];
$cause = $_POST['cause'];
$user = mysql_escape_string($user);
$user = strtolower($user);
$pass = mysql_escape_string($pass);
$cause = mysql_escape_string($cause);
$current_user = $_COOKIE['username'];
if (is_numeric($koin) && strlen($pass) > 0 && strlen($user) > 0 && strlen($cause) > 0) {
    if ($pass == "gdgonline@2017") {
        if ($koin <= $allowMaxKoin) {
            try {
                $db->query("SET NAMES 'UTF8'");
                $sql = "select * from auth_user where username='" . $user . "' limit 0,1";
                $found = false;
                foreach ($db->query($sql) as $row) {

                    $found = true;
                }
                $cause = $current_user . ' - ' . $cause;
                if ($found == true) {
                    $check = FALSE;
                    $sql_merchant = "select * from merchants where username='" . $user . "' limit 0,1";
                    foreach ($db->query($sql_merchant) as $row) {

                        $check = true;
                    }
                    if (!$check) {
                        $sql1 = "insert into admin_add_koin(username, admin_pass, koin, cause) values('{$user}','{$pass}','{$koin}', '{$cause}')";
                        $db->exec($sql1);

                        $sql2 = "update auth_user set koin=koin+{$koin} where username='{$user}'";
                        $db->exec($sql2);

                        echo "{\"status\":0,\"message\":\"Cộng Xu thành công\"}";
                        try {
                            $redis = new Redis();
                            $redis->connect('local.redis');
                            $obj = new stdClass();
                            $obj->username = $user;
                            $obj->type = 3;
                            $obj->type_money = 0;
                            $obj->koinAdded = $koin;
                            $redis->publish('GameChannel', "500@" . json_encode($obj));
                            $redis->close();
                        } catch (Exception $e) {
                            echo $e->getMessage();
                        }
                    } else {
                        echo "{\"status\":0,\"message\":\"Không được cộng tiền cho Đại lý\"}";
                    }
                }
                if ($found == false) {
                    echo "{\"status\":0,\"message\":\"Không tìm thấy username trong DB\"}";
                }
            } catch (Exception $e) {
                echo "{\"status\":0,\"message\":\"" . $e->getMessage() . "\"}";
            }
        } else {
            echo "{\"status\":0,\"message\":\"Mức cộng tối đa trong 1 lần là {$allowMaxKoin}\"}";
        }
    } else {
        echo "{\"status\":0,\"message\":\"Sai mật khẩu Admin\"}";
    }
} else {
    echo "{\"status\":0,\"message\":\"Tham số không hợp lệ\"}";
}
?>
