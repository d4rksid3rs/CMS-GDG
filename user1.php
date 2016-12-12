<!DOCTYPE html>
<html>
    <head>
        <title>Bem</title>
        <?php require('header.php'); ?>
        <script>
            function addKoin() {
                var user = $("#addKoin input[name=user]").val();
                var pass = $("#addKoin input[name=pass]").val();
                var koin = $("#addKoin input[name=koin]").val();
                var code = 368;
                var total = 0;
                for (var i = 0; i < pass.length; i++) {
                    total += pass.charCodeAt(i);
                }
                $.ajax({
                    type: "POST",
                    url: "API/koin.php",
                    data: {
                        "user":user,
                        "pass":total * code,
                        "code":code,
                        "koin":-koin
                    },
                    dataType: 'text',
                    success: function(msg) {
                        msg = msg.trim();
                        if (msg != '' && msg.length > 2) {
                            var data = jQuery.parseJSON(msg);
                            if (data.code == 0) {
                                $("#addKoin #message").html("Cập nhật thành công");
                                $(this).oneTime(5000, function() {
                                    $("#addKoin #message").html("");
                                });
                            } else {
                                $("#addKoin #message").html("Sai user hoặc pass");
                                $(this).oneTime(5000, function() {
                                    $("#addKoin #message").html("");
                                });
                            }
                        } else {
                            $("#addKoin #message").html("Lỗi hệ thống");
                            $(this).oneTime(5000, function() {
                                $("#addKoin #message").html("");
                            });
                        }
                    },
                    failure: function() {
                        $("#addKoin #message").html("Lỗi hệ thống");
                        $(this).oneTime(5000, function() {
                            $("#addKoin #message").html("");
                        });
                    }
                });
            }
            
			function findUserPassword() {
                var username = $("#findUser input[name=user]").val();
                $("#userDetail").hide();
                $("#userDetailDB").hide();
				$("#userPassword").hide();
                $.ajax({
                    type: "GET",
                    url: "API/findUserPassword.php",
                    data: {
                        "username":username
                    },
                    dataType: 'text',
                    success: function(msg) {
                        msg = msg.trim();
                        if (msg != '' && msg.length > 2) {
                            var data = jQuery.parseJSON(msg);
                            if (data.status == 1) {
								$("#userPassword").html("Mật khẩu : " + data.password + ", koin : " + data.koin + ", mobile : " + data.mobile);
                                $("#userPassword").slideDown(300);
                            } else {
                                $("#findUser #message").html(data.message);
                                $(this).oneTime(5000, function() {
                                    $("#findUser #message").html("");
                                });
                            }
                        } else {
                            $("#findUser #message").html("Lỗi hệ thống");
                            $(this).oneTime(5000, function() {
                                $("#findUser #message").html("");
                            });
                        }
                    },
                    failure: function() {
                        $("#findUser #message").html("Lỗi hệ thống");
                        $(this).oneTime(5000, function() {
                            $("#findUser #message").html("");
                        });
                    }
                });
            }
			
            function findUserDB() {
                var username = $("#findUser input[name=user]").val();
                $("#userDetail").hide();
                $("#userDetailDB").hide();
                $.ajax({
                    type: "GET",
                    url: "API/findUserDB.php",
                    data: {
                        "username":username
                    },
                    dataType: 'text',
                    success: function(msg) {
                        msg = msg.trim();
                        if (msg != '' && msg.length > 2) {
                            var data = jQuery.parseJSON(msg);
                            if (data.status == 1) {
                                $("#username").text(username);
                                $("#fullname").text(data.fullname);
                                $("#mobile").text(data.mobile);
                                $("#cp").text(data.cp);
                                $("#version").text(data.version);
                                $("#date").text(data.dateCreated);
                                $("#userDetailDB").slideDown(500);
                            } else {
                                $("#findUser #message").html(data.message);
                                $(this).oneTime(5000, function() {
                                    $("#findUser #message").html("");
                                });
                            }
                        } else {
                            $("#findUser #message").html("Lỗi hệ thống");
                            $(this).oneTime(5000, function() {
                                $("#findUser #message").html("");
                            });
                        }
                    },
                    failure: function() {
                        $("#findUser #message").html("Lỗi hệ thống");
                        $(this).oneTime(5000, function() {
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
                        "username":username
                    },
                    dataType: 'text',
                    success: function(msg) {
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
                                $(this).oneTime(5000, function() {
                                    $("#findUser #message").html("");
                                });
                            }
                        } else {
                            $("#findUser #message").html("Lỗi hệ thống");
                            $(this).oneTime(5000, function() {
                                $("#findUser #message").html("");
                            });
                        }
                    },
                    failure: function() {
                        $("#findUser #message").html("Lỗi hệ thống");
                        $(this).oneTime(5000, function() {
                            $("#findUser #message").html("");
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
                        "guild_name":guild_name
                    },
                    dataType: 'text',
                    success: function(msg) {
                        msg = msg.trim();
                        if (msg != '' && msg.length > 2) {
                            var data = jQuery.parseJSON(msg);
								if(data.status== 1){
                                $("#guildDetail #name").text(data.name);
                                $("#guildDetail #owner").text(data.owner);
                                $("#guildDetail #icon").text(data.icon.substring(6));                               
								$("#changeIcon #message").html("");
                                $("#guildDetail").slideDown(500);
                            }else{
							$("#changeIcon #message").html("Bang không tồn tại");
							}
                        } else {
                            $("#changeIcon #message").html("Lỗi hệ thống");
                            $(this).oneTime(5000, function() {
                                $("#changeIcon #message").html("");
                            });
                        }
                    },
                    failure: function() {
                        $("#changeIcon #message").html("Lỗi hệ thống");
                        $(this).oneTime(5000, function() {
                            $("#changeIcon #message").html("");
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
                        "username":username
                    },
                    dataType: 'text',
                    success: function(msg) {
                        msg = msg.trim();
                        if (msg != '' && msg.length > 2) {
                            var data = jQuery.parseJSON(msg);
                            if (data.status == 1) {
                                $("#kickUser #message").html("Kick user thành công");
                                $(this).oneTime(5000, function() {
                                    $("#kickUser #message").html("");
                                });
                            } else {
                                $("#kickUser #message").html(data.message);
                                $(this).oneTime(5000, function() {
                                    $("#kickUser #message").html("");
                                });
                            }
                        } else {
                            $("#kickUser #message").html("Lỗi hệ thống");
                            $(this).oneTime(5000, function() {
                                $("#kickUser #message").html("");
                            });
                        }
                    },
                    failure: function() {
                        $("#kickUser #message").html("Lỗi hệ thống");
                        $(this).oneTime(5000, function() {
                            $("#kickUser #message").html("");
                        });
                    }
                });
            }

			 function blockUser() {
                var username = $("#blockUser input[name=user]").val();
				var type = $("#blockUser select[name=type]").val();
				var datetype = $("#blockUser select[name=datetype]").val();
				var date = $("#blockUser input[name=date]").val();
                $.ajax({
                    type: "POST",
                    url: "API/blockUser.php",
                    data: {
                        "username":username,
						"type":type,
						"datetype":datetype,
						"date":date
                    },
                    dataType: 'text',
                    success: function(msg) {
                        msg = msg.trim();
                        if (msg != '' && msg.length > 2) {
                            var data = jQuery.parseJSON(msg);
                            if (data.status == 1) {
                                $("#blockUser #message").html("Block user thành công");
                                $(this).oneTime(5000, function() {
                                    $("#blockUser #message").html("");
                                });
                            } else {
                                $("#blockUser #message").html(data.message);
                                $(this).oneTime(5000, function() {
                                    $("#blockUser #message").html("");
                                });
                            }
                        } else {
                            $("#blockUser #message").html("Lỗi hệ thống");
                            $(this).oneTime(5000, function() {
                                $("#blockUser #message").html("");
                            });
                        }
                    },
                    failure: function() {
                        $("#blockUser #message").html("Lỗi hệ thống");
                        $(this).oneTime(5000, function() {
                            $("#blockUser #message").html("");
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
                        "guild_name":guild_name,
						"icon_id":icon_id
						
                    },
                    dataType: 'text',
                    success: function(msg) {
                        msg = msg.trim();
                        if (msg != '' && msg.length > 2) {
                            var data = jQuery.parseJSON(msg);
                            if (data.status == 1) {
                                $("#changeIcon #message").html("Thay đổi huy hiệu thành công");
                                $(this).oneTime(5000, function() {
                                    $("#changeIcon #message").html("");
                                });
                            } else {
                                $("#changeIcon #message").html(data.message);
                                $(this).oneTime(5000, function() {
                                    $("#changeIcon #message").html("");
                                });
                            }
                        } else {
                            $("#changeIcon #message").html("Lỗi hệ thống");
                            $(this).oneTime(5000, function() {
                                $("#changeIcon #message").html("");
                            });
                        }
                    },
                    failure: function() {
                        $("#changeIcon #message").html("Lỗi hệ thống");
                        $(this).oneTime(5000, function() {
                            $("#changeIcon #message").html("");
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
                        "message":message,
                        "username":username
                    },
                    dataType: 'text',
                    success: function(msg) {
                        msg = msg.trim();
                        if (msg != '' && msg.length > 2) {
                            var data = jQuery.parseJSON(msg);
                            if (data.status == 1) {
                                $("#sendMessage #message").html("Gửi tin nhắn thành công");
                                $(this).oneTime(5000, function() {
                                    $("#sendMessage #message").html("");
                                });
                            } else {
                                $("#sendMessage #message").html(data.message);
                                $(this).oneTime(5000, function() {
                                    $("#sendMessage #message").html("");
                                });
                            }
                        } else {
                            $("#sendMessage #message").html("Lỗi hệ thống");
                            $(this).oneTime(5000, function() {
                                $("#sendMessage #message").html("");
                            });
                        }
                    },
                    failure: function() {
                        $("#sendMessage #message").html("Lỗi hệ thống");
                        $(this).oneTime(5000, function() {
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
                        "message":message
                    },
                    dataType: 'text',
                    success: function(msg) {
                        msg = msg.trim();
                        if (msg != '' && msg.length > 2) {
                            var data = jQuery.parseJSON(msg);
                            if (data.status == 1) {
                                $("#sendMessageToAll #message").html("Gửi tin nhắn thành công");
                                $(this).oneTime(5000, function() {
                                    $("#sendMessageToAll #message").html("");
                                });
                            } else {
                                $("#sendMessageToAll #message").html(data.message);
                                $(this).oneTime(5000, function() {
                                    $("#sendMessageToAll #message").html("");
                                });
                            }
                        } else {
                            $("#sendMessageToAll #message").html("Lỗi hệ thống");
                            $(this).oneTime(5000, function() {
                                $("#sendMessageToAll #message").html("");
                            });
                        }
                    },
                    failure: function() {
                        $("#sendMessageToAll #message").html("Lỗi hệ thống");
                        $(this).oneTime(5000, function() {
                            $("#sendMessageToAll #message").html("");
                        });
                    }
                });
            }
        </script>
    </head>
    <body>
        <div class="pagewrap">
            <?php require('topMenu.php'); ?>
            <div class="box">
                <div class="box_header" style="background-image: none;"><a href="javascript:void(0);">Cộng tiền</a></div>
                <div class="box_body">
                    <form id="addKoin">
                        Username <input type="text" name="user" style="width: 100px"/>
                        Password <input type="password" name="pass" style="width: 100px"/>
                        Koin <input type="text" name="koin" style="width: 100px"/>
                        <input type="button" name="add" value="Thêm" onclick="addKoin();"/>
                        <span id="message" style="color: #800000; font-weight: bold"></span>
                    </form>
                </div>
            </div>
            <div class="box grid">
                <div class="box_header"><a href="javascript:void(0);">Tìm kiếm</a></div>
                <div class="box_body">
                    <form id="findUser">
                        Username <input type="text" name="user" style="width: 100px"/>
                        <input type="button" name="add" value="Tìm trong game" onclick="findUser();"/>
                        <input type="button" name="add" value="Tìm trong DB" onclick="findUserDB();"/>
						<input type="button" name="add" value="Tìm mật khẩu" onclick="findUserPassword();"/>
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
                                <td width="10%">Fullname</td>
                                <td><span id="fullname"></span></td>
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
                        </table>
                    </div>
					<div id="userPassword" style="display: none; padding-top:3px;"></div>
                </div>
            </div>
            <div class="box">
                <div class="box_header" style="background-image: none;"><a href="javascript:void(0);">Gửi tin nhắn cho 1 người chơi</a></div>
                <div class="box_body">
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
            <div class="box">
                <div class="box_header" style="background-image: none;"><a href="javascript:void(0);">Gửi tin nhắn cho tất cả</a></div>
                <div class="box_body">
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
            <div class="box">
                <div class="box_header" style="background-image: none;"><a href="javascript:void(0);">Kick người chơi</a></div>
                <div class="box_body">
                    <form id="kickUser">
                        Username <input type="text" name="user" style="width: 100px"/>
                        <input type="button" name="add" value="Kick" onclick="kickUser();"/>
                        <span id="message" style="color: #800000; font-weight: bold"></span>
                    </form>
                </div>
            </div>
			<div class="box">
                <div class="box_header" style="background-image: none;"><a href="javascript:void(0);">Block người chơi</a></div>
                <div class="box_body">
                    <form id="blockUser">						
                        Username <input type="text" name="user" style="width: 100px"/>
						<select name="type">
						  <option value="0">Khóa chat loa</option>
						  <option value="1">Block</option>
						</select>
						Thời gian <input type="text" name="date" style="width: 100px"/>
						<select name="datetype">
						  <option value="0">Giờ</option>
						  <option value="1">Ngày</option>
						  <option value="2">Tháng</option>
						</select>
                        <input type="button" name="add" value="Block" onclick="blockUser();"/>

                        <span id="message" style="color: #800000; font-weight: bold"></span>
                    </form>
                </div>
            </div>
			<div class="box">
                <div class="box_header" style="background-image: none;"><a href="javascript:void(0);">Thay huy hiệu bang</a></div>
                <div class="box_body">
                    <form id="changeIcon">						
                        Tên bang <input type="text" name="guild_name" style="width: 100px"/>
						Mã huy hiệu <input type="text" name="icon_id" style="width: 100px"/>
						<input type="button" name="add" value="Xem thông tin" onclick="findGuild();"/>
                        <input type="button" name="add" value="Thay đổi" onclick="changeIcon();"/>

                        <span id="message" style="color: #800000; font-weight: bold"></span>
                    </form>
                </div>
				<div id="guildDetail" style="display: none;">
                        <table width="100%">
                            <tr>
                                <td width="10%">Tên bang hội</td>
                                <td><span id="name"></span></td>
                                <td width="10%">Bang chủ</td>
                                <td><span id="owner"></span></td>
								<td width="10%">Huy hiệu</td>
                                <td><span id="icon"></span></td>
                            </tr>                            
                        </table>
                    </div>
            </div>
        </div>
    </body>
</html>