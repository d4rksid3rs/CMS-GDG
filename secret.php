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
            $(document).ready(function () {
                $(".datepicker").datepicker();
            });

        </script>
    </head>
    <body>
        <div class="pagewrap">
            <?php require('topMenu.php'); ?>
            <div class="box grid">
                <div class="box_header" style="background-image: none;"><a href="javascript:void(0);">Thống kê Chia sẻ Doanh thu</a></div>
                <div class="box_body"  style="display: none">
                    <form id="revShare">
                        <input type="button" name="add" value="Thống kê" onclick="getRevShare();"/>
                        <span id="message" style="color: #800000; font-weight: bold"></span>
                    </form>
                </div>
                <div id="revShareResult" style="display: none;">

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
