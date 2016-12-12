<?php

require('../Config.php');
require('db.class.php');
$phonenumber = $_GET['phonenumber'];
if (isset($phonenumber) && strlen($phonenumber) >= 8) {
    try {
        $sql = "SELECT auth_user.* FROM auth_user WHERE mobile LIKE '%$phonenumber%'";
        $found = false;
        $resultData = array();
        $html = "<table width='100%'><tr style='background-color: rgb(255, 255, 255);text-align:center;'>";
        $html .= "<td>Username</td><td>Xu</td><td>Chip</td><td>Time</td><td>Function</td>";
        $i = 0;
        foreach ($db->query($sql) as $row) {
            $i+=1;
            $found = true;
            $html .= "<tr style='background-color: rgb(" . ($i % 2 > 0 ? "204,204,204" : "255, 255, 255") . ");text-align:center;'>";
            $html .= "<td width='5%'>" . $row['username'] . "</td>";
            $html .= "<td width='5%'>" . $row['koin'] . "</td>";
            $html .= "<td width='5%'>" . $row['koin_vip'] . "</td>";
            $html .= "<td width='6%'>" . $row['created_on'] . "</td>";
            $html .= '<td width=\'10%\'><input type="checkbox" id="usernamemobile" name="usernamemobile" value="'.$row['username'].'" /> <input placeholder="Lý do" type="text" id="causemobile'.$row['username'].'" name="causemobile'.$row['username'].'" value="" /> <input type="button" value="Block '.$row['username'].'" onClick="blockUserName(\''.$row['username'].'\', \'causemobile'.$row['username'].'\')" /></td>';
			
            $html .= "</tr>";
        }
        $html .= '<tr><td colspan="3"></td><td><input type="button" onClick="selectListUserNameMobile();" value="Select All" /><input placeholder="Lý do" type="text" id="causeallmobile" name="causeallmobile" value="" /><input type="button" onClick="blockListUserNameMobile();" value="Block All" /></td></tr>';
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
?>
