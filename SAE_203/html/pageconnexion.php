<?php
    // connexion.php
    ini_set('display_errors', 1);
    error_reporting(E_ALL);

	session_start();
	header("Content-Type: text/html; charset=utf-8") ;
	
	require (__DIR__ . "/param.inc.php");
	
	require (__DIR__ . "/src/Membres/Administrer.php");
	
	$administrerMembres = new Membres\Administrer(MYHOST, MYDB, MYUSER, MYPASS) ; 
	if(isset($_POST['formconnexion'])) {
		try {
			$user = $administrerMembres->connecter($_POST['mailconnect'], $_POST['mdpconnect']) ;
			$_SESSION['id_membre'] = $user['id_membre'];
			$_SESSION['pseudo'] = $user['pseudo'];
			$_SESSION['mail'] = $user['mail'];
			header("Location: profil.php");
		} 
		catch (Exception $e) {
			$erreur = $e->getMessage() ;
		}
	}
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
			<h1>Connexion</h1>
			<form method="post" action="connexion.php">
				<div class="row">
					<input class="colspan-2" type="email" name="mailconnect" placeholder="Mail" aria-label="email" />
				</div>
				<div class="row">
					<input class="colspan-2" type="password" name="mdpconnect" placeholder="Mot de passe" aria-label="mot de passe"/>
				</div>
				<div class="row">
					<input class="colspan-2" type="submit" name="formconnexion" value="Se connecter !" />
				</div>
<?php
	if(isset($erreur)) {
?>
				<div class="row"></div>
					<p class="colspan-2 error"><?php echo($erreur) ; ?></p>
				</div>	
<?php
	}
?>
			</form>
		</main>
	</body>
</html>