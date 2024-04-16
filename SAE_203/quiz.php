<?php
    // quiz.php
    ini_set('display_errors', 1);
    error_reporting(E_ALL);

	session_start();
	header("Content-Type: text/html; charset=utf-8") ;
	
	require (__DIR__ . "/param.inc.php");
	
	require (__DIR__ . "/src/Quiz/Administrer.php");
	
	$administrerMembres = new Quiz\Administrer(MYHOST, MYDB, MYUSER, MYPASS) ; 
	
	if(isset($_SESSION['id_membre']) AND $_SESSION['id_membre'] > 0) {

		$questions = $administrerMembres->obtenirQuestions() ;
		if(! isset($_SESSION["indice_question_derniere_reponse"])) {
			$_SESSION["indice_question_derniere_reponse"] = 0 ;
		}
		else {
			$indiceQuestionDerniereReponse = $_SESSION["indice_question_derniere_reponse"] ;
			$reponses = $administrerMembres->obtenirReponses($questions[$indiceQuestionDerniereReponse]["id_question"]) ;
			/*if(isset($_POST["id_reponse"])) {
				$id_reponse = $_POST["id_reponse"] ;
				if ($reponses[$                  ]["                     "]) {
					$score = $questions[$                               ]["                  "] ;
					$membre = $administrerMembres->mettreAJour($_SESSION["id_membre"], null , null, null, null, $score) ;
					$reponse_correcte =             ;
				}
				else {
					$reponse_correcte =              ;
				} 
			}*/
		//else {
				$_SESSION["indice_question_derniere_reponse"] = $_SESSION["indice_question_derniere_reponse"] + 1 ;                                                          
			//}
		}

		if (count($questions) == $_SESSION["indice_question_derniere_reponse"]) {
			header("Location: deconnexion.php");
		}
		else {
			$indiceQuestion = $_SESSION["indice_question_derniere_reponse"] ;

?><!DOCTYPE html>
<html lang="fr">
	<head>
		<title>TUTO PHP</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" >
		<link rel="stylesheet" href="styles.css" type="text/css" >
		<link rel="stylesheet" href="moodle.css" type="text/css" >
		<meta name="viewport" content="width=device-width, initial-scale=1.0" >
	</head>
	<body>
		<div role="main">
			<div>
			  $_GET : <?php echo(var_export($_GET)) ; ?>
			</div>
			<div>
			  $_POST : <?php echo(var_export($_POST)) ; ?>
			</div>
			<div>
			  $_SESSION : <?php echo(var_export($_SESSION)) ; ?>
			</div>
			<hr>	
			<form action="quiz.php" method="post">
				<div class="que multichoice adaptive notyetanswered">
					<div class="info">
						<h3 class="no">Question <span class="qno"><?php echo($indiceQuestion + 1) ;?></span></h3>
						<div class="grade">Noté sur <?php echo($questions[$indiceQuestion]["scoreBonneReponse"]) ;?></div>
					</div>
					<div class="content">
						<div class="formulation clearfix">
							<h4 class="accesshide">Texte de la question</h4>
							<div class="qtext">
								<p><?php echo($questions[$indiceQuestion]["titre"]) ;?></p>
							</div>
							<div class="ablock no-overflow visual-scroll-x">
								<div class="prompt">Veuillez choisir une réponse.</div>
								<div class="answer">
<?php 
	foreach($administrerMembres->obtenirReponses($questions[$indiceQuestion]["id_question"]) as $reponse) { 
?>
									<div class="r0">
										<input type="radio" name="id_reponse" value="" >
										<div class="d-flex w-auto">
											<div class="flex-fill ml-1">
												<p></p>
											</div>
										</div>
									</div>
<?php
	}
?>
								</div>

							</div>
<?php 
if(isset($id_reponse)) {
?>
							<div class="im-controls">
								<a href="quiz.php">
									<button class="submit btn btn-secondary">Suivant</button>
								</a>
							</div>
						</div>
<?php 
} else {
?>
							<div class="im-controls">
								<input type="submit" value="Vérifier" class="submit btn btn-secondary">
							</div>
						</div>
<?php 
}
if(isset($reponse_correcte)) {
?>
						<div class="outcome clearfix">
							<h4 class="accesshide">Feedback</h4>
<?php 
	if ($reponse_correcte) { ?>
							<div class="feedback">
								<div class="specificfeedback">
									<p>Votre réponse est correcte.</p>
								</div>
							</div>
							<div class="im-feedback">
								<div class="correctness badge correct">Correct</div>
								<div class="gradingdetails">En tenant compte des tentatives précédentes, cela donne <strong><?php echo($membre["score"]) ; ?></strong> points.</div>
							</div>
	<?php } else { ?>
							<div class="feedback">
								<div class="specificfeedback">
									<p>Votre réponse est incorrecte.</p>
								</div>
							</div>
							<div class="im-feedback">
								<div class="correctness badge incorrect">Incorrect</div>
							</div>
<?php 
	}
?>
						</div>
<?php 
}	
?>
					</div>
				</div>
			</form>
		</div>
	</body>
</html>
<?php
		}
	}
	else {
		header("Location: connexion.php") ;
	}
?>