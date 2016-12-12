<?php
require('API/db.class.php');
$fromDate = $_REQUEST['fromDate'];
$toDate = $_REQUEST['toDate'];

if (!isset($fromDate)) {
    $fromDate = date('Y-m-d', time());
    $newdate = strtotime('-10 day', strtotime($fromDate));
    $fromDate = date('Y-m-d', $newdate);
}
if (!isset($toDate)) {
    $toDate = date('Y-m-d', time());
}
try {
    $sql = "select username, koin, date_created as day, cause from admin_add_koin where date(date_created) >= '" . $fromDate . "' and date(date_created) <= '" . $toDate . "' order by date_created DESC";
    $sql2 = "select sum(koin) as total from admin_add_koin where date(date_created) >= '" . $fromDate . "' and date(date_created) <= '" . $toDate . "' order by date_created DESC";
    //echo $sql;
    $chart_data = array();

    foreach ($db->query($sql) as $row) {
        $data[] = array('day' => $row['day'],
            'koin' => $row['koin'], 'username' => $row['username'], 'cause' => $row['cause']);
    }
    foreach ($db->query($sql2) as $row) {
        $html = "Tổng: " . number_format($row['total'], 0, ",", ".") . ' Xu';
    }
    //var_dump($rec_arr);
} catch (Exception $e) {
    echo "Lỗi kết nối CSDL";
}
$title = 'Lượng koin nạp từ admin'
?>
<!DOCTYPE html>
<html>
    <head>
        <title><?php echo $title; ?></title>
        <?php require('header.php'); ?>
        <script>
            $(document).ready(function () {
                $("#datepicker1").datepicker();
                $("#datepicker2").datepicker();
            });
        </script>


    </head>
    <body>
        <div class="pagewrap">
            <?php require('topMenu.php'); ?>


            <div class="box grid">
                <?php include('topMenu.trans.php'); ?>
                <div class="box_header"><a href="javascript:void(0);"><?php echo "Thống kê tiền fee"; ?></a></div>
                <div class="box_body">
                    <table width="100%">


                        <div style="padding-left:10px;">
                            <form action="" method="post">
                                Từ ngày
                                <input type="text" id="datepicker1" name="fromDate" style="text-align: center; width: 100px;" value="<?php echo $fromDate; ?>"/> 
                                (00:00:00)
                                Tới ngày
                                <input type="text" id="datepicker2" name="toDate" style="text-align: center; width: 100px;" value="<?php echo $toDate; ?>"/> 
                                (23:59:59)
                                <input type="submit" value="Cập nhật" class="input_button"/>
                                <span id="total-koin" style="font-weight: bold; color: #fff;"><?php echo $html;?></span>
                            </form>
                        </div>
                        <div style="width: 900px; height: <?php echo $chart_height; ?>px;"></div>
                        <table border="1" width="100%">
                            <tr>
                                <td>Tài khoản</td>
                                <td>Xu</td>
                                <td>Lý do</td>
                                <td>Ngày</td>
                            </tr>
                            <?php
                            $sum = 0;
                            foreach ($data as $val) {
                                ?>
                                <tr>
                                    <td><?php echo $val['username'] ?></td>
                                    <td><?php echo $val['koin'] ?></td>
                                    <td><?php echo $val['cause'] ?></td>
                                    <td><?php echo $val['day'] ?></td>
                                </tr>
                                <?php
                                $sum += $val['koin'];
                            }
                            ?>
                            <tr>
                                <td colspan="4">
                                    Tổng Xu: <?php echo $sum; ?>
                                </td>
                            </tr>
                        </table>


                    </table>
                </div>
            </div>

        </div>
    </body>
</html>

