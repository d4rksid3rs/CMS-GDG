<?php
require('API/db.class.php');

require('chartutil.php');
 

//$end_date = date('Y-m-d');
//
//$date_start = date ("Y-m-d", strtotime("-7 day", strtotime($end_date)));
//
//$start_date = $date_start;
//
//$week = array();
//while (strtotime($date_start) <= strtotime($end_date)) {
//        $date_start = date ("Y-m-d", strtotime("+1 day", strtotime($date_start)));         
//	$week[]= $date_start;
//}
$today = date("Y-m-d");
$date_start = $_GET['fromDate'];
$end_date = $_GET['toDate'];

$start_date = $date_start;

$week = array();
while (strtotime($date_start) <= strtotime($end_date)) {               
	$week[]= $date_start;
        $date_start = date ("Y-m-d", strtotime("+1 day", strtotime($date_start)));  
}


//$cpname = asort($cpname);

//$cplist = implode(",",$cps);

//var_dump($cps);


$sql1 = "select date_login,name1,sum(dau) as dau from active_user_detail 
			where type=3 

					and date_login >= '{$start_date}' AND date_login <= '{$end_date}'
				group by name1,date_login 
				order by name1"; //de duyet data dua vao mang cho de
				
$data = array();
$cpname = array();
$lastCPName = "asdf";
foreach ($db->query($sql1) as $row) {
	
	$data[] = $row;
	if ($row['name1']!=$lastCPName){
		$lastCPName = $row['name1'];
		$cpname[] = $lastCPName;
	}
	//echo $row["date_login"];
	//$data[] = array($row["date_login"],$row["name1"],$row["dau"]);

}

for ($i=0;$i<count($cpname);$i++){
	if ($cpname[$i]=="") $cpname[$i]="NULL";
}

array_unshift($cpname,"x");
if (in_array($today, $week)) {
    $my_file = file_get_contents("./dau/rt_login_os");
    $jsonData = json_decode($my_file, true);
    foreach ($jsonData as $val) {
        array_push($data, $val);
    }    
}
//echo json_encode($cpname);

//echo json_encode($data);
//var_dump($data);

//asort($cpname);

$table = array($cpname);

$sizeOfCP = count($cpname);


//echo $sizeOfCP;
foreach ($week as $day) {
    $table_row = array();
    $table_row[] = formatdate($day);
    foreach ($cpname as $name) {
        if ($name == "x")
            continue;
        $found = 0;
        foreach ($data as $row) {

            if ($row['date_login'] == $day && $row['name1'] == $name) {
                //echo "trong ".$day."<br />";
                $table_row[] = intval($row['dau']);
                $found++;
                break;
            }
        }
        if ($found == 0) {
            $table_row[] = 0;
        }
    }
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