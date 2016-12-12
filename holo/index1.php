<?php 
	require('api/db.class.php');
	$sql = "select * from config";
	try {
		foreach ($db->query($sql) as $row) {
			if ($row['key'] == "server_config") {
				$serverConfig = json_decode($row['value']);
			} else if ($row['key'] == "server_api") {
				$serverAPI = json_decode($row['value']);
			} else if (startsWith($row['key'], "common") or startsWith($row['key'],"sms") or startsWith($row['key'],"version")) {
				if ($row['key'] == "common_cp") {
					$commonCP = json_decode($row['value']);
				} else if ($row['key'] == "common_sms") {
					$commonCP = json_decode($row['value']);
				} else if ($row['key'] == "common_version") {
					$commonCP = json_decode($row['value']);
				}
			} else if ($row['key'] == "server_config") {
			} else if ($row['key'] == "server_config") {
			} else if ($row['key'] == "server_config") {
			} else if ($row['key'] == "server_config") {
			}
		}
	} catch (Exception $e) {
		echo $e->getMessage();
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
		<style>
			body{font-family: Tahoma,Verdana,Arial; font-size: 12px; margin:0; padding:0;}
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
			<span>Cấu hình</span>
		</div>
		<div style="margin-top:10px;">
			<ul id="collapser">
				<li class='parent' id="serverConfig">
					Server
					<ul>
						<li class='child'>
							<b>Default item: </b>
							<?php 
								foreach ($serverConfig->{"bonus_item"} as $row) {
									echo $row->{"type"}."(".$row->{"quantity"}.") ";
								}
							?>
						</li>
						<li class='child'>
							<b>Disable games: </b>
							<?php
								$output = "";
								foreach ($serverConfig->{"disableGames"} as $row) {
									$output .= " - ".$row;
								}
								echo substr($output, 3);
							?>
						</li>
						<li class='child'>
							<b>Admin: </b>
							<?php
								echo $serverConfig->{"admin"};
							?>
						</li>
						<li class='child'>
							<b>Shutdown: </b>
							<?php
								echo $serverConfig->{"shutdown"};
							?>
							<b>Message: </b>
							<?php
								echo $serverConfig->{"shutdownMessage"};
							?>
						</li>
						<li class='child'>
							<b>Monitor: </b>
							<?php
								echo "debug: ".$serverConfig->{"debug"}.", logKoin >= ".$serverConfig->{"min_log_koin"}." koin, Size process koin in memory = ".$serverConfig->{"koin_size"}.", speakerTime: ".$serverConfig->{"speaker_time"}." ms";
							?>
						</li>
					</ul>
				<li>
				<li class='parent' id="serverAPI">
					API 2
					<ul>
						<li class='child'>
							<b>Topup: </b>
							<?php
								echo $serverAPI->{"top_up"};
							?>
						</li>
						<li class='child'>
							<b>Exist User: </b>
							<?php
								echo $serverAPI->{"exist"};
							?>
						</li>
						<li class='child'>
							<b>Login: </b>
							<?php
								echo $serverAPI->{"login"};
							?>
						</li>
						<li class='child'>
							<b>Change password: </b>
							<?php
								echo $serverAPI->{"change_password"};
							?>
						</li>
						<li class='child'>
							<b>User infor: </b>
							<?php
								echo $serverAPI->{"user_infor"};
							?>
						</li>
						<li class='child'>
							<b>Top đại gia: </b>
							<?php
								echo $serverAPI->{"top_rich"};
							?>
						</li>
					</ul>
				<li>
				<li class='parent' id="serverSMS">
					SMS and Version
					<ul>
						<li class='child'>Topup:</li>
						<li class='child'>Exist:</li>
						<li class='child'>Login</li>
					</ul>
				<li>
				<li class='parent' id="serverVersion">
					Version
					<ul>
						<li class='child'>Topup</li>
						<li class='child'>b</li>
						<li class='child'>c</li>
					</ul>
				<li>
				<li class='parent' id="serverGame">
					Game
					<ul>
						<li class='child'>a</li>
						<li class='child'>b</li>
						<li class='child'>c</li>
					</ul>
				<li>
				<li class='parent' id="serverEvent">
					Event
					<ul>
						<li class='child'>a</li>
						<li class='child'>b</li>
						<li class='child'>c</li>
					</ul>
				<li>
			</ul>
		</div>
		<script>
			
		</script>
    </body>
</html>