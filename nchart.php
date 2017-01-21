<?php

function startsWith($haystack, $needle) {
    return !strncmp($haystack, $needle, strlen($needle));
}

require('API/db.class.php');
$fromDate = $_GET['fromDate'];
$toDate = $_GET['toDate'];
if (!isset($fromDate)) {
    $fromDate = date('Y-m-d', time());
}
if (!isset($toDate)) {
    $toDate = date('Y-m-d', time());
}
try {
    $sql = "select type, hour(dateOnline) as hourTime, sum(online)/count(*) as online, sum(total)/count(*) as total from user_online_history where date(dateOnline) >= '" . $fromDate . "' and date(dateOnline) <= '" . $toDate . "' group by type,hour(dateOnline) order by hour(dateOnline)";
    $sql_avg = "select avg(total) as avg from user_online_history where date(dateOnline) >= '{$fromDate}' and date(dateOnline) <= '{$toDate}'";
    $total = $db->prepare($sql_avg);
    $total->execute();
    $result = $total->fetch();
    $users = array();
    foreach ($db->query($sql) as $row) {
        $type = $row['type'];
        if (startsWith($type, "s1")) {
            $type = substr($type, 3);
            if ($type == 'All') {
                $type = 'Tổng người chơi trong Phòng';
                $users[$type][] = array('hour' => $row['hourTime'], 'online' => round($row['online']), 'total' => round($row['total']));
            }
        } else if (startsWith($type, "s2")) {
            $type = substr($type, 3);
            if ($type == 'All') {
                $type = 'Beme 2';
                $users[$type][] = array('hour' => $row['hourTime'], 'online' => $row['online']);
            }
        }
        /* else if (startsWith($type, "s3")) {
          $type = substr($type,3);
          if ($type == 'All') {
          $type = 'Trà Đá';
          $users[$type][] = array('hour' => $row['hourTime'], 'online' => $row['online']);
          }
          } */
    }
    $size = 1000;
    foreach ($users as $key => $value) {
        if ($size > sizeof($value)) {
            $size = sizeof($value);
        }
    }

    foreach ($users as $key => $value) {
        if ($size < sizeof($value)) {
            array_pop($value);
        }
    }
//                echo '<pre>';
//                print_r($users);
//                echo '</pre>';
//                die;
} catch (Exception $e) {
    echo "Lỗi kết nối CSDL";
}
$output = "";
$tmp = array();
//var_dump($users);die;
foreach ($users as $key => $val) {
//while (list($key, $val) = each($users)) {
    $output = $output . "{name: '" . $key . "',";
    $output = $output . "data:[";

    $count = 0;
    $op = "";
    foreach ($val as $item) {
        $op = $op . "," . $item['online'];
        $tmp[$count] += $item['total'];
        $count++;
    }
    $op = substr($op, 1);

    $output = $output . $op . "]},";
}
$all = $all . "{name: 'Tổng người chơi',";
$all = $all . "data:[";
$op = "";
for ($i = 0; $i < sizeof($tmp); $i++) {
    $op = $op . "," . $tmp[$i];
}
$op = substr($op, 1);
$all = $all . $op . "]}";

//$output = substr($output,0, strlen($output)-1);
$chart = $output . $all;
?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>User Online History Chart</title>
        <script src="js/jquery-1.5.1.min.js" type="text/javascript"></script>
        <script src="js/highcharts.js" type="text/javascript"></script>
        <script type="text/javascript" src="js/themes/grid.js"></script>
        <script>
            var chart1; // globally available
            $(document).ready(function () {
                chart1 = new Highcharts.Chart({
                    chart: {
                        renderTo: 'chart-container-1',
                        defaultSeriesType: 'spline'
                    },
                    title: {
                        text: 'Game Dân gian'
                    },
                    xAxis: {
                        categories: ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '24']
                    },
                    yAxis: {
                        title: {
                            text: 'Quantity'
                        }
                    },
                    series: [<?php echo $chart; ?>]
                });
            });
        </script>
    </head>
    <body>
        <div id="chart-container-1" style="width: 100%; height: 350px">

        </div>
        <span style="font-weight: bold;">CCU Trung bình: <?php echo round($result['avg']); ?></span>
<?php //echo $output;   ?>
    </body>
</html>
