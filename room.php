<?php
$name = $_GET["name"];
$roomId = $_GET["id"];
require('API/socket.php');
$service = 63745;
$input = "{\"roomId\":\"" . $roomId . "\"}";
//echo sendMessage($service, $input);
$jsonData = json_decode(sendMessage($service, $input));

?>
<!DOCTYPE html>
<html>
    <head>
        <title>Bem</title>
        <?php require('header.php'); ?>
        <script>
            function getTableDetail(roomId, tableId) {
                $.ajax({
                    type: "GET",
                    url: "API/tableDetail.php",
                    data: {
                        "roomId":roomId,
                        "tableId":tableId
                    },
                    dataType: 'text',
                    success: function(msg) {
                        msg = msg.trim();
                        if (msg != '' && msg.length > 2) {
                            var data = jQuery.parseJSON(msg);
                            if (data.status == 1) {
								var content = "<table width=100%>";
								$.each(data.players, function(index, value) {
									content += "<tr style='color:black; font-size:12px; border:none;'>";
									content += "<td width=100px align=left style='border:none;'>"+value.username+"</td><td width=100px align=center style='border:none;'>"+value.balance+"</td><td style='border:none;'>"+value.description+"</td>";
									content += "</tr>";
								});
								content += "</table>";
								$("#message").html(content);
                            } else {
                                $("#message").html(data.message);
                                $(this).oneTime(5000, function() {
                                    $("#message").html("");
                                });
                            }
                        } else {
                            $("#message").html("Lỗi hệ thống");
                            $(this).oneTime(5000, function() {
                                $("#message").html("");
                            });
                        }
                    },
                    failure: function() {
                        $("#message").html("Lỗi hệ thống");
                        $(this).oneTime(5000, function() {
                            $("#message").html("");
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
                <div class="box_header">
                    <a href="index.php"><?php echo $name; ?></a>
                </div>
                <div class="box_body">
                    <?php
                    foreach ($jsonData->{"tables"} as $table) {
                        echo "<div class=\"room_box\">";
                        if ($table->{"isPlay"} == false) {
                            echo "<div class=\"room_box_table\">";
                        } else {
                            echo "<div class=\"room_box_table\" style=\"background: url(images/ui/statusTable.png) no-repeat top left;\">";
                        }
                        if ($table->{"player"} == 0) {
                            echo "<a href=\"javascript:void(0)\" onclick=\"getTableDetail(" . $roomId . "," . $table->{"id"} . ")\" style=\"height:44px;\"><img src=\"images/ui/bc_01.png\"/></a>";
                        } else if ($table->{"player"} == 1) {
                            echo "<a href=\"javascript:void(0)\" onclick=\"getTableDetail(" . $roomId . "," . $table->{"id"} . ")\" style=\"height:44px;\"><img src=\"images/ui/bc_02.png\"/></a>";
                        } else if ($table->{"player"} == 2) {
                            echo "<a href=\"javascript:void(0)\" onclick=\"getTableDetail(" . $roomId . "," . $table->{"id"} . ")\" style=\"height:44px;\"><img src=\"images/ui/bc_03.png\"/></a>";
                        } else if ($table->{"player"} == 3) {
                            echo "<a href=\"javascript:void(0)\" onclick=\"getTableDetail(" . $roomId . "," . $table->{"id"} . ")\" style=\"height:44px;\"><img src=\"images/ui/bc_04.png\"/></a>";
                        } else if ($table->{"player"} == 4) {
                            echo "<a href=\"javascript:void(0)\" onclick=\"getTableDetail(" . $roomId . "," . $table->{"id"} . ")\" style=\"height:44px;\"><img src=\"images/ui/bc_05.png\"/></a>";
                        }
                        echo $table->{"desc"};
                        echo "</div>";
                        echo "</div>";
                    }
                    ?>
                    <div id="message" style="color:red; font-weight: bold; text-align: center; font-size: 16px; margin-top:15px;"></div>
                </div>
            </div>
        </div>
    </body>
</html>