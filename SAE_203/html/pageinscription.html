<?php


// possibilement renommer page index (vu que c'est la page sur laquelle on atterrit en arrivant sur le site)


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
<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
header("Content-type: text/html; charset=utf-8");
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page d'inscription</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta name="description" content="Application pour décourire des langues">
    <script src="scripts/index.js"></script>
    <link rel="stylesheet" href="../css/pageinscription.css" type="text/css">
</head>
</head>

<body>
    <section id="inscription" class="inscription">
        <div class="container">
            <div class="title">
                <!--     <h6>Venez faire partie de l'équipe !</h6>-->
                <h1>Envie de découvrir le monde ?</h1>
                <h2>Inscrivez-vous !</h2>
                <!--   <h6>N'hésitez pas à me contacter et je vous répondrais dans les plus brefs délais.</h6>-->
            </div>
            <form action="./index.php" method="get">
                <fieldset>
                <div class="form-column">
                    <label for="pseudo">Pseudo :</label>
                    <input minlength="3" pattern="^[A-Za-z]+[\d\p{L}]{2,}" id="pseudo" type="text" name="pseudo" placeholder="Entrer votre pseudo" title="Le format attendu est de minimum 3 caractères" required="">
                </div>
                <div class="form-column">
                    <label for="datNais">Date de naissance :</label>
                    <input id="dateNais" type="date" name="dateNais" max="2012-01-01" placeholder="Entrer votre date de naissance" title="L'âge autorisé est de minimum 12 ans" required="">
                </div>
                <div class="form-column">
                    <label for="message">Adresse mail :</label>
                    <input id="email" type="email" name="email" placeholder="Entrer votre adresse mail"></input>
                </div>
                <div class="form-column">
                    <label for="mdp1">Ton mot de passe :</label>
                    <input minlength="8" pattern="[A-a-\d]" id="mdp1" type="password" name="mdp1" pattern="(?=.*\p{Lu}.*)(?=.*\p{L1})(?=.*\d.*){8,}" placeholder="Entrer votre adresse mail"></input>
                </div>
                <div class="form-column">
                    <label for="mdp2">Confirme ton mot de passe :</label>
                    <input id="mdp2" pattern="(?=^.*\p{Lu}.*)(?=^.*\p{L1}.*)(?=^.*\d.*)(?=^.*{8,})" type="password" name="mdp2" placeholder="Retpe ton mot de passe"></input>
                </div>
                </fieldset>

                <button type="submit">Envoyer</button>
            </form>
        </div>
    </section>

</body>

</html>