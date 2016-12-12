<?php

require('../Config.php');
require('db.class.php');

$type = $_GET['type'];
$num = 20;
if (isset($_GET['num'])) {
    $num =  $_GET['num'];
}
if ($type == 'vip') {
    $sql = "SELECT au.*, u.screen_name, u.vip, auv.vip_type, auv.sum_money FROM auth_user au JOIN user u ON au.username = u.username JOIN auth_user_vip auv ON au.id = auv.auth_user_id "
            . "ORDER BY  auv.vip_type DESC, au.koin_vip DESC LIMIT 0, {$num} ";
} else if ($type == 'chip') {
    $sql = "SELECT au.*, u.screen_name, u.vip FROM auth_user au JOIN user u ON au.username = u.username ORDER BY au.koin_vip DESC LIMIT 0, {$num}";
}
//echo $sql;die;
$users = array();
$i = 0;
foreach ($db->query($sql) as $row) {
    
    $users[$i]['username'] = $row['username'];
    $users[$i]['screen_name'] = $row['screen_name'];
    $users[$i]['vip'] = $row['vip'];
    $users[$i]['balancexu'] = $row['koin'];
    $users[$i]['balancechip'] = $row['koin_vip'];
    $i++;
}
//var_dump($users);die;
$json = json_encode($users);
echo $json;