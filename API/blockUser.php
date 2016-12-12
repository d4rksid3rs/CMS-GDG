<?php

require('../Config.php');
require('db.class.php');
$username = $_POST['username'];
$type = $_POST['type']; //1 = lock_time //0 = mute_time
$datetype = $_POST['datetype']; // 0 = giờ // 1 = ngày // 2 = tháng
$date = $_POST['date'];
$cause = $_POST['cause'];
if (strlen($date) == 0) {
    die("{\"status\":0,\"message\":\"Chưa nhập thời gian\"}");
}

//2011-11-12 17:19:04
$formatDate = 'Y-m-d H:i:s';
$currDate = date($formatDate);

if (is_numeric($date) && $date != 0) {

    if (isset($username) && strlen($username) > 0) {
        if (isset($cause) && strlen($cause) > 0) {
            try {
                $sql = "select * from user where username='" . $username . "' limit 0,1";
                $found = false;
                foreach ($db->query($sql) as $row) {

                    $found = true;

                    if ($datetype == 0) {
                        $dateTime = new DateTime("+{$date} hours");
                        $dateLock =  $dateTime->format("Y-m-d H:i:s");
//                        $dateLock = strtotime(date($formatDate, strtotime($currDate)) . " +{$date} hour");
                    }
                    if ($datetype == 1) {
                        $dateTime = new DateTime("+{$date} days");
                        $dateLock =  $dateTime->format("Y-m-d H:i:s");
//                        $dateLock = strtotime(date($formatDate, strtotime($currDate)) . " +{$date} days");
                    }
                    if ($datetype == 2) {
                        $dateTime = new DateTime("+{$date} months");
                        $dateLock =  $dateTime->format("Y-m-d H:i:s");
                    }
//                    var_dump($dateLock);die;
//                    $dateLock = date($formatDate, $dateLock);

                    $sqlLock = "update user set mute_time = '{$dateLock}' where id = " . $row['id'];

                    if ($type == 1) {
                        $sqlLock = "update user set lock_time = '{$dateLock}' where id = " . $row['id'];
                    }
//                    echo $sqlLock;die;
                    $cause = mysql_escape_string($cause);
                    $sql_c = "SELECT * FROM user_block WHERE id = " . $row['id'];
                    $insert = true;
                    foreach ($db->query($sql_c) as $row) {
                        $insert = false;
                    }
                    //			echo "{\"status\":0,\"message\":\"{$sqlLock}\"}";
                    $db->query($sqlLock);


                    if ($insert) {
                        $sql_cause = "INSERT INTO user_block VALUES('" . $row['id'] . "','" . $cause . "')";
                    } else {
                        $sql_cause = "UPDATE user_block SET cause = '$cause' WHERE id = " . $row['id'];
                    }
                    $db->query($sql_cause);
                }
                if ($found == false) {
                    echo "{\"status\":0,\"message\":\"Không tìm thấy username trong DB\"}";
                } else {
                    echo "{\"status\":0,\"message\":\"Thành công\"}";
                }
            } catch (Exception $e) {
                echo "{\"status\":0,\"message\":\"" . $e->getMessage() . "\"}";
            }
        } else {
            echo "{\"status\":0,\"message\":\"Chưa nhập lý do\"}";
        }
    } else {
        echo "{\"status\":0,\"message\":\"Chưa nhập username\"}";
    }
} else {
    echo "{\"status\":0,\"message\":\"Thời gian chưa chính xác\"}";
}
?>
