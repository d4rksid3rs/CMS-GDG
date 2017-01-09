<?php
$today = date('Y-m-d', time());
require('API/db.class.php');
require('./_login_users.php');
$user_list = array_keys($users);
$sql_merchants = "SELECT merchants.*, auth_user.koin, auth_user.koin_vip FROM `merchants` JOIN auth_user ON merchants.username = auth_user.username";
//echo $sql_merchants;die;die
$i = 0;
if (!empty($_POST)) {
    $user = $_POST['user'];
    $screen_name = $_POST['screen'];
    $merchant_name = $_POST['name'];
    $address = $_POST['address'];
    $mobile = $_POST['mobile'];
    $email = $_POST['email'];
    $fb = $_POST['fb'];

    $username = mysql_escape_string($user);
    if (empty($_POST['id_merchant'])) {
        $sql = "select * from auth_user where username='" . $username . "' limit 0,1";
        $found = false;
        foreach ($db->query($sql) as $row) {
            $found = true;
            $user_id = $row['id'];
        }

        if ($found) {
            $sql_add_merchant = "INSERT INTO `merchants`(`user_id`, `username`, `screen_name`, `merchant_name`, `mobile`, `address`, `email`, `facebook`) "
                    . "VALUES ('{$user_id}','{$username}','{$screen_name}','{$merchant_name}','{$mobile}','{$address}','{$email}','{$fb}')";

            $db->exec($sql_add_merchant);
            echo "<span id='merchant-status'><b>Thêm Đại lý thành công</b></span>";
        } else {
            echo "<span id='merchant-status'>Không tìm thấy User</span>";
        }
    } else {
        $id = $_POST['id_merchant'];
        $sql_edit_merchant = "UPDATE `merchants` SET "
                . "`screen_name` = '{$screen_name}', "
                . "`merchant_name` = '{$merchant_name}', "
                . "`mobile` = '{$mobile}', "
                . "`address` = '{$address}', "
                . "`email` = '{$email}', "
                . "`facebook` = '{$fb}' "
                . "WHERE `merchants`.`id` = {$id}";
        $db->exec($sql_edit_merchant);
        echo "<span id='merchant-status'><b>Sửa Đại lý thành công</b></span>";
    }
}
$_POST = array();
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Đại lý</title>
        <?php require('header.php'); ?>
        <script src="js/highcharts.js" type="text/javascript"></script>
        <script type="text/javascript" src="js/themes/grid.js"></script> 
        <script>
            function addMerchantKoin() {
                var user = $("#addKoin input[name=user]").val();
                var pass = $("#addKoin input[name=pass]").val();
                var vnd = $("#addKoin input[name=koin]").val();
                $.ajax({
                    type: "POST",
                    url: "API/addMerchantKoin.php",
                    data: {
                        "user": user,
                        "pass": pass,
                        "vnd": vnd
                    },
                    dataType: 'text',
                    success: function (msg) {
                        msg = msg.trim();
                        if (msg != '' && msg.length > 2) {
                            var data = jQuery.parseJSON(msg);
                            if (data.status == 1) {
                                $("#addKoin #message").html("Cập nhật thành công");
                                $(this).oneTime(5000, function () {
                                    $("#addKoin #message").html("");
                                });
                            } else {
                                $("#addKoin #message").html(data.message);
                                $(this).oneTime(5000, function () {
                                    $("#addKoin #message").html("");
                                });
                            }
                        } else {
                            $("#addKoin #message").html("Lỗi hệ thống");
                            $(this).oneTime(5000, function () {
                                $("#addKoin #message").html("");
                            });
                        }
                    },
                    failure: function () {
                        $("#addKoin #message").html("Lỗi hệ thống");
                        $(this).oneTime(5000, function () {
                            $("#addKoin #message").html("");
                        });
                    }
                });
            }

            function getLogAddKoinByMerchant() {
                var user = $("#logKoinByMerchant input[name=user]").val();
                var from = $("#logKoinByMerchant input[name=fromDate]").val();
                var to = $("#logKoinByMerchant input[name=toDate]").val();
                $.ajax({
                    type: "GET",
                    url: "API/logMerchantAddKoin1.php",
                    data: {
                        "user": user,
                        "from": from,
                        "to": to
                    },
                    dataType: 'text',
                    success: function (msg) {
                        $("#logKoin1").html(msg);
                        $("#logKoin1").show();
                    },
                    failure: function () {
                        $("#logKoin1").html("<span>Không truy cập được dữ liệu</span>");
                        $("#btnFindListUser").attr("disabled", false);
                    }
                });
            }
            $("a.pagination-link-1").live("click", function (e) {
                e.preventDefault();
                var page = $(this).attr('page');
                var user = $("#logKoinByMerchant input[name=user]").val();
                var from = $("#logKoinByMerchant input[name=fromDate]").val();
                var to = $("#logKoinByMerchant input[name=toDate]").val();
                $.ajax({
                    type: "GET",
                    url: "API/logMerchantAddKoin1.php",
                    data: {
                        "page": page,
                        "user": user,
                        "from": from,
                        "to": to
                    },
                    dataType: 'text',
                    success: function (msg) {
                        $("#logKoin1").html(msg);
                        $("#logKoin1").show();
                    },
                    failure: function () {
                        $("#logKoin1").html("<span>Không truy cập được dữ liệu</span>");
                        $("#btnFindListUser").attr("disabled", false);
                    }
                });
            });
            function getLogAddKoinByUser() {
                var user = $("#logKoinByUser input[name=user]").val();
                var from = $("#logKoinByUser input[name=fromDate]").val();
                var to = $("#logKoinByUser input[name=toDate]").val();
                $.ajax({
                    type: "GET",
                    url: "API/logMerchantAddKoin2.php",
                    data: {
                        "user": user,
                        "from": from,
                        "to": to
                    },
                    dataType: 'text',
                    success: function (msg) {
                        $("#logKoin2").html(msg);
                        $("#logKoin2").show();
                    },
                    failure: function () {
                        $("#logKoin2").html("<span>Không truy cập được dữ liệu</span>");
                        $("#btnFindListUser").attr("disabled", false);
                    }
                });
            }
            function editMerchant(id) {
                var username = $("tr#merchant-" + id + " td:nth-child(1)").text();
                var merchant_name = $("tr#merchant-" + id + " td:nth-child(2)").text();
                var screen_name = $("tr#merchant-" + id + " td:nth-child(3)").text();
                var mobile = $("tr#merchant-" + id + " td:nth-child(4)").text();
                var address = $("tr#merchant-" + id + " td:nth-child(5)").text();
                var email = $("tr#merchant-" + id + " td:nth-child(6)").text();
                var fb = $("tr#merchant-" + id + " td:nth-child(7)").text();

                $("#addMerchant input[name=id_merchant]").val(id);
                $("#addMerchant input[name=user]").val(username);
                $("#addMerchant input[name=screen]").val(merchant_name);
                $("#addMerchant input[name=name]").val(screen_name);
                $("#addMerchant input[name=address]").val(address);
                $("#addMerchant input[name=fb]").val(fb);
                $("#addMerchant input[name=email]").val(email);
                $("#addMerchant input[name=mobile]").val(mobile);

                $("#addMerchant input[name=user]").attr('disabled', 'disabled');
                ;
                $('#add_merchant').hide();
                $("#edit_merchant").show();
            }

            function deleteMerchant(id) {
                var r = confirm("Xóa Đại lý này?");
                if (r == true) {
                    $.ajax({
                        type: "POST",
                        url: "API/deleteMerchant.php",
                        data: {
                            "id": id
                        },
                        dataType: 'text',
                        success: function (msg) {
                            $("#logKoin2").html(msg);
                            $("#logKoin2").show();
                        },
                        failure: function () {
                            $("#logKoin2").html("<span>Không truy cập được dữ liệu</span>");
                            $("#btnFindListUser").attr("disabled", false);
                        }
                    });
                    $(document).ajaxStop(function () {
                        window.location.reload();
                    });
                }
            }

            $("a.pagination-link-2").live("click", function (e) {
                e.preventDefault();
                var page = $(this).attr('page');
                var user = $("#logKoinByUser input[name=user]").val();
                var from = $("#logKoinByUser input[name=fromDate]").val();
                var to = $("#logKoinByUser input[name=toDate]").val();
                $.ajax({
                    type: "GET",
                    url: "API/logMerchantAddKoin2.php",
                    data: {
                        "page": page,
                        "user": user,
                        "from": from,
                        "to": to
                    },
                    dataType: 'text',
                    success: function (msg) {
                        $("#logKoin2").html(msg);
                        $("#logKoin2").show();
                    },
                    failure: function () {
                        $("#logKoin2").html("<span>Không truy cập được dữ liệu</span>");
                        $("#btnFindListUser").attr("disabled", false);
                    }
                });
            });
            $("#add_merchant").click(function () {
                var user = $("#addMerchant input[name=user]").val();
                var screen_name = $("#addMerchant input[name=screen]").val();
                var merchant_name = $("#addMerchant input[name=name]").val();
                var address = $("#addMerchant input[name=address]").val();
                var fb = $("#addMerchant input[name=fb]").val();
                var email = $("#addMerchant input[name=email]").val();
                var mobile = $("#addMerchant input[name=mobile]").val();
                $.ajax({
                    type: "POST",
                    url: "API/addMerchant.php",
                    data: {
                        "user": user,
                        "screen_name": screen_name,
                        "merchant_name": merchant_name,
                        "address": address,
                        "fb": fb,
                        "email": email,
                        "mobile": mobile
                    },
                    dataType: 'text',
                    success: function (msg) {
                        $("#logKoin2").html(msg);
                        $("#logKoin2").show();
                    },
                    failure: function () {
                        $("#logKoin2").html("<span>Không truy cập được dữ liệu</span>");
                        $("#btnFindListUser").attr("disabled", false);
                    }
                });
            });
            $(document).ready(function () {
                $(".datepicker").datepicker();
                var response = $("#merchant-status").html()
                $("#merchant-status").remove();
                console.log(response);
                $("#response").prepend(response);
            });
        </script>
    </head>
    <body>
        <div class="pagewrap">
            <?php require('topMenu.php'); ?>
            <div class="box grid">
                <div class="box_header" style="background-image: none;"><a href="javascript:void(0);">Danh sách Đại lý</a></div>
                <div class="box_body">
                    <form id="addMerchant" method="POST">
                        <fieldset>
                            <legend style="color: #fff; font-weight: bold;">Thêm Đại lý</legend>
                            <input type="hidden" name="id_merchant" />
                            Username <input type="text" name="user" />
                            Tên Hiển thị <input type="text" name="screen" />
                            Tên Đại lý <input type="text" name="name" />
                            Khu vực <input type="text" name="address" />
                            <br />
                            ĐT <input type="text" name="mobile" />
                            Email <input type="text" name="email" />
                            FaceBook <input type="text" name="fb" />
                            <br />
                            <input type="submit" id="add_merchant" value="Lưu"/>
                            <input type="submit" id="edit_merchant" value="Sửa" style="display:none;" />
                            <div id="response"></div>
                        </fieldset>
                    </form>

                    <hr />
                    <table width='100%' class="merchant">
                        <tr style='background-color: rgb(255, 255, 255);text-align:center;'>
                            <td>Username</td>
                            <td>Tên đại lý</td>
                            <td>Tên hiển thị</td>
                            <td>SĐT</td>
                            <td>Khu vực</td>
                            <td>Email</td>
                            <td>Facebook</td>
                            <td>Xu</td>
                            <td>Chip</td>
                            <td>Chức năng</td>
                        </tr>
                        <?php foreach ($db->query($sql_merchants) as $row) : ?>
                            <?php $i+=1; ?>
                            <tr id="merchant-<?php echo $row['id'] ?>" style='background-color: rgb(<?php ($i % 2 > 0) ? '204,204,204' : '255, 255, 255' ?>);text-align:center;'>
                                <td><?php echo $row['username'] ?></td>
                                <td><?php echo $row['merchant_name'] ?></td>
                                <td><?php echo $row['screen_name'] ?></td>
                                <td><?php echo $row['mobile'] ?></td>
                                <td><?php echo $row['address'] ?></td>
                                <td><?php echo $row['email'] ?></td>
                                <td><?php echo $row['facebook'] ?></td>
                                <td><?php echo $row['koin'] ?></td>
                                <td><?php echo $row['koin_vip'] ?></td>
                                <td><button onclick="editMerchant(<?php echo $row['id'] ?>)">Sửa</button> &nbsp; <button  onclick="deleteMerchant(<?php echo $row['id'] ?>)">Xóa</button></td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
            </div>     
            <div class="box">
                <div class="box_header" style="background-image: none;"><a href="javascript:void(0);">Cộng Xu</a></div>
                <div class="box_body">
                    <form id="addKoin">
                        Merchant
                        <input type="text" name="user" style="width: 100px"/>
                        Password <input type="password" name="pass" style="width: 100px"/>
                        VNĐ <input type="text" name="koin" style="width: 100px"/>
                        <input type="button" name="add" value="Thêm" onclick="addMerchantKoin();"/>
                        <span id="message" style="color: #800000; font-weight: bold"></span>
                    </form>
                </div>
            </div>
            <div class="box grid">
                <div class="box_header" style="background-image: none;"><a href="javascript:void(0);">Thống Kê theo Đại lý</a></div>
                <div class="box_body"  style="display: none">
                    <form id="logKoinByMerchant">
                        Merchant
                        <input type="text" name="user" style="width: 100px"/>
                        Từ Ngày
                        <input type="text" class="datepicker" name="fromDate" value="<?php echo $today ?>" style="text-align: center; width: 100px;" />
                        Tới Ngày
                        <input type="text" class="datepicker" name="toDate" value="<?php echo $today ?>" style="text-align: center; width: 100px;" />
                        <input type="button" name="add" value="Thống kê" onclick="getLogAddKoinByMerchant();"/>

                    </form>
                </div>
                <div id="logKoin1" style="display: none;">

                </div>
            </div>
            <div class="box grid">
                <div class="box_header" style="background-image: none;"><a href="javascript:void(0);">Thống Kê theo Người nạp</a></div>
                <div class="box_body"  style="display: none">
                    <form id="logKoinByUser">
                        Người nạp
                        <input type="text" name="user" style="width: 100px"/>
                        Từ Ngày
                        <input type="text" class="datepicker" name="fromDate" value="<?php echo $today ?>" style="text-align: center; width: 100px;" />
                        Tới Ngày
                        <input type="text" class="datepicker" name="toDate" value="<?php echo $today ?>" style="text-align: center; width: 100px;" />
                        <input type="button" name="add" value="Thống kê" onclick="getLogAddKoinByUser();"/>

                    </form>
                </div>
                <div id="logKoin2" style="display: none;">

                </div>
            </div>
        </div>
        <!-- The Modal -->
        <div id="myModal" class="modal">

            <!-- Modal content -->
            <div class="modal-content">
                <span class="close">×</span>
                <pre class="logKoin">
                    
                </pre>
            </div>

        </div>
    </body>
</html>
