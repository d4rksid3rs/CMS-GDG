<?php

require('../Config.php');
require('db.class.php');
$passport = $_GET['passport'];
    try {
        $sql = "SELECT username, lock_time FROM user WHERE passport = '$passport' LIMIT 0,100";
        //echo $sql;
        $found = false;
        $resultData = array();
        $html = "<table width='100%'><tr style='background-color: rgb(255, 255, 255);text-align:center;'>";
        $html .= "<td>Username</td><td>Koin</td><td>Lock</td><td>Function</td>";
        $i = 0;
        foreach ($db->query($sql) as $row) {
            $i+=1;
            $found = true;
            $row['username'] = strtolower($row['username']);
            $html .= "<tr style='background-color: rgb(" . ($i % 2 > 0 ? "204,204,204" : "255, 255, 255") . ");text-align:center;'>";
            $html .= "<td width=''>" . $row['username'] . "</td>";
            $html .= "<td width='10%'>" . userKoin($row['username']) . "</td>";
            $html .= "<td width=''>" . $row['lock_time'] . "</td>";
            $html .= '<td width=\'40%\'><input type="checkbox" id="usernamepassport" name="usernamepassport" value="'.$row['username'].'" /> <input placeholder="Lý do" type="text" id="causepassport'.$row['username'].'" name="causepassport'.$row['username'].'" value="" /> <input type="button" value="Block '.$row['username'].'" onClick="blockUserName(\''.$row['username'].'\', \'causepassport'.$row['username'].'\')" /></td>';
			
            $html .= "</tr>";
        }
        $html .= '<tr><td colspan="3"></td><td><input type="button" onClick="selectListUserNamePassport();" value="Select All" /><input placeholder="Lý do" type="text" id="causeallpassport" name="causeallpassport" value="" /><input type="button" onClick="blockListUserNamePassport();" value="Block All" /></td></tr>';
        $html .= "</table>";
        if ($found == true) {
            echo $html;
            exit;
        }
        if ($found == false) {
            echo "Không tìm thấy username nào!";
        }
    } catch (Exception $e) {
        echo $e->getMessage();
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
