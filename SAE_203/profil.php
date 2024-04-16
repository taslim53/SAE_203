<?php
   // profil.php
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
	session_start();
	header("Content-Type: text/html; charset=utf-8") ;
	 
	if(isset($_SESSION['id_membre']) AND $_SESSION['id_membre'] > 0) {
		unset($_SESSION["indice_question_derniere_reponse"]) ; // Redémarrer au début du quiz
?><!DOCTYPE html>
<html lang="fr">
	<head>
		<title>TUTO PHP</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" >
		<link rel="stylesheet" href="styles.css" type="text/css" >
		<meta name="viewport" content="width=device-width, initial-scale=1.0" >
	</head>
	<body>
		<main>
			<h1>Profil de <?php echo($_SESSION['pseudo']); ?></h1>
			<div class="profil">
				<p>Pseudo = <?php echo ($_SESSION['pseudo']); ?></p>
				<p>Mail = <?php echo ($_SESSION['mail']); ?></p>
				<a href="quiz.php">Faire le quiz</a>
				<a href="editionprofil.php">Editer mon profil</a>
				<a href="deconnexion.php">Se déconnecter</a>
			</div>
		</main>
	</body>
</html>
<?php   
	}
	else {
		header("Location: connexion.php") ;
	}
?>