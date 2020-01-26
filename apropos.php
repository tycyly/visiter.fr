<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>A propos</title>
	<link rel="stylesheet" type="text/css" href="css/apropos.css">
	<?php include_once("style_menu_awesome.php");?>
</head>
<body>
	<?php include_once("debut_menu.php");?>
	<header class="bords">
		<h1>A propos</h1>
	</header>

	<div id="groupe" class="informations">
		<h2>Nom du groupe :</h2>
		<p>Corobb</p>
	</div>

	<div id="etudiants" class="informations">
		<h2>Etudiants : </h2>
		<?php
			$membres = array("EXCOFFIER", "DEPOISIER", "GIRARDOT", "FABBRO", "CLEAR", "KAMBERI");

			echo "<p class=\"membre\">| ";
			foreach ($membres as $membre) {
				echo "$membre | ";
			}
			echo "</p>";
		?>
	</div>
	<footer class="bords">
		<p>&copy; Copyright Corobb</p>
	</footer>
	<?php include_once("fin_menu.php");?>
</body>
</html>