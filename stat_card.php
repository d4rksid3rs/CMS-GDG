<?php
include 'cache_begin.php';
require_once 'util.php';

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$isSum = isset($_GET['sum']) ? TRUE : FALSE;

$cmonth = date('m', time());
$cyear = date('Y', time());

$fromDate = isset($_REQUEST['fromDate']) ? trim($_REQUEST['fromDate']) : (
        $isSum ? "$cyear-$cmonth-01" : date('Y-m-d', time() - 86400 * 2)
        );
$toDate = isset($_REQUEST['toDate']) ? trim($_REQUEST['toDate']) : (
        $isSum ? "$cyear-$cmonth-31" : date('Y-m-d', time())
        );


include 'connectdb_gimwap.php';


$where = "success = 1";
if (!empty($fromDate) AND ! empty($toDate)) {
    $where .= " and created_on between '$fromDate 00:00:00' and '$toDate 23:59:59'";
} else {
    $fromDate = $toDate = NULL;
}

// $where .= ' and cp not in ("'.implode('","', $OWNCARD_PARTNERS).'")';
$iss_arr = get_iss_arr();

if ($id === 0) {
    $title = 'Doanh thu thẻ cào';
    if ($isSum) {
        $title .= ' tổng hợp';
        $chart_data = get_sum_card_by_iss_val($where, TRUE);
    } else {
        $chart_data = get_cardmoney_by_date_iss_val($where, $iss_arr);
    }
    $chart_title = "Doanh thu thẻ cào (từ user) : $fromDate -> $toDate";
} else if ($id === 1) {
    
}
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

<?php if ($id == 0 AND ! $isSum): ?>

            <script type="text/javascript">
                google.load("visualization", "1", {packages: ["corechart"]});
                google.setOnLoadCallback(drawChart);
                function drawChart() {
                    var data = new google.visualization.DataTable();
                    data.addColumn('string', 'Ngày');
            <?php
            $rect_count = array();
            $row_count = array();

            $date_arr = array_keys($chart_data);
            $no_date = count($chart_data);
            for ($i = 0; $i < $no_date; $i++) {
                $date = $chart_data[$date_arr[$i]];
                $iss_str = '';
                for ($j = 0; $j < count($iss_arr); $j++) {
                    $iss = $iss_arr[$j];
                    $iss_str .= ", {$date[$iss]}";
                    $rect_count[$iss] += $date[$iss];
                }
                $row_count[$i] = "['{$date_arr[$i]}' $iss_str],";
            }


            foreach ($iss_arr as $r) {
                $v = number_format($rect_count[$r], 0);
                echo "data.addColumn('number', '$r : $v');";
            }
            ?>
                    data.addRows([
    <?php
    for ($i = 0; $i < $no_date; $i++) {
        echo $row_count[$i];
    }


    $chart_height = max($no_date * 80, 900);
    ?>
                    ]);

                    var options = {
                        title: <?php echo "'$chart_title'"; ?>,
                        vAxis: {title: 'Ngày', titleTextStyle: {color: 'red'}},
                        backgroundColor: {fill: "none"},
                        isStacked: true
                    };

                    var chart = new google.visualization.BarChart(document.getElementById('chart_div'));
                    chart.draw(data, options);
                }
            </script>

<?php elseif ($id == 0 AND $isSum): ?>

            <script type="text/javascript">
                google.load("visualization", "1", {packages: ["corechart"]});
                google.setOnLoadCallback(drawChart);
                function drawChart() {
                    var data = new google.visualization.DataTable();
                    data.addColumn('string', '');
    <?php
    $iss_arr = array_keys($chart_data);
    $no_iss = count($chart_data);
    foreach ($iss_arr as $r) {
        $v = number_format($chart_data[$r], 0);
        echo "data.addColumn('number', '$r : $v');";
    }
    ?>
                    data.addRows([
    <?php
    $iss_str = '';
    $total = 0;
    for ($i = 0; $i < $no_iss; $i++) {
        $iss = $iss_arr[$i];
        $val = $chart_data[$iss];
        $total += $val;
        $iss_str .= ", $val";
    }
    echo "['' $iss_str]";
    $chart_height = 900;
    ?>
                    ]);

                    var options = {
                        title: <?php $total = number_format($total, 0);
    echo "'$chart_title, total: $total'"; ?>,
                        vAxis: {title: '', titleTextStyle: {color: 'red'}},
                        backgroundColor: {fill: "none"}
                    };

                    var chart = new google.visualization.BarChart(document.getElementById('chart_div'));
                    chart.draw(data, options);
                }
            </script>

<?php endif; ?>

    </head>
    <body>
        <div class="pagewrap">
<?php require_once('topMenu.php'); ?>


            <div class="box grid">
                <?php require_once('topMenu.sub2.php'); ?>
                <div class="box_header"><a href="javascript:void(0);"><?php echo $title; ?></a></div>
                <div class="box_body">
                    <table width="100%">

<?php if ($id == 0): ?>

                            <div style="padding-left:10px;">
                                <form action="" method="post">
                                    Từ ngày
                                    <input type="text" id="datepicker1" name="fromDate" style="text-align: center; width: 100px;" value="<?php echo $fromDate; ?>"/> 
                                    (00:00:00)
                                    Tới ngày
                                    <input type="text" id="datepicker2" name="toDate" style="text-align: center; width: 100px;" value="<?php echo $toDate; ?>"/> 
                                    (23:59:59)
                                    <input type="submit" value="Cập nhật" class="input_button"/>
                                </form>
                            </div>
                            <div id="chart_div" style="width: 900px; height: <?php echo $chart_height; ?>px;"></div>

<?php elseif ($id == 1): ?>
<?php endif; ?>

                    </table>
                </div>
            </div>

        </div>
    </body>
</html>

<?php include 'cache_end.php'; ?>
