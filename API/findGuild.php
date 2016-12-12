<?php
require('../Config.php');
require('db.class.php');
$guild_name = $_GET['guild_name'];
if (isset($guild_name) && strlen($guild_name) > 0) {
    try {
        $sql = "select * from guild where name='" . $guild_name . "' limit 0,1";
        $found = false;
        foreach ($db->query($sql) as $row) {
            $found = true;
            echo "{\"status\":1,\"name\":\"" . $row['name'] . "\",\"owner\":\"" . $row['owner'] . "\",\"icon\":\"" . $row['icon'] . "\"}";
        }
        if ($found == false) {
            echo "{\"status\":0,\"message\":\"Không tìm thấy bang trong DB\"}";
        }
    } catch (Exception $e) {
        echo "{\"status\":0,\"message\":\"" . $e->getMessage() . "\"}";
    }
} else {
    echo "{\"status\":0,\"message\":\"Chưa nhập bang\"}";
}
?>
