<?php
require('../Config.php');
require('db.class.php');
$type = $_GET['type'];
if ($type == 1) { // version
	$version = $type = $_GET['version'];
	try {
        $sql = "select count(mobile) as total from user where client_version='" . $version . "'";
        foreach ($db->query($sql) as $row) {
            echo "{\"status\":1,\"total\":\"" . $row['total'] . "\"}";
        }
    } catch (Exception $e) {
        echo "{\"status\":0,\"message\":\"" . $e->getMessage() . "\"}";
    }
} else if ($type == 2) { // so lan dang nhap
	$times = $type = $_GET['times'];
	try {
        $sql = "select count(mobile) as total from user where login_times >= " . $times . "";
        foreach ($db->query($sql) as $row) {
            echo "{\"status\":1,\"total\":\"" . $row['total'] . "\"}";
        }
    } catch (Exception $e) {
        echo "{\"status\":0,\"message\":\"" . $e->getMessage() . "\"}";
    }
} else if ($type == 3) { // lan cuoi dang nhap
	$lastLogin = $type = $_GET['lastLogin'];
	try {
        $sql = "select count(mobile) as total from user where last_login >= '" . $lastLogin . "'";
        foreach ($db->query($sql) as $row) {
            echo "{\"status\":1,\"total\":\"" . $row['total'] . "\"}";
        }
    } catch (Exception $e) {
        echo "{\"status\":0,\"message\":\"" . $e->getMessage() . "\"}";
    }
}

?>
