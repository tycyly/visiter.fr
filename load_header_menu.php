<?php
$monument = $_POST['monument'];
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

	echo "<h1>".$donnees["libelleMonument"]."</h1>
	<h2>".$donnees["libellePays"]." / ".$donnees["libelleRegion"]."</h2>
	<h2>";
	echo $donnees['siecle'] . "</h2>
	<h2>";

	include("notation.php");
}
$reponse->closeCursor();

echo "</h2>";
?>
