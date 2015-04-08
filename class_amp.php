<?php

	class Amp {
		private $ip;
		private $amp_description;
		private $in1;
		private $out1;
		private $in2;
		private $out2;
		private $mode;
		private $gainValue;
		private $power1;
		private $power2;
		private $temperature;
		private $timeout=10000;
		
		function __construct($ip) {
			$this->ip = $ip;
		} 

		public function printParam($originalParam) {
			$param = strtolower($originalParam);
			$oid;
			$value;
			
			if ($param=='in1' || $param=='input1') $oid=".1.3.6.1.4.1.17409.1.11.3.0";
			if ($param=='in2' || $param=='input2') $oid=".1.3.6.1.4.1.17409.1.11.10.0";
			if ($param=='out1' || $param=='output1') $oid=".1.3.6.1.4.1.17409.1.11.9.0";
			if ($param=='out2' || $param=='output2') $oid=".1.3.6.1.4.1.17409.1.11.2.0";
			if ($param=='power1' || $param=='p1') $oid=".1.3.6.1.4.1.17409.1.11.7.1.2.1";
			if ($param=='power1' || $param=='p1') $oid=".1.3.6.1.4.1.17409.1.11.7.1.2.2";
			if ($param=='mode') $oid=".1.3.6.1.4.1.17409.1.11.82.0";
			if ($param=='nonmode') $oid=".1.3.6.1.4.1.17409.1.11.82.0";
			if ($param=='gainvalue') $oid=".1.3.6.1.4.1.17409.1.11.80.0";
			if ($param=='outputvalue') $oid=".1.3.6.1.4.1.17409.1.11.11.0";
			if ($param=='temp' || $param=='temperature' || $param=='unittemp' ) $oid=".1.3.6.1.4.1.17409.1.3.1.13.0";

			
			$value = snmpget($this->ip, "public", $oid, $this->timeout);
			$value = str_replace("INTEGER: ", "", $value);
			
			if ($param == 'mode') {
				if ($value=='1') $value='Gain';
				else $value = 'Power';
			} else
			if ($param == 'nonmode') {
				if ($value=='1') $value='Power';
				else $value='Gain';
			} else
			if ($param=='power1' || $param=='power2' || $param=='p1' || $param=='p2') {
				// деления на 10 не происходит, ничего не делаем
			} else {
				$value = $value/10;
			}

			echo $value;
		}
		
		public function printIp() {
			echo $this->ip;
		}
		
		
		
	}
	
	
	
?>
