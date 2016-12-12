<?php
session_start();
if (!isset($_SERVER['PHP_AUTH_USER'])) {
    header('WWW-Authenticate: Basic realm="My Realm"');
    header('HTTP/1.0 401 Unauthorized');
    die('---^_^!');
} else {
    if(	($_SERVER['PHP_AUTH_USER']=='bemon' && $_SERVER['PHP_AUTH_PW']=='bemon20112011') ||
	($_SERVER['PHP_AUTH_USER']=='mkt' && $_SERVER['PHP_AUTH_PW']=='bemon20122012') ||
	($_SERVER['PHP_AUTH_USER']=='sale' && $_SERVER['PHP_AUTH_PW']=='bemon20132013') || 
    ($_SERVER['PHP_AUTH_USER']=='chamsockh' && $_SERVER['PHP_AUTH_PW']=='cskh20132013') ||
    ($_SERVER['PHP_AUTH_USER']=='dvkh' && $_SERVER['PHP_AUTH_PW']=='dvkh20132013')){
		$_SESSION['username'] = $_SERVER['PHP_AUTH_USER'];	
	} else {
	die('tắt trình duyệt đi và bật lại nhé ^_^!');
	}

}
//require('API/socket.php');
//$service = 0xF900;
//$input = "{}";
//$jsonData = json_decode(sendMessage($service, $input));
//readfile("./sdata");

/************************************************/
/************Server 1****************************/
/************************************************/
$my_file = file_get_contents("./sdata");
$jsonData = json_decode($my_file);
$phom = array();
$phomKey = array();
$total = 0;
foreach ($jsonData->{"phom"}->{"room"} as $row) {
    $phom[$row->{"type"}][] = array("id" => $row->{"id"},
        "name" => $row->{"name"},
        "online" => $row->{"online"},
        "maxBlind" => $row->{"maxBlind"},
        "minBlind" => $row->{"minBlind"},
        "limit" => $row->{"limit"});
    $phom["online"] += $row->{"online"};
    if (!in_array($row->{"type"}, $phomKey)) {
        $phomKey[] = $row->{"type"};
    }
}
//$phom["online"] += 25;
$phom["playingTable"] = $jsonData->{"phom"}->{"playingTable"};
$total += $phom["online"];

$bacay = array();
$bacayKey = array();
foreach ($jsonData->{"bacay"}->{"room"} as $row) {
    $bacay[$row->{"type"}][] = array("id" => $row->{"id"},
        "name" => $row->{"name"},
        "online" => $row->{"online"},
        "maxBlind" => $row->{"maxBlind"},
        "minBlind" => $row->{"minBlind"},
        "limit" => $row->{"limit"});
    $bacay["online"] += $row->{"online"};
    if (!in_array($row->{"type"}, $bacayKey)) {
        $bacayKey[] = $row->{"type"};
    }
}
//$bacay["online"] += 25;
$bacay["playingTable"] = $jsonData->{"bacay"}->{"playingTable"};
$total += $bacay["online"];

$bacaynew = array();
$bacaynewKey = array();
foreach ($jsonData->{"bacaynew"}->{"room"} as $row) {
    $bacaynew[$row->{"type"}][] = array("id" => $row->{"id"},
        "name" => $row->{"name"},
        "online" => $row->{"online"},
        "maxBlind" => $row->{"maxBlind"},
        "minBlind" => $row->{"minBlind"},
        "limit" => $row->{"limit"});
    $bacaynew["online"] += $row->{"online"};
    if (!in_array($row->{"type"}, $bacaynewKey)) {
        $bacaynewKey[] = $row->{"type"};
    }
}
$bacaynew["playingTable"] = $jsonData->{"bacaynew"}->{"playingTable"};
$total += $bacaynew["online"];

$trieuphu = array();
$trieuphuKey = array();
foreach ($jsonData->{"trieuphu"}->{"room"} as $row) {
    $trieuphu[$row->{"type"}][] = array("id" => $row->{"id"},
        "name" => $row->{"name"},
        "online" => $row->{"online"},
        "maxBlind" => $row->{"maxBlind"},
        "minBlind" => $row->{"minBlind"},
        "limit" => $row->{"limit"});
    $trieuphu["online"] += $row->{"online"};
    if (!in_array($row->{"type"}, $trieuphuKey)) {
        $trieuphuKey[] = $row->{"type"};
    }
}
$trieuphu["playingTable"] = $jsonData->{"trieuphu"}->{"playingTable"};
$total += $trieuphu["online"];

$tienlenmb = array();
$tienlenmbKey = array();
foreach ($jsonData->{"tienlenmb"}->{"room"} as $row) {
    $tienlenmb[$row->{"type"}][] = array("id" => $row->{"id"},
        "name" => $row->{"name"},
        "online" => $row->{"online"},
        "maxBlind" => $row->{"maxBlind"},
        "minBlind" => $row->{"minBlind"},
        "limit" => $row->{"limit"});
    $tienlenmb["online"] += $row->{"online"};
    if (!in_array($row->{"type"}, $tienlenmbKey)) {
        $tienlenmbKey[] = $row->{"type"};
    }
}
$tienlenmb["playingTable"] = $jsonData->{"tienlenmb"}->{"playingTable"};
$total += $tienlenmb["online"];

$tienlenmn = array();
$tienlenmnKey = array();
foreach ($jsonData->{"tienlenmn"}->{"room"} as $row) {
    $tienlenmn[$row->{"type"}][] = array("id" => $row->{"id"},
        "name" => $row->{"name"},
        "online" => $row->{"online"},
        "maxBlind" => $row->{"maxBlind"},
        "minBlind" => $row->{"minBlind"},
        "limit" => $row->{"limit"});
    $tienlenmn["online"] += $row->{"online"};
    if (!in_array($row->{"type"}, $tienlenmnKey)) {
        $tienlenmnKey[] = $row->{"type"};
    }
}
//$tienlenmn["online"] += 50;
$tienlenmn["playingTable"] = $jsonData->{"tienlenmn"}->{"playingTable"};
$total += $tienlenmn["online"];

$tienlenmndc = array();
$tienlenmndcKey = array();
foreach ($jsonData->{"tienlenmndc"}->{"room"} as $row) {
    $tienlenmndc[$row->{"type"}][] = array("id" => $row->{"id"},
        "name" => $row->{"name"},
        "online" => $row->{"online"},
        "maxBlind" => $row->{"maxBlind"},
        "minBlind" => $row->{"minBlind"},
        "limit" => $row->{"limit"});
    $tienlenmndc["online"] += $row->{"online"};
    if (!in_array($row->{"type"}, $tienlenmndcKey)) {
        $tienlenmndcKey[] = $row->{"type"};
    }
}
$tienlenmndc["playingTable"] = $jsonData->{"tienlenmndc"}->{"playingTable"};
$total += $tienlenmndc["online"];

$caro = array();
$caroKey = array();
foreach ($jsonData->{"caro"}->{"room"} as $row) {
    $caro[$row->{"type"}][] = array("id" => $row->{"id"},
        "name" => $row->{"name"},
        "online" => $row->{"online"},
        "maxBlind" => $row->{"maxBlind"},
        "minBlind" => $row->{"minBlind"},
        "limit" => $row->{"limit"});
    $caro["online"] += $row->{"online"};
    if (!in_array($row->{"type"}, $caroKey)) {
        $caroKey[] = $row->{"type"};
    }
}
$caro["playingTable"] = $jsonData->{"caro"}->{"playingTable"};
$total += $caro["online"];

$bing = array();
$bingKey = array();
foreach ($jsonData->{"bing"}->{"room"} as $row) {
    $bing[$row->{"type"}][] = array("id" => $row->{"id"},
        "name" => $row->{"name"},
        "online" => $row->{"online"},
        "maxBlind" => $row->{"maxBlind"},
        "minBlind" => $row->{"minBlind"},
        "limit" => $row->{"limit"});
    $bing["online"] += $row->{"online"};
    if (!in_array($row->{"type"}, $bingKey)) {
        $bingKey[] = $row->{"type"};
    }
}
$bing["playingTable"] = $jsonData->{"bing"}->{"playingTable"};
$total += $bing["online"];

