<?php

define('__URL', "http://apivmg.phang.mobi/top.php?no=10");
define('__TIMEOUT', "30");
define('__HOST', "localhost");

$homepage = file_get_contents(__URL);
echo $homepage;
?>
