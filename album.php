<?php
require('Config.php');
require('API/db.class.php');
session_start();
$albumId = $_GET['id'];
if (is_numeric($albumId) && $albumId > 0) {
} else {
	header( 'Location: index.php' ) ;
}
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Album</title>
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
        </script>
    </head>
    <body>
        <div class="pagewrap">
            <?php require('topMenu.php'); ?>
			<div class="box grid">
                <div class="box_header" style="background-image: none;"><a href="javascript:void(0);">User Album</a></div>
                <div class="box_body">
					<div id="historySMSResult">
						<table width="100%">
							<thead>
								<tr>
									<th width='100px'>Owner</th>
									<th width='100px'>Likes</th>
									<th width='200px'>Date Created</th>
									<th>Image</th>
									<th></th>
								</tr>
									<?php 
										
										$sql = "select * from user_blog_album_image where album_id=${albumId}";
										
										foreach ($db->query($sql) as $row) {
											$img = $row['image'];
											$img = str_replace("_", "/", $img);
											$img = "http://avatar.trachanhquan.com/".$img;
											echo "<tr>";
											echo "<td align='center' width='100px'>".$row['owner']."</td>";
											echo "<td align='center' width='100px'>".$row['plus_count']."</td>";
											echo "<td align='center' width='200px'>".$row['date_created']."</td>";
											echo "<td align='center'><a href='".$img.".png' target='_blank'><img src='".$img.".thumb.png'/></a></td>";
											echo "<td align='center' width='200px'><a href='javascript:deleteImage(".$row['id'].",".$row['status_id'].");'>Xóa</a></td>";
											echo "</tr>";
										}
										
									?>
							</thead>
							<tbody>
							</tbody>
						</table>
						<input type="button" value="Xóa Album" onclick="deleteAlbum(<?php echo $albumId;?>);"/>
						<input type="button" value="Add 100 Likes" onclick="addLikes(<?php echo $albumId;?>);"/>
					</div>
                </div>
            </div>
    </body>
</html>