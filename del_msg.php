<?php
$bdd = new PDO('mysql:host=localhost;dbname=-;charset=utf8', '-', '-');
$reponse = $bdd->query("SELECT count(*) as \"count\" FROM Message");

while ($donnees = $reponse->fetch()) {
	if ($donnees['count'] > 20) {
		$dateMin = $bdd->query("select dateMsg from Message where dateMsg <= ALL(select dateMsg FROM Message)");

		while ($data = $dateMin->fetch()) {
			echo $data['dateMsg'];
			$bdd->exec("delete from Message where dateMsg = \"" . $data['dateMsg'] . "\"");
		}
		$dateMin->closeCursor();
	}
}
$reponse->closeCursor();
?>
