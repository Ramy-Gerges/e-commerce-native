<?php

	session_start(); //Start The Session

	session_unset();

	session_destroy(); // Destroy The Session

	header('Location: index.php');

	exit();
	