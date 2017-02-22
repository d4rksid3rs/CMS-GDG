<?php

require('../Config.php');
require('db.class.php');

$fromDate = $_GET['fromDate'];
$toDate = $_GET['toDate'];
try {
    $found = false;
    include('Net/SSH2.php');
    $week = array();
    while (strtotime($fromDate) <= strtotime($toDate)) {
        $week[] = $fromDate;
        $fromDate = date("Y-m-d", strtotime("+1 day", strtotime($fromDate)));
    }

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
    foreach ($week as $day) {
        $day_convert = str_replace('-', '', $day);
        $cmd = "cat monaco/logs/cheatPlayer/log" . $day_convert . ".txt";
        $log .= $ssh->exec($cmd);
    }
    $lines = split("\n", $log);
    $i = 0;
    $html = "<table width='100%'><tr style='background-color: rgb(204, 204, 204);font-weight:bold;'>";
    $html .= "<td width='5%'>STT</td><td>Log</td></tr>";
    foreach ($lines as $line) {
        if ($line != '') {
            $i++;
            $html .= "<tr style='background-color: rgb(" . ($i % 2 > 0 ? "204,204,204" : "255, 255, 255") . ");text-align:left;'>";
            $html .= "<td>" . $i . "</td>";
            $html .= "<td>" . $line . "</td>";
            $html .= "</tr>";
        }
    }
    $html .= "</table>";
    echo $html;
    exit();
} catch (Exception $e) {
    echo $e->getMessage();
}
