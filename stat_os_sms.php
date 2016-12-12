<?php
//include 'cache_begin.php';
require_once 'util.php';

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$isSum = isset($_GET['sum']) ? TRUE : FALSE;

$cmonth = date('m', time());
$cyear  = date('Y', time());

$fromDate = isset($_REQUEST['fromDate'])
            ? trim($_REQUEST['fromDate'])
            : (
                $isSum
                ? date('Y-m-d', date('yesterday'))
                : date('Y-m-d', time() - 86400 * 2)
                );
$toDate = isset($_REQUEST['toDate']) 
            ? trim($_REQUEST['toDate']) 
            : (
                $isSum
                ? "$cyear-$cmonth-31"
                : date('Y-m-d', time())
                );


include 'connectdb_gimwap.php';

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Thống kê sản lượng SMS theo OS</title>
        <?php require('header.php'); ?>
        <script>
            $(document).ready(function(){
                $("#datepicker1").datepicker();
                $("#datepicker2").datepicker();
            }); 
        </script>

        <?php if($id == 0 AND !$isSum): ?>

        <script type="text/javascript">
          google.load("visualization", "1", {packages:["corechart"]});
          google.setOnLoadCallback(drawChart);
          function drawChart() {
            var data = new google.visualization.DataTable();
            data.addColumn('string', 'Ngày');
            <?php
		$rect_count = array();
		$row_count = array();
		$sql = "select os_type, date(created_on) as date, (CASE 
		    WHEN substr(recipient,2,1)='7' THEN 15000
		    WHEN substr(recipient,2,1)='6' THEN 10000
		    WHEN substr(recipient,2,1)='5' THEN 5000
			WHEN substr(recipient,2,1)='4' THEN 4000
			WHEN substr(recipient,2,1)='3' THEN 3000
			WHEN substr(recipient,2,1)='2' THEN 2000
			WHEN substr(recipient,2,1)='1' THEN 1000
			WHEN substr(recipient,2,1)='0' THEN 500
		    ELSE 0 END) * count(*) as money
		            from auth_user_partner JOIN user ON auth_user_partner.auth_user_id = user.id
		            where os_type IS NOT NULL AND test = 0 and recipient != '0000' and (created_on between '$fromDate 00:00:00' and '$toDate 23:59:59')
		            group by date, os_type ORDER BY date, os_type";
		            
		$q = mysql_query($sql);
		$rec_arr['android'] = 0;
		$rec_arr['iphone'] = 0;
		$rec_arr['j2me'] = 0;
		while($r = mysql_fetch_assoc($q))
		{
			if(!$r['os_type'])
				$r['os_type'] = 'j2me';
			$rec_arr[$r['os_type']] += $r['money'];
			$row_count[$r['date']][$r['os_type']] += $r['money'];
		}
		foreach($rec_arr as $r=>$v)
		{
			echo "data.addColumn('number', '$r : $v');";
			//echo $re .= $v.", ";
		}

	    
        //    var_dump($row_count);
            ?>
            
            data.addRows([
                <?php
                //$date_arr = array_keys($chart_data);
                //$no_date = count($chart_data);
                $re = "";
				foreach($row_count as $k=>$v)
				{
					if(!$v['android'])
						$v['android'] = 0;
					if(!$v['iphone'])
						$v['iphone'] = 0;
					if(!$v['j2me'])
						$v['j2me'] = 0;
					echo "['{$k}',".$v['android'].",".$v['iphone'].",".$v['j2me']."], ";
				}
				$re = substr($re, 0, -2);
				echo $re;
                ?>
            ]);
	    

            var options = {
              title: <?php echo "'$chart_title'"; ?>,
              vAxis: {title: 'Ngày',  titleTextStyle: {color: 'red'}},
              backgroundColor: { fill: "none" }
            };

            var chart = new google.visualization.BarChart(document.getElementById('chart_div'));
            chart.draw(data, options);
          }
        </script>

        <?php elseif($id == 1 AND !$isSum): ?>

        <script type="text/javascript">
          google.load("visualization", "1", {packages:["corechart"]});
          google.setOnLoadCallback(drawChart);
          function drawChart() {
            var data = new google.visualization.DataTable();
            data.addColumn('string', 'Ngày');
            <?php
		$rect_count = array();
		$row_count = array();
		
	        $date_arr = array_keys($chart_data);
                $no_date = count($chart_data);
                for($i = 0; $i < $no_date; $i++)
                {
                    $date = $chart_data[$date_arr[$i]];
                    $rec_str = '';
                    for($j = 0; $j < count($rec_arr); $j++)
                    {
                        $rec = $rec_arr[$j];
                        $rec_str .= ", {$date[$rec]}";
			$rect_count[$rec] +=  $date[$rec];
                    }
                    $row_count[$i] = "['{$date_arr[$i]}' $rec_str],";
                }

                //$chart_height = max($no_date * 80, 900);
	    
	    
            foreach($rec_arr as $r)
            {
		$v = number_format($rect_count[$r],0);
                echo "data.addColumn('number', '$r : $v');";
            }
            ?>
            data.addRows([
                <?php
                
                for($i = 0; $i < $no_date; $i++)
                {
		   echo $row_count[$i];	
                }

                $chart_height = max($no_date * 80, 900);
                ?>
            ]);

            var options = {
              title: <?php echo "'$chart_title'"; ?>,
              vAxis: {title: 'Ngày',  titleTextStyle: {color: 'red'}},
              backgroundColor: { fill: "none" },
              isStacked: true
            };

            var chart = new google.visualization.BarChart(document.getElementById('chart_div'));
            chart.draw(data, options);
          }
        </script>

        <?php elseif($id == 0 AND $isSum): ?>

        <script type="text/javascript">
          google.load("visualization", "1", {packages:["corechart"]});
          google.setOnLoadCallback(drawChart);
          function drawChart() {
            var data = new google.visualization.DataTable();
            data.addColumn('string', '');
            <?php
            $rec_arr = array_keys($chart_data);
            $no_rec = count($chart_data);
            foreach($rec_arr as $r)
            {
		$v = number_format($chart_data[$r],0);
                echo "data.addColumn('number', '$r : $v');";
            }
            ?>
            data.addRows([
                <?php
                $rec_str = '';
		$total = 0;
                for($i = 0; $i < $no_rec; $i++)
                {
                    $rec = $rec_arr[$i];
                    $val = $chart_data[$rec];
		    $total += $val;
                    $rec_str .= ", $val";
                }
                echo "['' $rec_str]";
                $chart_height = 900;
                ?>
            ]);

            var options = {
              title: <?php echo "'$chart_title, Total : $total'"; ?>,
              vAxis: {title: '',  titleTextStyle: {color: 'red'}},
              backgroundColor: { fill: "none" }
            };

            var chart = new google.visualization.BarChart(document.getElementById('chart_div'));
            chart.draw(data, options);
          }
        </script>

        <?php elseif($id == 1 AND $isSum): ?>

        <script type="text/javascript">
          google.load("visualization", "1", {packages:["corechart"]});
          google.setOnLoadCallback(drawChart);
          function drawChart() {
            var data = new google.visualization.DataTable();
            data.addColumn('string', '');
            <?php
            $rec_arr = array_keys($chart_data);
            $no_rec = count($chart_data);
            foreach($rec_arr as $r)
            {
	            $v = number_format($chart_data[$r],0);
                echo "data.addColumn('number', '$r : $v');";
            }
            ?>
            data.addRows([
                <?php
                $rec_str = '';
		$total = 0;
                for($i = 0; $i < $no_rec; $i++)
                {
                    $rec = $rec_arr[$i];
                    $val = $chart_data[$rec];
		    $total += $val;
                    $rec_str .= ", $val";
                }
                echo "['' $rec_str]";
                $chart_height = 900;
                ?>
            ]);

            var options = {
              title: <?php $total=number_format($total,0);echo "'$chart_title, total: $total'"; ?>,
              vAxis: {title: '',  titleTextStyle: {color: 'red'}},
              backgroundColor: { fill: "none" }
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
            <?php require_once('topMenu.sub2.php'); ?>

            <div class="box grid">
                <div class="box_header"><a href="javascript:void(0);"><?php echo $title; ?></a></div>
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
                        <div id="chart_div" style="width: 100%; height: <?php $chart_height = count($row_count) * 80; echo $chart_height; ?>px;"></div>

                    </table>
                </div>
            </div>

        </div>
    </body>
</html>

<?php //include 'cache_end.php'; ?>
