<?php
   // profil.php
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
	session_start();
	header("Content-Type: text/html; charset=utf-8") ;
	 
	if(isset($_SESSION['id_membre']) AND $_SESSION['id_membre'] > 0) {
?><!DOCTYPE html>
<html lang="fr">
	<head>
		<title>TUTO PHP</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" href="styles.css" type="text/css" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
	</head>
	<body>
		<main>
			<h1>Profil de <?php echo($_SESSION["pseudo"]); ?></h1>
			<div class="colspan-2">
				<p>Pseudo = <?php echo($_SESSION["pseudo"]); ?></p>
				<p>Mail = <?php echo($_SESSION["mail"]); ?></p>
				<a href="editionprofil.php">Editer mon profil</a>
				<a href="deconnexion.php">Se déconnecter</a>
			</div>
		</main>
	</body>
</html>
<?php   
	} else {
		header("Location: connexion.php");
	}
?>