<?php
require('../Config.php');
require('db.class.php');
$gamevms = $_POST['vms'];
$sql = "select * from config c where c.key='config_server'";
foreach ($db->query($sql) as $row) {
	$key = $row['value'];
	//str_replace("]","",str_replace("[","",)));
	break;
}
$value = json_decode($row['value']);
$new = new stdClass();
foreach($value as $k=>$v)
{
	if($k == "isDisplayPopupVMS")
	{
		$new->$k = $gamevms;
	}
	else
		$new->$k = $v;
}
$v_new = addslashes(json_encode($new));

try {	
    	$sql =  "UPDATE config SET `value`='$v_new' WHERE `key`='config_server';";
	$db->query($sql);
	file_get_contents("http://tk.trachanhquan.com/bi/API/reloadConfig.php");
	echo "{\"status\":1,\"message\":\"Thành công rồi, hãy refresh lại trình duyệt\"}";
} catch (Exception $e) {
    echo "{\"status\":0,\"message\":\"" . $e->getMessage() . "\"}";
}	

    
?>
