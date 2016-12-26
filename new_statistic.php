<?php
$today = date('Y-m-d', time());
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Thống kê Mới</title>
        <?php require('header.php'); ?>
        <script src="js/highcharts.js" type="text/javascript"></script>
        <script type="text/javascript" src="js/themes/grid.js"></script> 
        <script>
            function topCharge() {
                var fromDate = $("#top_charge_user input[name=fromDate]").val();
                var toDate = $("#top_charge_user input[name=toDate]").val();
                var type = $("#top_charge_user select[name=type]").val();
                var limit = $("#top_charge_user select[name=limit]").val();

                $("#btnFindListUser").attr("disabled", true);
                $.ajax({
                    type: "GET",
                    url: "API/topChargeUser.php",
                    data: {
                        "fromDate": fromDate,
                        "toDate": toDate,
                        "type": type,
                        "limit": limit
                    },
                    dataType: 'text',
                    success: function (msg) {
                        $("#topCharge").html(msg);
                        $("#topCharge").show();
                    },
                    failure: function () {
                        $("#topCharge").html("<span>Không truy cập được dữ liệu</span>");
                        $("#btnFindListUser").attr("disabled", false);
                    }
                });

            }
            function koinUserRange() {
                $.ajax({
                    type: "GET",
                    url: "API/countKoinRangeUser.php",
                    dataType: 'text',
                    success: function (msg) {
                        $("#userKoinRangeTable").html(msg);
                        $("#userKoinRangeTable").show();
                    },
                    failure: function () {
                        $("#userKoinRangeTable").html("<span>Không truy cập được dữ liệu</span>");
                    }
                });
            }
            function topKoinUser() {
                var limit = $("#user_top_xu select[name=limit]").val();

                $("#btnFindListUser").attr("disabled", true);
                $.ajax({
                    type: "GET",
                    url: "API/topUserKoin.php",
                    data: {
                        "limit": limit
                    },
                    dataType: 'text',
                    success: function (msg) {
                        $("#userTopKoin").html(msg);
                        $("#userTopKoin").show();
                    },
                    failure: function () {
                        $("#userTopKoin").html("<span>Không truy cập được dữ liệu</span>");
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
                <div class="box_header" style="background-image: none;"><a href="javascript:void(0);">Thống kê Top User Nạp tiền</a></div>
                <div class="box_body">
                    <form id="top_charge_user">
                        Từ Ngày
                        <input type="text" class="datepicker" name="fromDate" value="<?php echo $today; ?>" style="text-align: center; width: 100px;" />
                        Tới Ngày
                        <input type="text" class="datepicker" name="toDate" value="<?php echo $today; ?>" style="text-align: center; width: 100px;" />
                        Card
                        <select name="type">
                            <option value="2" selected="selected">CARD</option>
                            <option value="1" selected="selected">SMS</option>
                            <option value="4">IAP</option>
                        </select>
                        Số lượng
                        <select name="limit">
                            <option value="10" selected="selected">10</option>
                            <option value="20">20</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select>
                        <input type="button" name="add" value="Thống kê" onclick="topCharge();"/>
                        <!--<span id="top-charge" style="font-weight: bold; color: #fff;"></span>-->
                    </form>
                </div>
                <div id="topCharge" style="display: none;">

                </div>
            </div>  
            <div class="box grid">
                <div class="box_header" style="background-image: none;"><a href="javascript:void(0);">Thống kê Số User có Xu theo từng khoảng</a></div>
                <div class="box_body"  style="display: none">
                    <form id="user_range_koin">                        
                        <input type="button" name="add" value="Thống kê" onclick="koinUserRange();"/>
                        <!--<span id="top-charge" style="font-weight: bold; color: #fff;"></span>-->
                    </form>
                </div>
                <div id="userKoinRangeTable" style="display: none;">

                </div>
            </div> 
            <div class="box grid">
                <div class="box_header" style="background-image: none;"><a href="javascript:void(0);">Thống kê TOP XU trong Game</a></div>
                <div class="box_body"  style="display: none">
                    <form id="user_top_xu">    
                        Số lượng
                        <select name="limit">
                            <option value="10" selected="selected">10</option>
                            <option value="20">20</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select>
                        <input type="button" name="add" value="Thống kê" onclick="topKoinUser();"/>
                        <!--<span id="top-charge" style="font-weight: bold; color: #fff;"></span>-->
                    </form>
                </div>
                <div id="userTopKoin" style="display: none;">

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
