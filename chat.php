<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Test chat</title>
	<link rel="stylesheet" type="text/css" href="css/style_login.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<?php include_once("style_menu_awesome.php");?>
</head>
<body>
	<?php include_once("debut_menu.php");?>
	<header class="bords">
		<h1>ChatBox</h1>
	</header>
	<form method="post" action="">
		<p>
			<label for="message">Message : </label>
			<input type="text" name="message" id="message"/>
		</p>
		<input type="submit" name="Envoyer" value="Envoyer"/>
	</form>
		<?php
		try{
			$bdd = new PDO('mysql:host=-;dbname=-;charset=utf8', '-', '-');
		} catch (Exception $e) {
		        die('Problème de connexion à la base de donnée');
		}
		if (!empty($_POST['message'])) {
			$bdd->exec("insert into Message(idCompte, message) values (". $_SESSION['idCompte'] . ", \"" . filter_var(htmlspecialchars($_POST['message']), FILTER_SANITIZE_MAGIC_QUOTES) . "\")");
			header("location: chat.php");
		}
		?>

		<div id="messages" style="height: 74vh; padding: 2em; overflow: hidden;">
		<?php
		$i = 0;
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
			echo $affiche[$j]['nickname'] . " (";
			$donnees['Date'] = $affiche[$j]['Date'];
			include("affichedate.php");
			echo ") : " . $affiche[$j]['message'] . "<br/>";
		}
		?>
	</div>
	<footer>Copyright</footer>
	<?php include_once("fin_menu.php");?>
	<script>
		setInterval('load_messages()', 1);
		function load_messages() {
			$('#messages').load("load-message.php");
		}
	</script>
</body>
</html>