$lieng = array();
$liengKey = array();
foreach ($jsonData->{"lieng"}->{"room"} as $row) {
    $lieng[$row->{"type"}][] = array("id" => $row->{"id"},
        "name" => $row->{"name"},
        "online" => $row->{"online"},
        "maxBlind" => $row->{"maxBlind"},
        "minBlind" => $row->{"minBlind"},
        "limit" => $row->{"limit"});
    $lieng["online"] += $row->{"online"};
    if (!in_array($row->{"type"}, $liengKey)) {
        $liengKey[] = $row->{"type"};
    }
}
$lieng["playingTable"] = $jsonData->{"lieng"}->{"playingTable"};
$total += $lieng["online"];

$chatroom = array();
$chatroomKey = array();
foreach ($jsonData->{"chatroom"}->{"room"} as $row) {
    $chatroom[$row->{"type"}][] = array("id" => $row->{"id"},
        "name" => $row->{"name"},
        "online" => $row->{"online"},
        "maxBlind" => $row->{"maxBlind"},
        "minBlind" => $row->{"minBlind"},
        "limit" => $row->{"limit"});
    $chatroom["online"] += $row->{"online"};
    if (!in_array($row->{"type"}, $chatroomKey)) {
        $chatroomKey[] = $row->{"type"};
    }
}
$chatroom["playingTable"] = $jsonData->{"chatroom"}->{"playingTable"};
$total += $chatroom["online"];

$sam = array();
$samKey = array();
foreach ($jsonData->{"sam"}->{"room"} as $row) {
    $sam [$row->{"type"}][] = array("id" => $row->{"id"},
        "name" => $row->{"name"},
        "online" => $row->{"online"},
        "maxBlind" => $row->{"maxBlind"},
        "minBlind" => $row->{"minBlind"},
        "limit" => $row->{"limit"});
    $sam ["online"] += $row->{"online"};
    if (!in_array($row->{"type"}, $samKey)) {
        $samKey[] = $row->{"type"};
    }
}
$sam["playingTable"] = $jsonData->{"sam"}->{"playingTable"};
$total += $sam["online"];

/************************************************/
/************Server 2****************************/
/************************************************/
$my_file = file_get_contents("./sdata2");
$jsonData2 = json_decode($my_file);
$phom2 = array();
$phomKey2 = array();
$total2 = 0;
foreach ($jsonData2->{"phom"}->{"room"} as $row) {
    $phom2[$row->{"type"}][] = array("id" => $row->{"id"},
        "name" => $row->{"name"},
        "online" => $row->{"online"},
        "maxBlind" => $row->{"maxBlind"},
        "minBlind" => $row->{"minBlind"},
        "limit" => $row->{"limit"});
    $phom2["online"] += $row->{"online"};
    if (!in_array($row->{"type"}, $phomKey2)) {
        $phomKey2[] = $row->{"type"};
    }
}
//$phom["online"] += 25;
$phom2["playingTable"] = $jsonData2->{"phom"}->{"playingTable"};
$total2 += $phom2["online"];

$bacay2 = array();
$bacayKey2 = array();
foreach ($jsonData2->{"bacay"}->{"room"} as $row) {
    $bacay2[$row->{"type"}][] = array("id" => $row->{"id"},
        "name" => $row->{"name"},
        "online" => $row->{"online"},
        "maxBlind" => $row->{"maxBlind"},
        "minBlind" => $row->{"minBlind"},
        "limit" => $row->{"limit"});
    $bacay2["online"] += $row->{"online"};
    if (!in_array($row->{"type"}, $bacayKey2)) {
        $bacayKey2[] = $row->{"type"};
    }
}
//$bacay["online"] += 25;
$bacay2["playingTable"] = $jsonData2->{"bacay"}->{"playingTable"};
$total2 += $bacay2["online"];

$bacaynew2 = array();
$bacaynewKey2 = array();
foreach ($jsonData2->{"bacaynew"}->{"room"} as $row) {
    $bacaynew2[$row->{"type"}][] = array("id" => $row->{"id"},
        "name" => $row->{"name"},
        "online" => $row->{"online"},
        "maxBlind" => $row->{"maxBlind"},
        "minBlind" => $row->{"minBlind"},
        "limit" => $row->{"limit"});
    $bacaynew2["online"] += $row->{"online"};
    if (!in_array($row->{"type"}, $bacaynewKey2)) {
        $bacaynewKey2[] = $row->{"type"};
    }
}
$bacaynew2["playingTable"] = $jsonData2->{"bacaynew"}->{"playingTable"};
$total2 += $bacaynew2["online"];

$trieuphu2 = array();
$trieuphuKey2 = array();
foreach ($jsonData2->{"trieuphu"}->{"room"} as $row) {
    $trieuphu2[$row->{"type"}][] = array("id" => $row->{"id"},
        "name" => $row->{"name"},
        "online" => $row->{"online"},
        "maxBlind" => $row->{"maxBlind"},
        "minBlind" => $row->{"minBlind"},
        "limit" => $row->{"limit"});
    $trieuphu2["online"] += $row->{"online"};
    if (!in_array($row->{"type"}, $trieuphuKey2)) {
        $trieuphuKey2[] = $row->{"type"};
    }
}
$trieuphu2["playingTable"] = $jsonData2->{"trieuphu"}->{"playingTable"};
$total2 += $trieuphu2["online"];

$tienlenmb2 = array();
$tienlenmbKey2 = array();
foreach ($jsonData2->{"tienlenmb"}->{"room"} as $row) {
    $tienlenmb2[$row->{"type"}][] = array("id" => $row->{"id"},
        "name" => $row->{"name"},
        "online" => $row->{"online"},
        "maxBlind" => $row->{"maxBlind"},
        "minBlind" => $row->{"minBlind"},
        "limit" => $row->{"limit"});
    $tienlenmb2["online"] += $row->{"online"};
    if (!in_array($row->{"type"}, $tienlenmbKey2)) {
        $tienlenmbKey2[] = $row->{"type"};
    }
}
$tienlenmb2["playingTable"] = $jsonData2->{"tienlenmb"}->{"playingTable"};
$total2 += $tienlenmb2["online"];

$tienlenmn2 = array();
$tienlenmnKey2 = array();
foreach ($jsonData2->{"tienlenmn"}->{"room"} as $row) {
    $tienlenmn2[$row->{"type"}][] = array("id" => $row->{"id"},
        "name" => $row->{"name"},
        "online" => $row->{"online"},
        "maxBlind" => $row->{"maxBlind"},
        "minBlind" => $row->{"minBlind"},
        "limit" => $row->{"limit"});
    $tienlenmn2["online"] += $row->{"online"};
    if (!in_array($row->{"type"}, $tienlenmnKey2)) {
        $tienlenmnKey2[] = $row->{"type"};
    }
}
//$tienlenmn["online"] += 50;
$tienlenmn2["playingTable"] = $jsonData2->{"tienlenmn"}->{"playingTable"};
$total2 += $tienlenmn2["online"];

$tienlenmndc2 = array();
$tienlenmndcKey2 = array();
foreach ($jsonData2->{"tienlenmndc"}->{"room"} as $row) {
    $tienlenmndc2[$row->{"type"}][] = array("id" => $row->{"id"},
        "name" => $row->{"name"},
        "online" => $row->{"online"},
        "maxBlind" => $row->{"maxBlind"},
        "minBlind" => $row->{"minBlind"},
        "limit" => $row->{"limit"});
    $tienlenmndc2["online"] += $row->{"online"};
    if (!in_array($row->{"type"}, $tienlenmndcKey2)) {
        $tienlenmndcKey2[] = $row->{"type"};
    }
}
$tienlenmndc2["playingTable"] = $jsonData2->{"tienlenmndc"}->{"playingTable"};
$total2 += $tienlenmndc2["online"];

