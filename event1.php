<?php
$filename = "event.txt";
$fp = fopen( $filename, "r" ) or die("Couldn't open $filename");
$ret = array();
$source = array();
$max = 0;
while ( ! feof( $fp ) ) {
   $line = fgets( $fp, 1024 );
 	if (strlen($line) > 0) {
		$source[] = $line;
	}
   //print $tmp[5]."<br>";
}
sort($source);

foreach ($source as $line) {
	$tmp = explode(" ", $line);
    if (isset($ret[$tmp[5]])) {
		$ret[$tmp[5]]++;
	} else {
		$ret[$tmp[5]] = 1;	
	}
	if ($ret[$tmp[5]] > $max) {$max = $ret[$tmp[5]];};
}
//arsort($ret);
while ($max >0) {
	$keys = array_keys($ret);
	foreach ($keys as $key) {
		if ($max == $ret[$key]) {
			echo $key." ".$ret[$key]."<br>";
		}
	}
	$max--;
}
/*
$count = 0;
$keys = array_keys($ret);
foreach ($keys as $key) {
	echo $key." ".$ret[$key]."<br>";
}
*/
?>