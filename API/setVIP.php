<?php

require('../Config.php');
require('db.class.php');

if (!empty($_POST['username'])) {
    $username = $_POST['username'];
    $vip_type = $_POST['type'];
    
    $username = trim($username);
    $sql = "select * from auth_user where username='" . $username . "' limit 0,1";
    $found = false;
    
    foreach ($db->query($sql) as $row) {
        $found = true;
        $user_id = $row['id'];
    }
    if ($found) { 
        $sql = "update auth_user_vip set vip_type = '{$vip_type}' where auth_user_id = '{$user_id}'";
        $db->query($sql);
        echo "{\"status\":1,\"message\":\"Set VIP thành công!!!\"}";
    } else {
        echo "{\"status\":0,\"message\":\"Không tìm thấy User\"}";
    }
} else {
    echo "{\"status\":0,\"message\":\"Chưa nhập Username\"}";
    exit;
}
