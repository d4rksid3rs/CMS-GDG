<?php

define('__URL', "http://apivmg.phang.mobi/subkoin.php");
define('__TIMEOUT', "30");
define('__HOST', "localhost");

$user = $_POST['user'];
$pass = $_POST['pass'];
$code = $_POST['code'];
$koin = $_POST['koin'];
$homepage = file_get_contents(__URL . "?user=" . $user . "&pass=" . $pass . "&code=" . $code . "&koin=" . $koin);
echo $homepage;
?>
