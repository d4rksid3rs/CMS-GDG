<?php

require('../Config.php');
require('db.class.php');
if ($_GET['file_name']) {
    $file_name = $_GET['file_name'];
}
try {
    $found = false;
    include('Net/SSH2.php');
    date_default_timezone_set("Asia/Ho_Chi_Minh");
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
    $cat = $ssh->exec("cat /home/gdg/monaco/logs/logBanChoi/" . $file_name);
    $logs = split("\n", $cat);
    $html = "<table width='100%'><tr>";
    foreach($logs as $log) {
    $html .= $log."<br/>";
    }
    $html .= "</tr>";
    echo $html;
    exit();
} catch (Exception $e) {
    echo $e->getMessage();
}