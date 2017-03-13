<?php
require('../Config.php');
require('db.class.php');
if ($_GET['date']) {
    $date = $_GET['date'];
}
if ($_GET['game']) {
    $game = $_GET['game']."_";
}
if ($_GET['fromHour']) {
    $fromHour = $_GET['fromHour'];
} else {
    $fromHour = '00:00:00';
}
if ($_GET['toHour']) {
    $toHour = $_GET['toHour'];
} else {
    $fromHour = '23:59:59';
}
//echo date_default_timezone_get();
$start_time = $date . ' ' . $fromHour;
$end_time = $date . ' ' . $toHour;
$fromHour_ts = strtotime($start_time);
$toHour_ts = strtotime($end_time);
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
    $ssh->exec("ls /home/gdg/monaco/logs/logBanChoi/" . $date . " > ls.txt");
    $list = $ssh->exec("cat ls.txt");
    $ssh->exec("rm ls.txt");
    $list_file = split("\n", $list);
    $html = "<table width='100%'><tr style='background-color: rgb(255, 255, 255);text-align:center;'>";
    $html .= "<td>STT</td><td>Game</td><td>Giờ</td><td>Bàn</td><td>Log</td></tr>";
    $i = 0;
    foreach ($list_file as $table) {
        if (isset($table)) {
            if (strpos($table, $game) !== false) {
                $file_name_array = explode('.', $table);
                $name = $file_name_array[0];
                $rs = explode('_', $name);
                $timestamp_mili = $rs[1];
                $timestamp = substr($timestamp_mili, 0, -3);
                if (( (int) $timestamp - $fromHour_ts >= 0) && ((int) $timestamp - $toHour_ts <= 0)) {
                    $i += 1;
                    $html .= "<tr style='background-color: rgb(" . ($i % 2 > 0 ? "204,204,204" : "255, 255, 255") . ");text-align:center;'>";
                    $html .= "<td width='5%'>" . $i . "</td>";
                    $html .= "<td width='20%'>" . convertGame($rs[0]) . "</td>";
                    $html .= "<td width='10%'>" . date("Y-m-d H:i:s", $timestamp) . "</td>";
                    $html .= "<td width='10%'>" . $rs[2] . "</td>";
                    $html .= "<td width='10%'><a data-file='" . $date . "/" . $table . "' href='#' class='showLogTable'><input type='button' value='Show Log' /></a> </td>";
                    $html .= "</tr>";
                }
            }
        }
    }


    $html .= "</table>";

    echo $html;
    exit;
//    echo $log;
} catch (Exception $e) {
    echo $e->getMessage();
}

function convertGame($game) {
    $result = "";
    switch ($game) {
        case "vipphom":
            $result = "Phỏm Vip";
            break;
        case "viptlmn":
            $result = "TLMN VIP";
            break;
        case "viptlmndc":
            $result = "TLMNDC VIP";
            break;
        case "vipxito":
            $result = "Xì tố VIP";
            break;
        case "viplieng":
            $result = "Liêng VIP";
            break;
        case "phom":
            $result = "Phỏm";
            break;
        case "tlmn":
            $result = "TLMN";
            break;
        case "tlmndc":
            $result = "TLMNDC";
            break;
        case "xito":
            $result = "Xì tố";
            break;
        case "lieng":
            $result = "Liêng";
            break;
    }
    return $result;
}
