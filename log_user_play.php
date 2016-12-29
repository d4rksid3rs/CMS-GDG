<?php
$today = date('Y-m-d', time());
?>
<!DOCTYPE html>
<html>
    <head>
        <!--<title><?php echo $title; ?></title>-->
        <title>Thống kê Log chơi game</title>
        <?php require('header.php'); ?>
        <script>
            function getLogKoin(type) {
                var username = $("#logKoin input[name=username]").val();
                var fromdate = $("#logKoin input[name=fromDateKoin]").val();
                var todate = $("#logKoin input[name=toDateKoin]").val();
                $.ajax({
                    type: "GET",
                    url: "API/getLogKoin.php",
                    data: {
                        "username": username,
                        "fromdate": fromdate,
                        "todate": todate,
                        "type": type
                    },
                    dataType: 'text',
                    success: function (msg) {
                        $("#logKoinResult").html(msg);
                        $("#logKoinResult").show();
                    },
                    failure: function () {
                        $("#exchangeUserList").html("<span>Không truy cập được dữ liệu</span>");
                        $("#btnFindListUser").attr("disabled", false);
                    }
                });
            }
            
            $("a.pagination-link-log").live("click", function (e) {
                e.preventDefault();
                var page = $(this).attr('page');
                var username = $("#logKoin input[name=username]").val();
                var fromdate = $("#logKoin input[name=fromDateKoin]").val();
                var todate = $("#logKoin input[name=toDateKoin]").val();
                var type = $(this).attr('type');
                $.ajax({
                    type: "GET",
                    url: "API/getLogKoin.php",
                    data: {
                        "page": page,
                        "username": username,
                        "fromdate": fromdate,
                        "todate": todate,
                        "type": type
                    },
                    dataType: 'text',
                    success: function (msg) {
                        $("#logKoinResult").html(msg);
                        $("#logKoinResult").show();
                    },
                    failure: function () {
                        $("#exchangeUserList").html("<span>Không truy cập được dữ liệu</span>");
                        $("#btnFindListUser").attr("disabled", false);
                    }
                });                        
            });
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
                <div class="box_header"><a href="javascript:void(0);">Xem log chơi Xu/Chip của Người chơi</a></div>
                <div class="box_body" style="display: none">
                    <form id="logKoin">
                        Từ Ngày
                        <input type="text" class="datepicker" name="fromDateKoin" value="<?php echo $today; ?>" style="text-align: center; width: 100px;" />
                        Đến Ngày
                        <input type="text" class="datepicker" name="toDateKoin" value="<?php echo $today; ?>" style="text-align: center; width: 100px;" />
                        Username:
                        <input type="text" name="username" value="" />
                        <input type="button" name="add" value="Log Chơi (Xu)" onclick="getLogKoin(1);"/>
                        <input type="button" name="add" value="Lop Chơi (Chip)" onclick="getLogKoin(2);"/>

                    </form>
                </div>
                <div id="logKoinResult" style="display: none;">                    
                </div>
            </div>

        </div>
    </body>
</html>

