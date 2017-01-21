<?php

require('../Config.php');
require('db.class.php');
if ($_GET['fromDate'] && $_GET['toDate']) {
    $fromDate = $_GET['fromDate'] . " 00:00:00";
    $toDate = $_GET['toDate'] . " 23:59:59";
    try {
//        $sql = "SELECT * FROM `koin_deduct` WHERE `date_created` BETWEEN '$fromDate' AND '$toDate' AND `return_code` = 1";                
        $sql = "select u.*, auv.sum_money from user u join auth_user_vip auv on u.id = auv.auth_user_id "
                . "where (u.date_created  >= '{$fromDate}' AND u.date_created <= '{$toDate}' AND auv.sum_money > 0)";
        $sql_count = "select count(u.username) count from user u join auth_user_vip auv on u.id = auv.auth_user_id "
                . "where (u.date_created  >= '{$fromDate}' AND u.date_created <= '{$toDate}' AND auv.sum_money > 0)";
        $total = $db->prepare($sql_count);

        $total->execute();

        $result = $total->fetch();
        $found = false;
        $resultData = array();
        $html ="<b style='color:#fff;'>Tổng User: ".$result['count']."</b><br />";
        $html .= "<table width='100%'><tr style='background-color: rgb(255, 255, 255);text-align:center;font-weight:bold;'>";
        $html .= "<td>STT</td><td>Username</td><td>Screen Name</td><td>Mobile</td><td>CP</td><td>Tổng nạp</td><td>Ngày giờ Đăng ký</td></tr>";
        $i = 0;
        foreach ($db->query($sql) as $row) {
            $i+=1;
            $found = true;
            $html .= "<tr style='background-color: rgb(" . ($i % 2 > 0 ? "204,204,204" : "255, 255, 255") . ");text-align:center;'>";
            $html .= "<td width='5%'>" . $i . "</td>";
            $html .= "<td width='10%'>" . $row['username'] . "</td>";
            $html .= "<td width='15%'>" . $row['screen_name'] . "</td>";
            $html .= "<td width='10%'>" . $row['mobile'] . "</td>";
            $html .= "<td width='5%'>" . $row['cp'] . "</td>";
            $html .= "<td width='15%'>" . number_format($row['sum_money']) . "</td>";
            $html .= "<td width='10%'>" . $row['date_created'] . "</td>";
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
