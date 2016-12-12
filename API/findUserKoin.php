<?php

require('../Config.php');
require('db.class.php');
$username = $_GET['username'];
if (isset($username) && strlen($username) > 0) {
    try {
        $sql = "select koin, vip_type, koin_vip, mkoin, mkoin_vip from auth_user LEFT JOIN auth_user_vip ON auth_user.id = auth_user_vip.auth_user_id where username='" . $username . "' limit 0,1";
        $found = false;
        foreach ($db->query($sql) as $row) {
            $found = true;
            $array_true = array(
                'status' => 1,
                'vip' => $row['vip_type'],
                'koin' => number_format($row['koin']) . ' xu',
                'koin_vip' => number_format($row['koin_vip']). ' chip',
                'mkoin' => number_format($row['mkoin']). ' mini xu',
                'mkoin_vip' => number_format($row['mkoin_vip']). ' mini chip',
            );
            echo json_encode($array_true);
//            echo "{\"status\":1,\"vip\":\"" . vipType($row['vip_type']) . "\",\"koin\":\"" . number_format($row['koin']) . " xu\"}";
        }
        if ($found == false) {
            echo "{\"status\":0,\"message\":\"Không tìm thấy username\"}";
        }
    } catch (Exception $e) {
        echo "{\"status\":0,\"message\":\"" . $e->getMessage() . "\"}";
    }
} else {
    echo "{\"status\":0,\"message\":\"Chưa nhập username\"}";
}

function vipType($vip) {
    switch ($vip) {
        case 1:
            return "Vip Kim Cương";
        case 2:
            return "Vip Vàng";
        case 3:
            return "Vip Bạc";
        case 4:
            return "Kim Cương Đen";
        default:
            return "User thường";
    }
}

?>
