<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" 
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html" charset="utf-8" />
		<title>Мониторинг усилителей</title>
		<link href="style.css" type="text/css" rel="stylesheet" />
		<script language="javascript" type="text/javascript" src="flot/jquery.js"></script>
		<script language="javascript" type="text/javascript" src="flot/jquery.flot.js"></script>
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
						
				$arr1 = array();
				if (isset ($_POST['dwdm'])) $dwdm=$_POST['dwdm'];
				if (isset ($_POST['description'])) $description=$_POST['description'];
				$timeout = 10000;
				echo "<h2>$description<br>DWDM $dwdm<br>Прямое направление<br></h2>";
				$conn = mysql_connect ("localhost", "root", "root");
				mysql_select_db ("ampmonitoring", $conn);
				//$resultip = mysql_query("select ip from configurations where description='$description' and dwdm='$dwdm' order by number");
				$resultip = mysql_query("select configurations.ip, configurations.number, amps.description from configurations, amps where configurations.description='$description' and configurations.dwdm='$dwdm' and configurations.ip=amps.ip and configurations.direction=0 order by number, ip");
				echo "<table border=1 cellpadding=3>
				<tr><td>IP</td><td>Descr</td><td>№</td><td>In1</td><td>Out1</td><td>In2</td><td>Out2</td>
						<td>Mode</td><td>GainValue, dB</td><td>Power 1, V</td><td>Power 2, V</td><td>Temp, C</td></tr>";
				
				while ($row = mysql_fetch_array($resultip)) {
						
						echo "<tr>";
						echo "<form method='post' action='edit_amp.php'>";
						
					
					//ip
						$ip = $row[0];
					// тут запрашиваем ip по snmp, если возвращается пустая строка, значит связи нет -> окрашиваем в красный 
						if (snmpget($ip, "public", ".1.3.6.1.4.1.17409.1.3.1.9.0", $timeout) == "")
							echo "<td bgcolor=dd0000>$ip</td>";
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
						$arr1[] = $input1;
					//output 1
						$output1 = snmpget($ip, "public", ".1.3.6.1.4.1.17409.1.11.9.0", $timeout);
						$output1 = str_replace("INTEGER: ", "", $output1);
						$output1 = $output1/10;
						echo "<td>$output1</td>";
						$arr1[] = $output1;
					//input 2	
						$input2 = snmpget($ip, "public", ".1.3.6.1.4.1.17409.1.11.10.0", $timeout);
						$input2 = str_replace("INTEGER: ", "", $input2);
						$input2 = $input2/10;
						echo "<td>$input2</td>";
						$arr1[] = $input2;
					//output 2	
						$output2 = snmpget($ip, "public", ".1.3.6.1.4.1.17409.1.11.2.0", $timeout);
						$output2 = str_replace("INTEGER: ", "", $output2);
						$output2 = $output2/10;
						echo "<td>$output2</td>";
						$arr1[] = $output2;
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
			
<!----------Отрисовка графика--------------------------->

<script type="text/javascript">

    $(function() {
            function getXAxis() {
                    var res = [], a=0
                    for (a=0; a<<? echo count($arr1)?>; a=a+4) {
                            res.push([a, 'in1']);
                            res.push([a+1, 'out1']);
                            res.push([a+2, 'in2']);
                            res.push([a+3, 'out2']);
                    }
                    return res;
            }

            var d1 = {	data: [
                    <?
                    for ($i=0; $i<count($arr1); $i=$i+1) {
                            //if (($i%4)==0 && $i!=0) { echo "[".$i .", null],"; }
                            echo "[$i,".$arr1[$i]."], ";				
                    }
            ?>
                    ], color: 3,		
            }

            var markings = [
            <?
                    for ($i=0; $i<count($arr1); $i+=4) {
                            echo "{ color: '#000', lineWidth: 2, xaxis: { from: ".($i-0.5).", to: ".($i-0.5)." } },";
                    }
            ?>
            ];

            var options = {
                    series: {
                            lines: { show: true },
                            points: { show: true },
                            hoverable: true,
                    },
                    lines: {
                            lineWidth: 3
                    },
                    xaxis: {
                            show: true,
                            tickSize: 1,		
                            ticks: getXAxis()
                    },
                    yaxis: {
                            tickSize: 1,
                    }, 
                    grid: {
                            aboveData: false,
                            autoHighlight: true,
                            hoverable: true,
                            mouseActiveRadius:20,
                            markings: markings
                    }
            };
/*
            $("<div id='tooltip'></div>").css({
                    position: "absolute",
                    display: "none",
                    border: "1px solid #fdd",
                    padding: "7px",
                    "background-color": "#fee",
                    opacity: 0.90
            }).appendTo("body");

*/
            var placeholder = $("#placeholder");
/*
            placeholder.bind("plothover", function (event, pos, item) {	
                    if (item) {
                            var x = item.datapoint[0],
                            y = item.datapoint[1];
                            $("#tooltip").html(y)
                            .css({top: item.pageY-45, left: item.pageX-15})
                            .fadeIn(200);
                    } else {
                            $("#tooltip").hide();
                    }		
            });
*/
            var plot = $.plot(placeholder, [d1], options);

//            var o = plot.pointOffset({ x: 1, y: 15});
//		placeholder.append("<div style='position:absolute;left:" + (o.left + 4) + "px;top:" + o.top + "px;color:#666;font-size:smaller'>Warming up</div>");
//            placeholder.append("<div style='position:absolute;left:" + (o.left + 4) + "px;top:" + o.top + "px;color:#000;font-size:15'>Warming up</div>");
//            o = plot.pointOffset({ x: 5, y: 15});
//            placeholder.append("<div style='position:absolute;left:" + (o.left + 4) + "px;top:" + o.top + "px;color:#000;font-size:15'>Warming up</div>");
//            o = plot.pointOffset({ x: 9, y: 15});
//            placeholder.append("<div style='position:absolute;left:" + (o.left + 4) + "px;top:" + o.top + "px;color:#000;font-size:15'>Warming up</div>");

//		$.plot(placeholder, [d1], options);



    });

</script>

<div id="placeholder" style="width:100%;height:300px"></div>


<!------------обратное направление------>

<?php
				
				$arr2 = array();
				if (isset ($_POST['dwdm'])) $dwdm=$_POST['dwdm'];
				if (isset ($_POST['description'])) $description=$_POST['description'];
				$timeout = 10000;
				echo "<h2><br><br>$description<br>DWDM $dwdm<br>Обратное направление<br></h2>";
				$conn = mysql_connect ("localhost", "root", "root");
				mysql_select_db ("ampmonitoring", $conn);
				//$resultip = mysql_query("select ip from configurations where description='$description' and dwdm='$dwdm' order by number");
				$resultip = mysql_query("select configurations.ip, configurations.number, amps.description from configurations, amps where configurations.description='$description' and configurations.dwdm='$dwdm' and configurations.ip=amps.ip and configurations.direction=1 order by number, ip");
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
							echo "<td bgcolor=dd0000>$ip</td>";
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
						$arr2[] = $input1;
					//output 1
						$output1 = snmpget($ip, "public", ".1.3.6.1.4.1.17409.1.11.9.0", $timeout);
						$output1 = str_replace("INTEGER: ", "", $output1);
						$output1 = $output1/10;
						echo "<td>$output1</td>";
						$arr2[] = $output1;
					//input 2	
						$input2 = snmpget($ip, "public", ".1.3.6.1.4.1.17409.1.11.10.0", $timeout);
						$input2 = str_replace("INTEGER: ", "", $input2);
						$input2 = $input2/10;
						echo "<td>$input2</td>";
						$arr2[] = $input2;
					//output 2	
						$output2 = snmpget($ip, "public", ".1.3.6.1.4.1.17409.1.11.2.0", $timeout);
						$output2 = str_replace("INTEGER: ", "", $output2);
						$output2 = $output2/10;
						echo "<td>$output2</td>";
						$arr2[] = $output2;
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
			
<!----------Отрисовка графика--------------------------->

<script type="text/javascript">

	$(function() {
		
		function getXAxis() {
			var res = [], a=0
			for (a=0; a<<? echo count($arr2)?>; a=a+4) {
				res.push([a, 'in1']);
				res.push([a+1, 'out1']);
				res.push([a+2, 'in2']);
				res.push([a+3, 'out2']);
			}
			
			return res;
		}

		var d2 = {
			data: [
			<?
			for ($i=0; $i<count($arr2); $i=$i+1) {
				//if (($i%4)==0 && $i!=0) { echo "[".$i .", null],"; }
				echo "[$i,".$arr2[$i]."], ";
				
			}
		?>
			],
			color: 3,
		
		}
		
		var markings = [
		<?
			for ($i=0; $i<count($arr2); $i+=4) {
				echo "{ color: '#000', lineWidth: 2, xaxis: { from: ".($i-0.5).", to: ".($i-0.5)." } },";
			}
		?>
		];
		
		var options = {
			series: {
				lines: { show: true },
				points: { show: true },
				hoverable: true,
				
			},
			lines: {
				lineWidth: 3
			},
			xaxis: {
				show: true,
				tickSize: 1,		
				ticks: getXAxis()
			},
			yaxis: {
				tickSize: 1,
			}, 
			grid: {
				aboveData: false,
				autoHighlight: true,
				hoverable: true,
				mouseActiveRadius:20,
				markings: markings
			}
		};
		$("<div id='tooltip2'></div>").css({
			position: "absolute",
			display: "none",
			border: "1px solid #fdd",
			padding: "7px",
			"background-color": "#fee",
			opacity: 0.90
		}).appendTo("body");
		
		$("#placeholder2").bind("plothover", function (event, pos, item) {	
			if (item) {
				var x = item.datapoint[0],
				y = item.datapoint[1];
				$("#tooltip2").html(y)
				.css({top: item.pageY-45, left: item.pageX-15})
				.fadeIn(200);
			} else {
				$("#tooltip2").hide();
			}		
		});
		

		$.plot("#placeholder2", [d2], options);


		
	});

</script>

<div id="placeholder2" style="width:100%;height:300px"></div>


<!------------------------------------------------>

		</div>
		<div id="footer">&copy; АЛСиТЕК</div>
	</div> 
</body>
</html>
