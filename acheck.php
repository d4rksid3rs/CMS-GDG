<?php
require('API/db.class.php');

try {
	$deleteSQL = "update auth_user set koin=0 where koin < 0;";
	if (isset($_REQUEST['killbill']) && $_REQUEST['killbill'] == "delete") {
		$db->exec($deleteSQL);
	}

	$sql = "select sum(koin) as total from auth_user where koin>0";
	$sql1 = "select * from auth_user where koin<0";
	$sql2 = "select * from auth_user order by koin desc limit 0,20";

	$total = 0;
	foreach ($db->query($sql) as $row) {
		$total = $row['total'];
	}
	
	$user1 = array();
	foreach ($db->query($sql1) as $row) {
		$user1[] = array('username' => $row['username'],
						 'koin' => number_format($row['koin']),
						 'mobile' => $row['mobile'],
						 );
	}

	$user2 = array();
	foreach ($db->query($sql2) as $row) {
		$user2[] = array('username' => $row['username'],
						 'koin' => number_format($row['koin']),
						 'mobile' => $row['mobile'],
						 );
	}
} catch (Exception $e) {
	echo "Lỗi kết nối CSDL";
}

function sumMoney($u)
{
	global $db;
	$sql = 'SELECT SUM(money) money FROM log_nap_koin WHERE username = \''.$u.'\' GROUP BY username LIMIT 1';
	$money = 0;
	foreach($db->query($sql) as $row)
	{
		$money = $row['money'];
	}
	return number_format($money) . ' vnđ';
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title><?php echo $title; ?></title>
        <?php require('header.php'); ?>
    </head>
    <body>
        <div class="pagewrap">
            <?php require('topMenu.php'); ?>

            <div class="box grid">
                <div class="box_header"><a href="javascript:void(0);">AAAAAAAAAAAAAAAAAAAAAAAAAAAAAA</a></div>
                <div class="box_body">
                    <div>
						<?php echo "Sum(koin): <a href='http://bem.phang.mobi/bi1/acheck.php?killbill=delete'>".number_format($total)."</a>"?>
						<br>
						<!--
						<a href="http://svbm.hardcookie.com/test.php?u=" target="_blank">http://svbm.hardcookie.com/test.php?u=</a>
						-->
	                    <table width="100%" style="padding-top:20px">
	                    	<tr>
	                    		<td>username</td>
	                    		<td>Mobile</td>
		                    	<td>Koin</td>
	                    	</tr>
		                    <?php
		                    	foreach ($user1 as $row) {
		                    		echo "<tr>";
		                    		echo "<td>{$row['username']}</td>";
		                    		echo "<td>{$row['mobile']}</td>";
		                    		echo "<td>{$row['koin']}</td>";
		                    		echo "</tr>";
		                    	}
		                    ?>
	                    </table>
	                    
						<table width="100%" style="padding-top:20px">
	                    	<tr>
	                    		<td>username</td>
	                    		<td>Mobile</td>
		                    	<td>Koin</td>
	                    	</tr>
		                    <?php
		                    	foreach ($user2 as $row) {
		                    		echo "<tr>";
		                    		echo "<td>{$row['username']}</td>";
		                    		echo "<td>{$row['mobile']}</td>";
		                    		echo "<td>{$row['koin']}</td>";
		                    		echo "</tr>";
		                    	}
		                    ?>
	                    </table>
                    </div>
                </div>
            </div>

        </div>
    </body>
</html>

