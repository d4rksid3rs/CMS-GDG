<?php

require('../Config.php');
require('db.class.php');
if ($_GET['username']) {
    $username = $_GET['username'];
} else {
    echo "<b>Chưa nhập Username</b>";
    exit;
}
$fromDate = $_GET['fromdate'];
$toDate = $_GET['todate'];
$array_date = createDateRangeArray($fromDate, $toDate);
$today = date('Y-m-d', time());
$date = '';
if (isset($_GET{'page'})) {
    $page = $_GET{'page'};
} else {
    $page = 1;
}
if (!empty($_GET['date'])) {
    if ($today != $_GET['fromdate'])
        $date = '.' . $_GET['date'];
}
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
            $cmd = "cat monaco/logs/money.log$date_str | grep \" u_$username \" > $username.txt";
            $money = "Xu";
        } else if ($type == 2) {
            $cmd = "cat monaco/logs/moneyvip.log$date_str | grep \" u_$username \" > $username.txt";
            $money = "Vàng";
        }
        $ssh->exec($cmd);
        $log .= $ssh->exec("cat $username.txt");
        $ssh->exec("rm $username.txt");
    }

    $lines = split("\n", $log);
    $total_change = 0;
    foreach ($lines as $line1) {
        $str = explode(' ', $line1);
        if (isset($str[1])) {
            $change = (int) end($str);
            $total_change = $total_change + $change;
        }
            
    }
    $count = count($lines);
    $total_game = $count - 1;
//    $str1 = explode(' ', $lines[0]);
//    $str2 = explode(' ', $lines[$total_game - 1]);
//    $total_change = $str2[7] - $str1[7];
    $html = "<span style='font-weight: bold; color: #fff;'>Tổng số lần chơi: ".$total_game." ván | Tổng số tiền thay đổi: ".number_format($total_change)." ".$money."</span>";
    $html .= "<table width='100%'><tr style='background-color: rgb(255, 255, 255);text-align:center;'>";
    $html .= "<td>Thời điểm</td><td>Thay đổi</td><td>Giá trị mới</td><td>Lý do</td>";
    $i = 0;
    $limit = 20;
    $total = ceil($count / $limit);
    $start = $limit * ($page - 1);
    $end = $page * $limit;
    foreach ($lines as $line) {
        $i+=1;
        if ($i >= $start && $i <= $end) {
            if (!empty($line)) {
                $part = preg_split("/[\t]/", $line);
                $info = explode(' ', $part[1]);
                $time = $part[0];
                $count = count($info);
                $change = $info[$count - 1];
                $new_record = $info[$count - 2];
                unset($info[$count - 1]);
                unset($info[$count - 2]);
                unset($info[$count - 3]);
                $reason = implode(' ', $info);
                $found = true;
                $html .= "<tr style='background-color: rgb(" . ($i % 2 > 0 ? "204,204,204" : "255, 255, 255") . ");text-align:center;'>";
                $html .= "<td width='5%'>" . $time . "</td>";
                $html .= "<td width='5%'>" . $change . "</td>";
                $html .= "<td width='5%'>" . $new_record . "</td>";
                $html .= "<td width='6%'>" . $reason . "</td>";
                $html .= "</tr>";
            }
        }
    }


    $html .= "</table>";
    $html .= '<ul class="userStatPagination">';
    if ($page > 1) {
        //Go to previous page to show previous 10 items. If its in page 1 then it is inactive
        $html.= "<li><a class='pagination-link-log' href='#' page='" . ($page - 1) . "' type='" . $type . "' class='button'>Trước</a></li>";
    }
    for ($i = 1; $i <= $total; $i++) {
        if ($i == $page) {
            $html.= "<li class='current'>" . $i . "</li>";
        } else {
            $html.= "<li><a class='pagination-link-log' href='#' page='" . $i . "' type='" . $type . "'>" . $i . "</a></li>";
        }
    }
    if ($page != $total) {
        ////Go to previous page to show next 10 items.
        $html.= "<li><a class='pagination-link-log' href='#' page='" . ($page + 1) . "' type='" . $type . "' class='button'>Sau</a></li>";
    }
    $html .= '</ul>';
    
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
