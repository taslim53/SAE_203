<?php
   // deconnexion.php
    ini_set('display_errors', 1);
    error_reporting(E_ALL);

	session_start();
	session_destroy();
	$_SESSION = array();// créé un tableau VIDE (pour supprimer toutes les données lorsqu'on se déconnecte)

	header("Location: connexion.php");
?>