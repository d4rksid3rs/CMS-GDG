<?php
require('../Config.php');
require('db.class.php');
$username = $_GET['username'];
if (isset($username) && strlen($username) > 0) {
    try {
        $sql = "select * from user where username='" . $username . "' limit 0,1";
        $found = false;
        foreach ($db->query($sql) as $row) {
            $found = true;
            echo "{\"status\":1,\"avatar\":\"" . $row['avatar'] . "\"}";
        }
        if ($found == false) {
            echo "{\"status\":0,\"message\":\"Không tìm thấy username trong DB\"}";
        }
    } catch (Exception $e) {
        echo "{\"status\":0,\"message\":\"" . $e->getMessage() . "\"}";
    }
} else {
    echo "{\"status\":0,\"message\":\"Chưa nhập username\"}";
}
?>
