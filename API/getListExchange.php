<?php

require('../Config.php');
require('db.class.php');
if ($_GET['fromDate'] && $_GET['toDate']) {
    $fromDate = $_GET['fromDate'];
    $toDate = $_GET['toDate'];


    try {
//        $sql = "SELECT * FROM `koin_deduct` WHERE `date_created` BETWEEN '$fromDate' AND '$toDate' AND `return_code` = 1";        
//        $sql = "SELECT * FROM `koin_deduct` WHERE date(date_created) >= '$fromDate' AND date(date_created) <= '$toDate' AND return_code = 1";        
        $sql = "SELECT * FROM `koin_deduct` WHERE date(date_created) >= '$fromDate' AND date(date_created) <= '$toDate'";        
//        echo $sql;die;
        //select koin, date(date) as day from server_koin where date(date) >= '2016-08-18' and date(date) <= '2016-09-07' 
        $found = false;
        $resultData = array();
        $html = "<table width='100%'><tr style='background-color: rgb(255, 255, 255);text-align:center;'>";
        $html .= "<td>STT</td><td>Username</td><td>Vàng</td><td>Thẻ</td><td>Trạng thái</td><td>Thời gian</td></tr>";
        $i = 0;
        foreach ($db->query($sql) as $row) {
            switch ($row['state']) {
                case 0:
                    $state = 'Chờ xử lý';
                    break;
                case 1: 
                    $state = 'Đã trả thưởng';
                    break;
                case 2:
                    $state = 'Đã từ chối và cộng bù';
                    break;
            }
            $i+=1;
            $found = true;
            $html .= "<tr style='background-color: rgb(" . ($i % 2 > 0 ? "204,204,204" : "255, 255, 255") . ");text-align:center;'>";
            $html .= "<td width='5%'>" . $i. "</td>";
            $html .= "<td width='10%'>" . $row['username'] . "</td>";
            $html .= "<td width='20%'>" . number_format($row['chip']) . "</td>";
            $html .= "<td width='20%'>" . number_format($row['value']) . "</td>";
            $html .= "<td width='20%'>" . $state . "</td>";
            $html .= "<td width='20%'>" . $row['date_created'] . "</td>";
            $html .= "</tr>";
        }
        $html .= "</table>";        
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
