<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" 
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html" charset="utf-8" />
		<META HTTP-EQUIV="REFRESH" CONTENT="2; URL=view_conf_list.php">
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
		if (isset ($_POST['ip_del'])) $ip_del=$_POST['ip_del'];
		if (isset ($_POST['ip_add'])) $ip_add=$_POST['ip_add'];
		if (isset ($_POST['description'])) $description=$_POST['description'];
		if (isset ($_POST['dwdm'])) $dwdm=$_POST['dwdm'];
		if (isset ($_POST['new_description'])) $new_description=$_POST['new_description'];
		if (isset ($_POST['new_dwdm'])) $new_dwdm=$_POST['new_dwdm'];
		if (isset ($_POST['new_direction'])) $new_direction=$_POST['new_direction'];
		if (isset ($_POST['new_number'])) $new_number=$_POST['new_number'];
		
		// редактирование свойств
		
		if ($_POST['action'] == 'Edit') {
			echo "Applying parameters... Wait 5 sec<br><br>";
			echo "$description - $new_description<br>$dwdm - $new_dwdm";
			$conn = mysql_connect ("localhost", "root", "root");
			mysql_select_db ("ampmonitoring", $conn);
			$result = mysql_query("update configurations set dwdm='$new_dwdm', description='$new_description'
						where dwdm='$dwdm' and description='$description'");
			mysql_close($conn);
		}
		
		// удаление усилителей из конфигурации
		
		if ($_POST['action'] == 'Delete') {
			echo "Applying parameters... Wait 5 sec<br><br>";
			$conn = mysql_connect ("localhost", "root", "root");
			mysql_select_db ("ampmonitoring", $conn);			
			for ($i=0; $i<count($ip); $i++) {
				$result=mysql_query("delete from configurations where ip='$ip[$i]' and description='$description' and dwdm='$dwdm'");
			}
		
			mysql_close($conn);

		}
		
		// добавление усилителей в конфигурацию
		
		if ($_POST['action'] == 'Add') {
			echo "Applying parameters... Wait 5 sec<br><br>";
			$conn = mysql_connect ("localhost", "root", "root");
			mysql_select_db ("ampmonitoring", $conn);			
			for ($i=0; $i<count($ip); $i++) {
				$result=mysql_query("insert into configurations (ip, description, dwdm) values ('$ip[$i]', '$description', '$dwdm')");
			}
		
			mysql_close($conn);

		}
		
	// Удалить конфигурацию целиком
		
		if ($_POST['action'] == 'Delete configuration') {
			echo "Applying parameters... Wait 5 sec<br><br>";
			$conn = mysql_connect ("localhost", "root", "root");
			mysql_select_db ("ampmonitoring", $conn);			
			$result=mysql_query("delete from configurations where description='$description' and dwdm='$dwdm'");
			mysql_close($conn);

		}
		
		
		?>

<!------------------------------------------------>

		</div>
		<div id="footer">&copy; АЛСиТЕК</div>
	</div> 
</body>
</html>
