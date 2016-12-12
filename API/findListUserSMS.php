<?php

require('../Config.php');
require('db.class.php');
$mobile = $_GET['mobile'];
if (isset($mobile) && strlen($mobile) >= 11) {
    try {
        $sql = "SELECT au.message AS username FROM gim_wap.auth_user_partner au WHERE sender = '$mobile' AND service = 'NAP' GROUP BY au.message
        UNION ALL
        SELECT SUBSTRING_INDEX(SUBSTRING_INDEX(sms, ' ', 3), ' ', -1) as username FROM logsms.logsms_mv WHERE sender = '$mobile' AND SUBSTRING_INDEX(SUBSTRING_INDEX(sms, ' ', 2), ' ', -1) = 'NAP' GROUP BY sms";
        //echo $sql;
        $found = false;
        $resultData = array();
        $html = "<table width='100%'><tr style='background-color: rgb(255, 255, 255);text-align:center;'>";
        $html .= "<td>Username</td><td>Koin</td><td>Function</td>";
        $i = 0;
        foreach ($db->query($sql) as $row) {
            $i+=1;
            $found = true;
            $row['username'] = strtolower($row['username']);
            $html .= "<tr style='background-color: rgb(" . ($i % 2 > 0 ? "204,204,204" : "255, 255, 255") . ");text-align:center;'>";
            $html .= "<td width=''>" . $row['username'] . "</td>";
            $html .= "<td width='10%'>" . userKoin($row['username']) . "</td>";
            $html .= '<td width=\'40%\'><input type="checkbox" id="usernamesmsmobile" name="usernamesmsmobile" value="'.$row['username'].'" /> <input placeholder="Lý do" type="text" id="causesmsmobile'.$row['username'].'" name="causesmsmobile'.$row['username'].'" value="" /> <input type="button" value="Block '.$row['username'].'" onClick="blockUserName(\''.$row['username'].'\', \'causesmsmobile'.$row['username'].'\')" /></td>';
			
            $html .= "</tr>";
        }
        $html .= '<tr><td colspan="2"></td><td><input type="button" onClick="selectListUserNameSMSMobile();" value="Select All" /><input placeholder="Lý do" type="text" id="causeallsmsmobile" name="causeallsmsmobile" value="" /><input type="button" onClick="blockListUserNameSMSMobile();" value="Block All" /></td></tr>';
        $html .= "</table>";
        if ($found == true) {
            echo $html;
            exit;
        }
        if ($found == false) {
            echo "Không tìm thấy username";
        }
    } catch (Exception $e) {
        echo $e->getMessage();
    }
} else {
    echo "<b>Chưa nhập sdt hoặc nhập sai sdt</b>";
}

function userKoin($user)
{
	global $db;
	$sql = "SELECT * FROM auth_user WHERE username = '$user'";
	$koin = 0;
	foreach($db->query($sql) as $row)
	{
		$koin = $row['koin'];
	}
	return number_format($koin);
}
?>
