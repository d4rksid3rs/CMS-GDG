<?php
/* session_start();
  $u = isset($_SESSION['username']) ? $_SESSION['username'] : 'foobar';
  if($u == 'nguyet')
  header("Location: http://beme.net.vn/bi1/comment.php");
 */


/*
  if (!isset($_SERVER['PHP_AUTH_USER'])) {
  header('WWW-Authenticate: Basic realm="My Realm"');
  header('HTTP/1.0 401 Unauthorized');
  die('---^_^!');
  } else {
  if(	($_SERVER['PHP_AUTH_USER']=='bemon' && $_SERVER['PHP_AUTH_PW']=='hoilamgi') ||
  ($_SERVER['PHP_AUTH_USER']=='huong' && $_SERVER['PHP_AUTH_PW']=='chiuchiu2023')
  ){
  $_SESSION['username'] = $_SERVER['PHP_AUTH_USER'];
  } else {
  die('tắt trình duyệt đi và bật lại nhé ^_^!');
  }

  }
 */
/*
  require('API/socket.php');
  $service = 0xF900;
  $input = "{}";
  $jsonData = json_decode(sendMessage($service, $input));
 */
//readfile("./sdata");

/* * ********************************************* */
/* * **********Server 1*************************** */
/* * ********************************************* */
//$my_file = file_get_contents("./sdata");
//$jsonData = json_decode($my_file);

$my_file = file_get_contents("./sdata");
//echo $my_file;
$jsonData = json_decode($my_file);
$total = 0;
//$key = array("phom", "bacay", "bacaynew", "bacaychuong", "poker", "tienlenmb", "tienlenmn", "tienlenmndc", "caro", "bing", "lieng", "sam");
//$name = array("Phỏm", "Ba cây", "Ba cây mới", "Ba cây chương", "Poker", "Tiến lên MB", "Tiến lên MN", "Tiến lên MNDC", "Caro", "Binh", "Liêng", "Sâm");
$key = array("phom", "bacay", "bacaychuong", "tienlenmn", "tienlenmndc", "bing", "lieng", "sam", "baucua", 'xito', 'xocdia',
    "vipphom", "vipbacay", "vipbacaychuong", "viptienlenmn", "viptienlenmndc", "vipbing", "viplieng", "vipsam", "vipbaucua", 'vipxito', 'vipxocdia');
$name = array("Phỏm", "Ba cây", "Ba cây chương", "Tiến lên MN", "Tiến lên MNDC", "Binh", "Liêng", "Sâm", "Bầu cua", "Xì tố", "Xóc đĩa",
    "Phỏm VIP", "Ba cây VIP", "Ba cây chương VIP", "Tiến lên MN VIP", "Tiến lên MNDC VIP", "Binh VIP", "Liêng VIP", "Sâm VIP", "Bầu cua VIP", "Xì tố VIP", "Xóc đĩa VIP");
$value1 = array();
$value1["online"] = $jsonData->{"online"};
$value1["total"] = 0;
$value1["bot"] = $jsonData->{"bot"};
foreach ($key as $k) {
    $value1[$k]["online"] = 0;
    foreach ($jsonData->{$k}->{"room"} as $row) {
        $value1[$k]["online"] += $row->{"online"};
        $value1[$k]["room"] = array("id" => $row->{"id"},
            "name" => $row->{"name"},
            "online" => $row->{"online"},
            "maxBlind" => $row->{"maxBlind"},
            "minBlind" => $row->{"minBlind"},
            "limit" => $row->{"limit"});
    }
    $value1[$k]["playingTable"] = $jsonData->{$k}->{"playingTable"};
    $value1["total"] += $value1[$k]["online"];
}
$fromDate = $_GET['fromDate'];
$toDate = $_GET['toDate'];
if (!isset($fromDate)) {
    $fromDate = date('Y-m-d', time());
}
if (!isset($toDate)) {
    $toDate = date('Y-m-d', time());
}
require 'API/db.class.php';
$today = date('Y-m-d');
$sql_reg_today = "select count(*) as total from user where date(date_created) = '{$today}'";
$sql_login_today = "select count(*) as total from user where date(last_login) = '{$today}'";

$rs1 = $db->prepare($sql_reg_today);
$rs1->execute();
$total_reg = $rs1->fetch();

