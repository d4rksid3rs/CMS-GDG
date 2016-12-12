<?php
session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <title>VIP theo cấp độ</title>
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

<?php
include 'connectdb_gimwap.php';
	$sql = "SELECT u.username, u.mobile, os_type, client_version, date_created, last_login, koin, sum_money money, sum_exp, cp, vip_type FROM user u JOIN auth_user au ON u.username = au.username LEFT JOIN auth_user_vip ON auth_user_vip.auth_user_id = u.id WHERE vip_type IN (1,2,3,4) ORDER BY sum_money DESC";
	$q = mysql_query($sql);
	$i = 1;
	$kc = 0;
	$v = 0;
	$b = 0;
	$kcd = 0;
	while($r = mysql_fetch_assoc($q))
	{
		if($r['vip_type']==1)	$kc++; 
		if($r['vip_type']==2)	$v++; 
		if($r['vip_type']==3)	$b++; 
		if($r['vip_type']==4)	$kcd++;
		$arr[] = $r;
	}
/* 	echo $sql; */
?>
                <div class="box_header"><a href="javascript:void(0);">VIP user theo cấp độ - <?php echo "Kim cương đen: $kcd - Kim cương: $kc - Vàng: $v - Bạc : $b"?></a></div>
                <div class="box_body">
                    <table width="100%">
                        <div style="padding-left:10px;">


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
										<th align="center" style="width: 150px;">Cấp độ</th>
									</tr>
								</thead>
								<tbody>
				                <?php
				                //$q = mysql_query($sql);
				                $i = 1;
				                //while($r = mysql_fetch_assoc($q))
				                foreach($arr as $r)
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
										<td align="center" style="width: 150px;"><?php switch($r['vip_type']) { case 1: echo 'Kim Cương'; break; case 2: echo "Vàng"; break; case 3: echo "Bạc"; break; case 4: echo "Kim Cương Đen"; break;} ?></td>
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