<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" 
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html" charset="utf-8" />
	
		<title>Мониторинг усилителей</title>
		<META HTTP-EQUIV="REFRESH" CONTENT="2; URL=view_conf_list.php">
		<link href="style.css" type="text/css" rel="stylesheet" />
	</head>
<body>
	<div id="container">
		<div id="header">Редактирование конфигурации</div>
		<div id="leftbar">
			<?php include("navi.php"); ?>
		</div>
		<div id="content" align='justify'>
		
<!------------------------------------------------>		

		<?php
		if (isset ($_POST['ip'])) $ip=$_POST['ip'];
		if (isset ($_POST['ip_del'])) $ip_del=$_POST['ip_del'];
		if (isset ($_POST['ip_add'])) $ip_add=$_POST['ip_add'];
		if (isset ($_POST['description'])) $description=$_POST['description'];
		if (isset ($_POST['dwdm'])) $dwdm=$_POST['dwdm'];
		if (isset ($_POST['new_description'])) $new_description=$_POST['new_description'];
		if (isset ($_POST['new_dwdm'])) $new_dwdm=$_POST['new_dwdm'];
		if (isset ($_POST['new_direction'])) $new_direction=$_POST['new_direction'];
		if (isset ($_POST['new_number'])) $new_number=$_POST['new_number'];
		if (isset ($_POST['direction_add'])) $direction_add=$_POST['direction_add'];
		if (isset ($_POST['number_add'])) $number_add=$_POST['number_add'];
		
		$conn = mysql_connect ("localhost", "root", "root");
		mysql_select_db ("ampmonitoring", $conn);
		
	//редактирование описания
		if ($description != $new_description) {
			$result = mysql_query("update configurations set description='$new_description' where description='$description'");
		}
	
	//редактирование dwdm
		if ($dwdm != $new_dwdm) {
			$result = mysql_query("update configurations set dwdm='$new_dwdm' where description='$new_description' and dwdm='$dwdm'");
		}
	
	//редактирование направления и порядкового номера
		for ($i=0; $i<count($ip); $i++) {
			$result = mysql_query("update configurations set direction='$new_direction[$i]', number ='$new_number[$i]' where ip='$ip[$i]'");
		}
		
	//удаление усилителя из конфигурации
		for ($i=0; $i<count($ip_del); $i++) {
			$result = mysql_query("delete from configurations where ip='$ip_del[$i]'");
		}
		
	//добавление усилителя в конфигурацию
		for ($i=0; $i<count($ip_add); $i++) {
			$result = mysql_query("insert into configurations (ip, description, dwdm, direction, number, clock) values ('$ip_add[$i]', '$new_description', '$new_dwdm', '$direction_add[$i]', '$number_add[$i]', CURRENT_TIMESTAMP  )");
		}
		
		mysql_close($conn);
		?>


<!------------------------------------------------>

		</div>
		<div id="footer">&copy; АЛСиТЕК</div>
	</div> 
</body>
</html>
