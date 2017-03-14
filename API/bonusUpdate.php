<?php

require('../Config.php');
require('db.class.php');

$fromDate = $_GET['fromDate'] . " 00:00:00";
$toDate = $_GET['toDate'] . " 23:59:59";
try {
//        $sql = "SELECT * FROM `koin_deduct` WHERE `date_created` BETWEEN '$fromDate' AND '$toDate' AND `return_code` = 1";                
    $sql = "select bu.*, au.koin, au.koin_vip "
            . "from bonus_update bu join auth_user au on bu.username = au.username "
            . "where bu.date_created >= '{$fromDate}' and bu.date_created <= '{$toDate}'";

    //select koin, date(date) as day from server_koin where date(date) >= '2016-08-18' and date(date) <= '2016-09-07' 
    $found = false;
    $resultData = array();
    $html = "<table width='100%'><tr style='background-color: rgb(255, 255, 255);text-align:center;font-weight:bold;'>";
    $html .= "<td>STT</td><td>Username</td><td>Xu</td><td>Vàng</td><td>IP</td></tr>";
    $i = 0;
    foreach ($db->query($sql) as $row) {
        $i+=1;
        $found = true;
        $html .= "<tr style='background-color: rgb(" . ($i % 2 > 0 ? "204,204,204" : "255, 255, 255") . ");text-align:center;'>";
        $html .= "<td width='5%'>" . $i . "</td>";
        $html .= "<td width='20%'>" . $row['username'] . "</td>";
        $html .= "<td width='20%'>" . number_format($row['koin']) . "</td>";
        $html .= "<td width='20%'>" . number_format($row['koin_vip']) . "</td>";
        $html .= "<td width='20%'>" . $row['ip'] . "</td>";
        $html .= "</tr>";
    }
    $html .= "</table>";
    if ($found == true) {
        echo $html;
        exit;
    }
    if ($found == false) {
        echo "<b>Không tìm thấy dữ liệu</b>";
    }
} catch (Exception $e) {
    echo $e->getMessage();
}

