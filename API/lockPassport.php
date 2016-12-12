<?php

require('../Config.php');
require('db.class.php');
$passport = $_GET['passport'];
$type = $_GET['type'];
if($type == 'lock')
{
	$cause = $_GET['cause'];
    try {
        $sql = "SELECT * FROM imei_lock WHERE passport = '$passport'";
        //echo $sql;
        $found = false;
        foreach ($db->query($sql) as $row) {
            $found = true;
        }
        if ($found == true) {
            echo 'Đã khoá passport này';
            exit;
        }
        if ($found == false) {
            $sql_i = "INSERT INTO imei_lock VALUES('$passport','$cause')";
            $db->query($sql_i);
            echo "Đã khoá passport: $passport ";
        }
    } catch (Exception $e) {
        echo $e->getMessage();
    }
} else if($type == 'unlock')
{
	try {
        $sql = "SELECT * FROM imei_lock WHERE passport = '$passport'";
        //echo $sql;
        $found = false;
        foreach ($db->query($sql) as $row) {
            $found = true;
        }
        if ($found == true) {
            $sql_i = "DELETE FROM imei_lock WHERE passport = '$passport'";
            $db->query($sql_i);
            echo 'Đã mở khoá passport này';
            exit;
        }
        if ($found == false) {
            echo "Không tìm thấy passport: $passport ";
        }
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}
?>
