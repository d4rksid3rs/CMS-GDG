<?php

require('../Config.php');
require('db.class.php');
$fromDate = $_GET['fromDate'];
$toDate = $_GET['toDate'];
$array_date = createDateRangeArray($fromDate, $toDate);
$today = date('Y-m-d', time());
$type = $_GET['type'];
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
    foreach ($array_date as $date) {
        if ($date == $today) {
            $date_str = '';
        } else {
            $date_str = '.' . $date;
        }
        if ($type == 1) {
            $cmd = "cat monaco/logs/money.log$date_str | grep BOOM_ > boom.txt";
            $money = "Xu";
        } else if ($type == 2) {
            $cmd = "cat monaco/logs/moneyvip.log$date_str | grep BOOM_ > boom.txt";
            $money = "Vàng";
        }
        $ssh->exec($cmd);
        $log .= $ssh->exec("cat boom.txt");
        $ssh->exec("rm boom.txt");
    }
    $i = 0;
    $lines = split("\n", $log);
    $html = "<table width='100%'><tr style='background-color: rgb(255, 255, 255);text-align:center;'>";
    $html .= "<td>Thời điểm</td><td>Username</td><td>Game</td><td>Thay đổi</td><td>Giá trị mới</td></tr>";
    foreach ($lines as $line) {
        $i++;
        if (!empty($line)) {
            $part = preg_split("/[\t]/", $line);
            $info = explode(' ', $part[1]);
            $time = $part[0];
            $count = count($info);
            $change = $info[$count - 1];
            $new_record = $info[$count - 2];
            $text_u = $info[$count-3];
            $username = substr($text_u, 2);
            $game = $info[$count-4];            
            $found = true;
            $html .= "<tr style='background-color: rgb(" . ($i % 2 > 0 ? "204,204,204" : "255, 255, 255") . ");text-align:center;'>";
            $html .= "<td width='5%'>" . $time . "</td>";
            $html .= "<td width='6%'>" . $username . "</td>";
            $html .= "<td width='6%'>" . $game . "</td>";
            $html .= "<td width='5%'>" . number_format($change) . "</td>";
            $html .= "<td width='5%'>" . number_format($new_record) . "</td>";            
            $html .= "</tr>";
        }
    }

    $html .= "</table>";    

    if ($found == true) {
        echo $html;
        exit;
    }
    if ($found == false) {
        echo "<b style='color:#fff;'>Không tìm thấy log!</b>";
    }
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
