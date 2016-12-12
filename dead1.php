<?php
error_reporting(-1);
ini_set('display_errors', 'On');

require('API/socket1.php');
$service = 0xF900;
$input = "{}";
/*
$ret =  sendMessage($service, $input);
if ( strcmp($ret,"DEAD")==0){
	domail("Server Trà Chanh Die");	
} else {
	if (isset($ret) && strlen($ret) > 1000) {
		$jsonData = json_decode($ret);
		if ($jsonData->{'count'} > 300) {
			$filename = "./sdata";
			$fh = fopen($filename, 'w') or die("can't open file");
			fwrite($fh, $ret);
			fclose($fh);
		}
	}
	echo "server1 song===============>";
}*/

$ret =  sendMessage1($service, $input);
if ( strcmp($ret,"DEAD")==0){
	//domail("Server Beme 3 115.84.178.4:6969 Die");	
	//domail("Server Beme 3 115.84.179.241:6868 Die");	
} else {
	if (isset($ret) && strlen($ret) > 1000) {
		$jsonData = json_decode($ret);
		//if ($jsonData->{'count'} > 300) {
			$filename = "./sdata2";
			$fh = fopen($filename, 'w') or die("can't open file");
			fwrite($fh, $ret);
			fclose($fh);
		//}
	}
	echo "server2 song===============>";
}

function domail($body){

	error_reporting(E_STRICT);
    require_once('lib_mail/class.phpmailer.php');


    $mail             = new PHPMailer();

    //$body             = "Server die";
    

    $mail->IsSMTP(); // telling the class to use SMTP
    $mail->SMTPDebug  = 2;                     // enables SMTP debug information (for testing)
                                               // 1 = errors and messages
                                               // 2 = messages only
    $mail->SMTPAuth   = true;                  // enable SMTP authentication
    $mail->SMTPSecure = "tls";                 // sets the prefix to the servier
    $mail->Host       = "smtp.gmail.com";      // sets GMAIL as the SMTP server
    $mail->Port       = 587;                   // set the SMTP port for the GMAIL server
    $mail->Username   = "lamnhanvodanh@gmail.com";  // GMAIL username
    $mail->Password   = "forgetitnow!@#";            // GMAIL password

    $mail->SetFrom('lamnhanvodanh@gmail.com', 'Beme Monitor');

    $mail->AddReplyTo("lamnhanvodanh@gmail.com","Beme Monitor");

    $mail->Subject    = "[Beme] Monitor";



    $mail->MsgHTML($body);

	$mAddress = explode(",", "quan@k2tek.net,ha@k2tek.net,bao@k2tek.net,kien@k2tek.net"); 
	$mName = explode(",", "Quan,Ha,Bao,Kien"); 
	for ($i=0;$i<sizeof($mAddress);$i++) {
		$address = $mAddress[$i];
		$mail->AddAddress($address, $mName[$i]);
		//$mail->AddAttachment("images/phpmailer.gif");      // attachment
		//$mail->AddAttachment("images/phpmailer_mini.gif"); // attachment
	}
	if(!$mail->Send()) {
	  echo "Mailer Error: " . $mail->ErrorInfo;
	} else {
	  echo "Message sent!";
	}
}

?>