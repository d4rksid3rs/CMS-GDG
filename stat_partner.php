<?php
include 'cache_begin.php';
include 'util.php';

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$type = isset($_REQUEST['type']) ? trim($_REQUEST['type']) : "";
$fromDate = isset($_REQUEST['fromDate']) ? trim($_REQUEST['fromDate']) : date('Y-m-d');
$toDate = isset($_REQUEST['toDate']) ? trim($_REQUEST['toDate']) : date('Y-m-d');

$chart_title = 'Tổng số lượng user đăng ký';

include 'connectdb_gimwap.php';
$where = "service = 'DK' and test = 0";
if(!empty($fromDate) AND !empty($toDate))
{
    $where .= " and created_on between '$fromDate 00:00:00' and '$toDate 23:59:59'";
    $chart_title .= " : $fromDate -> $toDate";
} else
{
    $fromDate = $toDate = NULL;
}


$join_filed = "";
if (!empty($type)){
	
	$join_get_os =" inner join user ON (user.id=auth_user_partner.auth_user_id) ";
	//if ($type=="j2me") {
	//	$where .=" and platform<>'Android' and platform<>'Apple'";
	//} else {
		$where .=" and os_type = '$type'";
	//}
}
else
{
	$join_get_os =" inner join user ON (user.id=auth_user_partner.auth_user_id) ";
	//if ($type=="j2me") {
	//	$where .=" and platform<>'Android' and platform<>'Apple'";
	//} else {
		$where .=" and os_type IS NOT NULL";
}
$chart_data = array();


$result = mysql_query("
        select partner, count(*) as count
        from auth_user_partner $join_get_os
        where $where
        group by partner
        ");
     
$sum = 0;
while($row = mysql_fetch_assoc($result))
{
    $partner = $row['partner'];
    $count = $row['count'];
    $chart_data[$partner] = $count;
    $sum += $count;
}
$chart_title .= " ($sum)";


?>
<!DOCTYPE html>
<html>
    <head>
        <title>Thống kê user đăng ký</title>
        <?php require('header.php'); ?>
        <script>
            $(document).ready(function(){
                $("#datepicker1").datepicker();
                $("#datepicker2").datepicker();
            }); 
        </script>


        <script type="text/javascript">
            google.load("visualization", "1", {packages:["corechart"]});
            google.setOnLoadCallback(drawChart);
            function drawChart() {
            var data = new google.visualization.DataTable();
            data.addColumn('string', 'Kênh phân phối');
            data.addColumn('number', 'SL user d/k');
            data.addRows([
                <?php
                foreach($chart_data as $k=>$v)
                {

                    echo "['$k : $v', $v],";
                }
                ?>
            ]);

            var options = {
              title: <?php echo "'$chart_title'"; ?>,
              backgroundColor: { fill: "none" },
	      width: 1200
            };

            var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
            chart.draw(data, options);
            }
        </script>

    </head>
    <body>
        <div class="pagewrap">
            <?php require('topMenu.php'); ?>
            <?php
			$pars = '';
			if(!empty($fromDate) OR !empty($toDate))
			{
			    $pars .= "&fromDate=$fromDate&toDate=$toDate";
			}
			$pars .= isset($_REQUEST['nocache']) ? '&nocache' : '';
			
			?>
			<div class="topheader">
			    <ul class="topMenus">
			        Cache tại thời điểm: <?php echo date("Y-m-d H:i:s"); ?> |
			        <a href="ex.php">Xuất thống kê user đăng ký</a>
			        <!--
			        | <a href="stat_partner.php?id=0<?php echo $pars; ?>">Tất cả</a>
			        | <a href="stat_partner.php?id=1<?php echo $pars; ?>">Từ đầu số VMG</a>
			        | <a href="stat_partner.php?id=2<?php echo $pars; ?>">Từ đầu số VMG (Theo sđt)</a>
			        -->
			    </ul>
			</div>


            <div class="box grid">
                <div class="box_header"><a href="javascript:void(0);">Thống kê số lượng user đăng ký</a></div>
                <div class="box_body">
                    <table width="100%">
                        <div style="padding-left:10px;">
                        <form action="" method="post">
                            Từ ngày
                            <input type="text" id="datepicker1" name="fromDate" style="text-align: center; width: 100px;" value="<?php echo $fromDate;?>"/> 
                            (00:00:00)
                            Tới ngày
                            <input type="text" id="datepicker2" name="toDate" style="text-align: center; width: 100px;" value="<?php echo $toDate;?>"/> 
                            (23:59:59)
							<select name="type">
								<option value="" <?php if ($type == "") echo "selected='selected'";?>>Tất cả OS</option>
								<option value="android" <?php if ($type == "android") echo "selected='selected'";?>>android</option>
								<option value="iphone" <?php if ($type == "iphone") echo "selected='selected'";?>>iphone</option>
								<option value="j2me" <?php if ($type == "j2me") echo "selected='selected'";?>>java</option>
							</select>
                            <input type="submit" value="Cập nhật" class="input_button"/>
                        </form>
                        <div id="chart_div" style="width: 900px; height: 500px;"></div>
                    </div>
                    </table>
                </div>
            </div>

        </div>
    </body>
</html>

<?php //include 'cache_end.php'; ?>
