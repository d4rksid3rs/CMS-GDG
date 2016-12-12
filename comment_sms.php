<?php
require('API/db.class.php');
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Góp ý</title>
        <link type='text/css' href='css/basic.css' rel='stylesheet' media='screen' />
        
       
        <?php require('header.php'); ?>
         <script src="js/jquery.simplemodal.js"></script>
        <script type="text/javascript" >
            $(document).ready(function(){
                
            });
            
            function prepareReply(element, id, userId) {
                $(".reply").remove();
                var parent = element.parent().parent();
                parent.after("<tr class='reply'><td colspan=5 align=right><input type='text' name='replyContent' style='margin-right:5px; width:250px;'/><input type='button' value='Trả lời' style='margin-right:5px;' onclick='reply("+id+"," +userId+");'/><input type='button' value='Hủy' onclick='$(this).parent().parent().remove();'/></td></tr>");
            }

            function disableReply(element, id) {
                $.ajax({
                    type: "GET",
                    url: "API/replyComment.php",
                    data: {
                        "type":"disable",
                        "id":id,
                        "userId":0
                    },
                    dataType: 'text',
                    success: function(msg) {
                        msg = msg.trim();
                        if (msg != '' && msg.length > 2) {
                            var data = jQuery.parseJSON(msg);
                            if (data.status == 1) {
                                var parent = element.parent().parent();
                                var comment = parent.find('.comment');
                                comment.html(comment.html() + " - <font color=#4965AF>Không trả lời</font>");
                            } else {
                                alert(data.message);
                            }
                        } else {
                            alert("Lỗi hệ thống");
                        }
                    },
                    failure: function() {
                        alert("Kiểm tra lại kết nối mạng")
                    }
                });
            }
            
            function showAll(element, id) {
                $.ajax({
                    type: "GET",
                    url: "API/getAllFeedback.php",
                    data: {
                        "uid":id
                    },
                    dataType: 'text',
                    success: function(msg) {
                        if (msg != '' && msg.length > 2) {
                            //var data = jQuery.parseJSON(msg);
                            //if (data.status == 1) {
                               // var parent = element.parent().parent();
  //                              var comment = document.getElementById(element);
//                                comment.innerHTML = msg;
								$('#feedback').html(msg);
                                $('#feedback').modal({
									closeHTML: '<div style="float:right; font-size:25px; color:#fff"><a href="#" class="simplemodal-close" style="color:#fff">x</a></div>',
									opacity:65,
									overlayClose:true,
									minWidth: '750px',
									minHeight: '500px'
                                });
                              //  comment.html(comment.html() + " - <font color=#4965AF>Không trả lời</font>");
                            //} else {
                              //  alert(data.message);
                            //}
                        } else {
                            alert("Lỗi hệ thống");
                        }
                    },
                    failure: function() {
                        alert("Kiểm tra lại kết nối mạng")
                    }
                });
            }
            
            function reply(id, userId) {
                var element = $("input[name=replyContent]");
                var content = element.val();
                if (content.length == 0) {
                    alert("Chưa nhập thông tin trả lời.");
                } else {
                    // Gọi api trả lời
                    $.ajax({
                        type: "GET",
                        url: "API/replyComment.php",
                        data: {
                            "type":"reply",
                            "id":id,
                            "userId":userId,
                            "content":content
                        },
                        dataType: 'text',
                        success: function(msg) {
                            msg = msg.trim();
                            if (msg != '' && msg.length > 2) {
                                var data = jQuery.parseJSON(msg);
                                if (data.status == 1) {
                                    var parent = element.parent().parent();
                                    var comment = parent.prev().find('.comment');
                                    comment.html(comment.html() + " - <font color=#4965AF>Đã trả lời</font>");
                                    parent.remove();
                                } else {
                                    alert(data.message);
                                }
                            } else {
                                alert("Lỗi hệ thống");
                            }
                        },
                        failure: function() {
                            alert("Kiểm tra lại kết nối mạng")
                        }
                    });
                }
            }
        </script>
    </head>
    <body>
        <div class="pagewrap">
            <?php require('topMenu.php'); ?>
            <div class="topheader">
			    <ul class="topMenus">
			        <a href="comment_sms.php">Góp ý qua sms</a>
			    </ul>
			</div>
            <div class="box_header">
                Góp ý
            </div>
                <div class="box_body">
                    <?php 
                    $host="127.0.0.1:3307";
					$user="megatron";
					$password="optimus2771983";
					
					mysql_connect($host,$user,$password);
					mysql_select_db("logsms");
					if (isset($_GET["page"])) { $page  = $_GET["page"]; } else { $page=1; }; 
					$start_from = ($page-1) * 20; 
					$sql = "SELECT * FROM cskh ORDER BY created_on DESC";
					$rs_result = mysql_query($sql) or die(mysql_error());
					?> 
					<table width="100%" cellspacing="1" style="font-size:13px;" style="background-color: white">
								<thead>
					
					<tr style="background-color: rgb(204, 204, 204);">
					<td>Phone</td>
					<td>Message</td>
					<td>Date</td>
					</tr>
					
					<?php 
					
					while ($row = mysql_fetch_assoc($rs_result)) { 
					
					?> 
					
					            <tr style="background-color: white;">
					
					            <td><? echo $row["sender"]; ?></td>
					
					            <td><? echo $row["mo"]; ?></td>
					
					            <td><? echo $row["created_on"]; ?></td>
					
					            </tr>
					
					<?php 
					
					}; 
					
					?> 
					
					</table>
					
					<?php 
					
					$sql = "SELECT COUNT(Name) FROM students"; 
					
					$rs_result = mysql_query($sql,$connection); 
					
					$row = mysql_fetch_row($rs_result); 
					
					$total_records = $row[0]; 
					
					$total_pages = ceil($total_records / 20); 
					
					 
					
					for ($i=1; $i<=$total_pages; $i++) { 
					
					            echo "<a href='pagination.php?page=".$i."'>".$i."</a> "; 
					
					}; 
					
					?>
                </div>
            </div>
        </div>
    </body>
</html>