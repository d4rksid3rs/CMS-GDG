<?php
include('API/db.class.php');
$sql = "SELECT * FROM user LIMIT 0,10";
$arr = array();
foreach($db->query($sql) as $row)
{
	array_push($arr, $row);
}
echo json_encode($arr);
?>