<?php
require('API/db.class.php');
$pageSize = 30;
$acc = $_GET['a'];
$message = $_GET['m'];
$page = $_GET['p'];
if (!isset($page) || $page < 1) {
    $page = 1;
}
$query = "";
if (!isset($acc)) {
    $acc = "";
}
if (!isset($message)) {
    $message = "";
}
$sql = "Select * from (SELECT fb.*, u.screen_name, u.koin_added, u.vip FROM (SELECT f.* FROM feedback f ORDER BY id DESC ) fb "
        . "LEFT JOIN user u ON fb.user_id = u.id  ";
if ($acc != "") {
    $query .= "a=" . $acc;
    $sql .= " where fb.user like '%" . $acc . "%'";
}
if ($message != "" && $acc == "") {
    $query .= "m=" . $message;
    $sql .= " where fb.feedback like '%" . $message . "%'";
} else if ($message != "" && $acc != "") {
    $query .= "&m=" . $message;
    $sql .= " and fb.feedback like '%" . $message . "%'";
}
$sql .= " ORDER by fb.date_created desc limit " . ($page - 1) * $pageSize . "," . $pageSize . ") as tmp_table group by user_id order by date_created desc";
//echo $sql;die;
$comments = array();
foreach ($db->query($sql) as $row) {
    $comments[] = array(
        'username' => $row['user'],
        'comment' => $row['feedback'],
        'date' => $row['date_created'],
        'mobile' => $row['mobile'],
        'screen_name' => $row['screen_name'],
        'vip' => $row['vip'],
        'koin_added' => $row['koin_added'],
        'id' => $row['id'],
        'status' => $row['status'],
        'userId' => $row['user_id']
    );
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Góp ý</title>
        <link type='text/css' href='css/basic.css' rel='stylesheet' media='screen' />


        <?php require('header.php'); ?>
        <script src="js/jquery.simplemodal.js"></script>
        <script type="text/javascript" >
            $(document).ready(function () {

            });

            function prepareReply(element, id, userId) {
                $(".reply").remove();
                var parent = element.parent().parent();
                parent.after("<tr class='reply'><td colspan=5 align=right><textarea type='text' col='50' row='4' name='replyContent' style='margin-right:5px; width:250px;'></textarea><input type='button' value='Trả lời' style='margin-right:5px;' onclick='reply(" + id + "," + userId + ");'/><input type='button' value='Hủy' onclick='$(this).parent().parent().remove();'/></td></tr>");
            }

            function disableReply(element, id) {
                $.ajax({
                    type: "GET",
                    url: "API/replyComment.php",
                    data: {
                        "type": "disable",
                        "id": id,
                        "userId": 0
                    },
                    dataType: 'text',
                    success: function (msg) {
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
                    failure: function () {
                        alert("Kiểm tra lại kết nối mạng")
                    }
                });
            }

            function showAll(element, id) {
                $.ajax({
                    type: "GET",
                    url: "API/getAllFeedback.php",
                    data: {
                        "uid": id
                    },
                    dataType: 'text',
                    success: function (msg) {
                        if (msg != '' && msg.length > 2) {
                            //var data = jQuery.parseJSON(msg);
                            //if (data.status == 1) {
                            // var parent = element.parent().parent();
                            //                              var comment = document.getElementById(element);
//                                comment.innerHTML = msg;
                            $('#feedback').html(msg);
                            $('#feedback').modal({
                                closeHTML: '<div style="float:right; font-size:25px; color:#fff"><a href="#" class="simplemodal-close" style="color:#fff">x</a></div>',
                                opacity: 65,
                                overlayClose: true,
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
                    failure: function () {
                        alert("Kiểm tra lại kết nối mạng")
                    }
                });
            }

            function reply(id, userId) {
                var element = $("textarea[name=replyContent]");
                var content = element.val();
                if (content.length == 0) {
                    alert("Chưa nhập thông tin trả lời.");
                } else {
                    // Gọi api trả lời
                    $.ajax({
                        type: "GET",
                        url: "API/replyComment.php",
                        data: {
                            "type": "reply",
                            "id": id,
                            "userId": userId,
                            "content": content
                        },
                        dataType: 'text',
                        success: function (msg) {
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
                        failure: function () {
                            alert("Kiểm tra lại kết nối mạng")
                        }
                    });
                }
            }

            function createMessage() {
                var username = $("#new_message input[name=username]").val();
                var content = $("#new_message textarea[name=content]").val();
                $.ajax({
                    type: "POST",
                    url: "API/createMessage.php",
                    data: {
                        "username": username,
                        "content": content
                    },
                    dataType: 'text',
                    success: function (msg) {
                        msg = msg.trim();
                        if (msg != '' && msg.length > 2) {
                            var data = jQuery.parseJSON(msg);
                            if (data.status == 1) {
                                $("#new_message #message").text(data.numuser);
                            } else {
                                $("#new_message #message").html(data.message);
                                $(this).oneTime(5000, function () {
                                    $("#new_message #message").html("");
                                });
                            }
                        } else {
                            $("#new_message #message").html("Lỗi hệ thống");
                            $(this).oneTime(5000, function () {
                                $("#new_message #message").html("");
                            });
                        }
                    },
                    failure: function () {
                        $("#new_message #message").html("Lỗi hệ thống");
                        $(this).oneTime(5000, function () {
                            $("#new_message #message").html("");
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
                <div class="box_header" style="background-image: none;"><a href="javascript:void(0);">Gửi Tin nhắn cho Người chơi</a></div>
                <div class="box_body"  style="display: none">
                    <form id="new_message">    
                        Username
                        <input type="text" name="username" />
                        Nội dung
                        <textarea type='text' col='50' row='4' name='content' style='margin-right:5px; width:250px;'></textarea>

                        <input type="button" name="add" value="Gửi" onclick="createMessage();"/>
                        <span id="message" style="color: #800000; font-weight: bold"></span>
                    </form>
                </div>
                <div id="createMessageResult" style="display: none;">

                </div>
            </div> 
            <div class="box grid">
                <div class="box_header">
                    Góp ý
                </div>
                <div class="box_body">
                    <form action="comment.php" method="get" style="margin-bottom: 0px; padding-bottom: 0px;">
                        <table width="100%" style="font-size: 13px;">
                            <tr>
                                <td width="250px">
                                    Tài khoản
                                    <input type="text" name="a" class="input_text" value="<?php echo $acc; ?>" style="margin-left: 10px;"/>
                                </td>
                                <td>
                                    Message
                                    <input type="text" name="m" class="input_text" value="<?php echo $message; ?>" style="margin-left: 10px;" />
                                </td>
                            </tr>
                            <tr>
                                <td colspan="4">
                                    <input type="submit" value="Submit" class="input_button"/>
                                </td>
                            </tr>
                        </table>
                    </form>
                </div>
                <div class="box_header">
                    <a href="javascript:void(0);">Kết quả tìm kiếm</a>
                </div>
                <div class="box_body">
                    <table width="100%" cellspacing="1" style="font-size:13px;">
                        <thead>
                            <tr>
                                <th style="width: 30px;" align="center">STT</th>
                                <th style="width: 80px;" align="center">Tài khoản</th>
                                <th style="width: 80px;" align="center">Screen Name</th>
                                <th style="width: 80px;" align="center">Vip</th>
                                <th style="width: 80px;" align="center">Tổng Nạp</th>
                                <th style="width: 80px;" align="center">Số điện thoại</th>
                                <th>Nội dung</th>
                                <th style="width: 100px;" align="center">Ngày</th>
                                <th style="width:80px"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $count = $pageSize * ($page - 1) + 1;
                            foreach ($comments as $cm) {
                                echo "<tr>";
                                echo "<td align=center>" . $count . "</td>";
                                echo "<td align=center>" . $cm['username'] . "</td>";
                                echo "<td align=center>" . $cm['screen_name'] . "</td>";
                                echo "<td align=center>" . $cm['vip'] . "</td>";
                                echo "<td align=center>" . $cm['koin_added'] . "</td>";
                                if ($cm['mobile'] == '123456788') {
                                    echo "<td align=center></td>";
                                } else {
                                    echo "<td align=center>" . $cm['mobile'] . "</td>";
                                }
                                if ($cm['status'] == 1) {
                                    $index = strrpos($cm['comment'], '->');
                                    if ($index === false) {
                                        echo "<td class=comment>" . $cm['comment'] . "<font color=#4965AF> - đã xử lý</font></td>";
                                    } else {
                                        echo "<td class=comment>" . substr($cm['comment'], 0, $index - 1) . "<font color=#4965AF>" . substr($cm['comment'], $index - 1) . "</font></td>";
                                    }
                                } else {
                                    echo "<td class=comment>" . $cm['comment'] . "</td>";
                                }
                                echo "<td align=center>" . $cm['date'] . "</td>";
                                echo "<td align=center>";
                                echo "<a href='javascript:void(0);' onclick=\"showAll('feedback" . $cm['userId'] . "', " . $cm['userId'] . ")\"><img src='images/ui/message-icon.gif' width=20px/></a> ";
                                if ($cm['userId'] != 0) {
                                    echo " <a href='javascript:void(0);' onclick=\"prepareReply($(this)," . $cm['id'] . "," . $cm['userId'] . ")\"><img src='images/ui/mail_reply.png' width=20px/></a>";
                                }
                                echo "<a href='javascript:void(0);' onclick='disableReply($(this)," . $cm['id'] . ");'></a></td>"; //<img src='images/ui/1delete.png' width=20px/>
                                echo '<div id="feedback" style="display:none">demodemodemo</div>';
                                echo "</tr>";
                                $count++;
                            }
                            ?>
                        </tbody>
                    </table>
                    <div class="paging" style="text-align: center;">
                        <?php
                        $pageGroup = floor($page / 10);
                        if ($page > 10) {
                            echo "<a href=\"comment.php?" . $query . "&p=" . (($pageGroup - 1) * 10 + 1) . "\">... </a>";
                        }
                        for ($i = 0; $i < 10; $i++) {
                            if ($page == $pageGroup * 10 + 1 + $i) {
                                echo "<a href=\"comment.php?" . $query . "&p=" . ($pageGroup * 10 + 1 + $i) . "\">";
                                echo "<font color=\"white\">" . ($pageGroup * 10 + 1 + $i) . " </font></a>";
                            } else {
                                echo "<a href=\"comment.php?" . $query . "&p=" . ($pageGroup * 10 + 1 + $i) . "\">";
                                echo ($pageGroup * 10 + 1 + $i) . " </a>";
                            }
                        }
                        echo "<a href=\"comment.php?" . $query . "&p=" . (($pageGroup + 1) * 10 + 1) . "\"> ...</a>";
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>