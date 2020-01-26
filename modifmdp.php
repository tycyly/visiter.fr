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
		<h1>Changement de mot de passe</h1>
	</header>
	<div class="login_div">
		<form id="formulaire" method="post">
				<p>
					<label for="pass">Nouveau mot de passe</label>
	    			<input type="password" id="password" name="password" placeholder="Password" required pattern="^[a-zA-Z0-9.!?,:;#]+$">
				</p>
				<p>
					<label for="pass2">Entrez le à nouveau</label>
	    			<input type="password" id="password2" name="password2" placeholder="Password" required pattern="^[a-zA-Z0-9.!?,:;#]+$">
				</p>
				<input type="submit" name="valide" id="valide" value="Changer mot de passe">
		<?php
		if(!empty($_POST['valide'])){
			if(!(preg_match("/^[a-zA-Z0-9.!?,:;#]+$/", $_POST['password'])))
				echo "<p>Votre mot de passe ne corespond pas au format</p>";
			elseif ($_POST['password']!=$_POST['password2'])
					echo "<p>Vous n'avez pas entrer le même mot de passe</p>";
			else{
				try{
					$bdd = new PDO('mysql:host=localhost;dbname=-;charset=utf8', '-', '-');
				} catch (Exception $e) {
				        die('Problème de connexion à la base de donnée');
				}
				$bdd->exec("UPDATE Compte SET password = \"".hash("sha256",$_POST['password'])."\" where idCompte={$_SESSION['idCompte']}");
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
