<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" 
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html" charset="utf-8" />
		<title>Мониторинг усилителей</title>
		<link href="style.css" type="text/css" rel="stylesheet" />
		<meta http-equiv="Refresh" content="2;url=view_conf_list.php">
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
			if (isset ($_POST['dwdm'])) $dwdm=$_POST['dwdm'];
			if (isset ($_POST['description'])) $description=$_POST['description'];
			if (isset ($_POST['direction'])) $direction=$_POST['direction'];
			//echo count($ip);

			//echo $ip[1];
			if (count($ip)>0) {
				
				$conn = mysql_connect ("localhost", "root", "root");
				mysql_select_db ("ampmonitoring", $conn);

				for ($i=0; $i<count($ip); $i++) {
					$result = mysql_query ("INSERT INTO configurations (description, dwdm, direction, ip, number, clock) 
						VALUES ( '$description', '$dwdm', '$direction[$i]', '$ip[$i]', 0, CURRENT_TIMESTAMP())"); 
				}
				
				echo "Добавление...";
				mysql_close($conn);
			}


			?>


<!------------------------------------------------>

		</div>
		<div id="footer">&copy; АЛСиТЕК</div>
	</div> 
</body>
</html>
