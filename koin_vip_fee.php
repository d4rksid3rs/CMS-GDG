<?php
//include 'cache_begin.php';
require('API/db.class.php');

if (!isset($_REQUEST['fromDate'])) {
    $fromDate = date('Y-m-d', time());
    $newdate = strtotime('-10 day', strtotime($fromDate));
    $fromDate = date('Y-m-d', $newdate);
} else {
    $fromDate = $_REQUEST['fromDate'];
}
if (!isset($_REQUEST['toDate'])) {
    $toDate = date('Y-m-d', time());
} else {
    $toDate = $_REQUEST['toDate'];
}
$today = date('Y-m-d', time());
try {
    $sql = "select * from server_chip_daily where datecreate >= '" . $fromDate . "' and datecreate <= '" . $toDate . "' order by datecreate";
    $chart_data = array();
    //$sql2 = "SELECT type, sum(koin_added) koin_added, date(created_on) as day FROM log_nap_koin  where created_on >= '".$fromDate."' and created_on <= '".$toDate."' GROUP BY day, type order by created_on";
    $sql3 = "SELECT date(date_created) as day, sum(koin) as koinadmin FROM admin_add_koin WHERE date_created >= '" . $fromDate . "' and date_created <= '" . $toDate . "' GROUP BY day";
    $sql4 = "select date(time_update) as day, fee_vip from fee_taixiu where date(time_update) >= '" . $fromDate . "' and date(time_update) <= '" . $toDate . "' order by time_update";
//    echo $sql3;
    foreach ($db->query($sql) as $row) {
        $obj = json_decode($row['data']);
        $obj->KOINVIPSMS = $row['sms_chip'];
        $obj->KOINVIPCARD = $row['card_chip'];
        $obj->KOINVIPIAP = $row['iap_chip'];
        $obj->XOCDIAVIP = $row['vipxocdia'];
        $obj->BAUCUAVIP = $row['vipbaucua'];
        $obj->CASHOUT = $row['cashout'];
        $obj->ADDKOIN = $row['addkoin'];
        $obj->CHIPVERIFY = $row['chipverify'];
        $obj->KOINADMIN = $row['adminaddchip'];
        /*
          foreach($db->query($sql2) as $row2) {
          if($row['day'] == $row2['day']) {
          if($row2['type'] == 1)
          $obj->KOINSMS = $row2['koin_added'];
          else if($row2['type'] == 2)
          $obj->KOINCARD = $row2['koin_added'];
          }
          }
         */
        /*
          foreach($db->query($sql3) as $row3) {
          if($row['day'] == $row3['day']) {
          $obj->KOINADMIN = $row3['koinadmin'];
          echo $row3['koinadmin'];
          }
          } */
        $taixiu = 0;
        foreach ($db->query($sql4) as $row4) {
            if ($row['datecreate'] == $row4['day']) {
                $taixiu = $row4['fee_vip'] * (-1);
            }
        }
        $chart_data[] = array('day' => $row['datecreate'],
            'data' => json_encode($obj),
            'taixiu' => $taixiu
//            'koin' => $row['diff_server_koin'],
//            'regKoin' => $row['reg_koin'],
//            'iapKoin' => $row['iap_koin']
        );
    }
//   var_dump($obj);die;
//   var_dump($chart_data);die;
} catch (Exception $e) {
    echo "Lỗi kết nối CSDL";
}
$title = "Thống kê tiền fee";
$output = $output2 = "";

