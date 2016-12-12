<?php
require('API/db.class.php');

try {
	$sql = "select sum(koin) as total from auth_user where koin>0";
	$sql2 = "select auth_user.*, DATEDIFF(CURDATE(), last_login) AS last_login, os_type from auth_user JOIN user ON auth_user.username = user.username where koin > 5000000 order by koin desc";

	$total = 0;
	foreach ($db->query($sql) as $row) {
		$total = $row['total'];
	}
	
	$user2 = array();
	foreach ($db->query($sql2) as $row) {
		$user2[] = array('username' => $row['username'],
						 'koin' => number_format($row['koin']),
						 'last_login' => $row['last_login'],
						 'mobile' => $row['mobile'],
						 'os_type' => $row['os_type']);
	}
} catch (Exception $e) {
	echo "Lỗi kết nối CSDL";
}

function sumMoney($u)
{
	global $db;
	$sql = 'SELECT SUM(money) money, last_login, os_type FROM log_nap_koin JOIN user ON log_nap_koin.username = user.username WHERE username = \''.$u.'\' GROUP BY username LIMIT 1';
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
						<?php echo "Sum(koin): <a href='#'>".number_format($total)."</a>"?>
						<br>
						<!--
						<a href="http://svbm.hardcookie.com/test.php?u=" target="_blank">http://svbm.hardcookie.com/test.php?u=</a>
						-->
	                    
						<table width="100%" style="padding-top:20px">
	                    	<tr>
	                    		<td>username</td>
	                    		<td>Mobile</td>
		                    	<td>Koin</td>
	                    		<td>OS</td>
		                    	<td>Chưa login</td>
	                    	</tr>
		                    <?php
		                    	foreach ($user2 as $row) {
		                    		echo "<tr>";
		                    		echo "<td>{$row['username']}</td>";
		                    		echo "<td>{$row['mobile']}</td>";
		                    		echo "<td>{$row['koin']}</td>";
		                    		echo "<td>{$row['os_type']}</td>";
		                    		echo "<td>{$row['last_login']} ngày</td>";
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

