<?php
function es_query($qry) {
    $ch = curl_init();
    $url = "localhost/*/tcq-money/_search";
    $method = "GET";
     
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_PORT, 9200);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, strtoupper($method));
    curl_setopt($ch, CURLOPT_POSTFIELDS, $qry);
    $result = curl_exec($ch);
    curl_close($ch);

    return $result;
}

$qry = '
{
    "from": 0,
    "size" : 10,
    "sort" : [
        {"@timestamp": {"order":"desc"}}
    ],
    "fields": ["@fields.f1","@fields.f2","@fields.f3","@fields.f4","@fields.f5","@fields.f6"],
    "query": {
            "prefix" : { "@fields.f1" : "\"2013-03\"" }
    }
}
';
$es_result = es_query($qry);
die($es_result);
