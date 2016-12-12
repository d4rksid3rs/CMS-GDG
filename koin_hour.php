<?php
//include 'cache_begin.php';
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
    $sql = "SELECT hour(created_on) as hour,date(created_on) created_on, sum(money) AS money FROM log_nap_koin WHERE date(created_on) = '$toDate' GROUP BY hour ORDER BY hour";
    $chart_data = array();
    //$sql2 = "SELECT type, sum(koin_added) koin_added, date(created_on) as day FROM log_nap_koin  where created_on >= '".$fromDate."' and created_on <= '".$toDate."' GROUP BY day, type order by created_on";
//    echo $sql3;
    $money = 0;
    foreach ($db->query($sql) as $row) {
        $chart_data[] = array('hour' => $row['hour'],
            'money' => $row['money'],
            'created_on' => $row['created_on']);

        $money += $row['money'];

        $chart_data2[] = array('hour' => $row['hour'],
            'money' => $money,
            'created_on' => $row['created_on']);
    }

//   var_dump($obj);
//   var_dump($chart_data);
} catch (Exception $e) {
    echo "Lỗi kết nối CSDL";
}
$title = "Thống kê doanh thu theo giờ";
?>
<!DOCTYPE html>
<html>
    <head>
        <title><?php echo $title; ?></title>
        <?php require('header.php'); ?>
        <script src="js/highcharts.js" type="text/javascript"></script>
        <script type="text/javascript" src="js/themes/grid.js"></script> 
        <script>
            var chart1;
            var chart2;
            $(document).ready(function () {
                $("#datepicker1").datepicker();
                $("#datepicker2").datepicker();
                //chart 1
                chart1 = new Highcharts.Chart({
                    chart: {
                        renderTo: 'chart-container-1',
                        defaultSeriesType: 'spline'
                    },
                    title: {
                        text: 'Doanh thu theo giờ ngày <?php echo date("d-m-Y", strtotime($toDate)); ?>'
                    },
                    xAxis: {
                        categories:
                                [
                                    //'Phỏm','TLMN','TLMN DC','TLMB','Poker','BacayCh','INVITE','Bacay','BacayMoi','Lieng','Sam','Binh','BuyItem'
<?php
foreach ($chart_data as $row) {
    echo "'" . $row['hour'] . " - " . ($row['hour'] + 1) . " giờ' , ";
}
?>
                                ]
                    },
                    yAxis: {
                        title: {
                            text: 'VNĐ'
                        }
                    },
                    series: [
<?php
$output = "";
foreach ($chart_data as $row) {
    $output .= "{name: '" . $row['created_on'] . "',";
    $output .= "data:[";
    foreach ($chart_data as $row2) {
        $output .= $row2['money'] . ",";
    }
    $output .= "]}, ";

    break;
}
echo substr($output, 0, -1);
?>
                    ]
                });

                //chart 2
                chart2 = new Highcharts.Chart({
                    chart: {
                        renderTo: 'chart-container-2',
                        defaultSeriesType: 'spline'
                    },
                    title: {
                        text: 'Doanh thu tích luỹ theo giờ ngày <?php echo date("d-m-Y", strtotime($toDate)) ?>'
                    },
                    xAxis: {
                        categories:
                                [
                                    //'Phỏm','TLMN','TLMN DC','TLMB','Poker','BacayCh','INVITE','Bacay','BacayMoi','Lieng','Sam','Binh','BuyItem'
<?php
foreach ($chart_data as $row) {
    echo "'0 - " . ($row['hour'] + 1) . " giờ' , ";
}
?>
                                ]
                    },
                    yAxis: {
                        title: {
                            text: 'VNĐ'
                        }
                    },
                    series: [
<?php
$output = "";
foreach ($chart_data2 as $row) {
    $output .= "{name: '" . $row['created_on'] . "',";
    $output .= "data:[";
    foreach ($chart_data2 as $row2) {
        $output .= $row2['money'] . ",";
    }
    $output .= "]}, ";

    break;
}
echo substr($output, 0, -1);
?>
                    ]
                });
            });
        </script> 
    </head>
    <body>
        <div class="pagewrap">
            <?php require('topMenu.php'); ?>


            <div class="box grid">
                <?php include('topMenu.sub2.php'); ?>
                <div class="box_header"><a href="javascript:void(0);"><?php echo "Thống kê doanh thu theo giờ (trước telco)"; ?></a></div>
                <div class="box_body">
                    <div style="padding-left:10px;">
                        <form action="" method="post">
                            Ngày
                            <input type="text" id="datepicker2" name="toDate" style="text-align: center; width: 100px;" value="<?php echo $toDate; ?>"/>
                            <input type="submit" value="Cập nhật" class="input_button"/>
                        </form>
                    </div>

                    <br />
                    <div id="chart-container-1" style="width: <?php echo $size; ?>; height: 350px"></div>
                    <br><br>

                    <div id="chart-container-2" style="width: <?php echo $size; ?>; height: 350px"></div>
                </div>
            </div>
        </div>

    </body>
</html>
<?php
// include 'cache_end.php'; ?>