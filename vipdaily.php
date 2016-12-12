<?php
session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <title>VIP User theo ngày</title>
        <?php require('header.php'); ?>
        <script>
            $(document).ready(function(){
                $("#datepicker1").datepicker();
                $("#datepicker2").datepicker();
            }); 
        </script>
    </head>
    <body>
        <div class="pagewrap">
            <?php require('topMenu.php'); ?>
			 <div class="box grid">
                
                <div class="box_header"><a href="javascript:void(0);">VIP user theo ngày</a></div>
                <div class="box_body">
                    <table width="100%">
                        <div style="padding-left:10px;">
<?php
include 'connectdb_gimwap.php';
$money = $_POST['money'];
if(!isset($money))
	$money = 500000;
$day = $_POST['day'];
if(!isset($day))
	$day = date('Y-m-d');
if($day)
	$sql = "SELECT u.username, u.mobile, os_type, client_version, date_created, last_login, koin, money, cp FROM user u JOIN auth_user au ON u.username = au.username LEFT JOIN (SELECT username, date(created_on) AS created_on, SUM(money) money FROM log_nap_koin WHERE date(created_on) = '$day' GROUP BY date(created_on), username) l ON l.username = u.username WHERE date(l.created_on) = '$day' AND money >= 100000 ORDER BY money DESC";
else
	$sql = "SELECT u.username, u.mobile, os_type, client_version, date_created, last_login, koin, money, cp FROM user u JOIN auth_user au ON u.username = au.username LEFT JOIN (SELECT username, date(created_on) AS created_on, SUM(money) money FROM log_nap_koin WHERE date(created_on) = CURDATE() GROUP BY date(created_on), username) l ON l.username = u.username WHERE date(l.created_on) = CURDATE() AND money >= 100000 ORDER BY money DESC";
	
/* 	echo $sql; */
?>
			                <form method="post" action="">	               
		    	            	Ngày: <input value="<?php echo $day; ?>" name="day" id="datepicker1"><br />
		    	            	<input type="submit" value="Xác nhận">
			                </form>
			                <table width="100%" cellspacing="1" style="font-size:13px;">
								<thead>
									<tr style="background-color: rgb(204, 204, 204);">
										<th align="center" style="width: 20px;">STT</th>
										<th>Username</th>
										<th align="center" style="width: 100px;">Phiên bản</th>
										<th align="center" style="width: 150px;">Số điện thoại</th>
										<th align="center" style="width: 150px;">Balance</th>
										<th style="width:150px">Số tiền nạp</th>
										<th align="center" style="width: 150px;">CP</th>
									</tr>
								</thead>
								<tbody>
				                <?php
				                $q = mysql_query($sql);
				                $i = 1;
				                while($r = mysql_fetch_assoc($q))
				                {
					                ?>
					                <tr>
										<td align="center" style="width: 20px;"><?php echo $i; $i++ ?></td>
										<td><?php echo $r['username'] ?></td>
										<td align="center" style="width: 100px;"><?php echo $r['os_type']. ' | '.$r['client_version'] ?></td>
										<td align="center" style="width: 150px;"><?php echo $r['mobile'] ?></td>
										<td align="center" style="width: 150px;"><?php echo number_format($r['koin']) ?></td>
										<td align="center"><?php echo number_format($r['money']).' vnđ' ?></td>
										<td align="center" style="width: 150px;"><?php echo $r['cp'] ?></td>
									</tr>
					                <?php
				                }
				                ?>
								</tbody>
							</table>
                        </div>
                    </table>
                </div>
            </div>
        </div>
    </body>
</html>