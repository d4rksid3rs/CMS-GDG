<?php
$obj = new stdClass();

$filename = "data.txt";
$fp = fopen( $filename, "r" ) or die("Couldn't open $filename");
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

foreach ($source as $line) {
	if (substr($line, 0,1) != "#") {
		while (strpos($line, "  ") != false) {
			$line = str_replace("  ", " ", $line);
		}
		$tmp = explode(" ", $line);
		if (isset($ret[$tmp[6]])) {
			$ret[$tmp[6]]++;
		} else {
			$ret[$tmp[6]] = 1;	
		}
		if ($ret[$tmp[6]] > $max) {
			$max = $ret[$tmp[6]];
		};
	}
}
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

exit(json_encode($obj));

/*
$count = 0;
$keys = array_keys($ret);
foreach ($keys as $key) {
	echo $key." ".$ret[$key]."<br>";
}
*/
?>