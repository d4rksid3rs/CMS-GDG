<?php
$today = date('Y-m-d', time());
?>
<!DOCTYPE html>
<html>
    <head>
        <title>User Cộng bù Vàng</title>
        <?php require('header.php'); ?>
        <script src="js/highcharts.js" type="text/javascript"></script>
        <script type="text/javascript" src="js/themes/grid.js"></script> 
        <script>
            function getReturnExchange() {
                var fromDate = $("#koin_vip_exchange_return input[name=fromDate]").val();
                var toDate = $("#koin_vip_exchange_return input[name=toDate]").val();

//                $("#btnFindListUser").attr("disabled", true);
                $.ajax({
                    type: "GET",
                    url: "API/getListExchangeReturn.php",
                    data: {
                        "fromDate": fromDate,
                        "toDate": toDate,
                    },
                    dataType: 'text',
                    success: function (msg) {
                        $("#exchangeReturnUserList").html(msg);
                        $("#exchangeReturnUserList").show();
                    },
                    failure: function () {
                        $("#exchangeUserList").html("<span>Không truy cập được dữ liệu</span>");
                        $("#btnFindListUser").attr("disabled", false);
                    }
                });
                $.ajax({
                    type: "GET",
                    url: "API/getTotalExchangeKoin.php",
                    data: {
                        "fromDate": fromDate,
                        "toDate": toDate,
                        "type": 2
                    },
                    dataType: 'text',
                    success: function (msg) {
                        $("#total-koin").html(msg);
                        $("#total-koin").show();
                    },
                    failure: function () {
                        $("#total-koin").html("<span>Không truy cập được dữ liệu</span>");
                        $("#total-koin").attr("disabled", false);
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
                <div class="box_header"><a href="javascript:void(0);">Thống kê Danh sách User cộng bù Vàng</a></div>
                <div class="box_body">
                    <form id="koin_vip_exchange_return">
                        Từ Ngày
                        <input type="text" class="datepicker" value="<?php echo $today; ?>" name="fromDate" style="text-align: center; width: 100px;" />
                        Tới Ngày
                        <input type="text" class="datepicker" value="<?php echo $today; ?>" name="toDate" style="text-align: center; width: 100px;" />
                        <input type="button" name="add" value="Thống kê" onclick="getReturnExchange();"/>
                        <span id="total-koin" style="font-weight: bold; color: #fff;"></span>
                    </form>
                </div>
                <div id="exchangeReturnUserList" style="display: none;">

                </div>
            </div>         
        </div>
        <!-- The Modal -->
        <div id="myModal" class="modal">

            <!-- Modal content -->
            <div class="modal-content">
                <span class="close">×</span>
                <pre class="logKoin">
                    
                </pre>
            </div>

        </div>
    </body>
</html>
