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
		<div id="header">Добавление усилителя</div>
		<div id="leftbar">
			<?php include("navi.php"); ?>
		</div>
		<div id="content" align='justify'>
		
<!------------------------------------------------>		
			<h2>Добавление усилителя</h2><br>
			<form action="adding_amp.php" method="post" name="form">
				<p class="txt">
				IP: <input name="ip" type="text" size="20" maxlength="15"><br><br>
				Описание: <input name="description" type="text" size="40" maxlength="255"><br><br>
				Model: <input name="model" type="text" size="20" maxlength="15"><br><br>

				
				<input name="submit" type="submit" value="Добавить">
				</p>
			</form>


<!------------------------------------------------>

		</div>
		<div id="footer">&copy; АЛСиТЕК</div>
	</div> 
</body>
</html>
