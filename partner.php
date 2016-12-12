<?php
require('API/db.class.php');
$ids = $_GET['id'];


if (!isset($ids)) {
    $ids = "";
}

$sql = "SELECT f.* FROM system_message f ";
if ($acc != "") {
    $sql .= " where f.id = ".$ids;
}

$sql .= " order by date_created desc";

$messages = array();
foreach ($db->query($sql) as $row) {
    $messages[] = array('id' => $row['id'],
        'content' => $row['content'],
        'status' => $row['status'],
        'url' => $row['url'],
        'date_begin' => $row['date_begin'],
        'date_end' => $row['date_end'],
        'date_created' => $row['date_created']);
}

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
        <title>Bem</title>
        <?php require('header.php'); ?>
        <script>
            $(document).ready(function(){
				$("#datepicker1").datepicker();
				$("#datepicker2").datepicker();
			}); 
            
            
            function editPopup(id, content, url, status, begindate, enddate){
                
            }
            
            
            function addPopup() {
                var content = $("#addPopup input[name=user]").val();
                var pass = $("#addPopup input[name=pass]").val();
                var koin = $("#addPopup input[name=koin]").val();
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
        </script>
    </head>
    <body>
        <div class="pagewrap">
            <?php require('topMenu.php'); ?>
            <div class="box">
                <div class="box_header" style="background-image: none;"><a href="javascript:void(0);">Popup</a></div>
                <div class="box_body">
                <?php
                    $id = isset($_REQUEST['id']) ? trim($_REQUEST['id']) : NULL;
                    if($id!=NULL){
                        $sql = "SELECT * FROM system_message where id = ".$id;
                        foreach ($db->query($sql) as $row) {
                            //$messages[] = array('id' => $row['id'],
                            //'status' => $row['status'],
                            
                ?>
                    <form id="addPopup">
                        <table>
                            <tr>
                                <td valign="top">Nội Dung</td>
                                <td valign="top"><textarea name="content" style="width: 600px"><?php echo $row['content']; ?></textarea></td>
                            </tr>
                            <tr>
                                <td valign="top">Link</td>
                                <td valign="top"><input type="text" name="url" style="width: 500px;" value="<?php echo $row['url']; ?>" /></td>
                            </tr>
                            <tr>
                                <td valign="top">Trạng thái</td>
                                <td valign="top">
                                    <select name="status">
                                        <option <?php if($row['status']==0){echo "selected='true'";}?>>Disable</option>
                                        <option <?php if($row['status']==1){echo "selected='true'";}?>>Enable</option>
                                    </select>
                                </td>
                            </tr>
                            <?php
                                $sdate = substr($row['date_begin'], 0, -9);
                                $edate = substr($row['date_end'], 0, -9);
                            ?>
                            <tr>
                                <td valign="top">Ngày bắt đầu</td>
                                <td valign="top">
                                    <input type="text" id="datepicker1" name="fromDate" style="text-align: center; width: 100px;" value="<?php echo $sdate;?>"/>
                                </td>
                            </tr>
                            <tr>
                                <td valign="top">Ngày kế thúc</td>
                                <td valign="top">
                                    <input type="text" id="datepicker2" name="toDate" style="text-align: center; width: 100px;" value="<?php echo $edate;?>"/>
                                </td>
                            </tr>
                        </table>
                        <input type="button" name="add" value="Add" onclick="updatePopup();"/>
                        <span id="message" style="color: #800000; font-weight: bold"></span>
                    </form>
                <?php
                        }
                    }else{
                ?>
                    <form id="addPopup">
                        <table>
                            <tr>
                                <td valign="top">Nội Dung</td>
                                <td valign="top"><textarea name="content" style="width: 600px"></textarea></td>
                            </tr>
                            <tr>
                                <td valign="top">Link</td>
                                <td valign="top"><input type="text" name="url" style="width: 500px;" /></textarea></td>
                            </tr>
                            <tr>
                                <td valign="top">Trạng thái</td>
                                <td valign="top">
                                    <select name="status">
                                        <option>Enable</option>
                                        <option>Disable</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td valign="top">Ngày bắt đầu</td>
                                <td valign="top">
                                    <input type="text" id="datepicker1" name="fromDate" style="text-align: center; width: 100px;" value="<?php echo $fromDate;?>"/>
                                </td>
                            </tr>
                            <tr>
                                <td valign="top">Ngày kế thúc</td>
                                <td valign="top">
                                    <input type="text" id="datepicker2" name="toDate" style="text-align: center; width: 100px;" value="<?php echo $toDate;?>"/>
                                </td>
                            </tr>
                        </table>
                        <input type="button" name="add" value="Add" onclick="addPopup();"/>
                        <span id="message" style="color: #800000; font-weight: bold"></span>
                    </form>
                <?php } ?>
                </div>
                <div class="box grid">
                <div class="box_header">
                    <a href="javascript:void(0);">List Popup</a>
                </div>
                <div class="box_body">
                    <table width="100%" cellspacing="1" style="font-size:13px;">
                        <thead>
                            <tr>
                                <th style="width: 30px;" align="center">STT</th>
                                <th>Nội Dung</th>
                                <th style="width: 80px;" align="center">Trạng thái</th>
                                <th style="width: 80px;" align="center">URL</th>
                                <th style="width: 100px;" align="center">Ngày bắt đầu</th>
                                <th style="width: 100px;" align="center">Ngày kết thúc</th>
                                <th style="width:80px"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $count = 1;
                            foreach ($messages as $msg) {
                                echo "<tr>";
                                echo "<td align=center>" . $count . "</td>";
                                echo "<td align=center>" . $msg['content'] . "</td>";
                                if ($msg['status'] == 1) {
                                    echo "<td align=center>Enable</td>";
                                } else {
                                    echo "<td align=center>Disable</td>";
                                }
                                echo "<td align=center>" . $msg['url'] . "</td>";
                                echo "<td align=center>" . $msg['date_begin'] . "</td>";
                                echo "<td align=center>" . $msg['date_end'] . "</td>";
                                echo "<td align=center>";
                                echo "<a href='popup.php?id=".$msg['id']."' ><img src='images/ui/icon_edit.png' width='20px' alt='sửa' /> </a>";
                                echo "<a href='javascript:void(0);' > <img src='images/ui/1delete.png' width='20px' alt='xóa' /></a></td>";
                                echo "</tr>";
                                $count++;
                            }
                            ?>
                        </tbody>
                    </table>
                    <div class="paging" style="text-align: center;">
                        <?php
                            //$pageGroup = floor($page / 10);
//                            if ($page > 10) {
//                                echo "<a href=\"popup.php?&p=" . (($pageGroup - 1) * 10 + 1) . "\">... </a>";
//                            }else{
//                                for ($i = 0; $i < 10; $i++) {
//                                    if ($page == $pageGroup * 10 + 1 + $i) {
//                                        echo "<a href=\"popup.php?&p=".($pageGroup * 10 + 1 + $i)."\">";
//                                        echo "<font color=\"white\">".($pageGroup * 10 + 1 + $i)." </font></a>";
//                                    } else {
//                                        echo "<a href=\"popup.php?&p=".($pageGroup * 10 + 1 + $i)."\">";
//                                        echo ($pageGroup * 10 + 1 + $i)." </a>";
//                                    }
//                                }
//                                echo "<a href=\"popup.php?&p=" . (($pageGroup + 1) * 10 + 1) . "\"> ...</a>";
//                            }
                        ?>
                    </div>
                </div>
              </div>
            </div>
        </div>
    </body>
</html>
