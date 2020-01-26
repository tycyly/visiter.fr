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
		<h1>Changement de login</h1>
	</header>
	<div class="login_div">
		<form id="formulaire" method="post">
				<p>
					<label for="login">Entrez votre login</label>
	    			<input type="text" id="login" name="login" placeholder="Login" required pattern="^[a-zA-Z0-9]+$">
				</p>
				<input type="submit" name="valide" id="valide" value="Changer login">
		<?php
		if(!empty($_POST['valide'])){
			if(!(preg_match("/^[a-zA-Z0-9]+$/", $_POST['login'])))
				echo "<p>Votre login ne corespond pas au format</p>";
			else{
				try{
					$bdd = new PDO('mysql:host=localhost;dbname=-;charset=utf8', '-', '-');
				} catch (Exception $e) {
				        die('Problème de connexion à la base de donnée');
				}
				$reponse = $bdd->query('SELECT * FROM Compte');
				$exist = false;
				while ($donnees = $reponse->fetch()) {
					if (strtolower($donnees['nickname']) == strtolower($_POST['login'])) {
						$exist = true;
						echo "<p class='error'>Ce login n'est pas libre, réessayez avec un login différent</p>";
					}
				}
				$reponse->closeCursor();
				if($exist==false) {
					$bdd->exec("UPDATE Compte SET nickname = \"{$_POST['login']}\" where idCompte={$_SESSION['idCompte']}");
					$_SESSION['nickname'] = $_POST['login'];
					header('location: profile.php?etat=1');
				}
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
