<?php
session_start();

$fromDate = isset($_REQUEST['fromDate']) ? trim($_REQUEST['fromDate']) : date('Y-m-d');
$toDate = isset($_REQUEST['toDate']) ? trim($_REQUEST['toDate']) : date('Y-m-d');
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Thống kê tin nhắn</title>
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
                <div class="box_header"><a href="javascript:void(0);">Thống kê tin nhắn</a></div>
                <div class="box_body">
                    <table width="100%">
                        <div style="padding-left:10px;">
                            <form action="" method="post">
                                Từ ngày:
                                <input type="text" id="datepicker1" name="fromDate" style="text-align: center; width: 100px;" value="<?php echo $fromDate; ?>" readonly="true"/> 
                                (00:00:00)
                                Tới ngày:
                                <input type="text" id="datepicker2" name="toDate" style="text-align: center; width: 100px;" value="<?php echo $toDate; ?>" readonly="true"/> 
                                (23:59:59)
                                <!--                            Mã đối tác:-->
<?php
//                            require('connectdb_bemecp.php');
//                                /*
//$host="127.0.0.1";
//                                $user="dong";
//                                $password="dong!@#654";
//                                mysql_connect($host,$user,$password);
//                                                                                            
//                                mysql_select_db("beme_cp") or die("Ko ket noi duoc toi CSDL");
//*/
//                                $sql9 = "SELECT username,code FROM bm_partner WHERE status=1";
//                                $rs9 = mysql_query($sql9);
?>
                                <!--                            <select name="macp">
                                <?php
                                while ($row9 = mysql_fetch_array($rs9)) {
                                    if ($row9["code"] == $_POST["macp"]) {
                                        echo "<option  selected='true' value=" . $row9["code"] . ">" . $row9["username"] . "</option>";
                                    } else {
                                        echo "<option value=" . $row9["code"] . ">" . $row9["username"] . "</option>";
                                    }
                                }
                                ?>
                                                                                        </select>-->
                                <input type="submit" value="Submit" name="cmd" class="input_button"/>
                            </form>
                            <div style="height: 10px;"></div>

                            <?php
                            //require("connectdb_logsms.php");
                            require("connectdb_gimwap.php");
                            $cmd = isset($_REQUEST["cmd"]) ? trim($_REQUEST["cmd"]) : NULL;
                            if ($cmd != NULL && $cmd == "Submit") {
                                $a = isset($_REQUEST["fromDate"]) ? trim($_REQUEST["fromDate"]) : NULL;
                                $b = isset($_REQUEST["toDate"]) ? trim($_REQUEST["toDate"]) : NULL;
                                $code = isset($_REQUEST["macp"]) ? trim($_REQUEST["macp"]) : NULL;

//                                    if($code==NULL){
//                                        echo "<center><b><font style='color: black;'>Chưa điền mã đối tác</font></b></center>";
//                                        break;
//                                    }

                                $fDate = $a . " 00:00:00";
                                $tDate = $b . " 23:59:59";
//                                    $sql5 = "SELECT sum(count) as count FROM (SELECT count(cardvalue) as count FROM request WHERE success = 1 AND cp = '{$code}' AND created_on BETWEEN '{$fDate}' AND '{$tDate}' GROUP BY issuer,cardvalue,cp) AS S1";
                                $sql5 = "SELECT sum(count) as count FROM (SELECT count(cardvalue) as count FROM request WHERE success = 1 AND created_on BETWEEN '{$fDate}' AND '{$tDate}' GROUP BY issuer,cardvalue,cp) AS S1";

                                $rs5 = mysql_query($sql5) or die("Không thống kế đc");
                                $row5 = mysql_fetch_array($rs5);
                                $sms = $row5["count"];
                                ?>
                                <div style="height: 20px; text-align: right; padding-right: 9px;"><b><font color="#FFFFFF"> Tổng: <?php echo $sms . " Giao dịch"; ?> </font></b></div>
                                <div id="chart_div" style="width: 900px; ">
    <?php
//                                $sql = "SELECT created_on, issuer, cardvalue, cp, success, count(cardvalue) as count FROM request WHERE success = 1 AND cp = '{$code}' AND created_on BETWEEN '{$fDate}' AND '{$tDate}' GROUP BY issuer,cardvalue,cp ORDER BY issuer,created_on DESC";
    $sql = "SELECT created_on, issuer, cardvalue, cp, success, count(cardvalue) as count FROM request WHERE success = 1 AND created_on BETWEEN '{$fDate}' AND '{$tDate}' GROUP BY issuer,cardvalue,cp ORDER BY issuer,created_on DESC";

    //echo $sql;
    $rs = mysql_query($sql) or die("Không thống kê được");
    if (mysql_num_rows($rs) <= 0)
        echo "";
    else {
        $s0 = 0;
        $s1 = 0;
        $s2 = 0;
        $s3 = 0;
        $s4 = 0;
        $s5 = 0;
        $s6 = 0;
        $s7 = 0;
        echo "<table width='100%' border='1' align='center' cellpadding='0' cellspacing='0'>" .
        "<tr>" .
        "<th>Loại</th>" .
        "<th>Card/IAP</th>" .
        "<th>Tổng số thẻ</th>" .
        "</tr>";
        while ($row = mysql_fetch_array($rs)) {
            echo "<tr>" .
            "<td align='center'>";
            if ($row["issuer"] == "VINA") {
                echo "VINAPHONE";
            } else if ($row["issuer"] == "MOBI") {
                echo "MOBIFONE";
            } else if ($row["issuer"] == "VTT") {
                echo "VIETTEL";
            } else {
                echo "BEELINE";
            }
            echo "</td>" .
            "<td align='center'>" . $row["cardvalue"] . "</td>" .
            "<td align='center'>" . $row["count"] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
        //$tongbem = $cnt;
        //echo "<h3 style='color:#FFF; text-align: right;'>Tổng: ".number_format(floor($tongbem))." VNĐ</h3>";
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
