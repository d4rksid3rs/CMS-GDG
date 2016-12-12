<?php

require('../Config.php');
require('db.class.php');
$username = $_GET['username'];
if (isset($username) && strlen($username) > 0) {
    try {
        $sql = "SELECT cause,lock_time,daily_bonus, passport,screen_name, mobile, no_charging, cp, os_type, client_version, client_ip, date_created, login_times, last_login, smsmoney, smsDate, iapmoney, iapDate, cardmoney, cardDate, ls.lastCard FROM user u LEFT JOIN user_block ON u.id = user_block.id "
                . "LEFT JOIN (SELECT username, sum(money) as smsmoney, created_on as smsDate FROM (SELECT * FROM log_nap_koin WHERE username='{$username}' ORDER BY created_on DESC) ln WHERE type = 1) l ON u.username = l.username "
                . "LEFT JOIN (SELECT username, sum(money) as cardmoney, created_on as cardDate, money as lastCard FROM (SELECT * FROM log_nap_koin WHERE username='{$username}' ORDER BY created_on DESC) ln WHERE type = 2) ls ON u.username = ls.username "
                . "LEFT JOIN (SELECT username, sum(money) as iapmoney, created_on as iapDate, money as lastCard FROM (SELECT * FROM log_nap_koin WHERE username='$username' ORDER BY created_on DESC) ln WHERE type = 4) lz ON u.username = lz.username WHERE u.username = '{$username}'";
//        echo $sql;
        $found = false;
        foreach ($db->query($sql) as $row) {
            $found = true;
            $farm = checkPassport($row['passport']) . " " . countPassport($row['passport']);
            $str = getTypeUser($row['daily_bonus']);
            $lockdate = strtotime($row['lock_time']);
            $curdate = mktime();
            $list_ip = json_decode($row['client_ip'], true);
//            var_dump($list_ip);die;
            $ips = implode(' | ', $list_ip);
            if ($row['lock_time'] == "" || ($lockdate - $curdate) < 0) {
                $row['lock_time'] = 'Không khoá';
            }
            if (strlen($row['screen_name']) < 1) {
                $row['screen_name'] = $username;
            }
            $user_info_array = array(
                'status' => 1,
                'lock_time' => $row['lock_time'].' | '.$row['cause'],
                'type' => $str,
                'farm' => $farm,
                'fullname' => $row['screen_name'],
                'mobile' => $row['mobile'],
                'cardmoney' => number_format($row['cardmoney']). ' vnđ',
                'iapmoney' => number_format($row['iapmoney']). ' vnđ',
                'smsmoney' => number_format($row['smsmoney']). ' vnđ',
                'cp' => $row['cp'],
                'version' => $row['os_type']. ' | '. $row['client_version'],
                'dateCreated' => $row['date_created'],
                'smsDate' => $row['smsDate'],
                'cardDate' => $row['cardDate']. ' | '.number_format($row['lastCard']). ' vnđ',
                'loginTimes' => $row['login_times'],
                'lastLogin' => $row['last_login'],
                'clientIP' => $ips,
            );
            $output = json_encode($user_info_array);
            echo $output;
//            echo "{\"lastLogin\":\"" . $row['last_login'] . "\",\"clientIP\":\"" . $row['client_ip'] . "\"}";
//            echo "{\"status\":1,\"lock_time\":\"" . $row['lock_time'] . " | " . $row['cause'] . "\",\"type\":\"$str\",\"farm\":\"$farm\",\"fullname\":\"" . $row['screen_name'] . "\",\"mobile\":\"" . $row['mobile'] . "\",\"cardmoney\":\"" . number_format($row['cardmoney']) . ' vnd' . "\",\"iapmoney\":\"" . number_format($row['iapmoney']) . ' vnd' . "\",\"smsmoney\":\"" . number_format($row['smsmoney']) . ' vnd' . "\",\"cp\":\"" . $row['cp'] . "\",\"version\":\"" . $row['os_type'] . " | " . $row['client_version'] . "\",\"dateCreated\":\"" . $row['date_created'] . "\",\"smsDate\":\"" . $row['smsDate'] . "\",\"cardDate\":\"" . $row['cardDate'] . " | " . number_format($row['lastCard']) . ' vnđ' . "\",\"loginTimes\":\"" . $row['login_times'] . "\",\"lastLogin\":\"" . $row['last_login'] . "\",\"clientIP\":\"" . $row['client_ip'] . "\"}";
            
        }
        if ($found == false) {
            echo "{\"status\":0,\"message\":\"Không tìm thấy username\"}";
        }
    } catch (Exception $e) {
        echo "{\"status\":0,\"message\":\"" . $e->getMessage() . "\"}";
    }
} else {
    echo "{\"status\":0,\"message\":\"Chưa nhập username\"}";
}

function countPassport($pp) {
    global $db;
    if ($pp != 'null' && $pp != 'unknown' && $pp != '' && $pp != NULL) {
        $sql = "SELECT COUNT(*) AS PPCOUNT FROM user WHERE passport = '$pp'";
        $i = 0;
        foreach ($db->query($sql) as $r)
            $i = $r['PPCOUNT'];
        return $i;
    } else
        return 0;
}

function checkPassport($pp) {
    global $db;
    $sql = "SELECT * FROM imei_lock WHERE passport = '$pp'";
    $found = false;
    $str = $pp;
    foreach ($db->query($sql) as $r) {
        $str = $r['passport'] . ' | ' . $r['cause'] . ' | ';
    }
    return $str;
}

function getTypeUser($type) {
    switch ($type) {
        case 0:
            $str = 'Chưa có imei';
            break;
        case 1:
            $str = 'Đã trùng imei';
            break;
        case 2:
            $str = 'Imei đầu tiên / Đăng ký SMS';
            break;
        case 3:
            $str = 'Account facebook';
            break;
        case 4:
            $str = 'Account appota';
            break;
        case 5:
            $str = 'Đã nạp tiền';
            break;
        case 6:
            $str = 'Account vtc online';
            break;
    }
    return $str;
}

//0; chua xac dinh - ban cu
//1: da trung imei
//2: imei dau tien
//3: facebook
//4: appota - chua imei
//5: trung imei - da nap tien
//6: vtcO chua trung imei
?>
