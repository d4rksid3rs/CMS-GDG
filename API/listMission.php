<?php

require('../Config.php');
require('db.class.php');
$type = $_REQUEST['type'];
$id = $_REQUEST['id'];
$title = $_REQUEST['title'];
$mesg = $_REQUEST['msg'];
$koin = $_REQUEST['koin'];
$maxPerDay = $_REQUEST['maxPerDay'];
$enable = ($_REQUEST['enable'] == 1)?true:false;
$sql = "select value from config where `key` = 'config_mission' limit 0,1";
$json = "";
foreach ($db->query($sql) as $row) {
	$json = $row['value']; 
}
$arr = json_decode($json, true);
$msg = '';
if ($type == 'get')
{
	foreach($arr['mission'] as $mission)
	{
		if($mission['id'] == $id)
		{
			$msg .= '<br /><input type="hidden" id="mid" name="mid" style="width: 300px;" value="'. $mission['id']. '" />';
			$msg .= 'Title: <input type="text" id="title" name="title" style="width: 300px;" value="'. $mission['title']. '" /><br />';
			$msg .= 'Message: <input type="text" id="msg" name="msg" style="width: 300px;" value="'. $mission['msg'] .'" /><br />';
			$msg .= 'Koin: <input type="text" id="koin" name="koin" style="width: 300px;" value="'. $mission['koin'] .'" /><br />';
			$msg .= 'Số lần nhận: <input type="text" id="maxPerDay" name="maxPerDay" style="width: 300px;" value="'. $mission['maxPerDay'] .'" /><br />';
			$msg .= 'Enable <input type="checkbox" id="enable" name="enable" ';
			if($mission['enable']) 
				$msg .= 'checked="checked"';
			$msg .= ' /> <br />';
			$msg .= '<input type="button" name="btnEditMission" value="Sửa" onclick="editMission();" />';
			break;
		}
	}
	$status = 1;
	$message = $msg;
	$json_arr = array('status'=> $status, 'message'=>$msg);
	echo json_encode($json_arr);
} else if ($type == 'edit')
{
	$new_arr['app'] = $arr['app'];
	$arr_mission = array();
	$i = 0;
	foreach($arr['mission'] as $mission)
	{
		if($mission['id'] == $id)
		{
			$a = array();
			$a['id'] = $id;
			$a['koin'] = $koin;
			$a['title'] = $title;
			$a['msg'] = $mesg;
			$a['enable'] = $enable;
			$a['maxPerDay'] = $maxPerDay;
			$arr_mission[] = $a;
		}
		else
		{
			$a = array();
			$a['id'] = $arr['mission'][$i]['id'];
			$a['koin'] = $arr['mission'][$i]['koin'];
			$a['title'] = $arr['mission'][$i]['title'];
			$a['msg'] = $arr['mission'][$i]['msg'];
			$a['enable'] = $arr['mission'][$i]['enable'];
			$a['maxPerDay'] = $arr['mission'][$i]['maxPerDay'];
			$arr_mission[] = $a;
		}
		$i++;
	}
//	$new_arr['mission'] = $arr_mission;
//	$json = json_encode($new_arr);
        $arr['mission'] = $arr_mission;
	$json = json_encode($arr);
	$json = mysql_escape_string($json);
	$sql = "UPDATE config SET `value` = '$json' WHERE `key` = 'config_mission'";
	$db->query($sql);
	$status = 1;
	$message = "Cập nhật thành công";
	
	$json_arr = array('status'=> $status, 'message'=>$message);
	echo json_encode($json_arr);
	file_get_contents('http://beme.net.vn/bi1/API/reloadConfig.php');
	
}
?>
