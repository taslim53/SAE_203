<?php
    ini_set('display_errors', 1);
    error_reporting(E_ALL);

	session_start();
	header("Content-Type: text/html; charset=utf-8") ;
	
	require (__DIR__ . "/param.inc.php");
	
	require (__DIR__ . "/src/Membres/Administrer.php");
	
	$administrerMembres = new Membres\Administrer(MYHOST, MYDB, MYUSER, MYPASS) ; 

    //coller partie galerie du portfolio (csv avec $tab 1, 2, 3...)
    