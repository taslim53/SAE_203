<?php
    // inscription.php
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
	header("Content-Type: text/html; charset=utf-8") ;
	
	require (__DIR__ . "/param.inc.php");
	
	require (__DIR__ . "/src/Membres/Administrer.php");
	
	$administrerMembres = new Membres\Administrer(MYHOST, MYDB, MYUSER, MYPASS) ;
	
	if(isset($_POST['forminscription'])) {
		if(!empty($_POST['pseudo']) 
			AND !empty($_POST['mail']) 
			AND !empty($_POST['mail2']) 
			AND !empty($_POST['mdp']) 
			AND !empty($_POST['mdp2'])) {
			$pseudo = htmlspecialchars($_POST['pseudo']);
			$mail = htmlspecialchars($_POST['mail']);
			$mail2 = htmlspecialchars($_POST['mail2']);
			$mdp = $_POST['mdp'];
			$mdp2 = $_POST['mdp2'];

			if($mail == $mail2) {
				if($mdp == $mdp2) {
					if(strlen($mdp)>= 4) {
						try {
							$administrerMembres->inscrire($pseudo, $mail, $mdp) ;
						}
						catch (Exception $e) {
							$erreur = $e->getMessage() ;
						}
					} else {
						$erreur = "Votre mot de passe doit posséder au moins 4 caractères !";
					}
				} else {
					$erreur = "Vos mots de passes ne correspondent pas !";
				}
			} else {
				$erreur = "Vos adresses mail ne correspondent pas !";
			}
		} else {
			$erreur = "Tous les champs doivent être complétés !";
		}
	}
?>
<!DOCTYPE html>
<html lang="fr">
	<head>
		<title>TUTO PHP</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" href="styles.css" type="text/css" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
	</head>
	<body>
		<main>
			<h1>Inscription</h1>
			<form method="post" action="inscription.php">
				<div class="row">
					<label for="pseudo">Pseudo :</label>
					<input type="text" placeholder="Votre pseudo" id="pseudo" name="pseudo" value="<?php if(isset($_POST['pseudo'])) { echo (htmlspecialchars($_POST['pseudo'])); } ?>" />
				</div>
				<div class="row">
					<label for="mail">Mail :</label>
					<input type="email" placeholder="Votre mail" id="mail" name="mail" value="<?php if(isset($_POST['mail'])) { echo (htmlspecialchars($_POST['mail'])); } ?>" />
				</div>
				<div class="row">
					<label for="mail2">Confirmation du mail :</label>
					<input type="email" placeholder="Confirmez votre mail" id="mail2" name="mail2" value="<?php if(isset($_POST['mail2'])) { echo (htmlspecialchars($_POST['mail2'])); } ?>" />
				</div>
				<div class="row">
					<label for="mdp">Mot de passe :</label>
					<input type="password" placeholder="Votre mot de passe" id="mdp" name="mdp" />
				</div>
				<div class="row">
					<label for="mdp2">Confirmation du mot de passe :</label>
					<input type="password" placeholder="Confirmez votre mdp" id="mdp2" name="mdp2" />
				</div>
				<div class="row">
					<input class="colspan-2" type="submit" name="forminscription" value="Je m'inscris" />
				</div>
<?php
	if(isset($_POST['forminscription'])) {
		if(isset($erreur)) {
?>
				<div class="row">
					<p class="colspan-2 error"><?php echo($erreur) ; ?></p>
				</div>
<?php
		} 
		else {
?>
				<div class="row">
					<p class="colspan-2">Votre compte a bien été créé !</p>
				</div>					
<?php
		}
	}
?>
				<div class="row">
					<a class="colspan-2" href="connexion.php">Me connecter</a>
				</div>
			</form>
		</main>
	</body>
</html>