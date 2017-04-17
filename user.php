<?php
$today = date('Y-m-d', time());

?>
<!DOCTYPE html>
<html>
    <head>
        <title>Người chơi</title>
        <?php require('header.php'); ?>
        <script src="js/highcharts.js" type="text/javascript"></script>
        <script type="text/javascript" src="js/themes/grid.js"></script> 
        <script>
            function addKoin() {
                var user = $("#addKoin input[name=user]").val();
                var pass = $("#addKoin input[name=pass]").val();
                var koin = $("#addKoin input[name=koin]").val();
                var cause = $("#addKoin input[name=cause]").val();
                $.ajax({
                    type: "POST",
                    url: "API/addKoin.php",
                    data: {
                        "user": user,
                        "pass": pass,
                        "koin": koin,
                        "cause": cause
                    },
                    dataType: 'text',
                    success: function (msg) {
                        msg = msg.trim();
                        if (msg != '' && msg.length > 2) {
                            var data = jQuery.parseJSON(msg);
                            if (data.status == 1) {
                                $("#addKoin #message").html("Cập nhật thành công");
                                $(this).oneTime(5000, function () {
                                    $("#addKoin #message").html("");
                                });
                            } else {
                                $("#addKoin #message").html(data.message);
                                $(this).oneTime(5000, function () {
                                    $("#addKoin #message").html("");
                                });
                            }
                        } else {
                            $("#addKoin #message").html("Lỗi hệ thống");
                            $(this).oneTime(5000, function () {
                                $("#addKoin #message").html("");
                            });
                        }
                    },
                    failure: function () {
                        $("#addKoin #message").html("Lỗi hệ thống");
                        $(this).oneTime(5000, function () {
                            $("#addKoin #message").html("");
                        });
                    }
                });
            }
            
            function addKoinVip() {
                var user = $("#addChip input[name=user]").val();
                var pass = $("#addChip input[name=pass]").val();
                var koin = $("#addChip input[name=koin]").val();
                var cause = $("#addChip input[name=cause]").val();
                $.ajax({
                    type: "POST",
                    url: "API/addKoinVip.php",
                    data: {
                        "user": user,
                        "pass": pass,
                        "koin": koin,
                        "cause": cause
                    },
                    dataType: 'text',
                    success: function (msg) {
                        msg = msg.trim();
                        if (msg != '' && msg.length > 2) {
                            var data = jQuery.parseJSON(msg);
                            if (data.status == 1) {
                                $("#addChip #message").html("Cập nhật thành công");
                                $(this).oneTime(5000, function () {
                                    $("#addChip #message").html("");
                                });
                            } else {
                                $("#addChip #message").html(data.message);
                                $(this).oneTime(5000, function () {
                                    $("#addChip #message").html("");
                                });
                            }
                        } else {
                            $("#addChip #message").html("Lỗi hệ thống");
                            $(this).oneTime(5000, function () {
                                $("#addChip #message").html("");
                            });
                        }
                    },
                    failure: function () {
                        $("#addChip #message").html("Lỗi hệ thống");
                        $(this).oneTime(5000, function () {
                            $("#addChip #message").html("");
                        });
                    }
                });
            }
            
            function reduceKoinVip() {
                var user = $("#addChip input[name=user]").val();
                var pass = $("#addChip input[name=pass]").val();
                var koin = $("#addChip input[name=koin]").val();
                var cause = $("#addChip input[name=cause]").val();
                $.ajax({
                    type: "POST",
                    url: "API/reduceKoinVip.php",
                    data: {
                        "user": user,
                        "pass": pass,
                        "koin": koin,
                        "cause": cause
                    },
                    dataType: 'text',
                    success: function (msg) {
                        msg = msg.trim();
                        if (msg != '' && msg.length > 2) {
                            var data = jQuery.parseJSON(msg);
                            if (data.status == 1) {
                                $("#addChip #message").html("Cập nhật thành công");
                                $(this).oneTime(5000, function () {
                                    $("#addChip #message").html("");
                                });
                            } else {
                                $("#addChip #message").html(data.message);
                                $(this).oneTime(5000, function () {
                                    $("#addChip #message").html("");
                                });
                            }
                        } else {
                            $("#addChip #message").html("Lỗi hệ thống");
                            $(this).oneTime(5000, function () {
                                $("#addChip #message").html("");
                            });
                        }
                    },
                    failure: function () {
                        $("#addChip #message").html("Lỗi hệ thống");
                        $(this).oneTime(5000, function () {
                            $("#addChip #message").html("");
                        });
                    }
                });
            }

            function findUserPassword() {
                var username = $("#findUser input[name=user]").val();
                var adminpass = $("#findUser input[name=adminpass]").val();
                $("#userDetail").hide();
                $("#userDetailDB").hide();
                $("#userPassword").hide();
                $.ajax({
                    type: "GET",
                    url: "API/findUserPassword.php",
                    data: {
                        "username": username,
                        "password": adminpass
                    },
                    dataType: 'text',
                    success: function (msg) {
                        msg = msg.trim();
                        if (msg != '' && msg.length > 2) {
                            var data = jQuery.parseJSON(msg);
                            if (data.status == 1) {
                                $("#userPassword").html("Mật khẩu : " + data.password + ", koin : " + data.koin + ", mobile : " + data.mobile);
                                $("#userPassword").slideDown(1000);
                                $(this).oneTime(5000, function () {
                                    $("#userPassword").html("");
                                });
                            } else {
                                $("#findUser #message").html(data.message);
                                $(this).oneTime(5000, function () {
                                    $("#findUser #message").html("");
                                });
                            }
                        } else {
                            $("#findUser #message").html("Lỗi hệ thống");
                            $(this).oneTime(5000, function () {
                                $("#findUser #message").html("");
                            });
                        }
                    },
                    failure: function () {
                        $("#findUser #message").html("Lỗi hệ thống");
                        $(this).oneTime(5000, function () {
                            $("#findUser #message").html("");
                        });
                    }
                });
            }
            function findUserKoin(username) {
//                var username = $("#findUser input[name=user]").val();
                console.log(username);
                $.ajax({
                    type: "GET",
                    url: "API/findUserKoin.php",
                    data: {
                        "username": username
                    },
                    dataType: 'text',
                    success: function (msg) {
                        msg = msg.trim();
                        if (msg != '' && msg.length > 2) {
                            var data = jQuery.parseJSON(msg);
                            if (data.status == 1) {
                                $("#balance").text(data.koin);
                                $("#koin_vip").text(data.koin_vip);
                                $("#mkoin").text(data.mkoin);
                                $("#mkoin_vip").text(data.mkoin_vip);
                                $("#vip").text(data.vip);
                            } else {
                                $("#findUser #message").html(data.message);
                                $(this).oneTime(5000, function () {
                                    $("#findUser #message").html("");
                                });
                            }
                        } else {
                            $("#findUser #message").html("Lỗi hệ thống");
                            $(this).oneTime(5000, function () {
                                $("#findUser #message").html("");
                            });
                        }
                    },
                    failure: function () {
                        $("#findUser #message").html("Lỗi hệ thống");
                        $(this).oneTime(5000, function () {
                            $("#findUser #message").html("");
                        });
                    }
                });
            }
            function findUserDB() {
                var username = $("#findUser input[name=user]").val();
                $("#userDetail").hide();
                $("#userDetailDB").hide();
                $('#findUserDBID').attr("disabled", true);
                $.ajax({
                    type: "GET",
                    url: "API/findUserDB.php",
                    data: {
                        "username": username
                    },
                    dataType: 'text',
                    success: function (msg) {
                        msg = msg.trim();
                        if (msg != '' && msg.length > 2) {
                            var data = jQuery.parseJSON(msg);
                            if (data.status == 1) {
                                $("#username").text(username);
                                $("#fullname").text(data.fullname);
                                $("#mobile").text(data.mobile);
                                $("#last_login").text(data.lastLogin);
                                $("#cp").text(data.cp);
                                $("#version").text(data.version);
                                $("#date").text(data.dateCreated);
                                $("#valueChargedSMS").text(data.smsmoney);
                                $("#valueChargedCard").text(data.cardmoney);
                                $("#valueIAPCard").text(data.iapmoney);
                                $("#valueSmsDate").text(data.smsDate);
                                $("#valueCardDate").text(data.cardDate);
                                $("#farmCount").text(data.farm);
                                $("#userType").text(data.type);
                                $("#lockTime").text(data.lock_time);                                 
                                $("#client_ip").text(data.clientIP);                                
                                $('#findUserDBID').attr("disabled", false);
                                $("#userDetailDB").slideDown(500);
                                findUserKoin(username);
                            } else {
                                $("#findUser #message").html(data.message);
                                $(this).oneTime(5000, function () {
                                    $("#findUser #message").html("");
                                    $('#findUserDBID').attr("disabled", false);
                                });
                            }
                        } else {
                            $("#findUser #message").html("Lỗi hệ thống");
                            $('#findUserDBID').attr("disabled", false);
                            $(this).oneTime(5000, function () {
                                $("#findUser #message").html("");
                            });
                        }
                    },
                    failure: function () {
                        $("#findUser #message").html("Lỗi hệ thống");
                        $('#findUserDBID').attr("disabled", false);
                        $(this).oneTime(5000, function () {
                            $("#findUser #message").html("");
                        });
                    }
                });
            }

            function findUserDBbyScreenName() {
                var screen_name = $("#findUser input[name=screen-name]").val();
                $("#userDetail").hide();
                $("#userDetailDB").hide();
                $('#findUserDBID').attr("disabled", true);
                $.ajax({
                    type: "GET",
                    url: "API/findUserDBbyScreen.php",
                    data: {
                        "screen_name": screen_name
                    },
                    dataType: 'text',
                    success: function (msg) {
                        msg = msg.trim();
                        if (msg != '' && msg.length > 2) {
                            var data = jQuery.parseJSON(msg);
                            if (data.status == 1) {
                                console.log(data.iapmoney);
                                $("#username").text(data.username);
                                $("#fullname").text(data.fullname);
                                $("#mobile").text(data.mobile);
                                $("#last_login").text(data.lastLogin);
                                $("#cp").text(data.cp);
                                $("#version").text(data.version);
                                $("#date").text(data.dateCreated);
                                $("#valueChargedSMS").text(data.smsmoney);
                                $("#valueChargedCard").text(data.cardmoney);
                                $("#valueIAPCard").text(data.iapmoney);
                                $("#valueSmsDate").text(data.smsDate);
                                $("#valueCardDate").text(data.cardDate);
                                $("#farmCount").text(data.farm);
                                $("#userType").text(data.type);
                                $("#lockTime").text(data.lock_time);
                                $('#findUserDBID').attr("disabled", false);
                                $("#userDetailDB").slideDown(500);
                                findUserKoin(data.username);
                            } else {
                                $("#findUser #message").html(data.message);
                                $(this).oneTime(5000, function () {
                                    $("#findUser #message").html("");
                                    $('#findUserDBID').attr("disabled", false);
                                });
                            }
                        } else {
                            $("#findUser #message").html("Lỗi hệ thống");
                            $('#findUserDBID').attr("disabled", false);
                            $(this).oneTime(5000, function () {
                                $("#findUser #message").html("");
                            });
                        }
                    },
                    failure: function () {
                        $("#findUser #message").html("Lỗi hệ thống");
                        $('#findUserDBID').attr("disabled", false);
                        $(this).oneTime(5000, function () {
                            $("#findUser #message").html("");
                        });
                    }
                });
            }

            function findUser() {
                var username = $("#findUser input[name=user]").val();
                $("#userDetail").slideUp();
                $("#userDetailDB").slideUp();
                $.ajax({
                    type: "GET",
                    url: "API/findUser.php",
                    data: {
                        "username": username
                    },
                    dataType: 'text',
                    success: function (msg) {
                        msg = msg.trim();
                        if (msg != '' && msg.length > 2) {
                            var data = jQuery.parseJSON(msg);
                            if (data.online == 1) {
                                $("#online").text(data.online);
                                $("#description").text(data.description);
                                $("#roomId").text(data.roomId);
                                $("#tableId").text(data.tableId);
                                $("#playing").text(data.tablePlaying);
                                $("#blind").text(data.tableBlind);
                                $("#userDetail").slideDown(500);
                            } else {
                                $("#findUser #message").html("User không tồn tại hoặc không online");
                                $(this).oneTime(5000, function () {
                                    $("#findUser #message").html("");
                                });
                            }
                        } else {
                            $("#findUser #message").html("Lỗi hệ thống");
                            $(this).oneTime(5000, function () {
                                $("#findUser #message").html("");
                            });
                        }
                    },
                    failure: function () {
                        $("#findUser #message").html("Lỗi hệ thống");
                        $(this).oneTime(5000, function () {
                            $("#findUser #message").html("");
                        });
                    }
                });
            }

            function kickUser() {
                var username = $("#kickUser input[name=user]").val();
                $.ajax({
                    type: "GET",
                    url: "API/kickUser.php",
                    data: {
                        "username": username
                    },
                    dataType: 'text',
                    success: function (msg) {
                        msg = msg.trim();
                        if (msg != '' && msg.length > 2) {
                            var data = jQuery.parseJSON(msg);
                            if (data.status == 1) {
                                $("#kickUser #message").html("Kick user thành công");
                                $(this).oneTime(5000, function () {
                                    $("#kickUser #message").html("");
                                });
                            } else {
                                $("#kickUser #message").html(data.message);
                                $(this).oneTime(5000, function () {
                                    $("#kickUser #message").html("");
                                });
                            }
                        } else {
                            $("#kickUser #message").html("Lỗi hệ thống");
                            $(this).oneTime(5000, function () {
                                $("#kickUser #message").html("");
                            });
                        }
                    },
                    failure: function () {
                        $("#kickUser #message").html("Lỗi hệ thống");
                        $(this).oneTime(5000, function () {
                            $("#kickUser #message").html("");
                        });
                    }
                });
            }
            function blockUserName(u, causeid) {
                if (confirm('Are you sure block ' + u + '?')) {
                    var username = u;
                    var cause = $("input[name=" + causeid + "]").val();
                    var type = 1;
                    var datetype = 2;
                    var date = 12;
                    $.ajax({
                        type: "POST",
                        url: "API/blockUser.php",
                        data: {
                            "username": username,
                            "type": type,
                            "datetype": datetype,
                            "cause": cause,
                            "date": date
                        },
                        dataType: 'text',
                        success: function (msg) {
                            msg = msg.trim();
                            if (msg != '' && msg.length > 2) {
                                var data = jQuery.parseJSON(msg);
                                if (data.status == 1) {
                                    alert("Block user thành công");
                                    $(this).oneTime(5000, function () {
                                        $("#blockUser #message").html("");
                                    });
                                } else {
                                    alert(data.message);
                                    $(this).oneTime(5000, function () {
                                        $("#blockUser #message").html("");
                                    });
                                }
                            } else {
                                alert("Lỗi hệ thống");
                                $(this).oneTime(5000, function () {
                                    $("#blockUser #message").html("");
                                });
                            }
                        },
                        failure: function () {
                            alert("Lỗi hệ thống");
                            $(this).oneTime(5000, function () {
                                $("#blockUser #message").html("");
                            });
                        }
                    });
                }
            }

            function selectListUserNamePassport() {
                $("input:checkbox[name=usernamepassport]").each(function ()
                {
                    $(this).attr('checked', 'checked');
                });
            }
            function selectListUserName() {
                $("input:checkbox[name=username]").each(function ()
                {
                    $(this).attr('checked', 'checked');
                });
            }
            function selectListUserNameMobile() {
                $("input:checkbox[name=usernamemobile]").each(function ()
                {
                    $(this).attr('checked', 'checked');
                });
            }
            function selectListUserNameSMSMobile() {
                $("input:checkbox[name=usernamesmsmobile]").each(function ()
                {
                    $(this).attr('checked', 'checked');
                });
            }

            function blockListUserNamePassport() {
                var str = '';
                if (confirm('Are you sure?')) {
                    var cause = $("#causeallpassport").val();
                    $("input:checkbox[name=usernamepassport]:checked").each(function ()
                    {
                        var username = $(this).val();
                        var type = 1;
                        var datetype = 2;
                        var date = 12;
                        $.ajax({
                            type: "POST",
                            url: "API/blockUser.php",
                            data: {
                                "username": username,
                                "type": type,
                                "datetype": datetype,
                                "cause": cause,
                                "date": date
                            },
                            dataType: 'text',
                            success: function (msg) {
                                msg = msg.trim();
                                if (msg != '' && msg.length > 2) {
                                    var data = jQuery.parseJSON(msg);
                                    if (data.status == 1) {
                                        str += username + ', ';
                                        alert('Block thành công user');
                                    }
                                }
                            }
                        });
                    });

                }
            }
            function blockListUserNameMobile() {
                var str = '';
                if (confirm('Are you sure?')) {
                    var cause = $("#causeallmobile").val();
                    $("input:checkbox[name=usernamemobile]:checked").each(function ()
                    {
                        var username = $(this).val();
                        var type = 1;
                        var datetype = 2;
                        var date = 12;
                        $.ajax({
                            type: "POST",
                            url: "API/blockUser.php",
                            data: {
                                "username": username,
                                "type": type,
                                "datetype": datetype,
                                "cause": cause,
                                "date": date
                            },
                            dataType: 'text',
                            success: function (msg) {
                                msg = msg.trim();
                                if (msg != '' && msg.length > 2) {
                                    var data = jQuery.parseJSON(msg);
                                    if (data.status == 1) {
                                        str += username + ', ';
                                        alert('Block thành công user');
                                    }
                                }
                            }
                        });
                    });
                }
            }
            function blockListUserNameSMSMobile() {
                var str = '';
                if (confirm('Are you sure?')) {
                    var cause = $("#causeallsmsmobile").val();
                    $("input:checkbox[name=usernamesmsmobile]:checked").each(function ()
                    {
                        var username = $(this).val();
                        var type = 1;
                        var datetype = 2;
                        var date = 12;
                        $.ajax({
                            type: "POST",
                            url: "API/blockUser.php",
                            data: {
                                "username": username,
                                "type": type,
                                "datetype": datetype,
                                "cause": cause,
                                "date": date
                            },
                            dataType: 'text',
                            success: function (msg) {
                                msg = msg.trim();
                                if (msg != '' && msg.length > 2) {
                                    var data = jQuery.parseJSON(msg);
                                    if (data.status == 1) {
                                        str += username + ', ';
                                    }
                                }
                            }
                        });
                    });
                    alert('Block thành công user');
                }
            }
            function blockListUserName() {
                var str = '';
                if (confirm('Are you sure?')) {
                    var cause = $("#causeall").val();
                    $("input:checkbox[name=username]:checked").each(function ()
                    {
                        var username = $(this).val();
                        var type = 1;
                        var datetype = 2;
                        var date = 12;
                        $.ajax({
                            type: "POST",
                            url: "API/blockUser.php",
                            data: {
                                "username": username,
                                "type": type,
                                "datetype": datetype,
                                "cause": cause,
                                "date": date
                            },
                            dataType: 'text',
                            success: function (msg) {
                                msg = msg.trim();
                                if (msg != '' && msg.length > 2) {
                                    var data = jQuery.parseJSON(msg);
                                    if (data.status == 1) {
                                        str += username + ', ';
                                    }
                                }
                            }
                        });
                    });
                    alert('Block thành công user');
                }
            }
            function blockUser() {
                var username = $("#blockUser input[name=user]").val();
                var type = $("#blockUser select[name=type]").val();
                var datetype = $("#blockUser select[name=datetype]").val();
                var date = $("#blockUser input[name=date]").val();
                var cause = $("#blockUser input[name=cause]").val();
                $.ajax({
                    type: "POST",
                    url: "API/blockUser.php",
                    data: {
                        "username": username,
                        "type": type,
                        "datetype": datetype,
                        "cause": cause,
                        "date": date
                    },
                    dataType: 'text',
                    success: function (msg) {
                        msg = msg.trim();
                        if (msg != '' && msg.length > 2) {
                            var data = jQuery.parseJSON(msg);
                            if (data.status == 1) {
                                $("#blockUser #message").html("Block user thành công");
                                $(this).oneTime(5000, function () {
                                    $("#blockUser #message").html("");
                                });
                            } else {
                                $("#blockUser #message").html(data.message);
                                $(this).oneTime(5000, function () {
                                    $("#blockUser #message").html("");
                                });
                            }
                        } else {
                            $("#blockUser #message").html("Lỗi hệ thống");
                            $(this).oneTime(5000, function () {
                                $("#blockUser #message").html("");
                            });
                        }
                    },
                    failure: function () {
                        $("#blockUser #message").html("Lỗi hệ thống");
                        $(this).oneTime(5000, function () {
                            $("#blockUser #message").html("");
                        });
                    }
                });
            }

            function sendMessage() {
                var username = $("#sendMessage input[name=user]").val();
                var message = $("#sendMessage textarea[name=message]").val();
                $.ajax({
                    type: "GET",
                    url: "API/sendMessageToUser.php",
                    data: {
                        "message": message,
                        "username": username
                    },
                    dataType: 'text',
                    success: function (msg) {
                        msg = msg.trim();
                        if (msg != '' && msg.length > 2) {
                            var data = jQuery.parseJSON(msg);
                            if (data.status == 1) {
                                $("#sendMessage #message").html("Gửi tin nhắn thành công");
                                $(this).oneTime(5000, function () {
                                    $("#sendMessage #message").html("");
                                });
                            } else {
                                $("#sendMessage #message").html(data.message);
                                $(this).oneTime(5000, function () {
                                    $("#sendMessage #message").html("");
                                });
                            }
                        } else {
                            $("#sendMessage #message").html("Lỗi hệ thống");
                            $(this).oneTime(5000, function () {
                                $("#sendMessage #message").html("");
                            });
                        }
                    },
                    failure: function () {
                        $("#sendMessage #message").html("Lỗi hệ thống");
                        $(this).oneTime(5000, function () {
                            $("#sendMessage #message").html("");
                        });
                    }
                });
            }

            function sendMessageToAll() {
                var message = $("#sendMessageToAll textarea[name=message]").val();
                $.ajax({
                    type: "GET",
                    url: "API/sendMessageToAll.php",
                    data: {
                        "message": message
                    },
                    dataType: 'text',
                    success: function (msg) {
                        msg = msg.trim();
                        if (msg != '' && msg.length > 2) {
                            var data = jQuery.parseJSON(msg);
                            if (data.status == 1) {
                                $("#sendMessageToAll #message").html("Gửi tin nhắn thành công");
                                $(this).oneTime(5000, function () {
                                    $("#sendMessageToAll #message").html("");
                                });
                            } else {
                                $("#sendMessageToAll #message").html(data.message);
                                $(this).oneTime(5000, function () {
                                    $("#sendMessageToAll #message").html("");
                                });
                            }
                        } else {
                            $("#sendMessageToAll #message").html("Lỗi hệ thống");
                            $(this).oneTime(5000, function () {
                                $("#sendMessageToAll #message").html("");
                            });
                        }
                    },
                    failure: function () {
                        $("#sendMessageToAll #message").html("Lỗi hệ thống");
                        $(this).oneTime(5000, function () {
                            $("#sendMessageToAll #message").html("");
                        });
                    }
                });
            }

            function findGuild() {
                var guild_name = $("#changeIcon input[name=guild_name]").val();
                $("#guildDetail").slideUp();
                $.ajax({
                    type: "GET",
                    url: "API/findGuild.php",
                    data: {
                        "guild_name": guild_name
                    },
                    dataType: 'text',
                    success: function (msg) {
                        msg = msg.trim();
                        if (msg != '' && msg.length > 2) {
                            var data = jQuery.parseJSON(msg);
                            if (data.status == 1) {
                                $("#guildDetail #name").text(data.name);
                                $("#guildDetail #owner").text(data.owner);
                                $("#guildDetail #icon").text(data.icon.substring(6));
                                $("#changeIcon #message").html("");
                                $("#guildDetail").slideDown(500);
                            } else {
                                $("#changeIcon #message").html("Bang không tồn tại");
                            }
                        } else {
                            $("#changeIcon #message").html("Lỗi hệ thống");
                            $(this).oneTime(5000, function () {
                                $("#changeIcon #message").html("");
                            });
                        }
                    },
                    failure: function () {
                        $("#changeIcon #message").html("Lỗi hệ thống");
                        $(this).oneTime(5000, function () {
                            $("#changeIcon #message").html("");
                        });
                    }
                });
            }

            function changeIcon() {
                var guild_name = $("#changeIcon input[name=guild_name]").val();
                var icon_id = $("#changeIcon input[name=icon_id]").val();
                $.ajax({
                    type: "POST",
                    url: "API/changeIcon.php",
                    data: {
                        "guild_name": guild_name,
                        "icon_id": icon_id

                    },
                    dataType: 'text',
                    success: function (msg) {
                        msg = msg.trim();
                        if (msg != '' && msg.length > 2) {
                            var data = jQuery.parseJSON(msg);
                            if (data.status == 1) {
                                $("#changeIcon #message").html("Thay đổi huy hiệu thành công");
                                $(this).oneTime(5000, function () {
                                    $("#changeIcon #message").html("");
                                });
                            } else {
                                $("#changeIcon #message").html(data.message);
                                $(this).oneTime(5000, function () {
                                    $("#changeIcon #message").html("");
                                });
                            }
                        } else {
                            $("#changeIcon #message").html("Lỗi hệ thống");
                            $(this).oneTime(5000, function () {
                                $("#changeIcon #message").html("");
                            });
                        }
                    },
                    failure: function () {
                        $("#changeIcon #message").html("Lỗi hệ thống");
                        $(this).oneTime(5000, function () {
                            $("#changeIcon #message").html("");
                        });
                    }
                });
            }
            
            function changePassUser() {
                var username = $("#changeUserPassForm input[name=username]").val();
                var pass = $("#changeUserPassForm input[name=pass]").val();
                var confirm_pass = $("#changeUserPassForm input[name=confirm_pass]").val();
                $.ajax({
                    type: "POST",
                    url: "API/changePass.php",
                    data: {
                        "username": username,
                        "pass": pass,
                        "confirm_pass": confirm_pass
                    },
                    dataType: 'text',
                    success: function (msg) {                        
                        var data = jQuery.parseJSON(msg);
                        $("#changeUserPassForm #message").html(data.message);
                    },
                    failure: function () {
                        $("#changeUserPassForm #message").html("<span>Không truy cập được dữ liệu</span>");                        
                    }
                });
            }
            
            function setVipUser() {
                var username = $("#setVipUser input[name=username]").val();
                var type = $("#setVipUser select[name=type]").val();                
                $.ajax({
                    type: "POST",
                    url: "API/setVIP.php",
                    data: {
                        "username": username,
                        "type": type
                    },
                    dataType: 'text',
                    success: function (msg) {                        
                        var data = jQuery.parseJSON(msg);
                        $("#setVipUser #message").html(data.message);
                    },
                    failure: function () {
                        $("#changeUserPassForm #message").html("<span>Không truy cập được dữ liệu</span>");                        
                    }
                });
            }
            
            
            function findUserMobile() {
                var phonenumber = $("#findPhoneData input[name=phonenumber]").val();
                var fdate = $("#findPhoneData input[name=fromDate]").val();
                var tdate = $("#findPhoneData input[name=toDate]").val();
                $("#btnFindMobileDataSMS").attr("disabled", true);
                $.ajax({
                    type: "GET",
                    url: "API/findUserMobile.php",
                    data: {
                        "phonenumber": phonenumber,
                        "fdate": fdate,
                        "tdate": tdate
                    },
                    dataType: 'text',
                    success: function (msg) {
                        $("#phoneDataDetail").html(msg);
                        $("#btnFindMobileDataSMS").attr("disabled", false);
                    },
                    failure: function () {
                        $("#phoneDataDetail").html("<span>Không truy cập được dữ liệu</span>");
                        $("#btnFindMobileDataSMS").attr("disabled", false);
                    }
                });
            }

            function statUser() {
                var balance_koin = $("#statUser input[name=balance_koin]").val();
                var range_koin = $("#statUser input[name=range_koin]").val();
                $("#btnFindMobileDataSMS").attr("disabled", true);
                $.ajax({
                    type: "GET",
                    url: "API/getListUserByKoin.php",
                    data: {
                        "balance_koin": balance_koin,
                        "range_koin": range_koin,
                    },
                    dataType: 'text',
                    success: function (msg) {
                        $("#statUserList").html(msg);
                        $("#statUserList").show();
                    },
                    failure: function () {
                        $("#phoneDataDetail").html("<span>Không truy cập được dữ liệu</span>");
                        $("#btnFindMobileDataSMS").attr("disabled", false);
                    }
                });

            }

            function statUser2() {
                var balance_koin = $("#statUser input[name=balance_koin_vip]").val();
                var range_koin = $("#statUser input[name=range_koin_vip]").val();
                $("#btnFindMobileDataSMS").attr("disabled", true);
                $.ajax({
                    type: "GET",
                    url: "API/getListUserByKoinVip.php",
                    data: {
                        "balance_koin_vip": balance_koin,
                        "range_koin_vip": range_koin,
                    },
                    dataType: 'text',
                    success: function (msg) {
                        $("#statUserList").html(msg);
                        $("#statUserList").show();
                    },
                    failure: function () {
                        $("#phoneDataDetail").html("<span>Không truy cập được dữ liệu</span>");
                        $("#btnFindMobileDataSMS").attr("disabled", false);
                    }
                });

            }

            function findMobileUser() {
                var username = $("#findUserPhoneData input[name=username]").val();
                $("#btnFindUserMobileDataSMS").attr("disabled", true);
                $.ajax({
                    type: "GET",
                    url: "API/findMobileUser.php",
                    data: {
                        "username": username
                    },
                    dataType: 'text',
                    success: function (msg) {
                        $("#userphoneDataDetail").html(msg);
                        $("#btnFindUserMobileDataSMS").attr("disabled", false);
                    },
                    failure: function () {
                        $("#userphoneDataDetail").html("<span>Không truy cập được dữ liệu</span>");
                        $("#btnFindUserMobileDataSMS").attr("disabled", false);
                    }
                });
            }

            function lockPassport()
            {
                var passport = $("#findUserPassport input[name=passport]").val();
                var cause = $("#findUserPassport input[name=cause]").val();
                if (confirm('Are you sure lock passport: ' + passport + '?')) {
                    $.ajax({
                        type: "GET",
                        url: "API/lockPassport.php",
                        data: {
                            "type": "lock",
                            "passport": passport,
                            "cause": cause
                        },
                        dataType: 'text',
                        success: function (msg) {
                            $("#userPassport").html(msg);
                        },
                        failure: function () {
                            $("#userSMS").html("<span>Không truy cập được dữ liệu</span>");
                        }
                    });
                }
            }

            function unlockPassport()
            {
                var passport = $("#findUserPassport input[name=passport]").val();
                if (confirm('Are you sure unlock passport: ' + passport + '?')) {
                    $.ajax({
                        type: "GET",
                        url: "API/lockPassport.php",
                        data: {
                            "type": "unlock",
                            "passport": passport
                        },
                        dataType: 'text',
                        success: function (msg) {
                            $("#userPassport").html(msg);
                        },
                        failure: function () {
                            $("#userSMS").html("<span>Không truy cập được dữ liệu</span>");
                        }
                    });
                }
            }

            function findListUserPassport()
            {
                var passport = $("#findUserPassport input[name=passport]").val();
                $("#btnFindUserPassport").attr("disabled", true);
                $.ajax({
                    type: "GET",
                    url: "API/findListUserPassport.php",
                    data: {
                        "passport": passport
                    },
                    dataType: 'text',
                    success: function (msg) {
                        $("#userPassport").html(msg);
                        $("#btnFindUserPassport").attr("disabled", false);
                    },
                    failure: function () {
                        $("#userSMS").html("<span>Không truy cập được dữ liệu</span>");
                        $("#btnFindUserPassport").attr("disabled", false);
                    }
                });
            }

            function findListUserSMS()
            {
                var mobile = $("#findUserSMS input[name=mobile]").val();
                $("#btnFindUserSMS").attr("disabled", true);
                $.ajax({
                    type: "GET",
                    url: "API/findListUserSMS.php",
                    data: {
                        "mobile": mobile
                    },
                    dataType: 'text',
                    success: function (msg) {
                        $("#userSMS").html(msg);
                        $("#btnFindUserSMS").attr("disabled", false);
                    },
                    failure: function () {
                        $("#userSMS").html("<span>Không truy cập được dữ liệu</span>");
                        $("#btnFindUserSMS").attr("disabled", false);
                    }
                });
            }
            function findListUser()
            {
                var username = $("#findUser input[name=username]").val();
                if (username.length < 1)
                {
                    $("#userData").html("<b>Phải nhập ít nhất 1 ký tự</b>");
                } else
                {
                    $("#btnFindListUser").attr("disabled", true);
                    $.ajax({
                        type: "GET",
                        url: "API/findListUser.php",
                        data: {
                            "username": username
                        },
                        dataType: 'text',
                        success: function (msg) {
                            $("#userData").html(msg);
                            $("#btnFindListUser").attr("disabled", false);
                        },
                        failure: function () {
                            $("#userData").html("<span>Không truy cập được dữ liệu</span>");
                            $("#btnFindListUser").attr("disabled", false);
                        }
                    });
                }
            }
            function getExchange() {
                var fromDate = $("#koin_vip_exchange input[name=fromDate]").val();
                var toDate = $("#koin_vip_exchange input[name=toDate]").val();

                $("#btnFindListUser").attr("disabled", true);
                $.ajax({
                    type: "GET",
                    url: "API/getListExchange.php",
                    data: {
                        "fromDate": fromDate,
                        "toDate": toDate,
                    },
                    dataType: 'text',
                    success: function (msg) {
                        $("#exchangeUserList").html(msg);
                        $("#exchangeUserList").show();
                    },
                    failure: function () {
                        $("#exchangeUserList").html("<span>Không truy cập được dữ liệu</span>");
                        $("#btnFindListUser").attr("disabled", false);
                    }
                });

            }

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
            }
            
            function listReg() {
                var fromDate = $("#RegUser input[name=fromDate]").val();
                var toDate = $("#RegUser input[name=toDate]").val();                
                $.ajax({
                    type: "GET",
                    url: "API/listReg.php",
                    data: {
                        "type": 1,
                        "fromDate": fromDate,
                        "toDate": toDate
                    },
                    dataType: 'text',
                    success: function (msg) {
                        $("#RegUserList").html(msg);
                        $("#RegUserList").show();
                    },
                    failure: function () {
                        $("#RegUserList").html("<span>Không truy cập được dữ liệu</span>");
                        $("#RegUserList").attr("disabled", false);
                    }
                });
            }
            
            $("a.user-reg-pagination-link").live("click", function (e) {
                e.preventDefault();
                var page = $(this).attr('page');
                var fromDate = $("#RegUser input[name=fromDate]").val();
                var toDate = $("#RegUser input[name=toDate]").val(); 
                $.ajax({
                    type: "GET",
                    url: "API/listReg.php",
                    data: {
                        "page": page,
                        "type":1,
                        "fromDate": fromDate,
                        "toDate": toDate
                    },
                    dataType: 'text',
                    success: function (msg) {
                        $("#RegUserList").html(msg);
                        $("#RegUserList").show();
                    },
                    failure: function () {
                        $("#RegUserList").html("<span>Không truy cập được dữ liệu</span>");
                        $("#RegUserList").attr("disabled", false);
                    }
                });
            });
            
            function listRegbyPassport() {
                var fromDate = $("#RegUser input[name=fromDate]").val();
                var toDate = $("#RegUser input[name=toDate]").val();                
                $.ajax({
                    type: "GET",
                    url: "API/listReg.php",
                    data: {
                        "type": 2,
                        "fromDate": fromDate,
                        "toDate": toDate
                    },
                    dataType: 'text',
                    success: function (msg) {
                        $("#RegUserList").html(msg);
                        $("#RegUserList").show();
                    },
                    failure: function () {
                        $("#RegUserList").html("<span>Không truy cập được dữ liệu</span>");
                        $("#RegUserList").attr("disabled", false);
                    }
                });
            }
            
            $("a.user-reg-pagination-link").live("click", function (e) {
                e.preventDefault();
                var page = $(this).attr('page');
                var fromDate = $("#RegUser input[name=fromDate]").val();
                var toDate = $("#RegUser input[name=toDate]").val(); 
                $.ajax({
                    type: "GET",
                    url: "API/listReg.php",
                    data: {
                        "page": page,
                        "type": 2,
                        "fromDate": fromDate,
                        "toDate": toDate
                    },
                    dataType: 'text',
                    success: function (msg) {
                        $("#RegUserList").html(msg);
                        $("#RegUserList").show();
                    },
                    failure: function () {
                        $("#RegUserList").html("<span>Không truy cập được dữ liệu</span>");
                        $("#RegUserList").attr("disabled", false);
                    }
                });
            });
            
            $("input.show-bypassport").live("click", function(e) {
                e.preventDefault();
                var id = $(this).attr('data-index');                
                $(this).next().show();
                $(this).hide();
                $('#content-passport-'+id).show();
            });
            $("input.hide-bypassport").live("click", function(e) {
                e.preventDefault();
                var id = $(this).attr('data-index');                
                $(this).prev().show();
                $(this).hide();
                $('#content-passport-'+id).hide();
            });
            
            $("a.pagination-link").live("click", function (e) {
                e.preventDefault();
                var page = $(this).attr('page');
                var balance_koin = $(this).attr('balance_koin');
                var range_koin = $(this).attr('range_koin');
                $("#btnFindMobileDataSMS").attr("disabled", true);
                $.ajax({
                    type: "GET",
                    url: "API/getListUserByKoin.php",
                    data: {
                        "page": page,
                        "balance_koin": balance_koin,
                        "range_koin": range_koin,
                    },
                    dataType: 'text',
                    success: function (msg) {
                        $("#statUserList").html(msg);
                        $("#statUserList").show();
                    },
                    failure: function () {
                        $("#phoneDataDetail").html("<span>Không truy cập được dữ liệu</span>");
                        $("#btnFindMobileDataSMS").attr("disabled", false);
                    }
                });
            });
            $("a.pagination-link-vip").live("click", function (e) {
                e.preventDefault();
                var page = $(this).attr('page');
                var balance_koin = $(this).attr('balance_koin');
                var range_koin = $(this).attr('range_koin');
                $("#btnFindMobileDataSMS").attr("disabled", true);
                $.ajax({
                    type: "GET",
                    url: "API/getListUserByKoinVip.php",
                    data: {
                        "page": page,
                        "balance_koin_vip": balance_koin,
                        "range_koin_vip": range_koin,
                    },
                    dataType: 'text',
                    success: function (msg) {
                        $("#statUserList").html(msg);
                        $("#statUserList").show();
                    },
                    failure: function () {
                        $("#phoneDataDetail").html("<span>Không truy cập được dữ liệu</span>");
                        $("#btnFindMobileDataSMS").attr("disabled", false);
                    }
                });
            });
            
            $("input#hidelog").live("click", function (e) {
                e.preventDefault();
                $("pre.logKoin").hide();
                $('input#hidelog').hide();
            });
            $(document).ready(function () {
                $("#datepicker1").datepicker();
                $("#datepicker2").datepicker();
                $("#datepicker3").datepicker();
                $(".datepicker").datepicker();
            });

        </script>
    </head>
    <body>
        <div class="pagewrap">
            <?php require('topMenu.php'); ?>
            <div class="box">
                <div class="box_header" style="background-image: none;"><a href="javascript:void(0);">Cộng xu</a></div>
                <div class="box_body">
                    <form id="addKoin">
                        Username <input type="text" name="user" style="width: 100px"/>
                        Password Admin <input type="password" name="pass" style="width: 100px"/>
                        Xu <input type="text" name="koin" style="width: 100px"/>
                        Lý do <input type="text" name="cause" style="width: 100px"/>
                        <input type="button" name="add" value="Thêm" onclick="addKoin();"/>
                        <span id="message" style="color: #800000; font-weight: bold"></span>
                    </form>
                </div>
            </div>
            <div class="box">
                <div class="box_header" style="background-image: none;"><a href="javascript:void(0);">Cộng/Trừ Chip</a></div>
                <div class="box_body">
                    <form id="addChip">
                        Username <input type="text" name="user" style="width: 100px"/>
                        Password Admin <input type="password" name="pass" style="width: 100px"/>
                        Chip <input type="text" name="koin" style="width: 100px"/>
                        Lý do <input type="text" name="cause" style="width: 100px"/>
                        <input type="button" name="add" value="Cộng Chip" onclick="addKoinVip();"/>
                        <input type="button" name="add" value="Trừ Chip" onclick="reduceKoinVip();"/>
                        <span id="message" style="color: #800000; font-weight: bold"></span>
                    </form>
                </div>
            </div>
            <div class="box grid">
                <div class="box_header"><a href="javascript:void(0);">Tìm kiếm</a></div>
                <div class="box_body">
                    <form id="findUser">
                        Screen Name <input type="text" name="screen-name" style="width: 100px"/>
                        <input type="button" name="add" value="Tìm trong DB" id="findUserDBID" onclick="findUserDBbyScreenName();"/><br /> 
                        Username <input type="text" name="user" style="width: 100px"/>
                        <input type="button" name="add" value="Tìm trong game" onclick="findUser();"/>
                        <input type="button" name="add" value="Tìm trong DB" id="findUserDBID" onclick="findUserDB();"/><br />

                        Password Admin <input type="password" name="adminpass" id="adminpass" style="width: 100px"/>
                        <input type="button" name="add" value="Đổi mật khẩu" onclick="findUserPassword();"/>
                        <span id="message" style="color: #800000; font-weight: bold"></span>
                    </form>
                    <div id="userDetail" style="display: none;">
                        <table width="100%">
                            <tr>
                                <td width="10%">Online</td>
                                <td width="20%" align="center"><span id="online"></span></td>
                                <td width="10%">Description</td>
                                <td><span id="description"></span></td>
                            </tr>
                            <tr>
                                <td width="10%">RoomId</td>
                                <td width="20%" align="center"><span id="roomId"></span></td>
                                <td width="10%">TableId</td>
                                <td align="center"><span id="tableId"></span></td>
                            </tr>
                            <tr>
                                <td width="10%">Playing</td>
                                <td width="20%" align="center"><span id="playing"></span></td>
                                <td width="10%">Blind</td>
                                <td align="center"><span id="blind"></span></td>
                            </tr>
                        </table>
                    </div>
                    <div id="userDetailDB" style="display: none;">
                        <table width="100%">
                            <tr>
                                <td width="10%">Username</td>
                                <td width="20%" align="center"><span id="username"></span></td>
                                <td width="10%">Screenname</td>
                                <td align="center"><span id="fullname"></span></td>
                            </tr>
                            <tr>
                                <td width="10%">Mobile</td>
                                <td width="20%" align="center"><span id="mobile"></span></td>
                                <td width="10%">CP</td>
                                <td align="center"><span id="cp"></span></td>
                            </tr>
                            <tr>
                                <td width="10%">Client Version</td>
                                <td width="20%" align="center"><span id="version"></span></td>
                                <td width="10%">Date Register</td>
                                <td align="center"><span id="date"></span></td>
                            </tr>
                            <tr>
                                <td width="10%">Xu</td>
                                <td width="20%" align="center"><span id="balance"></span></td>
                                <td width="10%">Last login</td>
                                <td align="center"><span id="last_login"></span></td>
                            </tr>
                            <tr>
                                <td width="10%">Chip</td>
                                <td width="20%" align="center"><span id="koin_vip"></span></td>
                                <td width="10%">Số tiền nạp SMS</td>
                                <td align="center"><span id="valueChargedSMS"></span></td>
                            </tr>
                            <tr>
                                <td width="10%">Mini Xu</td>
                                <td width="20%" align="center"><span id="mkoin"></span></td>
                                <td width="10%">Mini Chip</td>
                                <td align="center"><span id="mkoin_vip"></span></td>
                            </tr>
                            <tr>

                                <td width="20%">Lần nạp SMS cuối cùng</td>
                                <td width="" align="center"><span id="valueSmsDate"></span></td>
                                <td width="10%">Số tiền nạp thẻ cào</td>
                                <td align="center"><span id="valueChargedCard"></span></td>
                            </tr>
                            <tr>
                                <td width="10%">Số tiền nạp IAP</td>
                                <td align="center"><span id="valueIAPCard"></span></td>
                                <td width="20%">Lần nạp thẻ cuối cùng</td>
                                <td width="" align="center"><span id="valueCardDate"></span></td>

                            </tr>
                            <tr>
                                <td width="10%">Số account farm</td>
                                <td align="center"><span id="farmCount"></span></td>
                                <td width="10%">Loại user</td>
                                <td align="center"><span id="userType"></span></td>

                            </tr>
                            <tr>
                                <td width="10%">VIP</td>
                                <td align="center"><span id="vip"></span></td>
                                <td width="10%">Bị khoá đến</td>
                                <td align="center"><span id="lockTime"></span></td>                                
                            </tr>
                            <tr>
                                <td width="10%">Client IP</td>
                                <td align="center"><span id="client_ip"></span></td>       
                                <td width="10%"></td>
                                <td align="center"><span id="client_ip2"></span></td>   
                            </tr>
                        </table>
                    </div>
                    <div id="userPassword" style="display: none; padding-top:3px;"></div>
                </div>
            </div>

            <div class="box grid">
                <div class="box_header"><a href="javascript:void(0);">Đổi Mật khẩu</a></div>
                <div class="box_body" style="display: none">                    
                    <form id="changeUserPassForm">
                        Username:
                        <input type="text" name="username" value="" />
                        Mật khẩu mới:
                        <input type="password" name="pass" value="" />
                        Xác nhận mật khẩu mới:
                        <input type="password" name="confirm_pass" value="" />
                        <input type="button" name="add" id="btnChangePassUser" value="Search" onclick="changePassUser();"/>
                        <span id="message" style="color: #800000; font-weight: bold"></span>
                    </form>
                </div>
            </div>
            
            <div class="box grid">
                <div class="box_header"><a href="javascript:void(0);">Set VIP</a></div>
                <div class="box_body" style="display: none">                    
                    <form id="setVipUser">
                        Username:
                        <input type="text" name="username" value="" />
                        Số lượng
                        <select name="type">
                            <option value="0" selected="selected">VIP 0</option>
                            <option value="1">VIP 1</option>
                            <option value="2">VIP 2</option>
                            <option value="3">VIP 3</option>
                            <option value="4">VIP 4</option>
                            <option value="5">VIP 5</option>
                            <option value="6">VIP 6</option>
                            <option value="7">VIP 7</option>
                            <option value="8">VIP 8</option>
                        </select>
                        <input type="button" name="add" value="Set VIP" onclick="setVipUser();"/>
                        <span id="message" style="color: #800000; font-weight: bold"></span>
                    </form>
                </div>
            </div>

            <div class="box grid">
                <div class="box_header"><a href="javascript:void(0);">Tìm kiếm theo số điện thoại</a></div>
                <div class="box_body" style="display: none">                    
                    <form id="findPhoneData">
                        Số điện thoại:
                        <input type="text" name="phonenumber" value="" />
                        <input type="button" name="add" id="btnFindMobileDataSMS" value="Search" onclick="findUserMobile();"/>
                        <span id="message" style="color: #800000; font-weight: bold"></span>
                    </form>                    
                    <div id="phoneData">
                        <div id="phoneDataDetail"></div>                        
                    </div>
                    <div id="userPassword" style="display: none; padding-top:3px;"></div>
                </div>
            </div>


            <div class="box grid">
                <div class="box_header"><a href="javascript:void(0);">Tìm kiếm list user</a></div>
                <div class="box_body" style="display: none">
                    <form id="findUser">
                        Username:
                        <input type="text" name="username" value="" />
                        <input type="button" name="add" id="btnFindListUser" value="Search" onclick="findListUser();"/>
                    </form>                    
                    <div id="userData">
                        <div id="userDetail"></div>                        
                    </div>
                </div>
            </div>
            
            <div class="box grid">
                <div class="box_header"><a href="javascript:void(0);">Thống kế User Đăng ký mới</a></div>
                <div class="box_body" style="display: none">
                    <form id="RegUser">
                        Từ Ngày
                        <input type="text" class="datepicker" name="fromDate" value="<?php echo $today; ?>" style="text-align: center; width: 100px;" />
                        Đến Ngày
                        <input type="text" class="datepicker" name="toDate" value="<?php echo $today; ?>" style="text-align: center; width: 100px;" />
                        <input type="button" name="add" value="DS Đăng ký" onclick="listReg();"/>
                        <input type="button" name="add" value="DS Đăng ký theo Passport" onclick="listRegbyPassport();"/>
                    </form>                    
                    <div id="RegUserList">
                                            
                    </div>
                </div>
            </div>

            <div class="box grid">
                <div class="box_header"><a href="javascript:void(0);">Thống kê User</a></div>
                <div class="box_body" style="display: none">
                    <form id="statUser">						
                        Số xu <input type="text" name="balance_koin" style="width: 100px"/>
                        Khoảng <input type="text" name="range_koin" style="width: 100px"/>
                        <input type="button" name="add" value="Thống kê" onclick="statUser();"/>
                        <br />
                        Số chip <input type="text" name="balance_koin_vip" style="width: 100px"/>
                        Khoảng <input type="text" name="range_koin_vip" style="width: 100px"/>
                        <input type="button" name="add" value="Thống kê" onclick="statUser2();"/>

                        <span id="message" style="color: #800000; font-weight: bold"></span>
                    </form>
                </div>
                <div id="statUserList" style="display: none;">

                </div>
            </div>            

            <div class="box grid">
                <div class="box_header"><a href="javascript:void(0);">Gửi tin nhắn cho 1 người chơi</a></div>
                <div class="box_body" style="display: none">
                    <form id="sendMessage">
                        <table>
                            <tr>
                                <td valign="top">Username</td>
                                <td valign="top"><input type="text" name="user" style="width: 100px"/></td>
                            </tr>
                            <tr>
                                <td valign="top">Message</td>
                                <td valign="top"><textarea type="text" name="message" style="width: 600px"></textarea></td>
                            </tr>
                        </table>
                        <input type="button" name="add" value="Gửi" onclick="sendMessage();"/>
                        <span id="message" style="color: #800000; font-weight: bold"></span>
                    </form>
                </div>
            </div>
            <div class="box grid">
                <div class="box_header"><a href="javascript:void(0);">Gửi tin nhắn cho tất cả</a></div>
                <div class="box_body" style="display: none">
                    <form id="sendMessageToAll">
                        <table>
                            <tr>
                                <td valign="top">Message</td>
                                <td valign="top"><textarea type="text" name="message" style="width: 600px"></textarea></td>
                            </tr>
                        </table>
                        <input type="button" name="add" value="Gửi" onclick="sendMessageToAll();"/>
                        <span id="message" style="color: #800000; font-weight: bold"></span>
                    </form>
                </div>
            </div>
            <div class="box grid">
                <div class="box_header"><a href="javascript:void(0);">Kick người chơi</a></div>
                <div class="box_body" style="display: none">
                    <form id="kickUser">
                        Username <input type="text" name="user" style="width: 100px"/>
                        <input type="button" name="add" value="Kick" onclick="kickUser();"/>
                        <span id="message" style="color: #800000; font-weight: bold"></span>
                    </form>
                </div>
            </div>
            <div class="box grid">
                <div class="box_header"><a href="javascript:void(0);">Block người chơi</a></div>
                <div class="box_body" style="display: none">
                    <form id="blockUser">						
                        Username <input type="text" name="user" style="width: 100px"/>
                        <select name="type">
                            <option value="1">Block</option>
                            <option value="0">Khóa chat loa</option>
                        </select>
                        Thời gian <input type="text" name="date" style="width: 100px"/>
                        <select name="datetype">
                            <option value="0">Giờ</option>
                            <option value="1">Ngày</option>
                            <option value="2">Tháng</option>
                        </select>
                        Lý do <input type="text" name="cause" style="width: 150px"/>
                        <input type="button" name="add" value="Block" onclick="blockUser();"/>

                        <span id="message" style="color: #800000; font-weight: bold"></span>
                    </form>
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

