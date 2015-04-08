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
		<div id="header">Создание конфигурации</div>
		<div id="leftbar">
			<?php include("navi.php"); ?>
		</div>
		<div id="content" align='justify'>
		
<!------------------------------------------------>		

				
				<form method=post action='adding_conf.php'>
					<?php
						$conn = mysql_connect ("localhost", "root", "root");
						mysql_select_db ("ampmonitoring", $conn);
						$result = mysql_query("select ip, description from amps where ip not in (select ip from configurations) order by ip");
						
						if (mysql_num_rows($result) >0 ) {
							
							echo "<h2>Создание конфигурации</h2>";
							echo "<form action=adding_conf.php method=post name=form>";
							echo "<p class=txt>";
							echo "Описание: <input name=description type=text size=40 maxlength=255><br><br>";
							echo "DWDM: <input name=dwdm type=text size=2 maxlength=1><br><br>";
							echo "<h2>Усилители</h2>";
							
							echo "<form method=post action='adding_conf.php'>";
							while ($row = mysql_fetch_array($result)) {
								echo "<input type=checkbox name=ip[] value=$row[0]>$row[0] - $row[1] ";
								echo "<select name=direction[] size=1>
									<option value='0'>Прямое направление</option>
									<option value='1'>Обратное направление</option>
									</select>
									<br>
								";
							}
							echo "<input name=submit type=submit value=Добавить>";
							echo "</form>";
							echo "</p>";
						}
						else echo "<h2>Создание конфигурации невозможно!<br>Остутствуют свободные усилители.</h2>";
						
						mysql_close($conn);
					?>
				<br>



<!------------------------------------------------>

		</div>
		<div id="footer">&copy; АЛСиТЕК</div>
	</div> 
</body>
</html>
