<?php

function es_query($qry) {
    $ch = curl_init();
    $url = "localhost/*/tcq-money/_search";
    //$url = "10.0.0.1/*/tcq-money/_search";
    $method = "GET";

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_PORT, 9200);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, strtoupper($method));
    curl_setopt($ch, CURLOPT_POSTFIELDS, $qry);
    $result = curl_exec($ch);
    curl_close($ch);

    return $result;
}

require('API/db.class.php');
$date = isset($_POST['date']) ? trim($_POST['date']) : date('Y-m-d');
$username = isset($_POST['user']) ? trim(strtolower($_POST['user'])) : "";

$max_row = 10000;
$data = array();
if (!empty($username)) {

    $qry_fmt = '
    {
        "from": 0,
        "size" : %d,
        "sort" : [
            {"@timestamp": {"order":"desc"}}
        ],
        "fields": ["@fields.f1","@fields.f2","@fields.f3","@fields.f4","@fields.f5","@fields.f6"],
        "query": {
            "query_string": {
                "fields": ["@fields.f4"],
                "query": "%s",
                "use_dis_max": true
            },
            "filtered" : {
                "filter" :{
                    "range": {
                        "@timestamp": {"from": "%s", "to": "%s"}
                }
            }
        }
    }
    ';
    $from_time = $date . "T00:00:00+07:00";
    $to_time = $date . "T23:59:59+07:00";
    $qry = sprintf($qry_fmt, $max_row, $username, $from_time, $to_time);

    /*
      $qry_fmt = '
      {
      "from": 0,
      "size" : %d,
      "sort" : [
      {"@timestamp": {"order":"desc"}}
      ],
      "fields": ["@fields.f1","@fields.f2","@fields.f3","@fields.f4","@fields.f5","@fields.f6"],
      "query": {
      "query_string": {
      "fields": ["@fields.f4"],
      "query": "%s",
      "use_dis_max": true
      }
      },
      "prefix": {"@fields.f1": "%s "}
      }
      ';
      $qry = sprintf($qry_fmt, $max_row, $username, $date);
     */
    $es_result = es_query($qry);
    $arr = json_decode($es_result, TRUE);
    $hits = $arr['hits']['hits'];

    $count = 0;
    foreach ($hits as $key => $value) {
        $data[$count] = array(
            "time" => $value['fields']['@fields.f1'][0],
            "key" => $value['fields']['@fields.f2'][0],
            "relate" => $value['fields']['@fields.f3'][0],
            "xxx" => $value['fields']['@fields.f4'][0],
            "balance" => $value['fields']['@fields.f5'][0],
            "trans" => $value['fields']['@fields.f6'][0],
        );
        $count++;
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Giao dịch xu</title>
        <link type='text/css' href='css/basic.css' rel='stylesheet' media='screen' />
<?php require('header.php'); ?>
        <script src="js/jquery.simplemodal.js"></script>
        <script type="text/javascript" >
            $(document).ready(function () {
                $("#datepicker1").datepicker();
            });

            function prepareReply(element, id, userId) {
                $(".reply").remove();
                var parent = element.parent().parent();
                parent.after("<tr class='reply'><td colspan=5 align=right><input type='text' name='replyContent' style='margin-right:5px; width:250px;'/><input type='button' value='Trả lời' style='margin-right:5px;' onclick='reply(" + id + "," + userId + ");'/><input type='button' value='Hủy' onclick='$(this).parent().parent().remove();'/></td></tr>");
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

            function findUserDB() {
                var username = $("#findUser input[name=user]").val();
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
                                document.getElementById("findUser").submit();
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
        </script>
    </head>
    <body>
        <div class="pagewrap">
<?php require('topMenu.php'); ?>			                        
            <div class="box grid">
                <div class="box_body">

<?php require('topMenu.trans.php'); ?>
                    <div class="box_header">
                        Thông tin
                    </div>
                    <form action="trans.php" method="post" style="margin-bottom: 0px; padding-bottom: 0px;" id="findUser">
                        <table width="100%" style="font-size: 13px;">
                            <tr>
                                <td width="250px">
                                    Tài khoản
                                    <input type="text" name="user" class="input_text" value="<?php echo $username; ?>" style="margin-left: 10px;"/>
                                </td>
                                <td>
                                    Ngày
                                    <input type="text" id="datepicker1" name="date" style="text-align: center; width: 100px;" value="<?php echo $date; ?>"/> 
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
                <div class="box_header">
                    <a href="javascript:void(0);">Kết quả tìm kiếm</a>
                </div>
                <div class="box_body">
                    <table width="100%" cellspacing="1" style="font-size:13px;">
                        <thead>
                            <tr>
                                <th style="width: 150px;" align="center">Thời gian</th>
                                <th style="width: 150px;" align="center">Keyword</th>
                                <th>Người chơi trong bàn</th>
                                <th style="width: 200px;">Chi tiết</th>
                                <th style="width: 100px;" align="center">Tài khoản</th>
                                <th style="width: 100px;" align="center">Giao dịch</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($data as $row) {
                                echo "<tr>";
                                echo "<td align=center>" . $row["time"] . "</td>";
                                echo "<td align=center>" . $row["key"] . "</td>";
                                echo "<td style='padding-left:10px;'>" . $row["relate"] . "</td>";
                                echo "<td align=center>" . $row["xxx"] . "</td>";
                                echo "<td align=center>" . $row["balance"] . "</td>";
                                echo "<td align=center>" . $row["trans"] . "</td>";
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
