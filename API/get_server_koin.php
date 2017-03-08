<?php

error_reporting(-1);
ini_set('display_errors', 'On');
require('db.class.php');

// Server Koin
$today_timestamp = date("Y-m-d H:i:s");
$sql_koin = "select sum(koin) as total, sum(koin_vip) as total_vip from auth_user";
$stmt20 = $db->prepare($sql_koin);
$stmt20->execute();
foreach ($stmt20 as $row) {
    $sql_insert = "INSERT INTO `server_koin` (`date`, `koin`, `koin_vip`) VALUES ('{$today_timestamp}', {$row['total']}, {$row['total_vip']})";
    $db->exec($sql_insert);
}

