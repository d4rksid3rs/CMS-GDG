<?php

require('../Config.php');
require('db.class.php');

$mobile = $_POST['mobile'];
$type = $_POST['type']; //2 = lock_time //1 = mute_time
$datetype = $_POST['datetype']; // 0 = giờ // 1 = ngày // 2 = tháng
$date = $_POST['date'];
//2011-11-12 17:19:04
$formatDate = 'Y-m-d H:i:s';
$currDate = date($formatDate);
if (is_numeric($date) && $date != 0) {
    if (isset($mobile) && strlen($mobile) > 0) {
        try {
            $sql = "select * from user where mobile='" . $mobile . "' limit 0,1";
            echo $sql;
            $found = false;
            foreach ($db->query($sql) as $row) {
                var_dump($row);
                $found = true;
                if ($datatype == 0) {
                    $dateLock = strtotime(date($formatDate, strtotime($currDate)) . " +{$date} hour");
                }
                if ($datetype == 1) {
                    $dateLock = strtotime(date($formatDate, strtotime($currDate)) . " +{$date} days");
                }
                if ($datetype == 2) {
                    $dateLock = strtotime(date($formatDate, strtotime($currDate)) . " +{$date} month");
                }
                $dateLock = date($formatDate, $dateLock);
                //$sqlLock = "update user set mute_time = '{$dateLock}' where id = ".$row['id'];
                if ($type == 2)
                    $sqlLock = "update user set lock_time = '{$dateLock}' where id = " . $row['id'];

                //			echo "{\"status\":0,\"message\":\"{$sqlLock}\"}";
                $db->query($sqlLock);
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
        echo "{\"status\":0,\"message\":\"Chưa nhập phone\"}";
    }
} else {
    echo "{\"status\":0,\"message\":\"Thời gian chưa chính xác\"}";
}
?>