$caro2 = array();
$caroKey2 = array();
foreach ($jsonData2->{"caro"}->{"room"} as $row) {
    $caro2[$row->{"type"}][] = array("id" => $row->{"id"},
        "name" => $row->{"name"},
        "online" => $row->{"online"},
        "maxBlind" => $row->{"maxBlind"},
        "minBlind" => $row->{"minBlind"},
        "limit" => $row->{"limit"});
    $caro2["online"] += $row->{"online"};
    if (!in_array($row->{"type"}, $caroKey2)) {
        $caroKey2[] = $row->{"type"};
    }
}
$caro2["playingTable"] = $jsonData2->{"caro"}->{"playingTable"};
$total2 += $caro2["online"];

$bing2 = array();
$bingKey2 = array();
foreach ($jsonData2->{"bing"}->{"room"} as $row) {
    $bing2[$row->{"type"}][] = array("id" => $row->{"id"},
        "name" => $row->{"name"},
        "online" => $row->{"online"},
        "maxBlind" => $row->{"maxBlind"},
        "minBlind" => $row->{"minBlind"},
        "limit" => $row->{"limit"});
    $bing2["online"] += $row->{"online"};
    if (!in_array($row->{"type"}, $bingKey2)) {
        $bingKey2[] = $row->{"type"};
    }
}
$bing2["playingTable"] = $jsonData2->{"bing"}->{"playingTable"};
$total2 += $bing2["online"];

$lieng2 = array();
$liengKey2 = array();
foreach ($jsonData2->{"lieng"}->{"room"} as $row) {
    $lieng2[$row->{"type"}][] = array("id" => $row->{"id"},
        "name" => $row->{"name"},
        "online" => $row->{"online"},
        "maxBlind" => $row->{"maxBlind"},
        "minBlind" => $row->{"minBlind"},
        "limit" => $row->{"limit"});
    $lieng2["online"] += $row->{"online"};
    if (!in_array($row->{"type"}, $liengKey2)) {
        $liengKey2[] = $row->{"type"};
    }
}
$lieng2["playingTable"] = $jsonData2->{"lieng"}->{"playingTable"};
$total2 += $lieng2["online"];

$chatroom2 = array();
$chatroomKey2 = array();
foreach ($jsonData2->{"chatroom"}->{"room"} as $row) {
    $chatroom2[$row->{"type"}][] = array("id" => $row->{"id"},
        "name" => $row->{"name"},
        "online" => $row->{"online"},
        "maxBlind" => $row->{"maxBlind"},
        "minBlind" => $row->{"minBlind"},
        "limit" => $row->{"limit"});
    $chatroom2["online"] += $row->{"online"};
    if (!in_array($row->{"type"}, $chatroomKey2)) {
        $chatroomKey2[] = $row->{"type"};
    }
}
$chatroom2["playingTable"] = $jsonData2->{"chatroom"}->{"playingTable"};
$total2 += $chatroom2["online"];

$sam2 = array();
$samKey2 = array();
foreach ($jsonData2->{"sam"}->{"room"} as $row) {
    $sam2[$row->{"type"}][] = array("id" => $row->{"id"},
        "name" => $row->{"name"},
        "online" => $row->{"online"},
        "maxBlind" => $row->{"maxBlind"},
        "minBlind" => $row->{"minBlind"},
        "limit" => $row->{"limit"});
    $sam2["online"] += $row->{"online"};
    if (!in_array($row->{"type"}, $samKey2)) {
        $samKey2[] = $row->{"type"};
    }
}
$sam2["playingTable"] = $jsonData2->{"sam"}->{"playingTable"};
$total2 += $sam2["online"];

