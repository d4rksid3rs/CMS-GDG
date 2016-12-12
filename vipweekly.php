<?php
session_start();
include 'connectdb_gimwap.php';
mysql_query("SET NAMES 'UTF8'");
$money = $_POST['money'];
if(!isset($money))
	$money = 500000;
$day = $_POST['day'];
$eday = $_POST['eday'];
if(!isset($day))
	$day = date('Y-m-d');
if(!isset($eday))
	$eday = date('Y-m-d',strtotime('-7 days'));
?>
<!DOCTYPE html>
<html>
    <head>
        <title>VIP user từ ngày <?php echo $eday. ' đến ngày '.$day ?></title>
        <link type='text/css' href='css/basic.css' rel='stylesheet' media='screen' />
        <?php require('header.php'); ?>
         <script src="js/jquery.simplemodal.js"></script>
        <script>
            $(document).ready(function(){
                $("#datepicker1").datepicker();
                $("#datepicker2").datepicker();
            }); 
            function feedback(checkbox, user)
            {
	            var fb = $("#fb"+user).val();
	            if(fb.length > 0)
	            {
	            $.ajax({
                    type: "POST",
                    url: "API/feedbackcall.php",
                    data: {
                        "user":user,
                        "feedback":fb,
                    },
                    dataType: 'text',
                    success: function(msg) {
                        msg = msg.trim();
                        if (msg != '' && msg.length > 2) {
                            var data = jQuery.parseJSON(msg);
                            $("#tdfb"+data.username).html(data.message);
                        }
                    }
                });
                }
                else
                {
	                alert("Phải nhập nội dung phản hổi!");
	                checkbox.checked = false;
                }
            }
            function logfb(div)
            {
	            $("#"+div).modal({
									closeHTML: '<div style="float:right; font-size:25px; color:#fff;"><a href="#" class="simplemodal-close" style="color:#fff">x</a></div>',
									opacity:50,
									overlayClose:true,
									minWidth: '750px',
									minHeight: '500px'
                                });
            }
        </script>
    </head>
    <body>
        <div class="pagewrap">
            <?php require('topMenu.php'); ?>
			 <div class="box grid">
                
                <div class="box_header"><a href="javascript:void(0);">VIP user từ ngày <?php echo $eday. ' đến ngày '.$day ?></a></div>
                <div class="box_body">
                    <table width="100%">
                        <div style="padding-left:10px;">
<?php
$sql = " SELECT u.username, u.mobile, os_type, client_version, date_created, last_login, koin, money, cp, DATEDIFF(CURDATE(), last_login) AS loginDate FROM user u JOIN auth_user au ON u.username = au.username LEFT JOIN (SELECT username, date(created_on) AS created_on, SUM(money) money FROM log_nap_koin WHERE date(created_on) BETWEEN '$eday' AND '$day' GROUP BY username) l ON l.username = u.username WHERE date(l.created_on) BETWEEN '$eday' AND '$day' HAVING money >= 500000 ORDER BY money DESC";

	
/* 	echo $sql; */
?>
			                <form method="post" action="">	               
		    	            	Ngày: <input value="<?php echo $eday; ?>" name="eday" id="datepicker1"><br />
		    	            	Đến ngày: <input value="<?php echo $day; ?>" name="day" id="datepicker2">
		    	            	<input type="submit" value="Xác nhận">
			                </form>
			                <table width="100%" cellspacing="1" style="font-size:13px;">
								<thead>
									<tr style="background-color: rgb(204, 204, 204);">
										<th align="center" style="width: 15px;">STT</th>
										<th align="center" style="width: 150px;">Username</th>
										<th align="center" style="width: 100px;">Phiên bản</th>
										<th align="center" style="width: 120px;">Số điện thoại</th>
										<th align="center" style="width: 120px;">Balance</th>
										<th style="width:120px">Số tiền nạp</th>
										<th align="center" style="width: 80px;">CP</th>
										<th align="center" style="width: 100px;">Chưa login</th>
										<th align="center" style="">Feedback</th>
									</tr>
								</thead>
								<tbody>
				                <?php
				                $q = mysql_query($sql);
				                $i = 1;
				                $show = false;
				                while($r = mysql_fetch_assoc($q))
				                {
				                
					                ?>
					                <tr>
										<td align="center" style="width: 20px;"><?php echo $i; $i++ ?></td>
										<td><?php echo $r['username'] ?></td>
										<td align="center" style=""><?php echo $r['os_type']. ' | '.$r['client_version'] ?></td>
										<td align="center" style=""><?php echo $r['mobile'] ?></td>
										<td align="center" style=""><?php echo number_format($r['koin']) ?></td>
										<td align="center"><?php echo number_format($r['money']).' vnđ' ?></td>
										<td align="center" style=""><?php echo $r['cp'] ?></td>
										<td align="center" style=""><?php echo $r['loginDate'] ?> ngày</td>
										<td align="center" style="" name="tdfb<?php echo $r['username']; ?>" id="tdfb<?php echo $r['username']; ?>">
										<div id="divfb<?php echo $r['username']; ?>" style="display:none">
										<table width="100%" cellspacing="1" border="1" style="font-size:13px;">
											<thead>
											    <tr>
											        <th style="width: 5%;" align="center">STT</th>
											        <th style="width: 10%;" align="center">Tài khoản</th>
											        <th>Nội dung</th>
											        <th style="width: 150px;" align="center">Ngày gọi</th>
											    </tr>
											</thead>
											<tbody>
 
										<?php
										$sql_fb = "SELECT * FROM feedback_call WHERE username = '{$r['username']}'";
										$q_fb = mysql_query($sql_fb);
										
										$j = 1;
										$n = mysql_num_rows($q_fb);
										$fb = '';
										while($r_fb = mysql_fetch_assoc($q_fb))
										{
											echo "<tr>";
											echo "<td>$j</td>"; $j++;
											echo "<td>{$r_fb['username']}</td>";
											echo "<td>{$r_fb['feedback']}</td>";
											echo "<td>{$r_fb['call_time']}</td>";
											echo "</tr>";
											$fb = $r_fb['feedback'] . ' - ' . $r_fb['call_time'] ;
										}
										 ?>
											 </tbody>
										 	</table>
										</div>
											<input placeholder="Phản hồi" name="fb<?php echo $r['username'] ?>" id="fb<?php echo $r['username'] ?>"><input type="checkbox" onclick="feedback(this,'<?php echo $r['username']; ?>');" /> Đã gọi
										<?php
										if($n > 0)
											echo "<input type=\"button\" onclick=\"logfb('divfb".$r['username']."')\" value=\"Log\" />";
										if(strlen($fb) > 0)
											echo $fb;
										//}
										//else
										//echo "Đã gọi: ". $row['feedback'];
										?>
										</td>
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