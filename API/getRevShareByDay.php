<?php

require('../Config.php');
require('db.class.php');
$parameters = $_GET;
$fromDate = $parameters['fromDate'];
$toDate = $parameters['toDate'];
unset($parameters['fromDate']);
unset($parameters['toDate']);
$array_date = createDateRangeArray($fromDate, $toDate);
$today = date('Y-m-d', time());
if (empty($parameters)) {
    echo "<span style='font-weight:bold;color:red;'>Phải chọn ít nhất 1 Fee</span>";
    exit;
}
//var_dump($parameter);die;
try {
    $found = false;
    include('Net/SSH2.php');

    $fee_game = 0;
    $bau_cua = 0;
    $xoc_dia = 0;
    $card_xu = 0;
    $gold_to_koin = 0;
    $boom = 0;
    $sms_xu = 0;
    $iap = 0;

    $sql_sms_koin = "SELECT SUM(money) AS total_money FROM log_nap_koin WHERE flag1 = 0 AND type = 1 AND date(created_on) >= '{$fromDate}' AND date(created_on) <= '{$toDate}'";
    $sql_card_koin = "SELECT SUM(money) AS total_money FROM log_nap_koin WHERE flag1 = 0 AND type = 2 AND date(created_on) >= '{$fromDate}' AND date(created_on) <= '{$toDate}'";    
    $sql_iap = "SELECT SUM(money) AS total_money FROM log_nap_koin WHERE type = 4 AND date(created_on) >= '{$fromDate}' AND date(created_on) <= '{$toDate}'";

    $stmt1 = $db->prepare($sql_sms_koin);
    $stmt1->execute();
    $sms = $stmt1->fetch();
    $sms_xu = $sms['total_money'];

    $stmt2 = $db->prepare($sql_card_koin);
    $stmt2->execute();
    $card = $stmt2->fetch();
    $card_xu = $card['total_money'];

    $stmt3 = $db->prepare($sql_iap);
    $stmt3->execute();
    $iap_rs = $stmt3->fetch();
    $iap = $iap_rs['total_money'];

    $sql = "select * from server_chip_daily where datecreate >= '{$fromDate}' and datecreate <= '{$toDate}'";
    foreach ($db->query($sql) as $row) {
        $total_fee = json_decode($row['data'], true);
        $fee_game += abs($total_fee['TLMN']) + abs($total_fee['BACAYCH']) + abs($total_fee['TLMNDC']) + abs($total_fee['XOCDIA']) + abs($total_fee['PHOM']) + abs($total_fee['LIENG']) + abs($total_fee['SAM']) + abs($total_fee['BAUCUA']) + abs($total_fee['XITO']) + abs($total_fee['POKER']) + abs($total_fee['BACAY']);
        $bau_cua += abs($row['vipbaucua']);
        $xoc_dia += abs($row['vipxocdia']);
        $gold_to_koin += abs($total_fee['GOLDTOSILVER_PUT']);
        $boom += abs($total_fee['BOOM']);
    }

    if (in_array($today, $array_date)) {
        $server = __HOST;
        $port = __PORT;
        $remote = "gdg";
        $password = "$#Fsda345#1z";
        $command = "ps";
        $log = '';
        $ssh = new Net_SSH2($server, $port, 100);
        if (!$ssh->login($remote, $password)) {
            exit('Login Failed');
        }

        $cmd = "python checkFeeVip.py";
        $fee_chip_today_json = $ssh->exec($cmd);
        $fee_chip_today = json_decode($fee_chip_today_json, true);
        $fee_game += abs($fee_chip_today['XOCDIA']) + abs($fee_chip_today['TLMN']) + abs($fee_chip_today['BACAYCH']) + abs($fee_chip_today['TLMNDC']) + abs($fee_chip_today['PHOM']) + abs($fee_chip_today['LIENG']) + abs($fee_chip_today['SAM']) + abs($fee_chip_today['BAUCUA']) + abs($fee_chip_today['XITO']) + abs($fee_chip_today['POKER']) + abs($fee_chip_today['BACAY']);
        $bau_cua += abs($fee_chip_today['HOSTBAUCUA']);
        $xoc_dia += abs($fee_chip_today['HOSTXOCDIA']);
        $gold_to_koin += abs($fee_chip_today['GOLDTOSILVER_PUT']);
        $boom += abs($fee_chip_today['BOOM']);
    }    

    $list_rev = array(
        'fee' => array(
            'total' => $fee_game,
            'rate' => 0.81,
            'net' => $fee_game * 0.81
        ),
        'baucua' => array(
            'total' => $bau_cua,
            'rate' => 0.81,
            'net' => $bau_cua * 0.81
        ),
        'xocdia' => array(
            'total' => $xoc_dia,
            'rate' => 0.81,
            'net' => $xoc_dia * 0.81
        ),
        'card_koin' => array(
            'total' => $card_xu,
            'rate' => 0.81,
            'net' => $card_xu * 0.81
        ),
        'gold_to_koin' => array(
            'total' => $gold_to_koin,
            'rate' => 0.81,
            'net' => $gold_to_koin * 0.81
        ),
        'boom' => array(
            'total' => -1 * $boom,
            'rate' => 0.81,
            'net' => -1 * $boom * 0.81
        ),
        'sms_koin' => array(
            'total' => $sms_xu,
            'rate' => 0.35,
            'net' => $sms_xu * 0.35
        ),
        'iap' => array(
            'total' => $iap,
            'rate' => 0.65,
            'net' => $iap * 0.65
        )
    );
    $i = 0;
    $html = "<table width='100%'><tr style='background-color: rgb(255, 255, 255);text-align:center;font-weight:bold;'>";
    $html .= "<td>STT</td><td>Fee Name</td><td>Total</td><td>Rate</td><td>Net.</td></tr>";
    $total_rev_share = 0;
    foreach ($parameters as $parameter) {
        $i+=1;
        $html .= "<tr style='background-color: rgb(" . ($i % 2 > 0 ? "204,204,204" : "255, 255, 255") . ");text-align:center;'>";
        $html .= "<td width='5%'>" . $i . "</td>";
        $html .= "<td width='20%'>" . getNameFee($parameter) . "</td>";
        $html .= "<td width='10%'>" . number_format($list_rev[$parameter]['total']) . "</td>";
        $html .= "<td width='10%'>" . $list_rev[$parameter]['rate'] . "</td>";
        $html .= "<td width='10%'>" . number_format($list_rev[$parameter]['net']) . "</td>";
        $html .= "</tr>";
        $total_rev_share += $list_rev[$parameter]['net'];
    }
    $html .= "<tr style='background-color: rgb(255, 255, 255);text-align:center;font-weight:bold;'><td colspan='4'>Tổng</td><td style='color:red; '>" . number_format($total_rev_share) . "</td></tr>";
    $html .= "</table>";

    echo $html;
    exit;
//    echo $log;
} catch (Exception $e) {
    echo $e->getMessage();
}

