<?php
header("Content-type: text/plain");

ob_implicit_flush(true);
ob_end_flush();

//$arr = array("V9X","COL","VPR","HSV","VNL","ALV","EGNS","M4U","NVD","NAN","G9X","YEU","VTL","IVI","VIET","VHA","Z9X","VINA","TRN","HDY","NHN","QTR","HQA","LNQ","RUA","HSM","V3X","B9X","T2H","TTX","WNL","WBY","W1X","VCH","ZHX","HVT","GDP","WTG","K2","XKK","2K","WCN","WVT","dad","HNN","TH1X","WSV","KS9X","MHP","GM1","GM2","VND","WTA","KNH","VJV","ISV","WA4G","TT9","TNN","WHN","DWG","AKN","G3X","vodoi","CAU","MNT","SVX","TGT","SVT","TTV","MKX","THN","W8X","MMG","GBG","HYK","HEO","KUY","DPX","HIE","WBM","YOH","LAL","BNG","HLA","XMT","SKT","VANH","MNG","SRP","TMT","DTE","THO","TND","PPR","GCN","VQG","LEDG","BOOM","DC4G","VBAC","TAMDI","ATRT","VMG","VNTT","TLTY","VHG","BDP","SVVN","CX95","XL10X");

//$arr = array("DVW");

//$arr = array("NHTN");

//$arr = array("KTVN","DEYEU");

//$arr = array("NKM","HQPH","LBS2","VGT","TRNS","G3XX","WM4U");

$arr = array("A2C19");

$x = 1;
foreach ($arr as $value) {
    //$cp1 = substr($value, 4);
    $cps = strtolower($value);
	buildapk($cps,$x);
    $x++;
}

function buildapk($cpcode,$x){
    $path = shell_exec("/home/hung/android_builder/run2.sh '$cpcode' '/home/dong/bookmark/$cpcode'");
    
    echo $path;
    
    echo "\n".$x." - thanh cong - ".$cpcode."\r\n";
    
}





?>