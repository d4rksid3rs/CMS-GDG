<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="content-type" content="text/html; charset=utf-8"/>

        <!--<title><?php // echo $title; ?></title>-->
        <title>Thống Kê Doanh thu</title>
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
                            vAxis: {maxValue: 10, viewWindowMode: "explicit", viewWindow: {min: 0}}}
                        );
            }


            google.setOnLoadCallback(drawVisualization);
        </script>
    </head>
    <body>

        <div class="pagewrap">
            <?php require('topMenu.php'); ?>
            


            <div class="box grid">
                <?php require_once('topMenu.sub2.php'); ?>
                <div class="box_header"><a href="javascript:void(0);"><?php echo "Bien dong doanh thu"; ?></a></div>
                <div class="box_body">

                    <table width=100%>
<!--                        <tr>
                            <td colspan="2">Kenh thanh toan MV</td>
                        </tr>
                        <tr>

                            <td width=50% align=center><div>The cao MV</div><div><iframe height="350px" width="100%" frameBorder="0" src="rev_data.php?type=3">your browser does not support IFRAMEs</iframe></div></td>
                            <td width=50% align=center><div>SMS MV</div><div><iframe height="350px" width="100%" frameBorder="0" src="rev_data.php?type=1">your browser does not support IFRAMEs</iframe></div></td>
                        </tr>-->
                        <tr>
                            <td colspan="2">Kenh thanh toan doi tac</td>
                        </tr>
                        <tr>
                            <td width=50% align=center><div>The cao</div><div><iframe height="350px" width="100%" frameBorder="0" src="rev_data.php?type=2">your browser does not support IFRAMEs</iframe></div></td>
                            <td width=50% align=center><div>IAP</div><div><iframe height="350px" width="100%" frameBorder="0" src="rev_data.php?type=4">your browser does not support IFRAMEs</iframe></div></td>
                        </tr>

                    </table>

                </div>
            </div>

        </div>
    </body>
</html>
​