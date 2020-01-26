<div id="champsCom">
	<form action="" method="post">
		<p id="etoiles">
			Note :
			<input type="radio" name="note" id="note1" value="1" <?php if(!empty($_POST["note"]) && $_POST["note"]==1) echo " checked "; ?> />
			<input type="radio" name="note" id="note2" value="2" <?php if(!empty($_POST["note"]) && $_POST["note"]==2) echo " checked "; ?>/>
			<input type="radio" name="note" id="note3" value="3" <?php if(!empty($_POST["note"]) && $_POST["note"]==3) echo " checked "; ?>/>
			<input type="radio" name="note" id="note4" value="4" <?php if(!empty($_POST["note"]) && $_POST["note"]==4) echo " checked "; ?>/>
			<input type="radio" name="note" id="note5" value="5" <?php if(!empty($_POST["note"]) && $_POST["note"]==5) echo " checked "; ?>/>
			<label for="note1" class="note1 note2 note3 note4 note5"><i class="far fa-star"></i></label>
			<label for="note2" class="note1 note2 note3 note4"><i class="far fa-star"></i></label>
			<label for="note3" class="note1 note2 note3"><i class="far fa-star"></i></label>
			<label for="note4" class="note1 note2"><i class="far fa-star"></i></label>
			<label for="note5" class="note1"><i class="far fa-star"></i></label>
		</p>
		<p id="p_com">
			<label id="labelCommentaire" class="commentaire" for="inputCom">Commentaire :</label>
			<textarea id="inputCom" name="commentaire" class="commentaire" placeholder="Commentaire..."><?php if(!empty($_POST["commentaire"])) echo $_POST["commentaire"];?></textarea>
		</p>
		<input type="submit" value="Envoyer" />
	</form>
</div>
<?php 
if(!empty($_POST)) {
	// Formulaire de commentaire soumis
	if(isset($_POST["note"]) && !empty($_POST["commentaire"])) {
		try{
			$bdd = new PDO('mysql:host=localhost;dbname=-;charset=utf8', '-', '-');
		} catch (Exception $e) {
		        die('Problème de connexion à la base de donnée');
		}
		if(preg_match("/\bpute\b|\bsalope\b|\bputain\b|\bencule\b|\bconnard\b|\bnique\b|\bbaise\b|\bmerde\b|\bcul\b|\bbatard\b|\bconnasse\b|\benfoire\b|\bcaca\b|\bbordel\b|\bcon\b|\bhitler\b/i", $_POST["commentaire"])==0 && preg_match("/^(')|(\")/", $_POST["commentaire"])==0) {
			if (preg_match("/[<>\"()=]+/", $_POST["commentaire"])==0) {
				if(strlen($_POST["commentaire"]<=150)) {
					$idCompte=$_SESSION["idCompte"];
					$bdd->exec("INSERT INTO Commentaire(idMonument, idCompte, note, commentaire) VALUES ($monument,$idCompte,{$_POST["note"]},\"" . filter_var(htmlspecialchars($_POST["commentaire"]), FILTER_SANITIZE_MAGIC_QUOTES) . "\");");
					echo "<p class='valid'>Avis envoyé !</p>";
				}
				else {
					echo "<p class='error'>Votre avis ne peut dépasser 150 charactères</p>";
				}
			}
			else {
				echo "<p class='error'>Problème lors de l'envoi de votre avis, veuillez ne pas utiliser de caractère spéciaux</p>";
			}
		}
		else {
			echo "<p class='error'>Problème lors de l'envoi de votre avis, veuillez utiliser un vocabulaire adéquat !</p>";
		}
	}
	else {
		echo "<p>Veuillez remplir tous les champs</p>";
	}
}
?>

