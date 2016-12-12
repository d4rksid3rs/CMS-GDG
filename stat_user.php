<?php
session_start();


?>
<!DOCTYPE html>
<html>
    <head>
        <title>Thống kê Đối tác</title>
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
                                $cpid = isset($_REQUEST["id"])?trim($_REQUEST["id"]):NULL;
                                if($cmd != NULL && $cmd=="Submit"){
                                    
                                    $cpname = isset($_REQUEST["cpname"])?trim($_REQUEST["cpname"]):"";
                                    
                                    $external = isset($_REQUEST["external"])?trim($_REQUEST["external"]):"";
                                    
                                    $internal = isset($_REQUEST["internal"])?trim($_REQUEST["internal"]):"";
                                    
                                    $cptype = isset($_REQUEST["cptype"])?trim($_REQUEST["cptype"]):"";
                                    
                                    $linkbuild  = isset($_REQUEST["linkbuild"])?trim($_REQUEST["linkbuild"]):"";
                                    
                                    $version  = isset($_REQUEST["version"])?trim($_REQUEST["version"]):"";
                                    
                                    $linkstats  = isset($_REQUEST["linkstats"])?trim($_REQUEST["linkstats"]):"";
                                    
                                    $connect_type  = isset($_REQUEST["connect_type"])?trim($_REQUEST["connect_type"]):"";
                                    
                                    $recipient  = isset($_REQUEST["recipient"])?trim($_REQUEST["recipient"]):"";
                                    
                                    $sms_dk  = isset($_REQUEST["sms_dk"])?trim($_REQUEST["sms_dk"]):"";
                                    
                                    $sms_nap  = isset($_REQUEST["sms_nap"])?trim($_REQUEST["sms_nap"]):"";
                                    
                                    $status  = isset($_REQUEST["status"])?trim($_REQUEST["status"]):"";
                                    
                                    $note = isset($_REQUEST["note"])?trim($_REQUEST["note"]):"K2";
                                    
                                    $id = isset($_REQUEST["idcp"]) ? trim($_REQUEST["idcp"]) : NULL;
                                    $host="127.0.0.1";
                                    $user="dong";
                                    $password="dong!@#654";
                                    
                                    $link = mysql_connect($host,$user,$password);
                                    mysql_select_db("beme_cp",$link);
                                    mysql_set_charset('utf8',$link);
                                    //mysql_select_db("altp") or die("Ko ket noi duoc toi CSDL");
                                    if($id==NULL){
                                        $sql = "INSERT INTO cp_manager(cpname, external, internal, cptype, linkbuild, version, note, linkstats, connect_type, recipient, sms_dk, sms_nap, status) VALUES ('{$cpname}', '{$external}', '{$internal}', '{$cptype}', '{$linkbuild}', '{$version}', '{$note}', '{$linkstats}', '{$connect_type}', '{$recipient}', '{$sms_dk}', '{$sms_nap}', '{$status}')";
                                        //echo $sql;
                                        mysql_query($sql) or die ("Khong the them thong tin!");
                                        echo "<script> alert('Thành công!');</script>";
                                        echo "<script>window.location='stat_user.php';</script>";
                                    }else{
                                        $sql="update cp_manager SET cpname='{$cpname}', external='{$external}', internal='{$internal}', cptype='{$cptype}', linkbuild='{$linkbuild}', version='{$version}', note='{$note}', linkstats='{$linkstats}', connect_type='{$connect_type}', recipient='{$recipient}', sms_dk='{$sms_dk}', sms_nap='{$sms_nap}', status='{$status}' WHERE cpid = ".$id;
                                    	mysql_query($sql) or die("Khong the cap nhat thong tin");
                                        echo "<script> alert('Cập nhật Thành công!');</script>";
                                    	echo "<script> window.location='stat_user.php';</script>";
                                    }
                                }else if($cpid!=NULL){
                                    $host="127.0.0.1";
                                    $user="dong";
                                    $password="dong!@#654";
                                    
                                    $link = mysql_connect($host,$user,$password);
                                    mysql_select_db("beme_cp",$link);
                                    mysql_set_charset('utf8',$link);
                                    $sql = "SELECT * FROM cp_manager where cpid = ".$cpid;
                                    $rs=mysql_query($sql) or die("Không có đối tác nào");
                                    $row=mysql_fetch_array($rs);
                            ?>
                            
                            <form method="post" name="form" id="form" action="stat_user.php?idcp=<?php echo $row["cpid"]; ?>" >
                                <table>
                                    <tr>
                                        <td>Tên đối tác:</td>
                                        <td><input type="text" name="cpname" value="<?php echo $row["cpname"]; ?>"/></td>
                                    </tr>
                                    <tr>
                                        <td>Mã code External:</td>
                                        <td><input type="text" name="external" value="<?php echo $row["external"]; ?>"/></td>
                                    </tr>
                                    <tr>
                                        <td>Mã code Internal:</td>
                                        <td><input type="text" name="internal" value="<?php echo $row["internal"]; ?>"/></td>
                                    </tr>
                                    <tr>
                                        <td>Phân Loại đối tác:</td>
                                        <td>
                                            <select name="cptype">
                                                <option value="1" <?php if($row["cptype"]=="1"){ echo "selected='true'"; } ?> >Wap thông thường</option>
                                                <option value="2" <?php if($row["cptype"]=="2"){ echo "selected='true'"; } ?> >Đối tác lớn</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Link bản build:</td>
                                        <td><input type="text" name="linkbuild" value="<?php echo $row["linkbuild"]; ?>"/></td>
                                    </tr>
                                    <tr>
                                        <td>Version:</td>
                                        <td><input type="text" name="version" value="<?php echo $row["version"]; ?>"/></td>
                                    </tr>
                                    
                                    <tr>
                                        <td>Trang xem sản lượng:</td>
                                        <td>
                                            <input type="text" name="linkstats" value="<?php echo $row["linkstats"]; ?>"/>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Hình thức kết nối:</td>
                                        <td>
                                            <textarea name="connect_type" style="height: 100px; width: 300px;"><?php echo $row["connect_type"]; ?></textarea>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Đầu số:</td>
                                        <td>
                                            <input type="text" name="recipient" value="<?php echo $row["recipient"]; ?>"/>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Cú pháp đăng kí:</td>
                                        <td>
                                            <textarea name="sms_dk" style="height: 100px; width: 300px;"><?php echo $row["sms_dk"]; ?></textarea>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Cú pháp Nạp:</td>
                                        <td>
                                            <textarea name="sms_nap" style="height: 100px; width: 300px;"><?php echo $row["sms_nap"]; ?></textarea>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Trạng thái kết nối, build:</td>
                                        <td>
                                            <select name="status">
                                                <option value="1" <?php if($row["status"]=="1"){ echo "selected='true'"; } ?> >Hoàn thành</option>
                                                <option value="0" <?php if($row["status"]=="0"){ echo "selected='true'"; } ?> >Chưa hoàn thành</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Note:</td>
                                        <td>    
                                            <textarea name="note" style="height: 100px; width: 300px;"><?php echo $row["note"]; ?></textarea>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td><input type="submit" value="Submit" name="cmd" class="input_button"/></td>
                                    </tr>
                                </table>
                            </form>
                            
                            
                            <?php
                                    
                                    
                                }else {
                            ?>
                        
                            <form method="post" name="form" id="form" action="" >
                                <table>
                                    <tr>
                                        <td>Tên đối tác:</td>
                                        <td><input type="text" name="cpname"/></td>
                                    </tr>
                                    <tr>
                                        <td>Mã code External:</td>
                                        <td><input type="text" name="external"/></td>
                                    </tr>
                                    <tr>
                                        <td>Mã code Internal:</td>
                                        <td><input type="text" name="internal" /></td>
                                    </tr>
                                    <tr>
                                        <td>Phân Loại đối tác:</td>
                                        <td>
                                            <select name="cptype">
                                                <option value="1">Wap thông thường</option>
                                                <option value="2">Đối tác lớn</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Link bản build:</td>
                                        <td><input type="text" name="linkbuild" /></td>
                                    </tr>
                                    <tr>
                                        <td>Version:</td>
                                        <td><input type="text" name="version" /></td>
                                    </tr>
                                    
                                    <tr>
                                        <td>Trang xem sản lượng:</td>
                                        <td>
                                            <input type="text" name="linkstats" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Hình thức kết nối:</td>
                                        <td>
                                            <textarea name="connect_type" style="height: 100px; width: 300px;"></textarea>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Đầu số:</td>
                                        <td>
                                            <input type="text" name="recipient" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Cú pháp đăng kí:</td>
                                        <td>
                                            <textarea name="sms_dk" style="height: 100px; width: 300px;"></textarea>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Cú pháp Nạp:</td>
                                        <td>
                                            <textarea name="sms_nap" style="height: 100px; width: 300px;"></textarea>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Trạng thái kết nối, build:</td>
                                        <td>
                                            <select name="status">
                                                <option value="1">Hoàn thành</option>
                                                <option value="0">Chưa hoàn thành</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Note:</td>
                                        <td>    
                                            <textarea name="note" style="height: 100px; width: 300px;"></textarea>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td><input type="submit" value="Submit" name="cmd" class="input_button"/></td>
                                    </tr>
                                </table>
                            </form>
                            <?php } ?>
                         <div style="height: 20px;"></div>
                         <div id="chart_div" style="width: 100%; ">
                         <?php
                            $host="127.0.0.1";
                            $user="dong";
                            $password="dong!@#654";
                            
                            $link = mysql_connect($host,$user,$password);
                            mysql_select_db("beme_cp",$link);
                            mysql_set_charset('utf8',$link);
                            
                            $sql = "SELECT * FROM cp_manager";
                            //echo $sql;
                            
                            
                            $rs=mysql_query($sql) or die("Không có đối tác nào"); 
                            if (mysql_num_rows($rs)<=0)
                            	echo "loi~";
                            else {
                            echo "<table width='100%' border='1' align='center' cellpadding='0' cellspacing='0'>".
                            "<tr>".
                				"<th>Tên đối tác</th>".
    							"<th>Mã External</th>".
    							"<th>Mã Internal</th>".
                                "<th>Phân loại đối tác</th>".
                                "<th>Link Build</th>".
                                "<th>Version</th>".
                                "<th>Trang xem sản lượng</th>".
                                "<th>Đầu số</th>".
                                "<th>Trạng thái kết nối</th>".
                                "<th>Command</th>".
                            "</tr>";
                            
                            $sobanghitrentrang = 20;
    						$soluongtrang=ceil(mysql_num_rows($rs)/$sobanghitrentrang);
    						$sotrang=isset($_REQUEST["p"])?trim($_REQUEST["p"]):0;
    						if($sotrang<=0) $sotrang=1;
    						if($sotrang>$soluongtrang) $sotrang=$soluongtrang;
    						$sql1=$sql." limit ".($sotrang-1)*$sobanghitrentrang.",".$sobanghitrentrang;
    						$rs2=mysql_query($sql1) or die("Không có người dùng nào thỏa mãn điều kiện!");
    						
                            
  					  		while($row=mysql_fetch_array($rs2)){
    					            echo "<tr>".
                                    "<td align='center'>".$row["cpname"]."</td>".
                                    "<td align='center'>".$row["external"]."</td>".
        							"<td align='center'>".$row["internal"]."</td>".
                                    "<td align='center'>";
                                        if($row["cptype"]==1){
                                            echo "Wap thông thường";
                                        }else{
                                            echo "Đối tác lớn";
                                        }
                                    
                                    echo "</td>".
                                    "<td align='center'>".$row["linkbuild"]."</td>".
                                    "<td align='center'>".$row["version"]."</td>".
                                    "<td align='center'>".$row["linkstats"]."</td>".
                                    "<td align='center'>".$row["recipient"]."</td>".
                                    "<td align='center'>";
                                        if($row["status"]==1){
                                            echo "Hoàn thành";
                                        }else{
                                            echo "Chưa hoàn thành";
                                        }
                                    
                                    echo "</td><td align='center'><a href='stat_user.php?id=".$row["cpid"]."'><img src='images/icon_edit.png' /><br/>Sửa</a></td></tr>";
                				  }
                                    echo "</table>";
                                }
                            for($i=1;$i<=$soluongtrang;$i++){
        						if($i==$sotrang) echo "&nbsp;<font color='red'><b>{$i}</b></font>&nbsp;";
        						else
        						{ 
        							echo "&nbsp;<a href='stat_user.php?p={$i}'>$i</a>&nbsp;";
        							
        						}if($i%30==0){
    								echo "<br/>";
    							}
            				}
                                
                            ?>
                            <div style="height: 20px;"></div>
                         </div>
                        </div>
                    </table>
                </div>
            </div>
        </div>
    </body>
</html>