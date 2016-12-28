<?php

require('../Config.php');
require('db.class.php');
if (isset($_POST['username'])) {
    $username = $_POST['username'];
} else {
    echo "{\"status\":0,\"message\":\"Thiếu dữ liệu Username\"}";
    die;
}

if (!empty($_FILES['fileUpload'])) {
    $file = $_FILES['fileUpload'];
} else {
    echo "{\"status\":0,\"message\":\"Thiếu dữ liệu Ảnh\"}";
    die;
}
$username = mysql_escape_string($username);
$sql = "select * from auth_user where username='" . $username . "' limit 0,1";
$found = false;
foreach ($db->query($sql) as $row) {
    $found = true;
}
if ($found) {
    $path = '/uploads/avatar/'; // file sẽ lưu vào thư mục data    
    $tmp_name = $file['tmp_name'];
    $name = basename($file["name"]);
    $ext = end((explode(".", $name))); # extra () to prevent notice    
    $new_name = $username."_avatar_gdg.".$ext;
    $location = $path . $new_name;

    $rootPath = dirname(__FILE__);
    if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
        $rootPath = str_replace('\API', '', $rootPath);
    } else {
        $rootPath = str_replace('/API', '', $rootPath);
    }   
    $saveFile = $rootPath . $path . "/" . $new_name;
    $url = "http://" . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
    $url = str_replace('API/uploadAvatar.php', '', $url);
    $linkAvatar = $url . $location;
    if (move_uploaded_file($tmp_name, $saveFile)) {
        $response = array(
            'status' => 1,
            'message' => 'Upload thành công',
            'link' => $linkAvatar
        );
        $sql2 = "update user set avatar='{$linkAvatar}' where username='{$username}'";
        $db->exec($sql2);
        echo json_encode($response);
    } else {
        echo "{\"status\":0,\"message\":\"Upload Avatar Fail\"}";
    }
} else {
    echo "{\"status\":0,\"message\":\"Không tìm thấy Username trong DB\"}";
}