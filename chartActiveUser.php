<?php
	require('API/db.class.php');
	//$fromDate = $_GET['fromDate'];
	$tmpDate = $_GET['toDate'];
	//if (!isset($fromDate)) {
	//	$fromDate = date('Y-m-d', time());
	//}
	if (!isset($tmpDate)) {
		$tmpDate = date('Y-m-d', time());
	}
	$newdate = strtotime ( '-1 day' , strtotime ( $tmpDate ) ) ;
	$toDate = date('Y-m-d', $newdate);
	
	$newdate = strtotime ( '-16 day' , strtotime ( $tmpDate ) ) ;
	$fromDate = date('Y-m-d', $newdate);
	
	try {
		$sql = "select date_login, dau as login_time, mau as mau from active_user_detail where date(date_login) >= '".$fromDate."' and date(date_login) <= '".$toDate."' order by date_login asc";
		$users = array();
		foreach ($db->query($sql) as $row) {
			$users[] = array('date' => $row['date_login'],
							 'times' => $row['login_time']);
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
                        text: 'Daily Active User'
                    },
                    xAxis: {
                        categories: [
							<?php
								$output = "";
								for ($i=0;$i<sizeof($users);$i++) {
									$value = sizeof($users) - $i - 1;
									$newdate = strtotime ( "-".$value." day" , strtotime ( $toDate ) ) ;
									$output .= ",'".date('d-m', $newdate)."'";
								}
								if (strlen($output)> 1) {
									$output = substr($output,1);
								}
								echo $output;
							?>
						]
                    },
                    yAxis: {
                        title: {
                            text: 'Quantity'
                        }
                    },
                    series: [
						<?php
							$output = "";
							$output = $output."{name: 'DAU',";
							$output = $output."data:[";
							$op = "";
							foreach ($users as $item) {
								$op = $op.",".($item['times']);
							}
							if (strlen($op)> 1) {
								$op = substr($op,1);
							}
							echo $output.$op.']}';
						?>
						]
                    });
                });
        </script>
    </head>
    <body>
        <div id="chart-container-1" style="width: 550px; height: 300px"></div>
    </body>
</html>
