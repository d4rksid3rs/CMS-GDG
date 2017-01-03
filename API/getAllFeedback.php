<?php
require('../Config.php');
require('db.class.php');
try {
    $userId = $_GET['uid'];
        $sql = "SELECT f.* FROM feedback f WHERE user_id = $userId order by date_created ASC";
        //echo $sql;
?>
<table width="100%" cellspacing="1" border="1" style="font-size:13px;">
<thead>
    <tr>
        <th style="width: 5%;" align="center">STT</th>
        <th style="width: 10%;" align="center">Tài khoản</th>
        <th style="width: 10%;" align="center">Số điện thoại</th>
        <th>Nội dung</th>
        <th style="width: 100px;" align="center">Ngày</th>
    </tr>
</thead>
<tbody>
<?php        
	$count = 1;
        foreach ($db->query($sql) as $row) {
		    $comments[] = array('username' => $row['user'],
		        'comment' => $row['feedback'],
		        'date' => $row['date_created'],
		        'mobile' => $row['mobile'],
		        'id' => $row['id'],
		        'status' => $row['status'],
		        'userId' => $row['user_id']);
		
		        echo "<tr>";
                echo "<td align=center>" . $count . "</td>";
                echo "<td align=center>" . $row['user'] . "</td>";
                echo "<td align=center>" . $row['mobile'] . "</td>";
                if ($row['status'] == 1) {
					$index = strrpos($row['feedback'],'->');
					if ($index === false) {
						echo "<td class=comment>" . $row['feedback'] . "<font color=#4965AF> - đã xử lý</font></td>";
					} else {
						echo "<td class=comment>" . substr($row['feedback'],0,$index-1) . "<br /><font color=#909>".substr($row['feedback'],$index-1)."</font></td>";
					}
                } else {
                    echo "<td class=comment>" . $row['feedback'] . "</td>";
                }
                echo "<td align=center>" . $row['date_created'] . "</td>";
                $count++;
		}
		//echo json_encode($comments);
?>
 </tbody>
                    </table>
<?php
} catch (Exception $e) {
    echo "{\"status\":0,\"" . $e->getMessage() . "\"}";
}
?>
