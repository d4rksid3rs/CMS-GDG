<?php
	require('constans.php');
	require('api/db.class.php');
	$cp = $_GET["id"];

/*	echo $_POST["CP_NAME"]."<br/>";
	echo $_POST["SMS_DK_SC"]."<br/>";
	echo $_POST["SMS_DK_SN"]."<br/>";
	
	echo $_POST["SMS_PWD_SC"]."<br/>";
	echo $_POST["SMS_PWD_SN"]."<br/>";
	
	echo $_POST["SMS_TANG_SC"]."<br/>";
	echo $_POST["SMS_TANG_SN"]."<br/>";
	echo $_POST["SMS_TANG_KOIN"]."<br/>";
	
	echo $_POST["SMS_KOIN_SC"]."<br/>";
	echo $_POST["SMS_KOIN_SN"]."<br/>";
	echo $_POST["SMS_KOIN_KOIN"]."<br/>";
	
	echo $_POST["SMS_NAP_SC"]."<br/>";
	echo $_POST["SMS_NAP1_SN"]."<br/>";
	echo $_POST["SMS_NAP1_KOIN"]."<br/>";
	echo $_POST["SMS_NAP2_SN"]."<br/>";
	echo $_POST["SMS_NAP2_KOIN"]."<br/>";
	echo $_POST["SMS_NAP3_SN"]."<br/>";
	echo $_POST["SMS_NAP3_KOIN"]."<br/>";
	
	echo $_POST["VER_VERSION"]."<br/>";
	echo $_POST["VER_VERSION_FORCE"]."<br/>";
	echo $_POST["VER_MSG_UPDATE"]."<br/>";
	echo $_POST["VER_MSG_FORCE"]."<br/>";
	echo $_POST["VER_WAP"]."<br/>";
*/	

	if (isset($cp)) {
		$cp = strtolower($cp);
		$sql = "select * from config c where c.key='sms_".$cp."' or c.key='version_".$cp."'";
		try {
			foreach ($db->query($sql) as $row) {
				if (startsWith($row['key'],"sms")) {
					$sms = json_decode($row['value']);
				} else if (startsWith($row['key'],"version")) {
					$version = json_decode($row['value'])->{'j2me'};
					$version_android = json_decode($row['value'])->{'android'};
					$version_iphone = json_decode($row['value'])->{'iphone'};
				}
			}
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}


	if (!isset($sms) or !isset($version)) {
		header('Location: index.php');
	} else {
		if (isset($_POST["SMS_DK_SC"])) {
			try {
				if ($_POST["SMS_ACTIVE_SN"] == "") {
					$_POST["SMS_ACTIVE_SN"] = 0;
				}
				if ($_POST["SMS_ACTIVE_SC"] == "") {
					$_POST["SMS_ACTIVE_SC"] = 0;
				}
				$enableActive = $_POST["ENABLE_ACTIVE"];
				$enableRegister = $_POST["ENABLE_REGISTER"];
				if ($enableRegister !== "1") {
					$enableRegister = "0";
				}
				$key = "sms_".strtolower($_POST["CP_NAME"]);
				$value = "{\\\"BEM_DK\\\":{\\\"ServiceNumber\\\":".strtoupper($_POST["SMS_DK_SN"]).",\\\"ServiceCode\\\":\\\"".$_POST["SMS_DK_SC"]."\\\",\\\"enable\\\":".$enableRegister."},\\\"BEM_PWD\\\":{\\\"ServiceNumber\\\":".$_POST["SMS_PWD_SN"].",\\\"ServiceCode\\\":\\\"".strtoupper($_POST["SMS_PWD_SC"])."\\\"},\\\"BEM_NAP\\\":{\\\"ServiceNumber\\\":[{\\\"sn\\\":".$_POST["SMS_NAP1_SN"].",\\\"koin\\\":".$_POST["SMS_NAP1_KOIN"]."}";
				if ($_POST["SMS_NAP2_SN"] !== "") {
					$value .= ",{\\\"sn\\\":".$_POST["SMS_NAP2_SN"].",\\\"koin\\\":".$_POST["SMS_NAP2_KOIN"]."}";
				}
				if ($_POST["SMS_NAP3_SN"] !== "") {
					$value .= ",{\\\"sn\\\":".$_POST["SMS_NAP3_SN"].",\\\"koin\\\":".$_POST["SMS_NAP3_KOIN"]."}";
				}
				$value .= "],\\\"ServiceCode\\\":\\\"".strtoupper($_POST["SMS_NAP_SC"])."\\\"},\\\"BEM_KOIN\\\":{\\\"ServiceNumber\\\":".$_POST["SMS_KOIN_SN"].",\\\"ServiceCode\\\":\\\"".strtoupper($_POST["SMS_KOIN_SC"])."\\\",\\\"koin\\\":".$_POST["SMS_KOIN_KOIN"]."},\\\"BEM_TANG\\\":{\\\"ServiceNumber\\\":".$_POST["SMS_TANG_SN"].",\\\"ServiceCode\\\":\\\"".strtoupper($_POST["SMS_TANG_SC"])."\\\",\\\"koin\\\":".$_POST["SMS_TANG_KOIN"]."},\\\"BEM_ACTIVE\\\":{\\\"ServiceNumber\\\":".$_POST["SMS_ACTIVE_SN"].",\\\"ServiceCode\\\":\\\"".strtoupper($_POST["SMS_ACTIVE_SC"])."\\\",\\\"enable\\\":".$enableActive."}}";
				//$value = "{\\\"BEM_DK\\\":{\\\"ServiceNumber\\\":".strtoupper($_POST["SMS_DK_SN"]).",\\\"ServiceCode\\\":\\\"".$_POST["SMS_DK_SC"]."\\\"},\\\"BEM_PWD\\\":{\\\"ServiceNumber\\\":".$_POST["SMS_PWD_SN"].",\\\"ServiceCode\\\":\\\"".strtoupper($_POST["SMS_PWD_SC"])."\\\"},\\\"BEM_NAP\\\":{\\\"ServiceNumber\\\":[{\\\"sn\\\":".$_POST["SMS_NAP1_SN"].",\\\"koin\\\":".$_POST["SMS_NAP1_KOIN"]."},{\\\"sn\\\":".$_POST["SMS_NAP2_SN"].",\\\"koin\\\":".$_POST["SMS_NAP2_KOIN"]."},{\\\"sn\\\":".$_POST["SMS_NAP3_SN"].",\\\"koin\\\":".$_POST["SMS_NAP3_KOIN"]."}],\\\"ServiceCode\\\":\\\"".strtoupper($_POST["SMS_NAP_SC"])."\\\"},\\\"BEM_KOIN\\\":{\\\"ServiceNumber\\\":".$_POST["SMS_KOIN_SN"].",\\\"ServiceCode\\\":\\\"".strtoupper($_POST["SMS_KOIN_SC"])."\\\",\\\"koin\\\":".$_POST["SMS_KOIN_KOIN"]."},\\\"BEM_TANG\\\":{\\\"ServiceNumber\\\":".$_POST["SMS_TANG_SN"].",\\\"ServiceCode\\\":\\\"".strtoupper($_POST["SMS_TANG_SC"])."\\\",\\\"koin\\\":".$_POST["SMS_TANG_KOIN"]."}}";
				$sql = "update config c set c.value=\"".$value."\" where c.key=\"".$key."\"";
				$db->exec($sql);
				$key = "version_".strtolower($_POST["CP_NAME"]);
				$value = "{\\\"j2me\\\":{\\\"version\\\":\\\"".$_POST["VER_VERSION"]."\\\",\\\"version_force\\\":\\\"".$_POST["VER_VERSION_FORCE"]."\\\",\\\"message_update\\\":\\\"".$_POST["VER_MSG_UPDATE"]."\\\",\\\"message_force\\\":\\\"".$_POST["VER_MSG_FORCE"]."\\\",\\\"wap\\\":\\\"".$_POST["VER_WAP"]."\\\"},\\\"android\\\":{\\\"version\\\":\\\"".$_POST["VER_VERSION_ANDROID"]."\\\",\\\"version_force\\\":\\\"".$_POST["VER_VERSION_FORCE_ANDROID"]."\\\",\\\"message_update\\\":\\\"".$_POST["VER_MSG_UPDATE_ANDROID"]."\\\",\\\"message_force\\\":\\\"".$_POST["VER_MSG_FORCE_ANDROID"]."\\\",\\\"wap\\\":\\\"".$_POST["VER_WAP_ANDROID"]."\\\"},\\\"iphone\\\":{\\\"version\\\":\\\"".$_POST["VER_VERSION_IPHONE"]."\\\",\\\"version_force\\\":\\\"".$_POST["VER_VERSION_FORCE_IPHONE"]."\\\",\\\"message_update\\\":\\\"".$_POST["VER_MSG_UPDATE_IPHONE"]."\\\",\\\"message_force\\\":\\\"".$_POST["VER_MSG_FORCE_IPHONE"]."\\\",\\\"wap\\\":\\\"".$_POST["VER_WAP_IPHONE"]."\\\"}}";
				$sql = "update config c set c.value=\"".$value."\" where c.key=\"".$key."\"";
				$db->exec($sql);
			} catch (Exception $e) {
				$message = $e->getMessage();
			}
			if (!isset($message)) {
				header('Location: index.php');
			}
		}
	}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<title>Beme Config</title>
		<link rel="stylesheet" type="text/css" href="css/jquery.ui.theme.css" />
        <link rel="stylesheet" type="text/css" href="css/jquery.ui.datetime.css" />
		<script type="text/javascript" src="js/jquery-1.6.2.js"></script>
        <script type="text/javascript" src="js/jquery-ui.min.js"></script>
        <script type="text/javascript" src="js/jquery.ui.datetime.min.js"></script>
        <script type="text/javascript" src="js/jquery.timers-1.2.js"></script>
        <script type="text/javascript" src="js/jquery.easing.js"></script>
        <script type="text/javascript" src="js/jquery.collapse.js"></script>
        <script type="text/javascript" src="js/jquery.ui.core.js"></script>
		<meta content="width = device-width, height = device-height, user-scalable = no;" name="viewport">
		<meta name="HandheldFriendly" content="true" >
		<style>
			body{font-family: Tahoma,Verdana,Arial; font-size: 12px; margin:0; padding:0;}
			a {text-decoration:none;}
			ul#collapser { margin: 0; padding: 0; }
			ul#collapser li { margin: 10px 0 10px 0px; padding: 0; list-style: none; }
			ul#collapser li.dateTotal {padding: 0;}
			ul#collapser li.dateTotal>ul {margin-left: 25px; padding: 0;}
			ul#collapser li.parent {border: 1px solid #DDDDDD; background: none repeat scroll 0 0 #EEEEEE;margin: 3px; padding: 0.4em;}
			ul#collapser li.ispaid>a {color: #5897DB !important;}
			ul#collapser li.child {border: 1px solid #DDDDDD; background: none repeat scroll 0 0 #FFF;margin: 3px; padding: 0.4em;}
			.jqcNode { font-weight: bold; color: green;display:block;}
		</style>
		<script type="text/javascript">
			$().ready(function() {
				$('#collapser').jqcollapse({
					slide: true,
					speed: 1000,
					easing: 'easeOutCubic'
				});
				$("#serverEvent ul").show();
			});
		</script>
	</head>
	<body>
		<div class="menu" style="background-color:#307BE5; padding:5px; font-size:13px; font-weight:bold;">
			<span><a href="index.php" style="color:#333;">Quản lý CP</a></span>
		</div>
		<div style="margin-top:10px;">
			<?php
				if (isset($message)) {
					echo "<div style='font-weight:bold; color:#E12B2C;margin:3px; padding:0.4em;'>".$message."</div>";
				}
			?>
			<form action="editCP.php?id=<?php echo $cp;?>" method="POST">
				<div style="margin:3px; padding:0.4em;">
					<div>
						<table width="100%" cellspacing=0 cellpadding=0>
							<tr>
								<td width="100px"><b>CP Name</b></td>
								<td><input type="text" style="width:100px; text-align:center;" value="<?php echo $cp;?>" name="CP_NAME" readonly="readonly"/></td>
							</tr>
						</table>
					</div>
					<div>
						<b>SMS</b>
					</div>
					<div style="margin-top:5px;">
						<table width="100%" cellspacing=0 cellpadding=0>
							<tr>
								<td width="100px">BEM_DK</td>
								<td>
									ServiceCode <input type="text" id="version" style="width:100px;" value="<?php echo $sms->{"BEM_DK"}->{"ServiceCode"};?>" name="SMS_DK_SC"/>
									ServiceNumber <input type="text" id="version" style="width:50px;" value="<?php echo $sms->{"BEM_DK"}->{"ServiceNumber"};?>" name="SMS_DK_SN"/>
									Need Register <input type="checkbox" name="ENABLE_REGISTER" value='1' <?php $enable = $sms->{"BEM_DK"}->{"enable"}; if (isset($enable) && $enable == 1) {echo "checked";}?>>
								</td>
							</tr>
							<tr style="height:5px;"></tr>
							<tr>
								<td>BEM_PWD</td>
								<td>
									ServiceCode <input type="text" id="version" style="width:100px;" value="<?php echo $sms->{"BEM_PWD"}->{"ServiceCode"};?>" name="SMS_PWD_SC"/>
									ServiceNumber <input type="text" id="version" style="width:50px;" value="<?php echo $sms->{"BEM_PWD"}->{"ServiceNumber"};?>" name="SMS_PWD_SN"/>
								</td>
							</tr>
							<tr style="height:5px;"></tr>
							<tr>
								<td>BEM_TANG</td>
								<td>
									ServiceCode <input type="text" id="version" style="width:100px;" value="<?php echo $sms->{"BEM_TANG"}->{"ServiceCode"};?>" name="SMS_TANG_SC"/>
									ServiceNumber <input type="text" id="version" style="width:50px;" value="<?php echo $sms->{"BEM_TANG"}->{"ServiceNumber"};?>" name="SMS_TANG_SN"/>
									Koin <input type="text" id="version" style="width:50px;" value="<?php echo $sms->{"BEM_TANG"}->{"koin"};?>"  name="SMS_TANG_KOIN"/>
								</td>
							</tr>
							<tr style="height:5px;"></tr>
							<tr>
								<td>BEM_KOIN</td>
								<td>
									ServiceCode <input type="text" id="version" style="width:100px;" value="<?php echo $sms->{"BEM_KOIN"}->{"ServiceCode"};?>" name="SMS_KOIN_SC"/>
									ServiceNumber <input type="text" id="version" style="width:50px;" value="<?php echo $sms->{"BEM_KOIN"}->{"ServiceNumber"};?>" name="SMS_KOIN_SN"/>
									Koin <input type="text" id="version" style="width:50px;" value="<?php echo $sms->{"BEM_KOIN"}->{"koin"};?>" name="SMS_KOIN_KOIN"/>
								</td>
							</tr>
							<tr style="height:5px;"></tr>
							<tr>
								<td valign="top">
									<div style="margin-top:6px;">BEM_NAP</div>
								</td>
								<td>
									ServiceCode <input type="text" id="version" style="width:100px;" value="<?php echo $sms->{"BEM_NAP"}->{"ServiceCode"};?>" name="SMS_NAP_SC"/>
									<?php 
										$count = 1;
										foreach ($sms->{"BEM_NAP"}->{"ServiceNumber"} as $child) {
											echo "<br/>";
											echo "ServiceNumber <input type=\"text\" id=\"version\" style=\"width:50px;\" value=\"".$child->{"sn"}."\" name=\"SMS_NAP{$count}_SN\"/>";
											echo "Koin <input type=\"text\" id=\"version\" style=\"width:50px;\" value=\"".$child->{"koin"}."\" name=\"SMS_NAP{$count}_KOIN\"/>";
											$count++;
										}
										for ($i=$count;$i<=3;$i++) {
											echo "<br/>";
											echo "ServiceNumber <input type=\"text\" id=\"version\" style=\"width:50px;\" value=\"\" name=\"SMS_NAP{$i}_SN\"/>";
											echo "Koin <input type=\"text\" id=\"version\" style=\"width:50px;\" value=\"\" name=\"SMS_NAP{$i}_KOIN\"/>";
										}
									?>
								</td>
							</tr>
							<tr style="height:5px;"></tr>
							<tr>
								<td>BEM_ACTIVE</td>
								<td>
									ServiceCode <input type="text" id="active" style="width:100px;" value="<?php echo $sms->{"BEM_ACTIVE"}->{"ServiceCode"};?>" name="SMS_ACTIVE_SC"/>
									ServiceNumber <input type="text" id="active" style="width:50px;" value="<?php echo $sms->{"BEM_ACTIVE"}->{"ServiceNumber"};?>" name="SMS_ACTIVE_SN"/>
									Enable Active 
									<select name="ENABLE_ACTIVE">
									<?php
										$enable = $enable = $sms->{"BEM_ACTIVE"}->{"enable"};
										if (!isset($enable)) {
											$enable = 0;
										}
										for ($i=0;$i<3;$i++) {
											if ($i == $enable) {
												echo "<option value=${i} selected>${i}</option>";
											} else {
												echo "<option value=${i}>${i}</option>";
											}
										}
									?>
									</select>
									1: active when login, 2: active when play
								</td>
							</tr>
						</table>
					</div>
					<div style="margin-top:5px;">
						<b>Version J2ME</b>
					</div>
					<div style="margin-top:5px;">
						<table width="100%" cellspacing=0 cellpadding=0>
							<tr>
								<td width="150px">version</td>
								<td><input type="text" id="version" style="width:150px;" value="<?php echo $version->{"version"};?>" name="VER_VERSION"/></td>
							</tr>
							<tr>
								<td width="150px">version_force</td>
								<td><input type="text" id="version" style="width:150px;" value="<?php echo $version->{"version_force"};?>" name="VER_VERSION_FORCE"/></td>
							</tr>
							<tr>
								<td valign="top" width="150px">message_update</td>
								<td><textarea id="version" style="width:600px; height:75px;" name="VER_MSG_UPDATE"><?php echo $version->{"message_update"};?></textarea></td>
							</tr>
							<tr>
								<td valign="top" width="150px">message_force</td>
								<td><textarea id="version" style="width:600px; height:75px;" name="VER_MSG_FORCE"><?php echo $version->{"message_force"};?></textarea></td>
							</tr>
							<tr>
								<td valign="top" width="150px">wap</td>
								<td><textarea id="version" style="width:600px; height:75px;" name="VER_WAP"><?php echo $version->{"wap"};?></textarea></td>
							</tr>
						</table>
					</div>
					<div style="margin-top:5px;">
						<b>Version ANDROID</b>
					</div>
					<div style="margin-top:5px;">
						<table width="100%" cellspacing=0 cellpadding=0>
							<tr>
								<td width="150px">version</td>
								<td><input type="text" id="version" style="width:150px;" value="<?php echo $version_android->{"version"};?>" name="VER_VERSION_ANDROID"/></td>
							</tr>
							<tr>
								<td width="150px">version_force</td>
								<td><input type="text" id="version" style="width:150px;" value="<?php echo $version_android->{"version_force"};?>" name="VER_VERSION_FORCE_ANDROID"/></td>
							</tr>
							<tr>
								<td valign="top" width="150px">message_update</td>
								<td><textarea id="version" style="width:600px; height:75px;" name="VER_MSG_UPDATE_ANDROID"><?php echo $version_android->{"message_update"};?></textarea></td>
							</tr>
							<tr>
								<td valign="top" width="150px">message_force</td>
								<td><textarea id="version" style="width:600px; height:75px;" name="VER_MSG_FORCE_ANDROID"><?php echo $version_android->{"message_force"};?></textarea></td>
							</tr>
							<tr>
								<td valign="top" width="150px">wap</td>
								<td><textarea id="version" style="width:600px; height:75px;" name="VER_WAP_ANDROID"><?php echo $version_android->{"wap"};?></textarea></td>
							</tr>
						</table>
					</div>
					<div style="margin-top:5px;">
						<b>Version IPHONE</b>
					</div>
					<div style="margin-top:5px;">
						<table width="100%" cellspacing=0 cellpadding=0>
							<tr>
								<td width="150px">version</td>
								<td><input type="text" id="version" style="width:150px;" value="<?php echo $version_iphone->{"version"};?>" name="VER_VERSION_IPHONE"/></td>
							</tr>
							<tr>
								<td width="150px">version_force</td>
								<td><input type="text" id="version" style="width:150px;" value="<?php echo $version_iphone->{"version_force"};?>" name="VER_VERSION_FORCE_IPHONE"/></td>
							</tr>
							<tr>
								<td valign="top" width="150px">message_update</td>
								<td><textarea id="version" style="width:600px; height:75px;" name="VER_MSG_UPDATE_IPHONE"><?php echo $version_iphone->{"message_update"};?></textarea></td>
							</tr>
							<tr>
								<td valign="top" width="150px">message_force</td>
								<td><textarea id="version" style="width:600px; height:75px;" name="VER_MSG_FORCE_IPHONE"><?php echo $version_iphone->{"message_force"};?></textarea></td>
							</tr>
							<tr>
								<td valign="top" width="150px">wap</td>
								<td><textarea id="version" style="width:600px; height:75px;" name="VER_WAP_IPHONE"><?php echo $version_iphone->{"wap"};?></textarea></td>
							</tr>
						</table>
					</div>
					<div style="margin-top:5px;">
						<input type="submit" value="Cập nhật"/>
						<input type="button" value="Hủy" onclick="window.location='cp.php'">
					</div>
				</div>
			</form>
		</div>
    </body>
</html>