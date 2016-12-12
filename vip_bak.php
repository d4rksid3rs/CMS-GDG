<?php
session_start();
$u = isset($_SESSION['username']) ? $_SESSION['username'] : 'foobar';
//inecho $u;
?>
<!DOCTYPE html>
<html>
    <head>
        <title>VIP User</title>
        <?php require('header.php'); ?>
    </head>
    <body>
        <div class="pagewrap">
            <?php require('topMenu.php'); ?>
			 <div class="box grid">
                
                <div class="box_header"><a href="javascript:void(0);">VIP user</a></div>
                <div class="box_body">
                    <table width="100%">
                        <div style="padding-left:10px;">
<?php
include 'connectdb_vnptcard.php';
	
require_once ('API/db2.class.php');
	echo "<h1>VIP nạp CARD:</h1>";
	try {
		$sql = "SELECT username,sum(cardvalue) as money FROM `request` group by username order by money desc limit 0,30";
		//die($sql);
		$result = mysql_query($sql);
		//echo $sql;
		//$total = 0;
		while($row = mysql_fetch_assoc($result)){
			echo "<br /><b>".$row['username'] ."</b> :  " . number_format(floor($row['money']))." vnđ";
		//	$total += intval($row['money']);
		}
		//echo "<br />Total :".$total;
			
	
	} catch (Exception $e) {
		echo "Loi ket noi CSDL";
	}
	echo "<h1>VIP nạp CARD 2 (ngân lượng):</h1>";
	//ngan luong
		$result = "SELECT username,sum(cardvalue) as money FROM ngl_card.request group by username order by money desc limit 0,30";
            //echo $result;
		    
			foreach ($db2->query($result) as $row) 
		    {
		    	echo "<br /><b>".$row['username'] ."</b> :  " . number_format(floor($row['money']))." vnđ";
		    }
	//paydirect
	echo "<h1>VIP nạp CARD 3 (pay direct):</h1>";
	//ngan luong
		$result = "SELECT username,sum(cardvalue) as money FROM paydirect_card.request group by username order by money desc limit 0,30";
            //echo $result;
		    
			foreach ($db2->query($result) as $row) 
		    {
		    	echo "<br /><b>".$row['username'] ."</b> :  " . number_format(floor($row['money']))." vnđ";
		    }
	
	require('API/db.class.php');
	$fromDate = $_REQUEST['fromDate'];
	$toDate = $_REQUEST['toDate'];
	

	try {
	echo "<h1>VIP nạp SMS:</h1>";
		//$total = 0;
		$sql = "SELECT message,(CASE 
		    WHEN substr(recipient,2,1)='7' THEN 15000
		    WHEN substr(recipient,2,1)='6' THEN 10000
		    WHEN substr(recipient,2,1)='5' THEN 5000
			WHEN substr(recipient,2,1)='4' THEN 4000
			WHEN substr(recipient,2,1)='3' THEN 3000
			WHEN substr(recipient,2,1)='2' THEN 2000
			WHEN substr(recipient,2,1)='1' THEN 1000
			WHEN substr(recipient,2,1)='0' THEN 500
		    ELSE 0 END) * count(*) as money FROM `auth_user_partner` where service = 'NAP' group by message order by money desc limit 0,30";
        //echo $sql;
		foreach ($db->query($sql) as $row) {
		  
			echo "<br /><b>".$row['message']."</b> :  " . number_format(floor($row['money']))." vnđ";
			//$total += intval($row['money']);
		}
		//echo "<br />Total :".$total;
			
	
	} catch (Exception $e) {
		echo "Lỗi kết nối CSDL";
	}

?>

                        </div>
                    </table>
                </div>
            </div>
        </div>
    </body>
</html>