<?php

if (isset($_GET["username"])) {
    $username = $_GET["username"];
}

require('socket.php');
$service = 0xF900;
$input = "{}";
require('db.class.php');
$content = sendMessage($service, $input);
$jsonData = json_decode($content);
//print_r($decode);die;
$key = array("phom", "bacay", "bacaychuong", "tienlenmn", "tienlenmndc", "bing", "lieng", "sam", "baucua", 'xito', 'xocdia',
    "vipphom", "vipbacay", "vipbacaychuong", "viptienlenmn", "viptienlenmndc", "vipbing", "viplieng", "vipsam", "vipbaucua", 'vipxito', 'vipxocdia');
$value1 = array();
$value1["online"] = $jsonData->{"online"};
$value1["total"] = 0;
$value1["bot"] = $jsonData->{"bot"};
foreach ($key as $k) {
    $value1[$k]["online"] = 0;
    foreach ($jsonData->{$k}->{"room"} as $row) {
        $value1[$k]["online"] += $row->{"online"};
    }
    $value1[$k]["playingTable"] = $jsonData->{$k}->{"playingTable"};
    $value1["total"] += $value1[$k]["online"];
}
$online = $value1['online'] - $value1['bot'];
$total = $value1['total'] - $value1['bot'];
$current_time = date("Y-m-d H:i:s");
$sql = "INSERT INTO `user_online_history` (`type`, `dateOnline`, `online`, `total`, `times`) VALUES ('s1-All', '{$current_time}', '{$total}', '{$online}', '0'); ";
$db->query($sql);
if (isset($content) && strlen($content) > 1000) {
    $filename = "../sdata";
    $fh = fopen($filename, 'w') or die("can't open file");
    //file_put_contents($filename, $content);
    fwrite($fh, $content);
    fclose($fh);
    echo "ok";
} else {
    echo "false";
}
?>
