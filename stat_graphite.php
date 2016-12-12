<?php
$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Log</title>
        <?php require('header.php'); ?>
    </head>
    <body>
        <div class="pagewrap">
            <?php require('topMenu.php'); ?>
            <?php include('topMenu.sub3.php'); ?>

            <?php if($id === 0): ?>

            <div class="box grid">
                <div class="box_header"><a href="javascript:void(0);">Log lượt login</a></div>
                <div class="box_body">
                    <table width="100%">
                        <img src="http://localhost:8080/render?width=800&height=400&target=hitcount%28stats.bem.login,%221h%22%29&from=-2day" />
                    </table>
                </div>
            </div>

            <?php elseif($id === 1): ?>

            <div class="box grid">
                <div class="box_header"><a href="javascript:void(0);">Log sl sms</a></div>
                <div class="box_body">
                    <table width="100%">
                        <img src="http://localhost:8080/render?width=800&height=400&target=hitcount%28stats.sms.gapit.8*,%221h%22%29&from=-2day" />
                    </table>
                </div>
            </div>

            <?php elseif($id === 2): ?>

            <div class="box grid">
                <div class="box_header"><a href="javascript:void(0);">Log lượt tải</a></div>
                <div class="box_body">
                    <table width="100%">
                        <img src="http://localhost:8080/render?width=800&height=400&target=hitcount%28stats.bem.download,%221h%22%29&from=-2day" />
                    </table>
                </div>
            </div>

            <?php endif; ?>

        </div>
    </body>
</html>
