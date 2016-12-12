<?php
	include 'connectdb_vnptcard.php';
	$fromDate = $_REQUEST['fromDate'];
	$toDate = $_REQUEST['toDate'];
	

	$i=1;
	
	if (!isset($fromDate)) {
		$fromDate = date('Y-m-d', time());
		$newdate = strtotime ( '-3 day' , strtotime ( $fromDate ) ) ;
		$fromDate = date('Y-m-d', $newdate);
	}
	if (!isset($toDate)) {
		$toDate = date('Y-m-d', time());
	}
	try {
		$sql = "select sum(koin_added) as koin, date(created_on) as day from request where date(created_on) >= '".$fromDate."' and date(created_on) <= '".$toDate."' group by day order by created_on";
		//die($sql);
		$result = mysql_query($sql);
		//echo $sql;
		$chart_data = array();
		//$rows = mysql_fetch_assoc($result);
		while($row = mysql_fetch_assoc($result)){
			$chart_data[] = array('day' => $row['day'],
										   'koin' => $row['koin']);
		}
		//var_dump($rec_arr);
		//die("here1 ".$i++ );
			
	
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
          ['Ngày', 'Lượng Koin Nạp vào từ thẻ'],
		  <?php
		  foreach ($chart_data as $data){
			$day = $data['day'];
			$koin = $data['koin'];
			echo "['{$day}',  {$koin}],";
		  }
		  ?>
         ]);
      
        // Create and draw the visualization.
        new google.visualization.BarChart(document.getElementById('chart_div')).
            draw(data,
                 {title:"Lượng Koin Nạp vào từ thẻ",
                  vAxis: {title: "Ngày"},
                  hAxis: {title: "Koins"},
				  backgroundColor: { fill: "none" },
				  height: <?php echo count($chart_data)*30+100; ?>,
				  width: 1000
				  }
            );
      }
      

      google.setOnLoadCallback(drawVisualization);
    </script>

       

    </head>
    <body>
        <div class="pagewrap">
            <?php require('topMenu.php');?>
            

            <div class="box grid">
                <?php include('topMenu.koin.php'); ?>
                <div class="box_header"><a href="javascript:void(0);"><?php echo "Thống kê Koin"; ?></a></div>
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

