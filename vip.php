<?php
session_start();
$u = isset($_SESSION['username']) ? $_SESSION['username'] : 'foobar';
//inecho $u;
?>
<!DOCTYPE html>
<html>
    <head>
        <title>VIP User</title>
        <?php require('header.php'); ?>
    </head>
    <body>

        <div class="pagewrap">
            <?php require('topMenu.php'); ?>
            <div class="box grid">
                <div class="topheader">
                    <ul class="top-filter">
                        <li><a href="vipweekly.php">Vip theo tuần</a></li> | 
                        <li><a href="vipdaily.php">Vip theo ngày</a></li> | 
                        <li><a href="viptype.php">Vip theo cấp độ</a> </li>
                    </ul>
                </div>
                <div class="box_header"><a href="javascript:void(0);">VIP user</a></div>
                <div class="box_body">
                    <table width="100%">
                        <div style="padding-left:10px;">
                            <?php
                            include 'connectdb_gimwap.php';
                            $money = $_POST['money'];
                            if (!isset($money))
                                $money = 2000000;
                            $day = $_POST['day'];
                            if ($day)
                                $sql = "SELECT u.username, u.mobile, os_type, client_version, date_created, last_login, koin, koin_vip, money, u.cp, DATEDIFF(CURDATE(), last_login) AS loginDate FROM user u JOIN auth_user au ON u.username = au.username LEFT JOIN (SELECT username, sum(money) AS money FROM log_nap_koin GROUP BY username) l ON l.username = u.username WHERE DATEDIFF(CURDATE(), last_login) >= $day AND money > $money ORDER BY money DESC";
                            else
                                $sql = "SELECT u.username, u.mobile, os_type, client_version, date_created, last_login, koin, koin_vip, money, u.cp, DATEDIFF(CURDATE(), last_login) AS loginDate FROM user u JOIN auth_user au ON u.username = au.username LEFT JOIN (SELECT username, sum(money) AS money FROM log_nap_koin GROUP BY username) l ON l.username = u.username WHERE money > $money ORDER BY money DESC";


//	echo $sql;
                            ?>
                            <form method="post" action="">	               
                                Số tiền nạp ít nhất: <input value="<?php echo $money; ?>" name="money" id="money"><br />
                                Số ngày chưa login: <input value="<?php echo $day; ?>" name="day" id="day"><br />
                                <input type="submit" value="Xác nhận">
                            </form>
                            <table width="100%" cellspacing="1" style="font-size:13px;">
                                <thead>
                                    <tr style="background-color: rgb(204, 204, 204);">
                                        <th align="center" style="width: 20px;">STT</th>
                                        <th>Username</th>
                                        <th align="center" style="width: 100px;">Phiên bản</th>
                                        <th align="center" style="width: 150px;">Số điện thoại</th>
                                        <th align="center" style="width: 150px;">Xu</th>
                                        <th align="center" style="width: 150px;">Chip</th>
                                        <th style="width:150px">Số tiền nạp</th>
                                        <th align="center" style="width: 150px;">CP</th>
                                        <th align="center" style="width: 150px;">Số ngày chưa login</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $q = mysql_query($sql);
                                    $rec_count = mysql_num_rows($q);
                                    $rec_limit = 30;
                                    if (isset($_GET{'page'})) {
                                        $page = $_GET{'page'} + 1;
                                        $offset = $rec_limit * $page;
                                    } else {
                                        $page = 0;
                                        $offset = 0;
                                    }
                                    $left_rec = $rec_count - ($page * $rec_limit);
                                    $sql .= " LIMIT $offset, $rec_limit";
                                    $q = mysql_query($sql);
                                    $i = 1 * $offset + 1;
                                    while ($r = mysql_fetch_assoc($q)) {
                                        ?>
                                        <tr>
                                            <td align="center" style="width: 20px;"><?php echo $i;
                                    $i++ ?></td>
                                            <td><?php echo $r['username'] ?></td>
                                            <td align="center" style="width: 100px;"><?php echo $r['os_type'] . ' | ' . $r['client_version'] ?></td>
                                            <td align="center" style="width: 150px;"><?php echo $r['mobile'] ?></td>
                                            <td align="center" style="width: 150px;"><?php echo number_format($r['koin']) ?></td>
                                            <td align="center" style="width: 150px;"><?php echo number_format($r['koin_vip']) ?></td>
                                            <td align="center"><?php echo number_format($r['money']) . ' vnđ' ?></td>
                                            <td align="center" style="width: 150px;"><?php echo $r['cp'] ?></td>
                                            <td align="center" style="width: 150px;"><?php echo $r['loginDate'] ?></td>
                                        </tr>
    <?php
}
?>
                                    <tr>
                                        <td colspan="8">
                                    <?php
                                    if ($page > 0) {
                                        $last = $page - 2;
                                        echo "<a href=\"$_PHP_SELF?page=$last\">Last $rec_limit VIPs</a> | ";
                                        echo "<a href=\"$_PHP_SELF?page=$page\">Next $rec_limit VIPs</a>";
                                    } else if ($page == 0) {
                                        echo "<a href=\"$_PHP_SELF?page=$page\">Next $rec_limit VIPs</a>";
                                    } else if ($left_rec < $rec_limit) {
                                        $last = $page - 2;
                                        echo "<a href=\"$_PHP_SELF?page=$last\">Last $rec_limit VIPs</a>";
                                    }
                                    ?>

                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </table>
                </div>
            </div>
        </div>
    </body>
</html>
<?php
mysql_select_db("logsms");
?>