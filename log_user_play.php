<?php
$today = date('Y-m-d', time());
?>
<!DOCTYPE html>
<html>
    <head>
        <!--<title><?php echo $title; ?></title>-->
        <title>Thống kê Log chơi game</title>
        <link type='text/css' href='css/basic.css' rel='stylesheet' media='screen' />
        <?php require('header2.php'); ?>
        <script src="js/jquery.simplemodal.js"></script>
        <script>
            function getLogKoin(type) {
                $("#dvloader").show();
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
                        $("#dvloader").hide();
                    },
                    failure: function () {
                        $("#exchangeUserList").html("<span>Không truy cập được dữ liệu</span>");
                        $("#btnFindListUser").attr("disabled", false);
                    }
                });
            }

            function logTable() {
                $("#dvloader").show();
                var date = $("#logTable input[name=date]").val();
                var game = $("#logTable select[name=game]").val();
                var fromHour = $("#logTable input[name=fromHour]").val();
                var toHour = $("#logTable input[name=toHour]").val();
                
                $.ajax({
                    type: "GET",
                    url: "API/getLogTable.php",
                    data: {
                        "date": date,
                        "game": game,
                        "fromHour": fromHour,
                        "toHour": toHour
                    },
                    dataType: 'text',
                    success: function (msg) {
                        
                        $("#logTableResult").html(msg);
                        $("#logTableResult").show(); 
                        $("#dvloader").hide();
                    },
                    failure: function () {
                        $("#exchangeUserList").html("<span>Không truy cập được dữ liệu</span>");
                        $("#btnFindListUser").attr("disabled", false);
                    }
                });            
            }
            
            function logBoom() {
                $("#dvloader").show();
                var fromDate = $("#logBoom input[name=fromDate]").val();
                var toDate = $("#logBoom input[name=toDate]").val();
                var type = $("#logBoom select[name=type]").val();
                
                $.ajax({
                    type: "GET",
                    url: "API/getLogBoom.php",
                    data: {
                        "fromDate": fromDate,
                        "toDate": toDate,
                        "type": type
                    },
                    dataType: 'text',
                    success: function (msg) {
                        
                        $("#logBoomResult").html(msg);
                        $("#logBoomResult").show(); 
                        $("#dvloader").hide();
                    },
                    failure: function () {
                        $("#exchangeUserList").html("<span>Không truy cập được dữ liệu</span>");
                        $("#btnFindListUser").attr("disabled", false);
                    }
                });            
            }
            
            $("a.showLogTable").live("click", function(e) {
                e.preventDefault();
                var file_name = $(this).data('file');
                $.ajax({
                    type: "GET",
                    url: "API/showLogTable.php",
                    data: {
                        "file_name": file_name
                    },
                    dataType: 'text',
                    success: function (msg) {
                        if (msg != '' && msg.length > 2) {
                            $('#logTableDetail').html(msg);
                            $('#logTableDetail').modal({
                                closeHTML: '<div style="float:right; font-size:25px; color:#fff"><a href="#" class="simplemodal-close" style="color:#fff">x</a></div>',
                                opacity: 65,
                                overlayClose: true,
                                minWidth: '750px',
                                minHeight: '500px'
                            });
                            
                        } else {
                            alert("Lỗi hệ thống");
                        }
                    },
                    failure: function () {
                        alert("Kiểm tra lại kết nối mạng")
                    }
                });
            });

            $("a.pagination-link-log").live("click", function (e) {
                e.preventDefault();
                $("#dvloader").show();
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
                        $("#dvloader").hide();
                    },
                    failure: function () {
                        $("#exchangeUserList").html("<span>Không truy cập được dữ liệu</span>");
                        $("#btnFindListUser").attr("disabled", false);
                    }
                });
            });
            $(document).ready(function () {
                $(".datepicker").datepicker();
                $('#timepicker1').timepicker({ 'timeFormat': 'H:i:s'  });
                $('#timepicker2').timepicker({ 'timeFormat': 'H:i:s'  });
            });
        </script>




    </head>
    <body>   
        <div class="pagewrap">
            <?php require('topMenu.php'); ?>
            <div class="box grid">
                <?php include('topMenu.koin.php'); ?>
            </div>

            <div class="box grid">
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
                    <hr />
                    <div id="logKoinResult" style="display: none;overflow: hidden;">                    
                    </div>
                </div>

            </div>

            <div class="box grid">
                <div class="box_header"><a href="javascript:void(0);">Log Bàn chơi</a></div>
                <div class="box_body" style="display: none">
                    <form id="logTable">
                        Chọn ngày
                        <input type="text" class="datepicker" name="date" value="<?php echo $today; ?>" style="text-align: center; width: 100px;" />
                        Chọn Game
                        <select name="game">
                            <option value="vipphom" selected="selected">Phỏm VIP</option>
                            <option value="viptlmn">TLMN VIP</option>
                            <option value="viptlmndc">TLMNDC VIP</option>
                            <option value="vipxito">Xì tố VIP</option>
                            <option value="viplieng">Liêng VIP</option>
                            <option value="phom">Phỏm</option>
                            <option value="tlmn">TLMN</option>
                            <option value="tlmndc">TLMNDC</option>
                            <option value="xito">Xì tố</option>
                            <option value="lieng">Liêng</option>
                        </select>
                        Từ:
                        <input type="text" id="timepicker1" name="fromHour" value="" style="text-align: center; width: 100px;" />
                        Đến:
                        <input type="text" id="timepicker2" name="toHour" value="" style="text-align: center; width: 100px;" />
                        <input type="button" name="add" value="Log Bàn chơi" onclick="logTable();"/>

                    </form>
                    <hr />
                    <div id="logTableResult" style="display: none;">                    
                    </div>
                </div>
            </div>
            
            <div class="box grid">
                <div class="box_header"><a href="javascript:void(0);">Log Nổ hũ</a></div>
                <div class="box_body" style="display: none">
                    <form id="logBoom">
                        Từ Ngày
                        <input type="text" class="datepicker" name="fromDate" value="<?php echo $today; ?>" style="text-align: center; width: 100px;" />
                        Đến Ngày
                        <input type="text" class="datepicker" name="toDate" value="<?php echo $today; ?>" style="text-align: center; width: 100px;" />
                        Loại
                        <select name="type">
                            <option value="2" selected="selected">Vàng</option>
                            <option value="1">Xu</option>
                        </select>
                        <input type="button" name="add" value="Thống kê" onclick="logBoom();"/>

                    </form>
                    <hr />
                    <div id="logBoomResult" style="display: none;">                    
                    </div>
                </div>
            </div>
        </div>
        <div style="display:none" id="dvloader">
        </div>
        <div id="logTableDetail" style="display:none">demodemodemo</div>
    </body>
</html>

