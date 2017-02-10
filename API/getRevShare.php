<?php

require('../Config.php');
require('db.class.php');
try {
    $found = false;
    include('Net/SSH2.php');

    $server = __HOST;
    $port = __PORT;
    $remote = "gdg";
    $password = "$#Fsda345#1z";
    $command = "ps";
    $log = '';
    $ssh = new Net_SSH2($server, $port, 100);
    if (!$ssh->login($remote, $password)) {
        exit('Login Failed');
    }
    $cmd = "python checkFeeVip.py";
    $log = $ssh->exec($cmd);

    $today = date("Y-m-d");

    $sql_total_sms = "SELECT SUM(money) AS total_money FROM log_nap_koin WHERE flag1 = 0 AND type = 1 AND date(created_on) = '{$today}'";
    $sql_total_card = "SELECT SUM(money) AS total_money FROM log_nap_koin WHERE flag1 = 0 AND type = 2 AND date(created_on) = '{$today}'";
    $sql_total_iap = "SELECT SUM(money) AS total_money FROM log_nap_koin WHERE flag1 = 0 AND type = 4 AND date(created_on) = '{$today}'";

    $stmt1 = $db->prepare($sql_total_sms);
    $stmt1->execute();
    $sms = $stmt1->fetch();
    $total_sms = $sms['total_money'];

    $stmt2 = $db->prepare($sql_total_card);
    $stmt2->execute();
    $card = $stmt2->fetch();
    $total_card = $card['total_money'];

    $stmt3 = $db->prepare($sql_total_iap);
    $stmt3->execute();
    $iap = $stmt3->fetch();
    $total_iap = $iap['total_money'];

    $fee_array = json_decode($log, true);
    $host_xoc_dia = $fee_array['HOSTXOCDIA'];
    $tlmn = $fee_array['TLMN'];
    $bacaych = $fee_array['BACAYCH'];
    $tlmndc = $fee_array['TLMNDC'];
    $host_bau_cua = $fee_array['HOSTBAUCUA'];
    $xoc_dia = $fee_array['XOCDIA'];
    $phom = $fee_array['PHOM'];
    $lieng = $fee_array['LIENG'];
    $sam = $fee_array['SAM'];
    $bau_cua = $fee_array['BAUCUA'];
    $xi_to = $fee_array['XITO'];
    $poker = $fee_array['POKER'];
    $ba_cay = $fee_array['BACAY'];

    // render table
    $html = "<table width='100%'><tr style='background-color: rgb(255, 255, 255);font-weight:bold;'>";
    $html .= "<td width='5%'>STT</td><td width='30%'>Game</td><td>Fee</td></tr>";
    $html .= "<tr><td>1</td><td>Tiến lên MN</td><td>" . number_format($tlmn) . "</td></td></tr>";
    $html .= "<tr><td>2</td><td>Ba cây Chương</td><td>" . number_format($bacaych) . "</td></td></tr>";
    $html .= "<tr><td>3</td><td>Tiến lên MN DC</td><td>" . number_format($tlmndc) . "</td></td></tr>";
    $html .= "<tr><td>4</td><td>Xóc Đĩa</td><td>" . number_format($xoc_dia) . "</td></td></tr>";
    $html .= "<tr><td>5</td><td>Phỏm</td><td>" . number_format($phom) . "</td></td></tr>";
    $html .= "<tr><td>6</td><td>Liêng</td><td>" . number_format($lieng) . "</td></td></tr>";
    $html .= "<tr><td>7</td><td>Sam</td><td>" . number_format($sam) . "</td></td></tr>";
    $html .= "<tr><td>8</td><td>Bầu Cua</td><td>" . number_format($bau_cua) . "</td></td></tr>";
    $html .= "<tr><td>9</td><td>Xi to</td><td>" . number_format($xi_to) . "</td></td></tr>";
    $html .= "<tr><td>10</td><td>Poker</td><td>" . number_format($poker) . "</td></td></tr>";
    $html .= "<tr><td>11</td><td>Ba Cây</td><td>" . number_format($ba_cay) . "</td></td></tr>";
    $html .= "</table>";
    echo $html;die;
    var_dump($total_sms);
    die;
    echo $log;
    die;
} catch (Exception $e) {
    echo $e->getMessage();
}