foreach ($chart_data as $row) {
    /*
      $obj = json_decode($row['data']);
      $output = $output."{name: '".$row['day']."',";
      $output = $output."data:[";
      $output .= $obj->PHOM . ",";
      $output .= $obj->TLMN . ",";
      $output .= $obj->TLMNDC . ",";
      $output .= $obj->TLMB . ",";
      $output .= $obj->POKER . ",";
      $output .= $obj->BACAYCH . ",";
      $output .= $obj->INVITE . ",";
      $output .= $obj->BACAY . ",";
      $output .= $obj->BACAYNEW . ",";
      $output .= $obj->LIENG . ",";
      $output .= $obj->SAM . ",";
      $output .= $obj->MAUBINH . ",";
      $output .= $obj->BUYITEM;
      $output .= "]}, ";
     */

    //phom
    $output .= "{name: 'Phỏm VIP',";
    $output .= "data:[";
    foreach ($chart_data as $row2) {
        $obj = json_decode($row2['data']);
        $output .= $obj->PHOM . ",";
    }
    $output .= "]}, ";
    //xito
    $output .= "{name: 'Xì Tố VIP',";
    $output .= "data:[";
    foreach ($chart_data as $row2) {
        $obj = json_decode($row2['data']);
        $output .= $obj->XITO . ",";
    }
    $output .= "]}, ";
    //tienlenmiennam
    $output .= "{name: 'TLMN VIP',";
    $output .= "data:[";
    foreach ($chart_data as $row2) {
        $obj = json_decode($row2['data']);
        $output .= $obj->TLMN . ",";
    }
    $output .= "]}, ";
    //tienlenmiennam dem cay
    $output .= "{name: 'TLMNDC VIP',";
    $output .= "data:[";
    foreach ($chart_data as $row2) {
        $obj = json_decode($row2['data']);
        $output .= $obj->TLMNDC . ",";
    }
    $output .= "]}, ";
    //ba cay chuong
    $output .= "{name: 'BACAYCH VIP',";
    $output .= "data:[";
    foreach ($chart_data as $row2) {
        $obj = json_decode($row2['data']);
        $output .= $obj->BACAYCH . ",";
    }
    $output .= "]}, ";
    //invite
    /*
      $output .= "{name: 'INVITE',";
      $output .= "data:[";
      foreach ($chart_data as $row2) {
      $obj = json_decode($row2['data']);
      $output .= $obj->INVITE . ",";
      }
      $output .= "]}, ";
     */
    //bacay
    $output .= "{name: 'BACAY VIP',";
    $output .= "data:[";
    foreach ($chart_data as $row2) {
        $obj = json_decode($row2['data']);
        $output .= $obj->BACAY . ",";
    }
    $output .= "]}, ";
    //Bacay New
    /*
      $output .= "{name: 'BACAYNew',";
      $output .= "data:[";
      foreach ($chart_data as $row2) {
      $obj = json_decode($row2['data']);
      $output .= $obj->BACAYNEW . ",";
      }
      $output .= "]}, ";
     */
    //lieng
    $output .= "{name: 'LIENG VIP',";
    $output .= "data:[";
    foreach ($chart_data as $row2) {
        $obj = json_decode($row2['data']);
        $output .= $obj->LIENG . ",";
    }
    $output .= "]}, ";
    //bing
//    $output .= "{name: 'MAUBINH VIP',";
//    $output .= "data:[";
//    foreach ($chart_data as $row2) {
//        $obj = json_decode($row2['data']);
//        $output .= $obj->MAUBINH . ",";
//    }
//    $output .= "]}, ";
    //Sam
    $output .= "{name: 'SAM VIP',";
    $output .= "data:[";
    foreach ($chart_data as $row2) {
        $obj = json_decode($row2['data']);
        $output .= $obj->SAM . ",";
    }
    $output .= "]}, ";
    //Sam
    $output .= "{name: 'XOCDIA VIP',";
    $output .= "data:[";
    foreach ($chart_data as $row2) {
        $obj = json_decode($row2['data']);
        $output .= $obj->XOCDIA . ",";
    }
    $output .= "]}, ";
    //Sam
    $output .= "{name: 'BAUCUA VIP',";
    $output .= "data:[";
    foreach ($chart_data as $row2) {
        $obj = json_decode($row2['data']);
        $output .= $obj->BAUCUA . ",";
    }
    $output .= "]}, ";
    //buy item
    /*
      $output .= "{name: 'BUY ITEM',";
      $output .= "data:[";
      foreach ($chart_data as $row2) {
      $obj = json_decode($row2['data']);
      $output .= $obj->BUYITEM . ",";
      }
      $output .= "]}, ";
     */

    break;
}
foreach ($chart_data as $row) {
    //register
    $output .= "{name: 'CHIP IAP',";
    $output .= "data:[";
    foreach ($chart_data as $row2) {
        $obj = json_decode($row2['data']);
        $output .= $obj->KOINVIPIAP . ",";
    }
    $output .= "]}, ";
    //koin sms
    $output2 .= "{name: 'VÀNG SMS',";
    $output2 .= "data:[";
    foreach ($chart_data as $row2) {
        $obj = json_decode($row2['data']);
        $output2 .= $obj->KOINVIPSMS . ",";
    }
    $output2 .= "]}, ";
    //koin card
    $output2 .= "{name: 'VÀNG CARD',";
    $output2 .= "data:[";
    foreach ($chart_data as $row2) {
        $obj = json_decode($row2['data']);
        $output2 .= $obj->KOINVIPCARD . ",";
    }
    $output2 .= "]}, ";
    // IAP Koin
    $output2 .= "{name: 'BAU CUA VIP',";
    $output2 .= "data:[";
    foreach ($chart_data as $row2) {
        $obj = json_decode($row2['data']);
        $output2 .= $obj->BAUCUAVIP . ",";
    }
    $output2 .= "]}, ";
    // IAP Koin
    $output2 .= "{name: 'XOC DIA VIP',";
    $output2 .= "data:[";
    foreach ($chart_data as $row2) {
        $obj = json_decode($row2['data']);
        $output2 .= $obj->XOCDIAVIP . ",";
    }
    $output2 .= "]}, ";
    // IAP Koin
    $output2 .= "{name: 'ADMIN ADD VÀNG',";
    $output2 .= "data:[";
    foreach ($chart_data as $row2) {
        $obj = json_decode($row2['data']);
        $output2 .= $obj->KOINADMIN . ",";
    }
    $output2 .= "]}, ";
    // Tai Xiu Chip
    $output .= "{name: 'Tai Xiu',";
    $output .= "data:[";
    foreach ($chart_data as $row2) {
        $obj = json_decode($row2['data']);
        $output .= $row2['taixiu'] . ",";
    }
    $output .= "]}, ";
    break;
}
//echo substr($output, 0, -1);die;
?>
<!DOCTYPE html>
<html>
    <head>
        <title><?php echo $title; ?></title>
