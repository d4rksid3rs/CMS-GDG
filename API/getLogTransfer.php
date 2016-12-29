<?php

require('../Config.php');
require('db.class.php');
if ($_GET['fromDate'] && $_GET['toDate']) {
    $fromDate = $_GET['fromDate']." 00:00:00";
    $toDate = $_GET['toDate']." 23:69:59";


    try {        
        $sql = "SELECT * FROM `log_chuyen_koin` WHERE date_created >= '$fromDate' AND date_created <= '$toDate'";        
//        echo $sql;die;
        //select koin, date(date) as day from server_koin where date(date) >= '2016-08-18' and date(date) <= '2016-09-07' 
        $found = false;
        $resultData = array();
        $html = "<table width='100%'><tr style='background-color: rgb(255, 255, 255);text-align:center;font-weight:bold;'>";
        $html .= "<td>STT</td><td>Tên Người chuyển</td><td>Tên Người nhận</td><td>Xu chuyển</td><td>Số xu cũ</td><td>Số xu mới</td><td>Mô tả</td><td>Ngày</td></tr>";
        $i = 0;
        $total = 0;
        foreach ($db->query($sql) as $row) {
            $i+=1;
            $found = true;
            $total = $total + $row['money_chuyen'];
            $html .= "<tr style='background-color: rgb(" . ($i % 2 > 0 ? "204,204,204" : "255, 255, 255") . ");text-align:left;'>";
            $html .= "<td width='5%'>" . $i. "</td>";
            $html .= "<td width='10%'>" . $row['user_send_name'] . "</td>";
            $html .= "<td width='10%'>" . $row['user_receive_name'] . "</td>";
            $html .= "<td width='10%'>" . number_format($row['money_chuyen']) . "</td>";
            $html .= "<td width='10%'>" . number_format($row['koin_sender_befor']) . "</td>";
            $html .= "<td width='10%'>" . number_format($row['koin_sender_after']) . "</td>";
            $html .= "<td width='10%'>" . $row['des'] . "</td>";
            $html .= "<td width='10%'>" . $row['date_created'] . "</td>";
            $html .= "</tr>";
        }
        $html .= "<tr style='background-color: #fff;'><td colspan='8'>Tổng: ".number_format($total)." Xu</td></tr>";
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
