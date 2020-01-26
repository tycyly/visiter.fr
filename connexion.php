<!DOCTYPE html>
<html>
<head>
	<title>Connectez vous</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="css/style_connexion.css">
	<?php include_once("style_menu_awesome.php");?>
</head>
<body>
	<?php include_once("debut_menu.php");?>
	<header class="bords">
		<h1>Connexion</h1>
	</header>
	<div class="login_div">
		<form id="formulaire" method="post">
			<p>
				<label for="login">Login</label>
				<input type="text" name="login" id="login" placeholder="Login" required pattern="^[a-zA-Z0-9]+$" />
			</p>
			<p>
				<label for="pass">Mot de passe</label>
    			<input type="password" id="password" name="password" placeholder="Password" required pattern="^[a-zA-Z0-9.!?,:;#]+$">
			</p>
			<input type="submit" name="valide" id="valide" value="Confirmer">
			<a href="inscription.php" id="sinscrire">S'inscrire</a>
			<?php
			if($_GET["etat"]==1) echo "<p class='valid'>Votre compte a bien été créé</p>"; 
		if(!empty($_POST)){
			$login=$_POST["login"];
			$password=$_POST["password"];
			if(preg_match("/^[a-zA-Z0-9]+$/", $login) && preg_match("/^[a-zA-Z0-9.!?,:;#]+$/", $password)) {
				try{
					$bdd = new PDO('mysql:host=localhost;dbname=-;charset=utf8', '-', '-');
				} catch (Exception $e) {
				        die('Problème de connexion à la base de donnée');
				}
				$reponse = $bdd->query('SELECT * FROM Compte');
				$exist = false;

				while ($donnees = $reponse->fetch()) {
					if ($donnees['nickname'] == $_POST['login']) {
						$exist = true;
						if(hash("sha256", $password)===$donnees["password"]) {
							echo "<p class='valid'>Connexion en cours... Si vous n'êtes pas redirigé cliquez <a href='index.php'>ici</a></p>";
							session_start();
							$_SESSION['idCompte'] = $donnees['idCompte'];
							$_SESSION['nickname'] = $donnees['nickname'];
							header('location: profile.php');
						}
						else {
							echo "<p class='error'>Mot de passe incorrect</p>";
						}
					}
				}
				if($exist===false) {
					echo "<p class='error'>Aucune compte ne possède ce login</p>";
				}
				$reponse->closeCursor();
			}
			else {
				echo "<p class='error'>Veuillez ne pas utiliser de caractères spéciaux dans le pseudo / mot de passe</p>";
			}
		}?>
		</form>
	</div>
	<footer class="bords">
		<p>&copy; Copyright Corobb</p>
	</footer>
	<?php include_once("debut_menu.php");?>
</body>
</html>
