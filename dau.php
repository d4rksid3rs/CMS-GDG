<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
   
    <title>DAU</title>
        <?php require('header.php'); ?>
 
    <script type="text/javascript">
      google.load('visualization', '1', {packages: ['corechart']});
    </script>
    <script type="text/javascript">
      function drawVisualization() {
        // Create and populate the data table.
        var data = google.visualization.arrayToDataTable(<?php echo json_encode($table); ?>);
      
        // Create and draw the visualization.
        new google.visualization.LineChart(document.getElementById('visualization')).
            draw(data, {curveType: "function",
                        width: 500, height: 300,
                        vAxis: {maxValue: 10, viewWindowMode: "explicit", viewWindow:{ min: 0 }}}
                );
      }
      

      google.setOnLoadCallback(drawVisualization);
    </script>
  </head>
  <body>
  
  <div class="pagewrap">
            <?php require('topMenu.php'); ?>
            

            <div class="box grid">
                <div class="box_header"><a href="javascript:void(0);"><?php echo "Thống kê DAU"; ?></a></div>
                <div class="box_body">
                   
	<table width=100%>
		<tr>
			<td colspan="2">Hệ thống</td>
		</tr>
		<tr>

			<td width=50% align=center><div>Đăng ky</div><div><iframe height="350px" width="100%" frameBorder="0" src="dau_data.php">your browser does not support IFRAMEs</iframe></div></td>
			<td width=50% align=center><div>Đăng nhập</div><div><iframe height="350px" width="100%" frameBorder="0" src="dau1.php">your browser does not support IFRAMEs</iframe></div></td>
		</tr>
		<tr>
			<td colspan="2">OS</td>
		</tr>
		<tr>
			<td colspan=2 align=center><iframe height="450px" width="100%" frameBorder="0" src="dauos.php">your browser does not support IFRAMEs</iframe></td>
		</tr>
		<tr>
			<td colspan="2">Version</td>
		</tr>
		<tr>
			<td colspan=2 align=center><iframe height="345px" width="100%" frameBorder="0" src="dauversion.php">your browser does not support IFRAMEs</iframe></td>
		</tr>
	</table>
	
	 </div>
            </div>

        </div>
  </body>
</html>
​