<?php require('header.php'); ?>
        <script src="js/highcharts.js" type="text/javascript"></script>
        <script type="text/javascript" src="js/themes/grid.js"></script>
        <script>
            var chart1;
            function chipVerify() {
                var date = $("#logKoin input[name=date]").val();
                $.ajax({
                    type: "GET",
                    url: "API/getChipVerify.php",
                    data: {
                        "date": date
                    },
                    dataType: 'text',
                    success: function (msg) {
                        $("#logKoinResult").html(msg);
                        $("#logKoinResult").show();
                    },
                    failure: function () {
                        $("#exchangeUserList").html("<span>Không truy cập được dữ liệu</span>");
                        $("#btnFindListUser").attr("disabled", false);
                    }
                });
            }
            $(document).ready(function () {
                $("#datepicker1").datepicker();
                $("#datepicker2").datepicker();
                $(".datepicker").datepicker();
                $("a.pagination-link").live("click", function (e) {
                    e.preventDefault();
                    var page = $(this).attr('page');
                    var date = $("#logKoin input[name=date]").val();
                    $("#btnFindMobileDataSMS").attr("disabled", true);
                    $.ajax({
                        type: "GET",
                        url: "API/getChipVerify.php",
                        data: {
                            "page": page,
                            "date": date
                        },
                        dataType: 'text',
                        success: function (msg) {
                            $("#logKoinResult").html(msg);
                            $("#logKoinResult").show();
                        },
                        failure: function () {
                            $("#phoneDataDetail").html("<span>Không truy cập được dữ liệu</span>");
                            $("#btnFindMobileDataSMS").attr("disabled", false);
                        }
                    });
                });
                //chart 1
                chart1 = new Highcharts.Chart({
                    chart: {
                        renderTo: 'chart-container-1',
                        defaultSeriesType: 'spline'
                    },
                    title: {
                        text: 'Vàng SMS, Card'
                    },
                    xAxis: {
                        categories:
                                [
                                    //'Phỏm','TLMN','TLMN DC','TLMB','Poker','BacayCh','INVITE','Bacay','BacayMoi','Lieng','Sam','Binh','BuyItem'
<?php
foreach ($chart_data as $row) {
    echo "'" . $row['day'] . "' , ";
}
?>
                                ]
                    },
                    yAxis: {
                        title: {
                            text: 'Chip'
                        }
                    },
                    series: [
<?php
echo substr($output2, 0, -1);
?>
                    ]
                });
                //chart 2
                chart2 = new Highcharts.Chart({
                    chart: {
                        renderTo: 'chart-container-2',
                        defaultSeriesType: 'spline'
                    },
                    title: {
                        text: 'Vàng Game'
                    },
                    xAxis: {
                        categories:
                                [
                                    //'Daily Bonus','Register'
<?php
foreach ($chart_data as $row) {
    echo "'" . $row['day'] . "' , ";
}
?>
                                ]
                    },
                    yAxis: {
                        title: {
                            text: 'Vàng'
                        }
                    },
                    series: [
<?php
echo substr($output, 0, -1);
?>
                    ]
                });
            });
        </script>       
    </head>
    <body>
        <div class="pagewrap">
