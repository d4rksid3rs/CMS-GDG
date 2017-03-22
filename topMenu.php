<?php
session_start();
require_once('_login.php');
$logout = array("link" => "logout.php", "img" => "logout.png", "title" => "Logout");
$settings = array("link" => "settings.php", "img" => "settings.png", "title" => "Settings");
$log = array("link" => "stat_graphite.php", "img" => "media_record.png", "title" => "Log");
$activity = array("link" => "activity.php", "img" => "activity.png", "title" => "Hoạt động");
$koin = array("link" => "koin.php", "img" => "koin.png", "title" => "T/k Tiền Trong game");
$money = array("link" => "rev.php", "img" => "money_bills.png", "title" => "T/k doanh thu");
$tool = array("link" => "vip.php", "img" => "bembuild.png", "title" => "VIP user");
//$register = array("link" => "stat_partner.php", "img" => "stats.png", "title" => "T/k user đăng ký");
$system = array("link" => "sysConfig.php", "img" => "system.png", "title" => "Hệ thống");
$user = array("link" => "user.php", "img" => "user.png", "title" => "Người chơi");
$comment = array("link" => "comment.php", "img" => "comment.png", "title" => "Góp ý");
$chatroom = array("link" => "chatroom.php", "img" => "comment.png", "title" => "Chatroom");
$home = array("link" => "index.php", "img" => "home.png", "title" => "Trang chủ");
$picture = array("link" => "picture.php", "img" => "picture.png", "title" => "Picture");
//$trans = array("link" => "trans_card.php", "img" => "transaction.png", "title" => "Giao dịch xu");
$dau = array("link" => "dau.php", "img" => "dau.png", "title" => "DAU");
$game = array("link" => "game.php", "img" => "game.png", "title" => "GAME");
$vip = array("link" => "cskhvip.php", "img" => "vip.png", "title" => "CSKH Vip");
$exchange = array("link" => "exchange.php", "img" => "exchange.png", "title" => "User đổi thưởng");
$exchange_return = array("link" => "exchange_return.php", "img" => "exchange_return.png", "title" => "User cộng bù Vàng");
$merchant = array("link" => "merchant.php", "img" => "merchants.png", "title" => "Đại lý");
$new_statistic = array("link" => "new_statistic.php", "img" => "new_statistic.png", "title" => "Thống kê Mới");
$secret = array("link" => "secret.php", "img" => "secret.png", "title" => "Secret");
?>
<div class="topheader">
    <div class="logo">
        <a href="index.php" title="<?php
        if (isset($totalMoney)) {
            echo number_format($totalMoney);
        }
        ?>"><img src="images/logo.png" alt="" height="85px" /></a>
    </div>
    <ul class="topMenus" id="mainMenu">



        <?php
        $u = isset($_SESSION['username']) ? $_SESSION['username'] : 'foobar';
        //echo "Xin chào ".$u;


        switch ($u) {
            case "bemon":

                $menu = array($logout, $settings, $activity, $koin, $money, $vip, $tool, $system , $exchange_return, $exchange, $new_statistic, $user, $comment, $merchant, $dau, $game);
                break;
            case "admin":

                $menu = array($logout, $secret, $settings, $activity, $koin, $money, $vip, $tool, $system, $exchange_return, $exchange, $new_statistic, $user, $comment, $merchant, $dau, $game);
                break;
            case "cskh":

                $menu = array($logout, $settings, $koin, $money, $vip, $tool, $exchange_return, $exchange, $new_statistic, $user, $comment);
                break;
            case "ccu":

                $menu = array($logout, $game);
                break;
            case "vmg":

                $menu = array($logout, $user);
                break;
//            case "monaco":
//
//                $menu = array($logout, $settings, $activity, $koin, $money,$vip, $tool, $system, $exchange_return, $exchange, $user, $comment, $merchant, $dau, $game);
//                break;
//            case "vuong":
//                $menu = array($logout, $settings, $activity, $koin, $money,$vip, $tool, $system, $exchange_return, $exchange, $user, $comment, $merchant, $dau, $game);
//                break;
//            case "hoa":
//                $menu = array($logout, $settings, $activity, $koin, $money,$vip, $tool, $system, $exchange_return, $exchange, $user, $comment, $merchant, $dau, $game);
//                break;
//            case "monacovh":
//
//                $menu = array($logout, $settings, $activity, $koin, $money,$vip, $tool, $system, $user, $comment, $dau, $game);
//                break;
//            case "hq":
//
//                $menu = array($logout, $settings, $activity, $koin, $money,$vip, $tool, $system, $user, $comment, $dau, $game);
//                break;
//            
//            case "mkt":
//                $menu = array($activity, $koin,$vip, $system, $user, $comment);
//                break;
//
//            case "sale":
//                $menu = array($activity, $koin, $money);
//                break;
//
//            case "chamsockh":
//            case "huong":
//                header("Location: http://beme.net.vn/bi1/comment.php");
//                $menu = array($logout, $comment, $user, $trans);
//                break;
//
//            case "nguyet":
//            case "lam":
//                //echo $_SERVER['REQUEST_URI'];
//                /*                     header("Location: http://beme.net.vn/bi1/vip.php"); */
//                /*                     header("Location: http://beme.net.vn/bi1/comment.php"); */
//                $menu = array($logout,$vip, $comment, $user);
//                break;
            default;
                setcookie($domain_code . '_uid', '');
                setcookie($domain_code . '_cid', '');
                setcookie('username', '');
                header("LOCATION: index.php");
                break;
        }



        foreach ($menu as $m) {
            $link = $m['link'];
            $img = $m['img'];
            $head_title = $m['title'];
            echo "<li>
						<a href='{$link}'><img src='images/ui/{$img}' height='40px'/>
						<br/>{$head_title}</a>
					</li>";
        }
        ?>



    </ul>
</div>
<script>
    var height = $("#mainMenu").height();
    var new_height = height + 20;
    $(".topheader").height(new_height);
</script>
