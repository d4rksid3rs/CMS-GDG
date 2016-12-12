<?php

require('../Config.php');
require('db.class.php');
if ($_GET['user']) {
    $username = $_GET['user'];
} else {
    echo "<b>Phải chọn 1 Người dùng</b>";
    exit;
}
$fromDate = $_GET['from'];
$toDate = $_GET['to'];

if (isset($_GET{'page'})) {
    $page = $_GET{'page'};
} else {
    $page = 1;
}
$limit = 30;

$start = $limit * ($page - 1);
$end = $page * $limit;
try {
    $found = false;
    $sql = "SELECT ma.*, m.screen_name, m.merchant_name FROM `merchant_add_koin` AS ma JOIN merchants AS m ON ma.username = m.username "
            . "WHERE date(date_created) >= '{$fromDate}' AND date(date_created) <= '{$toDate}' AND ma.created_by LIKE '{$username}' LIMIT $start, $limit ";
    $html = "<table width='100%'><tr style='background-color: rgb(255, 255, 255);text-align:center;'>";
    $html .= "<td>Tên Đại lý</td><td>Tên Hiển thị</td><td>VNĐ</td><td>Xu</td><td>Thời điểm</td>";
    $i = 0;
//    echo $sql;die;
    foreach ($db->query($sql) as $row) {
        $i+=1;
        $found = true;
        $html .= "<tr style='background-color: rgb(" . ($i % 2 > 0 ? "204,204,204" : "255, 255, 255") . ");text-align:center;'>";
        $html .= "<td>" . $row['merchant_name'] . "</td>";
        $html .= "<td>" . $row['screen_name'] . "</td>";
        $html .= "<td>" . $row['vnd'] . "</td>";
        $html .= "<td>" . $row['koin'] . "</td>";
        $html .= "<td>" . $row['date_created'] . "</td>";
        $html .= "</tr>";
    }
    $rows = $db->query("SELECT ma.*, m.screen_name, m.merchant_name FROM `merchant_add_koin` AS ma JOIN merchants AS m ON ma.username = m.username "
            . "WHERE date(date_created) >= '{$fromDate}' AND date(date_created) <= '{$toDate}' AND ma.created_by LIKE '{$username}'");
    $count = $rows->rowCount();
    $total = ceil($count / $limit);
    $html .= "</table>";
    $html .= '<ul class="userStatPagination">';
    if ($page > 1) {
        //Go to previous page to show previous 10 items. If its in page 1 then it is inactive
        $html.= "<li><a class='pagination-link-2' href='#' page='" . ($page - 1) . "' class='button'>Trước</a></li>";
    }
    for ($i = 1; $i <= $total; $i++) {
        if ($i == $page) {
            $html.= "<li class='current'>" . $i . "</li>";
        } else {
            $html.= "<li><a class='pagination-link-2' href='#' page='" . $i . "'>" . $i . "</a></li>";
        }
    }
    if ($page != $total) {
        ////Go to previous page to show next 10 items.
        $html.= "<li><a class='pagination-link-2' href='#' page='" . ($page + 1) . " class='button'>Sau</a></li>";
    }
    $html .= '</ul>';
    if ($found == true) {
        echo $html;
        exit;
    }
    if ($found == false) {
        echo "Không tìm thấy log!";
    }
//    echo $log;
} catch (Exception $e) {
    echo $e->getMessage();
}
