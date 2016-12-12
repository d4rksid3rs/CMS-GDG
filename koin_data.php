<?php
require('API/db.class.php');
require('chartutil.php');

$change = $_GET['change'];
//	require('API/db.class.php');
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
    $sql = "select koin, date(date) as day from server_koin where date(date) >= '" . $fromDate . "' and date(date) <= '" . $toDate . "' order by date";
    //echo $sql;
    $chart_data = array();

    foreach ($db->query($sql) as $row) {
        $chart_data[] = array('day' => $row['day'],
            'koin' => $row['koin']);
    }
    //var_dump($rec_arr);
} catch (Exception $e) {
    echo "Lỗi kết nối CSDL";
}
?>
<html>
    <head>
        <?php require('header.php'); ?>
        <script type="text/javascript" src="http://www.google.com/jsapi"></script>
        <script>
            $(document).ready(function () {
                $("#datepicker1").datepicker();
                $("#datepicker2").datepicker();
            });
        </script>
        <script type="text/javascript">
            google.load('visualization', '1', {packages: ['corechart']});
        </script>
        <script type="text/javascript">
            google.load("visualization", "1", {packages: ["corechart"]});
            google.setOnLoadCallback(drawChart);
            function drawChart() {
                var data = google.visualization.arrayToDataTable([
                    ['Ngày', 'Xu'],
<?php
foreach ($chart_data as $data) {
    $day = formatdate($data['day']);
    $koin = $data['koin'];
    echo "['{$day}',  {$koin}],";
}
?>
                ]);

                var options = {
                    title: 'Xu',
                    hAxis: {title: 'Ngay', titleTextStyle: {color: 'red'}},
                    width: 500, height: 300
                };

                var chart = new google.visualization.ColumnChart(document.getElementById('chart_div_koin'));
                chart.draw(data, options);
            }
        </script>
    </head>
    <body>
        <?php if (isset($change)) { ?>
            <div style="padding-left:10px;">
                <form action="" method="post">
                    Từ ngày
                    <input type="text" id="datepicker1" name="fromDate" style="text-align: center; width: 100px;" value="<?php echo $fromDate; ?>"/> 

                    Tới ngày
                    <input type="text" id="datepicker2" name="toDate" style="text-align: center; width: 100px;" value="<?php echo $toDate; ?>"/> 

                    <input type="submit" value="Cập nhật" class="input_button"/>
                </form>
            </div>

        <?php } ?>					
        <div id="chart_div_koin" style="width: 100%; height: <?php echo $chart_height; ?>px;"></div>
    </body>
</html>


