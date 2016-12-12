<?php
require('../Config.php');
require('db.class.php');
$u = $_REQUEST['username'];
//$sql = "SELECT * FROM user WHERE username LIKE '$u%' ORDER BY date_created DESC";
$sql = "SELECT * FROM user WHERE username REGEXP '^".$u."[0-9]{0,2}$' OR screen_name = '$u'";
$str = "";
?>
<table width="100%" cellspacing="1" style="font-size:13px;" id="listUser">
    <thead>
        <tr style="background-color: rgb(204, 204, 204);">
            <th align="center" style="width: 150px;">Username</th>
			<th align="center" style="width: 100px;">Xu</th>
                        <th align="center" style="width: 100px;">Chip</th>
			<th align="center" style="width: 100px;">Money</th>
			<th align="center" style="width: 100px;">Function</th>
        </tr>
    </thead>
<?php
echo '<tbody style="background-color: white;">';
foreach ($db->query($sql) as $row)
{
	echo '<tr>';
//	$str .= $row['sender'].' - ';
	echo '<td>'.$row['username'].'</td>';
	echo '<td>'.getBalance($row['username']).'</td>';
        echo '<td>'.getChip($row['username']).'</td>';
	echo '<td>'.sumMoney($row['username']).'</td>';
	echo '<td><input type="checkbox" id="username" name="username" value="'.$row['username'].'" /> <input placeholder="Lý do" type="text" id="cause'.$row['username'].'" name="cause'.$row['username'].'" value="" /> <input type="button" value="Block '.$row['username'].'" onClick="blockUserName(\''.$row['username'].'\', \'cause'.$row['username'].'\')" /></td>';
	echo '</tr>';
}
echo '<tr><td colspan="4"></td><td><input type="button" onClick="selectListUserName();" value="Select All" /> <input placeholder="Lý do" type="text" id="causeall" name="causeall" value="" /> <input type="button" onClick="blockListUserName();" value="Block" /></td></tr>';
echo '</tbody></table>';
function sumMoney($u)
{
	global $db;
	$sql = 'SELECT SUM(money) money FROM log_nap_koin WHERE username = \''.$u.'\' GROUP BY username LIMIT 1';
	$money = 0;
	foreach($db->query($sql) as $row)
	{
		$money = $row['money'];
	}
	return number_format($money) . ' vnđ';
}
function getBalance($u)
{
	global $db;
	$sql = 'SELECT * FROM auth_user WHERE username = \''.$u.'\' LIMIT 1';
	$ba = 0;
	foreach($db->query($sql) as $row)
	{
		$ba = $row['koin'];
	}
	return number_format($ba) . ' xu';
}

function getChip($u)
{
	global $db;
	$sql = 'SELECT * FROM auth_user WHERE username = \''.$u.'\' LIMIT 1';
	$ba = 0;
	foreach($db->query($sql) as $row)
	{
		$ba = $row['koin_vip'];
	}
	return number_format($ba) . ' chip';
}
?>
