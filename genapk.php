<?php
header("Content-type: text/plain");

ob_implicit_flush(true);
ob_end_flush();

//$host="localhost";
//$user="dong";
//$password="dong!@#654";
//mysql_connect($host,$user,$password);
//mysql_select_db("beme_cp");
//
//$sql = "select code from bm_partner";
//$result = mysql_query($sql);
//
//while( $row = mysql_fetch_array($result)){
//    $cpc = $row["code"];
//    $cps = strtolower($cpc);
//	build($cps);
//}

//$arr = array("GTH","MVN","GCT","TAI","COLOA","NETVN","BNN","JAVAVN","T9X","37NET","HOTGHE","KPH","TLAT","VIETBAC","ADVN","KHGM","TYA","XNG","SDG","KPW","BLMV","LSL","KT5A","VT3X","LYC","DLW","GDD","TCH","MSV","HAYCUC","GOCVN","THM18","MTV","V9X","COL","VPR","HSV","VNL","ALV","EGNS","M4U","NVD","NAN","G9X","YEU","VTL","IVI","VHA","Z9X","VINA","TRN","HDY","NHN","QTR","HQA","LNQ","RUA","HSM","V3X","B9X","T2H","TTX","WNL","WBY","W1X","VCH","ZHX","HVT","GDP","WTG","XKK","WCN","WVT","dad","HNN","TH1X","WSV","KS9X","MHP","VND","WTA","KNH","VJV","ISV","WA4G","TT9","TNN","WHN","DWG","AKN","G3X","vodoi","CAU","MNT","SVX","TGT","SVT","TTV","MKX","THN","W8X","MMG","GBG","HYK","HEO","KUY","DPX","HIE","WBM","YOH","LAL","BNG","HLA","XMT","SKT","VANH","MNG","SRP","TMT","DTE","THO","TND","l9x", "huw", "tg9x", "kct", "hor", "vdec", "thm", "tnp", "bsa", "vhp", "tsu", "mvc", "v4g", "olc", "mp", "nty", "d4g", "ymb", "Ihiep", "mad","YWAP","DATTO","TCS","GTRI","DHX","WTAI","MBL","TPL","TNC","GNH","VS9X","TNGK","VTPR","VIPND","MDW","BATGA","TGCDT","TS9X","MLT","SJN","ZNET","PL","MLT1","PPR","24H","LBS2");

//$arr = array("NETVIET","M4ME"); //wap binh thuong

////////////////$arr = array("VMK","VINAMOB","VINAMOB1","VINAMOB2","MLT","MLT1"); //doi ten fie jar bem230
//$arr = array("TOCDO","TOCDO1","TOCDO2","TOCDO3","TOCDO4","TOCDO5","TOCDO6","TOCDO7","TOCDO8","TOCDO9","TOCDO10");


//$arr = array("THINKNET","BLUESEA","GSM","BMT","UPRO","sami","NHTN"); // ko invite


//$arr = array("BMT"); // co refcode

//$x = 1;
//foreach ($arr as $value) {
    //$cp1 = substr($value, 4);
   // $cps = strtolower($value);
	//buildapk($cps,$x);
    //$x++;
//}

$ref = isset($_REQUEST["ref"]) ? $_REQUEST["ref"] : "K2";

$cpcode = strtolower($ref);

//function buildapk($cpcode,$x){
    $path = shell_exec("/home/hung/android_builder/run.sh '$cpcode' '/home/admin/domains/phang.mobi/public_html/bem/$cpcode'");
    
    echo $path;
    
    echo "\n - thanh cong - ".$cpcode."\r\n";
    
//}





?>