<?php

require('../Config.php');
require('db.class.php');

if (!empty($_POST['username'])) {
    $username = $_POST['username'];
} else {
    echo "{\"status\":0,\"message\":\"Chưa nhập Username\"}";
    exit;
}

if (!empty($_POST['pass'])) {
    $pass = $_POST['pass'];
} else {
    echo "{\"status\":0,\"message\":\"Chưa nhập Mật khẩu\"}";
    exit;
}

if (!empty($_POST['confirm_pass'])) {
    $confirm_pass = $_POST['confirm_pass'];
} else {
    echo "{\"status\":0,\"message\":\"Chưa nhập Xác nhận Mật khẩu\"}";
    exit;
}
if ($pass == $confirm_pass) {
    $username = trim($username);
    $sql = "select * from auth_user where username='" . $username . "' limit 0,1";
    $found = false;
    foreach ($db->query($sql) as $row) {
        $found = true;
    }
    if ($found) {
        $pass_hash = md5($pass);   
        $sql_change_pass = "update auth_user set password_hash='{$pass_hash}' where username='{$username}'";
        $db->query($sql_change_pass);
        echo "{\"status\":1,\"message\":\"Đổi Mật khẩu User thành công!!!\"}";
    } else {
        echo "{\"status\":0,\"message\":\"Không tìm thấy User\"}";
    }
} else {
    echo "{\"status\":0,\"message\":\"Mật khẩu và Xác nhận Mật khẩu không giống nhau\"}";
}