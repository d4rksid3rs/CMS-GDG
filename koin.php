<!DOCTYPE html>
<html>
    <head>
        <!--<title><?php echo $title; ?></title>-->
        <title>Thống kế Tiền trong Game</title>
        <?php require('header.php'); ?>
        <script>
            $(document).ready(function () {
                $("#datepicker1").datepicker();
                $("#datepicker2").datepicker();
            });
        </script>




    </head>
    <body>   
        <div class="pagewrap">
            <?php require('topMenu.php'); ?>
            <div class="box grid">
                <?php include('topMenu.koin.php'); ?>
                <div class="box_header"><a href="javascript:void(0);"><?php echo "Thống kê Koin"; ?></a></div>
                <div class="box_body">
                    <table width="100%">


                        <tr>
                            <td width="50%">
                                <iframe height="370" width="100%" frameBorder="0" src="koin_data.php?change=1">your browser does not support IFRAMEs</iframe>
                            </td>
                            <td width="50%">
                                <iframe height="370" width="100%" frameBorder="0" src="koin_vip_data.php?change=1">your browser does not support IFRAMEs</iframe>
                            </td>
                        </tr>
                        


                    </table>
                </div>
            </div>

        </div>
    </body>
</html>

