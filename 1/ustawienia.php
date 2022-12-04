<?php
session_start();
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8" />
	<style type="text/css">
		ul#menu {
			float: left;
			width: 10%;
			list-style-type: none;
		}

		div#tresc {
			float: left;
			width: 85%;
		}

		div#tresc table span {
			padding: 3px;
		}
	</style>
</head>

<body>
	<ul id="menu">
		<li><a href="tekst.php">Tekst</a></li>
		<li><a href="ustawienia.php">Ustawienia</a></li>
	</ul>
	<div id="tresc">
		<table cellpadding="4">
			<tr>
			<form method="post">
				<td>Kolor tla strony:</td>
				<td>
					<input type="radio" id = "greenish" name = "backgroundColor" value="#BAFF49"> <span style="background-color: #BAFF49" >#BAFF49 </span><br />
					<input type="radio" id = "blueish" name = "backgroundColor" value="#8E9BFF"> <span style="background-color: #8E9BFF" >#8E9BFF</span><br />
					<input type="radio" id = "brownish" name = "backgroundColor" value="#FFEFBF"> <span style="background-color: #FFEFBF" >#FFEFBF</span><br />
				</td>
			</tr>
			<tr>
				<td>Krój czcionki:</td>
				<td>
					<select name = "font">
						<option value = "Verdana">Verdana</option>
						<option value = "Arial">Arial</option>
						<option value = "Courier New">Courier New</option>
					</select>
				</td>
			</tr>
			<tr>
				<td>Wielkość czcionki:</td>
				<td><input type="text" name ="fontSize" style="width: 30px" />px</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td><input type="submit" name="submit1" value="Zapisz" /></td>
				
			</tr>
		</table>
		</form>
	</div>
<?php
if (isset($_POST['submit1'])) {
   $color = $_POST['backgroundColor'];
   $fonts = $_POST['font'];  
   $fontSize = $_POST['fontSize']; 
   $_SESSION["SelectedColor"] = $color;
   $_SESSION["SelectedFont"] = $fonts;
   $_SESSION["SelectedFontSize"] = $fontSize;
   echo $color, $fonts, $fontSize;
}
?>
</body>
</html>