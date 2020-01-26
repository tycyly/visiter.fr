<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title></title>
	<link rel="stylesheet" type="text/css" href="css/recherche.css">
	<?php include_once("style_menu_awesome.php");?>
</head>
<body>
	<?php 
	try{
		$bdd = new PDO('mysql:host=localhost;dbname=-;charset=utf8', '-', '-');
	} catch (Exception $e) {
	        die('Problème de connexion à la base de donnée');
	}
	$ville = $bdd->query("SELECT libelleVille from Ville");
	$pays = $bdd->query("SELECT libellePays from Pays");
	?>
	<?PHP include_once("debut_menu.php");?>
	<header class="bords">
		<h1>Recherche d'un lieu touristique</h1>
	</header>

	<figure id="mapAll">
		<h2>Emplacements des monuments : </h2>
		<iframe id="map" src='https://www.google.com/maps/d/u/0/embed?mid=1N_pvyBXlUBNoJ1Wrz5MawLtwKt8XTn1B'></iframe></figure>
		
	<form action="#" method="post">
		<fieldset id="formulaire">
			<legend align="center">Formulaire de recherche : </legend>
			
			<div id="paysEnter" class="champs" style="margin-left: 150px;">
				<label for="nom">Nom du site</label>
				<input type="text" name="nom" id="nom" <?php if(!empty($_POST["nom"])) echo "value='{$_POST["nom"]}'";?> />
			</div>

			<div id="paysEnter" class="champs" style="margin-left: 150px;">
				<label for="pays">Pays : </label>
				<select id="pays" name="pays">
					<option>-- Choisissez un pays --</option>
					<?PHP
					while ($pays_bdd = $pays->fetch()) {
						if (!empty($_POST["pays"]) && $_POST["pays"]==$pays_bdd["libellePays"] && !empty($pays_bdd["libellePays"])) {
							echo "<option selected>{$_POST["pays"]}</option>";
						}
						elseif(!empty($pays_bdd["libellePays"])) {
							echo "<option>{$pays_bdd["libellePays"]}</option>";
						}
					}
					$pays->closeCursor();
					?>
				</select>
			</div>

			<div id="menuType" class="champs" style="margin-left: 150px;">
				<label for="ville">Ville : </label>
				<select id="ville" name="ville">
					<option>-- Choisissez une ville --</option>
					<?PHP
					while ($ville_bdd = $ville->fetch()) {
						if (!empty($_POST["ville"]) && $_POST["ville"]==$ville_bdd["libelleVille"]) {
							echo "<option selected>{$ville_bdd["libelleVille"]}</option>";
						}
						elseif(!empty($ville_bdd["libelleVille"])) {
							echo "<option>{$ville_bdd["libelleVille"]}</option>";
						}
					}
					$ville->closeCursor();
					?>
				</select>
			</div>
		<input type="image" id="submit" src="img/submit.png">
		</fieldset>
	</form>

	<?php
		if (!empty($_POST)){
			$pays = filter_var(htmlspecialchars($_POST['pays']), FILTER_SANITIZE_MAGIC_QUOTES);
			$ville = filter_var(htmlspecialchars($_POST['ville']), FILTER_SANITIZE_MAGIC_QUOTES);
			$nom = filter_var(htmlspecialchars($_POST["nom"]), FILTER_SANITIZE_MAGIC_QUOTES);
			$occ=0;
			if($pays=="-- Choisissez un pays --" && $ville=="-- Choisissez une ville --" && empty($nom)) {
				echo "<p class='typeRecherche'>Recherche sans critere</p>";
				$reponse = $bdd->query('SELECT * FROM Monument m join Ville v on v.idVille=m.idVille join Pays p on p.idPays=v.idPays order by m.libelleMonument asc');
			}
			else {
				echo "<p class='typeRecherche'>Recherche avec critere</p>";
				$erreur = False;
				$req="SELECT * FROM Monument m join Ville v on v.idVille=m.idVille join Pays p on p.idPays=v.idPays where 1";
				if($pays!="-- Choisissez un pays --"){
					$req.=" and p.libellePays=\"$pays\"";
				}
				if($ville!="-- Choisissez une ville --"){
					$req.=" and v.libelleVille=\"$ville\"";
				}
				$req.=" order by m.libelleMonument asc";
				$reponse = $bdd->query($req);
			}
		}
		else {
			echo "<p class='typeRecherche'>Aucune recherche spécifique</p>";
			$reponse = $bdd->query('SELECT * FROM Monument m join Ville v on v.idVille=m.idVille join Pays p on p.idPays=v.idPays order by m.libelleMonument asc');
		}
		echo "<div class='recherche_container'>";
		while ($donnees = $reponse->fetch()) {
			if(!empty($_POST["nom"])) {
				if(preg_match("/[<>'\"!?;]+/",$_POST["nom"])==0) {
					$test=strtolower($_POST["nom"]);
					if(preg_match("/$test/", strtolower($donnees['libelleMonument']))) {
						$occ++;
						echo "<div class='recherche_item'>
							<img src=\"img/".$donnees['header4000x2250']."\" alt=\"Image manquante\" class=\"img_item\"/>
							<div>
								<h1><a href='monument.php?monument={$donnees['idMonument']}'>{$donnees['libelleMonument']}</a></h1>
								<p>";
							echo $donnees['siecle'] . "</p>
							<p>".$donnees['libellePays']." / ".$donnees['libelleVille']."</p>
								</div>
							</div>";
					}
				}
				else {
					echo "Veuillez ne pas utiliser de caractères spéciaux";
				}
			}
			else {
				$occ++;
				echo "<div class='recherche_item'>
						<img src=\"img/".$donnees['header4000x2250']."\" alt=\"Image manquante\" class=\"img_item\"/>
						<div>
							<h1><a href='monument.php?monument={$donnees['idMonument']}'>{$donnees['libelleMonument']}</a></h1>
							<p>";
				echo $donnees['siecle'] . "</p>
				<p>".$donnees['libellePays']." / ".$donnees['libelleVille']."</p>
					</div>
				</div>";
			}
		}
		echo "<p class='nbRes'>$occ Résultats</p>";
		$reponse->closeCursor();
		echo "</div>";
	?>
	<footer class="bords">
		<p>&copy; Copyright Corobb</p>
	</footer>
	<?PHP include_once("fin_menu.php");?>
</body>
</html>
