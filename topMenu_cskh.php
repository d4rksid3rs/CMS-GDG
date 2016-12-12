<?php 
session_start();
	$settings 	= 			array("link"=>"settings.php","img"=>"settings.png","title"=>"Settings");
	$log 		= 			array("link"=>"stat_graphite.php","img"=>"media_record.png","title"=>"Log");
	$activity 	=			array("link"=>"activity.php","img"=>"activity.png","title"=>"Hoạt động");
	$koin	 	=			array("link"=>"koin.php","img"=>"koin.png","title"=>"T/k Tiền Trong game");
	$money	 	=			array("link"=>"stat_sms.php","img"=>"money_bills.png","title"=>"T/k doanh thu");
	$tool	 	=			array("link"=>"vip.php","img"=>"bembuild.png","title"=>"VIP user");
	$register 	=			array("link"=>"stat_partner.php","img"=>"stats.png","title"=>"T/k user đăng ký");
	$system 	=			array("link"=>"sysConfig.php","img"=>"system.png","title"=>"Hệ thống");
	$user	 	=			array("link"=>"user.php","img"=>"user.png","title"=>"Người chơi");
	$comment 	=			array("link"=>"comment.php","img"=>"comment.png","title"=>"Góp ý");
	$chatroom 	=			array("link"=>"chatroom.php","img"=>"comment.png","title"=>"Chatroom");
	$home	 	=			array("link"=>"index.php","img"=>"home.png","title"=>"Trang chủ");
	$picture	 	=			array("link"=>"picture.php","img"=>"picture.png","title"=>"Picture");
	$trans	 	=			array("link"=>"trans_card.php","img"=>"transaction.png","title"=>"Giao dịch xu");
		
?>
<div class="topheader">
    <div class="logo">
        <a href="index.php" title="<?php if (isset($totalMoney)) {echo number_format($totalMoney);}?>"><img src="images/logo.png" alt="" height="85px" /></a>
    </div>
    <ul class="topMenus">
                
		<?php 
		
			$u = isset($_SESSION['username']) ? $_SESSION['username'] : 'foobar';
			//echo "Xin chào ".$u;
			
			
			switch ($u){
				case "bemon":
				
					$menu = array($settings, $log, $trans, $activity,$koin,$money,$tool,$register,$system,$picture,$user,$chatroom,$comment,$home);
				break;
				
				case "mkt":
					$menu = array($log,$activity,$koin,$register,$system,$user,$comment,$home);
				break;
				
				case "sale":
					$menu = array($log,$activity,$koin,$money,$register,$home);
				break;
                
                case "chamsockh":
                    $menu = array($picture,$comment,$user,$home);
                break;
                
                case "dvkh":
                    header("Location: http://tk.trachanhquan.com/bi/comment.php");
                    $menu = array($picture,$comment);
                    break;
                
				default;
					$menu = array();
				break;
			}
			
			
			
			foreach ($menu as $m){
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
