<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="css/carte.css">
	<title></title>
</head>
<body>
<form id="carte" method="post" action="">
	<div id="links">
		<label for="lien">Monuments :</label><br>
		<select name="lien" id="lien">
			<option value="default" selected>-</option>
			<?php

			$dbconn = new PDO('mysql:host=localhost;dbname=-;port=5432','-','-');
			$query = $dbconn->query('SELECT idMonument, libelleMonument, mapTab FROM Monument');
			foreach ($query as $row) {
				$monuments[] = $row;
			}
			$dbconn = null;
		
			foreach ($monuments as $id => $txt) {
				if ($_POST["lien"] == "$id" )
					echo "<option value='$id' selected>".utf8_encode($txt[1])."</option>";
				else
					echo "<option value='$id'>".utf8_encode($txt[1])."</option>";
			}
	echo "</select><br><br><input type='submit' name='valide' id='valide' value='Chercher'></form></div>";

			if($_POST["lien"] != "default" && isset($_POST["lien"])){
				$code=$_POST["lien"];
				echo "<figure><iframe class='map' src=\"" .$monuments[$code][2]. "\"></iframe><figcaption>" .utf8_encode($monuments[$code][1]). "</figcaption></figure>";
			}
			else{
				// foreach ($monuments as $id => $txt) {
				// 	echo "<figure><iframe class='map' src=\"" .$monuments[$id][2]. "\"></iframe></figure>";
				// }
				echo "<figure><iframe class='map' src='https://www.google.com/maps/d/u/0/embed?mid=1N_pvyBXlUBNoJ1Wrz5MawLtwKt8XTn1B'></iframe></figure>";			
			}
			?>

</body>
</html>
