<?php

$nocache = isset($_REQUEST['nocache']) ? TRUE : FALSE;

if($nocache) define('CACHE_ENABLED', FALSE);
else define('CACHE_ENABLED', TRUE);

if(CACHE_ENABLED) {

define('MEM_SERVER', '127.0.0.1');
define('MEM_PORT', 11211);
define('MEM_EXPIRE', 60); // seconds

$page = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
if(!empty($_POST))
{
    foreach($_POST as $k=>$v)
    {
        $page .= "|$k:$v";
    }
}
$mem_key = 'http://' . md5($page);

$memcache = new Memcache;
$memcache->connect(MEM_SERVER, MEM_PORT) OR die();
$mem_value = $memcache->get($mem_key);
if($mem_value != NULL)
{
    ob_start('ob_gzhandler');
    echo $mem_value;
    ob_end_flush();
    exit();
}

ob_start();

}
