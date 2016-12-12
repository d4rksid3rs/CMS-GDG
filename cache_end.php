<?php

if(CACHE_ENABLED) {
$memcache->set($mem_key, ob_get_contents(), /*MEMCACHE_COMPRESSED*/0, MEM_EXPIRE);
ob_end_flush();
}
