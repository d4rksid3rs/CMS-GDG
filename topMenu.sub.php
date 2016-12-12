<?php
$pars = '';
if(!empty($fromDate) OR !empty($toDate))
{
    $pars .= "&fromDate=$fromDate&toDate=$toDate";
}
$pars .= isset($_REQUEST['nocache']) ? '&nocache' : '';

?>
<div class="topheader">
    <ul class="topMenus">
        Cache tại thời điểm: <?php echo date("Y-m-d H:i:s"); ?>
        <!--
        | <a href="stat_partner.php?id=0<?php echo $pars; ?>">Tất cả</a>
        | <a href="stat_partner.php?id=1<?php echo $pars; ?>">Từ đầu số VMG</a>
        | <a href="stat_partner.php?id=2<?php echo $pars; ?>">Từ đầu số VMG (Theo sđt)</a>
        -->
    </ul>
</div>
