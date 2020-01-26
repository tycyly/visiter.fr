<!DOCTYPE html>
<html>
<head>
	<title>Mes informations</title>
	<link rel="stylesheet" type="text/css" href="css/style_info.css" />
	<?php include_once("style_menu_awesome.php");?>
</head>
<body>
	<?php include_once("debut_menu.php");?>
	<div id="mesInfo">
		<header class="bords">
			<h1>Mes informations</h1>
		</header>
		<div class="textInfo">
			<?php
			try{
				$bdd = new PDO('mysql:host=localhost;dbname=-;charset=utf8', '-', '-');
			} catch (Exception $e) {
			        die('Problème de connexion à la base de donnée');
			}
			$reponse = $bdd->query("SELECT * FROM Compte where Compte.idCompte=\"{$_SESSION["idCompte"]}\"");

			while ($donnees = $reponse->fetch()) {
				echo "<div class='itemInfo'><p>Pseudo : {$donnees["nickname"]}</p><a href='modifnickname.php'><i class='fas fa-pen'></i></a></div>";
				echo "<div class='itemInfo'><p>Email : {$donnees["email"]}</p><a href='modifmail.php'><i class='fas fa-pen'></i></a></div>";
				echo "<div class='itemInfo'><p>Nom : {$donnees["nom"]}</p><a href='modifnom.php'><i class='fas fa-pen'></i></a></div>";
				echo "<div class='itemInfo'><p>Prénom : {$donnees["prenom"]}</p><a href='modifprenom.php'><i class='fas fa-pen'></i></a></div>";
				echo "<div class='itemInfo'><p>Mot de passe : <i>Secret</i> </p><a href='modifmdp.php'><i class='fas fa-pen'></i></a></div>";
			}
			?>
		</div>
		<footer class="bords">
			<p>&copy; Copyright Corobb</p>
		</footer>
	</div>
	<?php include_once("fin_menu.php");?>
</body>
</html>
