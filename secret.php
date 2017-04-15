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
                var str = $("form#revShareByDay").serialize();
                var url = "API/getRevShareByDay.php?"+ str;
                $.ajax({
                    type: "GET",
                    url: url,
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
        <style>
            ul#revShare-list {
                list-style-type: none;
                overflow-x: hidden;
                padding: 0;
                width: 200px;
            }
            ul#revShare-list li {
                margin: 0;
                padding: 0;
            }
            ul#revShare-list label {
                background-color: window;
                color: windowtext;
                display: block;
                margin: 0;
                padding: 0;
                width: 100%;
            }
            ul#revShare-list label:hover {
                background-color: highlight;
                color: highlighttext;
            }
        </style>
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
                        <br />
                        List Danh mục:
                        <ul id="revShare-list">
                            <li><label for="chk1"><input name="fee" value="fee" type="checkbox">Fee Game</label></li>
                            <li><label for="chk2"><input name="baucua" value="baucua" type="checkbox">Bầu Cua</label></li>
                            <li><label for="chk3"><input name="xocdia" value="xocdia" type="checkbox">Xóc Đĩa</label></li>
                            <li><label for="chk4"><input name="card_koin" value="card_koin" type="checkbox">Card Xu</label></li>
                            <li><label for="chk5"><input name="gold_to_koin" value="gold_to_koin" type="checkbox">Vàng đổi Xu</label></li>
                            <li><label for="chk6"><input name="boom" value="boom" type="checkbox">Nổ hũ</label></li>
                            <li><label for="chk7"><input name="sms_koin" value="sms_koin" type="checkbox">SMS Xu</label></li>
                            <li><label for="chk7"><input name="iap" value="iap" type="checkbox">IAP</label></li>
                        </ul>
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
