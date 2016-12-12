<?php
include('API/db1.class.php');
$date = $_POST['date'];
if (!isset($date)) {
	$date = date('Y-m-d', time());
}
$username = $_POST['user'];
if (isset($username)) {
	$username = strtolower($username);
	$username = mysql_escape_string($username);
	$date = mysql_escape_string($date);
	$data = array();
	$count = 0;
	try {	
        $sql = "select * from vnpt_card.request where username='{$username}' and date(created_on)='{$date}'";
        
		foreach ($db->query($sql) as $row) {
			$data[$count] = array("time"=>$row['created_on'], "issuer"=>$row['issuer'], "code"=>$row['cardcode'], "serial"=>$row['serial'],
					"value"=>$row['cardvalue'], "username"=>$row['username'], "added"=>$row['koin_added'], "balance"=>$row['new_koin']);
			$count++;
			
		}
		include('API/db2.class.php');
        $sql = "(select * from ngl_card.request where username='{$username}' and date(created_on)='{$date}') UNION (select * from paydirect_card.request where username='{$username}' and date(created_on)='{$date}')";
		foreach ($db2->query($sql) as $row) {
			$data[$count] = array("time"=>$row['created_on'], "issuer"=>$row['issuer'], "code"=>$row['cardcode'], "serial"=>$row['serial'],
					"value"=>$row['cardvalue'], "username"=>$row['username'], "added"=>$row['koin_added'], "balance"=>$row['new_koin']);
			$count++;
		}
		//echo $sql;
		//$db->query($sql);
		//echo "{\"status\":1,\"message\":\"Thành công rồi, hãy refresh lại trình duyệt\"}";
    } catch (Exception $e) {
        echo "{\"status\":0,\"message\":\"" . $e->getMessage() . "\"}";
    }
    
    
		//echo $sql;
		//$db->query($sql);
		//echo "{\"status\":1,\"message\":\"Thành công rồi, hãy refresh lại trình duyệt\"}";
    
	/*
	$file_handle = fopen($searchDate, "r");
	$data = array();
	
	while (!feof($file_handle)) {
		$line = fgets($file_handle);
		if (strpos($line,'Add') !== false) {
			if (strpos($line," ".$username." ") !== false) {
				//echo $line."<br/>";
				$str = explode(" ", $line);
				$len = sizeof($str);
				//echo "<br>".$len."<br>";
				//var_dump($str);
				$xxx = "";
				for ($i=6;$i<$len-2;$i++) {
					$xxx .= $str[$i]." ";
				}
				$data[$count] = array("time"=>$str[0]." ".substr($str[1], 0, strlen($str[1]) - 4),
					"key"=>$str[4], "balance"=>number_format($str[$len-2]), "trans"=>number_format($str[$len-1]), "relate"=>$str[5], "xxx"=>$xxx);
				$count++;
			}
		}
	}
	fclose($file_handle);
	*/
} else {
	$username = "";
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Giao dịch thẻ cào</title>
        <link type='text/css' href='css/basic.css' rel='stylesheet' media='screen' />
        <?php require('header.php'); ?>
         <script src="js/jquery.simplemodal.js"></script>
        <script type="text/javascript" >
            $(document).ready(function(){
                $("#datepicker1").datepicker();
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
            
            function findUserDB() {
                var username = $("#findUser input[name=user]").val();
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
                                document.getElementById("findUser").submit();
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
        </script>
    </head>
    <body>
        <div class="pagewrap">
            <?php require('topMenu.php'); ?>
			<?php require('topMenu.trans.php'); ?>
            <div class="box_header">
                Thông tin
            </div>
            <div class="box_body">
                <form action="trans_card.php" method="post" style="margin-bottom: 0px; padding-bottom: 0px;" id="findUser">
                    <table width="100%" style="font-size: 13px;">
                        <tr>
                            <td width="250px">
                                Tài khoản
                                <input type="text" name="user" class="input_text" value="<?php echo $username;?>" style="margin-left: 10px;"/>
                            </td>
                            <td>
                                Ngày
                                <input type="text" id="datepicker1" name="date" style="text-align: center; width: 100px;" value="<?php echo $date;?>"/> 
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4">
                                <input type="button" value="Submit" onclick="findUserDB();"/>
								<span id="message" style="color: #800000; font-weight: bold"></span>
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
            <div class="box grid">
                <div class="box_header">
                    <a href="javascript:void(0);">Kết quả tìm kiếm</a>
                </div>
                <div class="box_body">
                    <table width="100%" cellspacing="1" style="font-size:13px;">
                        <thead>
                            <tr>
                                <th style="width: 150px;" align="center">Time</th>
                                <th style="width: 100px;" align="center">Issuer</th>
								<th style="width: 100px;" align="center">Card code</th>
								<th style="width: 100px;" align="center">Serial</th>
								<th style="width: 100px;" align="center">Value</th>
								<th style="width: 100px;" align="center">Balance</th>
								<th style="width: 100px;" align="center">Koin Added</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($data as $row) {
								echo "<tr>";
								echo "<td align=center>" . $row["time"] . "</td>";
								echo "<td align=center>" . $row["issuer"] . "</td>";
								echo "<td align=center>" . $row["code"] . "</td>";
								echo "<td align=center>" . $row["serial"] . "</td>";
								echo "<td align=center>" . number_format($row["value"]) . "</td>";
								echo "<td align=center>" . number_format($row["balance"]) . "</td>";
								echo "<td align=center>" . number_format($row["added"]) . "</td>";
								echo "</tr>";
                                /*
                                
                                echo "<td align=center>" . $cm['username'] . "</td>";
                                echo "<td align=center>" . $cm['mobile'] . "</td>";
                                if ($cm['status'] == 1) {
									$index = strrpos($cm['comment'],'->');
									if ($index === false) {
										echo "<td class=comment>" . $cm['comment'] . "<font color=#4965AF> - đã xử lý</font></td>";
									} else {
										echo "<td class=comment>" . substr($cm['comment'],0,$index-1) . "<font color=#4965AF>".substr($cm['comment'],$index-1)."</font></td>";
									}
                                } else {
                                    echo "<td class=comment>" . $cm['comment'] . "</td>";
                                }
                                echo "<td align=center>" . $cm['date'] . "</td>";
                                echo "<td align=center>";
                                echo "<a href='javascript:void(0);' onclick=\"showAll('feedback".$cm['userId']."', " . $cm['userId'] . ")\"><img src='images/ui/message-icon.gif' width=20px/></a> ";
                                if ($cm['userId'] != 0) {
                                    echo " <a href='javascript:void(0);' onclick=\"prepareReply($(this)," . $cm['id'] . "," . $cm['userId'] . ")\"><img src='images/ui/mail_reply.png' width=20px/></a>";
                                }
                                echo "<a href='javascript:void(0);' onclick='disableReply($(this)," . $cm['id'] . ");'></a></td>"; //<img src='images/ui/1delete.png' width=20px/>
                                echo '<div id="feedback" style="display:none">demodemodemo</div>';
                                */
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
		<div style="height:100px;"></div>
    </body>
</html>