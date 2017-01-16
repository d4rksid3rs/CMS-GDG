<?php
require('API/db.class.php');

$sql_setting = "SELECT * FROM config WHERE `key` = 'config_server'";
foreach ($db->query($sql_setting) as $row) {
    $json_settings = json_decode($row['value'], true);
}
$xu_dk = 15000;
$xu_bonus = $json_settings['bonus_koin']['koin'];
//fee
$sql_fee = "SELECT * FROM config WHERE `key` LIKE 'ngame_%'";
$json_fee = array();
foreach ($db->query($sql_fee) as $row) {
    if (in_array($row['key'], array('ngame_caro', 'ngame_luotvan', 'ngame_nhaycot', 'ngame_quay', 'ngame_trieuphu', 'ngame_name', 'ngame_tienlenmb')))
        continue;
    $key = substr($row['key'], 6);
    switch ($key) {
        case "bacay";
            $key = "Ba cây";
            break;
        case "bacaychuong";
            $key = "Ba cây chương";
            break;
        case "bing";
            $key = "Mậu binh";
            break;
        case "lieng";
            $key = "Liêng";
            break;
        case "phom";
            $key = "Phỏm";
            break;
        case "poker";
            $key = "Poker";
            break;
        case "sam";
            $key = "Sâm";
            break;
        case "tienlenmn";
            $key = "Tiến lên miền nam";
            break;
        case "tienlenmndc";
            $key = "Tiến lên miền nam đếm cây";
            break;
    }
    $json_fee[$key] = json_decode($row['value'], true);
}

//$card_types = array(500000, 300000, 200000, 100000, 50000, 30000, 20000, 10000);
$card_types = array(10000, 20000, 30000, 50000, 60000, 100000, 200000, 300000, 5000000, 1000000, 2000000);
$iap_types = array(21386, 42989, 107798, 215813, 539857, 1079930, 2160077);
$no_cards = count($card_types);
$no_iaps = count($iap_types);

$ratio_presets = array();
for ($i = 0; $i < $no_cards; $i++) {
    $ratio_presets[] = 1;
}
$iap_ratio_presets = array();
for ($i = 0; $i < $no_iaps; $i++) {
    $iap_ratio_presets[] = 1;
}

// sms
$from_date = isset($_REQUEST['from_date']) ? trim($_REQUEST['from_date']) : '2016-06-20';
$from_time = !empty($_REQUEST['from_time']) ? trim($_REQUEST['from_time']) : '00:00:00';
$to_date = isset($_REQUEST['to_date']) ? trim($_REQUEST['to_date']) : '2016-06-20';
$to_time = !empty($_REQUEST['to_time']) ? trim($_REQUEST['to_time']) : '23:59:59';
$factor = isset($_REQUEST['factor']) ? (float) ($_REQUEST['factor']) : 1.0;
// card 1
$from_date2 = isset($_REQUEST['from_date2']) ? trim($_REQUEST['from_date2']) : '2016-06-20';
$from_time2 = !empty($_REQUEST['from_time2']) ? trim($_REQUEST['from_time2']) : '00:00:00';
$to_date2 = isset($_REQUEST['to_date2']) ? trim($_REQUEST['to_date2']) : '2016-06-20';
$to_time2 = !empty($_REQUEST['to_time2']) ? trim($_REQUEST['to_time2']) : '23:59:59';
$factor2 = array();
for ($i = 0; $i < $no_cards; $i++) {
    $factor2[] = isset($_REQUEST['factor2'][$i]) ? (float) ($_REQUEST['factor2'][$i]) : 1.0;
}
// card 2
$from_date3 = isset($_REQUEST['from_date3']) ? trim($_REQUEST['from_date3']) : '2016-06-20';
$from_time3 = !empty($_REQUEST['from_time3']) ? trim($_REQUEST['from_time3']) : '00:00:00';
$to_date3 = isset($_REQUEST['to_date3']) ? trim($_REQUEST['to_date3']) : '2016-06-20';
$to_time3 = !empty($_REQUEST['to_time3']) ? trim($_REQUEST['to_time3']) : '23:59:59';
$factor3 = array();
for ($i = 0; $i < $no_cards; $i++) {
    $factor3[] = isset($_REQUEST['factor3'][$i]) ? (float) ($_REQUEST['factor3'][$i]) : 1.0;
}
// iap 1
$from_date4 = isset($_REQUEST['from_date4']) ? trim($_REQUEST['from_date4']) : '2016-06-20';
$from_time4 = !empty($_REQUEST['from_time4']) ? trim($_REQUEST['from_time4']) : '00:00:00';
$to_date4 = isset($_REQUEST['to_date4']) ? trim($_REQUEST['to_date4']) : '2016-06-20';
$to_time4 = !empty($_REQUEST['to_time4']) ? trim($_REQUEST['to_time4']) : '23:59:59';
$factor4 = array();
for ($i = 0; $i < $no_cards; $i++) {
    $factor4[] = isset($_REQUEST['factor4'][$i]) ? (float) ($_REQUEST['factor4'][$i]) : 1.0;
}
// iap 2
$from_date5 = isset($_REQUEST['from_date5']) ? trim($_REQUEST['from_date5']) : '2016-06-20';
$from_time5 = !empty($_REQUEST['from_time5']) ? trim($_REQUEST['from_time5']) : '00:00:00';
$to_date5 = isset($_REQUEST['to_date5']) ? trim($_REQUEST['to_date5']) : '2016-06-20';
$to_time5 = !empty($_REQUEST['to_time5']) ? trim($_REQUEST['to_time5']) : '23:59:59';
$factor5 = array();
for ($i = 0; $i < $no_cards; $i++) {
    $factor5[] = isset($_REQUEST['factor5'][$i]) ? (float) ($_REQUEST['factor5'][$i]) : 1.0;
}
// chip
$from_date6 = isset($_REQUEST['from_date6']) ? trim($_REQUEST['from_date6']) : '2016-06-20';
$from_time6 = !empty($_REQUEST['from_time6']) ? trim($_REQUEST['from_time6']) : '00:00:00';
$to_date6 = isset($_REQUEST['to_date6']) ? trim($_REQUEST['to_date6']) : '2016-06-20';
$to_time6 = !empty($_REQUEST['to_time6']) ? trim($_REQUEST['to_time6']) : '23:59:59';
$factor6 = array();
for ($i = 0; $i < $no_cards; $i++) {
    $factor6[] = isset($_REQUEST['factor6'][$i]) ? (float) ($_REQUEST['factor6'][$i]) : 1.0;
}
include 'connectdb_gimwap.php';

