
<?php
//uck,shit, địt, dit, lồn, lon, buồi, buoi, cac, cặc, cứt, cut, đái, dai, ỉa, ia, đụ, du, dcm, cm, dkm
require('../Config.php');
require('db.class.php');
require('socket1.php');
$sql_setting = "SELECT * FROM config WHERE `key` = 'config_server'";
foreach($db->query($sql_setting) as $row)
{
	$json_settings = json_decode($row['value'], true);
}
$viettel = $_POST['viettel'];
$vina = $_POST['vina'];
$mobi = $_POST['mobi'];
$sms = $_POST['sms'];
$sms = explode(',',$sms);
$json_settings['payment']['viettel'] = $viettel;
$json_settings['payment']['vina'] = $vina;
$json_settings['payment']['mobi'] = $mobi;
$json_settings['payment']['sms'] = $sms;
$content = json_encode($json_settings);
	try {
		$content = mysql_escape_string($content);
        $sql = "update config c set c.value=\"$content\" where c.key='config_server'";
        //echo $sql;
		$db->query($sql);
		file_get_contents("http://beme.net.vn/bi1/API/reloadConfig.php");
		echo "{\"status\":1,\"message\":\"Lưu thành công\"}";
		//sendMessage(0xF90C, "{}");
    } catch (Exception $e) {
        echo "{\"status\":0,\"message\":\"" . $e->getMessage() . "\"}";
    }	
    
?>
