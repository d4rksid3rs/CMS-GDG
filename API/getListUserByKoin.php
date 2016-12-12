<?php

require('../Config.php');
require('db.class.php');
$balance_koin = $_GET['balance_koin'];
$range_koin = $_GET['range_koin'];
$start = 0;
$limit = 100;
if (isset($_GET{'page'})) {
    $page = $_GET{'page'};
    $start=($page-1)*$limit;
} else {
    $page = 1;
    
}

if (is_numeric($range_koin) && is_numeric($balance_koin)) {
    if ($balance_koin > $range_koin) {
        try {
            $start_koin = $balance_koin - $range_koin;
            $end_koin = $balance_koin + $range_koin;
            $sql = "SELECT auth_user.* FROM auth_user WHERE koin >= '$start_koin' AND koin <= '$end_koin' LIMIT $start, $limit";
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
                $html .= "<td width='25%'>" . $row['koin'] . "</td>";
                $html .= "<td width='25%'>" . $row['koin_vip'] . "</td>";
                $html .= "<td width='25%'>" . $row['created_on'] . "</td>";                
                $html .= "</tr>";
            }            
            $html .= "</table>";
            $rows = $db->query("SELECT auth_user.* FROM auth_user WHERE koin >= '$start_koin' AND koin <= '$end_koin'");
            $count = $rows->rowCount();
            $total = ceil($count / $limit);
            $html .= '<ul class="userStatPagination">';
            if ($page > 1) {
                //Go to previous page to show previous 10 items. If its in page 1 then it is inactive
                $html.= "<li><a class='pagination-link' href='#' page='" . ($page - 1) . "' balance_koin='".$balance_koin."' range_koin='".$range_koin."' class='button'>Trước</a></li>";
            }
            for ($i = 1; $i <= $total; $i++) {
                if ($i == $page) {
                    $html.= "<li class='current'>" . $i . "</li>";
                } else {
                    $html.= "<li><a class='pagination-link' href='#' page='" . $i . "' balance_koin='".$balance_koin."' range_koin='".$range_koin."'>" . $i . "</a></li>";
                }
            }
            if ($page != $total) {
                ////Go to previous page to show next 10 items.
                $html.= "<li><a class='pagination-link' href='#' page='" . ($page + 1) . "' balance_koin='".$balance_koin."' range_koin='".$range_koin."' class='button'>Sau</a></li>";
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
    } else {
        echo "<b>Khoảng Xu phải nhỏ hơn Số Xu</b>";
    }
} else {
    echo "<b>Chưa nhập số xu hoặc nhập sai</b>";
}