// SET
//if (
//        (!empty($from_date) AND ! empty($to_date))
//        OR ( !empty($from_date2) AND ! empty($to_date2))
//        OR ( !empty($from_date3) AND ! empty($to_date3))
//        OR ( !empty($from_date4) AND ! empty($to_date4))
//        OR ( !empty($from_date5) AND ! empty($to_date5))
//) {
// check method POST vào
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $arr = array();
    $arr['sms']['from_date'] = "$from_date $from_time";
    $arr['sms']['to_date'] = "$to_date $to_time";
    $arr['sms']['factor'] = $factor;
    $arr['card']['from_date'] = "$from_date2 $from_time2";
    $arr['card']['to_date'] = "$to_date2 $to_time2";
    $arr['card']['factor'] = $factor2;
    $arr['card2']['from_date'] = "$from_date3 $from_time3";
    $arr['card2']['to_date'] = "$to_date3 $to_time3";
    $arr['card2']['factor'] = $factor3;
    $arr['iap']['from_date'] = "$from_date4 $from_time4";
    $arr['iap']['to_date'] = "$to_date4 $to_time4";
    $arr['iap']['factor'] = $factor4;
    $arr['iap2']['from_date'] = "$from_date5 $from_time5";
    $arr['iap2']['to_date'] = "$to_date5 $to_time5";
    $arr['iap2']['factor'] = $factor5;
    $arr['cardvip']['from_date'] = "$from_date6 $from_time6";
    $arr['cardvip']['to_date'] = "$to_date6 $to_time6";
    $arr['cardvip']['factor'] = $factor6;
//    var_dump($arr);die;
    $json = json_encode($arr);

    $sql = sprintf("update config set value = '%s' where `key` = 'special_offer_koin_v3'", $json);
    $result = mysql_query($sql);
    echo 'xxx';
}

