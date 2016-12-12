<?php
include 'cache_begin.php';
require_once 'util.php';
$totalMoney = 0;
$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$fromDate = isset($_REQUEST['fromDate']) ? trim($_REQUEST['fromDate']) : date('Y-m-d', time());
$toDate = isset($_REQUEST['toDate']) ? trim($_REQUEST['toDate']) : date('Y-m-d', time());

$title = 'Chia sẻ doanh thu';

$pnames = get_partner_names();


// SMS (dau so cua VMG)

// include 'connectdb_logsms.php';
include 'connectdb_gimwap.php';

// $where = "service in ('nap_bem', 'dk_bem', 'change_bem')";
// $where = '1 = 1';
$where = "test = 0 and recipient != '0000'";
if(!empty($fromDate) AND !empty($toDate))
{
    $where .= " and created_on between '$fromDate 00:00:00' and '$toDate 23:59:59'";
} else
{
    $fromDate = $toDate = NULL;
}
$where2 = "recipient != '0000'";
if(!empty($fromDate) AND !empty($toDate))
{
    $where2 .= " and created_on between '$fromDate 00:00:00' and '$toDate 23:59:59'";
} else
{
    $fromDate = $toDate = NULL;
}
$where .= ' and recipient in ('.implode(',', $MV_RECIPIENTS).')';

$chart_data = build_table_stat_sms($where, $where2);

$sum = array_sum($chart_data['Tổng']);
$sum2 = format_money($sum * SMS_TELCO_SHARE);
$sum3 = format_money($sum * SMS_TELCO_SHARE * SMS_PROVIDER_SHARE);
$sum = format_money($sum);
unset($chart_data['Tổng']);

$chart_title = "Chia sẻ doanh thu SMS (Đầu số của MV) : $fromDate -> $toDate<br>
        Tổng: Trước telco (100%): $sum,
        Sau telco (".(SMS_TELCO_SHARE*100)."%): $sum2,
        Thu về (".(SMS_TELCO_SHARE*100)."% * ".(SMS_PROVIDER_SHARE*100)."%): $sum3";



// SMS (dau so cua doi tac)

// include 'connectdb_gimwap.php';

$where = "test = 0 and recipient != '0000'";
if(!empty($fromDate) AND !empty($toDate))
{
    $where .= " and created_on between '$fromDate 00:00:00' and '$toDate 23:59:59'";
} else
{
    $fromDate = $toDate = NULL;
}

$where .= ' and recipient not in ('.implode(',', $MV_RECIPIENTS).')';

$where2 = '1 = 1';
if(!empty($fromDate) AND !empty($toDate))
{
    $where2 .= " and created_on between '$fromDate 00:00:00' and '$toDate 23:59:59'";
} else
{
    $fromDate = $toDate = NULL;
}

$where2 .= ' and recipient not in ('.implode(',', $MV_RECIPIENTS).')';

$chart_data3 = build_table_stat_sms2($where, $where2);

$sum = array_sum($chart_data3['Tổng']);
$sum2 = format_money($sum * SMS_TELCO_SHARE);
$sum3 = format_money($sum * SMS_TELCO_SHARE * SMS_PROVIDER_SHARE);
$sum = format_money($sum);
unset($chart_data3['Tổng']);

$chart_title3 = "Chia sẻ doanh thu SMS (Đầu số của đối tác) : $fromDate -> $toDate<br>
        Tổng: Trước telco (100%): $sum,
        Sau telco (".(SMS_TELCO_SHARE*100)."%): $sum2,
        Thu về (".(SMS_TELCO_SHARE*100)."% * ".(SMS_PROVIDER_SHARE*100)."%): $sum3";



// CARD (cua VMG)

include 'connectdb_vnptcard.php';

$where = "success = 1";
if(!empty($fromDate) AND !empty($toDate))
{
    $where .= " and created_on between '$fromDate 00:00:00' and '$toDate 23:59:59'";
} else
{
    $fromDate = $toDate = NULL;
}

