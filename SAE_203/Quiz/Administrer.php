<?php

namespace Quiz;

use PDO;
use SplFileObject;
use Exception;

/**
 * Administrer
 */
class Administrer
{

	private $myHost;

	private $myDb;

	private $myUser;

	private $myPass;

	private $debug;

	/**
	 * Administrer
	 *
	 * @param string $myHost
	 * @param string $myDb
	 * @param string $myUser
	 * @param string $myPass
	 *
	 * @return Administrer
	 */
	function __construct($myHost = null, $myDb = null, $myUser = null, $myPass = null)
	{
		$this->myHost = $myHost;
		$this->myDb = $myDb;
		$this->myUser = $myUser;
		$this->myPass = $myPass;

		$this->debug = true;
	}

	/**
	 * Installer la base de données
	 *
	 * @return Administrer
	 */
	public function installerBaseDeDonnees()
	{
		try {
			// Etape 1 : connexion au serveur de base de données
			$pdo = new PDO("mysql:host=" . $this->myHost, $this->myUser, $this->myPass);
			$pdo->query("CREATE DATABASE IF NOT EXISTS " . $this->myDb . " DEFAULT CHARACTER SET utf8 COLLATE utf8_bin");
			$pdo = null;
			$pdo = new PDO("mysql:host=" . $this->myHost . ";dbname=" . $this->myDb, $this->myUser, $this->myPass);
			$pdo->query("SET NAMES utf8");
			$pdo->query("SET CHARACTER SET 'utf8'");
			$pdo->query("SET SESSION sql_mode=(SELECT REPLACE(@@sql_mode,'STRICT_TRANS_TABLES',''))");
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			$mdp = sha1("test");

			//score INT DEFAULT 0 = par défaut le score est de zéro
			//tableau membre déjà créé (id - pseudo - mail -mdp - âge - score...)
			//tableau réponse et tableau question créées

			$requetesSQL = <<<EOF
			DROP TABLE IF EXISTS membre ;
			DROP TABLE IF EXISTS question ;
			DROP TABLE IF EXISTS reponse ;
			CREATE TABLE membre (
				id_membre INT NOT NULL AUTO_INCREMENT,
				pseudo VARCHAR(255), 
				mail VARCHAR(255),
				motdepasse TEXT, 
				age INT,
				score INT DEFAULT 0,
					PRIMARY KEY(id_membre) ) ;
			CREATE TABLE question (
				id_question INT NOT NULL AUTO_INCREMENT,
				titre VARCHAR(250), 
				scoreBonneReponse INT,
					PRIMARY KEY(id_question) ) ;
			CREATE TABLE reponse (
				id_reponse INT NOT NULL AUTO_INCREMENT,
				id_question INT NOT NULL,
				texte VARCHAR(255), 
				bonneReponse BOOLEAN,
					PRIMARY KEY(id_reponse,id_question) ) ;
			INSERT INTO question VALUES (1, 'Une page serveur peut fixer la durée de vie d’une session à 5 ans ?', 2) ;
			INSERT INTO reponse VALUES (1, 1, 'Vrai', true) ;
			INSERT INTO reponse VALUES (2, 1, 'Faux', false) ;
			INSERT INTO reponse VALUES (3, 1, 'Je ne sais pas', false) ;
			INSERT INTO question VALUES (2, 'En désactivant les cookies de votre navigateur, il n\'est plus possible d\'échanger des données entre les pages consultées.', 2) ;
			INSERT INTO reponse VALUES (4, 2, 'Vrai', false) ;
			INSERT INTO reponse VALUES (5, 2, 'Faux', true) ;
			INSERT INTO reponse VALUES (6, 2, 'Je ne sais pas', false) ;
			INSERT INTO question VALUES (3, 'Pour gérer l’authentification de l’utilisateur du site à concevoir pour la SAÉ203, j\'utilise systématiquement dans le code de mes pages serveur en php ….', 4) ;
			INSERT INTO reponse VALUES (7, 3, 'la variable \$_SESSION', true) ;
			INSERT INTO reponse VALUES (8, 3, 'du code en JavaScript', false) ;
			INSERT INTO reponse VALUES (9, 3, 'la classe SplFileObject', false) ;

EOF;
			$tabRequetesSQL = explode(";", $requetesSQL);
			foreach ($tabRequetesSQL as $requeteSQL) {
				if (trim($requeteSQL) != "") {
					$pdo->query($requeteSQL);
				}
			}

			// Etape 4 : ferme la connexion au serveur de base de données
			$pdo = null;
		} catch (Exception $e) {
			if ($this->debug) {
				echo ($e->getMessage());
			}
		}

		return $this;
	}

