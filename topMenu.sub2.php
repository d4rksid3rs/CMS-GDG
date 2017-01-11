<?php
$pars = '';
if (!empty($fromDate) OR ! empty($toDate)) {
    $pars .= "&fromDate=$fromDate&toDate=$toDate";
}
$pars .= isset($_REQUEST['nocache']) ? '&nocache' : '';
?>
<ul class="top-filter">
    <li>Cache tại thời điểm: <?php echo date("Y-m-d H:i:s"); ?> |</li>
    <li><a href="rev.php">Biến động doanh thu</a> |</li>
    <!--<li><a href="stat_sms.php?id=0<?php echo $pars; ?>">Sản lượng SMS</a> (<a href="stat_sms.php?sum&id=0">Tổng</a>) |</li>-->
    <!--<li><a href="stat_sms.php?id=1<?php echo $pars; ?>">Doanh thu SMS</a> (<a href="stat_sms.php?sum&id=1">Tổng</a>) |</li>-->
    <!--<li><a href="stat_os_sms.php?id=0<?php echo $pars; ?>">Doanh thu SMS theo OS</a> |</li>-->
    <!--<li><a href="stat_os_card.php?id=0<?php echo $pars; ?>">Doanh thu Card theo OS</a> |</li>-->
    <!--<li><a href="stat_card.php?<?php echo $pars; ?>">Doanh thu thẻ cào</a> (<a href="stat_card.php?sum">Tổng</a>) |</li>-->
    <!--<li><a href="stat_money.php">Chia sẻ doanh thu</a> |</li>-->
    <!--<li><a href="thongkesms.php">TK chi tiết tin nhắn</a> |</li>-->
    <!--<li><a href="tksmsdausodt.php">TK tin nhắn từ đầu số đối tác</a> | </li>-->
    <!--<li><a href="thongkethecao.php">TK chi tiết</a> |</li>-->
    <li><a href="koin_charge.php">Thống Kê Charging</a> |</li>
    <li><a href="koin_hour.php">TK doanh thu theo giờ</a></li>
</ul>
