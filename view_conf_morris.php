<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" 
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html" charset="utf-8" />
		<title>Мониторинг усилителей</title>
		<link href="style.css" type="text/css" rel="stylesheet" />
		<link href="morris.js-0.5.1/morris.css" type="text/css" rel="stylesheet" />
		<script src="morris.js-0.5.1/jquery-1.10.2.js"></script>
		<script src="morris.js-0.5.1/raphael.js"></script>
		<script src="morris.js-0.5.1/morris.js"></script>
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
			
				$arr = array();
				if (isset ($_POST['dwdm'])) $dwdm=$_POST['dwdm'];
				if (isset ($_POST['description'])) $description=$_POST['description'];
				$timeout = 10000;
				echo "<h2>$description<br>DWDM $dwdm<br></h2>";
				$conn = mysql_connect ("localhost", "root", "root");
				mysql_select_db ("ampmonitoring", $conn);
				//$resultip = mysql_query("select ip from configurations where description='$description' and dwdm='$dwdm' order by number");
				$resultip = mysql_query("select configurations.ip, configurations.number, amps.description from configurations, amps where configurations.description='$description' and configurations.dwdm='$dwdm' and configurations.ip=amps.ip order by number");
				echo "<table border=1 cellpadding=3>
				<tr><td>IP</td><td>Descr</td><td>№</td><td>Input 1, dBm</td><td>Output 1, dBm</td><td>Input 2, dBm</td><td>Output 2, dBm</td>
						<td>Mode</td><td>GainValue, dB</td><td>Power 1, V</td><td>Power 2, V</td><td>Temp, C</td></tr>";
				
				while ($row = mysql_fetch_array($resultip)) {
						
						echo "<tr>";
						echo "<form method='post' action='edit_amp.php'>";
						
					
					//ip
						$ip = $row[0];
					// тут запрашиваем ip по snmp, если возвращается пустая строка, значит связи нет -> окрашиваем в красный 
						if (snmpget($ip, "public", ".1.3.6.1.4.1.17409.1.3.1.9.0", $timeout) == "")
							echo "<td bgcolor=dd000>$ip</td>";
						else echo "<td>$ip</td>";
					//descr
						$descr=$row[2];
						echo "<td><input type=text size=10 name=amp_description value=$descr></td>";
					//number
						$number=$row[1];
						echo "<td><input type=text size=1 name=amp_number value=$number></td>";	
					//input 1
						$input1 = snmpget($ip, "public", ".1.3.6.1.4.1.17409.1.11.3.0", $timeout);
						$input1 = str_replace("INTEGER: ", "", $input1);
						$input1 = $input1/10;
						echo "<td>$input1</td>";
						$arr[] = $input1;
					//output 1
						$output1 = snmpget($ip, "public", ".1.3.6.1.4.1.17409.1.11.9.0", $timeout);
						$output1 = str_replace("INTEGER: ", "", $output1);
						$output1 = $output1/10;
						echo "<td>$output1</td>";
						$arr[] = $output1;
					//input 2	
						$input2 = snmpget($ip, "public", ".1.3.6.1.4.1.17409.1.11.10.0", $timeout);
						$input2 = str_replace("INTEGER: ", "", $input2);
						$input2 = $input2/10;
						echo "<td>$input2</td>";
						$arr[] = $input2;
					//output 2	
						$output2 = snmpget($ip, "public", ".1.3.6.1.4.1.17409.1.11.2.0", $timeout);
						$output2 = str_replace("INTEGER: ", "", $output2);
						$output2 = $output2/10;
						echo "<td>$output2</td>";
						$arr[] = $output2;
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
												
						echo "<td><input type=submit name=action value=Apply></td>";	
						echo "<td><input type=reset value=Reset></td>";
						echo "<input type=hidden name=description value=$description>";
						echo "<input type=hidden name=dwdm value=$dwdm>";
						echo "<input type=hidden name=ip value=$ip>";
					
					echo "</form>";
					echo "</tr>";
				};
				echo "</table><br>";

				mysql_free_result($result);		
				mysql_close($conn);
			
			?>
			
	<div id="graph"></div>
	<script>
		
    var day_data = [

    <?php
		for ($i=0; $i<count($arr); $i=$i+4) {
			echo "{'elapsed': 'in1', 'value': ".$arr[$i]."},";
			echo "{'elapsed': 'out1', 'value': ".$arr[$i+1]."},";
			echo "{'elapsed': 'in2', 'value': ".$arr[$i+2]."},";
			echo "{'elapsed': 'out2', 'value': ".$arr[$i+3]."},";
			echo "{'elapsed': '_', 'value': null },";
		}
	?>
		
    ];
    
    
    Morris.Line({
		element: 'graph',
		data: day_data,
		xkey: 'elapsed',
		ykeys: ['value'],
		labels: ['value'],
		parseTime: false,
		
    });
		
	</script>
	

<!------------------------------------------------>

		</div>
		<div id="footer">&copy; АЛСиТЕК</div>
	</div> 
</body>
</html>
