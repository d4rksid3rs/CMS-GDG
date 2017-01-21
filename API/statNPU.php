<?php

require('../Config.php');
require('db.class.php');
if ($_GET['fromDate'] && $_GET['toDate']) {
    $fromDate = $_GET['fromDate'] . " 00:00:00";
    $toDate = $_GET['toDate'] . " 23:59:59";
    try {
//        $sql = "SELECT * FROM `koin_deduct` WHERE `date_created` BETWEEN '$fromDate' AND '$toDate' AND `return_code` = 1";                
        $sql = "select u.username, u.screen_name, auv.sum_money, b.sms, c.card, d.iap from user u 
left join (select username, sum(money) as sms from log_nap_koin where type = 1 group by username) b on u.username = b.username
left join (select username, sum(money) as card from log_nap_koin where type = 2 group by username) c on u.username = c.username
left join (select username, sum(money) as iap from log_nap_koin where type = 4 group by username) d on u.username = d.username
join auth_user_vip auv on u.id = auv.auth_user_id 
where (u.date_created >= '{$fromDate}' AND u.date_created <= '{$toDate}' AND auv.sum_money > 0)";
        $sql_count = "select count(u.username) count from user u join auth_user_vip auv on u.id = auv.auth_user_id "
                . "where (u.date_created  >= '{$fromDate}' AND u.date_created <= '{$toDate}' AND auv.sum_money > 0)";
        $total = $db->prepare($sql_count);

        $total->execute();

        $result = $total->fetch();
        $found = false;
        $resultData = array();
        $html ="<b style='color:#fff;'>Tổng User: ".$result['count']."</b><br />";
        $html .= "<table width='100%'><tr style='background-color: rgb(255, 255, 255);text-align:center;font-weight:bold;'>";
        $html .= "<td>STT</td><td>Username</td><td>Screen Name</td><td>Mobile</td><td>CP</td>"
                . "<td>SMS</td><td>CARD</td><td>IAP</td><td>Tổng nạp</td><td>Ngày giờ Đăng ký</td></tr>";
        $i = 0;
        foreach ($db->query($sql) as $row) {
            $i+=1;
            $found = true;
            $html .= "<tr style='background-color: rgb(" . ($i % 2 > 0 ? "204,204,204" : "255, 255, 255") . ");text-align:center;'>";
            $html .= "<td width='5%'>" . $i . "</td>";
            $html .= "<td width='10%'>" . $row['username'] . "</td>";
            $html .= "<td width='10%'>" . $row['screen_name'] . "</td>";
            $html .= "<td width='10%'>" . $row['mobile'] . "</td>";
            $html .= "<td width='5%'>" . $row['cp'] . "</td>";
            $html .= "<td width='10%'>" . number_format($row['sms']) . "</td>";
            $html .= "<td width='10%'>" . number_format($row['card']) . "</td>";
            $html .= "<td width='10%'>" . number_format($row['iap']) . "</td>";
            $html .= "<td width='10%'>" . number_format($row['sum_money']) . "</td>";
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
