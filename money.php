<?php
$handle = @fopen("/home/k2tek/a.txt", "r");
echo $handle;
if ($handle) {
    while (($buffer = fgets($handle, 4096)) !== false) {
        echo $buffer;
    }
    if (!feof($handle)) {
        echo "Error: unexpected fgets() fail\n";
    }
    fclose($handle);
} else {
	echo "a";
}
?>