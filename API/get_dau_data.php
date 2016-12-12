<?php

error_reporting(-1);
ini_set('display_errors', 'On');
require('db.class.php');
//$end_date = date('Y-m-d');
//
//$end_date = date("Y-m-d", strtotime("-1 day", strtotime($end_date)));
//
////$date_start = date ("Y-m-d",strtotime("yesterday"));
//
//$date_start = date("Y-m-d", strtotime("-7 day", strtotime($end_date)));
//
//$start_date = $date_start;
//
//$week = array();
//while (strtotime($date_start) < strtotime($end_date)) {
//    $date_start = date("Y-m-d", strtotime("+1 day", strtotime($date_start)));
//    $week[] = $date_start;
//}

$today = date('Y-m-d');
//$today = date('2016-07-23');
$month = date("Y-m-d", strtotime("-30 day", strtotime($today)));
$today_start = $today . ' 00:00:00';
$month_start = $month . ' 00:00:00';

//$today_start = '2016-07-23 00:00:00';
//$month_start = '2016-06-23 00:00:00';
// Log Dang ky by CP
$sql_reg_cp_day = "select count(*) as total, cp from user where date_created > '{$today_start}' group by cp";
$sql_reg_cp_month = "select count(*) as total, cp from user where date_created > '{$month_start}' group by cp";
$stmt1 = $db->prepare($sql_reg_cp_day);
$stmt1->execute();

$stmt2 = $db->prepare($sql_reg_cp_month);
$stmt2->execute();

if ($stmt1->rowCount() > 0) {
    foreach ($stmt1 as $row) {
        $total_month = 0;
        foreach ($stmt2 as $row2) {
            if ($row2['cp'] == $row['cp']) {
                $total_month = $row2['total'];
                break;
            }
        }
        $sql_insert = "INSERT INTO `active_user_detail` (`date_login`, `type`, `name1`, `name2`, `dau`, `mau`) VALUES ('{$today}', '2', '{$row['cp']}', '{$row['cp']}', '{$row['total']}', '{$total_month}')";

        $db->exec($sql_insert);
    }
    echo 'Success !!!!';
} else {
//    $sql_insert = "INSERT INTO `active_user_detail` (`date_login`, `type`, `name1`, `name2`, `dau`, `mau`) VALUES ('{$today}', '0', '', '', '', '0')";
//    var_dump($sql_insert);
//    $db->exec($sql_insert);
    echo 'No Moeny for Today !!';
}
// Log Login by CP

$sql_login_cp_day = "select count(*) as total, cp from user where  last_login > '{$today_start}' group by cp";
$sql_login_cp_month = "select count(*) as total, cp from user where  last_login > '{$month_start}' group by cp";
$stmt3 = $db->prepare($sql_login_cp_day);
$stmt3->execute();

$stmt4 = $db->prepare($sql_login_cp_month);
$stmt4->execute();

if ($stmt3->rowCount() > 0) {
    foreach ($stmt3 as $row) {
        $total_month = 0;
        foreach ($stmt4 as $row2) {
            if ($row2['cp'] == $row['cp']) {
                $total_month = $row2['total'];
                break;
            }
        }
        $sql_insert = "INSERT INTO `active_user_detail` (`date_login`, `type`, `name1`, `name2`, `dau`, `mau`) VALUES ('{$today}', '4', '{$row['cp']}', '{$row['cp']}', '{$row['total']}', '{$total_month}')";
//        var_dump($sql_insert);
        $db->exec($sql_insert);
    }
    echo 'Success !!!!';
} else {
//    $sql_insert = "INSERT INTO `active_user_detail` (`date_login`, `type`, `name1`, `name2`, `dau`, `mau`) VALUES ('{$today}', '0', '', '', '', '0')";
//    $db->exec($sql_insert);
    echo 'No Moeny for Today !!';
}

// Log Dang ky by OS
$sql_reg_os_day = "select count(*) as total, os_type from user where date_created > '{$today_start}' group by os_type";
$sql_reg_os_month = "select count(*) as total, os_type from user where date_created > '{$month_start}' group by os_type";
$stmt5 = $db->prepare($sql_reg_os_day);
$stmt5->execute();

$stmt6 = $db->prepare($sql_reg_os_month);
$stmt6->execute();

if ($stmt5->rowCount() > 0) {
    foreach ($stmt5 as $row) {
        $total_month = 0;
        foreach ($stmt6 as $row2) {
            if ($row2['os_type'] == $row['os_type']) {
                $total_month = $row2['total'];
                break;
            }
        }
        $sql_insert = "INSERT INTO `active_user_detail` (`date_login`, `type`, `name1`, `name2`, `dau`, `mau`) VALUES ('{$today}', '1', '{$row['os_type']}', '{$row['os_type']}', '{$row['total']}', '{$total_month}')";
        $db->exec($sql_insert);
    }
    echo 'Success !!!!';
} else {
//    $sql_insert = "INSERT INTO `active_user_detail` (`date_login`, `type`, `name1`, `name2`, `dau`, `mau`) VALUES ('{$today}', '0', '', '', '', '')";
//    $db->exec($sql_insert);
    echo 'No Moeny for Today !!';
}

// Log Login by OS
$sql_login_os_day = "select count(*) as total, os_type from user where date_created > '{$today_start}' group by os_type";
$sql_login_os_month = "select count(*) as total, os_type from user where date_created > '{$month_start}' group by os_type";
$stmt7 = $db->prepare($sql_login_os_day);
$stmt7->execute();

$stmt8 = $db->prepare($sql_login_os_month);
$stmt8->execute();

if ($stmt7->rowCount() > 0) {
    foreach ($stmt7 as $row) {
        $total_month = 0;
        foreach ($stmt8 as $row2) {
            if ($row2['os_type'] == $row['os_type']) {
                $total_month = $row2['total'];
                break;
            }
        }
        $sql_insert = "INSERT INTO `active_user_detail` (`date_login`, `type`, `name1`, `name2`, `dau`, `mau`) VALUES ('{$today}', '3', '{$row['os_type']}', '{$row['os_type']}', '{$row['total']}', '{$total_month}')";
        $db->exec($sql_insert);
    }
    echo 'Success !!!!';
} else {
//    $sql_insert = "INSERT INTO `active_user_detail` (`date_login`, `type`, `name1`, `name2`, `dau`, `mau`) VALUES ('{$today}', '0', '', '', '', '')";
//    $db->exec($sql_insert);
    echo 'No Moeny for Today !!';
}

// Server Koin
$sql_koin = "select sum(koin) as total, sum(koin_vip) as total_vip from auth_user";
$stmt10 = $db->prepare($sql_koin);
$stmt10->execute();
$today_timestamp = date("Y-m-d H:i:s");
foreach ($stmt10 as $row) {
    $sql_insert = "INSERT INTO `server_koin` (`date`, `koin`, `koin_vip`) VALUES ('{$today_timestamp}', {$row['total']}, {$row['total_vip']})";
    $db->exec($sql_insert);
}