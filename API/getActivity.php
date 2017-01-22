<?php

$type = $_GET['type'];

switch ($type) {

    case "login":
        getLogin();
        break;

    case "inactive":

        getInactive();
        break;

    case "napsms":
        getNapSMS();
        break;


    case "napcard":
        getNapCard();
        break;

    case "napiap":
        getNapIAP();
        break;
}

function getNapIAP() {

    require('../connectdb_gimwap.php');

    $fromDate = $_REQUEST['fromDate'];
    $toDate = $_REQUEST['toDate'];

    if (isset($fromDate) && isset($toDate)) {
        try {
            $sql = "SELECT count(distinct(username)) as log FROM `log_nap_koin` where date(created_on) >= '" . $fromDate . "' and date(created_on) <= '" . $toDate . "' AND type='4'";

//		die($sql);
            $result = mysql_query($sql);

            while ($row = mysql_fetch_assoc($result)) {

                $numLogin = $row['log'];
            }
            echo "{\"status\":1,\"numuser\":\"" . $numLogin . "\"}";
        } catch (Exception $e) {
            echo "{\"status\":0,\"message\":\"" . $e->getMessage() . "\"}";
        }
    } else {
        echo "{\"status\":0,\"message\":\"Chưa nhập đủ thông tin\"}";
    }
}

function getNapCard() {

    require('../connectdb_gimwap.php');

    $fromDate = $_REQUEST['fromDate'];
    $toDate = $_REQUEST['toDate'];

    if (isset($fromDate) && isset($toDate)) {
        try {
            $sql = "SELECT count(distinct(username)) as log FROM `log_nap_koin` where date(created_on) >= '" . $fromDate . "' and date(created_on) <= '" . $toDate . "' AND type='2'";

//		die($sql);
            $result = mysql_query($sql);

            while ($row = mysql_fetch_assoc($result)) {

                $numLogin = $row['log'];
            }
            echo "{\"status\":1,\"numuser\":\"" . $numLogin . "\"}";
        } catch (Exception $e) {
            echo "{\"status\":0,\"message\":\"" . $e->getMessage() . "\"}";
        }
    } else {
        echo "{\"status\":0,\"message\":\"Chưa nhập đủ thông tin\"}";
    }
}

function getNapSMS() {
    require('../connectdb_gimwap.php');
    //mysql_connect("10.0.0.2","pokervmg_tk","Z2bLevYRuLtnY") or die("loi ket noi toi may chu---");
//	mysql_connect("local.db:3306","root","Tienquang1!") or die("loi ket noi toi may chu---");
//	
//	//define('HOST', '127.0.0.1:3307');
//	mysql_select_db("gim_wap") or die("Ko ket noi duoc toi CSDL");
    $fromDate = $_REQUEST['fromDate'];
    $toDate = $_REQUEST['toDate'];

    if (isset($fromDate) && isset($toDate)) {
        try {
            $sql = "SELECT count(distinct(username)) as log FROM `log_nap_koin` where date(created_on) >= '" . $fromDate . "' and date(created_on) <= '" . $toDate . "' AND type='1'";
//            die($sql);
            $result = mysql_query($sql);

            while ($row = mysql_fetch_assoc($result)) {

                $numLogin = $row['log'];
            }
            echo "{\"status\":1,\"numuser\":\"" . $numLogin . "\"}";
        } catch (Exception $e) {
            echo "{\"status\":0,\"message\":\"" . $e->getMessage() . "\"}";
        }
    } else {
        echo "{\"status\":0,\"message\":\"Chưa nhập đủ thông tin\"}";
    }
}

function getLogin() {
    require('../Config.php');
    require('db.class.php');

    $fromDate = $_REQUEST['fromDate'];
    $toDate = $_REQUEST['toDate'];

    if (isset($fromDate) && isset($toDate)) {
        try {
            $sql = "select os_type, count(*) as log FROM user where date(last_login) >= '" . $fromDate . "' and date(last_login) <= '" . $toDate . "' GROUP BY os_type";
            $json['status'] = 1;
            $i = 0;
            foreach ($db->query($sql) as $row) {
                $os = $row['os_type'];
                $numLogin = $row['log'];
                $json['dataos'] .= $os . ": " . $numLogin . " - ";
//			$json['dataos'][$i]['num'] = $numLogin;
                $i++;
            }
            $json['dataos'] = substr($json['dataos'], 0, -3);
            echo json_encode($json);
            //echo "{\"status\":1,\"numuser\":\"" . $numLogin . "\"}";
        } catch (Exception $e) {
            echo "{\"status\":0,\"message\":\"" . $e->getMessage() . "\"}";
        }
    } else {
        echo "{\"status\":0,\"message\":\"Chưa nhập đủ thông tin\"}";
    }
}

function getInactive() {
    require('../Config.php');
    require('db.class.php');



    $fromDate = $_GET['fromDate'];
    $numLogin = $_GET['numLogin'];

    if (isset($fromDate) && isset($numLogin)) {

        try {
            $sql = "select count(*) as log FROM user where date(last_login) <= '{$fromDate}' and login_times >{$numLogin}";

            $found = false;
            foreach ($db->query($sql) as $row) {

                $found = true;
                echo "{\"status\":1,\"numuser\":\"" . $row['log'] . "\"}";
            }
            if ($found == false) {
                echo "{\"status\":0,\"message\":\"Không xong có dữ liệu\"}";
            }
        } catch (Exception $e) {
            echo "{\"status\":0,\"message\":\"" . $e->getMessage() . "\"}";
        }
    } else {
        echo "{\"status\":0,\"message\":\"Chưa nhập đủ thông tin\"}";
    }
}

?>
