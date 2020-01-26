<!DOCTYPE html>
<html>
<head>
	<title>Connectez vous</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="css/modif.css">
	<?php session_start();
	include_once("style_menu_awesome.php");?>
</head>
<body>
	<?php include_once("debut_menu.php");?>
	<header class="bords">
		<h1>Changement de prenom</h1>
	</header>
	<div class="login_div">
		<form id="formulaire" method="post">
				<p>
					<label for="prenom">Entrez votre prenom</label>
	    			<input type="text" id="prenom" name="prenom" placeholder="Prenom" required pattern="^[a-zA-Z]+$">
				</p>
				<input type="submit" name="valide" id="valide" value="Changer prenom">
		<?php
		if(!empty($_POST['valide'])){
			if(!(preg_match("/^[a-zA-Z]+$/", $_POST['prenom'])))
				echo "<p>Votre prenom ne corespond pas au format</p>";
			else{
				try{
					$bdd = new PDO('mysql:host=localhost;dbname=-;charset=utf8', '-', '-');
				} catch (Exception $e) {
				        die('Problème de connexion à la base de donnée');
				}
				$bdd->exec("UPDATE Compte SET prenom = \"{$_POST['prenom']}\" where idCompte={$_SESSION['idCompte']}");
					header('location: profile.php?etat=1');
			}
		}
		?>
		</form>
	</div>
	<footer class="bords">
		<p>&copy; Copyright Corobb</p>
	</footer>
	<?php include_once("debut_menu.php");?>
</body>
</html>
