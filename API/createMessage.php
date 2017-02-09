<?php

require('../Config.php');
require('db.class.php');
if (!empty($_POST['username'])) {
    $username = $_POST['username'];
} else {
    echo "{\"status\":0,\"message\":\"Chưa nhập Username\"}";
    exit();
}

if (!empty($_POST['content'])) {
    $content = $_POST['content'];
} else {
    echo "{\"status\":0,\"message\":\"Chưa nhập Nội dung\"}";
    exit();
}
$username = mysql_escape_string($username);
$username = strtolower($username);
$content = mysql_escape_string($content);
try {
    $sql = "select * from auth_user where username='" . $username . "' limit 0,1";
    $found = false;
    foreach ($db->query($sql) as $row) {
        $userId = $row['id'];
        $mobile = $row['mobile'];
        $found = true;
    }
    if ($found) {        
        $sql = "INSERT INTO `feedback`(`user_id`, `user`, `mobile`, `feedback`) VALUES ('{$userId}','{$username}','{$mobile}','{$content}')";
        $db->exec($sql);
        $sql = "insert into user_message(user_id, sender_id, content,sender_name,title, message_type) values('" . $userId . "','" . __GMID . "','" . $content . "','admin','Trả lời góp ý', 1)";
        $db->exec($sql);
        $sql = "update user set notify_message=notify_message+1 where id='{$userId}'";
        $db->exec($sql);
        echo "{\"status\":1,\"message\":\"Gửi tin nhắn thành công\"}";
    } else {
        echo "{\"status\":0,\"message\":\"Không tìm thấy người chơi\"}";
        exit();
    }
} catch (Exception $ex) {
    echo "{\"status\":0,\"" . $ex->getMessage() . "\"}";
}