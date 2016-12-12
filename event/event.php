<?php
$obj = new stdClass();


$url = "http://pi.beme.com.vn/textEvent.log";
$fp = file_get_contents( $url) or die("Couldn't load $url");

$source = explode("\n", $fp);

/*
$ret = array();
$source = array();
$max = 0;
while ( ! feof( $fp ) ) {
   $line = fgets( $fp, 1024 );
 	if (strlen($line) > 0) {
		$source[] = $line;
	}
}
sort($source);
*/

foreach ($source as $line) {
	if (strlen($line) > 10 && substr($line, 0,1) != "#") {
		while (strpos($line, "  ") != false) {
			$line = str_replace("  ", " ", $line);
		}
		$line = substr($line, strpos($line, "Add ME") + 6);
		$tmp = explode(" ", $line);
		
		if (isset($ret[$tmp[3]])) {
			$ret[$tmp[3]]++;
		} else {
			$ret[$tmp[3]] = 1;	
		}
		if ($ret[$tmp[3]] > $max) {
			$max = $ret[$tmp[3]];
		};
	}
}

$message = "Top thu thập bộ chữ@@@";
//arsort($ret);
$count = 0;
$winner = array();
while ($max >0) {
	$keys = array_keys($ret);
	foreach ($keys as $key) {
		if ($max == $ret[$key]) {
			$prefix = substr($key, 0, 2);
			$subfix = substr($key, 2);
			$key1 = $key;
			if ($prefix == "fb" && is_numeric($subfix)) {
				$json = json_decode(file_get_contents("http://graph.facebook.com/{$subfix}"));
				$key1 = str_replace(" ","_",$json->name);
			}
			if ($key1 == "") {
				//echo $key." ".$ret[$key]."<br>";
			} else {
				//echo $key1." ".$ret[$key]."<br>";
			}
			
			$winner[] = array("user"=>$key,"name"=>$key1,"number"=>$ret[$key]);
			$message .= ($count + 1).". {$key1}: {$ret[$key]} bộ chữ\n";
			if (++$count == 10) {
				break;
			}
		}
	}
	if ($count == 10) {
		break;
	}
	$max--;
}
$obj->data = $winner;

$f = fopen('./log.txt', 'w') or die("can't open file");
fputs($f, json_encode($obj));
fclose($f);

// Save to system message
try {
	require('db.class.php');
	$sql = "update system_message set content=\"{$message}\" where id=1";
	$db->exec($sql);
} catch (Exception $e) {
	echo "{\"status\":0,\"message\":\"" . $e->getMessage() . "\"}";
}

exit(json_encode($obj));

/*
$count = 0;
$keys = array_keys($ret);
foreach ($keys as $key) {
	echo $key." ".$ret[$key]."<br>";
}
*/
?>