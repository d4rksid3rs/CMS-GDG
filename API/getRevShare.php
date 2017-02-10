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

    $total_fee_game = $tlmn + $bacaych + $tlmndc + $xoc_dia + $phom + $lieng + $sam
            + $bau_cua + $xi_to + $poker + $ba_cay + $host_bau_cua + $host_xoc_dia;
    $rev_share = ($total_fee_game + $total_card) * 0.81 + $total_sms * 0.45 + $total_iap * 0.65;
    
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
    $html .= "<tr><td>12</td><td>Tiền Bầu Cua ăn</td><td>" . number_format($host_bau_cua) . "</td></td></tr>";
    $html .= "<tr><td>13</td><td>Tiền Xóc đĩa ăn</td><td>" . number_format($host_xoc_dia) . "</td></td></tr>";
    $html .= "<tr><td>14</td><td>Tổng <span style='font-weight:bold;color:red;'>(A)</span></td><td>" . number_format($total_fee_game) . "</td></td></tr>";
    $html .= "</table>";
    
    $html .= "<br />";
    $html .= "<table width='100%'><tr style='background-color: rgb(255, 255, 255);font-weight:bold;'>";
    $html .= "<td width='5%'>STT</td><td width='30%'>Doanh thu từ Người chơi nạp Xu</td><td>$$$</td></tr>";
    $html .= "<tr><td>1</td><td>SMS <span style='font-weight:bold;color:red;'>(B)</span></td><td>" . number_format($total_sms) . "</td></td></tr>";
    $html .= "<tr><td>2</td><td>Card <span style='font-weight:bold;color:red;'>(C)</span></td><td>" . number_format($total_card) . "</td></td></tr>";
    $html .= "<tr><td>3</td><td>IAP <span style='font-weight:bold;color:red;'>(D)</span></td><td>" . number_format($total_iap) . "</td></td></tr>";
    $html .= "<tr><td>4</td><td>Tổng DT Chia sẻ <span style='font-weight:bold;color:red;'>[(A + C) x0.81 + B x 0.45 + D x 0.65]</span></td><td>" . number_format($rev_share) . "</td></td></tr>";
    $html .= "</table>";       
} catch (Exception $e) {
    echo $e->getMessage();
}
