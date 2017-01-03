<?php

require('../Config.php');
require('db.class.php');
$limit = $_GET['limit'];
$sql = "select au.username, u.screen_name, au.koin from auth_user au left join user u on au.username = u.username order by koin desc limit 0,{$limit}";
$found = false;
$html = "<table width='100%'><tr style='background-color: rgb(255, 255, 255);text-align:center;font-weight:bold;'>";
$html .= "<td>STT</td><td>Username</td><td>Screen Name</td><td>Xu</td></tr>";
$i = 0;
foreach ($db->query($sql) as $row) {
    $i+=1;
    $found = true;
    $html .= "<tr style='background-color: rgb(" . ($i % 2 > 0 ? "204,204,204" : "255, 255, 255") . ");text-align:center;'>";
    $html .= "<td width='5%'>" . $i . "</td>";
    $html .= "<td width='20%'>" . $row['username'] . "</td>";
    $html .= "<td width='20%'>" . $row['screen_name'] . "</td>";
    $html .= "<td width='20%'>" . number_format($row['koin']) . "</td>";
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