	/**
	 * Inscrire un nouveau membre
	 *
	 * @param string $pseudo
	 * @param string $mail
	 * @param string $mdp
	 *            
	 * @exception string
	 */
	public function inscrire($pseudo, $mail, $mdp)
	{
		$erreur = "";
		if (
			!empty($pseudo)
			and !empty($mail)
			and !empty($mdp)
		) {
			$pseudo = htmlspecialchars($pseudo);
			$mail = htmlspecialchars($mail);
			$mdp_not_crypt = $mdp;
			$mdp = sha1($mdp);
			// Etape 1 : connexion au serveur de base de données
			$pdo = new PDO("mysql:host=" . $this->myHost . ";dbname=" . $this->myDb, $this->myUser, $this->myPass);
			$pdo->query("SET NAMES utf8");
			$pdo->query("SET CHARACTER SET 'utf8'");
			$pdo->query("SET SESSION sql_mode=(SELECT REPLACE(@@sql_mode,'STRICT_TRANS_TABLES',''))");
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			$pseudolength = mb_strlen($pseudo);
			if ($pseudolength <= 255) {
				if (filter_var($mail, FILTER_VALIDATE_EMAIL)) {
					$reqmail = $pdo->prepare("SELECT * FROM membre WHERE mail = ?");
					$reqmail->execute(array($mail));
					$ligne = $reqmail->fetch(PDO::FETCH_ASSOC);
					if ($ligne == false) {
						if (mb_strlen($mdp_not_crypt) >= 4) {
							// Etape 2 : envoi de la requête SQL au serveur
							$statement = $pdo->prepare("INSERT INTO membre(pseudo, mail, motdepasse) VALUES(?, ?, ?)");
							$statement->execute(array($pseudo, $mail, $mdp));
						} else {
							$erreur = "Votre mot de passe doit posséder au moins 4 caractères !";
						}
					} else {
						$erreur = "Adresse mail déjà utilisée !";
					}
				} else {
					$erreur = "Votre adresse mail n'est pas valide !";
				}
			} else {
				$erreur = "Votre pseudo ne doit pas dépasser 255 caractères !";
			}
			// Etape 4 : ferme la connexion au serveur de base de données
			$pdo = null;
		} else {
			$erreur = "Tous les champs doivent être complétés !";
		}
		if ($erreur != "") {
			throw new Exception($erreur);
		}
	}

	/**
	 * Connecter un nouveau membre
	 *
	 * @param string $mailconnect
	 * @param string $mdpconnect
	 *            
	 * @exception string
	 * @return array $user (tableau associatif) ou null
	 */
	public function connecter($mailconnect, $mdpconnect)
	{
		$erreur = "";
		$user = null;
		if (
			!empty($mailconnect)
			and !empty($mdpconnect)
		) {
			$mailconnect = htmlspecialchars($mailconnect);
			$mdpconnect = sha1($mdpconnect);
			// Etape 1 : connexion au serveur de base de données
			$pdo = new PDO("mysql:host=" . $this->myHost . ";dbname=" . $this->myDb, $this->myUser, $this->myPass);
			$pdo->query("SET NAMES utf8");
			$pdo->query("SET CHARACTER SET 'utf8'");
			$pdo->query("SET SESSION sql_mode=(SELECT REPLACE(@@sql_mode,'STRICT_TRANS_TABLES',''))");
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			// Etape 2 : envoi de la requête SQL au serveur
			$statement = $pdo->prepare("SELECT id_membre, pseudo, mail FROM membre WHERE mail = ? AND motdepasse = ?");
			$statement->execute(array($mailconnect, $mdpconnect));
			$user = $statement->fetch(PDO::FETCH_ASSOC);
			if ($user == false) {
				$erreur = "Mauvais mail ou mot de passe !";
				$user = null;
			}
			// Etape 4 : ferme la connexion au serveur de base de données
			$pdo = null;
		} else {
			$erreur = "Tous les champs doivent être complétés !";
		}

		if ($erreur != "") {
			throw new Exception($erreur);
		}

		return $user;
	}

