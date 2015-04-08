<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" 
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html" charset="utf-8" />
		<meta http-equiv="Refresh" content="0;url=view_amp.php">
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
			if (isset ($_POST['description'])) $description=$_POST['description'];
			if (isset ($_POST['ip'])) $ip=$_POST['ip'];
			if (isset ($_POST['model'])) $model=$_POST['model'];

			$conn = mysql_connect ("localhost", "root", "root");
			mysql_select_db ("ampmonitoring", $conn);

			$result = mysql_query ("INSERT INTO amps (description, ip, model, edit_date) VALUES ( '$description', '$ip', '$model', CURRENT_TIMESTAMP)"); 

			echo "Добавление...";
			mysql_close($conn);

		?>
		
<!------------------------------------------------>

		</div>
		<div id="footer">&copy; АЛСиТЕК</div>
	</div> 
</body>
</html>

