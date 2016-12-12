<?php
	$user = "";
	$serial = "";
	$code = "";
	$issuer = "";
	if (isset($_POST['username'])) {
		$user = $_POST['username'];
		$serial = $_POST['serial'];
		$code = $_POST['code'];
		$issuer = $_POST['issuer'];
		$msg = file_get_contents("http://api.phang.mobi/the/clientreq_all.php?issuer={$issuer}&cardCode={$code}&userName={$user}&serial={$serial}", true);
	}
?>
<html>
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8">
		<title>Nạp thẻ</title>
	</head>
	<body>
		<form method="POST" action="">
			<table>
				<tr>
					<td>Username</td>
					<td><input type="text" name="username" value="<?php echo $user;?>"/></td>
				</tr>
				<tr>
					<td>Issuer</td>
					<td>
						<select name="issuer">
							<option value="VTT">Viettel</option>
							<option value="VINA">Vina</option>
							<option value="MOBI">Mobi</option>
						</select>
					</td>
				</tr>
				<tr>
					<td>Serial</td>
					<td><input type="text" name="serial" value="<?php echo $serial;?>"/> - BMM077226</td>
				</tr>
				<tr>
					<td>Code</td>
					<td><input type="text" name="code" value="<?php echo $code;?>"/> - 54151232127157</td>
				</tr>
				<tr>
					<td colspan=2><input type="submit"/> <font size="18" color="red"><strong><?php if (isset($msg)) {echo $msg;}?></strong></font></td>
				</tr>
			</table>
		</form>
	</body>
</html>