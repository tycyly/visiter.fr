<?php
if (!empty($_POST['login']) && !preg_match("/^[a-zA-Z0-9]{5,}$/", $_POST['login'])) {
	echo "</br>";
	echo "Login incorrect";
}

echo "</br>";

if (!empty($_POST["mdp"]) && !preg_match("/^[a-zA-Z0-9]{8,}$/", $_POST['mdp'])) {
	if (empty($_POST["mdp2"])) {
		echo "Il manque la Vérification";
		
	} else if ($_POST["mdp"] != $_POST["mdp2"]) {			
		echo "Mot de passe et vérification non identique";
	}
}

if (!empty($_POST['login']) && !empty($_POST['mdp']) && $_POST['mdp2'] == $_POST['mdp']) {
	$bdd = new PDO('mysql:host=localhost;dbname=-;charset=utf8', '-', '-');

	$reponse = $bdd->query('SELECT nickname FROM Compte');
	$exist = false;

	while ($donnees = $reponse->fetch()) {
		if ($donnees['nickname'] == $_POST['login']) {
			$exist = true;
		}
	}

	$reponse->closeCursor();

	if ($exist == false) {
		$bdd->exec("INSERT INTO Compte(nickname, password) VALUES (\"" . $_POST['login'] . "\", \"" . hash("sha256", $_POST['mdp']) . "\");");
		echo "Compte créé";

	} else {
		echo "Compte existant";
	}
}
?>