//    var_dump($arr);die;
//}
//var_dump($arr);
//die;
// GET
$init = TRUE;
$sql = "select value from config where `key` = 'special_offer_koin_v3' limit 1";
$result = mysql_query($sql);
if ($row = mysql_fetch_assoc($result)) {
//    var_dump($row);die;
    $value = $row['value'];
    if (!empty($value)) {
        $init = FALSE;
        // sms
        $arr = json_decode($value, TRUE);
        $from_date = !empty($arr['sms']['from_date']) ? $arr['sms']['from_date'] : '2016-06-20';
        $arr1 = explode(' ', $from_date);
        $from_date = $arr1[0];
        $from_time = $arr1[1];
        $to_date = !empty($arr['sms']['to_date']) ? $arr['sms']['to_date'] : '2016-06-20';
        $arr1 = explode(' ', $to_date);
        $to_date = $arr1[0];
        $to_time = $arr1[1];
        $factor = !empty($arr['sms']['factor']) ? $arr['sms']['factor'] : 1.0;
        // card 1
        $from_date2 = !empty($arr['card']['from_date']) ? $arr['card']['from_date'] : '2016-06-20';
        $arr1 = explode(' ', $from_date2);
        $from_date2 = $arr1[0];
        $from_time2 = $arr1[1];
        $to_date2 = !empty($arr['card']['to_date']) ? $arr['card']['to_date'] : '2016-06-20';
        $arr1 = explode(' ', $to_date2);
        $to_date2 = $arr1[0];
        $to_time2 = $arr1[1];
        $factor2 = !empty($arr['card']['factor']) ? $arr['card']['factor'] : $ratio_presets;
        // card 2
        $from_date3 = !empty($arr['card2']['from_date']) ? $arr['card2']['from_date'] : '2016-06-20';
        $arr1 = explode(' ', $from_date3);
        $from_date3 = $arr1[0];
        $from_time3 = $arr1[1];
        $to_date3 = !empty($arr['card2']['to_date']) ? $arr['card2']['to_date'] : '2016-06-20';
        $arr1 = explode(' ', $to_date3);
        $to_date3 = $arr1[0];
        $to_time3 = $arr1[1];
        $factor3 = !empty($arr['card2']['factor']) ? $arr['card2']['factor'] : $ratio_presets;
        // iap
        $from_date4 = !empty($arr['iap']['from_date']) ? $arr['iap']['from_date'] : '2016-06-20';
        $arr1 = explode(' ', $from_date4);
        $from_date4 = $arr1[0];
        $from_time4 = $arr1[1];
        $to_date4 = !empty($arr['iap']['to_date']) ? $arr['iap']['to_date'] : '2016-06-20';
        $arr1 = explode(' ', $to_date4);
        $to_date4 = $arr1[0];
        $to_time4 = $arr1[1];
        $factor4 = !empty($arr['iap']['factor']) ? $arr['iap']['factor'] : $ratio_presets;
        // iap 2
        $from_date5 = !empty($arr['iap2']['from_date']) ? $arr['iap2']['from_date'] : '2016-06-20';
        $arr1 = explode(' ', $from_date5);
        $from_date5 = $arr1[0];
        $from_time5 = $arr1[1];
        $to_date5 = !empty($arr['iap2']['to_date']) ? $arr['iap2']['to_date'] : '2016-06-20';
        $arr1 = explode(' ', $to_date5);
        $to_date5 = $arr1[0];
        $to_time5 = $arr1[1];
        $factor5 = !empty($arr['iap2']['factor']) ? $arr['iap2']['factor'] : $ratio_presets;
        // chip
        $from_date6 = !empty($arr['cardvip']['from_date']) ? $arr['cardvip']['from_date'] : '2016-06-20';
        $arr1 = explode(' ', $from_date6);
        $from_date6 = $arr1[0];
        $from_time6 = $arr1[1];
        $to_date6 = !empty($arr['cardvip']['to_date']) ? $arr['cardvip']['to_date'] : '2016-06-20';
        $arr1 = explode(' ', $to_date6);
        $to_date6 = $arr1[0];
        $to_time6 = $arr1[1];
        $factor6 = !empty($arr['cardvip']['factor']) ? $arr['cardvip']['factor'] : $ratio_presets;
    }
}
if ($init) {
    $from_date = $to_date = $from_date2 = $to_date2 = $from_date3 = $to_date3 = $from_date4 = $to_date4 = $from_date5 = $to_date5 = $from_date6 = $to_date6 = '';
    $from_time = $from_time2 = $from_time3 = $from_time4 = $from_time5 = $from_time6 = '00:00:00';
    $to_time = $to_time2 = $to_time3 = $to_time4 = $to_time5 = $to_time6 = '23:59:59';
    $factor = 1.0;
    $factor2 = $factor3 = $factor6 = $ratio_presets;
    $factor4 = $factor5 = $iap_ratio_presets;
}

// GET event message
$sql = "select * from system_message";
$msg = array();

foreach ($db->query($sql) as $row) {
    $cp = explode(",", $row['not_cp']);
    $gsm = 0;
    //echo "abc: ". $gsm;//."<br/>".$cp14."<br/>".$cp16;

    foreach ($cp as $c) {
        if ($c == "gsm")
            $gsm = 1;
    }
    //echo "def: ". $gsm;//."<br/>".$cp14."<br/>".$cp16;
    $msg[] = array('id' => $row['id'],
        'content' => $row['content'],
        'dateBegin' => $row['date_begin'],
        'dateEnd' => $row['date_end'],
        'gsm' => $gsm,
        'os_type' => $row['os_type'],
    );
}

// GET block word
// GET event message
$sql = "select c.* from config c where c.key='config_chatmessage'";
foreach ($db->query($sql) as $row) {
    $blockWord = str_replace("\"", "", $row['value']);
    $blockWord = substr($blockWord, 1);
    $blockWord = substr($blockWord, 0, strlen($blockWord) - 1);
    //str_replace("]","",str_replace("[","",)));
    break;
}

