<?php
	require('constans.php');
	require('api/db.class.php');

/*	echo $_POST["CP_NAME"]."<br/>";
	echo $_POST["cmmSms_DK_SC"]."<br/>";
	echo $_POST["cmmSms_DK_SN"]."<br/>";
	
	echo $_POST["cmmSms_PWD_SC"]."<br/>";
	echo $_POST["cmmSms_PWD_SN"]."<br/>";
	
	echo $_POST["cmmSms_TANG_SC"]."<br/>";
	echo $_POST["cmmSms_TANG_SN"]."<br/>";
	echo $_POST["cmmSms_TANG_KOIN"]."<br/>";
	
	echo $_POST["cmmSms_KOIN_SC"]."<br/>";
	echo $_POST["cmmSms_KOIN_SN"]."<br/>";
	echo $_POST["cmmSms_KOIN_KOIN"]."<br/>";
	
	echo $_POST["cmmSms_NAP_SC"]."<br/>";
	echo $_POST["cmmSms_NAP1_SN"]."<br/>";
	echo $_POST["cmmSms_NAP1_KOIN"]."<br/>";
	echo $_POST["cmmSms_NAP2_SN"]."<br/>";
	echo $_POST["cmmSms_NAP2_KOIN"]."<br/>";
	echo $_POST["cmmSms_NAP3_SN"]."<br/>";
	echo $_POST["cmmSms_NAP3_KOIN"]."<br/>";
	
	echo $_POST["VER_cmmVersion"]."<br/>";
	echo $_POST["VER_cmmVersion_FORCE"]."<br/>";
	echo $_POST["VER_MSG_UPDATE"]."<br/>";
	echo $_POST["VER_MSG_FORCE"]."<br/>";
	echo $_POST["VER_WAP"]."<br/>";
*/	

	$sql = "select * from config c where c.key like 'common%'";
	try {
		foreach ($db->query($sql) as $row) {
			if ($row['key'] == "common_cp") {				
				$cmmCp = json_decode($row['value']);
			} else if ($row['key'] == "common_sms") {
				$cmmSms = json_decode($row['value']);
			} else if ($row['key'] == "common_version") {
				$cmmVersion = json_decode($row['value']);
			}
		}
	} catch (Exception $e) {
		echo $e->getMessage();
	}
	
	if (isset($_POST["CP_NAME"])) {
		$listCP = $_POST["CP_NAME"];
		$listCP = str_replace("\r", "", $listCP);
		$listCP = str_replace("\n", "", $listCP);
		$listCP = str_replace(" ", "", $listCP);
		$pieces = explode(",", $listCP);
		$output="";
		foreach ($pieces as $value) {
			if ($value != "") {
				$output = $output.",\\\"".$value."\\\"";
			}
		}
		$output = substr($output, 1);

		$sql = "update config c set value=\"{\\\"cp\\\":[".$output."]}\" where c.key='common_cp'";
		try {
			$db->exec($sql);
		} catch (Exception $e) {
			$message = $e->getMessage();
		}
		if (!isset($message)) {
			header('Location: cp.php');
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
			<form action="editCommonCP.php" method="POST">
				<div style="margin:3px; padding:0.4em;">
					<div>
						<table width="100%" cellspacing=0 cellpadding=0>
							<tr>
								<td width="100px"><b>List CP</b></td>
								<td>
									<textarea type="text" style="width:600px; height:300px;" name="CP_NAME"><?php
											$output = "";
											foreach ($cmmCp->{"cp"} as $cp) {
												$output = $output.", ".trim($cp);
											}								
											echo trim(substr($output, 1));
										?></textarea>
								</td>
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