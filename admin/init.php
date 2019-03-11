<?php
	
	include 'connect.php';		
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

	// Include Navbar On All Pages Expected The One With $noNavbar Variable
	if(!isset($noNavbar)){include $tpl . 'navbar.php';}
	

	
	
	



