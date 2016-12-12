<?php
$username = $_GET["username"];
require('socket1.php');
$service = 0xF903;
$input = "{\"username\":\"" . $username . "\"}";
$str = sendMessage($service, $input);
$str1 = sendMessage1($service, $input);
if($str === $str1)
	echo $str;
else
{
	$jsonData = json_decode($str, true);
	$jsonData1 = json_decode($str, true);
	if($jsonData['status'] == 1)
		echo $str;
	else
		echo $str1;
}
//$jsonData = json_decode(sendMessage($service, $input));
?>
