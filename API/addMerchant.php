<?php

require('API/db.class.php');
require('./_login_users.php');

if (!empty($_POST)) {
    $username = $_POST['user'];
    $screen_name = $_POST['screen'];
    $merchant_name = $_POST['name'];
    $address = $_POST['address'];
    $mobile = $_POST['mobile'];
    $email = $_POST['email'];
    $fb = $_POST['fb'];
    $username = mysql_escape_string($username);
    $sql = "select * from auth_user where username='" . $username . "' limit 0,1";
    $found = false;
    foreach ($db->query($sql) as $row) {
        $found = true;
        $user_id = $row['id'];
    }

    if ($found) {
        $sql_add_merchant = "INSERT INTO `merchants`(`user_id`, `username`, `screen_name`, `merchant_name`, `mobile`, `address`, `email`, `facebook`) "
                . "VALUES ('{$user_id}','{$username}','{$screen_name}','{$merchant_name}','{$mobile}','{$address}','{$email}','{$fb}')";

        $db->exec($sql_add_merchant);
    } else {
        echo "{\"status\":0,\"message\":\"Không tìm thấy Username\"}";
    }
}