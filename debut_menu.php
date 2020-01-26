<?php session_start(); ?>
<div id="page">
	<input type="checkbox"  id="button" name="button" />
	<label for="button"><i class="fas fa-bars"></i></label>
	<div class="contenu_menu">
		<a href="index.php"><img src="img/logo.png" alt="Image manquante !" style="padding-top: 10px;"/></a>
		<div class="links">
			<a href="index.php" class="lien"><i class="fas fa-home"></i> - Page d'accueil</a>
			<a href="recherche.php" class="lien"><i class="fas fa-monument"></i> - Liste des monuments</a>
			<a href="partir.php" class="lien"><i class="fas fa-map-marked-alt"></i> - Où partir ?</a>
			<a href="classement.php" class="lien"><i class="fas fa-star"></i> - Les meilleurs monuments</a>
			<a href="apropos.php" class="lien"><i class="far fa-question-circle"></i> - À propos</a>
			<?php 
				if(!empty($_SESSION)) {
					// USER CONNECTE
					echo "<a href='profile.php' class='lien'><i class='far fa-address-card'></i> - {$_SESSION["nickname"]}</a>";
					echo "<a href='chat.php' class='lien'><i class='far fa-envelope'></i> - Chatbox</a>";
					echo "<a href='deconnexion.php' class='lien'><i class='fas fa-sign-out-alt'></i> - Déconnexion</a>";
				}
				else {
					// USER NON CONNECTE
					echo "<a href='connexion.php' class='lien'><i class='fas fa-sign-in-alt'></i> - Connexion</a>";
					echo "<a href='inscription.php' class='lien'><i class='fas fa-plus-square'></i> - Inscription</a>";
				}
			?>
		</div>
	</div>
	<div class="contenu">
