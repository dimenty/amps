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
	
	<script src="js-class.js"></script>
	<script src="bluff-src.js"></script>
	<script src="bluff-min.js"></script>
	<script src="excanvas.js"></script>
	<canvas id="example" width="400" height="300"></canvas>
  <script type="text/javascript">
    var g = new Bluff.Line('example', '400x300');
    g.title = 'My Graph';
    g.tooltips = true;

    g.theme_37signals();

    g.data("Apples", [1, 2, 3, 4, 4, 3]);
    g.data("Oranges", [4, 8, 7, 9, 8, 9]);
    g.data("Watermelon", [2, 3, 1, 5, 6, 8]);
    g.data("Peaches", [9, 9, 10, 8, 7, 9]);

    g.labels = {0: '2003', 2: '2004', 4: '2005'};

    g.draw();
  </script>
<!------------------------------------------------>

		</div>
		<div id="footer">&copy; АЛСиТЕК</div>
	</div> 
</body>
</html>