/*
$nhaycot = array();
$nhaycotKey = array();
foreach ($jsonData->{"nhaycot"}->{"room"} as $row) {
    $nhaycot[$row->{"type"}][] = array("id" => $row->{"id"},
        "name" => $row->{"name"},
        "online" => $row->{"online"},
        "maxBlind" => $row->{"maxBlind"},
        "minBlind" => $row->{"minBlind"},
        "limit" => $row->{"limit"});
    $nhaycot["online"] += $row->{"online"};
    if (!in_array($row->{"type"}, $nhaycotKey)) {
        $nhaycotKey[] = $row->{"type"};
    }
}
$nhaycot["playingTable"] = $jsonData->{"nhaycot"}->{"playingTable"};
$total += $nhaycot["online"];

$luotvan = array();
$luotvanKey = array();
foreach ($jsonData->{"luotvan"}->{"room"} as $row) {
    $luotvan[$row->{"type"}][] = array("id" => $row->{"id"},
        "name" => $row->{"name"},
        "online" => $row->{"online"},
        "maxBlind" => $row->{"maxBlind"},
        "minBlind" => $row->{"minBlind"},
        "limit" => $row->{"limit"});
    $luotvan["online"] += $row->{"online"};
    if (!in_array($row->{"type"}, $luotvanKey)) {
        $luotvanKey[] = $row->{"type"};
    }
}
$luotvan["playingTable"] = $jsonData->{"luotvan"}->{"playingTable"};
$total += $luotvan["online"];

$bar0 = array();
$bar0Key = array();
foreach ($jsonData->{"bar_0"}->{"room"} as $row) {
    $bar0[$row->{"type"}][] = array("id" => $row->{"id"},
        "name" => $row->{"name"},
        "online" => $row->{"online"},
        "maxBlind" => $row->{"maxBlind"},
        "minBlind" => $row->{"minBlind"},
        "limit" => $row->{"limit"});
    $bar0["online"] += $row->{"online"};
    if (!in_array($row->{"type"}, $barKey)) {
        $bar0Key[] = $row->{"type"};
    }
}
$bar0["playingTable"] = $jsonData->{"bar_0"}->{"playingTable"};
$total += $bar0["online"];

$park0 = array();
$park0Key = array();
foreach ($jsonData->{"park_0"}->{"room"} as $row) {
    $park0[$row->{"type"}][] = array("id" => $row->{"id"},
        "name" => $row->{"name"},
        "online" => $row->{"online"},
        "maxBlind" => $row->{"maxBlind"},
        "minBlind" => $row->{"minBlind"},
        "limit" => $row->{"limit"});
    $park0["online"] += $row->{"online"};
    if (!in_array($row->{"type"}, $park0Key)) {
        $park0Key[] = $row->{"type"};
    }
}
$park["playingTable"] = $jsonData->{"park_0"}->{"playingTable"};
$total += $park0["online"];

$park1 = array();
$park1Key = array();
foreach ($jsonData->{"park_1"}->{"room"} as $row) {
    $park1[$row->{"type"}][] = array("id" => $row->{"id"},
        "name" => $row->{"name"},
        "online" => $row->{"online"},
        "maxBlind" => $row->{"maxBlind"},
        "minBlind" => $row->{"minBlind"},
        "limit" => $row->{"limit"});
    $park1["online"] += $row->{"online"};
    if (!in_array($row->{"type"}, $park1Key)) {
        $park1Key[] = $row->{"type"};
    }
}
$park1["playingTable"] = $jsonData->{"park_1"}->{"playingTable"};
$total += $park1["online"];

$park2 = array();
$park2Key = array();
foreach ($jsonData->{"park_2"}->{"room"} as $row) {
    $park2[$row->{"type"}][] = array("id" => $row->{"id"},
        "name" => $row->{"name"},
        "online" => $row->{"online"},
        "maxBlind" => $row->{"maxBlind"},
        "minBlind" => $row->{"minBlind"},
        "limit" => $row->{"limit"});
    $park2["online"] += $row->{"online"};
    if (!in_array($row->{"type"}, $park2Key)) {
        $park2Key[] = $row->{"type"};
    }
}
$park2["playingTable"] = $jsonData->{"park_2"}->{"playingTable"};
$total += $park2["online"];

$beach0 = array();
$beach0Key = array();
foreach ($jsonData->{"beach_0"}->{"room"} as $row) {
    $beach0[$row->{"type"}][] = array("id" => $row->{"id"},
        "name" => $row->{"name"},
        "online" => $row->{"online"},
        "maxBlind" => $row->{"maxBlind"},
        "minBlind" => $row->{"minBlind"},
        "limit" => $row->{"limit"});
    $beach0["online"] += $row->{"online"};
    if (!in_array($row->{"type"}, $beach0Key)) {
        $beach0Key[] = $row->{"type"};
    }
}
$beach0["playingTable"] = $jsonData->{"beach_0"}->{"playingTable"};
$total += $beach0["online"];

$beach1 = array();
$beach1Key = array();
foreach ($jsonData->{"beach_1"}->{"room"} as $row) {
    $beach1[$row->{"type"}][] = array("id" => $row->{"id"},
        "name" => $row->{"name"},
        "online" => $row->{"online"},
        "maxBlind" => $row->{"maxBlind"},
        "minBlind" => $row->{"minBlind"},
        "limit" => $row->{"limit"});
    $beach1["online"] += $row->{"online"};
    if (!in_array($row->{"type"}, $beach1Key)) {
        $beach1Key[] = $row->{"type"};
    }
}
$beach1["playingTable"] = $jsonData->{"beach_1"}->{"playingTable"};
$total += $beach1["online"];

$beach2 = array();
$beach2Key = array();
foreach ($jsonData->{"beach_2"}->{"room"} as $row) {
    $beach2[$row->{"type"}][] = array("id" => $row->{"id"},
        "name" => $row->{"name"},
        "online" => $row->{"online"},
        "maxBlind" => $row->{"maxBlind"},
        "minBlind" => $row->{"minBlind"},
        "limit" => $row->{"limit"});
    $beach2["online"] += $row->{"online"};
    if (!in_array($row->{"type"}, $beach2Key)) {
        $beach2Key[] = $row->{"type"};
    }
}
$beach2["playingTable"] = $jsonData->{"beach_2"}->{"playingTable"};
$total += $beach2["online"];
*/
$fromDate = $_GET['fromDate'];
$toDate = $_GET['toDate'];
if (!isset($fromDate)) {
	$fromDate = date('Y-m-d', time());
}
if (!isset($toDate)) {
	$toDate = date('Y-m-d', time());
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Trà Chanh Quán</title>
        <?php require('header.php'); ?>
		<script>
			$(document).ready(function(){
				$("#datepicker1").datepicker();
				$("#datepicker2").datepicker();
			}); 
		</script>
    </head>
    <body>
        <div class="pagewrap">
            <?php require('topMenu.php'); ?>
            <div class="box grid">
                <div class="box_header"><a href="javascript:void(0);" title="<?php echo $jsonData->{'count'}." - ".$jsonData2->{'count'}." - ".($jsonData->{'count'} + $jsonData2->{'count'}); ?>">Người chơi <?php echo ($total + $total2)."/".($jsonData->{"online"} + $jsonData2->{"online"})?></a></div>
                <div class="box_body">
                    <table width="100%">
						<tr>
							<td width="50%">
								<table width=100%>
									<tr><td colspan="2" align="center"><b>Trà Chanh - 123.29.67.101</b></td></tr>
									<tr><td width="40%">Tổng số người online </td><td align="center"><?php echo $total." / ".($jsonData->{"online"}); ?></td></tr>
									<tr><td>Chơi phỏm </td><td align="center"><?php echo $phom["online"]; ?></td></tr>
									<tr><td>Chơi ba cây </td><td align="center"><?php echo $bacay["online"]; ?></td></tr>
									<tr><td>Chơi ba cây mới </td><td align="center"><?php echo $bacaynew["online"]; ?></td></tr>
									<tr><td>Chơi Olympia </td><td align="center"><?php echo $trieuphu["online"]; ?></td></tr>
									<tr><td>Chơi tiến lên MB </td><td align="center"><?php echo $tienlenmb["online"]; ?></td></tr>
									<tr><td>Chơi tiến lên MN </td><td align="center"><?php echo $tienlenmn["online"]; ?></td></tr>
									<tr><td>Chơi tiến lên MNDC </td><td align="center"><?php echo $tienlenmndc["online"]; ?></td></tr>
									<tr><td>Chơi caro </td><td align="center"><?php echo $caro["online"]; ?></td></tr>
									<tr><td>Chơi bing </td><td align="center"><?php echo $bing["online"]; ?></td></tr>
									<tr><td>Chơi liêng </td><td align="center"><?php echo $lieng["online"]; ?></td></tr>
									<tr><td>Chơi sâm </td><td align="center"><?php echo $sam["online"]; ?></td></tr>
									<!--<tr><td>Chatroom </td><td align="center"><?php echo $chatroom["online"]; ?></td></tr>-->
								</table>
							</td>
							<td width="50%">
								<table width=100%>
									<tr><td colspan="2" align="center"><b>Trà Sữa - 123.29.67.69</b></td></tr>
									<tr><td width="40%">Tổng số người online </td><td align="center"><?php echo $total2." / ".($jsonData2->{"online"}); ?></td></tr>
									<tr><td>Chơi phỏm </td><td align="center"><?php echo $phom2["online"]; ?></td></tr>
									<tr><td>Chơi ba cây </td><td align="center"><?php echo $bacay2["online"]; ?></td></tr>
									<tr><td>Chơi ba cây mới </td><td align="center"><?php echo $bacaynew2["online"]; ?></td></tr>
									<tr><td>Chơi Olympia </td><td align="center"><?php echo $trieuphu2["online"]; ?></td></tr>
									<tr><td>Chơi tiến lên MB </td><td align="center"><?php echo $tienlenmb2["online"]; ?></td></tr>
									<tr><td>Chơi tiến lên MN </td><td align="center"><?php echo $tienlenmn2["online"]; ?></td></tr>
									<tr><td>Chơi tiến lên MNDC </td><td align="center"><?php echo $tienlenmndc2["online"]; ?></td></tr>
									<tr><td>Chơi caro </td><td align="center"><?php echo $caro2["online"]; ?></td></tr>
									<tr><td>Chơi bing </td><td align="center"><?php echo $bing2["online"]; ?></td></tr>
									<tr><td>Chơi liêng </td><td align="center"><?php echo $lieng2["online"]; ?></td></tr>
									<tr><td>Chơi sâm </td><td align="center"><?php echo $sam2["online"]; ?></td></tr>
									<!--<tr><td>Chatroom </td><td align="center"><?php echo $chatroom2["online"]; ?></td></tr>-->
								</table>
							</td>
						</tr>
						<!--
						<tr><td>Chơi nhảy cột </td><td align="center"><?php echo $nhaycot["online"]; ?></td></tr>
						<tr><td>Chơi lướt ván </td><td align="center"><?php echo $luotvan["online"]; ?></td></tr>
						<tr><td>Sàn nhạc </td><td align="center"><?php echo $bar0["online"]; ?></td></tr>
						<tr><td>Công viên 1</td><td align="center"><?php echo $park0["online"]; ?></td></tr>
						<tr><td>Công viên 2</td><td align="center"><?php echo $park1["online"]; ?></td></tr>
						<tr><td>Công viên 3</td><td align="center"><?php echo $park2["online"]; ?></td></tr>
						<tr><td>Bãi biển 1</td><td align="center"><?php echo $beach0["online"]; ?></td></tr>
						<tr><td>Bãi biển 2</td><td align="center"><?php echo $beach1["online"]; ?></td></tr>
						<tr><td>Bãi biển 3</td><td align="center"><?php echo $beach2["online"]; ?></td></tr>
						-->
                    </table>
                </div>
            </div>
			<div class="box grid">
                <div class="box_header">
                    <a href="javascript:void(0);">Biểu đồ lịch sử</a>
                </div>
                <div class="box_body">
					<table width=100%>
						<tr>
							<td width="50%"> <iframe height="370" width="100%" frameBorder="0" src="chart.php?fromDate=<?php echo $fromDate;?>&toDate=<?php echo $toDate;?>">your browser does not support IFRAMEs</iframe></td>
							<td width="50%"> <iframe height="370" width="100%" frameBorder="0" src="chart2.php?fromDate=<?php echo $fromDate;?>&toDate=<?php echo $toDate;?>">your browser does not support IFRAMEs</iframe></td>
						</tr>
					</table>
					<div style="padding-left:10px; text-align:center;">
						<form method="index.php" method="GET">
							Từ ngày 
							<input type="text" id="datepicker1" name="fromDate" style="text-align: center; width: 100px;" value="<?php echo $fromDate;?>"/> 
							Tới ngày 
							<input type="text" id="datepicker2" name="toDate" style="text-align: center; width: 100px;" value="<?php echo $toDate;?>"/> 
							<input type="submit" value="Cập nhật" class="input_button"/>
						</form>
					</div>
                </div>
            </div>
            <div class="box grid">
                <div class="box_header">
                    <a href="javascript:void(0);">Trà Chanh</a>
                </div>
                <div class="box_body" style="display:none;">
                	<table>
	                	<tr>
		                	<td>
			                	<?php
			                    foreach ($phomKey as $key) {
			                        echo "<div class=\"room_title\">Phỏm " . $phom["playingTable"] . "</div>";
			                        foreach ($phom[$key] as $room) {
			                            echo "<div class=\"room_box\">";
			                            echo "<div class=\"room_box_title room_dark\"><a href=\"room.php?name=Phỏm - " . $key . " - " . $room["name"] . "&id=" . $room["id"] . "\">" . $room["name"] . "</a></div>";
			                            if ($room["online"] <= $room["limit"] / 2) {
			                                echo "<div class=\"room_box_body room_green\"><a href=\"room.php?name=Phỏm - " . $key . " - " . $room["name"] . "&id=" . $room["id"] . "\">" . $room["online"] . "/" . $room["limit"] . "</a></div>";
			                            } else if ($room["online"] <= $room["limit"] / 4 * 3) {
			                                echo "<div class=\"room_box_body room_yellow\"><a href=\"room.php?name=Phỏm - " . $key . " - " . $room["name"] . "&id=" . $room["id"] . "\">" . $room["online"] . "/" . $room["limit"] . "</a></div>";
			                            } else {
			                                echo "<div class=\"room_box_body room_red\"><a href=\"room.php?name=Phỏm - " . $key . " - " . $room["name"] . "&id=" . $room["id"] . "\">" . $room["online"] . "/" . $room["limit"] . "</a></div>";
			                            }
			                            echo "</div>";
			                        }
			                    }
			                    ?>
		                	</td>
		                	<td>
			                	<?php
			                    foreach ($bacayKey as $key) {
			                        echo "<div class=\"room_title\">Ba cây " . $bacay["playingTable"] . "</div>";
			                        foreach ($bacay[$key] as $room) {
			                            echo "<div class=\"room_box\">";
			                            echo "<div class=\"room_box_title room_dark\"><a href=\"room.php?name=Ba cây - " . $key . " - " . $room["name"] . "&id=" . $room["id"] . "\">" . $room["name"] . "</a></div>";
			                            if ($room["online"] <= $room["limit"] / 2) {
			                                echo "<div class=\"room_box_body room_green\"><a href=\"room.php?name=Ba cây - " . $key . " - " . $room["name"] . "&id=" . $room["id"] . "\">" . $room["online"] . "/" . $room["limit"] . "</a></div>";
			                            } else if ($room["online"] <= $room["limit"] / 4 * 3) {
			                                echo "<div class=\"room_box_body room_yellow\"><a href=\"room.php?name=Ba cây - " . $key . " - " . $room["name"] . "&id=" . $room["id"] . "\">" . $room["online"] . "/" . $room["limit"] . "</a></div>";
			                            } else {
			                                echo "<div class=\"room_box_body room_red\"><a href=\"room.php?name=Ba cây - " . $key . " - " . $room["name"] . "&id=" . $room["id"] . "\">" . $room["online"] . "/" . $room["limit"] . "</a></div>";
			                            }
			                            echo "</div>";
			                        }
			                    }
			                    ?>
		                	</td>
		                	<td>
        	                    <?php
								foreach ($bacaynewKey as $key) {
								    echo "<div class=\"room_title\">Ba cây mới </div>";
								    foreach ($bacaynew[$key] as $room) {
								        echo "<div class=\"room_box\">";
								        echo "<div class=\"room_box_title room_dark\"><a href=\"room.php?name=Ba cây - " . $key . " - " . $room["name"] . "&id=" . $room["id"] . "\">" . $room["name"] . "</a></div>";
								        if ($room["online"] <= $room["limit"] / 2) {
								            echo "<div class=\"room_box_body room_green\"><a href=\"room.php?name=Ba cây - " . $key . " - " . $room["name"] . "&id=" . $room["id"] . "\">" . $room["online"] . "/" . $room["limit"] . "</a></div>";
								        } else if ($room["online"] <= $room["limit"] / 4 * 3) {
								            echo "<div class=\"room_box_body room_yellow\"><a href=\"room.php?name=Ba cây - " . $key . " - " . $room["name"] . "&id=" . $room["id"] . "\">" . $room["online"] . "/" . $room["limit"] . "</a></div>";
								        } else {
								            echo "<div class=\"room_box_body room_red\"><a href=\"room.php?name=Ba cây - " . $key . " - " . $room["name"] . "&id=" . $room["id"] . "\">" . $room["online"] . "/" . $room["limit"] . "</a></div>";
								        }
								        echo "</div>";
								    }
								}
								?>
		                	</td>
		                	<td>
			                    <?php
			                    foreach ($tienlenmbKey as $key) {
			                        echo "<div class=\"room_title\">TLMB " . $tienlenmb["playingTable"] . "</div>";
			                        foreach ($tienlenmb[$key] as $room) {
			                            echo "<div class=\"room_box\">";
			                            echo "<div class=\"room_box_title room_dark\"><a href=\"room.php?name=Tiến lên MB - " . $key . " - " . $room["name"] . "&id=" . $room["id"] . "\">" . $room["name"] . "</a></div>";
			                            if ($room["online"] <= $room["limit"] / 2) {
			                                echo "<div class=\"room_box_body room_green\"><a href=\"room.php?name=Tiến lên MB - " . $key . " - " . $room["name"] . "&id=" . $room["id"] . "\">" . $room["online"] . "/" . $room["limit"] . "</a></div>";
			                            } else if ($room["online"] <= $room["limit"] / 4 * 3) {
			                                echo "<div class=\"room_box_body room_yellow\"><a href=\"room.php?name=Tiến lên MB - " . $key . " - " . $room["name"] . "&id=" . $room["id"] . "\">" . $room["online"] . "/" . $room["limit"] . "</a></div>";
			                            } else {
			                                echo "<div class=\"room_box_body room_red\"><a href=\"room.php?name=Tiến lên MB - " . $key . " - " . $room["name"] . "&id=" . $room["id"] . "\">" . $room["online"] . "/" . $room["limit"] . "</a></div>";
			                            }
			                            echo "</div>";
			                        }
			                    }
			                    ?>
		                	</td>
		                	<td>
			                	<?php
			                    foreach ($tienlenmnKey as $key) {
			                        echo "<div class=\"room_title\">TLMN " . $tienlenmn["playingTable"] . "</div>";
			                        foreach ($tienlenmn[$key] as $room) {
			                            echo "<div class=\"room_box\">";
			                            echo "<div class=\"room_box_title room_dark\"><a href=\"room.php?name=Tiến lên MN - " . $key . " - " . $room["name"] . "&id=" . $room["id"] . "\">" . $room["name"] . "</a></div>";
			                            if ($room["online"] <= $room["limit"] / 2) {
			                                echo "<div class=\"room_box_body room_green\"><a href=\"room.php?name=Tiến lên MN - " . $key . " - " . $room["name"] . "&id=" . $room["id"] . "\">" . $room["online"] . "/" . $room["limit"] . "</a></div>";
			                            } else if ($room["online"] <= $room["limit"] / 4 * 3) {
			                                echo "<div class=\"room_box_body room_yellow\"><a href=\"room.php?name=Tiến lên MN - " . $key . " - " . $room["name"] . "&id=" . $room["id"] . "\">" . $room["online"] . "/" . $room["limit"] . "</a></div>";
			                            } else {
			                                echo "<div class=\"room_box_body room_red\"><a href=\"room.php?name=Tiến lên MN - " . $key . " - " . $room["name"] . "&id=" . $room["id"] . "\">" . $room["online"] . "/" . $room["limit"] . "</a></div>";
			                            }
			                            echo "</div>";
			                        }
			                    }
			                    ?>
		                	</td>
		                	<td>
			                	 <?php
			                    foreach ($tienlenmndcKey as $key) {
			                        echo "<div class=\"room_title\">TLMNDC </div>";
			                        foreach ($tienlenmndc[$key] as $room) {
			                            echo "<div class=\"room_box\">";
			                            echo "<div class=\"room_box_title room_dark\"><a href=\"room.php?name=Tiến lên MNDC - " . $key . " - " . $room["name"] . "&id=" . $room["id"] . "\">" . $room["name"] . "</a></div>";
			                            if ($room["online"] <= $room["limit"] / 2) {
			                                echo "<div class=\"room_box_body room_green\"><a href=\"room.php?name=Tiến lên MNDC - " . $key . " - " . $room["name"] . "&id=" . $room["id"] . "\">" . $room["online"] . "/" . $room["limit"] . "</a></div>";
			                            } else if ($room["online"] <= $room["limit"] / 4 * 3) {
			                                echo "<div class=\"room_box_body room_yellow\"><a href=\"room.php?name=Tiến lên MNDC - " . $key . " - " . $room["name"] . "&id=" . $room["id"] . "\">" . $room["online"] . "/" . $room["limit"] . "</a></div>";
			                            } else {
			                                echo "<div class=\"room_box_body room_red\"><a href=\"room.php?name=Tiến lên MNDC - " . $key . " - " . $room["name"] . "&id=" . $room["id"] . "\">" . $room["online"] . "/" . $room["limit"] . "</a></div>";
			                            }
			                            echo "</div>";
			                        }
			                    }
			                    ?>
		                	</td>
		                	<td>
			                	<?php
			                    foreach ($caroKey as $key) {
			                        echo "<div class=\"room_title\">Caro " . $caro["playingTable"] . "</div>";
			                        foreach ($caro[$key] as $room) {
			                            echo "<div class=\"room_box\">";
			                            echo "<div class=\"room_box_title room_dark\"><a href=\"room.php?name=Caro - " . $key . " - " . $room["name"] . "&id=" . $room["id"] . "\">" . $room["name"] . "</a></div>";
			                            if ($room["online"] <= $room["limit"] / 2) {
			                                echo "<div class=\"room_box_body room_green\"><a href=\"room.php?name=Caro - " . $key . " - " . $room["name"] . "&id=" . $room["id"] . "\">" . $room["online"] . "/" . $room["limit"] . "</a></div>";
			                            } else if ($room["online"] <= $room["limit"] / 4 * 3) {
			                                echo "<div class=\"room_box_body room_yellow\"><a href=\"room.php?name=Caro - " . $key . " - " . $room["name"] . "&id=" . $room["id"] . "\">" . $room["online"] . "/" . $room["limit"] . "</a></div>";
			                            } else {
			                                echo "<div class=\"room_box_body room_red\"><a href=\"room.php?name=Caro - " . $key . " - " . $room["name"] . "&id=" . $room["id"] . "\">" . $room["online"] . "/" . $room["limit"] . "</a></div>";
			                            }
			                            echo "</div>";
			                        }
			                    }
			                    ?>
		                	</td>
		                	<td>
			                	<?php
			                    foreach ($liengKey as $key) {
			                        echo "<div class=\"room_title\">Liêng " . $lieng["playingTable"] . "</div>";
			                        foreach ($lieng[$key] as $room) {
			                            echo "<div class=\"room_box\">";
			                            echo "<div class=\"room_box_title room_dark\"><a href=\"room.php?name=Lieng - " . $key . " - " . $room["name"] . "&id=" . $room["id"] . "\">" . $room["name"] . "</a></div>";
			                            if ($room["online"] <= $room["limit"] / 2) {
			                                echo "<div class=\"room_box_body room_green\"><a href=\"room.php?name=Lieng - " . $key . " - " . $room["name"] . "&id=" . $room["id"] . "\">" . $room["online"] . "/" . $room["limit"] . "</a></div>";
			                            } else if ($room["online"] <= $room["limit"] / 4 * 3) {
			                                echo "<div class=\"room_box_body room_yellow\"><a href=\"room.php?name=Lieng - " . $key . " - " . $room["name"] . "&id=" . $room["id"] . "\">" . $room["online"] . "/" . $room["limit"] . "</a></div>";
			                            } else {
			                                echo "<div class=\"room_box_body room_red\"><a href=\"room.php?name=Lieng - " . $key . " - " . $room["name"] . "&id=" . $room["id"] . "\">" . $room["online"] . "/" . $room["limit"] . "</a></div>";
			                            }
			                            echo "</div>";
			                        }
			                    }
			                    ?>
		                	</td>
		                	<td>
			                	<?php
			                    foreach ($trieuphuKey as $key) {
			                        echo "<div class=\"room_title\">Olympia " . $trieuphu["playingTable"] . "</div>";
			                        foreach ($trieuphu[$key] as $room) {
			                            echo "<div class=\"room_box\">";
			                            echo "<div class=\"room_box_title room_dark\"><a href=\"room.php?name=Olympia - " . $key . " - " . $room["name"] . "&id=" . $room["id"] . "\">" . $room["name"] . "</a></div>";
			                            if ($room["online"] <= $room["limit"] / 2) {
			                                echo "<div class=\"room_box_body room_green\"><a href=\"room.php?name=Olympia - " . $key . " - " . $room["name"] . "&id=" . $room["id"] . "\">" . $room["online"] . "/" . $room["limit"] . "</a></div>";
			                            } else if ($room["online"] <= $room["limit"] / 4 * 3) {
			                                echo "<div class=\"room_box_body room_yellow\"><a href=\"room.php?name=Olympia - " . $key . " - " . $room["name"] . "&id=" . $room["id"] . "\">" . $room["online"] . "/" . $room["limit"] . "</a></div>";
			                            } else {
			                                echo "<div class=\"room_box_body room_red\"><a href=\"room.php?name=Olympia - " . $key . " - " . $room["name"] . "&id=" . $room["id"] . "\">" . $room["online"] . "/" . $room["limit"] . "</a></div>";
			                            }
			                            echo "</div>";
			                        }
			                    }
			                    ?>
		                	</td>
		                	<td>
			                	<?php
			                    foreach ($samKey as $key) {
			                        echo "<div class=\"room_title\">Sâm " . $sam["playingTable"] . "</div>";
			                        foreach ($sam[$key] as $room) {
			                            echo "<div class=\"room_box\">";
			                            echo "<div class=\"room_box_title room_dark\"><a href=\"room.php?name=Olympia - " . $key . " - " . $room["name"] . "&id=" . $room["id"] . "\">" . $room["name"] . "</a></div>";
			                            if ($room["online"] <= $room["limit"] / 2) {
			                                echo "<div class=\"room_box_body room_green\"><a href=\"room.php?name=Olympia - " . $key . " - " . $room["name"] . "&id=" . $room["id"] . "\">" . $room["online"] . "/" . $room["limit"] . "</a></div>";
			                            } else if ($room["online"] <= $room["limit"] / 4 * 3) {
			                                echo "<div class=\"room_box_body room_yellow\"><a href=\"room.php?name=Olympia - " . $key . " - " . $room["name"] . "&id=" . $room["id"] . "\">" . $room["online"] . "/" . $room["limit"] . "</a></div>";
			                            } else {
			                                echo "<div class=\"room_box_body room_red\"><a href=\"room.php?name=Olympia - " . $key . " - " . $room["name"] . "&id=" . $room["id"] . "\">" . $room["online"] . "/" . $room["limit"] . "</a></div>";
			                            }
			                            echo "</div>";
			                        }
			                    }
			                    ?>
		                	</td>
	                	</tr>
                	</table>
                    
                </div>
            </div>
            
            
            <div class="box grid">
                <div class="box_header">
                    <a href="javascript:void(0);">Trà Sữa</a>
                </div>
                <div class="box_body" style="display:none;">
                	<table>
	                	<tr>
		                	<td>
			                	<?php
			                    foreach ($phomKey2 as $key) {
			                        echo "<div class=\"room_title\">Phỏm " . $phom2["playingTable"] . "</div>";
			                        foreach ($phom2[$key] as $room) {
			                            echo "<div class=\"room_box\">";
			                            echo "<div class=\"room_box_title room_dark\"><a href=\"room.php?name=Phỏm - " . $key . " - " . $room["name"] . "&id=" . $room["id"] . "\">" . $room["name"] . "</a></div>";
			                            if ($room["online"] <= $room["limit"] / 2) {
			                                echo "<div class=\"room_box_body room_green\"><a href=\"room.php?name=Phỏm - " . $key . " - " . $room["name"] . "&id=" . $room["id"] . "\">" . $room["online"] . "/" . $room["limit"] . "</a></div>";
			                            } else if ($room["online"] <= $room["limit"] / 4 * 3) {
			                                echo "<div class=\"room_box_body room_yellow\"><a href=\"room.php?name=Phỏm - " . $key . " - " . $room["name"] . "&id=" . $room["id"] . "\">" . $room["online"] . "/" . $room["limit"] . "</a></div>";
			                            } else {
			                                echo "<div class=\"room_box_body room_red\"><a href=\"room.php?name=Phỏm - " . $key . " - " . $room["name"] . "&id=" . $room["id"] . "\">" . $room["online"] . "/" . $room["limit"] . "</a></div>";
			                            }
			                            echo "</div>";
			                        }
			                    }
			                    ?>
		                	</td>
		                	<td>
			                	<?php
			                    foreach ($bacayKey2 as $key) {
			                        echo "<div class=\"room_title\">Ba cây " . $bacay2["playingTable"] . "</div>";
			                        foreach ($bacay2[$key] as $room) {
			                            echo "<div class=\"room_box\">";
			                            echo "<div class=\"room_box_title room_dark\"><a href=\"room.php?name=Ba cây - " . $key . " - " . $room["name"] . "&id=" . $room["id"] . "\">" . $room["name"] . "</a></div>";
			                            if ($room["online"] <= $room["limit"] / 2) {
			                                echo "<div class=\"room_box_body room_green\"><a href=\"room.php?name=Ba cây - " . $key . " - " . $room["name"] . "&id=" . $room["id"] . "\">" . $room["online"] . "/" . $room["limit"] . "</a></div>";
			                            } else if ($room["online"] <= $room["limit"] / 4 * 3) {
			                                echo "<div class=\"room_box_body room_yellow\"><a href=\"room.php?name=Ba cây - " . $key . " - " . $room["name"] . "&id=" . $room["id"] . "\">" . $room["online"] . "/" . $room["limit"] . "</a></div>";
			                            } else {
			                                echo "<div class=\"room_box_body room_red\"><a href=\"room.php?name=Ba cây - " . $key . " - " . $room["name"] . "&id=" . $room["id"] . "\">" . $room["online"] . "/" . $room["limit"] . "</a></div>";
			                            }
			                            echo "</div>";
			                        }
			                    }
			                    ?>
		                	</td>
		                	<td>
        	                    <?php
								foreach ($bacaynewKey2 as $key) {
								    echo "<div class=\"room_title\">Ba cây mới </div>";
								    foreach ($bacaynew2[$key] as $room) {
								        echo "<div class=\"room_box\">";
								        echo "<div class=\"room_box_title room_dark\"><a href=\"room.php?name=Ba cây - " . $key . " - " . $room["name"] . "&id=" . $room["id"] . "\">" . $room["name"] . "</a></div>";
								        if ($room["online"] <= $room["limit"] / 2) {
								            echo "<div class=\"room_box_body room_green\"><a href=\"room.php?name=Ba cây - " . $key . " - " . $room["name"] . "&id=" . $room["id"] . "\">" . $room["online"] . "/" . $room["limit"] . "</a></div>";
								        } else if ($room["online"] <= $room["limit"] / 4 * 3) {
								            echo "<div class=\"room_box_body room_yellow\"><a href=\"room.php?name=Ba cây - " . $key . " - " . $room["name"] . "&id=" . $room["id"] . "\">" . $room["online"] . "/" . $room["limit"] . "</a></div>";
								        } else {
								            echo "<div class=\"room_box_body room_red\"><a href=\"room.php?name=Ba cây - " . $key . " - " . $room["name"] . "&id=" . $room["id"] . "\">" . $room["online"] . "/" . $room["limit"] . "</a></div>";
								        }
								        echo "</div>";
								    }
								}
								?>
		                	</td>
		                	<td>
			                    <?php
			                    foreach ($tienlenmbKey2 as $key) {
			                        echo "<div class=\"room_title\">TLMB " . $tienlenmb2["playingTable"] . "</div>";
			                        foreach ($tienlenmb2[$key] as $room) {
			                            echo "<div class=\"room_box\">";
			                            echo "<div class=\"room_box_title room_dark\"><a href=\"room.php?name=Tiến lên MB - " . $key . " - " . $room["name"] . "&id=" . $room["id"] . "\">" . $room["name"] . "</a></div>";
			                            if ($room["online"] <= $room["limit"] / 2) {
			                                echo "<div class=\"room_box_body room_green\"><a href=\"room.php?name=Tiến lên MB - " . $key . " - " . $room["name"] . "&id=" . $room["id"] . "\">" . $room["online"] . "/" . $room["limit"] . "</a></div>";
			                            } else if ($room["online"] <= $room["limit"] / 4 * 3) {
			                                echo "<div class=\"room_box_body room_yellow\"><a href=\"room.php?name=Tiến lên MB - " . $key . " - " . $room["name"] . "&id=" . $room["id"] . "\">" . $room["online"] . "/" . $room["limit"] . "</a></div>";
			                            } else {
			                                echo "<div class=\"room_box_body room_red\"><a href=\"room.php?name=Tiến lên MB - " . $key . " - " . $room["name"] . "&id=" . $room["id"] . "\">" . $room["online"] . "/" . $room["limit"] . "</a></div>";
			                            }
			                            echo "</div>";
			                        }
			                    }
			                    ?>
		                	</td>
		                	<td>
			                	<?php
			                    foreach ($tienlenmnKey2 as $key) {
			                        echo "<div class=\"room_title\">TLMN " . $tienlenmn2["playingTable"] . "</div>";
			                        foreach ($tienlenmn2[$key] as $room) {
			                            echo "<div class=\"room_box\">";
			                            echo "<div class=\"room_box_title room_dark\"><a href=\"room.php?name=Tiến lên MN - " . $key . " - " . $room["name"] . "&id=" . $room["id"] . "\">" . $room["name"] . "</a></div>";
			                            if ($room["online"] <= $room["limit"] / 2) {
			                                echo "<div class=\"room_box_body room_green\"><a href=\"room.php?name=Tiến lên MN - " . $key . " - " . $room["name"] . "&id=" . $room["id"] . "\">" . $room["online"] . "/" . $room["limit"] . "</a></div>";
			                            } else if ($room["online"] <= $room["limit"] / 4 * 3) {
			                                echo "<div class=\"room_box_body room_yellow\"><a href=\"room.php?name=Tiến lên MN - " . $key . " - " . $room["name"] . "&id=" . $room["id"] . "\">" . $room["online"] . "/" . $room["limit"] . "</a></div>";
			                            } else {
			                                echo "<div class=\"room_box_body room_red\"><a href=\"room.php?name=Tiến lên MN - " . $key . " - " . $room["name"] . "&id=" . $room["id"] . "\">" . $room["online"] . "/" . $room["limit"] . "</a></div>";
			                            }
			                            echo "</div>";
			                        }
			                    }
			                    ?>
		                	</td>
		                	<td>
			                	 <?php
			                    foreach ($tienlenmndcKey2 as $key) {
			                        echo "<div class=\"room_title\">TLMNDC </div>";
			                        foreach ($tienlenmndc2[$key] as $room) {
			                            echo "<div class=\"room_box\">";
			                            echo "<div class=\"room_box_title room_dark\"><a href=\"room.php?name=Tiến lên MNDC - " . $key . " - " . $room["name"] . "&id=" . $room["id"] . "\">" . $room["name"] . "</a></div>";
			                            if ($room["online"] <= $room["limit"] / 2) {
			                                echo "<div class=\"room_box_body room_green\"><a href=\"room.php?name=Tiến lên MNDC - " . $key . " - " . $room["name"] . "&id=" . $room["id"] . "\">" . $room["online"] . "/" . $room["limit"] . "</a></div>";
			                            } else if ($room["online"] <= $room["limit"] / 4 * 3) {
			                                echo "<div class=\"room_box_body room_yellow\"><a href=\"room.php?name=Tiến lên MNDC - " . $key . " - " . $room["name"] . "&id=" . $room["id"] . "\">" . $room["online"] . "/" . $room["limit"] . "</a></div>";
			                            } else {
			                                echo "<div class=\"room_box_body room_red\"><a href=\"room.php?name=Tiến lên MNDC - " . $key . " - " . $room["name"] . "&id=" . $room["id"] . "\">" . $room["online"] . "/" . $room["limit"] . "</a></div>";
			                            }
			                            echo "</div>";
			                        }
			                    }
			                    ?>
		                	</td>
		                	<td>
			                	<?php
			                    foreach ($caroKey2 as $key) {
			                        echo "<div class=\"room_title\">Caro " . $caro2["playingTable"] . "</div>";
			                        foreach ($caro2[$key] as $room) {
			                            echo "<div class=\"room_box\">";
			                            echo "<div class=\"room_box_title room_dark\"><a href=\"room.php?name=Caro - " . $key . " - " . $room["name"] . "&id=" . $room["id"] . "\">" . $room["name"] . "</a></div>";
			                            if ($room["online"] <= $room["limit"] / 2) {
			                                echo "<div class=\"room_box_body room_green\"><a href=\"room.php?name=Caro - " . $key . " - " . $room["name"] . "&id=" . $room["id"] . "\">" . $room["online"] . "/" . $room["limit"] . "</a></div>";
			                            } else if ($room["online"] <= $room["limit"] / 4 * 3) {
			                                echo "<div class=\"room_box_body room_yellow\"><a href=\"room.php?name=Caro - " . $key . " - " . $room["name"] . "&id=" . $room["id"] . "\">" . $room["online"] . "/" . $room["limit"] . "</a></div>";
			                            } else {
			                                echo "<div class=\"room_box_body room_red\"><a href=\"room.php?name=Caro - " . $key . " - " . $room["name"] . "&id=" . $room["id"] . "\">" . $room["online"] . "/" . $room["limit"] . "</a></div>";
			                            }
			                            echo "</div>";
			                        }
			                    }
			                    ?>
		                	</td>
		                	<td>
			                	<?php
			                    foreach ($liengKey2 as $key) {
			                        echo "<div class=\"room_title\">Liêng " . $lieng2["playingTable"] . "</div>";
			                        foreach ($lieng2[$key] as $room) {
			                            echo "<div class=\"room_box\">";
			                            echo "<div class=\"room_box_title room_dark\"><a href=\"room.php?name=Lieng - " . $key . " - " . $room["name"] . "&id=" . $room["id"] . "\">" . $room["name"] . "</a></div>";
			                            if ($room["online"] <= $room["limit"] / 2) {
			                                echo "<div class=\"room_box_body room_green\"><a href=\"room.php?name=Lieng - " . $key . " - " . $room["name"] . "&id=" . $room["id"] . "\">" . $room["online"] . "/" . $room["limit"] . "</a></div>";
			                            } else if ($room["online"] <= $room["limit"] / 4 * 3) {
			                                echo "<div class=\"room_box_body room_yellow\"><a href=\"room.php?name=Lieng - " . $key . " - " . $room["name"] . "&id=" . $room["id"] . "\">" . $room["online"] . "/" . $room["limit"] . "</a></div>";
			                            } else {
			                                echo "<div class=\"room_box_body room_red\"><a href=\"room.php?name=Lieng - " . $key . " - " . $room["name"] . "&id=" . $room["id"] . "\">" . $room["online"] . "/" . $room["limit"] . "</a></div>";
			                            }
			                            echo "</div>";
			                        }
			                    }
			                    ?>
		                	</td>
		                	<td>
			                	<?php
			                    foreach ($trieuphuKey2 as $key) {
			                        echo "<div class=\"room_title\">Olympia " . $trieuphu2["playingTable"] . "</div>";
			                        foreach ($trieuphu2[$key] as $room) {
			                            echo "<div class=\"room_box\">";
			                            echo "<div class=\"room_box_title room_dark\"><a href=\"room.php?name=Olympia - " . $key . " - " . $room["name"] . "&id=" . $room["id"] . "\">" . $room["name"] . "</a></div>";
			                            if ($room["online"] <= $room["limit"] / 2) {
			                                echo "<div class=\"room_box_body room_green\"><a href=\"room.php?name=Olympia - " . $key . " - " . $room["name"] . "&id=" . $room["id"] . "\">" . $room["online"] . "/" . $room["limit"] . "</a></div>";
			                            } else if ($room["online"] <= $room["limit"] / 4 * 3) {
			                                echo "<div class=\"room_box_body room_yellow\"><a href=\"room.php?name=Olympia - " . $key . " - " . $room["name"] . "&id=" . $room["id"] . "\">" . $room["online"] . "/" . $room["limit"] . "</a></div>";
			                            } else {
			                                echo "<div class=\"room_box_body room_red\"><a href=\"room.php?name=Olympia - " . $key . " - " . $room["name"] . "&id=" . $room["id"] . "\">" . $room["online"] . "/" . $room["limit"] . "</a></div>";
			                            }
			                            echo "</div>";
			                        }
			                    }
			                    ?>
		                	</td>
		                	<td>
			                	<?php
			                    foreach ($samKey2 as $key) {
			                        echo "<div class=\"room_title\">Sâm " . $sam2["playingTable"] . "</div>";
			                        foreach ($sam2[$key] as $room) {
			                            echo "<div class=\"room_box\">";
			                            echo "<div class=\"room_box_title room_dark\"><a href=\"room.php?name=Olympia - " . $key . " - " . $room["name"] . "&id=" . $room["id"] . "\">" . $room["name"] . "</a></div>";
			                            if ($room["online"] <= $room["limit"] / 2) {
			                                echo "<div class=\"room_box_body room_green\"><a href=\"room.php?name=Olympia - " . $key . " - " . $room["name"] . "&id=" . $room["id"] . "\">" . $room["online"] . "/" . $room["limit"] . "</a></div>";
			                            } else if ($room["online"] <= $room["limit"] / 4 * 3) {
			                                echo "<div class=\"room_box_body room_yellow\"><a href=\"room.php?name=Olympia - " . $key . " - " . $room["name"] . "&id=" . $room["id"] . "\">" . $room["online"] . "/" . $room["limit"] . "</a></div>";
			                            } else {
			                                echo "<div class=\"room_box_body room_red\"><a href=\"room.php?name=Olympia - " . $key . " - " . $room["name"] . "&id=" . $room["id"] . "\">" . $room["online"] . "/" . $room["limit"] . "</a></div>";
			                            }
			                            echo "</div>";
			                        }
			                    }
			                    ?>
		                	</td>
	                	</tr>
                	</table>
                    
                </div>
            </div>
        </div>
    </body>
</html>