<?php
require('API/db.class.php');

$end_date = date('Y-m-d');

$date_start = date ("Y-m-d", strtotime("-7 day", strtotime($end_date)));

$start_date = $date_start;

$week = array();
while (strtotime($date_start) <= strtotime($end_date)) {
        $date_start = date ("Y-m-d", strtotime("+1 day", strtotime($date_start)));         
	$week[]= $date_start;
}

//TOP CP trong vong 1 tuan
$sql = "select name1, sum(dau) from active_user_detail where type=4 and date_login >= '{$start_date}' AND date_login <= '{$end_date}' group by name1 order by dau desc LIMIT 0,10";

$cps = array();
//$cpname = array("x");
foreach ($db->query($sql) as $row) {
	$cps[] = "'".$row['name1']."'";
	//$cpname[] = $row['name1'];
}

//$cpname = asort($cpname);

$cplist = implode(",",$cps);

//var_dump($cps);

$sql1 = "select date_login,name1,dau from active_user_detail 
			where type=4
					and name1 IN ({$cplist}) 
					and date_login >= '{$start_date}' AND date_login <= '{$end_date}'
				group by name1,date_login 
				order by name1"; //de duyet data dua vao mang cho de
				
$data = array();
$cpname = array();
$lastCPName = "";
foreach ($db->query($sql1) as $row) {
	
	$data[] = $row;
	if ($row['name1']!=$lastCPName){
		$lastCPName = $row['name1'];
		$cpname[] = $lastCPName;
	}
	//echo $row["date_login"];
	//$data[] = array($row["date_login"],$row["name1"],$row["dau"]);

}
array_unshift($cpname,"x");

//echo json_encode($data);
//var_dump($data);

//asort($cpname);

$table = array($cpname);

$sizeOfCP = count($cpname);



foreach ($week as $day){
	
	//echo $day."<br />";

	$table_row = array();
	$table_row[] = $day;
	foreach ($data as $row){
		
		//var_dump($day);
		//var_dump($row);
		if ($row['date_login'] == $day){
			//echo "trong ".$day."<br />";
			$table_row[] =  intval($row['dau']);
		} 
	}
	if (count($table_row) == $sizeOfCP )
		$table[] = $table_row;
}

//var_dump($table);
//echo json_encode($table);

//$xAxis = "CP,".$cps;
//die();
?>

<!--
You are free to copy and use this sample in accordance with the terms of the
Apache license (http://www.apache.org/licenses/LICENSE-2.0.html)
-->

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
    <title>
      Google Visualization API Sample
    </title>
    <script type="text/javascript" src="//www.google.com/jsapi"></script>
    <script type="text/javascript">
      google.load('visualization', '1', {packages: ['corechart']});
    </script>
    <script type="text/javascript">
      function drawVisualization() {
        // Create and populate the data table.
        var data = google.visualization.arrayToDataTable(<?php echo json_encode($table); ?>);
      
        // Create and draw the visualization.
        new google.visualization.LineChart(document.getElementById('visualization')).
            draw(data, {curveType: "function",
                        width: 500, height: 300,
                        vAxis: {maxValue: 10}}
                );
      }
      

      google.setOnLoadCallback(drawVisualization);
    </script>
  </head>
  <body style="font-family: Arial;border: 0 none;">
    <div id="visualization" style="width: 500px; height: 300px;"></div>
  </body>
</html>
​