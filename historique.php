<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Historique</title>
	<link rel="stylesheet" type="text/css" href="css/recherche.css">
	<?php include_once("style_menu_awesome.php");?>
</head>
<body>
	<?php include_once("debut_menu.php");?>
	<header class="bords">
		<h1>Historique</h1>
	</header>
	<div class="contenu">
		<div class="monument_trouve">
			<?php
			try{
				$bdd = new PDO('mysql:host=localhost;dbname=-;charset=utf8', '-', '-');
			} catch (Exception $e) {
			        die('Problème de connexion à la base de donnée');
			}

			$reponse = $bdd->query("select compte.nickname as \"Nom\", commentaire.note as \"Note\", commentaire.commentaire as \"Commentaire\", commentaire.dateMsg as \"Date\", monument.libelleMonument as \"Lieu\" from Commentaire commentaire join Compte compte on compte.idCompte = commentaire.idCompte join Monument monument on monument.idMonument = commentaire.idMonument WHERE compte.nickname = \"" . $_SESSION['nickname'] . "\"");

			echo "<div><h2>Avis</h2>";
			while ($donnees = $reponse->fetch()) {
				echo "<hr><div class='bidule'>
						<p>
							<h1>" . $donnees['Nom'] . "</h1>
							<h4>";
				include("affichedate.php");
				echo "		<h4>" . $donnees['Lieu'] . "</h4>";

				echo "		</h4>
							<h4>";
							$note = $donnees['Note'];
							include("notation.php");
							echo "</h4>
								" . $donnees['Commentaire'] . "
						</p>
					</div>
					";

			}
			echo "</div>";
			$reponse->closeCursor();

			$reponse = $bdd->query("select compte.nickname as \"Nom\", message.message as \"Message\", message.dateMsg as \"Date\" from Message message join Compte compte on compte.idCompte = message.idCompte WHERE compte.nickname = \"" . $_SESSION['nickname'] . "\"");

			echo "<div><hr><h2>Chat</h2>";
			while ($donnees = $reponse->fetch()) {
				echo "<hr><div class='bidule'>
						<p>
							<h1>" . $donnees['Nom'] . "</h1>
							<h4>";
				include("affichedate.php");

				echo "		</h4>";
				echo $donnees['Message'] . "
						</p>
					</div>
					";

			}
			echo "</div>";
			$reponse->closeCursor();
			?>
		</div>
	</div>
	<footer class="bords">
		<p>&copy; Copyright Corobb</p>
	</footer>
	<?php include_once("fin_menu.php");?>
</body>
</html>