function createDateRangeArray($strDateFrom, $strDateTo) {
    // takes two dates formatted as YYYY-MM-DD and creates an
    // inclusive array of the dates between the from and to dates.
    // could test validity of dates here but I'm already doing
    // that in the main script

    $aryRange = array();

    $iDateFrom = mktime(1, 0, 0, substr($strDateFrom, 5, 2), substr($strDateFrom, 8, 2), substr($strDateFrom, 0, 4));
    $iDateTo = mktime(1, 0, 0, substr($strDateTo, 5, 2), substr($strDateTo, 8, 2), substr($strDateTo, 0, 4));

    if ($iDateTo >= $iDateFrom) {
        array_push($aryRange, date('Y-m-d', $iDateFrom)); // first entry
        while ($iDateFrom < $iDateTo) {
            $iDateFrom+=86400; // add 24 hours
            array_push($aryRange, date('Y-m-d', $iDateFrom));
        }
    }
    return $aryRange;
}

function getNameFee($code) {
    $name_fee = '';
    switch ($code) {
        case 'fee':
            $name_fee = 'Fee Game';
            break;
        case 'baucua':
            $name_fee = 'Bầu cua';
            break;
        case 'xocdia':
            $name_fee = "Xóc đĩa";
            break;
        case 'card_koin':
            $name_fee = 'Card nạp Xu';
            break;
        case 'gold_to_koin':
            $name_fee = 'Vàng đổi Xu';
            break;
        case 'boom':
            $name_fee = 'Nổ hũ';
            break;
        case 'sms_koin':
            $name_fee = 'SMS nạp Xu';
            break;
        case 'iap':
            $name_fee = 'IAP';
            break;
    }
    return $name_fee;
}
