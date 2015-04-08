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
		<div id="header">Список конфигураций</div>
		<div id="leftbar">
			<?php include("navi.php"); ?>
		</div>
		<div id="content" align='justify'>
		
<!------------------------------------------------>		
			
			<?php
				$conn = mysql_connect ("localhost", "root", "root");
				mysql_select_db ("ampmonitoring", $conn);
				$result = mysql_query("select description, dwdm, clock from configurations group by description order by description");
				echo "<table border=1 cellpadding=3>
				<tr><td>Description</td><td>DWDM</td><td>IP list</td><td>Date</td></tr>";
				
				while ($row=mysql_fetch_array($result)) {
					$description=$row[0];
					$dwdm=$row[1];
					$clock=$row[2];
					
					echo "<tr>";
					echo "<td>$description</td>";
					echo "<td>$dwdm</td>";
					///ip
					echo "<td>";
						$ipresult = mysql_query("select ip from configurations where description ='$description'");
						while ($iprow=mysql_fetch_array($ipresult)) {
							echo $iprow[0]."<br>";
						}

					echo "</td>";	
					///
					echo "<td>$clock</td>";
					echo "<td><form method=post action=view_conf.php>
							<input type=submit value=Details>";
					echo "<input type=hidden name=description value=$description>";
					echo "<input type=hidden name=dwdm value=$dwdm>";
					echo "</form></td>";
					
					echo "<td><form method=post action=edit_conf.php>
							<input type=submit value=Edit>";
					echo "<input type=hidden name=description value=$description>";
					echo "<input type=hidden name=dwdm value=$dwdm>";
					echo "</form></td>";					
					echo "</tr>";
					
				}
				
				
				
				echo "</table>";
				
				
				
				mysql_free_result($result);		
				mysql_close($conn);
			
			?>
			


<!------------------------------------------------>

		</div>
		<div id="footer">&copy; АЛСиТЕК</div>
	</div> 
</body>
</html>
