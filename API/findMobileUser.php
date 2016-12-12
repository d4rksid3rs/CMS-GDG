<?php
$host="local.db";
$user="root";
$password="";
mysql_connect($host,$user,$password);
mysql_select_db('logsms') or die(mysql_error());
$u = $_REQUEST['username'];
//echo "SELECT sender FROM logsms_mv WHERE sms LIKE '%NAP $u%' GROUP BY sender";
$sql = mysql_query("SELECT sender FROM logsms.logsms_mv WHERE sms LIKE '%NAP $u' GROUP BY sender UNION ALL SELECT sender FROM gim_wap.auth_user_partner WHERE message LIKE '$u' GROUP BY sender") or die(mysql_error());
$str = "";
while($row = mysql_fetch_assoc($sql))
{
	$str .= $row['sender'].' - ';
}
echo "<b>Danh sách số điện thoại:</b> ".substr($str,0,-2);
?>
