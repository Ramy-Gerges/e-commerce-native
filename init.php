<?php

	// Error Reporting

	ini_set('display_errors', 'On');
	error_reporting(E_ALL);


	
	include 'admin/connect.php';

	$sessionUser = '';


	if(isset($_SESSION['user'])) {

		$sessionUser = $_SESSION['user'];
	}		
	// Routes

	$tpl = 'includes/templates/'; // Temaplate Directory
	$css = 'layout/css/'; // Css Directory
	$js = 'layout/js/'; // Js Directory
	$func = 'includes/functions/'; // Functions Directory
	$lang = 'includes/languages/'; // Language Directory

	// Include The Important Files

	include $lang . 'english.php';
	include $func . 'functions.php';
	include $tpl . 'header.php';




	