$where .= ' and cp not in ("'.implode('","', $OWNCARD_PARTNERS).'")';

$chart_data2 = build_table_stat_card_cp($where);

$sum = array_sum($chart_data2['Tổng']);
$sum2 = format_money($sum * CARD_PROVIDER_SHARE);
$sum = format_money($sum);
unset($chart_data2['Tổng']);

$chart_title2 = "Chia sẻ doanh thu thẻ cào (của MV) : $fromDate -> $toDate<br>
        Tổng: Giá trị thẻ (100%): $sum,
        Thu về (".(CARD_PROVIDER_SHARE*100)."%): $sum2";


// CARD (cua doi tac)

$where = "success = 1";
if(!empty($fromDate) AND !empty($toDate))
{
    $where .= " and created_on between '$fromDate 00:00:00' and '$toDate 23:59:59'";
} else
{
    $fromDate = $toDate = NULL;
}

$where .= ' and cp in ("'.implode('","', $OWNCARD_PARTNERS).'")';

$chart_data4 = build_table_stat_card_cp($where);

$sum = array_sum($chart_data4['Tổng']);
$sum2 = format_money($sum * CARD_PROVIDER_SHARE);
$sum = format_money($sum);
unset($chart_data4['Tổng']);

$chart_title4 = "Chia sẻ doanh thu thẻ cào (của đối tác: '".implode("', '", $OWNCARD_PARTNERS)."') : $fromDate -> $toDate<br>
        Tổng: Giá trị thẻ (100%): $sum,
        Thu về (".(CARD_PROVIDER_SHARE*100)."%): $sum2";



