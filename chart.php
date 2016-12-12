<?php
	function startsWith($haystack, $needle)
	{
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
		$sql = "select type, hour(dateOnline) as hourTime, sum(online) as online from user_online_history where date(dateOnline) >= '".$fromDate."' and date(dateOnline) <= '".$toDate."' and type not like 's2%' group by type,hour(dateOnline) order by hour(dateOnline)";
		$users = array();
		foreach ($db->query($sql) as $row) {
			$type = $row['type'];
			if (startsWith($type, "s1")) {
				$type = substr($type,3);
			}
			$users[$type][] = array('hour' => $row['hourTime'],
										   'online' => $row['online']);
		}
	} catch (Exception $e) {
		echo "Lỗi kết nối CSDL";
	}
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
            $(document).ready(function() {
                chart1 = new Highcharts.Chart({
                    chart: {
                        renderTo: 'chart-container-1',
                        defaultSeriesType: 'spline'
                    },
                    title: {
                        text: 'Trà Chanh - 123.29.67.101'
                    },
                    xAxis: {
                        categories: ['1','2','3','4','5','6','7','8','9','10','11','12','13','14','15','16','17','18','19','20','21','22','23','24']
                    },
                    yAxis: {
                        title: {
                            text: 'Quantity'
                        }
                    },
                    series: [
						<?php
							$output = "";
							$output = $output."{name: 'Tổng',";
							$output = $output."data:[";
							$op = "";
							foreach ($users["All"] as $item) {
								$op = $op.",".($item['online']);
							}
							$op = substr($op,1);
							$output = $output.$op."]},";
							while (list($key, $val) = each($users)) {
								if ($key != "All" && strpos($key, "bar") === false && strpos($key, "beach") === false && strpos($key, "park") === false && strpos($key, "trochoi") === false && strpos($key, "nhaycot") === false && strpos($key, "luotvan") === false && strpos($key, "thidau") === false && strpos($key, "wedding") === false && strpos($key, "area") === false) {
									$output = $output."{name: '".$key."',";
									$output = $output."data:[";
									$op = "";
									if ($key == 'tienlenmn') {
										foreach ($val as $item) {
											$op = $op.",".($item['online']);
										}
									} else if ($key == 'phom') {
										foreach ($val as $item) {
											$op = $op.",".($item['online']);
										}
									} else if ($key == 'bacay') {
										foreach ($val as $item) {
											$op = $op.",".($item['online']);
										}
									} else {
										foreach ($val as $item) {
											$op = $op.",".$item['online'];
										}
									}								
									$op = substr($op,1);
									$output = $output.$op."]},";
								}
							}
							$output = substr($output,0, strlen($output)-1);
							echo $output;
						?>
						]
                    });
                });
        </script>
    </head>
    <body>
        <div id="chart-container-1" style="width: 100%; height: 350px"></div>
		<?php //echo $output;?>
    </body>
</html>
