<?php
session_start();


?>
<!DOCTYPE html>
<html>
    <head>
        <title>Tool build BEME</title>
        <?php require('header.php'); ?>
        
        
    </head>
    <body>
        <div class="pagewrap">
            <?php require('topMenu.php'); ?>
            

            <div class="box grid">
                
                <div class="box_header"><a href="javascript:void(0);">Bem Builder</a></div>
                <div class="box_body">
                    <table width="100%">
                        <div style="padding-left:10px;">
                        <?php
                                $cmd = isset($_REQUEST["cmd"])?trim($_REQUEST["cmd"]):NULL;
                                if($cmd != NULL && $cmd=="Submit"){
                                    
                                    $nuser = isset($_REQUEST["user"])?trim($_REQUEST["user"]):"bem";
                                    
                                    $npass = isset($_REQUEST["pass"])?trim($_REQUEST["pass"]):"bem123";
                                    
                                    $cp = isset($_REQUEST["code"])?trim($_REQUEST["code"]):"K2";
                                    
                                    $json = file_get_contents("http://trachanhquan.com/stats/addpartner.php?user=".$nuser."&pass=".$npass."&code=".$cp);
                                    
                                    $jss = json_decode($json);
                                    
                                    $status = $jss->status;
                                    
                                    if($status==1){
                                    
                                        $file_jar = "/home/k2tek/domains/trachanhquan.com/tcq.jar";
                                        $cfg = "/home/k2tek/domains/trachanhquan.com/cfg";
                                        
                                        $name = 'tcq';
                                        $fp = fopen($cfg, 'w');
                                        fwrite($fp, "cp:".$cp."\r\n");
                                        fwrite($fp, "more:http://trachanhquan.com\r\n");
                                        fwrite($fp, "drawlogo:true\r\n");
                                        fwrite($fp, "showhelp:true\r\n");
                                        fwrite($fp, "version:1.0.0\r\n");
                                        fwrite($fp, "share:http://trachanhquan.com/?ref=\r\n");
                                        fwrite($fp, "email:info@trachanhquan.com\r\n");
                                        fwrite($fp, "thecao:true\r\n");
                                        fwrite($fp, "invite:true\r\n");
                                        fwrite($fp, "tangkoin:true\r\n");
                                        fclose($fp);
                                        //$path = shell_exec("/home/admin/bembuilder/run.sh '$cfg' 'Bem 301' '$file_jar' '$icon' '$cp' '$name' '$logo' 2>&1");
                                        $path = shell_exec("/home/k2tek/tcqbuilder/run.sh '$cfg' 'Tra Chanh Quan' '$file_jar' 'na' '$cp' '$name' 'na' 2>&1");
                                        
                                        
                                        echo "<b>Build Thành công!</script>";
                                        echo "<br/>";
                                        echo "Link tải JAD: <a href= 'http://trachanhquan.com/".$cp."/tcq.jad' >http://trachanhquan.com/".$cp."/tcq.jad</a>";
                                        echo "<br/>";
                                        echo "Link tải JAR: <a href='http://trachanhquan.com/".$cp."/tcq.jar' >http://trachanhquan.com/".$cp."/tcq.jar</a>";
                                        echo "<br/>";
                                        echo "<br/>";
                                        echo "Link Xem Doanh Thu: <a href='http://trachanhquan.com/stats/' >http://trachanhquan.com/stats/</a>";
                                        echo "<br/>";
                                        echo "<br/>";
                                        echo "Account/Pass Xem Doanh Thu: ".$nuser."/".$npass."</b>";
                                    }else if($status==-1){
                                        echo "<b>".$jss->message."</b>";
                                    }
                                    
                                }else {
                            ?>
                        
                            <form method="post" name="form" id="form" action="" >
                                <table>
                                    
                                    <tr>
                                        <td>UserName Xem Doanh Thu:</td>
                                        <td><input type="text" name="user" /></td>
                                    </tr>
                                    
                                    <tr>
                                        <td>PassWord Xem Doanh Thu:</td>
                                        <td><input type="text" name="pass" /></td>
                                    </tr>
                                    <tr>
                                        <td>Mã CP:</td>
                                        <td><input type="text" name="code" /></td>
                                    </tr>
                                    
                                    <tr>
                                        <td></td>
                                        <td><input type="submit" value="Submit" name="cmd" class="input_button"/></td>
                                    </tr>
                                </table>
                            </form>
                            <?php } ?>
                         <div style="height: 20px;"></div>
                         <div id="chart_div" style="width: 900px; ">
                            
                            
                         </div>
                        </div>
                    </table>
                </div>
            </div>
        </div>
    </body>
</html>