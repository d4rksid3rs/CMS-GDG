<?php

require('../Config.php');
require('db.class.php');
$sql_10k = "select count(*) count from auth_user where koin <= 10000";
$sql_10k_100k = "select count(*) count from auth_user where koin >= 10000 AND koin <= 100000";
$sql_100k_1m = "select count(*) count from auth_user where koin >= 100000 AND koin <= 1000000";
$sql_1m_10m = "select count(*) count from auth_user where koin >= 1000000 AND koin <= 10000000";
$sql_10m_50m = "select count(*) count from auth_user where koin >= 10000000 AND koin <= 50000000";
$sql_50m_200m = "select count(*) count from auth_user where koin >= 50000000 AND koin <= 200000000";
$sql_over_200m = "select count(*) count from auth_user where koin > 200000000";

$rs1 = $db->prepare($sql_10k);
$rs1->execute();
$rs_10k = $rs1->fetch();

$rs2 = $db->prepare($sql_10k_100k);
$rs2->execute();
$rs_10k_100k = $rs2->fetch();

$rs3 = $db->prepare($sql_100k_1m);
$rs3->execute();
$rs_100k_1m = $rs3->fetch();

$rs4 = $db->prepare($sql_1m_10m);
$rs4->execute();
$rs_1m_10m = $rs4->fetch();

$rs5 = $db->prepare($sql_10m_50m);
$rs5->execute();
$rs_10m_50m = $rs5->fetch();

$rs6 = $db->prepare($sql_50m_200m);
$rs6->execute();
$rs_50m_200m = $rs6->fetch();

$rs7 = $db->prepare($sql_over_200m);
$rs7->execute();
$rs_over_200m = $rs7->fetch();

$html = "<table width='100%'>";
$html .= "<tr style='background-color: rgb(204,204,204);text-align:center;font-weight:bold;'>";
$html .= "<td></td><td><=10k</td><td>>10k&<=100k</td><td>>100k&<=1.000k</td><td>>1.000k&<=10.000k</td><td>>10.000k&<=50.000k</td><td>>50.000k&<=200.000k</td><td>>200.000k</td></tr>";
$html .= "<tr style='background-color: rgb(255,255,255);text-align:center;'>";
$html .= "<td width='5%'>Count</td>";
$html .= "<td width='10%'>" . number_format($rs_10k['count']) . "</td>";
$html .= "<td width='10%'>" . number_format($rs_10k_100k['count'] ). "</td>";
$html .= "<td width='10%'>" . number_format($rs_100k_1m['count']) . "</td>";
$html .= "<td width='10%'>" . number_format($rs_1m_10m['count'] ). "</td>";
$html .= "<td width='10%'>" . number_format($rs_10m_50m['count']) . "</td>";
$html .= "<td width='10%'>" . number_format($rs_50m_200m['count']) . "</td>";
$html .= "<td width='10%'>" . number_format($rs_over_200m['count']) . "</td>";
$html .= "</tr>";
echo $html;
