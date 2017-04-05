<?php

function curPageURL() {
    $pageURL = 'http';
    if ($_SERVER["HTTPS"] == "on") {
        $pageURL .= "s";
    }
    $pageURL .= "://";
    if ($_SERVER["SERVER_PORT"] != "80") {
        $pageURL .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . $_SERVER["REQUEST_URI"];
    } else {
        $pageURL .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
    }
    return $pageURL;
}

$today = date('Y-m-d', time());
$current_user = $_COOKIE['username'];
if ($current_user != 'admin') {
    $url = curPageURL();
    $url = str_replace('secret.php', '', $url);
    header('Location: ' . $url);
    exit();
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Secret - For Admin Only</title>
        <?php require('header.php'); ?>
        <script src="js/highcharts.js" type="text/javascript"></script>
        <script type="text/javascript" src="js/themes/grid.js"></script> 
        <script>

            function getRevShare() {
                $("#dvloader").show();
                $.ajax({
                    type: "GET",
                    url: "API/getRevShare.php",
                    dataType: 'text',
                    success: function (msg) {
                        $("#revShareResult").html(msg);
                        $("#revShareResult").show();
                        $("#dvloader").hide();
                    },
                    failure: function () {
                        $("#revShareResult").html("<b>Không truy cập được dữ liệu</b>");
                    }
                });
            }
            
            function getGoldToKoin() {
                $("#dvloader").show();
                var fromDate = $("#goldToKoin input[name=fromDate]").val();
                var toDate = $("#goldToKoin input[name=toDate]").val();
                $.ajax({
                    type: "GET",
                    url: "API/goldToKoin.php",
                    data: {
                        "fromDate": fromDate,
                        "toDate": toDate
                    },
                    dataType: 'text',
                    success: function (msg) {
                        $("#goldToKoinResult").html(msg);
                        $("#goldToKoinResult").show();
                        $("#dvloader").hide();
                    },
                    failure: function () {
                        $("#goldToKoinResult").html("<b>Không truy cập được dữ liệu</b>");
                    }
                });
            }
            
            function getRevShareByDay() {
                $("#dvloader").show();
                var fromDate = $("#revShareByDay input[name=fromDate]").val();
                var toDate = $("#revShareByDay input[name=toDate]").val();
                $.ajax({
                    type: "GET",
                    url: "API/getRevShareByDay.php",
                    data: {
                        "fromDate": fromDate,
                        "toDate": toDate
                    },
                    dataType: 'text',
                    success: function (msg) {
                        $("#revShareByDayResult").html(msg);
                        $("#revShareByDayResult").show();
                        $("#dvloader").hide();
                    },
                    failure: function () {
                        $("#goldToKoinResult").html("<b>Không truy cập được dữ liệu</b>");
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
                <div class="box_header" style="background-image: none;"><a href="javascript:void(0);">Thống kê Chia sẻ Doanh thu Real Time</a></div>
                <div class="box_body"  style="display: none">
                    <form id="revShare">
                        <input type="button" name="add" value="Thống kê" onclick="getRevShare();"/>
                        <span id="message" style="color: #800000; font-weight: bold"></span>
                    </form>
                    <div id="revShareResult" style="display: none;">

                    </div>
                </div>
            </div> 
            
            <div class="box grid">
                <div class="box_header" style="background-image: none;"><a href="javascript:void(0);">Thống kê Vàng đổi Xu</a></div>
                <div class="box_body"  style="display: none">
                    <form id="goldToKoin">
                        Từ ngày:
                        <input type="text" class="datepicker" name="fromDate" value="<?php echo $today; ?>" style="text-align: center; width: 100px;"/>
                        Đến ngày:
                        <input type="text" class="datepicker" name="toDate" value="<?php echo $today; ?>" style="text-align: center; width: 100px;"/>
                        <input type="button" name="add" value="Thống kê" onclick="getGoldToKoin();"/>
                        <span id="message" style="color: #800000; font-weight: bold"></span>
                    </form>
                    <div id="goldToKoinResult" style="display: none;">

                    </div>
                </div>
            </div> 
            
            <div class="box grid">
                <div class="box_header" style="background-image: none;"><a href="javascript:void(0);">Thống kê Chia sẻ Doanh thu Theo ngày</a></div>
                <div class="box_body"  style="display: none">
                    <form id="revShareByDay">
                        Từ ngày:
                        <input type="text" class="datepicker" name="fromDate" value="<?php echo $today; ?>" style="text-align: center; width: 100px;"/>
                        Đến ngày:
                        <input type="text" class="datepicker" name="toDate" value="<?php echo $today; ?>" style="text-align: center; width: 100px;"/>
                        <input type="button" name="add" value="Thống kê" onclick="getRevShareByDay();"/>
                        <span id="message" style="color: #800000; font-weight: bold"></span>
                    </form>
                    <div id="revShareByDayResult" style="display: none;">

                    </div>
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
        <div style="display:none" id="dvloader">
        </div>
    </body>
</html>