?>
<!DOCTYPE html>
<html>
    <head>
        <title><?php echo $title; ?></title>
        <?php require('header.php'); ?>
        <script>
            $(document).ready(function(){
                $("#datepicker1").datepicker();
                $("#datepicker2").datepicker();
            }); 
        </script>


        <!-- chart 1 -->

        <script type='text/javascript'>
          google.load('visualization', '1', {packages:['table']});
          google.setOnLoadCallback(drawTable);
          function drawTable() {
            var data = new google.visualization.DataTable();
            data.addColumn('string', 'Tên đối tác');
            /*
            data.addColumn('number', '$ Đối tác (S1)');
            data.addColumn('number', '$ K2 (S1)');
            data.addColumn('number', '$ VMG (S1)');
            data.addColumn('number', '$ Đối tác (S2)');
            data.addColumn('number', '$ K2 (S2)');
            data.addColumn('number', '$ VMG (S2)');
            */
            data.addColumn('number', '$ Đối tác (S3)');
            data.addColumn('number', '$ K2 (S3)');
            data.addColumn('number', '$ MV (S3)');
            data.addColumn('number', 'Tổng doanh thu sau đầu số');
            data.addColumn('number', 'K2 thu về');
            data.addColumn('number', 'MV thu về');
            <?php
            $count = count($chart_data);
            echo "data.addRows($count + 1);";
            $keys = array_keys($chart_data);
            
            $sum1 = $sum2 = $sum3 = $sum4 = $sum5 = $sum6 = 
                    $sum7 = $sum8 = $sum9 = $suma = $sumb = $sumc = 0;
            for($i = 0; $i < $count; $i++) {
                $partner = $keys[$i];
                $arr = $chart_data[$partner];
                
                $pname = getv($partner, $pnames);

                /*
                $col1 = $arr[0];
                $col2 = $arr[1];
                $col3 = $arr[2];
                $col4 = $arr[0] * SMS_TELCO_SHARE;
                $col5 = $arr[1] * SMS_TELCO_SHARE;
                $col6 = $arr[2] * SMS_TELCO_SHARE;
                */
                $col7 = $arr[0] * SMS_TELCO_SHARE * SMS_PROVIDER_SHARE;
                $col8 = $arr[1] * SMS_TELCO_SHARE * SMS_PROVIDER_SHARE;
                $col9 = $arr[2] * SMS_TELCO_SHARE * SMS_PROVIDER_SHARE;
                $cola = $col7 + $col8 + $col9;
                if(startsWith($pname, 'K2 - ')) {
                    $colb = $col7 + $col8;
                    $colc = $col9;
                } else
                {
                    $colb = $col8;
                    $colc = $col7 + $col9;
                }

                echo "data.setCell($i, 0, '".$pname."');";
                /*
                echo "data.setCell($i, 1, ".$col1.", '".format_money($col1)."');"; $sum1 += $col1;
                echo "data.setCell($i, 2, ".$col2.", '".format_money($col2)."');"; $sum2 += $col2;
                echo "data.setCell($i, 3, ".$col3.", '".format_money($col3)."');"; $sum3 += $col3;
                echo "data.setCell($i, 4, ".$col4.", '".format_money($col4)."');"; $sum4 += $col4;
                echo "data.setCell($i, 5, ".$col5.", '".format_money($col5)."');"; $sum5 += $col5;
                echo "data.setCell($i, 6, ".$col6.", '".format_money($col6)."');"; $sum6 += $col6;
                */
                echo "data.setCell($i, 1, ".$col7.", '".format_money($col7)."');"; $sum7 += $col7;
                echo "data.setCell($i, 2, ".$col8.", '".format_money($col8)."');"; $sum8 += $col8;
                echo "data.setCell($i, 3, ".$col9.", '".format_money($col9)."');"; $sum9 += $col9;
                echo "data.setCell($i, 4, ".$cola.", '".format_money($cola)."');"; $suma += $cola;
                echo "data.setCell($i, 5, ".$colb.", '".format_money($colb)."');"; $sumb += $colb;
                echo "data.setCell($i, 6, ".$colc.", '".format_money($colc)."');"; $sumc += $colc;

            }
            // summary
            echo "data.setCell($i, 0, 'Tổng:');";
            /*
            echo "data.setCell($i, 1, ".$sum1.", '".format_money($sum1)."');";
            echo "data.setCell($i, 2, ".$sum2.", '".format_money($sum2)."');";
            echo "data.setCell($i, 3, ".$sum3.", '".format_money($sum3)."');";
            echo "data.setCell($i, 4, ".$sum4.", '".format_money($sum4)."');";
            echo "data.setCell($i, 5, ".$sum5.", '".format_money($sum5)."');";
            echo "data.setCell($i, 6, ".$sum6.", '".format_money($sum6)."');";
            */
            echo "data.setCell($i, 1, ".$sum7.", '".format_money($sum7)."');";
            echo "data.setCell($i, 2, ".$sum8.", '".format_money($sum8)."');";
            echo "data.setCell($i, 3, ".$sum9.", '".format_money($sum9)."');";
            echo "data.setCell($i, 4, ".$suma.", '".format_money($suma)."');";
            echo "data.setCell($i, 5, ".$sumb.", '".format_money($sumb)."');";
            echo "data.setCell($i, 6, ".$sumc.", '".format_money($sumc)."');";
			$totalMoney += $suma;
            ?>

            var table = new google.visualization.Table(document.getElementById('table_div'));
            table.draw(data, {showRowNumber: true});
          }
        </script>


        <!-- chart 3 -->

        <script type='text/javascript'>
          google.load('visualization', '1', {packages:['table']});
          google.setOnLoadCallback(drawTable);
          function drawTable() {
            var data = new google.visualization.DataTable();
            data.addColumn('string', 'Tên đối tác');
            /*
            data.addColumn('number', '$ Đối tác (S1)');
            data.addColumn('number', '$ K2 (S1)');
            data.addColumn('number', '$ VMG (S1)');
            data.addColumn('number', '$ Đối tác (S2)');
            data.addColumn('number', '$ K2 (S2)');
            data.addColumn('number', '$ VMG (S2)');
            */
            data.addColumn('number', '$ Đối tác (S3)');
            data.addColumn('number', '$ K2 (S3)');
            data.addColumn('number', '$ MV (S3)');
            data.addColumn('number', 'Tổng doanh thu sau đầu số');
            data.addColumn('number', 'K2 thu về');
            data.addColumn('number', 'MV thu về');
            <?php
            $count = count($chart_data3);
            echo "data.addRows($count + 1);";
            $keys = array_keys($chart_data3);
            
            $sum1 = $sum2 = $sum3 = $sum4 = $sum5 = $sum6 = 
                    $sum7 = $sum8 = $sum9 = $suma = $sumb = $sumc = 0;
            for($i = 0; $i < $count; $i++) {
                $partner = $keys[$i];
                $arr = $chart_data3[$partner];
                
                $pname = getv($partner, $pnames);

                /*
                $col1 = $arr[0];
                $col2 = $arr[1];
                $col3 = $arr[2];
                $col4 = $arr[0] * SMS_TELCO_SHARE;
                $col5 = $arr[1] * SMS_TELCO_SHARE;
                $col6 = $arr[2] * SMS_TELCO_SHARE;
                */
                $col7 = $arr[0] * SMS_TELCO_SHARE * SMS_PROVIDER_SHARE;
                $col8 = $arr[1] * SMS_TELCO_SHARE * SMS_PROVIDER_SHARE;
                $col9 = $arr[2] * SMS_TELCO_SHARE * SMS_PROVIDER_SHARE;
                $cola = $col7 + $col8 + $col9;
                if(startsWith($pname, 'K2 - ')) {
                    $colb = $col7 + $col8;
                    $colc = $col9;
                } else
                {
                    $colb = $col8;
                    $colc = $col7 + $col9;
                }

                echo "data.setCell($i, 0, '".$pname."');";
                /*
                echo "data.setCell($i, 1, ".$col1.", '".format_money($col1)."');"; $sum1 += $col1;
                echo "data.setCell($i, 2, ".$col2.", '".format_money($col2)."');"; $sum2 += $col2;
                echo "data.setCell($i, 3, ".$col3.", '".format_money($col3)."');"; $sum3 += $col3;
                echo "data.setCell($i, 4, ".$col4.", '".format_money($col4)."');"; $sum4 += $col4;
                echo "data.setCell($i, 5, ".$col5.", '".format_money($col5)."');"; $sum5 += $col5;
                echo "data.setCell($i, 6, ".$col6.", '".format_money($col6)."');"; $sum6 += $col6;
                */
                echo "data.setCell($i, 1, ".$col7.", '".format_money($col7)."');"; $sum7 += $col7;
                echo "data.setCell($i, 2, ".$col8.", '".format_money($col8)."');"; $sum8 += $col8;
                echo "data.setCell($i, 3, ".$col9.", '".format_money($col9)."');"; $sum9 += $col9;
                echo "data.setCell($i, 4, ".$cola.", '".format_money($cola)."');"; $suma += $cola;
                echo "data.setCell($i, 5, ".$colb.", '".format_money($colb)."');"; $sumb += $colb;
                echo "data.setCell($i, 6, ".$colc.", '".format_money($colc)."');"; $sumc += $colc;

            }
            // summary
            echo "data.setCell($i, 0, 'Tổng:');";
            /*
            echo "data.setCell($i, 1, ".$sum1.", '".format_money($sum1)."');";
            echo "data.setCell($i, 2, ".$sum2.", '".format_money($sum2)."');";
            echo "data.setCell($i, 3, ".$sum3.", '".format_money($sum3)."');";
            echo "data.setCell($i, 4, ".$sum4.", '".format_money($sum4)."');";
            echo "data.setCell($i, 5, ".$sum5.", '".format_money($sum5)."');";
            echo "data.setCell($i, 6, ".$sum6.", '".format_money($sum6)."');";
            */
            echo "data.setCell($i, 1, ".$sum7.", '".format_money($sum7)."');";
            echo "data.setCell($i, 2, ".$sum8.", '".format_money($sum8)."');";
            echo "data.setCell($i, 3, ".$sum9.", '".format_money($sum9)."');";
            echo "data.setCell($i, 4, ".$suma.", '".format_money($suma)."');";
            echo "data.setCell($i, 5, ".$sumb.", '".format_money($sumb)."');";
            echo "data.setCell($i, 6, ".$sumc.", '".format_money($sumc)."');";
			$totalMoney += $suma;
            ?>

            var table = new google.visualization.Table(document.getElementById('table_div3'));
            table.draw(data, {showRowNumber: true});
          }
        </script>


        <!-- chart 2 -->

        <script type='text/javascript'>
          google.load('visualization', '1', {packages:['table']});
          google.setOnLoadCallback(drawTable);
          function drawTable() {
            var data = new google.visualization.DataTable();
            data.addColumn('string', 'Tên đối tác');
            /*
            data.addColumn('number', '$ Đối tác (C1)');
            data.addColumn('number', '$ K2 (C1)');
            data.addColumn('number', '$ VMG (C1)');
            */
            data.addColumn('number', '$ Đối tác (C2)');
            data.addColumn('number', '$ K2 (C2)');
            data.addColumn('number', '$ MV (C2)');
            data.addColumn('number', 'Tổng doanh thu');
            data.addColumn('number', 'K2 thu về');
            data.addColumn('number', 'MV thu về');
            <?php
            $count = count($chart_data2);
            echo "data.addRows($count + 1);";
            $keys = array_keys($chart_data2);

            $sum1 = $sum2 = $sum3 = $sum4 = $sum5 = $sum6 = $suma = $sumb = $sumc = 0;
            for($i = 0; $i < $count; $i++) {
                $cp = $keys[$i];
                $arr = $chart_data2[$cp];

                $pname = getv($cp, $pnames);

                /*
                $col1 = $arr[0];
                $col2 = $arr[1];
                $col3 = $arr[2];
                */
                $col4 = $arr[0] * CARD_PROVIDER_SHARE;
                $col5 = $arr[1] * CARD_PROVIDER_SHARE;
                $col6 = $arr[2] * CARD_PROVIDER_SHARE;
                $cola = $col4 + $col5 + $col6;
                if(startsWith($pname, 'K2 - ')) {
                    $colb = $col4 + $col5;
                    $colc = $col6;
                } else
                {
                    $colb = $col5;
                    $colc = $col4 + $col6;
                }

                echo "data.setCell($i, 0, '{$pname}');";
                /*
                echo "data.setCell($i, 1, ".$col1.", '".format_money($col1)."');"; $sum1 += $col1;
                echo "data.setCell($i, 2, ".$col2.", '".format_money($col2)."');"; $sum2 += $col2;
                echo "data.setCell($i, 3, ".$col3.", '".format_money($col3)."');"; $sum3 += $col3;
                */
                echo "data.setCell($i, 1, ".$col4.", '".format_money($col4)."');"; $sum4 += $col4;
                echo "data.setCell($i, 2, ".$col5.", '".format_money($col5)."');"; $sum5 += $col5;
                echo "data.setCell($i, 3, ".$col6.", '".format_money($col6)."');"; $sum6 += $col6;
                echo "data.setCell($i, 4, ".$cola.", '".format_money($cola)."');"; $suma += $cola;
                echo "data.setCell($i, 5, ".$colb.", '".format_money($colb)."');"; $sumb += $colb;
                echo "data.setCell($i, 6, ".$colc.", '".format_money($colc)."');"; $sumc += $colc;
            }
            // summary
            echo "data.setCell($i, 0, 'Tổng:');";
            /*
            echo "data.setCell($i, 1, ".$sum1.", '".format_money($sum1)."');";
            echo "data.setCell($i, 2, ".$sum2.", '".format_money($sum2)."');";
            echo "data.setCell($i, 3, ".$sum3.", '".format_money($sum3)."');";
            */
            echo "data.setCell($i, 1, ".$sum4.", '".format_money($sum4)."');";
            echo "data.setCell($i, 2, ".$sum5.", '".format_money($sum5)."');";
            echo "data.setCell($i, 3, ".$sum6.", '".format_money($sum6)."');";
            echo "data.setCell($i, 4, ".$suma.", '".format_money($suma)."');";
            echo "data.setCell($i, 5, ".$sumb.", '".format_money($sumb)."');";
            echo "data.setCell($i, 6, ".$sumc.", '".format_money($sumc)."');";
			$totalMoney += $suma;
            ?>

            var table = new google.visualization.Table(document.getElementById('table_div2'));
            table.draw(data, {showRowNumber: true});
          }
        </script>


        <!-- chart 4 -->

        <script type='text/javascript'>
          google.load('visualization', '1', {packages:['table']});
          google.setOnLoadCallback(drawTable);
          function drawTable() {
            var data = new google.visualization.DataTable();
            data.addColumn('string', 'Tên đối tác');
            /*
            data.addColumn('number', '$ Đối tác (C1)');
            data.addColumn('number', '$ K2 (C1)');
            data.addColumn('number', '$ VMG (C1)');
            */
            data.addColumn('number', '$ Đối tác (C2)');
            data.addColumn('number', '$ K2 (C2)');
            data.addColumn('number', '$ MV (C2)');
            data.addColumn('number', 'Tổng doanh thu');
            data.addColumn('number', 'K2 thu về');
            data.addColumn('number', 'MV thu về');
            <?php
            $count = count($chart_data4);
            echo "data.addRows($count + 1);";
            $keys = array_keys($chart_data4);

            $sum1 = $sum2 = $sum3 = $sum4 = $sum5 = $sum6 = $suma = $sumb = $sumc = 0;
            for($i = 0; $i < $count; $i++) {
                $cp = $keys[$i];
                $arr = $chart_data4[$cp];

                $pname = getv($cp, $pnames);

                /*
                $col1 = $arr[0];
                $col2 = $arr[1];
                $col3 = $arr[2];
                */
                $col4 = $arr[0] * CARD_PROVIDER_SHARE;
                $col5 = $arr[1] * CARD_PROVIDER_SHARE;
                $col6 = $arr[2] * CARD_PROVIDER_SHARE;
                $cola = $col4 + $col5 + $col6;
                if(startsWith($pname, 'K2 - ')) {
                    $colb = $col4 + $col5;
                    $colc = $col6;
                } else
                {
                    $colb = $col5;
                    $colc = $col4 + $col6;
                }

                echo "data.setCell($i, 0, '{$pname}');";
                /*
                echo "data.setCell($i, 1, ".$col1.", '".format_money($col1)."');"; $sum1 += $col1;
                echo "data.setCell($i, 2, ".$col2.", '".format_money($col2)."');"; $sum2 += $col2;
                echo "data.setCell($i, 3, ".$col3.", '".format_money($col3)."');"; $sum3 += $col3;
                */
                echo "data.setCell($i, 1, ".$col4.", '".format_money($col4)."');"; $sum4 += $col4;
                echo "data.setCell($i, 2, ".$col5.", '".format_money($col5)."');"; $sum5 += $col5;
                echo "data.setCell($i, 3, ".$col6.", '".format_money($col6)."');"; $sum6 += $col6;
                echo "data.setCell($i, 4, ".$cola.", '".format_money($cola)."');"; $suma += $cola;
                echo "data.setCell($i, 5, ".$colb.", '".format_money($colb)."');"; $sumb += $colb;
                echo "data.setCell($i, 6, ".$colc.", '".format_money($colc)."');"; $sumc += $colc;
            }
            // summary
            echo "data.setCell($i, 0, 'Tổng:');";
            /*
            echo "data.setCell($i, 1, ".$sum1.", '".format_money($sum1)."');";
            echo "data.setCell($i, 2, ".$sum2.", '".format_money($sum2)."');";
            echo "data.setCell($i, 3, ".$sum3.", '".format_money($sum3)."');";
            */
            echo "data.setCell($i, 1, ".$sum4.", '".format_money($sum4)."');";
            echo "data.setCell($i, 2, ".$sum5.", '".format_money($sum5)."');";
            echo "data.setCell($i, 3, ".$sum6.", '".format_money($sum6)."');";
            echo "data.setCell($i, 4, ".$suma.", '".format_money($suma)."');";
            echo "data.setCell($i, 5, ".$sumb.", '".format_money($sumb)."');";
            echo "data.setCell($i, 6, ".$sumc.", '".format_money($sumc)."');";
			$totalMoney += $suma;
            ?>
			
            var table = new google.visualization.Table(document.getElementById('table_div4'));
            table.draw(data, {showRowNumber: true});
          }
        </script>



    </head>
    <body>
        <div class="pagewrap">
            <?php require('topMenu.php'); ?>
            <?php include('topMenu.sub2.php'); ?>
            <!-- sms (dau so cua VMG) -->

			<div style="text-align:center; font-weight:bold; font-size:20px;"><?php echo number_format($totalMoney);?></div>
			
            <div class="box grid">
                <div class="box_header"><a href="javascript:void(0);"><?php echo $chart_title; ?></a></div>
                <div class="box_body">
                    <table width="100%">
                        <div style="padding-left:10px;">
                            <form action="" method="post">
                                Từ ngày
                                <input type="text" id="datepicker1" name="fromDate" style="text-align: center; width: 100px;" value="<?php echo $fromDate;?>"/> 
                                (00:00:00)
                                Tới ngày
                                <input type="text" id="datepicker2" name="toDate" style="text-align: center; width: 100px;" value="<?php echo $toDate;?>"/> 
                                (23:59:59)
                                <input type="submit" value="Cập nhật" class="input_button"/>
                            </form>
                        </div>
                        <br>
                        <div>Chú thích - <strong>S1</strong>: Trước telco, <strong>S2</strong>: Sau telco, <strong>S3</strong>: Thu về</div>
                        <div id='table_div'></div>

                    </table>
                </div>
            </div>

            <!-- sms (dau so cua doi tac) -->
            <div class="box grid">
                <div class="box_header"><a href="javascript:void(0);"><?php echo $chart_title3; ?></a></div>
                <div class="box_body">
                    <table width="100%">

                        <div style="padding-left:10px;">
                            <form action="" method="post">
                                Từ ngày
                                <input type="text" id="datepicker1" name="fromDate" style="text-align: center; width: 100px;" value="<?php echo $fromDate;?>"/> 
                                (00:00:00)
                                Tới ngày
                                <input type="text" id="datepicker2" name="toDate" style="text-align: center; width: 100px;" value="<?php echo $toDate;?>"/> 
                                (23:59:59)
                                <input type="submit" value="Cập nhật" class="input_button"/>
                            </form>
                        </div>
                        <br>
                        <div>Chú thích - <strong>S1</strong>: Trước telco, <strong>S2</strong>: Sau telco, <strong>S3</strong>: Thu về</div>
                        <div id='table_div3'></div>

                    </table>
                </div>
            </div>

            <!-- the cao (cua VMG) -->
            <div class="box grid">
                <div class="box_header"><a href="javascript:void(0);"><?php echo $chart_title2; ?></a></div>
                <div class="box_body">
                    <table width="100%">
                        <div>Chú thích - <strong>C1</strong>: Giá trị thẻ, <strong>C2</strong>: Thu về</div>
                        <div id='table_div2'></div>

                    </table>
                </div>
            </div>

            <!-- the cao (cua doi tac) -->
            <div class="box grid">
                <div class="box_header"><a href="javascript:void(0);"><?php echo $chart_title4; ?></a></div>
                <div class="box_body">
                    <table width="100%">
                        <div>Chú thích - <strong>C1</strong>: Giá trị thẻ, <strong>C2</strong>: Thu về</div>
                        <div id='table_div4'></div>
                    </table>
                </div>
            </div>
        </div>
    </body>
</html>

<?php include 'cache_end.php'; ?>