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
		<div id="header">Редактирование конфигурации</div>
		<div id="leftbar">
			<?php include("navi.php"); ?>
		</div>
		<div id="content" align='justify'>
		
<!------------------------------------------------>		
			
			<?php 

				if (isset ($_POST['description'])) $description=$_POST['description'];
				if (isset ($_POST['dwdm'])) $dwdm=$_POST['dwdm'];				
				
				// Редактирование свойств
				
				echo "<h2>Редактирование конфигурации</h2>";
				echo "<form method=post action=editing_conf.php>";
				echo "Description: <input type=text name=new_description value='$description'><br>";
				echo "DWDM: <input type=text name=new_dwdm value='$dwdm'><br>";
				echo "<input type=hidden name=description value='$description'>";
				echo "<input type=hidden name=dwdm value='$dwdm'>";
				$conn = mysql_connect ("localhost", "root", "root");
				mysql_select_db ("ampmonitoring", $conn);
				$result = mysql_query("select ip, direction, number from configurations where description='$description' and dwdm='$dwdm' order by direction, number");
										
				while ($row = mysql_fetch_array($result)) {
					echo "$row[0] ";
					echo "<select name=new_direction size=1>
							<option value=".$row[1].">".$row[1]."</option>
							<option value=".abs($row[1]-1).">".abs($row[1]-1)."</option>
							</select> ";
					echo "<input type=text size=1 name=new_number value=".$row[2].">
					<br>";
				}
				
				
				echo "<input type=submit name=action value=Edit>";
				echo "</form><br>";
				
				// Удаление усилителей из конфигурации
				
				echo "<br><br><h2>Удалить из конфигурации</h2>";
			//	$conn = mysql_connect ("localhost", "root", "root");
			//	mysql_select_db ("ampmonitoring", $conn);
				$result = mysql_query("select ip from configurations where description='$description' and dwdm='$dwdm' order by number");
				
				echo "<form method=post action=editing_conf.php>";
						
				while ($row = mysql_fetch_array($result)) {
					echo "<input type=checkbox name=ip[] value=$row[0]>$row[0]<br>";
				}
				echo "<input type=hidden name=description value='$description'>";
				echo "<input type=hidden name=dwdm value='$dwdm'>";
				echo "<input type=submit name=action value=Delete>";
				echo "</form><br>";
				

				// Добавление усилителей в конфигурацию
				
				echo "<br><br><h2>Добавить в конфигурацию</h2>";
				mysql_free_result($result); $row=null;
				$result = mysql_query("select ip, description from amps where ip not in (select ip from configurations)");
				
				// если есть свободные усилители
				if (mysql_num_rows($result)>0) {
					echo "<form method=post action=editing_conf.php>";
							
					while ($row = mysql_fetch_array($result)) {
						echo "<input type=checkbox name=ip[] value=$row[0]>$row[0]<br>";
					}
					echo "<input type=hidden name=description value='$description'>";
					echo "<input type=hidden name=dwdm value='$dwdm'>";
					echo "<input type=submit name=action value=Add>";
					echo "</form><br>";
			} else echo "Нет свободных усилителй<br><br>";
				
				mysql_close($conn);
				
				//
				
				
				echo "<br><br>";
				echo "<form method=post action=editing_conf.php>";
				echo "<input type=hidden name=description value='$description'>";
				echo "<input type=hidden name=dwdm value='$dwdm'>";
				echo "<input type=submit name=action value='Delete configuration'>";
				echo "</form><br>"
			?>
<!------------------------------------------------>

		</div>
		<div id="footer">&copy; АЛСиТЕК</div>
	</div> 
</body>
</html>