$sql = "select c.* from config c where c.key='config_server'";
foreach ($db->query($sql) as $row) {
    $key = $row['value'];
    break;
}
$value = json_decode($row['value']);
$new = new stdClass();
foreach ($value as $k => $v) {
    if ($k == "shutdownMessage")
        $s = $v;
    if ($k == "isDisplayPopupVMS") {
        $gamevms = $v;
    }
}
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Settings</title>
        <?php require('header.php'); ?>
        <script>
            $(document).ready(function () {
                $("#datepicker1").datepicker(); // sms
                $("#datepicker2").datepicker(); // sms
                $("#datepicker3").datepicker();
                $("#datepicker4").datepicker();
                $("#datepicker5").datepicker(); // card 1
                $("#datepicker6").datepicker(); // card 1
                $("#datepicker7").datepicker(); // card 2
                $("#datepicker8").datepicker(); // card 2
                $("#datepicker9").datepicker(); // iap 1
                $("#datepicker10").datepicker(); // iap 1
                $("#datepicker11").datepicker(); // iap 2
                $("#datepicker12").datepicker(); // iap 2
                $('.datepicker').datepicker();
            });

            function deleteMessage(id) {
                $.ajax({
                    type: "POST",
                    url: "API/eventMessage.php",
                    data: {
                        "type": "delete",
                        "id": id
                    },
                    dataType: 'text',
                    success: function (msg) {
                        msg = msg.trim();
                        if (msg != '' && msg.length > 2) {
                            var data = jQuery.parseJSON(msg);
                            if (data.status == 1) {
                                alert(data.message);
                            } else {
                                alert(data.message);
                            }
                        } else {
                            alert("Lỗi hệ thống");
                        }
                    },
                    failure: function () {
                        alert("Kiểm tra lại kết nối mạng")
                    }
                });
            }

            function addMessage() {
                var title = $("input[id=msgTitle]").val();
                var content = $("textarea[id=msgContent]").val();
                var dateBegin = $("input[id=datepicker3]").val();
                var dateEnd = $("input[id=datepicker4]").val();
                var GSM = $("select[id=gsmselect]").val();
                var VMS = $("select[id=vmsselect]").val();
                var VMGS = $("select[id=vmgsselect]").val();
                var CP14 = $("select[id=cp14select]").val();
                var CP16 = $("select[id=cp16select]").val();
                var os_type = $("select[id=os_type]").val();
                var from_time = $("input[id=from_time_mess]").val();
                var to_time = $("input[id=to_time_mess]").val();
                $.ajax({
                    type: "POST",
                    url: "API/eventMessage.php",
                    data: {
                        "title": title,
                        "content": content,
                        "dateBegin": dateBegin,
                        "dateEnd": dateEnd,
                        "from_time": from_time,
                        "to_time": to_time,
                        "gsm": GSM,
                        "vms": VMS,
                        "vmgs": VMGS,
                        "cp14": CP14,
                        "cp16": CP16,
                        "os_type": os_type,
                        "type": "add"
                    },
                    dataType: 'text',
                    success: function (msg) {
                        msg = msg.trim();
                        if (msg != '' && msg.length > 2) {
                            var data = jQuery.parseJSON(msg);
                            alert(data.message);
                        } else {
                            alert("Lỗi hệ thống");
                        }
                    },
                    failure: function () {
                        alert("Kiểm tra lại kết nối mạng")
                    }
                });
            }

            function saveEditedMessage() {
                var title = $("#editEvent input[id=msgTitle]").val();
                var msgid = $("#editEvent input[id=msgID]").val();
                var content = $("#editEvent textarea[id=msgContent]").val();
                var dateBegin = $("#editEvent input[id=editdatepicker3]").val();
                var dateEnd = $("#editEvent input[id=editdatepicker4]").val();
                var GSM = $("#editEvent select[id=gsmselect]").val();
                var VMS = $("#editEvent select[id=vmsselect]").val();
                var VMGS = $("#editEvent select[id=vmgsselect]").val();
                var CP14 = $("#editEvent select[id=cp14select]").val();
                var CP16 = $("#editEvent select[id=cp16select]").val();
                var os_type = $("#editEvent select[id=os_type]").val();
                $.ajax({
                    type: "POST",
                    url: "API/eventMessage.php",
                    data: {
                        "id": msgid,
                        "title": title,
                        "content": content,
                        "dateBegin": dateBegin,
                        "dateEnd": dateEnd,
                        "gsm": GSM,
                        "vms": VMS,
                        "vmgs": VMGS,
                        "cp14": CP14,
                        "cp16": CP16,
                        "os_type": os_type,
                        "type": "update"
                    },
                    dataType: 'text',
                    success: function (msg) {
                        msg = msg.trim();
                        if (msg != '' && msg.length > 2) {
                            var data = jQuery.parseJSON(msg);
                            alert(data.message);
                            $("#editEvent #msgID").val("");
                            $("#editEvent #msgTitle").val("");
                            $("#editEvent #msgContent").val("");
                            $("#editEvent #datepicker3").datepicker();
                            $("#editEvent #datepicker4").datepicker();
                            $("#editEvent").css('display', 'none');
                        } else {
                            alert("Lỗi hệ thống");
                        }
                    },
                    failure: function () {
                        alert("Kiểm tra lại kết nối mạng")
                    }
                });
            }

            function configFullgame() {
                var VMS = $("select[id=gamevms]").val();
                $.ajax({
                    type: "POST",
                    url: "API/editconfigvms.php",
                    data: {
                        "vms": VMS
                    },
                    dataType: 'text',
                    success: function (msg) {
                        msg = msg.trim();
                        if (msg != '' && msg.length > 2) {
                            var data = jQuery.parseJSON(msg);
                            if (data.status == 1) {
                                alert(data.message);
                            } else {
                                alert(data.message);
                            }
                        } else {
                            alert("Lỗi hệ thống");
                        }
                    },
                    failure: function () {
                        alert("Kiểm tra lại kết nối mạng")
                    }
                });
            }

            function saveBlockWord() {
                var content = $("textarea[id=blockContent]").val();
                $.ajax({
                    type: "POST",
                    url: "API/blockWord.php",
                    data: {
                        "content": content
                    },
                    dataType: 'text',
                    success: function (msg) {
                        msg = msg.trim();
                        if (msg != '' && msg.length > 2) {
                            var data = jQuery.parseJSON(msg);
                            if (data.status == 1) {
                                alert(data.message);
                            } else {
                                alert(data.message);
                            }
                        } else {
                            alert("Lỗi hệ thống");
                        }
                    },
                    failure: function () {
                        alert("Kiểm tra lại kết nối mạng")
                    }
                });
            }

            function saveConfigPayment() {
                if (confirm('Are you sure?')) {
                    var viettel = 0;
                    var vina = 0;
                    var mobi = 0;
                    var sms = $("#paymentSMS").val();
                    $("input:checkbox[name=paymentCard]:checked").each(function ()
                    {
                        if ($(this).val() == 'viettel')
                            viettel = 1;
                        if ($(this).val() == 'vina')
                            vina = 1;
                        if ($(this).val() == 'mobi')
                            mobi = 1;
                    });
                    $.ajax({
                        type: "POST",
                        url: "API/configPayment.php",
                        data: {
                            "viettel": viettel,
                            "vina": vina,
                            "mobi": mobi,
                            "sms": sms
                        },
                        dataType: 'text',
                        success: function (msg) {
                            msg = msg.trim();
                            if (msg != '' && msg.length > 2) {
                                var data = jQuery.parseJSON(msg);
                                alert(data.message);
                            } else {
                                alert("Lỗi hệ thống");
                            }
                        },
                        failure: function () {
                            alert("Kiểm tra lại kết nối mạng")
                        }
                    });
                }
            }
            function editMessage(json) {
                //alert(json.id);
                $("#editEvent #editdatepicker3").datepicker();
                $("#editEvent #editdatepicker4").datepicker();
                var str = json.content;
                var res = str.split("@@@");
                var strSDate = json.dateBegin;
                var resSDate = strSDate.split(" ");
                var strEDate = json.dateEnd;
                var resEDate = strEDate.split(" ");
                $("#editEvent #msgID").val(json.id);
                $("#editEvent #msgTitle").val(res[0]);
                $("#editEvent #msgContent").val(res[1]);

                $("#editEvent #editdatepicker3").datepicker('setDate', resSDate[0]);
                $("#editEvent #editdatepicker4").datepicker('setDate', resEDate[0]);

                $('#editEvent #gsmselect option:eq(' + json.gsm + ')').attr('selected', 'selected');
                $('#selectBox #gsmselect option:eq(' + json.os_type + ')').attr('selected', 'selected');
                $("#editEvent").css('display', 'block');
                $('html, body').animate({
                    scrollTop: $("#editEvent").offset().top
                }, 500);
            }
        </script>
    </head>
    <body>
        <div class="pagewrap">
            <?php require('topMenu.php'); ?>

            <div class="box grid">
                <div class="box_header"><a href="javascript:void(0);">Xu/Chip Special Offers</a></div>
                <div class="box_body">
                    <div style="padding-left:10px;">
                        <form action="" method="post">
                            <b>Xu (SMS) </b><br>
                            Từ ngày
                            <input type="text" id="datepicker1" name="from_date" style="text-align: center; width: 100px;" value="<?php echo $from_date; ?>"/>
                            <input type="text" id="" name="from_time" style="width: 60px;" value="<?php echo $from_time; ?>"/>
                            Tới ngày
                            <input type="text" id="datepicker2" name="to_date" style="text-align: center; width: 100px;" value="<?php echo $to_date; ?>"/> 
                            <input type="text" id="" name="to_time" style="width: 60px;" value="<?php echo $to_time; ?>"/>
                            <br>
                            Hệ số nhân
                            <input type="text" id="factor" name="factor" style="text-align: right; width: 40px;" value="<?php echo $factor; ?>"/> 
                            <hr>
                            <b>Xu (CARD) (Khoảng thời gian 1) </b><br>
                            Từ ngày
                            <input type="text" id="datepicker5" name="from_date2" style="text-align: center; width: 100px;" value="<?php echo $from_date2; ?>"/> 
                            <input type="text" id="" name="from_time2" style="width: 60px;" value="<?php echo $from_time2; ?>"/>
                            Tới ngày
                            <input type="text" id="datepicker6" name="to_date2" style="text-align: center; width: 100px;" value="<?php echo $to_date2; ?>"/> 
                            <input type="text" id="" name="to_time2" style="width: 60px;" value="<?php echo $to_time2; ?>"/>
                            <br>
                            Hệ số nhân
                            <br>
                            <?php
                            foreach ($card_types as $key => $item) {
                                echo $item . " <input type='text' id='factor2[]' name='factor2[]' style='text-align: right; width: 40px;' value='" . $factor2[$key] . "' /> ";
                            }
                            ?>
                            <br>
                            <b>Xu (CARD) (Khoảng thời gian 2) </b><br>
                            Từ ngày
                            <input type="text" id="datepicker7" name="from_date3" style="text-align: center; width: 100px;" value="<?php echo $from_date3; ?>"/> 
                            <input type="text" id="" name="from_time3" style="width: 60px;" value="<?php echo $from_time3; ?>"/>
                            Tới ngày
                            <input type="text" id="datepicker8" name="to_date3" style="text-align: center; width: 100px;" value="<?php echo $to_date3; ?>"/> 
                            <input type="text" id="" name="to_time3" style="width: 60px;" value="<?php echo $to_time3; ?>"/>
                            <br>
                            Hệ số nhân
                            <br>
                            <?php
                            foreach ($card_types as $key => $item) {
                                echo $item . " <input type='text' id='factor3[]' name='factor3[]' style='text-align: right; width: 40px;' value='" . $factor3[$key] . "' /> ";
                            }
                            ?>
                            <hr>
                            <b>IAP (Khoảng thời gian 1) </b><br>
                            Từ ngày
                            <input type="text" id="datepicker9" name="from_date4" style="text-align: center; width: 100px;" value="<?php echo $from_date4; ?>"/> 
                            <input type="text" id="" name="from_time4" style="width: 60px;" value="<?php echo $from_time4; ?>"/>
                            Tới ngày
                            <input type="text" id="datepicker10" name="to_date4" style="text-align: center; width: 100px;" value="<?php echo $to_date4; ?>"/> 
                            <input type="text" id="" name="to_time4" style="width: 60px;" value="<?php echo $to_time4; ?>"/>
                            <br>
                            Hệ số nhân
                            <br>
                            <?php
                            foreach ($iap_types as $key => $item) {
                                echo $item . " <input type='text' id='factor4[]' name='factor4[]' style='text-align: right; width: 40px;' value='" . $factor4[$key] . "' /> ";
                            }
                            ?>
                            <br />
                            <b>IAP (Khoảng thời gian 2) </b><br>
                            Từ ngày
                            <input type="text" id="datepicker11" name="from_date5" style="text-align: center; width: 100px;" value="<?php echo $from_date5; ?>"/> 
                            <input type="text" id="" name="from_time5" style="width: 60px;" value="<?php echo $from_time5; ?>"/>
                            Tới ngày
                            <input type="text" id="datepicker12" name="to_date5" style="text-align: center; width: 100px;" value="<?php echo $to_date5; ?>"/> 
                            <input type="text" id="" name="to_time5" style="width: 60px;" value="<?php echo $to_time5; ?>"/>
                            <br>
                            Hệ số nhân
                            <br>
                            <?php
                            foreach ($iap_types as $key => $item) {
                                echo $item . " <input type='text' id='factor5[]' name='factor5[]' style='text-align: right; width: 40px;' value='" . $factor5[$key] . "' /> ";
                            }
                            ?>
                            <br />
                            <hr />
                            <b>Chip (CARD)  </b><br>
                            Từ ngày
                            <input type="text" class="datepicker" name="from_date6" style="text-align: center; width: 100px;" value="<?php echo $from_date6; ?>"/> 
                            <input type="text" id="" name="from_time6" style="width: 60px;" value="<?php echo $from_time6; ?>"/>
                            Tới ngày
                            <input type="text" class="datepicker" name="to_date6" style="text-align: center; width: 100px;" value="<?php echo $to_date6; ?>"/> 
                            <input type="text" id="" name="to_time6" style="width: 60px;" value="<?php echo $to_time6; ?>"/>
                            <br>
                            Hệ số nhân
                            <br>
                            <?php
                            foreach ($card_types as $key => $item) {
                                echo $item . " <input type='text' id='factor6[]' name='factor6[]' style='text-align: right; width: 40px;' value='" . $factor6[$key] . "' /> ";
                            }
                            ?>
                            <br>
                            <hr>
                            <input type="submit" value="Cập nhật" class="input_button"/>
                        </form>
                        <div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="box grid">
                <div class="box_header"><a href="javascript:void(0);">Event Message</a></div>
                <div class="box_body">
                    <div style="padding-left:10px;">                            
                        <form action="" method="post">
                            <table width="100%" cellspacing="1" style="font-size:13px;">
                                <thead>
                                    <tr>
                                        <th style="width: 200px;" align="center">Title</th>
                                        <th>Nội dung</th>
                                        <th style="width: 150px;" align="center">Ngày bắt đầu</th>
                                        <th style="width: 150px;" align="center">Ngày kết thúc</th>
                                        <th style="width: 50px;" align="center">OS</th>
                                        <th style="width: 20px;" align="center">Fang?</th>
                                        <th style="width:80px"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($msg as $m) {
                                        echo "<tr>";
                                        echo "<td>" . substr($m['content'], 0, strrpos($m['content'], '@@@')) . "</td>";
                                        $flag_event_text = trim(str_replace("\n", "<br/>", substr($m['content'], strrpos($m['content'], '@@@') + 3)));                                        
                                        if ($flag_event_text == 'event_text') {
                                            $sql_top_text = "select * from user order by event_text desc limit 0,10";                                            
                                            $str_top_text = "";
                                            foreach ($db->query($sql_top_text) as $key => $row) {
                                                $str_top_text = $str_top_text . ($key + 1). '. '.$row['username'].': '.$row['event_text']. ' bộ chữ<br/>';                                                
                                            }
                                            echo "<td>".$str_top_text."</td>";
                                        } else {
                                            echo "<td>" . str_replace("\n", "<br/>", substr($m['content'], strrpos($m['content'], '@@@') + 3)) . "</td>";
                                        }
                                        echo "<td>" . $m['dateBegin'] . "</td>";
                                        echo "<td>" . $m['dateEnd'] . "</td>";
                                        echo "<td>";
                                        echo ($m['os_type'] != "") ? $m['os_type'] : "Cả 3";
                                        echo "</td>";
                                        if ($m['gsm'] == 0)
                                            echo "<td>Có</td>";
                                        else
                                            echo "<td>Không</td>";
                                        echo "<td align='center'><a href='javascript:editMessage(" . json_encode($m) . ");'>Sửa</a> / <a href='javascript:deleteMessage(" . $m['id'] . ");'>Xóa</a></td>";
                                        echo "</tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                            <input type="button" value="Thêm nhiệm vụ" id='btnThemid' onclick="document.getElementById('divAddEvent').style.display = 'block';
                                    this.style.display = 'none';" />
                            <div style="display: none" id="divAddEvent">
                                Tiêu đề: <input type="text" id="msgTitle" style="width: 300px;"/> <br/>
                                Nội dung:  <br/> <textarea id="msgContent" cols=50 rows=5></textarea> <br/>
                                Ngày bắt đầu: <input type="text" id="datepicker3" style="text-align: center; width: 100px;" value=""/> 
                                <input type="text" id="from_time_mess" style="width: 60px;" value="00:00:00"/><br/>
                                Ngày hết hạn: <input type="text" id="datepicker4" style="text-align: center; width: 100px;" value=""/>
                                <input type="text" id="to_time_mess" style="width: 60px;" value="23:59:59"/> <br/>
                                Fang?: <select name="gsmselect" id="gsmselect"> <option value="0">Có</option><option value="1">Không</option> </select> <br />
                                OS: <select name="vms" id="os_type"> <option value="">Cả 4</option><option value="android">Android</option><option value="iphone">iPhone</option><option value="ipad">iPad</option><option value="j2me">Java</option> </select> <br />
                                <input type="button" value="Thêm" onclick="addMessage();"/>
                                <input type="button" value="Huỷ" onclick="document.getElementById('divAddEvent').style.display = 'none';
                                        document.getElementById('btnThemid').style.display = 'block';"/> 
                            </div>
                            <div style="display: none" id="editEvent">
                                Tiêu đề: <input type="text" id="msgTitle" style="width: 300px;"/>
                                <input type="hidden" id="msgID" style="width: 300px;"/> <br/>
                                Nội dung:  <br/> <textarea id="msgContent" cols=50 rows=5></textarea> <br/>
                                Ngày bắt đầu: <input type="text" id="editdatepicker3" style="text-align: center; width: 100px;" value=""/>  <br/>
                                Ngày hết hạn: <input type="text" id="editdatepicker4" style="text-align: center; width: 100px;" value=""/>  <br/>
                                Fang?: <select name="gsmselect" id="gsmselect"> <option value="0">Có</option><option value="1">Không</option> </select> <br />
                                OS: <select name="vms" id="os_type"> <option value="">Cả 4</option><option value="android">Android</option><option value="iphone">iPhone</option><option value="ipad">iPad</option><option value="j2me">Java</option> </select> <br />
                                <input type="button" value="Sửa" onclick="saveEditedMessage();"/>
                                <input type="button" value="Huỷ" onclick="document.getElementById('editEvent').style.display = 'none';"/> 
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="box grid">
                <div class="box_header"><a href="javascript:void(0);">Hiển thị full game VMS</a></div>
                <div class="box_body">
                    <form action="" method="post">	               
                        <?php if ($gamevms == 1) { ?>
                            Có hiển thị full game? <select name="gamevms" id="gamevms"> <option value="1">Có</option><option value="0">Không</option> </select> <br />
                        <?php } else { ?>
                            Có hiển thị full game? <select name="gamevms" id="gamevms"><option value="0">Không</option> <option value="1">Có</option> </select> <br />
<?php } ?>
                        <input type="button" value="Xác nhận" onclick="configFullgame();"/>
                    </form>
                </div>
            </div>
            <div class="box grid">
                <div class="box_header"><a href="javascript:void(0);">Block Word</a></div>
                <div class="box_body">
                    <div style="margin-right:10px;">
                        <textarea id="blockContent" cols=50 rows=5 style="width:100%;"><?php echo $blockWord; ?></textarea>
                    </div>
                    <input type="button" value="Lưu" onclick="saveBlockWord();"/>
                </div>
            </div>	
            <div class="box grid">
                <div class="box_header"><a href="javascript:void(0);">Thông tin cấu hình</a></div>
                <div class="box_body" style="display:none">
                    <div style="margin-right:10px;">
                        <table width="100%" cellpadding="1">
                            <tr>
                                <td colspan="2"><b>Xu nhận được khi đăng ký</b></td>
                            </tr>
                            <tr>
                                <td>Free</td> <td>5.000 xu</td>
                            </tr>
                            <tr>
                                <td>SMS 5.000 đ</td> <td>10.000 xu</td>
                            </tr>
                            <tr>
                                <td>Facebook</td> <td>5.000 xu</td>
                            </tr>
                            <tr>
                                <td>Xu Bonus</td><td><?php echo number_format($xu_bonus); ?> xu</td>
                            </tr>
                            <tr>
                                <td colspan="2"><b>Tiền fee game</b></td>
                            </tr>
                            <?php
                            foreach ($json_fee as $key => $val) {
                                echo "<tr><td>" . $key . "</td>";
                                echo "<td>" . ( 1 - $val['fee']['winner'] ) * 100 . " %</td></tr>";
                            }
                            ?>
                            <tr>
                                <td colspan="2"><b>Xu nạp SMS</b></td>
                            </tr>
                            <?php
                            foreach ($json_settings['tygia']['smsArray'] as $tygia) {
                                echo "<tr><td>" . number_format($tygia['key']) . " đ</td>";
                                echo "<td>" . number_format($tygia['value']) . " xu</td></tr>";
                            }
                            ?>
                            <tr>
                                <td colspan="2"><b>Xu nạp Card</b></td>
                            </tr>
                            <?php
                            foreach ($json_settings['tygia']['cardArray'] as $tygia) {
                                echo "<tr><td>" . number_format($tygia['key']) . " đ</td>";
                                echo "<td>" . number_format($tygia['value']) . " xu</td></tr>";
                            }
                            ?>
                        </table>
                    </div>
                </div>
            </div>

            <!--            <div class="box grid">
                            <div class="box_header"><a href="javascript:void(0);">Bật tắt kênh thanh toán</a></div>
                            <div class="box_body">
                                <div style="margin-right:10px;">
                                    Viettel: <input type="checkbox" value="viettel" name="paymentCard" <?php if ($json_settings['payment']['viettel'] == 1) echo 'checked="checked"' ?> /><br />
                                    Vinaphone: <input type="checkbox" value="vina" name="paymentCard" <?php if ($json_settings['payment']['vina'] == 1) echo 'checked="checked"' ?> /><br />
                                    Mobifone: <input type="checkbox" value="mobi" name="paymentCard" <?php if ($json_settings['payment']['mobi'] == 1) echo 'checked="checked"' ?> /><br />
                                    SMS: <input type="text" value="<?php echo implode(",", $json_settings['payment']['sms']); ?>" id="paymentSMS" /> (SMS có dạng 8x62)<br />
                                </div>
                                <input type="button" value="Lưu" onclick="saveConfigPayment();"/>
                            </div>
                        </div>-->
        </div>
    </body>
</html>