	/**
	 * Obtenir un membre
	 *
	 * @param int $id (identifiant du membre)
	 *
	 * @return array $user (tableau associatif) ou null
	 */
	public function obtenirMembre($id = null)
	{
		$user = null;
		if ($id != null) {
			// Etape 1 : connexion au serveur de base de données
			$pdo = new PDO("mysql:host=" . $this->myHost . ";dbname=" . $this->myDb, $this->myUser, $this->myPass);
			$pdo->query("SET NAMES utf8");
			$pdo->query("SET CHARACTER SET 'utf8'");
			$pdo->query("SET SESSION sql_mode=(SELECT REPLACE(@@sql_mode,'STRICT_TRANS_TABLES',''))");
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			// Etape 2 : envoi de la requête SQL au serveur
			$statement = $pdo->prepare("SELECT * FROM membre WHERE id_membre = ?");
			$statement->execute(array($id));
			// Etape 3 : récupère les données
			$user = $statement->fetch(PDO::FETCH_ASSOC);
			if ($user == false) {
				$user = null;
			}
			// Etape 4 : ferme la connexion au serveur de base de données
			$pdo = null;
		}
		return $user;
	}

	/**
	 * Mettre à jour l'un des membres
	 *
	 * @param int $id (identifiant du membre)
	 * @param string $newpseudo
	 * @param string $newmail
	 * @param string $newmdp
	 * @param int $newage
	 * @param int $score
	 *
	 * @exception string
	 * @return array $user (tableau associatif) ou null
	 */
	public function mettreAJour($id = null, $newpseudo = null, $newmail = null, $newmdp = null, $newage = null, $score = 0)
	{
		$erreur = "Aucune modification !";
		if ($id != null) {
			$user = $this->obtenirMembre($id);
			$erreur = "";

			// Etape 1 : connexion au serveur de base de données
			$pdo = new PDO("mysql:host=" . $this->myHost . ";dbname=" . $this->myDb, $this->myUser, $this->myPass);
			$pdo->query("SET NAMES utf8");
			$pdo->query("SET CHARACTER SET 'utf8'");
			$pdo->query("SET SESSION sql_mode=(SELECT REPLACE(@@sql_mode,'STRICT_TRANS_TABLES',''))");
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			if (isset($newpseudo) and !empty($newpseudo) and $newpseudo != $user['pseudo']) {
				$newpseudo = htmlspecialchars($newpseudo);
				$pseudolength = mb_strlen($newpseudo);
				if ($pseudolength <= 255) {
					$statement = $pdo->prepare("UPDATE membre SET pseudo = ? WHERE id_membre = ?");
					$statement->execute(array($newpseudo, $id));
				} else {
					$erreur = $erreur . "<div>Votre pseudo ne doit pas dépasser 255 caractères !</div>";
				}
			}
			if (isset($newmail) and !empty($newmail) and $newmail != $user['mail']) {
				$newmail = htmlspecialchars($newmail);
				if (filter_var($newmail, FILTER_VALIDATE_EMAIL)) {
					$statement = $pdo->prepare("UPDATE membre SET mail = ? WHERE id_membre = ?");
					$statement->execute(array($newmail, $id));
				} else {
					$erreur = $erreur . "<div>Votre adresse mail n'est pas valide !</div>";
				}
			}
			if (isset($newmdp) and !empty($newmdp)) {
				if (mb_strlen($newmdp) >= 4) {
					$newmdp = sha1($newmdp);
					$statement = $pdo->prepare("UPDATE membre SET motdepasse = ? WHERE id_membre = ?");
					$statement->execute(array($newmdp, $id));
				} else {
					$erreur = $erreur . "<div>Votre mot de passe doit posséder au moins 4 caractères !</div>";
				}
			}
			if (isset($newage) and !empty($newage)) {
				if ($newage >= 0 && $newage <= 150) {
					$statement = $pdo->prepare("UPDATE membre SET age = ? WHERE id_membre = ?");
					$statement->execute(array($newage, $id));
				} else {
					$erreur = $erreur . "<div>Votre age n'est pas correct !</div>";
				}
			}

			// remplir cette méthode
			if (isset($score) and ($score != 0)) {
				if (is_numeric($score)) {
					$statement = $pdo->prepare("UPDATE membre SET score = ? WHERE id_membre = ?");
					$statement->execute(array($score, $id));
				}
			}


			// Etape 4 : ferme la connexion au serveur de base de données
			$pdo = null;
		}
		if ($erreur != "") {
			throw new Exception($erreur);
		}

		return $this->obtenirMembre($id); // Utilisateur avec les données mises à jour
	}

