<?php 
try{
	$bdd = new PDO('mysql:host=localhost;dbname=-;charset=utf8', '-', '-');
} catch (Exception $e) {
        die('Problème de connexion à la base de donnée');
}

$occ=true;

echo "
	<!DOCTYPE html>
	<html>
	<head>
		<title>Profile</title>
		<meta charset='utf-8'>
		<link rel='stylesheet' type='text/css' href='css/style_profile.css'>
		<link rel='stylesheet' type='text/css' href='css/style_note.css'>";
include_once('style_menu_awesome.php');
	echo "</head>
	<body>";
include_once("debut_menu.php");
	echo "<header>";
	echo "<div class=\"div_profile\">
		<h1>Profil</h1>
		<h2>Pseudo : " . $_SESSION['nickname']."</h2>
		</div>
		</header>";

$reponse = $bdd->query("SELECT compte.nickname as \"Nom\", commentaire.commentaire as \"Commentaire\", commentaire.note as \"Note\", monument.libelleMonument as \"Lieu\", commentaire.dateMsg as \"Date\" from Compte compte join Commentaire commentaire on commentaire.idCompte = compte.idCompte join Monument monument on monument.idMonument = commentaire.idMonument where compte.nickname = \"" . $_SESSION["nickname"] . "\"");
	echo "<div class='bidule_cont'>
			<div class='liens'>
				<a href='info.php' id='modif'>Mes infos</a>";
				if($_GET["etat"]==1) echo "<p class='valid'>Modification effectuée</p>";
				echo "<!--<a href='historique.php' id='msg'>Mon historique</a>-->
			</div>";
while ($donnees = $reponse->fetch()) {
	echo "<div class='bidule'>
			<h1>".$donnees['Nom']."</h1><h4>".$donnees['Lieu']."</h4>
			<h4>";
			include("affichedate.php");
	echo "</h4>
		<h4>";
			$note = $donnees['Note'];
			include("notation.php");
	echo "</h4>
			<p>".$donnees['Commentaire']."</p>
		</div>";
}
echo "</div>";
$reponse->closeCursor();

echo "<footer> &copy; Our Website </footer>";
include_once("fin_menu.php");
echo "</body> </html>";

if($occ===false) {
	header('location: errors/404.php');
}
?>
