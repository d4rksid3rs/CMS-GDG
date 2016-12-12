<?php
$date = $_POST['date'];
if (!isset($date)) {
    $date = date('Y-m-d', strtotime('last week'));
}
$date2 = $_POST['date2'];
if (!isset($date2)) {
    $date2 = date('Y-m-d', time());
}
require('API/db.class.php');

function findMobileByUsername($u) {
    global $db;
    $sql = "SELECT mobile FROM auth_user WHERE username = '$u' LIMIT 1";
    foreach ($db->query($sql) as $row) {
        $m = $row['mobile'];
    }
    return $m;
}

function checkCard($cardcode) {
    global $db2;
    $sql = "SELECT * FROM paydirect_card.request WHERE cardcode = '$cardcode' AND success = 1 ";
    $ok = 0;
    foreach ($db2->query($sql) as $row) {
        $ok = 1;
    }
    return $ok;
}

//inecho $u;
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Lỗi nạp thẻ</title>
<?php require('header.php'); ?>
        <script type="text/javascript" >
            $(document).ready(function () {
                $("#datepicker1").datepicker();
            });
        </script>
    </head>
    <body>

        <div class="pagewrap">
<?php require('topMenu.php'); ?>

            <div class="box grid">
<?php require('topMenu.trans.php'); ?>
                <div class="box_header"><a href="javascript:void(0);">Lỗi thẻ cào</a></div>
                <div class="box_body">

                    <table width="100%">
                        <td>
                            <form method="post" action="">	  
                                Từ ngày
                                <input type="text" id="datepicker1" name="date" style="text-align: center; width: 100px;" value="<?php echo $date; ?>"/> 
                                đến ngày <input type="text" id="datepicker2" name="date2" style="text-align: center; width: 100px;" value="<?php echo $date2; ?>"/> 
                                <input type="submit" value="Xác nhận">
                            </form>
                        </td>
                        <div style="padding-left:10px;">
                            <?php
                            require_once ('API/db2.class.php');
                            $result = "SELECT *, created_on AS created_on2 FROM paydirect_card.request WHERE (response_raw LIKE '40|%' OR response_raw LIKE '13|%' ) AND date(created_on) BETWEEN '$date' AND '$date2' group by cardcode ORDER BY created_on DESC";
//echo $result;
//	echo $sql;
                            ?>
                            <table width="100%" cellspacing="1" style="font-size:13px;">
                                <thead>
                                    <tr style="background-color: rgb(204, 204, 204);">
                                        <th align="center" style="width: 20px;">STT</th>
                                        <th>Username</th>
                                        <th style="width: 150px;">Số điện thoại</th>
                                        <th align="center" style="width: 100px;">Nhà mạng</th>
                                        <th align="center" style="width: 100px;">Card code</th>
                                        <th align="center" style="width: 150px;">Serial</th>
                                        <th align="center" style="width: 200px;">Ngày</th>
                                        <th align="center" style="width: 200px;">Lỗi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $q = mysql_query($sql);
                                    $i = 1;
                                    foreach ($db2->query($result) as $row) {

                                        //echo "<br /><b>".$row['username'] ."</b> :  " . number_format(floor($row['money']))." vnđ";
                                        if (checkCard($row['cardcode']) == 1)
                                            continue;
                                        ?>
                                        <tr>
                                            <td align="center" style="width: 20px;"><?php echo $i;
                                    $i++ ?></td>
                                            <td><?php echo $row['username'] ?></td>
                                            <td><?php echo findMobileByUsername($row['username']); ?></td>
                                            <td align="center" style="width: 100px;"><?php echo $row['issuer'] ?></td>
                                            <td align="center" style="width: 100px;"><?php echo $row['cardcode'] ?></td>
                                            <td align="center" style="width: 150px;"><?php echo $row['serial'] ?></td>
                                            <td align="center" style="width: 150px;"><?php echo $row['created_on2'] ?></td>
                                            <td align="center" style="width: 150px;"><?php echo $row['response_raw'] ?></td>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </table>
                </div>
            </div>
        </div>
    </body>
</html>