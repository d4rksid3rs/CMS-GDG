<?php

error_reporting(-1);
ini_set('display_errors', 'On');
require('db.class.php');

// Server Koin
if (empty($_GET['date'])) {
    $today_timestamp = date("Y-m-d H:i:s");
} else {
    $today_timestamp = $_GET['date']. " 00:00:01";
}
$sql_koin = "select sum(koin) as total_koin, sum(koin_vip) as total_vip_koin, sum(mkoin) as total_mkoin, sum(mkoin_vip) as total_vip_mkoin from auth_user";
$stmt20 = $db->prepare($sql_koin);
$stmt20->execute();
foreach ($stmt20 as $row) {
    $total_koin = $row['total_koin'] + $row['total_mkoin'];
    $total_koin_vip = $row['total_vip_koin'] + $row['total_vip_mkoin'];
    $sql_insert = "INSERT INTO `server_koin` (`date`, `koin`, `koin_vip`) VALUES ('{$today_timestamp}', {$total_koin}, {$total_koin_vip})";
    $db->exec($sql_insert);
}

