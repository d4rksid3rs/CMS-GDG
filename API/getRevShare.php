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

    $sql_total_sms = "SELECT SUM(money) AS total_money FROM log_nap_koin WHERE flag1 = 0 AND type = 1";
    $sql_total_card = "SELECT SUM(money) AS total_money FROM log_nap_koin WHERE flag1 = 0 AND type = 2";
    $sql_total_iap = "SELECT SUM(money) AS total_money FROM log_nap_koin WHERE flag1 = 0 AND type = 4";

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
    echo "<pre>";
    var_dump($fee_array);die;
    
    // render table
    $html = "<table width='100%'><tr style='background-color: rgb(255, 255, 255);text-align:center;font-weight:bold;'>";
        $html .= "<td>STT</td><td>Game</td><td></td>Fee</tr>";
        $html .= "<tr><td>1</td><td>Tiến lên MN</td><td></td></td>";
        $html .= "</table>";
    var_dump($total_sms);die;
    echo $log;
    die;
} catch (Exception $e) {
    echo $e->getMessage();
}
