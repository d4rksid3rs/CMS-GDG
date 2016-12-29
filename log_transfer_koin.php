<?php
$today = date('Y-m-d', time());
?>
<!DOCTYPE html>
<html>
    <head>
        <!--<title><?php echo $title; ?></title>-->
        <title>Log chuyển xu</title>
        <?php require('header.php'); ?>
        <script>
            function getLogTransfer() {
                var fromDate = $("#logTrans input[name=fromDateKoin]").val();
                var toDate = $("#logTrans input[name=toDateKoin]").val();
                $.ajax({
                    type: "GET",
                    url: "API/getLogTransfer.php",
                    data: {
                        "fromDate": fromDate,
                        "toDate": toDate
                    },
                    dataType: 'text',
                    success: function (msg) {
                        $("#logTransResult").html(msg);
                        $("#logTransResult").show();
                    },
                    failure: function () {
                        $("#logTransResult").html("<span>Không truy cập được dữ liệu</span>");
                    }
                });
            }
                        
            $(document).ready(function () {
                $(".datepicker").datepicker();                
            });
        </script>




    </head>
    <body>   
        <div class="pagewrap">
            <?php require('topMenu.php'); ?>
            <div class="box grid">
                <?php include('topMenu.koin.php'); ?>                
                <div class="box_body">
                    <form id="logTrans">
                        Từ Ngày
                        <input type="text" class="datepicker" name="fromDateKoin" value="<?php echo $today; ?>" style="text-align: center; width: 100px;" /> (00:00:00)
                        Đến Ngày
                        <input type="text" class="datepicker" name="toDateKoin" value="<?php echo $today; ?>" style="text-align: center; width: 100px;" /> (23:59:59)                                                
                        <input type="button" name="add" value="Thống kê" onclick="getLogTransfer();"/>

                    </form>
                </div>
                <div id="logTransResult" style="display: none;">                    
                </div>
            </div>

        </div>
    </body>
</html>

