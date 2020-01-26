<?php
$i = 0;
$bdd = new PDO('mysql:host=localhost;dbname=-;charset=utf8', '-', '-');
$reponse = $bdd->query("select message.dateMsg as \"Date\", message.message as \"message\", compte.nickname as \"nickname\" from Message message join Compte compte on compte.idCompte = message.idCompte order by dateMsg desc");

$affiche = array();

while ($donnees = $reponse->fetch()) {
	if ($i < 30) {
		$affiche[] = array('nickname' => $donnees['nickname'], 'Date' => $donnees['Date'], 'message' => $donnees['message']);
	}
	$i++;
}

$reponse->closeCursor();

for ($j = 29; $j >= 0; $j--) {
	if (!empty($affiche[$j])) {
		echo $affiche[$j]['nickname'] . " (";
		$donnees['Date'] = $affiche[$j]['Date'];
		include("affichedate.php");
		echo ") : " . $affiche[$j]['message'] . "<br/>";
	}
}
?>
