<?php
$host="127.0.0.1:3307";
$user="megatron";
$password="optimus2771983";

mysql_connect($host,$user,$password);
mysql_select_db("logsms");
$s = mysql_query("SELECT * FROM cskh WHERE flag = 0 ORDER BY created_on");
$i = 1;
$content = "";
$arr = array();
while($r = mysql_fetch_assoc($s))
{
	$arr[] = $r['id'];
	$content .= $i.': <br />';
	$content .= 'Số điện thoại: '.$r['sender'].'<br />';
	$content .= 'Nội dung: '.$r['mo'].'<br />';
	$content .= 'Ngày giờ: '. date('H:i:s d-m-Y', strtotime($r['created_on'])).'<br /><br />'; 
}
foreach($arr as $id)
{
	$sql = 'UPDATE cskh SET flag = 1 WHERE id = '. $id;
	mysql_query($sql);
}
domail($content);

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

    $mail->SetFrom('lamnhanvodanh@gmail.com', 'BEM CSKH');

    $mail->AddReplyTo("lamnhanvodanh@gmail.com","BEM CSKH");

    $mail->Subject    = "[SMS] Chăm sóc khách hàng";



    $mail->MsgHTML($body);

	$mAddress = explode(",", "quan@k2tek.net,ha@k2tek.net,bao@k2tek.net,kien@k2tek.net,nguyetdt@mvdigital.vn,lam@k2tek.net"); 
	$mName = explode(",", "Quan,Ha,Bao,Kien,Nguyet,Lam"); 
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