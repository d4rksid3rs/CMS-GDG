<?php
session_start();
?>
<?php
$fromDate = $_GET['fromDate'];
$toDate = $_GET['toDate'];
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
        <title>Người chơi</title>
        <?php require('header.php'); ?>
        <script>
			$(document).ready(function(){
				$("#datepicker1").datepicker();
				$("#datepicker2").datepicker();
			}); 
			
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
									output = output + "<td align='center' width='200px'><a href='javascript:deleteImage("+value.id+","+value.statusId+");'>Xóa</a> | <a href='album.php?id="+value.albumId+"' target='_blank'>Xem Album</a></td>";
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
                <div class="box_header" style="background-image: none;"><a href="javascript:void(0);">User Picture</a></div>
                <div class="box_body">
                    <form id="historySMS">
						Từ ngày 
						<input type="text" id="datepicker1" name="fromDate" style="text-align: center; width: 100px;" value="<?php echo $fromDate;?>"/> 
						Tới ngày 
						<input type="text" id="datepicker2" name="toDate" style="text-align: center; width: 100px;" value="<?php echo $toDate;?>"/> 
						Trang
						<input type="text" id="pageNumber" name="pageNumber" style="text-align: center; width: 50px;" value="1"/>
                        <input type="button" name="add" value=" Tìm " onclick="showUserPicture();"/>
                        <span id="message" style="color: #800000; font-weight: bold"></span>
                    </form>
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
							</thead>
							<tbody>
							</tbody>
						</table>
					</div>
                </div>
            </div>
    </body>
</html>