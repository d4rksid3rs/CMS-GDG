
<?php
//uck,shit, địt, dit, lồn, lon, buồi, buoi, cac, cặc, cứt, cut, đái, dai, ỉa, ia, đụ, du, dcm, cm, dkm
require('../Config.php');
require('db.class.php');
require('socket1.php');
$content = $_POST['content'];
if (strlen($content) > 0) {
	$tmp = explode(",", $content);
	for($i = 0; $i < count($tmp); $i++) {
		$tmp[$i] = trim($tmp[$i], " ");
	}
	
	$output = "";
	for($i = 0; $i < count($tmp); $i++) {
		if (strlen($tmp[$i]) > 0) {
			$output = $output.",\"".$tmp[$i]."\"";
		}
	}
	if (strlen($output) > 0) {
		$output = substr($output, 1);
	}
	
	$output = "[".$output."]";
	//$content = "[\"".str_replace(",", "\",\"",$content)."\"]";
	
	$content = mysql_escape_string($output);
	
	try {	
        $sql = "update config c set c.value=\"${content}\" where c.key='config_chatmessage'";
		$db->query($sql);
		echo "{\"status\":1,\"message\":\"Lưu thành công\"}";
		sendMessage(0xF90C, "{}");
    } catch (Exception $e) {
        echo "{\"status\":0,\"message\":\"" . $e->getMessage() . "\"}";
    }
}	
    
?>
