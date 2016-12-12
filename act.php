<?php
	require('API/db.class.php');
	$fromDate = $_REQUEST['fromDate'];
	$toDate = $_REQUEST['toDate'];
	

	
	
	if (!isset($fromDate)) {
		$fromDate = date('Y-m-d', time());
	}
	if (!isset($toDate)) {
		$toDate = date('Y-m-d', time());
	}
	try {
		$sql = "select count(*) as log FROM user where date(last_login) >= '".$fromDate."' and date(last_login) <= '".$toDate."'";
		
		//echo $sql;
		//$row = $db->query($sql);// as $row) {
		//	echo row['log'];
		//}
		//var_dump($row[0]);
		
		//echo $row['log'];
		
		
		
		foreach ($db->query($sql) as $row) {
			//$chart_data[] = array('day' => $row['day'],
				//						   'koin' => $row['koin']);
			$numLogin = $row['log'];
		}
		
			
	
	} catch (Exception $e) {
		echo "Lỗi kết nối CSDL";
	}
?>
<!DOCTYPE html>
<html>
    <head>
        <title><?php echo $title; ?></title>
        <?php require('header.php'); ?>
        <script>
            $(document).ready(function(){
                $("#datepicker1").datepicker();
                $("#datepicker2").datepicker();
            });


			function getInactive() {
				alert($("#abc").html());
				alert($("#inActive input[name=fromDate]").html());
                var fromDate = $("#inActive input[name=fromDate]").val();
				var numLogin = $("#inActive input[name=numLogin]").val();
				
				alert(fromDate);
                
                $.ajax({
                    type: "GET",
                    url: "API/getInactive.php",
                    data: {
                        "fromDate":fromDate,
						"numLogin":numLogin
                    },
                    dataType: 'text',
                    success: function(msg) {
                        msg = msg.trim();
                        if (msg != '' && msg.length > 2) {
                            var data = jQuery.parseJSON(msg);
                            if (data.status == 1) {
                                $("#inActive").text(numuser);
                            } else {
                                $("#inActive #message").html(data.message);
                                $(this).oneTime(5000, function() {
                                    $("#inActive #message").html("");
                                });
                            }
                        } else {
                            $("#inActive #message").html("Lỗi hệ thống");
                            $(this).oneTime(5000, function() {
                                $("#inActive #message").html("");
                            });
                        }
                    },
                    failure: function() {
                        $("#findUser #message").html("Lỗi hệ thống");
                        $(this).oneTime(5000, function() {
                            $("#findUser #message").html("");
                        });
                    }
                });
            }	
        </script>

  

        
       

    </head>
    <body>
        <div class="pagewrap">
            <?php require('topMenu.php'); ?>
            <?php include('topMenu.activity.php'); ?>

            <div class="box grid">
                <div class="box_header"><a href="javascript:void(0);"><?php echo "Số người login"; ?></a></div>
                <div class="box_body">
                    <table width="100%">
                      
						<div style="padding-left:10px;">
                            <form action="" method="post">
                                Từ ngày
                                <input type="text" id="datepicker1" name="fromDate" style="text-align: center; width: 100px;" value="<?php echo $fromDate;?>"/> 
                                (00:00:00)
                                Tới ngày
                                <input type="text" id="datepicker2" name="toDate" style="text-align: center; width: 100px;" value="<?php echo $toDate;?>"/> 
                                (23:59:59)
                                <input type="submit" value="Cập nhật" class="input_button"/>
                            </form>
                        </div>
                        <div id="chart_div" style="width: 900px; height: <?php echo $chart_height; ?>px;">
						Số người login: <?php echo $numLogin;?>
						</div>

                    </table>
                </div>
            </div>
			
							
			<div class="box grid">
			
                <div class="box_header"><a href="javascript:void(0);"><?php echo "Số người CHƯA login"; ?></a></div>
                <div class="box_body">
                    
						<form id="abc">
                            <input type="text" id="datepicker3" name="fromDate" style="text-align: center; width: 100px;" value="2012-04-20"/> 
                                <input type="text" value="10" class="input_button" name="numLogin"/>
                                <input type="button" value="Cập nhật" class="input_button" onClick="getInactive();"/>
                            </form>
						
                        <div id="chart_div" style="width: 900px; height: <?php echo $chart_height; ?>px;">
						Số người login: <?php echo $numLogin;?>
						</div>

                    
                </div>
            </div>

        </div>
		
		
		
		
    </body>
</html>

