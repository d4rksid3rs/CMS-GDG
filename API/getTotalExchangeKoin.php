<?php

require('../Config.php');
require('db.class.php');
if ($_GET['fromDate'] && $_GET['toDate']) {
    $fromDate = $_GET['fromDate'];
    $toDate = $_GET['toDate'];
    $type = $_GET['type'];

    try {
//        $sql = "SELECT * FROM `koin_deduct` WHERE `date_created` BETWEEN '$fromDate' AND '$toDate' AND `return_code` = 1";        
        if ($type == 1) {
            $sql = "SELECT SUM(chip) as total FROM `koin_deduct` WHERE date(date_created) >= '$fromDate' AND date(date_created) <= '$toDate'";
        } else {
            $sql = "SELECT SUM(coin) as total FROM `koin_add_deducterror` WHERE date(date_created) >= '$fromDate' AND date(date_created) <= '$toDate'";
        }
        //select koin, date(date) as day from server_koin where date(date) >= '2016-08-18' and date(date) <= '2016-09-07' 
        $found = false;

        foreach ($db->query($sql) as $row) {
            $found = true;
            $html = "Tổng: " . number_format($row['total'], 0, ",", ".") . ' Vàng';
        }
        if ($found == true) {
            echo $html;
            exit;
        }
        if ($found == false) {
            echo "Không tìm thấy dữ liệu";
        }
    } catch (Exception $e) {
        echo $e->getMessage();
    }
} else {
    echo "<b>Chưa nhập ngày</b>";
}
