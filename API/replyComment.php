<?php

require('../Config.php');
require('db.class.php');
$type = $_GET['type'];
if ($type == "reply") {
    try {
        $id = $_GET['id'];
        $userId = $_GET['userId'];
        $content = $_GET['content'];
        $content = mysql_escape_string($content);        
        if (isset($content) && strlen($content) > 0) {
            $sql = "update feedback f set f.status=1,f.feedback=concat(f.feedback,' -> $content') where f.id=" . $id;
            $db->exec($sql);
            $sql = "insert into user_message(user_id, sender_id, content,sender_name,title, message_type) values('" . $userId . "','" . __GMID . "','" . $content . "','admin','Trả lời góp ý', 1)";
            $db->exec($sql);
            $sql = "update user set notify_message=notify_message+1 where id='{$userId}'";
            $db->exec($sql);
            echo "{\"status\":1,\"message\":\"Cập nhật thành công\"}";
        } else {
            echo "{\"status\":0,\"message\":\"Chưa nhập thông tin góp ý\"}";
        }
    } catch (Exception $e) {
        echo "{\"status\":0,\"" . $e->getMessage() . "\"}";
    }
} else if ($type == "disable") {
    try {
        $id = $_GET['id'];
        $sql = "update feedback set status=1 where id=" . $id;
        if (isset($id) && $id != 0) {
            $db->exec($sql);
            echo "{\"status\":1,\"message\":\"Cập nhật thành công\"}";
        } else {
            echo "{\"status\":0,\"message':'Chưa nhập thông tin góp ý\"}";
        }
    } catch (Exception $e) {
        echo "{\"status\":0,\"message\":\"" . $e->getMessage() . "\"}";
    }
}
?>
