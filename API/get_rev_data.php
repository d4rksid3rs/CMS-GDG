<?php

//error_reporting(-1);
//ini_set('display_errors', 'On');
require('db.class.php');
//$end_date = date('Y-m-d');
//
//$end_date = date("Y-m-d", strtotime("-1 day", strtotime($end_date)));
//
////$date_start = date ("Y-m-d",strtotime("yesterday"));
//
//$date_start = date("Y-m-d", strtotime("-7 day", strtotime($end_date)));
//
//$start_date = $date_start;
//
//$week = array();
//while (strtotime($date_start) < strtotime($end_date)) {
//    $date_start = date("Y-m-d", strtotime("+1 day", strtotime($date_start)));
//    $week[] = $date_start;
//}

$today = date('Y-m-d');
$yesterday = date("Y-m-d", strtotime("-1 day", strtotime($today)));
$yesterday_start = $yesterday . ' 00:00:00';
$yesterday_end = $yesterday . ' 23:59:59';
$sql = "select l.type, sum(l.money) total, l.flag1 from log_nap_koin l "
        . "left join user u on l.username = u.username "
        . "where u.cp != 'test' AND created_on >= '{$yesterday_start}' AND created_on <= '{$yesterday_end}' group by type, flag1";
$stmt = $db->prepare($sql);
$stmt->execute();
$total_chip = $total_xu = 0;
if ($stmt->rowCount() > 0) {
    foreach ($stmt as $row) {
        if ($row['flag1'] == 1) {
            $type_koin = 'Chip';
        }
        if ($row['flag1'] == 0) {
            $type_koin = 'Xu';
        }
        $sql_insert = "INSERT INTO revenue (date_created, type, partner, k2, mv, total, type_koin) VALUES ('{$yesterday}', '{$row['type']}', 'partner', '0', '0', '{$row['total']}', '{$type_koin}')";        
        $db->exec($sql_insert);
    }

    echo 'Success !!!!';
} else {
    $sql_insert = "INSERT INTO revenue (date_created, type, partner, k2, mv, total) VALUES ('{$yesterday}', '0', 'partner', '0', '0', '')";
    $db->exec($sql_insert);
    echo 'No Money for Today !!';
}
