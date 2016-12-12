<?php
define('USER', 'k2tek');
define('PASS', 'k2tek123456');
define('DB', 'beme_cp');
define('HOST', '10.0.0.2');

mysql_connect(HOST,USER,PASS) or die("loi ket noi toi may chu ne");
mysql_select_db(DB) or die("Ko ket noi duoc toi CSDL");


$sql = 'SELECT bemapk FROM download';
$rs = mysql_query($sql) or die("khong download duoc");

$row = mysql_fetch_array($rs);

echo "Download = ".$row["bemapk"];


echo "<br/><br/>";

mysql_select_db('gim_wap') or die("Ko ket noi duoc toi CSDL");

$sql2 = "SELECT count(*) as count FROM `user` where os_type = 'android'";

$rs2 = mysql_query($sql2) or die("khong download duoc");

$row2 = mysql_fetch_array($rs2);

echo "User = ".$row2["count"];

echo "<br/><br/>";
$avideo = file_get_contents("http://api.phang.mobi/stats/sms_avideo.php");

echo $avideo;