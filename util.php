<?php

require_once 'const.php';
require_once ('API/db2.class.php');

//////////// recipients, issuers

function get_rec_arr($where) {
    $result = mysql_query("
            select distinct recipient
            from auth_user_partner
            where $where
            ");
    $rec_arr = array();
    $mean_no = array(0, 1, 2, 3, 4, 5, 6, 7);
    while ($row = mysql_fetch_array($result, MYSQL_NUM)) {
        $recipient = $row[0];
        $char = (int) $recipient{1};
        if (in_array($char, $mean_no)) {
            $rec_arr[] = $recipient;
        }
    }
    return $rec_arr;
}

function get_iss_arr() {
    return array('VTT', 'MOBI', 'VINA', 'FPT', 'VTC');
}

/////////// database queries

function get_sms_by_date_rec($where) {
    $arr = array();
    $result = mysql_query("
            select date(created_on) as date, recipient, count(*) as count
            from auth_user_partner
            where $where
            group by date, recipient
            ");
    while ($row = mysql_fetch_assoc($result)) {
        $date = $row['date'];
        $recipient = $row['recipient'];
        $count = $row['count'];
        $arr[$date][$recipient] = $count;
    }
    return $arr;
}

function get_card_by_date_iss_val($where) {
    global $db2;
    $arr = array();
    /* $result = mysql_query("
      select date, issuer, cardvalue, sum(count) as count
      from
      (
      select date(created_on) as date, issuer, cardvalue, count(*) as count
      from vmg_card.request
      where $where
      group by date, issuer, cardvalue
      UNION
      select date(created_on) as date, issuer, cardvalue, count(*) as count
      from vnpt_card.request
      where $where
      group by date, issuer, cardvalue
      ) SS
      group by date, issuer, cardvalue
      "); */
    $result = mysql_query("
            select date(created_on) as date, issuer, cardvalue, count(*) as count
            from request
            where $where
            group by date, issuer, cardvalue
            ");
    while ($row = mysql_fetch_assoc($result)) {
        $date = $row['date'];
        $iss = $row['issuer'];
        $val = $row['cardvalue'];
        $count = $row['count'];
        $arr[$date][$iss][$val] = $count;
    }

    //$sql = "select * from ngl_card.request where username='{$username}' and date(created_on)='{$date}'";
    $result = "(select date(created_on) as date, issuer, cardvalue, count(*) as count
            from request
            where $where
            group by date, issuer, cardvalue)            
            ";
    foreach ($db2->query($result) as $row) {
        $date = $row['date'];
        $iss = $row['issuer'];
        $val = $row['cardvalue'];
        $count = $row['count'];
        $arr[$date][$iss][$val] += $count;
    }
    return $arr;
}

function get_card_by_date_cp_val($where) {
    $arr = array();
    $result = mysql_query("
            select date(created_on) as date, cp, cardvalue, count(*) as count
            from vnpt_card.request
            where $where
            group by date, cp, cardvalue
            ");
    while ($row = mysql_fetch_assoc($result)) {
        $date = $row['date'];
        $cp = $row['cp'];
        $val = $row['cardvalue'];
        $count = $row['count'];
        $arr[$date][$cp][$val] = $count;
    }
    return $arr;
}

////////////////

/**
 * fill recipient if not set
 */
function get_full_sms_by_date_rec($where, $rec_arr) {
    $data = get_sms_by_date_rec($where);

    $date_arr = array_keys($data);
    $no_date = count($data);

    for ($i = 0; $i < $no_date; $i++) {
        $date_str = $date_arr[$i];
        $date = $data[$date_str];
        for ($j = 0; $j < count($rec_arr); $j++) {
            $rec = $rec_arr[$j];
            if (!isset($date[$rec])) {
                $data[$date_str][$rec] = 0;
            }
        }
    }
    return $data;
}

/**
 * fill issuer if not set
 */
function get_full_card_by_date_iss_val($where, $iss_arr) {
    $data = get_card_by_date_iss_val($where);

    $date_arr = array_keys($data);
    $no_date = count($data);

    for ($i = 0; $i < $no_date; $i++) {
        $date_str = $date_arr[$i];
        $date = $data[$date_str];
        for ($j = 0; $j < count($iss_arr); $j++) {
            $iss = $iss_arr[$j];
            if (!isset($date[$iss])) {
                $data[$date_str][$iss] = array();
            }
        }
    }
    return $data;
}

//////////////////////////// recipient, card value -> money


function money_from_rec($recipient) {
    $mean_no = (int) $recipient{1};
    if (preg_match('/^9\d10$/', $recipient)) {
        switch ($mean_no) {
            case 0:
                return 0;
            case 1:
                return 5000;
            case 2:
                return 10000;
            case 3:
                return 15000;
            case 4:
                return 20000;
            case 5:
                return 30000;
            case 6:
                return 40000;
            case 7:
                return 50000;
            default:
                return 0;
        }
    } else {
        switch ($mean_no) {
            case 7:
                return 15000;
            case 6:
                return 10000;
            case 5:
                return 5000;
            case 4:
                return 4000;
            case 3:
                return 3000;
            case 2:
                return 2000;
            case 1:
                return 1000;
            case 0:
                return 500;
            default:
                return 0;
        }
    }
}

function money_from_card($val) {
    return $val;
}

///////////////////

function get_smsmoney_by_date_rec($where, $rec_arr, $ret_number = FALSE) {
    $data = get_full_sms_by_date_rec($where, $rec_arr);

    $date_arr = array_keys($data);
    $no_date = count($data);

    $sum = 0;
    for ($i = 0; $i < $no_date; $i++) {
        $sum_tmp = 0;
        $date_str = $date_arr[$i];
        $date = $data[$date_str];
        for ($j = 0; $j < count($rec_arr); $j++) {
            $rec = $rec_arr[$j];
            $money = money_from_rec($rec) * $date[$rec];
            $data[$date_str][$rec] = $money;
            $sum_tmp += $money;
        }
        // $data[$date_str]['all'] = $sum_tmp;
        $sum += $sum_tmp;
    }
    return $ret_number ? $sum : $data;
}

function get_cardmoney_by_date_iss_val($where, $iss_arr, $ret_number = FALSE) {
    $data = get_full_card_by_date_iss_val($where, $iss_arr);
    $date_arr = array_keys($data);
//    echo '<pre>';
//    print_r($date_arr);
//    echo '</pre>';
//    die;
    $no_date = count($data);

    $sum = 0;
    for ($i = 0; $i < $no_date; $i++) {
        $sum_tmp = 0;
        $date_str = $date_arr[$i];
        $date = $data[$date_str];
        for ($j = 0; $j < count($iss_arr); $j++) {
            $iss_str = $iss_arr[$j];
            $iss = $date[$iss_str];
            $val_keys = array_keys($iss);
            $money = 0;
            for ($k = 0; $k < count($iss); $k++) {
                $val_key = $val_keys[$k];
                $val = $iss[$val_key];
                $money += money_from_card($val_key) * $val;
            }
            $data[$date_str][$iss_str] = $money;
            $sum_tmp += $money;
        }
        $sum += $sum_tmp;
    }
    echo $sum;
    die;
    return $ret_number ? $sum : $data;
}

function get_cardmoney_by_date_cp_val($where, $ret_number = FALSE) {
    $data = get_card_by_date_cp_val($where);

    $date_arr = array_keys($data);
    $no_date = count($data);

    $sum = 0;
    for ($i = 0; $i < $no_date; $i++) {
        $sum_tmp = 0;
        $date_str = $date_arr[$i];
        $date = $data[$date_str];

        $cp_arr = array_keys($date);
        $no_cp = count($date);

        for ($j = 0; $j < $no_cp; $j++) {
            $cp_str = $cp_arr[$j];
            $cp = $date[$cp_str];

            $val_keys = array_keys($cp);
            $money = 0;
            for ($k = 0; $k < count($cp); $k++) {
                $val_key = $val_keys[$k];
                $val = $cp[$val_key];
                $money += money_from_card($val_key) * $val;
            }
            $data[$date_str][$cp_str] = $money;
            $sum_tmp += $money;
        }
        $sum += $sum_tmp;
    }
    return $ret_number ? $sum : $data;
}

///////////////// database queries

function get_sms_by_cha_rec($where, $where2 = "") {
    $arr = array();
    $result = mysql_query("
            select partner, recipient, count(*) as count
            from auth_user_partner
            where $where
            group by partner, recipient
            ");
    while ($row = mysql_fetch_assoc($result)) {
        $channel = format_channel(trim($row['partner']));
        $recipient = $row['recipient'];
        $count = (int) $row['count'];
        $money = money_from_rec($recipient) * $count;
        $arr[] = array($channel, $money);
    }
    $result = mysql_query("
            select channel, recipient, count(*) as count
            from logsms.logsms_mv
            where $where2
            group by channel, recipient
            ");

    while ($row = mysql_fetch_assoc($result)) {
        $channel = format_channel(trim($row['channel']));
        $recipient = $row['recipient'];
        $count = (int) $row['count'];
        $money = money_from_rec($recipient) * $count;
        $arr[] = array($channel, $money);
    }
    return $arr;
}

function get_sms_by_cha_rec2($where, $where2 = '') {
    $arr = array();
    $result = mysql_query("
            select partner, recipient, count(*) as count
            from gim_wap.auth_user_partner
            where $where
            group by partner, recipient
            
            UNION ALL
            select channel, recipient, count(*) as count
            from logsms.logsms_mv
            where $where2
            group by channel, recipient");
    while ($row = mysql_fetch_assoc($result)) {
        $channel = format_channel(trim($row['partner']));
        $recipient = $row['recipient'];
        $count = (int) $row['count'];
        $money = money_from_rec($recipient) * $count;
        $arr[] = array($channel, $money);
    }
    return $arr;
}

function get_card_by_iss_val($where) {
    $arr = array();
    /* $result = mysql_query("
      select issuer, cardvalue, sum(count) as count
      from
      (
      select issuer, cardvalue, count(*) as count
      from vmg_card.request
      where $where
      group by issuer, cardvalue
      UNION
      select issuer, cardvalue, count(*) as count
      from vnpt_card.request
      where $where
      group by issuer, cardvalue
      ) SS
      group by issuer, cardvalue
      "); */
    $result = mysql_query("
            select issuer, cardvalue, count(*) as count
            from vnpt_card.request
            where $where
            group by issuer, cardvalue
            ");
    while ($row = mysql_fetch_assoc($result)) {
        $iss = $row['issuer'];
        $val = $row['cardvalue'];
        $count = (int) $row['count'];
        $money = $val * $count;
        $arr[] = array($iss, $money);
    }
    return $arr;
}

function get_card_by_cp_val($where) {
    global $db2;
    $arr = array();
    $result = mysql_query("
            select cp, cardvalue, count(*) as count
            from vnpt_card.request
            where $where
            group by cp, cardvalue
            ");
    while ($row = mysql_fetch_assoc($result)) {
        $cp = format_channel(trim($row['cp']));
        $val = $row['cardvalue'];
        $count = (int) $row['count'];
        $money = $val * $count;
        $arr[] = array($cp, $money);
    }
    //include('API/db2.class.php');
    //$sql = "select * from ngl_card.request where username='{$username}' and date(created_on)='{$date}'";
    $result = "(select cp, cardvalue, count(*) as count
            from ngl_card.request
            where $where
            group by cp, cardvalue)
            UNION ALL
            (select subcp AS cp, cardvalue, count(*) as count
            from paydirect_card.request
            where $where
            group by cp, cardvalue)
            UNION ALL
            (select subcp AS cp, cardvalue, count(*) as count
            from pay1_card.request
            where $where
            group by cp, cardvalue)
            UNION ALL
            (select subcp AS cp, cardvalue, count(*) as count
            from abc_card.request
            where $where
            group by cp, cardvalue)
            ";
    foreach ($db2->query($result) as $row) {
        $cp = format_channel(trim($row['cp']));
        $val = $row['cardvalue'];
        $count = (int) $row['count'];
        $money = $val * $count;
        $arr[] = array($cp, $money);
    }
    return $arr;
}

//////////////// money

function build_table_stat_sms($where, $where2) {
    $data = get_sms_by_cha_rec($where, $where2);
    // $pnames = get_partner_names();
    $pinfos = get_partners_info();
    $table = array();
    $sum_arr = array();
    foreach ($data as $row) {
        $key = $row[0];
        $money = $row[1];
        if ($key == K2_KEY) { // VMG user
            $tmp_arr = array($money * USER_COM_SHARE_SMS_PARTNER, $money * USER_COM_SHARE_SMS_K2, $money * USER_COM_SHARE_SMS_MV);
        } else {

            // $pname = getv($key, $pnames);
            $pname = $pinfos[$key]['name'];
            $tlsms = $pinfos[$key]['tlsms'];
            $tlcard = $pinfos[$key]['tlcard'];
            if (startsWith($pname, 'K2 - ') OR startsWith($pname, '.EWAY', FALSE)) {
                $tmp_arr = array($money * $tlsms, $money * (1 - $tlsms) * USER_MV_SHARE_SMS_K2, $money * (1 - $tlsms) * USER_MV_SHARE_SMS_MV);
            } else if (startsWith($pname, 'K2 - ')) {
                $tmp_arr = array($money * $tlsms, $money * (1 - $tlsms) * USER_WAP_SHARE_SMS_K2, $money * (1 - $tlsms) * USER_WAP_SHARE_SMS_MV);
            } else {
                $tmp_arr = array($money * USER_COM_SHARE_SMS_PARTNER, $money * USER_COM_SHARE_SMS_K2, $money * USER_COM_SHARE_SMS_MV);
            }
        }
        if (isset($table[$key])) {
            $table[$key] = array_map('array_sum', array_map(null, $table[$key], $tmp_arr));
        } else {
            $table[$key] = $tmp_arr;
        }
        $sum_arr = array_map('array_sum', array_map(null, $sum_arr, $tmp_arr));
    }
    $table['Tổng'] = $sum_arr;
    return $table;
}

function build_table_stat_sms2($where, $where2) {
    $data = get_sms_by_cha_rec2($where, $where2);
    // $pnames = get_partner_names();
    $pinfos = get_partners_info();
    $table = array();
    $sum_arr = array();
    foreach ($data as $row) {
        $key = $row[0];
        $money = $row[1];
        /*
          // if($key == K2_KEY) { // VMG user
          //     $tmp_arr = array($money * USER_COM_SHARE_SMS_PARTNER, $money * USER_COM_SHARE_SMS_K2, $money * USER_COM_SHARE_SMS_MV);
          // } else {

          // $pname = getv($key, $pnames);
          // if(startsWith($pname, 'VMG - ') OR startsWith($pname, '.EWAY', FALSE)) {
          $tmp_arr = array($money * USER_MV_SHARE_SMS_PARTNER, $money * USER_MV_SHARE_SMS_K2, $money * USER_MV_SHARE_SMS_MV);
          // } else {
          //     $tmp_arr = array($money * USER_WAP_SHARE_SMS_PARTNER, $money * USER_WAP_SHARE_SMS_K2, $money * USER_WAP_SHARE_SMS_MV);
          // }
          // }
         */

        $pname = $pinfos[$key]['name'];
        $tlsms = $pinfos[$key]['tlsms'];
        $tlcard = $pinfos[$key]['tlcard'];
        if ($pname) {
            $tmp_arr = array($money * $tlsms, $money * (1 - $tlsms) * USER_MV_SHARE_SMS_K2, $money * (1 - $tlsms) * USER_MV_SHARE_SMS_MV);
        } else {
            $tmp_arr = array($money * USER_COM_SHARE_SMS_PARTNER, $money * USER_COM_SHARE_SMS_K2, $money * USER_COM_SHARE_SMS_MV);
        }

        if (isset($table[$key])) {
            $table[$key] = array_map('array_sum', array_map(null, $table[$key], $tmp_arr));
        } else {
            $table[$key] = $tmp_arr;
        }
        $sum_arr = array_map('array_sum', array_map(null, $sum_arr, $tmp_arr));
    }
    $table['Tổng'] = $sum_arr;
    return $table;
}

function build_table_stat_card($where) {
    $data = get_card_by_iss_val($where);
    // $pnames = get_partner_names();
    $pinfos = get_partners_info();
    $table = array();
    $sum_arr = array();
    foreach ($data as $row) {
        $key = $row[0];
        $money = $row[1];

        // $pname = getv($key, $pnames);
        $pname = $pinfos[$key]['name'];
        $tlsms = $pinfos[$key]['tlsms'];
        $tlcard = $pinfos[$key]['tlcard'];
        if (startsWith($pname, 'K2 - ') OR startsWith($pname, '.EWAY', FALSE)) {
            $tmp_arr = array($money * $tlcard, $money * (1 - $tlcard) * USER_MV_SHARE_CARD_K2, $money * (1 - $tlcard) * USER_MV_SHARE_CARD_MV);
        } else if (startsWith($pname, 'K2 - ')) {
            $tmp_arr = array($money * $tlcard, $money * (1 - $tlcard) * USER_WAP_SHARE_CARD_K2, $money * (1 - $tlcard) * USER_WAP_SHARE_CARD_MV);
        } else {
            $tmp_arr = array($money * USER_COM_SHARE_CARD_PARTNER, $money * USER_COM_SHARE_CARD_K2, $money * USER_COM_SHARE_CARD_MV);
        }

        if (isset($table[$key])) {
            $table[$key] = array_map('array_sum', array_map(null, $table[$key], $tmp_arr));
        } else {
            $table[$key] = $tmp_arr;
        }
        $sum_arr = array_map('array_sum', array_map(null, $sum_arr, $tmp_arr));
    }
    $table['Tổng'] = $sum_arr;
    return $table;
}

function build_table_stat_card_cp($where) {
    $data = get_card_by_cp_val($where);
    // $pnames = get_partner_names(); // get_mv_partner_names(); // VMG only
    $pinfos = get_partners_info();
    $table = array();
    $sum_arr = array();
    foreach ($data as $row) {
        $key = $row[0];
        $money = $row[1];

        // $pname = getv($key, $pnames);
        $pname = $pinfos[$key]['name'];
        $tlsms = $pinfos[$key]['tlsms'];
        $tlcard = $pinfos[$key]['tlcard'];
        if (($key == K2_KEY) OR startsWith($pname, 'K2 - ') OR startsWith($pname, '.EWAY', FALSE)) {
            $tmp_arr = array($money * $tlcard, $money * (1 - $tlcard) * USER_MV_SHARE_CARD_K2, $money * (1 - $tlcard) * USER_MV_SHARE_CARD_MV);
        } else if (startsWith($pname, 'K2 - ')) {
            $tmp_arr = array($money * $tlcard, $money * (1 - $tlcard) * USER_WAP_SHARE_CARD_K2, $money * (1 - $tlcard) * USER_WAP_SHARE_CARD_MV);
        } else {
            $tmp_arr = array($money * USER_COM_SHARE_CARD_PARTNER, $money * USER_COM_SHARE_CARD_K2, $money * USER_COM_SHARE_CARD_MV);
        }

        if (isset($table[$key])) {
            $table[$key] = array_map('array_sum', array_map(null, $table[$key], $tmp_arr));
        } else {
            $table[$key] = $tmp_arr;
        }
        $sum_arr = array_map('array_sum', array_map(null, $sum_arr, $tmp_arr));
    }
    $table['Tổng'] = $sum_arr;
    return $table;
}

/////////////////////////////////////

function format_money($number) {
    return number_format($number, 0, ',', ' ');
}

/////////////////// channel => partner name

function get_k2_partner_names() {
    /*
      include 'connectdb_altp.php';
      $result = mysql_query("
      select chanel, userDT
      from syntax
      ");
      $ret = array();
      while($row = mysql_fetch_array($result, MYSQL_NUM)) {
      $channel = format_channel(strtoupper(trim($row[0])));
      $pname = $row[1];
      $ret[$channel] = "K2 - $pname";
      }
      return $ret;
     */
    $ret = array();
    $ret[format_channel('CP10')] = "K2 - NAP9";
    return $ret;
}

function get_mv_partner_names() {
    include 'connectdb_bemecp.php';
    $result = mysql_query("
            select code, username
            from bm_partner
            ");
    $ret = array();
    while ($row = mysql_fetch_array($result, MYSQL_NUM)) {
        $channel = format_channel(strtoupper(trim($row[0])));
        $pname = $row[1];
        $ret[$channel] = "K2 - $pname";
    }
    return $ret;
}

function get_partner_names() {
    return array_merge(
            get_mv_partner_names(), get_k2_partner_names()
    );
}

//////////////////// channel => partner name, tlsms, tlcard

function get_k2_partners_info() {
    /*
      include 'connectdb_altp.php';
      $result = mysql_query("select chanel, userDT from syntax");
      $ret = array();
      while($row = mysql_fetch_array($result, MYSQL_NUM)) {
      $channel = format_channel(strtoupper(trim($row[0])));
      $pname = $row[1];
      $ret[$channel] = array('name'=>"K2 - $pname",
      'tlsms'=>USER_WAP_SHARE_SMS_PARTNER,
      'tlcard'=>USER_WAP_SHARE_CARD_PARTNER);
      }
      return $ret;
     */
    $ret = array();
    $ret[format_channel('CP10')] = array('name' => 'K2 - NAP9',
        'tlsms' => USER_WAP_SHARE_SMS_PARTNER,
        'tlcard' => USER_WAP_SHARE_CARD_PARTNER,);
    return $ret;
}

function get_mv_partners_info() {
    include 'connectdb_bemecp.php';
    $result = mysql_query("select code, username, tyle_sms, tyle_card from bm_partner");
    $ret = array();
    while ($row = mysql_fetch_array($result, MYSQL_NUM)) {
        $channel = format_channel(strtoupper(trim($row[0])));
        $pname = $row[1];
        $tlsms = (int) $row[2];
        $tlcard = (int) $row[3];
        $ret[$channel] = array('name' => "K2 - $pname",
            'tlsms' => USER_MV_SHARE_SMS_PARTNER/* $tlsms / 100. */,
            'tlcard' => USER_MV_SHARE_CARD_PARTNER/* $tlcard / 100. */,);
    }
    return $ret;
}

function get_partners_info() {
    return array_merge(
            get_mv_partners_info(), get_k2_partners_info());
}

////////////

function getv($key, $arr) {
    $keyu = strtoupper($key);
    if (isset($arr[$keyu]))
        return $arr[$keyu];
    else
        return '.' . $key; // from nowhere
}

function format_channel($channel) {
    if (in_array(strtoupper($channel), array(SYNTAX_PREFIX, K2_CARD_CP))) {
        return K2_KEY; // VMG
    } else {
        return strtoupper(preg_replace('/^' . SYNTAX_PREFIX . '/i', '', $channel)); // partner
    }
}

///////////////////

function startsWith($haystack, $needle, $case = true) {
    if ($case) {
        return (strcmp(substr($haystack, 0, strlen($needle)), $needle) === 0);
    }
    return (strcasecmp(substr($haystack, 0, strlen($needle)), $needle) === 0);
}

function endsWith($haystack, $needle, $case = true) {
    if ($case) {
        return (strcmp(substr($haystack, strlen($haystack) - strlen($needle)), $needle) === 0);
    }
    return (strcasecmp(substr($haystack, strlen($haystack) - strlen($needle)), $needle) === 0);
}

//////////////////////////////////////
// count upon date range


function get_sum_sms_by_rec($where, $money = FALSE) {
    $arr = array();
    $result = mysql_query("
            select recipient, count(*) as count
            from auth_user_partner
            where $where
            group by recipient
            ");
    while ($row = mysql_fetch_assoc($result)) {
        $recipient = $row['recipient'];
        $count = $row['count'];
        $arr[$recipient] = $money ? $count * money_from_rec($recipient) : $count;
    }
    $result = mysql_query("
            select channel, recipient, count(*) as count
            from logsms.logsms_mv
            where $where2
            group by channel, recipient
            ");

    while ($row = mysql_fetch_assoc($result)) {
        $channel = format_channel(trim($row['channel']));
        $recipient = $row['recipient'];
        $count = (int) $row['count'];
        $money = money_from_rec($recipient) * $count;
        $arr[] = array($channel, $money);
    }
    return $arr;
}

function get_sum_card_by_iss_val($where, $money = FALSE) {
    $arr = array();
    $result = mysql_query("
                select issuer, cardvalue, count(*) as count
                from vnpt_card.request
                where $where
                group by issuer, cardvalue
                ");
    echo $result;
    die;
    while ($row = mysql_fetch_assoc($result)) {
        $iss = $row['issuer'];
        $val = $row['cardvalue'];
        $count = $row['count'];
        if ($money) {
            $sum_val = $count * money_from_card($val);
            if (isset($arr[$iss])) {
                $arr[$iss] += $sum_val;
            } else {
                $arr[$iss] = $sum_val;
            }
        } else
            $arr[$iss][$val] = $count;
    }
    return $arr;
}
