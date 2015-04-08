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
			<h2>Все имеющиеся усилители</h2><br>
			<?php
				$timeout = 10000;
				$conn = mysql_connect ("localhost", "root", "root");
				mysql_select_db ("ampmonitoring", $conn);
				$resultip = mysql_query("select distinct ip, description from amps order by ip");
				echo "<table border=1 cellpadding=3>
				<tr><td>IP</td><td>Descr</td><td>Input 1, dBm</td><td>Output 1, dBm</td><td>Input 2, dBm</td><td>Output 2, dBm</td>
						<td>Mode</td><td>GainValue, dB</td><td>Power 1, V</td><td>Power 2, V</td><td>Temp, C</td></tr>";
				
				while ($row = mysql_fetch_array($resultip)) {
						
						echo "<tr>";
						echo "<form method=post action=edit_amp.php>";
					//ip
						$ip = $row[0];
						echo "<td>$ip</td>";
					//descr
						$discr=$row[1];
						echo "<td>$discr</td>";
					//input 1
						$input1 = snmpget($ip, "public", ".1.3.6.1.4.1.17409.1.11.3.0", $timeout);
						$input1 = str_replace("INTEGER: ", "", $input1);
						$input1 = $input1/10;
						echo "<td>$input1</td>";
					//output 1
						$output1 = snmpget($ip, "public", ".1.3.6.1.4.1.17409.1.11.9.0", $timeout);
						$output1 = str_replace("INTEGER: ", "", $output1);
						$output1 = $output1/10;
						echo "<td>$output1</td>";
					//input 2	
						$input2 = snmpget($ip, "public", ".1.3.6.1.4.1.17409.1.11.10.0", $timeout);
						$input2 = str_replace("INTEGER: ", "", $input2);
						$input2 = $input2/10;
						echo "<td>$input2</td>";
					//output 2	
						$output2 = snmpget($ip, "public", ".1.3.6.1.4.1.17409.1.11.2.0", $timeout);
						$output2 = str_replace("INTEGER: ", "", $output2);
						$output2 = $output2/10;
						echo "<td>$output2</td>";
					//mode	
						$mode = snmpget($ip, "public", ".1.3.6.1.4.1.17409.1.11.82.0", $timeout);
						$mode = str_replace("INTEGER: ", "", $mode);
						if ($mode == 1) { 
							$mode = "Gain";
							$nonmode = "Power";
						} else {
							$mode = "Power";
							$nonmode = "Gain";
						}
						echo "
						<td><select name='mode' size=1>
								<option value='$mode'>$mode</option>
								<option value='$nonmode'>$nonmode</option>
						</select></td>
						";
					//gainValue/outputValue
						if ($mode == "Gain") $gainValue = snmpget($ip, "public", ".1.3.6.1.4.1.17409.1.11.80.0", $timeout);
						else $gainValue = snmpget($ip, "public", ".1.3.6.1.4.1.17409.1.11.11.0", $timeout);
						$gainValue = str_replace("INTEGER: ", "", $gainValue);
						$gainValue = $gainValue/10;
						echo "<td><input type='text' size=4 name='gainValue' value='$gainValue'></td>";
					//power 1
						$power1 = snmpget($ip, "public", ".1.3.6.1.4.1.17409.1.11.7.1.2.1", $timeout);
						$power1 = str_replace("INTEGER: ", "", $power1);
						$power1 = $power1/10;
						echo "<td>$power1</td>";
					//power 2
						$power2 = snmpget($ip, "public", ".1.3.6.1.4.1.17409.1.11.7.1.2.2", $timeout);
						$power2 = str_replace("INTEGER: ", "", $power2);
						$power2 = $power2/10;
						echo "<td>$power2</td>";
					//Tempetarure
						$temperature = snmpget($ip, "public", ".1.3.6.1.4.1.17409.1.3.1.13.0", $timeout);
						$temperature = str_replace("INTEGER: ", "", $temperature);
						$temperature = $temperature;
						echo "<td>$temperature</td>";
					
						
						echo "<td>
								
								<input type=hidden name=ip value=$ip>

								<input type=submit name=action value=Apply>
								
							</td>";
							
						echo "<td><input type=reset value=Reset></td>";
						echo "<td><input type=submit name=action value=Delete></td>";
					
					echo "</form>";
					echo "</tr>";
				};
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
