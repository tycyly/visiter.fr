<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Inscription</title>
	<link rel="stylesheet" type="text/css" href="css/style_login.css">
	<?php include_once("style_menu_awesome.php");?>
</head>
<body>
	<?php include_once("debut_menu.php");?>
	<header class="bords">
		<h1>Inscription</h1>
	</header>
	<div class="inscription_div">
		<form method="POST" action="">
			<p>
				<label for="login">Login: *</label>
				<input type="text" name="login" size="30" minlength="5" value="<?PHP if ( !empty($_POST['login']) && preg_match("/^[a-zA-Z0-9]+$/", $_POST['login'])==1) echo $_POST['login']; ?>" placeholder="5 caractères minimum" required />
			</p>
			<p>
				<label for="email">Email: *</label>
				<input type="email"  name="email" value="<?PHP if ( !empty($_POST['email']) && preg_match("/[:punct:]/", $_POST['email'])==0) echo $_POST['email']; ?>" required />
			</p>
			<p>
				<label for="nom">Nom:</label>
				<input type="text"  name="nom" value="<?PHP if ( !empty($_POST['nom']) && preg_match("/[:punct:]/", $_POST['nom'])==0) echo $_POST['nom']; ?>" />
			</p>
			<p>
				<label for="prenom">Prénom: </label>
				<input type="text"  name="prenom" value="<?PHP if ( !empty($_POST['prenom']) && preg_match("/[:punct:]/", $_POST['prenom'])==0) echo $_POST['prenom']; ?>" />
			</p>
			<p>
				<label for="mdp">Mot de passe: *</label>
				<input type="password"  name="mdp" value="<?PHP if ( !empty($_POST['mdp']) && preg_match("/^[a-zA-Z0-9.!?,:;#]+$/", $_POST['mdp'])) echo $_POST['mdp']; ?>" placeholder="8 caractères minimum" required />
			</p>
			<p>
				<label for="mdp2">Vérification mot de passe: *</label>
				<input type="password"  name="mdp2" value="<?PHP if ( !empty($_POST['mdp2']) && preg_match("/^[a-zA-Z0-9.!?,:;#]+$/", $_POST['mdp2'])) echo $_POST['mdp2']; ?>" required />
			</p>
			<p>
				<input type="submit" name="valide" id="valide" value="Envoyer">
			</p>
		<?PHP
		if(!empty($_POST)) {
			if(!empty($_POST["login"]) && !empty($_POST["mdp"]) && !empty($_POST["mdp2"]) && !empty($_POST["email"])){
				$login=$_POST["login"];
				$password=$_POST["mdp"];
				$password2=$_POST["mdp2"];
				$email=$_POST["email"];
				$prenom=$_POST["prenom"];
				$nom=$_POST["nom"];
				if(strlen($login)>=5) {
					if (strlen($password)>=8) {
						if(preg_match("/[:punct:]/", $prenom)==0) {
							if(preg_match("/[:punct:]/", $nom)==0) {
								if (filter_var($email, FILTER_VALIDATE_EMAIL)){
									if(preg_match("/^[a-zA-Z0-9]+$/", $login)==1 && preg_match("/^[a-zA-Z0-9.!?,:;#]+$/", $password)==1 && preg_match("/^[a-zA-Z0-9.!?,:;#]+$/", $password2)==1) {
										try{
											$bdd = new PDO('mysql:host=localhost;dbname=-;charset=utf8', '-', '-');
										} catch (Exception $e) {
										        die('Problème de connexion à la base de donnée');
										}
										$reponse = $bdd->query('SELECT * FROM Compte');
										$exist = false;

										while ($donnees = $reponse->fetch()) {
											if (strtolower($donnees['nickname']) == strtolower($login)) {
												$exist = true;
												echo "<p class='error'>Ce login n'est pas libre, réessayez avec un login différent</p>";
											}
										}
										$reponse->closeCursor();
										if($exist===false) {
											if($password===$password2) {
												$password=hash("sha256", $password);
												$bdd->exec("INSERT INTO Compte(nickname, password, nom, prenom, email) VALUES (\"$login\",\"$password\",\"$nom\",\"$prenom\",\"$email\");");
												echo "<p class='valid'>Compte créé</p>";
												header('location: connexion.php?etat=1');
											}
											else {
												echo "<p class='error'>Compte non créé</p>";
											}
										}
									}
									else {
										echo "<p class='error'>Veuillez ne pas utiliser de caractères spéciaux dans le pseudo / mot de passe (seuls .!?,:;# sont autorisés)</p>";
									}
								}
								else {
									echo "Votre email ne soit pas contenir de caractères spéciaux</p>";
								}
							}
							else {
								echo "Votre nom ne soit pas contenir de caractères spéciaux</p>";
							}
						}
						else {
							echo "Votre prénom ne soit pas contenir de caractères spéciaux</p>";
						}
					}
					else {
						echo "<p class='error'>Votre mot de passe n'est pas assez long (8 Caractères minimum)</p>";
					}
				}
				else {
					echo "<p class='error'>Votre pseudo n'est pas assez long (5 Caractères minimum)</p>";
				}
			}
			else {
				echo "<p class='error'>Veuillez renseigner tous les champs</p>";
			}
		}?>
		</form>
	</div>
	<footer class="bords">
		<p>&copy; Copyright Corobb</p>
	</footer>
	<?php include_once("fin_menu.php");?>
</body>
</html>
