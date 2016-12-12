<?php
$type = $_GET['type'];
if (!isset($type))
    $type = 2;
/*
  1: sms mv
  2: sms đối tác
  3: card mv
  4: card đối tác
 */
require('API/db.class.php');
require('chartutil.php');

$end_date = date('Y-m-d');

$end_date = date("Y-m-d", strtotime("-1 day", strtotime($end_date)));

//$date_start = date ("Y-m-d",strtotime("yesterday"));

$date_start = date("Y-m-d", strtotime("-7 day", strtotime($end_date)));

$start_date = $date_start;

$week = array();
while (strtotime($date_start) < strtotime($end_date)) {
    $date_start = date("Y-m-d", strtotime("+1 day", strtotime($date_start)));
    $week[] = $date_start;
}

//TOP CP trong vong 1 tuan
$sql = "select type_koin, sum(total) as sum_total from revenue where type_koin != '0' and type={$type} and date_created >= '{$start_date}' AND date_created <= '{$end_date}' group by type_koin order by sum_total desc LIMIT 0,9";

//echo ($sql);die;
$cps = array();
//$cpname = array("x");
foreach ($db->query($sql) as $row) {
    $cps[] = "'" . $row['type_koin'] . "'";
    //$cpname[] = $row['name1'];
}
//$cpname = asort($cpname);

$cplist = implode(",", $cps);
//echo $cplist;
//var_dump($cps);

$sql1 = "select date_created,type_koin,total from revenue 
			where type={$type}
					and type_koin IN ({$cplist}) 
					and date_created >= '{$start_date}' AND date_created <= '{$end_date}'
				group by type_koin,date_created 
				order by type_koin"; //de duyet data dua vao mang cho de
//
//die($sql1);			                                       
$data = array();
$cpname = array();
$lastCPName = "fuck";
foreach ($db->query($sql1) as $row) {

    $data[] = $row;
    if ($row['type_koin'] != $lastCPName) {
        $lastCPName = $row['type_koin'];
        $cpname[] = $lastCPName;
    }
    //echo $row["date_login"];
    //$data[] = array($row["date_login"],$row["name1"],$row["dau"]);
}
array_unshift($cpname, "x");

//echo json_encode($data);
//var_dump($data);
//asort($cpname);

$table = array($cpname);

$sizeOfCP = count($cpname);







foreach ($week as $day) {
    //
    //echo $day."<br />";
    //echo $name."<br />";
    $table_row = array();
    $table_row[] = formatdate($day);
    foreach ($cpname as $name) {
        if ($name == "x")
            continue;
        $found = 0;
        foreach ($data as $row) {

            //echo $row['name1']."<br />";
            if ($row['date_created'] == $day && $row['type_koin'] == $name) {
                //echo "trong ".$day."<br />";
                $table_row[] = intval($row['total']);
                $found++;
                break;
            }


            //var_dump($day);
            //var_dump($row);
        }
        if ($found == 0)
            $table_row[] = 0;





        //}
    }
    //if ($found>0) 
    $table[] = $table_row;
}
//echo '<pre>';
//print_r($table);
//echo '</pre>';die;
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
                            vAxis: {maxValue: 10, viewWindowMode: "explicit", viewWindow: {min: 0}}}
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