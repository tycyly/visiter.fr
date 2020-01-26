<?php 
	$monument=$_GET["monument"];
	$occ=false;

	try{
		$bdd = new PDO('mysql:host=localhost;dbname=-;charset=utf8', '-', '-');
	} catch (Exception $e) {
	        die('Problème de connexion à la base de donnée');
	}

	$moyenne = "Aucune note";
	$i = 0;

	$reponse = $bdd->query("select note from Commentaire where idMonument = \"$monument\"");

	while ($donnees = $reponse->fetch()) {
		if ($i == 0) {
			$moyenne = 0;
		}
		$note = $donnees['note'];
		$moyenne += $note;
		$i += 1;
	}

	$reponse->closeCursor();

	if ($moyenne != "Aucune note") {
		$moyenne /= $i;
	}
	$note = $moyenne;

	$reponse = $bdd->query("SELECT * FROM Monument m join Ville v on v.idVille=m.idVille join Pays p on p.idPays=v.idPays join Region r on r.idRegion=p.idRegion where m.idMonument=\"$monument\"");
	while ($donnees = $reponse->fetch()) {
		$occ=true;
		echo "
		<!DOCTYPE html>
		<html>
		<head>
			<title>Monument - ".$donnees["libelleMonument"]."</title>
			<meta charset='utf-8'>
			<link rel='stylesheet' type='text/css' href='css/style_monument.css'>
			<link rel='stylesheet' type='text/css' href='css/style_note.css'>";
		echo "<script src=\"https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js\"></script>";
			include_once('style_menu_awesome.php');
		echo "</head>
		<body>";
		include_once("debut_menu.php");
		echo "<div class='monument_trouve'>
				<header";
		echo " style=\"background :linear-gradient(rgba(66, 72, 116, 0.95),rgba(55, 68, 95, 0.95)),url('img/".$donnees["bandeau1170x530"]."'), no-repeat\"";
		echo ">";
		?>
					<div id='machin'>
						<?php
						 echo "<h1>".$donnees["libelleMonument"]."</h1>
						<h2>".$donnees["libellePays"]." / ".$donnees["libelleRegion"]."</h2>
						<h2>";
						echo $donnees['siecle'] . "</h2>
						<h2>";

						include("notation.php");

						echo "</h2>";
						?>
					</div>
					<?php
					 echo "<div id='truc' style=\"background: url(img/".$donnees["header4000x2250"].") center center no-repeat;background-size: auto 500px\"></div>
				</header>
				<div id=\"description\">
				<div>".$donnees["description"]."</div>
				<iframe src='".$donnees["mapTab"]."frameborder='0' style='border:0px;'></iframe></div>";
				if(!empty($donnees["pdf"]))
					echo "<a class='telechargement' href='{$donnees["pdf"]}' download><i class='fas fa-file-pdf'></i> Guide de tourisme du pays</a>";

	}
	$reponse->closeCursor();

	if(!empty($_SESSION)) {
		$i=0;
		$idCompte=$_SESSION['idCompte'];
		$req = $bdd->query("SELECT * FROM Compte join Commentaire on Commentaire.idCompte=Compte.idCompte where Commentaire.idMonument=\"$monument\" and Compte.idCompte=\"$idCompte\"");
		while ($reqCom = $req->fetch()) {
			$i++;
		}
		$req->closeCursor();
		if($i===0)
			include_once("commentaire.php");
		else {
			echo "<p>Vous avez déjà laissé un commentaire sur ce monument</p>";
			try {
				$bdd = new PDO('mysql:host=localhost;dbname=-;charset=utf8', '-', '-');
			} catch (Exception $e){
				die('Problème de connexion à la base de donnée');
			}
			$requete = $bdd->query("SELECT commentaire from Commentaire where Commentaire.idCompte=\"$idCompte\" and Commentaire.idMonument=\"$monument\"");

			echo "<form method=\"post\" action=\"\">";
			echo "<div id=\"apBouton\">";
			echo "<label id=\"apparBouton\" for=\"changeCom\">Cliquez ici pour modifier le commentaire</label>\n";
			echo "<input type=\"checkbox\" name=\"changeCom\" id=\"changeCom\">";
			echo "<div id=\"modifieCom\">\n";
			echo "<label for=\"nouveauCommentaire\">Nouveau Commentaire : </label>\n";
			if (!empty($_POST['nouveauCommentaire']))  {
				if (preg_match("/\bpute\b|\bsalope\b|\bputain\b|\bencule\b|\bconnard\b|\bnique\b|\bbaise\b|\bmerde\b|\bcul\b|\bbatard\b|\bconnasse\b|\benfoire\b|\bcaca\b|\bbordel\b|\bcon\b|\bhitler\b/i", $_POST['nouveauCommentaire']) == 0)
				{
					if(strlen($_POST["commentaire"]<=150)) {
						$bdd->exec("UPDATE Commentaire SET commentaire = \"{$_POST['nouveauCommentaire']}\" where Commentaire.idCompte=$idCompte and Commentaire.idMonument=\"$monument\"");
						echo "Avis modifié !";
					}
					else {
						echo "<p class='error'>Votre avis ne peut dépasser 150 charactères</p>";
					}
				}
				else
					echo "<p>Commentaire non autorisé</p>";
			}

			while ($donnees = $requete->fetch()) {
				echo "<textarea type=\"text\" name=\"nouveauCommentaire\" id=\"nouveauCommentaire\" placeholder=\"Commentaire...\">{$donnees["commentaire"]}</textarea>\n";				
			}
			echo "<input type=\"submit\" id=\"submit\" name=\"submit\"\n>";

			echo "</div>";
			echo "</div>";
			echo "</form>\n";
		}
	}
	else {
		echo "<p>Vous devez être connecté pour laisser un avis</p>";
	}

	$reponse = $bdd->query("select compte.nickname as \"Nom\", commentaire.note as \"Note\", commentaire.commentaire as \"Commentaire\", commentaire.dateMsg as \"Date\" from Commentaire commentaire join Compte compte on compte.idCompte = commentaire.idCompte WHERE idMonument = $monument");

	while ($donnees = $reponse->fetch()) {
		echo "<hr><div class='bidule'>
				<p>
					<h1>" . $donnees['Nom'] . "</h1>
					<h4>";
		include("affichedate.php");

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
	$reponse->closeCursor();

	echo "<footer> &copy; Corobb</footer>
		</div>";
	include_once("fin_menu.php");
	?>
	<script>
		setInterval('load_messages()', 1500);
		function load_messages() {
			$('#machin').load("load_header_menu.php", {monument : <?php echo json_encode($monument); ?>});
		}
	</script>
</body> 
</html>
<?php

	if($occ===false) {
		header('location: errors/404.php');
	}
	?>
