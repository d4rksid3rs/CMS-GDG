<?php
	require('API/db.class.php');
	$fromDate = $_REQUEST['fromDate'];
	$toDate = $_REQUEST['toDate'];

	if (!isset($fromDate)) {
		$fromDate = date('Y-m-d', time());
		$newdate = strtotime ( '-10 day' , strtotime ( $fromDate ) ) ;
		$fromDate = date('Y-m-d', $newdate);
	}
	if (!isset($toDate)) {
		$toDate = date('Y-m-d', time());
	}
	try {
		$sql = "select game, daily_bonus, date(date_created) as day from server_koin_trace where date(date_created) >= '".$fromDate."' and date(date_created) <= '".$toDate."' order by date_created";
		//echo $sql;
		$chart_data = array();
	
		foreach ($db->query($sql) as $row) {
			$chart_data[] = array('day' => $row['day'],
										   'koin' => $row['game'], 'bonus' => $row['daily_bonus']);
		}
		//var_dump($rec_arr);
		
			
	
	} catch (Exception $e) {
		echo "Lỗi kết nối CSDL";
	}
?>
<!DOCTYPE html>
<html>
    <head>
        <title><?php echo $title; ?></title>
        <?php require('header.php'); ?>
        <script>
            $(document).ready(function(){
                $("#datepicker1").datepicker();
                $("#datepicker2").datepicker();
            }); 
        </script>

  

        <script type="text/javascript" src="http://www.google.com/jsapi"></script>
    <script type="text/javascript">
      google.load('visualization', '1', {packages: ['corechart']});
    </script>
    <script type="text/javascript">
      function drawVisualization() {
        // Create and populate the data table.
        var data = google.visualization.arrayToDataTable([
          ['Ngày', 'Koin'],
		  <?php
		  foreach ($chart_data as $data){
			$day = $data['day'];
			$koin = 0 - $data['koin'];
			$bonus = $data['bonus'];
			echo "['{$day}',  {$bonus}],";
		  }
		  ?>
         ]);
      
        // Create and draw the visualization.
        new google.visualization.BarChart(document.getElementById('chart_div')).
            draw(data,
                 {title:"Tiền koin cộng hàng ngày",
                  vAxis: {title: "Ngày"},
                  hAxis: {title: "xu"},
				  backgroundColor: { fill: "none" },
				  height: <?php echo count($chart_data)*30+100; ?>,
				  width: 1200
				  }
            );
      }
      

      google.setOnLoadCallback(drawVisualization);
    </script>

       

    </head>
    <body>
        <div class="pagewrap">
            <?php require('topMenu.php'); ?>            

            <div class="box grid">
                <?php include('topMenu.koin.php'); ?>
                <div class="box_header"><a href="javascript:void(0);"><?php echo "Thống kê tiền koin cộng hàng ngày"; ?></a></div>
                <div class="box_body">
                    <table width="100%">
                      

                        <div style="padding-left:10px;">
                            <form action="" method="post">
                                Từ ngày
                                <input type="text" id="datepicker1" name="fromDate" style="text-align: center; width: 100px;" value="<?php echo $fromDate;?>"/> 
                                (00:00:00)
                                Tới ngày
                                <input type="text" id="datepicker2" name="toDate" style="text-align: center; width: 100px;" value="<?php echo $toDate;?>"/> 
                                (23:59:59)
                                <input type="submit" value="Cập nhật" class="input_button"/>
                            </form>
                        </div>
                        <div id="chart_div" style="width: 900px; height: <?php echo $chart_height; ?>px;"></div>

                       

                    </table>
                </div>
            </div>

        </div>
    </body>
</html>