$rs2 = $db->prepare($sql_login_today);
$rs2->execute();
$total_login = $rs2->fetch();

?>
<!DOCTYPE html>
<html>
    <head>
        <title>Game Dân gian</title>
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
            <?php require('topMenu.php'); ?>
            <div class="box grid">
                <div class="box_header">
                    <a href="javascript:void(0);" >Đăng ký / Login: <?php echo $total_reg['total'] ."/".$total_login['total']. " Người chơi"; ?>
                    </a>
                </div>
                <div class="box_body">
                    <table width="100%">
                        <tr>
                            <td width="50%">
                                <table width=100%>
                                    <tr><td colspan="2" align="center"><b>Game Dân gian</b></td></tr>
                                    <tr><td width="40%">Tổng số người online </td><td align="center"><?php echo $value1["total"] . " / " . $value1["online"]; ?></td></tr>
                                    <?php
                                    for ($i = 0; $i < sizeof($key); $i++) {
                                        echo "<tr><td>" . $name[$i] . " </td><td align=\"center\">" . $value1[$key[$i]]["online"] . "</td></tr>";
                                    }
                                    ?>    
                                    <tr><td width="40%">Bot </td><td align="center"><?php echo $value1["bot"]; ?></td></tr>
                                </table>
                            </td>
<!--                            <td width="50%">
                                <table width=100%>
                                    <tr><td colspan="2" align="center"><b>Beme 2 - 115.84.178.4:6969</b></td></tr>
                                    <tr><td width="40%">Tổng số người online </td><td align="center"><?php echo $value2["total"] . " / " . $value2["online"]; ?></td></tr>
                            <?php
                            for ($i = 0; $i < sizeof($key); $i++) {
                                echo "<tr><td>" . $name[$i] . " </td><td align=\"center\">" . $value2[$key[$i]]["online"] . "</td></tr>";
                            }
                            ?>
                                </table>
                            </td>-->
                        </tr>
                        <!--
                        <tr><td>Chơi nhảy cột </td><td align="center"><?php echo $nhaycot["online"]; ?></td></tr>
                        <tr><td>Chơi lướt ván </td><td align="center"><?php echo $luotvan["online"]; ?></td></tr>
                        <tr><td>Sàn nhạc </td><td align="center"><?php echo $bar0["online"]; ?></td></tr>
                        <tr><td>Công viên 1</td><td align="center"><?php echo $park0["online"]; ?></td></tr>
                        <tr><td>Công viên 2</td><td align="center"><?php echo $park1["online"]; ?></td></tr>
                        <tr><td>Công viên 3</td><td align="center"><?php echo $park2["online"]; ?></td></tr>
                        <tr><td>Bãi biển 1</td><td align="center"><?php echo $beach0["online"]; ?></td></tr>
                        <tr><td>Bãi biển 2</td><td align="center"><?php echo $beach1["online"]; ?></td></tr>
                        <tr><td>Bãi biển 3</td><td align="center"><?php echo $beach2["online"]; ?></td></tr>
                        -->
                    </table>
                </div>
            </div>
            <div class="box grid">
                <div class="box_header">
                    <a href="javascript:void(0);">Biểu đồ lịch sử</a>
                </div>
                <div class="box_body">
                    <table width=100%>
                        <tr>
                            <td width="100%"> 
                                <iframe height="450" width="100%" frameBorder="0" src="nchart.php?fromDate=<?php echo $fromDate; ?>&toDate=<?php echo $toDate; ?>">your browser does not support IFRAMEs</iframe></td>
                            <!--
                                    <td width="50%"> <iframe height="370" width="100%" frameBorder="0" src="chart.php?fromDate=<?php echo $fromDate; ?>&toDate=<?php echo $toDate; ?>">your browser does not support IFRAMEs</iframe></td>
                                    <td width="50%"> <iframe height="370" width="100%" frameBorder="0" src="chart2.php?fromDate=<?php echo $fromDate; ?>&toDate=<?php echo $toDate; ?>">your browser does not support IFRAMEs</iframe></td>
                            -->
                        </tr>
                    </table>
                    <div style="padding-left:10px; text-align:center;">
                        <form method="index.php" method="GET">
                            Từ ngày 
                            <input type="text" id="datepicker1" name="fromDate" style="text-align: center; width: 100px;" value="<?php echo $fromDate; ?>"/> 
                            Tới ngày 
                            <input type="text" id="datepicker2" name="toDate" style="text-align: center; width: 100px;" value="<?php echo $toDate; ?>"/> 
                            <input type="submit" value="Cập nhật" class="input_button"/>
                        </form>
                    </div>
                </div>
            </div>
            <!--            <div class="box grid">
                            <div class="box_header">
                                <a href="javascript:void(0);">Monaco</a>
                            </div>
                            <div class="box_body" style="display:none;">
                                <table>
                                    <tr>
            <?php
            for ($i = 0; $i < sizeof($key); $i++) {
                $room = $value1[$key[$i]]["room"];
                echo "<td><div class=\"room_title\" style='height:35px;'>" . $name[$i] . " " . $value1[$key[$i]]["playingTable"] . "</div>";
                echo "<div class=\"room_box\">";
                echo "<div class=\"room_box_title room_dark\"><a href=\"room.php?name=" . $name[$i] . " - " . $key[$i] . " - " . $key[$i] . "&id=" . $room["id"] . "\">" . $room["name"] . "</a></div>";
                if ($room["online"] <= $room["limit"] / 2) {
                    echo "<div class=\"room_box_body room_green\"><a href=\"room.php?name=" . $name[$i] . " - " . $key[$i] . " - " . $key[$i] . "&id=" . $room["id"] . "\">" . $room["online"] . "/" . $room["limit"] . "</a></div>";
                } else if ($room["online"] <= $room["limit"] / 4 * 3) {
                    echo "<div class=\"room_box_body room_yellow\"><a href=\"room.php?name=" . $name[$i] . " - " . $key[$i] . " - " . $key[$i] . "&id=" . $room["id"] . "\">" . $room["online"] . "/" . $room["limit"] . "</a></div>";
                } else {
                    echo "<div class=\"room_box_body room_red\"><a href=\"room.php?name=" . $name[$i] . " - " . $key[$i] . " - " . $key[$i] . "&id=" . $room["id"] . "\">" . $room["online"] . "/" . $room["limit"] . "</a></div>";
                }
                echo "</div></td>";
            }
            ?>
                                    </tr>
                                </table>
                                
                            </div>
                        </div>-->

            <!--            <div class="box grid">
                            <div class="box_header">
                                <a href="javascript:void(0);">Beme 2</a>
                            </div>
                            <div class="box_body" style="display:none;">
                                <table>
                                    <tr>
            <?php
            for ($i = 0; $i < sizeof($key); $i++) {
                $room = $value2[$key[$i]]["room"];
                echo "<td><div class=\"room_title\" style='height:35px;'>" . $name[$i] . " " . $value2[$key[$i]]["playingTable"] . "</div>";
                echo "<div class=\"room_box\">";
                echo "<div class=\"room_box_title room_dark\"><a href=\"room.php?name=" . $name[$i] . " - " . $key[$i] . " - " . $key[$i] . "&id=" . $room["id"] . "\">" . $room["name"] . "</a></div>";
                if ($room["online"] <= $room["limit"] / 2) {
                    echo "<div class=\"room_box_body room_green\"><a href=\"room.php?name=" . $name[$i] . " - " . $key[$i] . " - " . $key[$i] . "&id=" . $room["id"] . "\">" . $room["online"] . "/" . $room["limit"] . "</a></div>";
                } else if ($room["online"] <= $room["limit"] / 4 * 3) {
                    echo "<div class=\"room_box_body room_yellow\"><a href=\"room.php?name=" . $name[$i] . " - " . $key[$i] . " - " . $key[$i] . "&id=" . $room["id"] . "\">" . $room["online"] . "/" . $room["limit"] . "</a></div>";
                } else {
                    echo "<div class=\"room_box_body room_red\"><a href=\"room.php?name=" . $name[$i] . " - " . $key[$i] . " - " . $key[$i] . "&id=" . $room["id"] . "\">" . $room["online"] . "/" . $room["limit"] . "</a></div>";
                }
                echo "</div></td>";
            }
            ?>
                                    </tr>
                                </table>
                            </div>
                        </div>-->



        </div>
    </body>
</html>