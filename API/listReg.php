<?php

require('../Config.php');
require('db.class.php');
$fromDate = $_GET['fromDate'];
$toDate = $_GET['toDate'];
$start = 0;
$limit = 30;
if (isset($_GET{'page'})) {
    $page = $_GET{'page'};
    $start = ($page - 1) * $limit;
} else {
    $page = 1;
}
$type = $_GET['type'];

try {
    $fromDate = $fromDate . ' 00:00:00';
    $toDate = $toDate . ' 23:59:59';
    if ($type == 1) {
        $sql = "select * from user where date_created >= '$fromDate' AND date_created <= '$toDate' order by date_created DESC LIMIT $start, $limit";
        $found = false;
        $resultData = array();
        $html = "<table width='100%'><tr style='background-color: rgb(255, 255, 255);text-align:center;'>";
        $html .= "<td>Username</td><td>Screen Name</td><td>Ngày tạo</td></tr>";
        $i = 0;
        foreach ($db->query($sql) as $row) {
            $i+=1;
            $found = true;
            $html .= "<tr style='background-color: rgb(" . ($i % 2 > 0 ? "204,204,204" : "255, 255, 255") . ");text-align:center;'>";
            $html .= "<td width='25%'>" . $row['username'] . "</td>";
            $html .= "<td width='25%'>" . $row['screen_name'] . "</td>";
            $html .= "<td width='25%'>" . $row['date_created'] . "</td>";
            $html .= "</tr>";
        }
        $html .= "</table>";
        $rows = $db->query("select * from user where date_created >= '$fromDate' AND date_created <= '$toDate'");
        $count = $rows->rowCount();
        $total = ceil($count / $limit);
        $html .= '<ul class="userStatPagination">';
        if ($page > 1) {
            //Go to previous page to show previous 10 items. If its in page 1 then it is inactive
            $html.= "<li><a class='user-reg-pagination-link' href='#' page='" . ($page - 1) . "' class='button'>Trước</a></li>";
        }
        for ($i = 1; $i <= $total; $i++) {
            if ($i == $page) {
                $html.= "<li class='current'>" . $i . "</li>";
            } else {
                $html.= "<li><a class='user-reg-pagination-link' href='#' page='" . $i . "' >" . $i . "</a></li>";
            }
        }
        if ($page != $total) {
            ////Go to previous page to show next 10 items.
            $html.= "<li><a class='user-reg-pagination-link' href='#' page='" . ($page + 1) . "' class='button'>Sau</a></li>";
        }
        $html .= '</ul>';
        if ($found == true) {
            echo $html;
            exit;
        }
        if ($found == false) {
            echo "<span style='font-weight:bold; color: #fff;'>Không tìm thấy dữ liệu</span>";
        }
    }
    if ($type == 2) {
        $sql = "select * from user where date_created >= '$fromDate' AND date_created <= '$toDate' group by passport order by date_created DESC LIMIT $start, $limit";
        $found = false;
        $resultData = array();
        $html = "<table width='100%'><tr style='background-color: rgb(255, 255, 255);text-align:center;font-weight: bold'>";
        $html .= "<td>Passport</td><td>List User</td></tr>";
        $i = 0;
        foreach ($db->query($sql) as $row) {
            $i+=1;
            $found = true;
            $passport = $row['passport'];
            $sql2 = "select * from user where passport = '$passport'";
            $html .= "<tr style='background-color: rgb(" . ($i % 2 > 0 ? "204,204,204" : "255, 255, 255") . ");text-align:left;'>";
            $html .= "<td width='20%'>" . $row['passport'] . "</td>";
            $html .= "<td width='50%'><input class='show-bypassport' data-index='" . $i . "' type='button' value='Show' /> &nbsp "
                    . "<input class='hide-bypassport' data-index='" . $i . "' type='button' value='Hide' style='display:none;' /> <br />"
                    . "<div id='content-passport-" . $i . "' style='display:none;'>";
            $html .= "<table style='border: solid 1px #000'><tr style='text-align:center;font-weight: bold'>";
            $html .= "<td>Username</td><td>Screen Name</td><td>Ngày tạo</td></tr>";
            foreach ($db->query($sql2) as $row2) {
                $html .= "<tr style='background-color: rgb(" . ($i % 2 > 0 ? "204,204,204" : "255, 255, 255") . ");text-align:left;'>";
                $html .= "<td width='20%'>" . $row['username'] . "</td>";
                $html .= "<td width='10%'>" . $row['screen_name'] . "</td>";
                $html .= "<td width='20%'>" . $row['date_created'] . "</td></tr>";
            }
            $html .="</div></td>";
            $html .= "</tr></table>";
        }
        $html .= "</table>";
        $rows = $db->query("select * from user where date_created >= '$fromDate' AND date_created <= '$toDate' group by passport");
        $count = $rows->rowCount();
        $total = ceil($count / $limit);
        $html .= '<ul class="userStatPagination">';
        if ($page > 1) {
            //Go to previous page to show previous 10 items. If its in page 1 then it is inactive
            $html.= "<li><a class='user-reg-pagination-link' href='#' page='" . ($page - 1) . "' class='button'>Trước</a></li>";
        }
        for ($i = 1; $i <= $total; $i++) {
            if ($i == $page) {
                $html.= "<li class='current'>" . $i . "</li>";
            } else {
                $html.= "<li><a class='user-reg-pagination-link' href='#' page='" . $i . "' >" . $i . "</a></li>";
            }
        }
        if ($page != $total) {
            ////Go to previous page to show next 10 items.
            $html.= "<li><a class='user-reg-pagination-link' href='#' page='" . ($page + 1) . "' class='button'>Sau</a></li>";
        }
        $html .= '</ul>';
        if ($found == true) {
            echo $html;
            exit;
        }
        if ($found == false) {
            echo "<span style='font-weight:bold; color: #fff;'>Không tìm thấy dữ liệu</span>";
        }
    }
} catch (Exception $e) {
    echo $e->getMessage();
}
