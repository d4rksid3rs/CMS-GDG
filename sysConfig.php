<?php
$fromDate = date('Y-m-d', time());
include('API/db.class.php');
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Hệ thống</title>
        <?php require('header.php'); ?>
        <script>
            $(document).ready(function () {
                $("#datepicker1").datepicker();
            });
            function selecttype(type) {
                $("#thongbao1").css("display", "block");
                if (type == 2 || type == 3)
                    $("#thongbao2").css("display", "block");
                else
                    $("#thongbao2").css("display", "none");
                if (type == 0)
                {
                    $("#thongbao1").css("display", "none");
                    $("#thongbao2").css("display", "none");
                }
            }

            function selectMission(id) {
                if (id != 0)
                {
                    $.ajax({
                        type: "POST",
                        url: "API/listMission.php",
                        data: {
                            "type": "get",
                            "id": id
                        },
                        dataType: 'text',
                        success: function (msg) {
                            msg = msg.trim();
                            if (msg != '' && msg.length > 2) {
                                var data = jQuery.parseJSON(msg);
                                if (data.status == 1) {
                                    $("#listMission #editMission").html(data.message);
                                    $("#listMission #editMission").css("display", "block");
                                } else
                                    $("#listMission #message").html(data.message);
                            } else {
                                $("#listMission #message").html("Lỗi hệ thống");
                            }
                        },
                        failure: function () {
                            $("#listMission #message").html("Lỗi hệ thống");
                            $(this).oneTime(5000, function () {
                                $("#listMission #message").html("");
                            });
                        }
                    });
                }
            }

            function editMission() {
                var id = $("#listMission input[name=mid]").val();
                var title = $("#listMission input[name=title]").val();
                var msg = $("#listMission input[name=msg]").val();
                var koin = $("#listMission input[name=koin]").val();
                var maxPerDay = $("#listMission input[name=maxPerDay]").val();
                var enable = $("#listMission input[name=enable]").attr("checked") ? 1 : 0;
                $.ajax({
                    type: "POST",
                    url: "API/listMission.php",
                    data: {
                        "type": "edit",
                        "id": id,
                        "title": title,
                        "msg": msg,
                        "koin": koin,
                        "maxPerDay": maxPerDay,
                        "enable": enable
                    },
                    dataType: 'text',
                    success: function (msg) {
                        msg = msg.trim();
                        if (msg != '' && msg.length > 2) {
                            var data = jQuery.parseJSON(msg);
                            if (data.status == 1) {
                                $("#listMission #editMission").html(data.message);
                            } else
                                $("#listMission #message").html(data.message);
                        } else {
                            $("#listMission #message").html("Lỗi hệ thống");
                        }
                    },
                    failure: function () {
                        $("#listMission #message").html("Lỗi hệ thống");
                        $(this).oneTime(5000, function () {
                            $("#listMission #message").html("");
                        });
                    }
                });
            }

            function sendNotify()
            {
                //alert($("#type").val());
                var type = $("#type").val();
                var msg = $("#notify textarea[name=message]").val();
                var usr = $("#notify input[name=username]").val();
                $.ajax({
                    type: "POST",
                    url: "API/sendSlideMessage.php",
                    data: {
                        "type": type,
                        "message": msg,
                        "username": usr
                    },
                    dataType: 'text',
                    success: function (msg) {
                        msg = msg.trim();
                        if (msg != '' && msg.length > 2) {
                            var data = jQuery.parseJSON(msg);
                            if (data.status == 1) {
                                $("#notify #message").html("Gửi thông báo thành công");
                            } else {
                                $("#notify #message").html(data.message);
                            }
                        } else {
                            $("#notify #message").html("Lỗi hệ thống");
                        }
                    },
                    failure: function () {
                        $("#notify #message").html("Lỗi hệ thống");
                        $(this).oneTime(5000, function () {
                            $("#notify #message").html("");
                        });
                    }
                });
            }

            function statistics(type) {
                var version = "2.0.2";
                var times = "50";
                if (type == 1) {
                    version = $("#statistic input[name=version]").val();
                    $.ajax({
                        type: "GET",
                        url: "API/statistic.php",
                        data: {
                            "type": type,
                            "version": version
                        },
                        dataType: 'text',
                        success: function (msg) {
                            msg = msg.trim();
                            if (msg != '' && msg.length > 2) {
                                var data = jQuery.parseJSON(msg);
                                if (data.status == 1) {
                                    $("#statistic #message1").html(data.total);
                                } else {
                                    $("#statistic #message1").html(data.message);
                                }
                            } else {
                                $("#statistic #message1").html("Lỗi hệ thống");
                            }
                        },
                        failure: function () {
                            $("#statistic #message1").html("Lỗi hệ thống");
                            $(this).oneTime(5000, function () {
                                $("#statistic #message1").html("");
                            });
                        }
                    });
                } else if (type == 2) {
                    times = $("#statistic select[name=times]").val();
                    $.ajax({
                        type: "GET",
                        url: "API/statistic.php",
                        data: {
                            "type": type,
                            "times": times
                        },
                        dataType: 'text',
                        success: function (msg) {
                            msg = msg.trim();
                            if (msg != '' && msg.length > 2) {
                                var data = jQuery.parseJSON(msg);
                                if (data.status == 1) {
                                    $("#statistic #message2").html(data.total);
                                } else {
                                    $("#statistic #message2").html(data.message);
                                }
                            } else {
                                $("#statistic #message2").html("Lỗi hệ thống");
                            }
                        },
                        failure: function () {
                            $("#statistic #message2").html("Lỗi hệ thống");
                            $(this).oneTime(5000, function () {
                                $("#statistic #message2").html("");
                            });
                        }
                    });
                } else if (type == 3) {
                    lastLogin = $("#statistic input[name=lastLogin]").val();
                    $.ajax({
                        type: "GET",
                        url: "API/statistic.php",
                        data: {
                            "type": type,
                            "lastLogin": lastLogin
                        },
                        dataType: 'text',
                        success: function (msg) {
                            msg = msg.trim();
                            if (msg != '' && msg.length > 2) {
                                var data = jQuery.parseJSON(msg);
                                if (data.status == 1) {
                                    $("#statistic #message3").html(data.total);
                                } else {
                                    $("#statistic #message3").html(data.message);
                                }
                            } else {
                                $("#statistic #message3").html("Lỗi hệ thống");
                            }
                        },
                        failure: function () {
                            $("#statistic #message3").html("Lỗi hệ thống");
                            $(this).oneTime(5000, function () {
                                $("#statistic #message3").html("");
                            });
                        }
                    });
                }
            }
        </script>
    </head>
    <body>
        <div class="pagewrap">
            <?php require('topMenu.php'); ?>
            <div class="box">
                <div class="box_header" style="background-image: none;"><a href="javascript:void(0);">Thống kê người dùng</a></div>
                <div class="box_body">
                    <form id="statistic">
                        Theo version <input type="text" name="version" style="width: 100px; text-align:center;" value="1.0.0"/>
                        <input type="button" name="add" value="Thống kê" onclick="statistics(1);"/>
                        <span id="message1" style="color: #800000; font-weight: bold"></span>
                        <br/>
                        Số lần đăng nhập >=
                        <select style="text-align:center;" name="times">
                            <option value="10">10</option>
                            <option value="30">30</option>
                            <option value="50">50</option>
                            <option value="70">70</option>
                            <option value="100">100</option>
                        </select>
                        <input type="button" name="add" value="Thống kê" onclick="statistics(2);"/>
                        <span id="message2" style="color: #800000; font-weight: bold"></span>
                        <br/>
                        Lần cuối đăng nhập >= <input type="text" name="lastLogin" style="width: 100px; text-align:center;" value="<?php echo $fromDate; ?>" id="datepicker1"/>
                        <input type="button" name="add" value="Thống kê" onclick="statistics(3);"/>
                        <span id="message3" style="color: #800000; font-weight: bold"></span>
                    </form>
                </div>
            </div>

            <div class="box grid">
                <div class="box_header">
                    <a href="javascript:void(0);">Gửi thông báo</a>
                </div>
                <div class="box_body" style="display:block;">
                    <form id="notify">
                        Loại thông báo
                        <select style="text-align:center;" name="type" id="type" onchange="selecttype(this.value);">
                            <option value="0">----- Chọn ----</option>
                            <option value="1">Gửi thông báo chữ chạy cho toàn bộ user</option>
                            <option value="2">Gửi thông báo chữ chạy cho một user</option>
                            <option value="3">Gửi thông báo popup cho một user</option>
                        </select>
                        <div style='display:none' id="thongbao1">
                                Nội dung: <!-- <input type="text" name="message" name="message" /> -->
                            <textarea name="message" id="message" rows="4" cols="50"></textarea>
                        </div>
                        <div style='display:none' id="thongbao2">
                            Username: <input type="text" name="username" name="username" />
                        </div>
                        <input type="button" name="add" value="Thông báo" onclick="sendNotify()" />
                        <span id="message" style="color: #800000; font-weight: bold"></span>
                    </form>
                </div>
            </div>

            <div class="box grid">
                <div class="box_header">
                    <a href="javascript:void(0);">Cấu hình nhiệm vụ</a>
                </div>
                <div class="box_body" style="display:block;">
                    <form id="listMission">
                        List nhiệm vụ
                        <select style="text-align:center;" name="type" id="type" onchange="selectMission(this.value);">
                            <option value="0">----- Chọn ----</option>
                            <?php
                            $sql = "select value from config where `key` = 'config_mission' limit 0,1";
                            $json = "";
                            foreach ($db->query($sql) as $row) {
                                $json = $row['value'];
                            }
                            $arr = json_decode($json, true);
                            foreach ($arr['mission'] as $mission) {
                                echo '<option value="' . $mission['id'] . '">' . $mission['title'] . '</option>';
                            }
                            ?>
                        </select>
                        <div style='display:none' id="editMission"></div>
                        <span id="message" style="color: #800000; font-weight: bold"></span>
                    </form>
                </div>
            </div>

            <!--
<div class="box grid">
    <div class="box_header">
        <a href="javascript:void(0);">Cấu hình hệ thống</a>
    </div>
    <div class="box_body" style="display:none;">
        <iframe height="800" width="100%" frameBorder="0" src="olympia/">your browser does not support IFRAMEs</iframe>
    </div>
</div>
            -->
        </div>
    </body>
</html>