	/**
	 * Obtenir questions
	 *
	 * @return array $questions (tableau indicé) ou (tableau vide)
	 */
	public function obtenirQuestions()
	{
		$questions = array();
		// Etape 1 : connexion au serveur de base de données
		$pdo = new PDO("mysql:host=" . $this->myHost . ";dbname=" . $this->myDb, $this->myUser, $this->myPass);
		$pdo->query("SET NAMES utf8");
		$pdo->query("SET CHARACTER SET 'utf8'");
		$pdo->query("SET SESSION sql_mode=(SELECT REPLACE(@@sql_mode,'STRICT_TRANS_TABLES',''))");
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		// Etape 2 : envoi de la requête SQL au serveur
		$statement = $pdo->prepare(" SELECT * FROM question");
		// eloise : * = on sélectionne toutes les colonnes de "question" dans phpadmin + ajouter "where quiz = nom de la langue")
		$statement->execute(array());
		// Etape 3 : récupère les données
		$ligne = $statement->fetch(PDO::FETCH_ASSOC);
		while ($ligne != false) {

			// trois questions 

			$questions[] =  $ligne; //ajoute une nouvelle question à la fin du tableau
			$ligne = $statement->fetch(PDO::FETCH_ASSOC);
		}
		// Etape 4 : ferme la connexion au serveur de base de données
		$pdo = null;
		return $questions;
	}

	/**
	 * Obtenir reponses
	 *
	 * @param int $id (identifiant de la question)
	 *
	 * @return array $reponses (tableau indicé avec l'id_reponse) ou (tableau vide)
	 */
	public function obtenirReponses($id = null)
	{
		$reponses = array();
		if ($id != null) {
			// Etape 1 : connexion au serveur de base de données
			$pdo = new PDO("mysql:host=" . $this->myHost . ";dbname=" . $this->myDb, $this->myUser, $this->myPass);
			$pdo->query("SET NAMES utf8");
			$pdo->query("SET CHARACTER SET 'utf8'");
			$pdo->query("SET SESSION sql_mode=(SELECT REPLACE(@@sql_mode,'STRICT_TRANS_TABLES',''))");
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			// Etape 2 : envoi de la requête SQL au serveur
			$statement = $pdo->prepare("SELECT * FROM reponse WHERE id_question = ?");
			$statement->execute(array($id));
			// Etape 3 : récupère les données
			$ligne = $statement->fetch(PDO::FETCH_ASSOC);
			while ($ligne != false) {
				$reponses[$ligne["id_reponse"]] = $ligne; //ajoute une nouvelle réponse dans le tableau
				$ligne = $statement->fetch(PDO::FETCH_ASSOC);
			}
			// Etape 4 : ferme la connexion au serveur de base de données
			$pdo = null;
		}
		return $reponses;
	}
}
