<?php

require('../Config.php');
require('db.class.php');
$date = $_GET['date'];
$start = 0;
$limit = 40;
if (isset($_GET{'page'})) {
    $page = $_GET{'page'};
    $start = ($page - 1) * $limit;
} else {
    $page = 1;
}
try {
    $sql = "SELECT k.*, u.screen_name  FROM `koin_verify` k  LEFT JOIN user u ON k.username = u.username WHERE date(k.date_created) = '{$date}'  LIMIT $start, $limit";    
    $found = false;
    $resultData = array();
    $html = "<table width='100%'><tr style='background-color: rgb(255, 255, 255);text-align:center;'>";
    $html .= "<td>Username</td><td>Xu</td><td>Chip</td><td>Time</td>";
    $i = 0;
    foreach ($db->query($sql) as $row) {
        $i+=1;
        $found = true;
        $html .= "<tr style='background-color: rgb(" . ($i % 2 > 0 ? "204,204,204" : "255, 255, 255") . ");text-align:center;'>";
        $html .= "<td width='25%'>" . $row['username'] . "</td>";
        $html .= "<td width='25%'>" . $row['screen_name'] . "</td>";
        $html .= "<td width='25%'>" . $row['mobile'] . "</td>";
        $html .= "<td width='25%'>" . $row['chip'] . "</td>";
        $html .= "</tr>";
    }
    $html .= "</table>";
    $rows = $db->query("SELECT k.*, u.screen_name  FROM `koin_verify` k  LEFT JOIN user u ON k.username = u.username WHERE date(k.date_created) = '{$date}'");
    $count = $rows->rowCount();
    $total = ceil($count / $limit);    
    $html .= '<ul class="userStatPagination">';
    if ($page > 1) {
        //Go to previous page to show previous 10 items. If its in page 1 then it is inactive
        $html.= "<li><a class='pagination-link' href='#' page='" . ($page - 1) . "' class='button'>Trước</a></li>";
    }
    for ($i = 1; $i <= $total; $i++) {
        if ($i == $page) {
            $html.= "<li class='current'>" . $i . "</li>";
        } else {
            $html.= "<li><a class='pagination-link' href='#' page='" . $i . "'>" . $i . "</a></li>";
        }
    }
    if ($page != $total) {
        ////Go to previous page to show next 10 items.
        $html.= "<li><a class='pagination-link' href='#' page='" . ($page + 1) . "' class='button'>Sau</a></li>";
    }
    $html .= '</ul>';
    if ($found == true) {
        echo $html;
        exit;
    }
    if ($found == false) {
        echo "Không tìm thấy dữ liệu";
    }
} catch (Exception $e) {
    echo $e->getMessage();
}
