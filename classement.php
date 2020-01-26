<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title></title>
	<link rel="stylesheet" type="text/css" href="css/recherche.css">
	<?php include_once("style_menu_awesome.php");?>
</head>
<body>
	<?PHP include_once("debut_menu.php");?>
	<header class="bords">
		<h1>Classement par <i class="fas fa-star"></i></h1>
	</header>

	<?php
	try{
		$bdd = new PDO('mysql:host=localhost;dbname=-;charset=utf8', '-', '-');
	} catch (Exception $e) {
	        die('Problème de connexion à la base de donnée');
	}
	$reponse = $bdd->query("SELECT monument.header4000x2250 as \"header\", monument.idMonument as \"idMonument\", monument.libelleMonument as \"libelleMonument\", monument.description as \"description\"
							from Commentaire commentaire
							join Monument monument on monument.idMonument = commentaire.idMonument
							group by monument.idMonument
							ORDER by avg(commentaire.note) desc");

	echo "<div class='recherche_container'>";
	while ($donnees = $reponse->fetch()) {
		echo "<div class='recherche_item'>
				<img src=\"img/".$donnees['header']."\" alt=\"Image manquante\" class=\"img_item\"/>
				<div>
					<h1><a href='monument.php?monument={$donnees['idMonument']}'>{$donnees['libelleMonument']}</a></h1>
					<p>";
		echo $donnees['siecle'] . "</p>
				<p>{$donnees['description']}</p>
			</div>
		</div>";
	}
	$reponse->closeCursor();

	$reponse = $bdd->query("SELECT monument.header4000x2250 as \"header\", monument.idMonument as \"idMonument\", monument.libelleMonument as \"libelleMonument\", monument.description as \"description\"
							from Monument monument
							where monument.idMonument not in (SELECT monument.idMonument
							                        FROM Monument monument
							                        join Commentaire commentaire on commentaire.idMonument = monument.idMonument
							                        group by idMonument)");

	echo "<div class='recherche_container'>";
	while ($donnees = $reponse->fetch()) {
		echo "<div class='recherche_item'>
				<img src=\"img/".$donnees['header']."\" alt=\"Image manquante\" class=\"img_item\"/>
				<div>
					<h1><a href='monument.php?monument={$donnees['idMonument']}'>{$donnees['libelleMonument']}</a></h1>
					<p>";
		echo $donnees['siecle'] . "</p>
				<p>{$donnees['description']}</p>
			</div>
		</div>";
	}
	$reponse->closeCursor();
	?>
	<footer class="bords">
		<p>&copy; Copyright Corobb</p>
	</footer>
	<?PHP include_once("fin_menu.php");?>
</body>
</html>
