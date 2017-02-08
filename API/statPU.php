<?php

require('../Config.php');
require('db.class.php');
if ($_GET['fromDate'] && $_GET['toDate']) {
    $fromDate = $_GET['fromDate'] . " 00:00:00";
    $toDate = $_GET['toDate'] . " 23:59:59";
    $osType = $_GET['osType'];
    $os = '';
    switch ($osType) {
        case 1:
            $os = 'iphone';
            break;
        case 2:
            $os = 'android';
            break;
        default :
            $os = '';
            break;
    }
    try {
//        $sql = "SELECT * FROM `koin_deduct` WHERE `date_created` BETWEEN '$fromDate' AND '$toDate' AND `return_code` = 1";                
        $sql = "select l.*, sum(l.money) as sum_money, b.sms, c.card, d.iap, u.screen_name, u.cp, u.os_type,  u.mobile from log_nap_koin l 
join user u on l.username = u.username
left join (select username, sum(money) as sms from log_nap_koin where type = 1 group by username) b on u.username = b.username 
left join (select username, sum(money) as card from log_nap_koin where type = 2 group by username) c on u.username = c.username 
left join (select username, sum(money) as iap from log_nap_koin where type = 4 group by username) d on u.username = d.username 
where l.created_on >= '{$fromDate}' AND l.created_on <= '{$toDate}' AND u.os_type like '%{$os}%' group by l.username";
        $sql_count = "select count(DISTINCT (l.username)) count, sum(money) as total_money from log_nap_koin l join user u on l.username = u.username  
where l.created_on >= '{$fromDate}' AND l.created_on <= '{$toDate}' AND u.os_type like '%{$os}%'";
        $total = $db->prepare($sql_count);

        $total->execute();

        $result = $total->fetch();
        $found = false;
        $resultData = array();
        $html = "<b style='color:#fff;'>Tổng User: " . $result['count'] . " | Tổng Doanh thu: " . number_format($result['total_money']) . " VNĐ</b><br />";
        $html .= "<table width='100%'><tr style='background-color: rgb(255, 255, 255);text-align:center;font-weight:bold;'>";
        $html .= "<td>STT</td><td>Username</td><td>Screen Name</td><td>Mobile</td><td>CP</td>"
                . "<td>HĐH</td><td>SMS</td><td>CARD</td><td>IAP</td><td>Tổng nạp</td><td>Ngày giờ Đăng ký</td></tr>";
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
            $html .= "<td width='5%'>" . $row['os_type'] . "</td>";
            $html .= "<td width='10%'>" . number_format($row['sms']) . "</td>";
            $html .= "<td width='10%'>" . number_format($row['card']) . "</td>";
            $html .= "<td width='10%'>" . number_format($row['iap']) . "</td>";
            $html .= "<td width='10%'>" . number_format($row['sum_money']) . "</td>";
            $html .= "<td width='10%'>" . $row['created_on'] . "</td>";
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
