<?php

require('../Config.php');
require('db.class.php');
$current_user = $_COOKIE['username'];
//$allowMaxKoin = 10000000;
$user = $_POST['user'];
$pass = $_POST['pass'];
$vnd = $_POST['vnd'];
$user = mysql_escape_string($user);
$user = strtolower($user);
$pass = mysql_escape_string($pass);
$rate = 1;
$sql_rate = "SELECT * FROM `config` WHERE `key` LIKE 'merchant_rate'  limit 0,1";
foreach ($db->query($sql_rate) as $row) {
    $json =  $row['value'];
}
$rate_array = json_decode($json, true);
$rate = $rate_array['merchant_rate'];
if (is_numeric($vnd) && strlen($pass) > 0 && strlen($user) > 0) {
    $koin = $vnd * $rate;
    if ($pass == "daily2017") {
        try {
            $db->query("SET NAMES 'UTF8'");
            $sql = "select * from auth_user where username='" . $user . "' limit 0,1";
            $found = false;
            foreach ($db->query($sql) as $row) {

                $found = true;
            }
//            $cause = $current_user .' - '.$cause;
            if ($found == true) {
                $sql1 = "insert into merchant_add_koin(username, admin_pass, vnd, koin, created_by) values('{$user}','{$pass}','{$vnd }','{$koin }','{$current_user}')";
                $db->exec($sql1);

                $sql2 = "update auth_user set koin=koin+{$koin} where username='{$user}'";
                $db->exec($sql2);

                echo "{\"status\":0,\"message\":\"Cộng koin thành công\"}";
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
    echo "{\"status\":0,\"message\":\"Tham số không hợp lệ\"}";
}
?>
