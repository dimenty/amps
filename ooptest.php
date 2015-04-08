<html>
<head>
</head>

<body>
	<?
		include ("class_amp.php");
		$amp = new Amp('192.168.100.31');
		$amp->printParam('nonmode');
		echo "<br>done<br>";
		
		$conn = mysql_connect ("localhost", "root", "root");
		mysql_select_db ("ampmonitoring", $conn);
		$result = mysql_query("select ip from amps order by ip");
		
		$arr = array();
		while ($row = mysql_fetch_array($result)) { 
			$arr[] = $row[0];
		}
		mysql_close($conn);
		$amps = array();
		
		for ($i=0; $i<count($arr); $i++) {
			$amps[] = new Amp($arr[$i]);
		}
		
		for ($i=0; $i<count($amps); $i++) {
			$amps[$i]->printIp(); echo " - ";
			$amps[$i]->printParam("in1"); echo " - ";
			$amps[$i]->printParam("out1"); echo " - ";
			$amps[$i]->printParam("in2"); echo " - ";
			$amps[$i]->printParam("out2"); echo " - ";
			echo "<br>";
		}
						
	?>
	
	

</body>
