<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" 
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html" charset="utf-8" />
		
		<title>Мониторинг усилителей</title>
		<link href="style.css" type="text/css" rel="stylesheet" />
	</head>
<body>
	<div id="container">
		<div id="header">Мониторинг усилителей</div>
		<div id="leftbar">
			<?php include("navi.php"); ?>
		</div>
		<div id="content" align='justify'>
		
<!------------------------------------------------>		

		<?php 
			if (isset ($_POST['ip'])) $ip=$_POST['ip'];
			if (isset ($_POST['mode'])) $mode=$_POST['mode'];
			if (isset ($_POST['gainValue'])) $gainValue=$_POST['gainValue'];
			if (isset ($_POST['description'])) $description=$_POST['description'];
			if (isset ($_POST['amp_description'])) $amp_description=$_POST['amp_description'];
			if (isset ($_POST['amp_number'])) $amp_number=$_POST['amp_number'];
			if (isset ($_POST['dwdm'])) $dwdm=$_POST['dwdm'];
			$prev_page = $_SERVER['HTTP_REFERER'];
			
			echo "<form id='prev_page' action='$prev_page' method=post>";
			echo "<input type=hidden name=description value=$description>";
			echo "<input type=hidden name=dwdm value=$dwdm>";
			echo "<input type=submit value='No time to wait'>";
			echo "</form>";
			
			if ($_POST['action'] == 'Apply') {
							

				echo "Wait 5 sec...<br>Applying SNMP parameters...<br><br>";
				if ($mode=="Gain")
					$result = snmpset($ip, "public", ".1.3.6.1.4.1.17409.1.11.80.0", "i", $gainValue*10);
				else
					$result = snmpset($ip, "public", ".1.3.6.1.4.1.17409.1.11.11.0", "i", $gainValue*10);
				if ($result !=1) echo "SNMPSet fail<br>";
				
				$conn = mysql_connect ("localhost", "root", "root");
				mysql_select_db ("ampmonitoring", $conn);
				$result = mysql_query("update amps set description='$amp_description' where ip='$ip'");
				$result = mysql_query("update configurations set number='$amp_number' where ip='$ip'");
				mysql_close($conn);
								
				// редирект на предыдущую страницу
				echo "
						<script type=text/javascript>
							setTimeout('document.getElementById(\'prev_page\').submit()', 5000)
						</script>
				";
				
			
			}
			
			if ($_POST['action'] == 'Delete') {
				$conn = mysql_connect ("localhost", "root", "root");
				mysql_select_db ("ampmonitoring", $conn);
				$result = mysql_query("Delete from amps where ip = '$ip'");
				$result = mysql_query("Delete from configurations where ip = '$ip'");
				mysql_close($conn);
				echo "Wait 1 sec<br>Deleting $ip... <br>";
				echo "
						<script type=text/javascript>
							setTimeout('document.getElementById(\'prev_page\').submit()', 1000)
						</script>
				";
			}
			
			if ($_POST['del_from_conf'] == 'Delete') {
				$conn = mysql_connect ("localhost", "root", "root");
				mysql_select_db ("ampmonitoring", $conn);
				$result = mysql_query("Delete from configurations where ip = '$ip' and description='$description' and dwdm='$dwdm'");
				mysql_close($conn);
				echo "Wait 1 sec<br>Deleting $ip from conf $description... ";
				echo "
						<script type=text/javascript>
							setTimeout('document.getElementById(\'prev_page\').submit()', 1000)
						</script>
				";
			}
		?>

<!------------------------------------------------>

		</div>
		<div id="footer">&copy; АЛСиТЕК</div>
	</div> 
</body>
</html>
