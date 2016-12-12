<?php
	if (isset($_REQUEST['u'])) {
		$username = $_REQUEST['u'];
		
		try {
			$redis = new Redis();
			$redis->connect('local.redis');
			echo "${username} : ".$redis->get("o${username}");
			if (isset($_REQUEST['d'])) {
				echo " -> ".$redis->del("o${username}");
			}
			//echo " -> ".$redis->del("blngayxaque2010");
			$redis->close();
		} catch (Exception $e){
		}
	}
?>

<html>
	<head>
	</head>
	<body>
		<form action="" method="get">
			<input type = "text" name="u"/>
			<input type = "submit" />
		</form>
	</body>
</html>