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
        $sql_dau = "select count(*) as total from user where last_login >= '{$fromDate}' AND last_login <= '{$toDate}' AND os_type like '%{$os}%'";
        $sql_pu = "select count(*) as total from user u 
            join log_nap_koin l on u.username = l.username 
            where l.created_on >= '{$fromDate}' AND l.created_on <= '{$toDate}' AND u.os_type like '%{$os}%'";

        $sql_rev = "SELECT SUM(money) AS total_money FROM log_nap_koin l "
                . "join user u on u.username = l.username "
                . "where (created_on >= '{$fromDate}' AND created_on <= '{$toDate}' AND u.os_type like '%{$os}%')";

        $rs1 = $db->prepare($sql_dau);
        $rs1->execute();
        $total_login = $rs1->fetch();

        $rs2 = $db->prepare($sql_rev);
        $rs2->execute();
        $total_rev = $rs2->fetch();

        $rs3 = $db->prepare($sql_pu);
        $rs3->execute();
        $total_pu = $rs3->fetch();
        $arpu = $total_rev['total_money'] / $total_login['total'];
        $arppu = $total_rev['total_money'] / $total_pu['total'];
        $stat_ingame = array(
            array(
                'NameStat' => 'ARPU',
                'Value' => $arpu
            ),
            array (
                'NameStat' => 'ARPPU',
                'Value' => $arppu
            )
        );
        $html = "<table width='100%'><tr style='background-color: rgb(255, 255, 255);text-align:center;font-weight:bold;'>";
        $html .= "<td>STT</td><td>Tên Chỉ số Ingame</td><td>Giá trị</td></tr>";
        $i = 0;
        foreach ($stat_ingame as $row) {
            $i+=1;
            $html .= "<tr style='background-color: rgb(" . ($i % 2 > 0 ? "204,204,204" : "255, 255, 255") . ");text-align:center;'>";
            $html .= "<td width='5%'>" . $i . "</td>";
            $html .= "<td width='10%'>" . $row['NameStat'] . "</td>";
            $html .= "<td width='10%'>" . number_format($row['Value']) . "</td>";
            $html .= "</tr>";
        }
        $html .= "</table>";
        echo $html;
        exit;
    } catch (Exception $e) {
        echo $e->getMessage();
    }
} else {
    echo "<b>Chưa nhập ngày</b>";
}

