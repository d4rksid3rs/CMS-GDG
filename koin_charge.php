<?php
session_start();

$fromDate = isset($_REQUEST['fromDate']) ? trim($_REQUEST['fromDate']) : date('Y-m-d');
$toDate = isset($_REQUEST['toDate']) ? trim($_REQUEST['toDate']) : date('Y-m-d');
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Thống kê Charging</title>
        <?php require('header.php'); ?>
        <script>
            $(document).ready(function () {
                $("#datepicker1").datepicker();
                $("#datepicker2").datepicker();
            });
        </script>

    </head>
    <body>
        <div class="pagewrap">
            <?php require_once('topMenu.php'); ?>                
            <div class="box grid">
                <?php require_once('topMenu.sub2.php'); ?>
                <div class="box_header"><a href="javascript:void(0);">Thống kê Charge</a></div>
                <div class="box_body">
                    <table width="100%">
                        <div style="padding-left:10px;">
                            <form action="" method="post">
                                UserName:
                                <input type="text" name="username" style="width: 100px;" />
                                Từ ngày:
                                <input type="text" id="datepicker1" name="fromDate" style="text-align: center; width: 100px;" value="<?php echo $fromDate; ?>" readonly="true"/> 
                                (00:00:00)
                                Tới ngày:
                                <input type="text" id="datepicker2" name="toDate" style="text-align: center; width: 100px;" value="<?php echo $toDate; ?>" readonly="true"/> 
                                (23:59:59)
                                <input type="submit" value="Submit" name="cmd" class="input_button"/>
                            </form>
                            <div style="height: 10px;"></div>

                            <?php
                            require("connectdb_gimwap.php");
                            $cmd = isset($_REQUEST["cmd"]) ? trim($_REQUEST["cmd"]) : NULL;
                            if ($cmd != NULL && $cmd == "Submit") {
                                $a = isset($_REQUEST["fromDate"]) ? trim($_REQUEST["fromDate"]) : NULL;
                                $b = isset($_REQUEST["toDate"]) ? trim($_REQUEST["toDate"]) : NULL;
                                $usern = isset($_REQUEST["username"]) ? trim($_REQUEST["username"]) : NULL;

                                $fDate = $a . " 00:00:00";
                                $tDate = $b . " 23:59:59";

//                                $sql5 = "SELECT count(*) AS count FROM koin_charge WHERE username like '%{$usern}%' AND(created_on BETWEEN '{$fDate}' AND '{$tDate}')";
//
//                                $rs5 = mysql_query($sql5) or die("Không thống kế đc");
//                                $row5 = mysql_fetch_array($rs5);
//                                $sms = $row5["count"];
                                $sql = "SELECT l.*, u.screen_name, u.vip, u.mobile FROM log_nap_koin l "
                                        . "LEFT JOIN user u ON l.username = u.username "
                                        . "WHERE l.username like '%{$usern}%' AND(created_on BETWEEN '{$fDate}' AND '{$tDate}')";
                                $rs = mysql_query($sql) or die("Không thống kê được");
                                $sms = mysql_num_rows($rs);
                                $sql_total_chip = "SELECT SUM(CASE WHEN flag1 = 1 THEN koin_added ELSE 0 END) AS total_chip FROM log_nap_koin "
                                        . "WHERE username like '%{$usern}%' AND(created_on BETWEEN '{$fDate}' AND '{$tDate}')";
//                                        echo $sql_total_chip;die;
                                $sql_total_xu = "SELECT SUM(CASE WHEN flag1 = 0 THEN koin_added ELSE 0 END) AS total_xu FROM log_nap_koin "
                                        . "WHERE username like '%{$usern}%' AND(created_on BETWEEN '{$fDate}' AND '{$tDate}')";
                                $sql_total_money = "SELECT SUM(money) AS total_money FROM log_nap_koin "
                                        . "WHERE username like '%{$usern}%' AND(created_on BETWEEN '{$fDate}' AND '{$tDate}')";
                                $sql_total_sms = "SELECT SUM(money) AS total_money FROM log_nap_koin "
                                        . "WHERE username like '%{$usern}%' AND type = 1 AND(created_on BETWEEN '{$fDate}' AND '{$tDate}')";
                                $sql_total_card = "SELECT SUM(money) AS total_money FROM log_nap_koin "
                                        . "WHERE username like '%{$usern}%' AND type = 2 AND(created_on BETWEEN '{$fDate}' AND '{$tDate}')";
                                $sql_total_iap = "SELECT SUM(money) AS total_money FROM log_nap_koin "
                                        . "WHERE username like '%{$usern}%' AND type = 4 AND(created_on BETWEEN '{$fDate}' AND '{$tDate}')";
                                        
                                $sql_card_koin = "SELECT SUM(money) AS total_money FROM log_nap_koin "
                                        . "WHERE username like '%{$usern}%' AND type = 2 AND flag1 = 0 AND(created_on BETWEEN '{$fDate}' AND '{$tDate}')";
                                $sql_sms_koin = "SELECT SUM(money) AS total_money FROM log_nap_koin "
                                        . "WHERE username like '%{$usern}%' AND type = 1 AND flag1 = 0 AND(created_on BETWEEN '{$fDate}' AND '{$tDate}')";
                                $sql_card_koin_vip = "SELECT SUM(money) AS total_money FROM log_nap_koin "
                                        . "WHERE username like '%{$usern}%' AND type = 2 AND flag1 = 1 AND(created_on BETWEEN '{$fDate}' AND '{$tDate}')";
                                $sql_sms_koin_vip = "SELECT SUM(money) AS total_money FROM log_nap_koin "
                                        . "WHERE username like '%{$usern}%' AND type = 1 AND flag1 = 1 AND(created_on BETWEEN '{$fDate}' AND '{$tDate}')";
                                        
                                $rs_tt_chip = mysql_query($sql_total_chip) or die("Không thống kế đc");
                                $rs_tt_xu = mysql_query($sql_total_xu) or die("Không thống kế đc");
                                $rs_tt_money = mysql_query($sql_total_money) or die("Không thống kế đc");
                                $rs_tt_sms = mysql_query($sql_total_sms) or die("Không thống kế đc");
                                $rs_tt_card = mysql_query($sql_total_card) or die("Không thống kế đc");
                                $rs_tt_iap = mysql_query($sql_total_iap) or die("Không thống kế đc");
                                
                                $rs_card_koin = mysql_query($sql_card_koin) or die("Không thống kế đc");
                                $rs_sms_koin = mysql_query($sql_sms_koin) or die("Không thống kế đc");
                                $rs_card_koinvip = mysql_query($sql_card_koin_vip) or die("Không thống kế đc");
                                $rs_sms_koinvip = mysql_query($sql_sms_koin_vip) or die("Không thống kế đc");

                                $row_chip = mysql_fetch_array($rs_tt_chip);
                                $row_xu = mysql_fetch_array($rs_tt_xu);
                                $row_money = mysql_fetch_array($rs_tt_money);
                                $row_sms = mysql_fetch_array($rs_tt_sms);
                                $row_card = mysql_fetch_array($rs_tt_card);
                                $row_iap = mysql_fetch_array($rs_tt_iap);
                                
                                $row_card_koin = mysql_fetch_array($rs_card_koin);
                                $row_sms_koin = mysql_fetch_array($rs_sms_koin);
                                $row_card_koinvip = mysql_fetch_array($rs_card_koinvip);
                                $row_sms_koinvip = mysql_fetch_array($rs_sms_koinvip);
                                ?>
                                <div style="height: 20px; text-align: right; padding-right: 9px;"><b><font color="#FFFFFF"> Tổng: <?php echo $sms . " user"; ?> </font></b></div>
                                <div id="chart_div" style="width: auto; ">
                                    <span style="font-weight: bold; color: #fff;">Tổng Xu: <?php echo number_format($row_xu['total_xu']); ?> Xu |</span>
                                    <span style="font-weight: bold; color: #fff;">Tổng Vàng: <?php echo number_format($row_chip['total_chip']); ?> Vàng |</span>
                                    <span style="font-weight: bold; color: #fff;">Tổng Tiền: <?php echo number_format($row_money['total_money']); ?> VNĐ |</span>
                                    <span style="font-weight: bold; color: #fff;">Tổng SMS: <?php echo number_format($row_sms['total_money']); ?> VNĐ |</span>
                                    <span style="font-weight: bold; color: #fff;">Tổng Card: <?php echo number_format($row_card['total_money']); ?> VNĐ |</span>
                                    <span style="font-weight: bold; color: #fff;">Tổng IAP: <?php echo number_format($row_iap['total_money']); ?> VNĐ</span>
                                    <br />
                                    <span style="font-weight: bold; color: #fff;">Tổng Card nạp vào Xu: <?php echo number_format($row_card_koin['total_money']); ?> VNĐ |</span>
                                    <span style="font-weight: bold; color: #fff;">Tổng SMS nạp vào Xu: <?php echo number_format($row_sms_koin['total_money']); ?> VNĐ |</span>
                                    <span style="font-weight: bold; color: #fff;">Tổng Card nạp vào Vàng: <?php echo number_format($row_card_koinvip['total_money']); ?> VNĐ |</span>
                                    <span style="font-weight: bold; color: #fff;">Tổng SMS nạp vào Vàng: <?php echo number_format($row_sms_koinvip['total_money']); ?> VNĐ</span>
                                    <?php
                                    if (mysql_num_rows($rs) <= 0)
                                        echo "";
                                    else {
                                        echo "<table width='100%' border='1' align='center' cellpadding='0' cellspacing='0'>" .
                                        "<tr>" .
                                        "<th>UserName</th>" .
                                        "<th>Screen Name</th>" .
                                        "<th>Điện thoại</th>" .
                                        "<th>Vip</th>" .
                                        "<th>Xu</th>" .
                                        "<th>Vàng</th>" .
                                        "<th>Money</th>" .
                                        "<th>Ngày Charge</th>" .
                                        "</tr>";

                                        $sobanghitrentrang = 30;
                                        $soluongtrang = ceil(mysql_num_rows($rs) / $sobanghitrentrang);
                                        $sotrang = isset($_REQUEST["p"]) ? trim($_REQUEST["p"]) : 0;
                                        if ($sotrang <= 0)
                                            $sotrang = 1;
                                        if ($sotrang > $soluongtrang)
                                            $sotrang = $soluongtrang;
                                        $sql1 = $sql . " limit " . ($sotrang - 1) * $sobanghitrentrang . "," . $sobanghitrentrang;
                                        $rs2 = mysql_query($sql1) or die("Không có người dùng nào thỏa mãn điều kiện!");
                                        while ($row = mysql_fetch_array($rs2)) {
                                            $mobile = ($row['mobile'] == '123456788') ? '' : $row['mobile'];
                                            $koin = ($row['flag1'] == 0) ? $row['koin_added'] : '';
                                            $koin_vip = ($row['flag1'] == 1) ? $row['koin_added'] : '';
                                            echo "<tr>" .
                                            "<td align='center'>" . $row["username"] . "</td>" .
                                            "<td align='center'>" . $row["screen_name"] . "</td>" .
                                            "<td align='center'>" . $mobile . "</td>" .
                                            "<td align='center'>" . $row['vip'] . "</td>" .
                                            "<td align='center'>" . number_format($koin) . "</td>" .
                                            "<td align='center'>" . number_format($koin_vip) . "</td>" .
                                            "<td align='center'>" . number_format($row["money"]) . "</td>" .
                                            "<td align='center'>" . $row["created_on"] . "</td>";
                                            echo "</tr>";
                                        }
                                        echo "</table>";
                                    }
                                    echo "<br/>Trang: ";
                                    for ($i = 1; $i <= $soluongtrang; $i++) {
                                        if ($i == $sotrang)
                                            echo "&nbsp;<font color='red'><b>{$i}</b></font>&nbsp;";
                                        else {
                                            echo "&nbsp;<a href='koin_charge.php?p={$i}&cmd={$cmd}&username={$usern}&fromDate={$a}&toDate={$b}'>$i</a>&nbsp;";
                                        }if ($i % 30 == 0) {
                                            echo "<br/>";
                                        }
                                    }
                                }
                                ?>
                                <div style="height: 20px;"></div>
                            </div>

                        </div>
                    </table>
                </div>
            </div>

        </div>
    </body>
</html>