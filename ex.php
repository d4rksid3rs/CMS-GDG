<?php
/*******EDIT LINES 3-8*******/
require("connectdb_gimwap.php");
$date = date('Y-m-d', strtotime('yesterday'));
if($_POST)
{
$date = $_POST['date'];
$filename = "user$date";

/*******YOU DO NOT NEED TO EDIT ANYTHING BELOW THIS LINE*******/
//create MySQL connection
$sql = "Select recipient,partner, subpartner,SUBSTRING(`message`, 1, LOCATE(' ', `message`) - 1) as username,koin_added,created_on from auth_user_partner WHERE created_on LIKE '$date%' AND service = 'DK' ORDER BY created_on DESC";
//$Connect = @mysql_connect($DB_Server, $DB_Username, $DB_Password) or die("Couldn't connect to MySQL:<br>" . mysql_error() . "<br>" . mysql_errno());
//select database
//$Db = @mysql_select_db($DB_DBName, $Connect) or die("Couldn't select database:<br>" . mysql_error(). "<br>" . mysql_errno());
//execute query
$result = @mysql_query($sql) or die("Couldn't execute query:<br>" . mysql_error(). "<br>" . mysql_errno());
$file_ending = "xls";
 
//header info for browser
header("Content-Type: application/xls;");
header("Content-Disposition: attachment; filename=$filename.xls");
header("Pragma: no-cache");
header("Expires: 0");
 
/*******Start of Formatting for Excel*******/
//define separator (defines columns in excel & tabs in word)
$sep = "\t"; //tabbed character
 
//start of printing column names as names of MySQL fields
/*
for ($i = 0; $i < mysql_num_fields($result); $i++) {
echo mysql_field_name($result,$i) . "\t";
}
*/
//in ten column o day
echo "Username"."\t";
echo "CP"."\t";
echo "Type"."\t";
echo "Koin bonus"."\t";
echo "Time"."\t";
print("\n");
//end of printing column names
 
//start while loop to get data
    while($row = mysql_fetch_assoc($result))
    {
        $schema_insert = "";
        /*
for($j=0; $j<mysql_num_fields($result);$j++)
        {
            if(!isset($row[$j]))
                $schema_insert .= "NULL".$sep;
            elseif ($row[$j] != "")
                $schema_insert .= "$row[$j]".$sep;
            else
                $schema_insert .= "".$sep;
        }
*/
//		var_dump($row);
		$dk = 'Free';
		if(startsWith($row['partner'],'CP1K-'))
		{
			$row['partner'] = substr($row['partner'], 5);
		}
		if($row['recipient'] != '0000')
		{
			$dk = 'SMS';
		}
		$schema_insert .= "*".$row['username'].$sep;
		if($row['subpartner']!="")
			$schema_insert .= $row['partner'].' - '.$row['subpartner'].$sep;
		else
			$schema_insert .= $row['partner'].$sep;
		$schema_insert .= $dk.$sep;
		$schema_insert .= $row['koin_added'].$sep;
		$schema_insert .= $row['created_on'].$sep;
								
        $schema_insert = str_replace($sep."$", "", $schema_insert);
 $schema_insert = preg_replace("/\r\n|\n\r|\n|\r/", " ", $schema_insert);
        $schema_insert .= "\t";
        print(trim($schema_insert));
        print "\n";
    }   
}
function startsWith($haystack, $needle)
{
    return $needle === "" || strpos($haystack, $needle) === 0;
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Thống kê người chơi</title>
        <?php require('header.php'); ?>
         <script>
            $(document).ready(function(){
                $("#datepicker1").datepicker(); // sms
            });
            </script>
    </head>
<body>
        <div class="pagewrap">
            <?php require('topMenu.php'); ?>
			<div class="box">
                <div class="box_header" style="background-image: none;"><a href="javascript:void(0);">Thống kê user</a></div>
                <div class="box_body">
                    <form action="" method="post">
                        Ngày
						<input type="text" id="datepicker1" name="date" style="text-align: center; width: 100px;" value="<?php echo $date;?>"/>
                        <input type="submit" name="add" value="Submit" id='buttonSubmit' />
                    </form>
                </div>
            </div>
        </div>
</body>
    