<?php
require('Config.php');
require('API/db.class.php');
session_start();
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Chatroom</title>
        <?php require('header.php'); ?>
        <script>
			$(document).ready(function(){
				$("#datepicker1").datepicker();
				$("#datepicker2").datepicker();
			}); 
			function addLikes(albumId) {
					$.ajax({
						type: "GET",
						url: "API/addLikeAlbum.php",
						data: {
							"id":albumId
						},
						dataType: 'text',
						success: function(msg) {
							msg = msg.trim();
							if (msg != '' && msg.length > 2) {
								var data = jQuery.parseJSON(msg);
								if (data.status == 1) {
									alert(data.message);
								} else {
									alert(data.message);
								}
							} else {
								alert("Lỗi hệ thống");
							}
						},
						failure: function() {
							alert("Lỗi hệ thống");
						}
					});
			}
			
			function deleteAlbum(albumId) {
				var r = window.confirm("Are you sure to Delete ?");
				if (r == true) {
					$.ajax({
						type: "GET",
						url: "API/deleteAlbum.php",
						data: {
							"id":albumId
						},
						dataType: 'text',
						success: function(msg) {
							msg = msg.trim();
							if (msg != '' && msg.length > 2) {
								var data = jQuery.parseJSON(msg);
								if (data.status == 1) {
									alert(data.message);
								} else {
									alert(data.message);
								}
							} else {
								alert("Lỗi hệ thống");
							}
						},
						failure: function() {
							alert("Lỗi hệ thống");
						}
					});
				}
			}
			
			function deleteImage(imageId, statusId) {
				var r = window.confirm("Are you sure to Delete?");
				if (r == true) {
					$.ajax({
						type: "GET",
						url: "API/deleteImage.php",
						data: {
							"id":imageId,
							"status":statusId
						},
						dataType: 'text',
						success: function(msg) {
							msg = msg.trim();
							if (msg != '' && msg.length > 2) {
								var data = jQuery.parseJSON(msg);
								if (data.status == 1) {
									alert(data.message);
								} else {
									alert(data.message);
								}
							} else {
								alert("Lỗi hệ thống");
							}
						},
						failure: function() {
							alert("Lỗi hệ thống");
						}
					});
				}
			}
			
            function showUserPicture() {
				var fromDate = $("#historySMS input[name=fromDate]").val();
				var toDate = $("#historySMS input[name=toDate]").val();
				var page = $("#historySMS input[name=pageNumber]").val();
                $("#userDetail").slideUp();
                $("#userDetailDB").slideUp();
                $.ajax({
                    type: "GET",
                    url: "API/showUserPicture.php",
                    data: {
                        "page":page,
						"fromDate":fromDate,
						"toDate":toDate
                    },
                    dataType: 'text',
                    success: function(msg) {
                        msg = msg.trim();
                        if (msg != '' && msg.length > 2) {
                            var data = jQuery.parseJSON(msg);
							$("#historySMSResult table>tbody>tr").remove();
							if (data.status == 1) {
								$.each(data.picture, function (index, value) {
									var output = "<tr id='row"+value.id+"'>";
									output = output + "<td align='center' width='100px'>"+value.owner+"</td>";
									output = output + "<td align='center' width='100px'>"+value.plusCount+"</td>";
									output = output + "<td align='center' width='200px'>"+value.dateCreated+"</td>";
									output = output + "<td align='center'><a href='"+value.image+".png' target='_blank'><img src='"+value.image+".thumb.png'/></a></td>";
									output = output + "<td align='center' width='200px'><a href='javascript:deleteImage("+value.id+","+value.statusId+");'>Xóa</a> <a href='album.php?id="+value.albumId+"' target='_blank'>Xem Album</a></td>";
									output = output + "</tr>";
									$("#historySMSResult table>tbody").append(output);
								});
								$(".grid tr:odd").css("background-color","#FFFFFF");
								$(".grid tr:even").css("background-color","#CCC");
							} else {
							
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
			
			function editImage(roomId) {
				$("#updateBox").hide(500);
				$.ajax({
					type: "GET",
					url: "API/chatroomAPI.php",
					data: {
						"id":roomId,
						"type":"get"
					},
					dataType: 'text',
					success: function(msg) {
						msg = msg.trim();
						if (msg != '' && msg.length > 2) {
							var data = jQuery.parseJSON(msg);
							if (data.status == 1) {
								$("input[name=roomId]").val(roomId);
								$("input[name=title]").val(data.tmp1);
								$("input[name=desp]").val(data.tmp2);
								$("input[name=image]").val(data.tmp3);
								$("#updateBox").show(500);
							} else {
								alert(data.message);
							}
						} else {
							alert("Lỗi hệ thống");
						}
					},
					failure: function() {
						alert("Lỗi hệ thống");
					}
				});
			}
			
			function updateRoom() {
				roomId = $("input[name=roomId]").val();
				title = $("input[name=title]").val();
				desp = $("input[name=desp]").val();
				image = $("input[name=image]").val();
				$.ajax({
					type: "GET",
					url: "API/chatroomAPI.php",
					data: {
						"id":roomId,
						"type":"update",
						"title":title,
						"desp":desp,
						"image":image
					},
					dataType: 'text',
					success: function(msg) {
						msg = msg.trim();
						if (msg != '' && msg.length > 2) {
							var data = jQuery.parseJSON(msg);
							if (data.status == 1) {
								alert(data.message);
								$("#updateBox").hide(500);
							} else {
								alert(data.message);
							}
						} else {
							alert("Lỗi hệ thống");
						}
					},
					failure: function() {
						alert("Lỗi hệ thống");
					}
				});
			}
        </script>
    </head>
    <body>
        <div class="pagewrap">
            <?php require('topMenu.php'); ?>
			<div class="box grid">
                <div class="box_header" style="background-image: none;"><a href="javascript:void(0);">Chatroom</a></div>
                <div class="box_body">
					<div id="historySMSResult">
						<div style="margin-bottom:10px; display:none;" id="updateBox">
							<input type="hidden" name="roomId" value=""/>
							<b>Title</b> 
							<input type="text" name="title" style="width:300px;"/><br/>
							<b>Description</b> 
							<input type="text" name="desp" style="width:600px;"/><br/>
							<b>Image</b> 
							<input type="text" name="image" style="width:600px;"/><br/>
							<input type="button" value="Cập nhật" onclick="updateRoom();"> <input type="button" value="Hủy" onclick="$('#updateBox').hide(500)">
						</div>
						<table width="100%">
							<thead>
								<tr>
									<th width='100px'>Title</th>
									<th width='500px'>Description</th>
									<th>Image</th>
									<th width='200px'></th>
								</tr>
									<?php 
										
										$sql = "select * from room where id>=300 and id<400";						
										foreach ($db->query($sql) as $row) {
											$tmp = explode("@@", $row['name']);
											$img = str_replace("_", "/", $tmp[2]);
											$img = "http://avatar.trachanhquan.com/".$img;
											echo "<tr class='.caigiday'>";
											echo "<td align='center' width='100px'>".$tmp[0]."</td>";
											echo "<td align='center' width='500px'>".$tmp[1]."</td>";
											echo "<td align='center'><a href='".$img.".png' target='_blank'><img src='".$img.".thumb.png'/></a></td>";
											echo "<td align='center' width='200px'><a href='javascript:editImage(".$row['id'].");'>Sửa</a></td>";
											echo "</tr>";
										}
										
									?>
							</thead>
							<tbody>
							</tbody>
						</table>
					</div>
                </div>
            </div>
    </body>
</html>