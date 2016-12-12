<?php
	include 'connectdb_vnptcard.php';
	$name = $_REQUEST['name'];
	echo "<br /><b>CARD:</b>";
	try {
		$sql = "select cardvalue as money, date(created_on) as day from request where username='$name' order by created_on";
		//die($sql);
		$result = mysql_query($sql);
		//echo $sql;
		$total = 0;
		while($row = mysql_fetch_assoc($result)){
			echo "<br />".$row['day'] ." :  " . $row['money'];
			$total += intval($row['money']);
		}
		echo "<br />Total :".$total;
			
	
	} catch (Exception $e) {
		echo "Loi ket noi CSDL";
	}
	
	
	require('API/db.class.php');
	$fromDate = $_REQUEST['fromDate'];
	$toDate = $_REQUEST['toDate'];
	

	try {
	echo "<br /><b>SMS:</b>";
		$total = 0;
		$sql = "select koin_added as money, date(created_on) as day from logkoin where username='$name' order by created_on";
		foreach ($db->query($sql) as $row) {
			echo "<br />".$row['day'] ." :  " . $row['money'];
			$total += intval($row['money']);
		}
		echo "<br />Total :".$total;
			
	
	} catch (Exception $e) {
		echo "Lỗi kết nối CSDL";
	}
?>