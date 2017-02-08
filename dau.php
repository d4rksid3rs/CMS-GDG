<?php
$today = date('Y-m-d');
if (!isset($_GET['toDate'])) {
    $toDate = $today;
} else {
    $toDate = $_GET['toDate'];
}
if (!isset($_GET['fromDate'])) {
    $fromDate = date ("Y-m-d", strtotime("-7 day", strtotime($today)));
} else {
    $fromDate = $_GET['fromDate'];
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="content-type" content="text/html; charset=utf-8"/>

        <title>DAU</title>
        <?php require('header.php'); ?>
        <script>
            $(document).ready(function () {
               $(".datepicker").datepicker();
            });
        </script>
        <script type="text/javascript">
            google.load('visualization', '1', {packages: ['corechart']});
        </script>
        <script type="text/javascript">
            $(document).ready(function () {
                $(".datepicker").datepicker();
            });
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
                <div class="box_header"><a href="javascript:void(0);"><?php echo "Thống kê DAU"; ?></a></div>
                <div class="box_body">
                    <div style="padding-left:10px; text-align:center;">
                        <form action="" method="GET">
                            Từ ngày 
                            <input type="text" class="datepicker" name="fromDate" style="text-align: center; width: 100px;" value="<?php echo $fromDate; ?>"/> 
                            Tới ngày 
                            <input type="text" class="datepicker" name="toDate" style="text-align: center; width: 100px;" value="<?php echo $toDate; ?>"/> 
                            <input type="submit" value="Cập nhật" class="input_button"/>
                        </form>
                    </div>
                    <table width=100%>
                        <tr>
                            <td colspan="2">Hệ thống</td>
                        </tr>
                        <tr>

                            <td width=50% align=center><div>Đăng ky</div><div><iframe height="350px" width="100%" frameBorder="0" src="dau_data.php?fromDate=<?php echo $fromDate; ?>&toDate=<?php echo $toDate; ?>">your browser does not support IFRAMEs</iframe></div></td>
                            <td width=50% align=center><div>Đăng nhập</div><div><iframe height="350px" width="100%" frameBorder="0" src="dau1.php?fromDate=<?php echo $fromDate; ?>&toDate=<?php echo $toDate; ?>">your browser does not support IFRAMEs</iframe></div></td>
                        </tr>
                        <tr>
                            <td colspan="2">OS</td>
                        </tr>
                        <tr>
                            <td width=50% align=center><iframe height="450px" width="100%" frameBorder="0" src="dauos.php?fromDate=<?php echo $fromDate; ?>&toDate=<?php echo $toDate; ?>">your browser does not support IFRAMEs</iframe></td>
                            <td width=50% align=center><iframe height="450px" width="100%" frameBorder="0" src="dauos1.php?fromDate=<?php echo $fromDate; ?>&toDate=<?php echo $toDate; ?>">your browser does not support IFRAMEs</iframe></td>
                        </tr>
                        <tr>
                            <td colspan="2">Version</td>
                        </tr>
                        <tr>
                            <td width=50% align=center><iframe height="345px" width="100%" frameBorder="0" src="dauversion.php?fromDate=<?php echo $fromDate; ?>&toDate=<?php echo $toDate; ?>">your browser does not support IFRAMEs</iframe></td>
                            <td width=50% align=center><iframe height="345px" width="100%" frameBorder="0" src="dauversion1.php?fromDate=<?php echo $fromDate; ?>&toDate=<?php echo $toDate; ?>">your browser does not support IFRAMEs</iframe></td>
                        </tr>
                    </table>

                </div>
            </div>

        </div>
    </body>
</html>
​