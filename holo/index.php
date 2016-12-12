<?php 
//unset($_SERVER['PHP_AUTH_USER']);
if (!isset($_SERVER['PHP_AUTH_USER'])) {
    header('WWW-Authenticate: Basic realm="My Realm"');
    header('HTTP/1.0 401 Unauthorized');
    echo 'Access denied';
    exit;
} else {
   $user = $_SERVER['PHP_AUTH_USER'];
   $pass = $_SERVER['PHP_AUTH_PW'];
   if($user != 'holo' && $pass != 'holo!@#')
   		die('Sai user, pass');
}
session_start();
	require('api/db.class.php');
	$sql = "select c.* from config c where c.key != 'sms_vms' and c.key != 'version_vms' order by c.key asc";
	$arrCP = array();
	$arrParentCP = array();
	try {
		foreach ($db->query($sql) as $row) {
			if (startsWith($row['key'], "cp_") or startsWith($row['key'], "common") or startsWith($row['key'],"sms") or startsWith($row['key'],"version")) {
				if (startsWith($row['key'],"cp_")) {
					$arrParentCP[$row['key']]['sms'] = json_decode($row['value'])->{'sms'};
					$arrParentCP[$row['key']]['version_j2me'] = json_decode($row['value'])->{'version'}->{'j2me'};
					$arrParentCP[$row['key']]['version_android'] = json_decode($row['value'])->{'version'}->{'android'};
					$arrParentCP[$row['key']]['version_iphone'] = json_decode($row['value'])->{'version'}->{'iphone'};
				} else if ($row['key'] == "common_cp") {
					$commonCP = json_decode($row['value']);
				} else if ($row['key'] == "common_sms") {
					$commonSMS = json_decode($row['value']);
				} else if ($row['key'] == "common_version") {
					$commonVersion = json_decode($row['value'])->{'j2me'};
				} else if (startsWith($row['key'],"sms")) {
					$arrCP[substr($row['key'], 4)]["sms"] = json_decode($row['value']);
				} else if (startsWith($row['key'],"version")) {
					$arrCP[substr($row['key'], 8)]["version_j2me"] = json_decode($row['value'])->{'j2me'};
					$arrCP[substr($row['key'], 8)]["version_android"] = json_decode($row['value'])->{'android'};
					$arrCP[substr($row['key'], 8)]["version_iphone"] = json_decode($row['value'])->{'iphone'};
				}
			}
		}
	} catch (Exception $e) {
		echo $e->getMessage();
	}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<title>Beme Config</title>
		<link rel="stylesheet" type="text/css" href="css/jquery.ui.theme.css" />
        <link rel="stylesheet" type="text/css" href="css/jquery.ui.datetime.css" />
		<script type="text/javascript" src="js/jquery-1.6.2.js"></script>
        <script type="text/javascript" src="js/jquery-ui.min.js"></script>
        <script type="text/javascript" src="js/jquery.ui.datetime.min.js"></script>
        <script type="text/javascript" src="js/jquery.timers-1.2.js"></script>
        <script type="text/javascript" src="js/jquery.easing.js"></script>
        <script type="text/javascript" src="js/jquery.collapse.js"></script>
        <script type="text/javascript" src="js/jquery.ui.core.js"></script>
		<meta content="width = device-width, height = device-height, user-scalable = no;" name="viewport">
		<meta name="HandheldFriendly" content="true" >
		<style>
			body{font-family: Tahoma,Verdana,Arial; font-size: 12px; margin:0; padding:0;}
			a {text-decoration:none;}
			ul#collapser { margin: 0; padding: 0; }
			ul#collapser li { margin: 10px 0 10px 0px; padding: 0; list-style: none; }
			ul#collapser li.dateTotal {padding: 0;}
			ul#collapser li.dateTotal>ul {margin-left: 25px; padding: 0;}
			ul#collapser li.parent {border: 1px solid #DDDDDD; background: none repeat scroll 0 0 #EEEEEE;margin: 3px; padding: 0.4em;}
			ul#collapser li.ispaid>a {color: #5897DB !important;}
			ul#collapser li.child {border: 1px solid #DDDDDD; background: none repeat scroll 0 0 #FFF;margin: 3px; padding: 0.4em;}
			.jqcNode { font-weight: bold; color: green;display:block;}
		</style>
		<script type="text/javascript">
			$().ready(function() {
				$('#collapser').jqcollapse({
					slide: true,
					speed: 1000,
					easing: 'easeOutCubic'
				});
				$("#serverEvent ul").show();
			});
			
			function reload() {
			
				$.ajax({
                    type: "POST",
                    url: "api/reloadConfig.php",
                    data: {
                    },
                    dataType: 'text',
                    success: function(msg) {
                        msg = msg.trim();
                        if (msg != '' && msg.length > 2) {
                            var data = jQuery.parseJSON(msg);
                            if (data.status == 1) {
                                $("#message").html("Cập nhật config thành công");
                                $(this).oneTime(5000, function() {
                                    $("#message").html("");
                                });
                            } else {
                                $("#message").html(data.message);
                                $(this).oneTime(5000, function() {
                                    $("#message").html("Không biết lỗi gì");
                                });
                            }
                        } else {
                            $("#message").html("Lỗi hệ thống");
                            $(this).oneTime(5000, function() {
                                $("#message").html("");
                            });
                        }
                    },
                    failure: function() {
                        $("#message").html("Lỗi hệ thống");
                        $(this).oneTime(5000, function() {
                            $("#message").html("");
                        });
                    }
                });
			}
		</script>
	</head>
	<body>
		<div class="menu" style="background-color:#307BE5; padding:5px; font-size:13px; font-weight:bold;">
			<span><a href="cp.php" style="color:#333;">Quản lý CP</a></span>
		</div>
		<div style="margin-top:10px;">
			<div style="margin:3px; padding:0.4em;">
				<a href="addCP.php"><b>Add CP</b></a> | <a href="javascript:void(0)" onclick="reload();"><b>Reload Config</b></a><span id="message" style="color:#CC0000;font-weight:bold;margin-left:100px;"></span>
			</div>
			<ul id="collapser">
			<!--
				<li class='parent'>
					Common CP
					<ul>
						<?php
							echo "<li class='child'>";
							$output = "";
							foreach ($commonCP->{"cp"} as $cp) {
								$output = $output.",".$cp." ";
							}
							echo substr($output, 1);
							echo "</li>";
							echo "<li class='child'>";
							echo "<b>BEM_DK</b>: ".$commonSMS->{"BEM_DK"}->{"ServiceCode"}." -> ".$commonSMS->{"BEM_DK"}->{"ServiceNumber"}."<br/>";
							echo "<b>BEM_PWD</b>: ".$commonSMS->{"BEM_PWD"}->{"ServiceCode"}." -> ".$commonSMS->{"BEM_PWD"}->{"ServiceNumber"}."<br/>";
							echo "<b>BEM_TANG</b>: ".$commonSMS->{"BEM_TANG"}->{"ServiceCode"}." -> ".$commonSMS->{"BEM_TANG"}->{"ServiceNumber"}."<br/>";
							echo "<b>BEM_KOIN</b>: ".$commonSMS->{"BEM_KOIN"}->{"ServiceCode"}." -> ".$commonSMS->{"BEM_KOIN"}->{"ServiceNumber"}." (".$commonSMS->{"BEM_KOIN"}->{"koin"}." koin)<br/>";
							echo "<b>BEM_NAP</b>: ".$commonSMS->{"BEM_NAP"}->{"ServiceCode"}." -> ";
							echo $commonSMS->{"BEM_NAP"}->{"ServiceNumber"}[0]->{"sn"}."(".$commonSMS->{"BEM_NAP"}->{"ServiceNumber"}[0]->{"koin"}." koin), ";
							echo $commonSMS->{"BEM_NAP"}->{"ServiceNumber"}[1]->{"sn"}."(".$commonSMS->{"BEM_NAP"}->{"ServiceNumber"}[1]->{"koin"}." koin), ";
							//echo $commonSMS->{"BEM_NAP"}->{"ServiceNumber"}[2]->{"sn"}."(".$commonSMS->{"BEM_NAP"}->{"ServiceNumber"}[2]->{"koin"}." koin)";
							echo "</li>";
							echo "<li class='child'>";
							echo "<b>version</b>: ".$commonVersion->{"version"}.", <b>version_force</b>: ".$commonVersion->{"version"}."<br/>";
							echo "<b>message_update</b>: ".$commonVersion->{"message_update"}."<br/>";
							echo "<b>message_force</b>: ".$commonVersion->{"message_force"}."<br/>";
							echo "<b>wap</b>: ".$commonVersion->{"wap"};
							echo "</li>";
							echo "<li style='margin:3px; padding:0.4em;'><a href='editCommonCP.php'><b>Edit Common CP</b></a></li>";
						?>
					</ul>
				</li>
				-->
				<?php
					foreach($arrParentCP as $key => $value) {	
						$sms = $value['sms'];
						$version = $value['version_j2me'];
						$version_android = $value['version_android'];
						$version_iphone = $value['version_iphone'];
						echo "<li class='parent'>".$key."<ul>";
						echo "<li class='child'>";
						echo "<b>BEM_DK</b>: ".$sms->{"BEM_DK"}->{"ServiceCode"}." -> ".$sms->{"BEM_DK"}->{"ServiceNumber"}."<br/>";
						echo "<b>BEM_PWD</b>: ".$sms->{"BEM_PWD"}->{"ServiceCode"}." -> ".$sms->{"BEM_PWD"}->{"ServiceNumber"}."<br/>";
						echo "<b>BEM_TANG</b>: ".$sms->{"BEM_TANG"}->{"ServiceCode"}." -> ".$sms->{"BEM_TANG"}->{"ServiceNumber"}."<br/>";
						echo "<b>BEM_KOIN</b>: ".$sms->{"BEM_KOIN"}->{"ServiceCode"}." -> ".$sms->{"BEM_KOIN"}->{"ServiceNumber"}." (".$sms->{"BEM_KOIN"}->{"koin"}." koin)<br/>";
						echo "<b>BEM_NAP</b>: ".$sms->{"BEM_NAP"}->{"ServiceCode"}." -> ";
						foreach ($sms->{"BEM_NAP"}->{"ServiceNumber"} as $child) {
							echo $child->{"sn"}."(".$child->{"koin"}." koin) ";
						}
						echo "</li>";
						echo "<li class='child'>";
						echo "<b>J2ME</b><br/>";
						echo "<b>version</b>: ".$version->{"version"}.", <b>version_force</b>: ".$version->{"version_force"}."<br/>";
						echo "<b>message_update</b>: ".$version->{"message_update"}."<br/>";
						echo "<b>message_force</b>: ".$version->{"message_force"}."<br/>";
						echo "<b>wap</b>: ".$version->{"wap"};
						echo "</li>";
						echo "<li class='child'>";
						echo "<b>Android</b><br/>";
						echo "<b>version</b>: ".$version_android->{"version"}.", <b>version_force</b>: ".$version_android->{"version_force"}."<br/>";
						echo "<b>message_update</b>: ".$version_android->{"message_update"}."<br/>";
						echo "<b>message_force</b>: ".$version_android->{"message_force"}."<br/>";
						echo "<b>wap</b>: ".$version_android->{"wap"};
						echo "</li>";
						echo "<li class='child'>";
						echo "<b>Iphone</b><br/>";
						echo "<b>version</b>: ".$version_iphone->{"version"}.", <b>version_force</b>: ".$version_iphone->{"version_force"}."<br/>";
						echo "<b>message_update</b>: ".$version_iphone->{"message_update"}."<br/>";
						echo "<b>message_force</b>: ".$version_iphone->{"message_force"}."<br/>";
						echo "<b>wap</b>: ".$version_iphone->{"wap"};
						echo "</li>";
						echo "<li style='margin:3px; padding:0.4em;'><a href='editParentCP.php?id=".$key."'><b>Edit ".$key."</b></a></li>";
						echo "</ul></li>";
					}
				?>
				<?php
					foreach($arrCP as $key => $value) {	
						$sms = $value['sms'];
						$version = $value['version_j2me'];
						$version_android = $value['version_android'];
						$version_iphone = $value['version_iphone'];
						echo "<li class='parent'>".$key."<ul>";
						echo "<li class='child'>";
						echo "<b>BEM_DK</b>: ".$sms->{"BEM_DK"}->{"ServiceCode"}." -> ".$sms->{"BEM_DK"}->{"ServiceNumber"}."<br/>";
						echo "<b>BEM_PWD</b>: ".$sms->{"BEM_PWD"}->{"ServiceCode"}." -> ".$sms->{"BEM_PWD"}->{"ServiceNumber"}."<br/>";
						echo "<b>BEM_TANG</b>: ".$sms->{"BEM_TANG"}->{"ServiceCode"}." -> ".$sms->{"BEM_TANG"}->{"ServiceNumber"}."<br/>";
						echo "<b>BEM_KOIN</b>: ".$sms->{"BEM_KOIN"}->{"ServiceCode"}." -> ".$sms->{"BEM_KOIN"}->{"ServiceNumber"}." (".$sms->{"BEM_KOIN"}->{"koin"}." koin)<br/>";
						echo "<b>BEM_NAP</b>: ".$sms->{"BEM_NAP"}->{"ServiceCode"}." -> ";
						foreach ($sms->{"BEM_NAP"}->{"ServiceNumber"} as $child) {
							echo $child->{"sn"}."(".$child->{"koin"}." koin) ";
						}
						echo "</li>";
						echo "<li class='child'>";
						echo "<b>J2ME</b><br/>";
						echo "<b>version</b>: ".$version->{"version"}.", <b>version_force</b>: ".$version->{"version_force"}."<br/>";
						echo "<b>message_update</b>: ".$version->{"message_update"}."<br/>";
						echo "<b>message_force</b>: ".$version->{"message_force"}."<br/>";
						echo "<b>wap</b>: ".$version->{"wap"};
						echo "</li>";
						echo "<li class='child'>";
						echo "<b>Android</b><br/>";
						echo "<b>version</b>: ".$version_android->{"version"}.", <b>version_force</b>: ".$version_android->{"version_force"}."<br/>";
						echo "<b>message_update</b>: ".$version_android->{"message_update"}."<br/>";
						echo "<b>message_force</b>: ".$version_android->{"message_force"}."<br/>";
						echo "<b>wap</b>: ".$version_android->{"wap"};
						echo "</li>";
						echo "<li class='child'>";
						echo "<b>Iphone</b><br/>";
						echo "<b>version</b>: ".$version_iphone->{"version"}.", <b>version_force</b>: ".$version_iphone->{"version_force"}."<br/>";
						echo "<b>message_update</b>: ".$version_iphone->{"message_update"}."<br/>";
						echo "<b>message_force</b>: ".$version_iphone->{"message_force"}."<br/>";
						echo "<b>wap</b>: ".$version_iphone->{"wap"};
						echo "</li>";
						echo "<li style='margin:3px; padding:0.4em;'><a href='editCP.php?id=".$key."'><b>Edit ".$key."</b></a></li>";
						echo "</ul></li>";
					}
				?>
			</ul>
		</div>
    </body>
</html>