<?php require('topMenu.php'); ?> 

            <div class="box grid">
<?php include('topMenu.koin.php'); ?>
                <div class="box_header"><a href="javascript:void(0);">Chip Verify</a></div>
                <div class="box_body" style="display: none">
                    <form id="logKoin">
                        Ngày
                        <input type="text" class="datepicker" name="date" value="<?php echo $today; ?>" style="text-align: center; width: 100px;" />                        
                        <input type="button" name="add" value="Thống kê" onclick="chipVerify();"/>

                    </form>
                </div>
                <div id="logKoinResult" style="display: none;">                    
                </div>
                <br />
                <br />
                <br />
                <div class="box_header"><a href="javascript:void(0);"><?php echo "Thống kê tiền fee"; ?></a></div>
                <div class="box_body">
                    <div style="padding-left:10px;">
                        <form action="" method="post">
                            Từ ngày
                            <input type="text" id="datepicker1" name="fromDate" style="text-align: center; width: 100px;" value="<?php echo $fromDate; ?>"/> 
                            (00:00:00)
                            Tới ngày
                            <input type="text" id="datepicker2" name="toDate" style="text-align: center; width: 100px;" value="<?php echo $toDate; ?>"/> 
                            (23:59:59)
                            <input type="submit" value="Cập nhật" class="input_button"/>
                        </form>
                    </div>
                    <div>
                        <table width="100%">
                            <tr>
                                <td>Ngày</td>
                                <td>Phỏm VIP</td>
                                <td>TLMN VIP</td>
                                <td>TLMN DC VIP</td>
                                <td>POKER VIP</td>
                                <td>BACAYCH VIP</td>
                                <td>Bacay VIP</td>
                                <td>Bacay moi VIP</td>
                                <td>LIENG VIP</td>
                                <td>Sam VIP</td>
                                <td>Xoc Dia VIP</td>
                                <td>Bau Cua VIP</td>
                                <td>Xì tố VIP</td>
                                <td>Vàng sang Xu Put</td>
                                <td>Tài xỉu</td>                                
                                <td align="center" style="background-color:#81A0F3;"><b>Vàng</b></td>

