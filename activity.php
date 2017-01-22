<?php
$fromDate = $_REQUEST['fromDate'];
$toDate = $_REQUEST['toDate'];

if (!isset($fromDate)) {
    $fromDate = date('Y-m-d', time());
}
if (!isset($toDate)) {
    $toDate = date('Y-m-d', time());
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title><?php echo 'Activity'; ?></title>
        <?php require('header.php'); ?>
        <script>
            $(document).ready(function () {
                $("#datepicker1").datepicker();
                $("#datepicker2").datepicker();
                $("#datepicker3").datepicker();
                $("#datepicker4").datepicker();
                $("#datepicker5").datepicker();
                $("#datepicker6").datepicker();
                $("#datepicker7").datepicker();
            });

            function getInactive() {

                var fromDate = $("#inActive input[name=fromDate]").val();
                var numLogin = $("#inActive input[name=numLogin]").val();

                //alert(fromDate);

                $.ajax({
                    type: "GET",
                    url: "API/getActivity.php",
                    data: {
                        "fromDate": fromDate,
                        "numLogin": numLogin,
                        "type": "inactive"
                    },
                    dataType: 'text',
                    success: function (msg) {
                        msg = msg.trim();
                        if (msg != '' && msg.length > 2) {
                            var data = jQuery.parseJSON(msg);
                            if (data.status == 1) {
                                $("#inActive #message").text(data.numuser);
                            } else {
                                $("#inActive #message").html(data.message);
                                $(this).oneTime(5000, function () {
                                    $("#inActive #message").html("");
                                });
                            }
                        } else {
                            $("#inActive #message").html("Lỗi hệ thống");
                            $(this).oneTime(5000, function () {
                                $("#inActive #message").html("");
                            });
                        }
                    },
                    failure: function () {
                        $("#inActive #message").html("Lỗi hệ thống");
                        $(this).oneTime(5000, function () {
                            $("#inActive #message").html("");
                        });
                    }
                });
            }


            function getLogin() {

                var fromDate = $("#login input[name=fromDate]").val();
                var numLogin = $("#login input[name=toDate]").val();

                //alert(fromDate);

                $.ajax({
                    type: "GET",
                    url: "API/getActivity.php",
                    data: {
                        "fromDate": fromDate,
                        "toDate": numLogin,
                        "type": "login"
                    },
                    dataType: 'text',
                    success: function (msg) {
                        msg = msg.trim();
                        if (msg != '' && msg.length > 2) {
                            var data = jQuery.parseJSON(msg);
                            if (data.status == 1) {
                                //$("#login #message").text(data.numuser);
                                $("#login #message").text(data.dataos);
                            } else {
                                $("#login #message").html(data.message);
                                $(this).oneTime(5000, function () {
                                    $("#login #message").html("");
                                });
                            }
                        } else {
                            $("#login #message").html("Lỗi hệ thống");
                            $(this).oneTime(5000, function () {
                                $("#login #message").html("");
                            });
                        }
                    },
                    failure: function () {
                        $("#login #message").html("Lỗi hệ thống");
                        $(this).oneTime(5000, function () {
                            $("#login #message").html("");
                        });
                    }
                });
            }




            function getNapSMS() {

                var fromDate = $("#napSMS input[name=fromDate]").val();
                var toDate = $("#napSMS input[name=toDate]").val();

                //alert(fromDate);

                $.ajax({
                    type: "GET",
                    url: "API/getActivity.php",
                    data: {
                        "fromDate": fromDate,
                        "toDate": toDate,
                        "type": "napsms"
                    },
                    dataType: 'text',
                    success: function (msg) {
                        msg = msg.trim();
                        if (msg != '' && msg.length > 2) {
                            var data = jQuery.parseJSON(msg);
                            if (data.status == 1) {
                                $("#napSMS #message").text(data.numuser);
                            } else {
                                $("#napSMS #message").html(data.message);
                                $(this).oneTime(5000, function () {
                                    $("#napSMS #message").html("");
                                });
                            }
                        } else {
                            $("#napSMS #message").html("Lỗi hệ thống");
                            $(this).oneTime(5000, function () {
                                $("#napSMS #message").html("");
                            });
                        }
                    },
                    failure: function () {
                        $("#napSMS #message").html("Lỗi hệ thống");
                        $(this).oneTime(5000, function () {
                            $("#napSMS #message").html("");
                        });
                    }
                });
            }

            function getNapIAP() {

                var fromDate = $("#napIAP input[name=fromDate]").val();
                var toDate = $("#napIAP input[name=toDate]").val();

                //alert(fromDate);

                $.ajax({
                    type: "GET",
                    url: "API/getActivity.php",
                    data: {
                        "fromDate": fromDate,
                        "toDate": toDate,
                        "type": "napiap"
                    },
                    dataType: 'text',
                    success: function (msg) {
                        msg = msg.trim();
                        if (msg != '' && msg.length > 2) {
                            var data = jQuery.parseJSON(msg);
                            if (data.status == 1) {
                                $("#napIAP #message").text(data.numuser);
                            } else {
                                $("#napIAP #message").html(data.message);
                                $(this).oneTime(5000, function () {
                                    $("#napIAP #message").html("");
                                });
                            }
                        } else {
                            $("#napIAP #message").html("Lỗi hệ thống");
                            $(this).oneTime(5000, function () {
                                $("#napIAP #message").html("");
                            });
                        }
                    },
                    failure: function () {
                        $("#napIAP #message").html("Lỗi hệ thống");
                        $(this).oneTime(5000, function () {
                            $("#napIAP #message").html("");
                        });
                    }
                });
            }

            function getNapCard() {

                var fromDate = $("#napCard input[name=fromDate]").val();
                var toDate = $("#napCard input[name=toDate]").val();

                //alert(fromDate);

                $.ajax({
                    type: "GET",
                    url: "API/getActivity.php",
                    data: {
                        "fromDate": fromDate,
                        "toDate": toDate,
                        "type": "napcard"
                    },
                    dataType: 'text',
                    success: function (msg) {
                        msg = msg.trim();
                        if (msg != '' && msg.length > 2) {
                            var data = jQuery.parseJSON(msg);
                            if (data.status == 1) {
                                $("#napCard #message").text(data.numuser);
                            } else {
                                $("#napCard #message").html(data.message);
                                $(this).oneTime(5000, function () {
                                    $("#napCard #message").html("");
                                });
                            }
                        } else {
                            $("#napCard #message").html("Lỗi hệ thống");
                            $(this).oneTime(5000, function () {
                                $("#napCard #message").html("");
                            });
                        }
                    },
                    failure: function () {
                        $("#napCard #message").html("Lỗi hệ thống");
                        $(this).oneTime(5000, function () {
                            $("#napCard #message").html("");
                        });
                    }
                });
            }
        </script>






    </head>
    <body>
        <div class="pagewrap">
            <?php require('topMenu.php'); ?>
            <?php //include('topMenu.activity.php'); ?>

            <div class="box grid">
                <div class="box_header"><a href="javascript:void(0);"><?php echo "Số account login"; ?></a></div>
                <div class="box_body">
                    <table width="100%">
                        <tr><td>
                                <div style="padding-left:10px;">
                                    <form id="login">
                                        Từ ngày
                                        <input type="text" id="datepicker1" name="fromDate" style="text-align: center; width: 100px;" value="<?php echo $fromDate; ?>"/> 
                                        (00:00:00)
                                        Tới ngày
                                        <input type="text" id="datepicker2" name="toDate" style="text-align: center; width: 100px;" value="<?php echo $toDate; ?>"/> 
                                        (23:59:59)
                                        <input type="button" value="Cập nhật" class="input_button" onClick="getLogin();"/>
                                        <span id="message" style="color: #800000; font-weight: bold"></span>
                                    </form>
                                </div>
                            </td></tr>

                    </table>
                </div>
            </div>


            <div class="box grid">
                <div class="box_header"><a href="javascript:void(0);"><?php echo "Số account CHƯA login"; ?></a></div>
                <div class="box_body">
                    <table width="100%">
                        <tr><td>
                                <div style="padding-left:10px;">
                                    <form id="inActive">
                                        Đến ngày
                                        <input type="text" id="datepicker3" name="fromDate" style="text-align: center; width: 100px;" value="<?php echo $fromDate; ?>"/>  
                                        (00:00:00)
                                        &nbsp;Đã từng login
                                        <input type="text" value="10" class="input_button" name="numLogin"/>
                                        lần
                                        <input type="button" value="Cập nhật" class="input_button" onClick="getInactive();"/>
                                        <span id="message" style="color: #800000; font-weight: bold"></span>
                                    </form>
                                </div>

                            </td></tr></table>		
                </div>
            </div>




            <div class="box grid">
                <div class="box_header"><a href="javascript:void(0);"><?php echo "Số thuê bao điện thoại Nạp tiền qua SMS"; ?></a></div>
                <div class="box_body">
                    <table width="100%">
                        <tr><td>
                                <div style="padding-left:10px;">
                                    <form id="napSMS">
                                        Từ ngày
                                        <input type="text" id="datepicker4" name="fromDate" style="text-align: center; width: 100px;" value="<?php echo $fromDate; ?>"/> 
                                        (00:00:00)
                                        Tới ngày
                                        <input type="text" id="datepicker5" name="toDate" style="text-align: center; width: 100px;" value="<?php echo $toDate; ?>"/> 
                                        (23:59:59)
                                        <input type="button" value="Cập nhật" class="input_button" onClick="getNapSMS();"/>
                                        <span id="message" style="color: #800000; font-weight: bold"></span>
                                    </form>
                                </div>

                            </td></tr></table>		
                </div>
            </div>
            
            <div class="box grid">
                <div class="box_header"><a href="javascript:void(0);"><?php echo "Số thuê bao điện thoại Nạp tiền qua IAP"; ?></a></div>
                <div class="box_body">
                    <table width="100%">
                        <tr><td>
                                <div style="padding-left:10px;">
                                    <form id="napIAP">
                                        Từ ngày
                                        <input type="text" id="datepicker4" name="fromDate" style="text-align: center; width: 100px;" value="<?php echo $fromDate; ?>"/> 
                                        (00:00:00)
                                        Tới ngày
                                        <input type="text" id="datepicker5" name="toDate" style="text-align: center; width: 100px;" value="<?php echo $toDate; ?>"/> 
                                        (23:59:59)
                                        <input type="button" value="Cập nhật" class="input_button" onClick="getNapIAP();"/>
                                        <span id="message" style="color: #800000; font-weight: bold"></span>
                                    </form>
                                </div>

                            </td></tr></table>		
                </div>
            </div>


            <div class="box grid">
                <div class="box_header"><a href="javascript:void(0);"><?php echo "Số account Nạp tiền qua Thẻ cào"; ?></a></div>
                <div class="box_body">
                    <table width="100%">
                        <tr><td>
                                <div style="padding-left:10px;">
                                    <form id="napCard">
                                        Từ ngày
                                        <input type="text" id="datepicker6" name="fromDate" style="text-align: center; width: 100px;" value="<?php echo $fromDate; ?>"/> 
                                        (00:00:00)
                                        Tới ngày
                                        <input type="text" id="datepicker7" name="toDate" style="text-align: center; width: 100px;" value="<?php echo $toDate; ?>"/> 
                                        (23:59:59)
                                        <input type="button" value="Cập nhật" class="input_button" onClick="getNapCard();"/>
                                        <span id="message" style="color: #800000; font-weight: bold"></span>
                                    </form>
                                </div>

                            </td></tr></table>		
                </div>
            </div>

            <div class="box grid">
                <div class="box_header">
                    <a href="javascript:void(0);">Active User</a>
                </div>
                <div class="box_body">
                    <table width="100%">
                        <tr>
                            <td width="50%"><iframe height="320" width="100%" frameBorder="0" src="chartActiveUser.php?fromDate=<?php echo $fromDate; ?>&toDate=<?php echo $toDate; ?>">your browser does not support IFRAMEs</iframe></td>
                            <td><iframe height="320" width="100%" frameBorder="0" src="chartMauUser.php?fromDate=<?php echo $fromDate; ?>&toDate=<?php echo $toDate; ?>">your browser does not support IFRAMEs</iframe></td>
                        </tr>
                    </table>
                    <div style="padding-left:10px;">
                        <!--                        
                                                        <form method="index.php" method="GET">
                                                                Từ ngày 
                                                                <input type="text" id="datepicker1" name="fromDate" style="text-align: center; width: 100px;" value="<?php echo $fromDate; ?>"/> 
                                                                Tới ngày 
                                                                <input type="text" id="datepicker2" name="toDate" style="text-align: center; width: 100px;" value="<?php echo $toDate; ?>"/> 
                                                                <input type="submit" value="Cập nhật" class="input_button"/>
                                                        </form>
                                                </div>
                        -->
                    </div>


                </div>



            </div>
        </div>




    </body>
</html>

