<?php
function formatdate($date){

$pos = strrpos($date, "-");

return substr($date,$pos+1);

}


?>