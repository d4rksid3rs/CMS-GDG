<?php

require('../Config.php');
require('db.class.php');
if ($_GET['fromDate'] && $_GET['toDate']) {
    $fromDate = $_GET['fromDate'] . " 00:00:00";
    $toDate = $_GET['toDate'] . " 23:59:59";
    $type = $_GET['type'];
    $limit = $_GET['limit'];
    try {
//        $sql = "SELECT * FROM `koin_deduct` WHERE `date_created` BETWEEN '$fromDate' AND '$toDate' AND `return_code` = 1";                
        $sql = "SELECT l.username, sum(l.money) as total, u.screen_name, u.mobile, u.cp FROM `log_nap_koin` l "
                . "LEFT JOIN  user u ON l.username = u.username "
                . "WHERE created_on >= '{$fromDate}' AND created_on <= '{$toDate}' AND type = {$type} group by username order by total desc LIMIT 0,{$limit}";

        //select koin, date(date) as day from server_koin where date(date) >= '2016-08-18' and date(date) <= '2016-09-07' 
        $found = false;
        $resultData = array();
        $html = "<table width='100%'><tr style='background-color: rgb(255, 255, 255);text-align:center;font-weight:bold;'>";
        $html .= "<td>STT</td><td>Username</td><td>Screen Name</td><td>Tổng Nạp</td><td>Mobile</td><td>CP</td></tr>";
        $i = 0;
        foreach ($db->query($sql) as $row) {
            $i+=1;
            $found = true;
            $html .= "<tr style='background-color: rgb(" . ($i % 2 > 0 ? "204,204,204" : "255, 255, 255") . ");text-align:center;'>";
            $html .= "<td width='5%'>" . $i . "</td>";
            $html .= "<td width='20%'>" . $row['username'] . "</td>";
            $html .= "<td width='20%'>" . $row['screen_name'] . "</td>";
            $html .= "<td width='20%'>" . number_format($row['total']) . "</td>";
            $html .= "<td width='20%'>" . $row['mobile'] . "</td>";
            $html .= "<td width='15%'>" . $row['cp'] . "</td>";
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
} else {
    echo "<b>Chưa nhập ngày</b>";
}
