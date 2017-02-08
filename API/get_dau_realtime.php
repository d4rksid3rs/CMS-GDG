<?php

error_reporting(-1);
ini_set('display_errors', 'On');
require('db.class.php');

if (isset($_GET['date'])) {
    $today = $_GET['date'];
} else {
    $today = date('Y-m-d');
}
$path = realpath(__DIR__ . DIRECTORY_SEPARATOR . '..');
//$today_start = '2016-07-23 00:00:00';
//$month_start = '2016-06-23 00:00:00';
// Log Dang ky by CP
$sql_reg_cp_day = "select count(*) as total, cp from user where date(date_created) = '{$today}' group by cp";

$stmt1 = $db->prepare($sql_reg_cp_day);
$stmt1->execute();
$dau_rt_reg_cp_array = array();
if ($stmt1->rowCount() > 0) {
    foreach ($stmt1 as $row) {
        $dau_rt_reg_cp_array[] = array(
            'date_login' => $today,
            'name1' => $row['cp'],
            'dau' => $row['total']
        );
    }
    echo 'Success !!!!';
}
$content1 = json_encode($dau_rt_reg_cp_array);
if (isset($content1)) {
    $filename = $path . "/dau/rt_reg_cp";
    $fh = fopen($filename, 'w') or die("can't open file");
    //file_put_contents($filename, $content);
    fwrite($fh, $content1);
    fclose($fh);
    echo "ok";
} else {
    echo "false";
}

// Log Login by CP

$sql_login_cp_day = "select count(*) as total, cp from user where date(last_login) = '{$today}' group by cp";
$stmt2 = $db->prepare($sql_login_cp_day);
$stmt2->execute();
$dau_rt_login_cp_array = array();

if ($stmt2->rowCount() > 0) {
    foreach ($stmt2 as $row) {
        $dau_rt_login_cp_array[] = array(
            'date_login' => $today,
            'name1' => $row['cp'],
            'dau' => $row['total']
        );
    }
    echo 'Success !!!!';
} else {
    echo 'No Moeny for Today !!';
}
$content2 = json_encode($dau_rt_login_cp_array);
if (isset($content2)) {
    $filename = $path . "/dau/rt_login_cp";
    $fh = fopen($filename, 'w') or die("can't open file");
    //file_put_contents($filename, $content);
    fwrite($fh, $content2);
    fclose($fh);
    echo "ok";
} else {
    echo "false";
}

// Log Dang ky by OS
$sql_reg_os_day = "select count(*) as total, os_type from user where date(date_created) = '{$today}' group by os_type";
$stmt3 = $db->prepare($sql_reg_os_day);
$stmt3->execute();
$dau_rt_reg_os_array = array();

if ($stmt3->rowCount() > 0) {
    foreach ($stmt3 as $row) {
        $dau_rt_reg_os_array[] = array(
            'date_login' => $today,
            'name1' => $row['os_type'],
            'dau' => $row['total']
        );
    }
    echo 'Success !!!!';
} else {
    echo 'No Moeny for Today !!';
}
$content3 = json_encode($dau_rt_reg_os_array);
if (isset($content3)) {
    $filename = $path . "/dau/rt_reg_os";
    $fh = fopen($filename, 'w') or die("can't open file");
    //file_put_contents($filename, $content);
    fwrite($fh, $content3);
    fclose($fh);
    echo "ok";
} else {
    echo "false";
}

// Log Login by OS
$sql_login_os_day = "select count(*) as total, os_type from user where date(last_login) = '{$today}' group by os_type";
$stmt4 = $db->prepare($sql_login_os_day);
$stmt4->execute();
$dau_rt_login_os_array = array();

if ($stmt4->rowCount() > 0) {
    foreach ($stmt4 as $row) {
        $dau_rt_login_os_array[] = array(
            'date_login' => $today,
            'name1' => $row['os_type'],
            'dau' => $row['total']
        );
    }
    echo 'Success !!!!';
} else {
    echo 'No Moeny for Today !!';
}
$content4 = json_encode($dau_rt_login_os_array);
if (isset($content4)) {
    $filename = $path . "/dau/rt_login_os";
    $fh = fopen($filename, 'w') or die("can't open file");
    //file_put_contents($filename, $content);
    fwrite($fh, $content4);
    fclose($fh);
    echo "ok";
} else {
    echo "false";
}

// Log Dang ky by Version
$sql_reg_client_day = "select count(*) as total, client_version from user where date(date_created) = '{$today}' group by client_version";
$stmt5 = $db->prepare($sql_reg_client_day);
$stmt5->execute();
$dau_rt_reg_ver_array = array();

if ($stmt5->rowCount() > 0) {
    foreach ($stmt5 as $row) {
        $dau_rt_reg_ver_array[] = array(
            'date_login' => $today,
            'name1' => $row['client_version'],
            'dau' => $row['total']
        );
    }
    echo 'Success !!!!';
} else {
    echo 'No Moeny for Today !!';
}
$content5 = json_encode($dau_rt_reg_ver_array);
if (isset($content5)) {
    $filename = $path . "/dau/rt_reg_ver";
    $fh = fopen($filename, 'w') or die("can't open file");
    //file_put_contents($filename, $content);
    fwrite($fh, $content5);
    fclose($fh);
    echo "ok";
} else {
    echo "false";
}

// Log Login by Version
$sql_login_client_day = "select count(*) as total, client_version from user where date(last_login) = '{$today}' group by client_version";
$stmt6 = $db->prepare($sql_login_client_day);
$stmt6->execute();
$dau_rt_login_ver_array = array();

if ($stmt6->rowCount() > 0) {
    foreach ($stmt6 as $row) {
        $dau_rt_login_ver_array[] = array(
            'date_login' => $today,
            'name1' => $row['client_version'],
            'dau' => $row['total']
        );
    }
    echo 'Success !!!!';
} else {
    echo 'No Moeny for Today !!';
}
$content6 = json_encode($dau_rt_login_ver_array);
if (isset($content6)) {
    $filename = $path . "/dau/rt_login_ver";
    $fh = fopen($filename, 'w') or die("can't open file");
    //file_put_contents($filename, $content);
    fwrite($fh, $content6);
    fclose($fh);
    echo "ok";
} else {
    echo "false";
}