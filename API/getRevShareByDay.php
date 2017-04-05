<?php

require('../Config.php');
require('db.class.php');
$fromDate = $_GET['fromDate'];
$toDate = $_GET['toDate'];
$array_date = createDateRangeArray($fromDate, $toDate);
$today = date('Y-m-d', time());

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

    $fee_game = 0;
    $bau_cua = 0;
    $xoc_dia = 0;
    $card_xu = 0;
    $gold_to_koin = 0;
    $boom = 0;
    $sms_xu = 0;
    $iap = 0;
    foreach ($array_date as $date) {
        if ($date != $today) {
            $sql1 = "select * from server_chip_daily where datecreate = '{$date}'";
            $stmt1 = $db->prepare($sql1);
            $stmt1->execute();
            $fee_chip_by_date = $stmt1->fetch();

            $sql2 = "select * from server_koin_daily where datecreate = '{$date}'";
            $stmt2 = $db->prepare($sql2);
            $stmt2->execute();
            $fee_koin_by_date = $stmt2->fetch();

            print_r($fee_chip_by_date);
//            var_dump($fee_koin_by_date);
            die;
        } else {
            $cmd = "cat monaco/logs/moneyvip.log$date_str | grep \" GOLDTOSILVER_PUT \" > GOLDTOSILVER_PUT.txt";

            $ssh->exec($cmd);
            $log .= $ssh->exec("cat GOLDTOSILVER_PUT.txt");
            $ssh->exec("rm GOLDTOSILVER_PUT.txt");
        }
    }
    $lines = split("\n", $log);
    $i = 0;
    $html = "<table width='100%'><tr style='background-color: rgb(255, 255, 255);text-align:center;'>";
    $html .= "<td>STT</td><td>Thời điểm</td><td>Nội dung</td></tr>";
    foreach ($lines as $line) {
        $i+=1;
        if (!empty($line)) {
            $part = preg_split("/[\t]/", $line);
            $content = $part[1];
            $time = $part[0];
            $html .= "<tr style='background-color: rgb(" . ($i % 2 > 0 ? "204,204,204" : "255, 255, 255") . ");text-align:center;'>";
            $html .= "<td width='5%'>" . $i . "</td>";
            $html .= "<td width='10%'>" . $time . "</td>";
            $html .= "<td>" . $content . "</td>";
            $html .= "</tr>";
        }
    }
    $html .= "</table>";

    echo $html;
    exit;
//    echo $log;
} catch (Exception $e) {
    echo $e->getMessage();
}

function createDateRangeArray($strDateFrom, $strDateTo) {
    // takes two dates formatted as YYYY-MM-DD and creates an
    // inclusive array of the dates between the from and to dates.
    // could test validity of dates here but I'm already doing
    // that in the main script

    $aryRange = array();

    $iDateFrom = mktime(1, 0, 0, substr($strDateFrom, 5, 2), substr($strDateFrom, 8, 2), substr($strDateFrom, 0, 4));
    $iDateTo = mktime(1, 0, 0, substr($strDateTo, 5, 2), substr($strDateTo, 8, 2), substr($strDateTo, 0, 4));

    if ($iDateTo >= $iDateFrom) {
        array_push($aryRange, date('Y-m-d', $iDateFrom)); // first entry
        while ($iDateFrom < $iDateTo) {
            $iDateFrom+=86400; // add 24 hours
            array_push($aryRange, date('Y-m-d', $iDateFrom));
        }
    }
    return $aryRange;
}