<!--                                <td>Facebook</td>
                                <td>Daily Bonus</td>
                                <td>Exp Event</td>
                                <td>Text Event</td>
                                <td>Koin SMS</td>
                                <td>Koin Card</td>
                                <td align="center" style="background-color:#81A0F3;"><b>Tổng</b></td>-->

                            </tr>
                            <?php
                            foreach ($chart_data as $row) {
                                $obj = json_decode($row['data']);
                                echo "<tr>";
                                echo "<td>{$row['day']}</td>";
                                echo "<td>" . number_format($obj->PHOM) . "</td>";
                                echo "<td>" . number_format($obj->TLMN) . "</td>";
                                echo "<td>" . number_format($obj->TLMNDC) . "</td>";
                                echo "<td>" . number_format($obj->POKER) . " </td>";
                                echo "<td>" . number_format($obj->BACAYCH) . " </td>";
                                echo "<td>" . number_format($obj->BACAY) . "</td>";
                                echo "<td>" . number_format($obj->BACAYNEW) . "</td>";
                                echo "<td>" . number_format($obj->LIENG) . "</td>";
                                echo "<td>" . number_format($obj->SAM) . "</td>";
                                echo "<td>" . number_format($obj->XOCDIA) . "</td>";
                                echo "<td>" . number_format($obj->BAUCUA) . "</td>";
                                echo "<td>" . number_format($obj->XITO) . "</td>";
                                echo "<td>" . number_format($obj->GOLDTOSILVER_PUT) . "</td>";
                                echo "<td>" . number_format($row['taixiu']) . "</td>";
                                $total = $obj->PHOM + $obj->TLMN + $obj->TLMNDC +
                                        $obj->POKER + $obj->BACAYCH + $obj->BACAY + $obj->BACAYNEW + 
                                        $obj->LIENG + $obj->SAM + $obj->BAUCUA + $obj->XOCDIA + $obj->XITO + $obj->GOLDTOSILVER_PUT + $row['taixiu'];
                                echo "<td style='background-color:#FCD5B4;'><b>" . number_format($total) . "</b></td>";

                                /*
                                  echo "<td>".number_format($obj->FACEBOOK)."</td>";
                                  echo "<td>".number_format($obj->DAILY_BONUS)."</td>";
                                  echo "<td>".number_format($obj->EXP_MISSION)."</td>";
                                  echo "<td>".number_format($obj->EVENT)."</td>";
                                  echo "<td>".number_format($obj->KOINSMS)."</td>";
                                  echo "<td>".number_format($obj->KOINCARD)."</td>";

                                  $total2 = $total + $obj->FACEBOOK + $obj->DAILY_BONUS + $obj->EXP_MISSION + $obj->EVENT + $obj->KOINSMS + $obj->KOINCARD;
                                  echo "<td style='background-color:#FCD5B4;'><b>".number_format($total2)."</b></td>";
                                 */

                                echo "</tr>";
                            }
                            ?>
                        </table>
                        <table width="100%" style="padding-top:20px">
                            <tr>
                                <td>Ngày</td>
                                <td align="center" style="background-color:#81A0F3;"><b>Vàng từ Game</b></td>                                
                                <td>Vàng IAP</td>

                                <td>Vàng SMS</td>
                                <td>Vàng Card</td>
                                <td>Bau Cua</td>
                                <td>Xoc Dia</td>
                                <td>Cash Out</td>
                                <td>Add Chip</td>
                                <td>Chip Verify</td>
                                <td>Admin Add</td>
                                <td>Nổ hũ</td>
                                <td align="center" style="background-color:#81A0F3;"><b>Tổng</b></td>
                            </tr>
                            <?php
                            foreach ($chart_data as $row) {
                                $obj = json_decode($row['data']);
                                echo "<tr>";
                                echo "<td>{$row['day']}</td>";
                                $total = $obj->PHOM + $obj->TLMN + $obj->TLMNDC +
                                        $obj->POKER + $obj->BACAYCH + $obj->BACAY + $obj->BACAYNEW + 
                                        $obj->LIENG + $obj->SAM + $obj->BAUCUA + $obj->XOCDIA + $obj->XITO + $obj->GOLDTOSILVER_PUT + $row['taixiu'];
                                echo "<td style='background-color:#FCD5B4;'><b>" . number_format($total) . "</b></td>";

//                                echo "<td>" . number_format($obj->FACEBOOK) . "</td>";
//                                echo "<td>" . number_format($obj->DAILY_BONUS) . "</td>";
                                echo "<td>" . number_format($obj->KOINVIPIAP) . "</td>";
//                                echo "<td>" . number_format($obj->EXP_MISSION) . "</td>";
//                                echo "<td>" . number_format($obj->EVENT) . "</td>";
                                echo "<td>" . number_format($obj->KOINVIPSMS) . "</td>";
                                echo "<td>" . number_format($obj->KOINVIPCARD) . "</td>";
                                echo "<td>" . number_format($obj->BAUCUAVIP) . "</td>";
                                echo "<td>" . number_format($obj->XOCDIAVIP) . "</td>";                                
                                
                                echo "<td>" . number_format($obj->CASHOUT) . "</td>";
                                echo "<td>" . number_format($obj->ADDKOIN) . "</td>";
                                echo "<td>" . number_format($obj->CHIPVERIFY) . "</td>";
//                                echo "<td>" . number_format($row['regKoin']) . "</td>";
                                echo "<td>" . number_format($obj->KOINADMIN) . "</td>";
                                echo "<td>" . number_format($obj->BOOM) . "</td>";

                                $total2 = $total + $obj->KOINVIPSMS + $obj->KOINVIPCARD + $obj->KOINVIPIAP + $obj->XOCDIAVIP +
                                        $obj->BAUCUAVIP + $obj->CASHOUT + $obj->ADDKOIN + $obj->CHIPVERIFY + $obj->KOINADMIN + $obj->BOOM;
                                echo "<td style='background-color:#FCD5B4;'><b>" . number_format($total2) . "</b></td>";
                                echo "</tr>";
                            }
                            ?>
                        </table>
                        <br />
                        <div id="chart-container-1" style="width: <?php echo $size; ?>; height: 350px"></div>
                        <br />
                        <div id="chart-container-2" style="width: <?php echo $size; ?>; height: 350px"></div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
<?php include 'cache_end.php'; ?>