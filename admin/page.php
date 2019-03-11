<?php
	$do = '';

	if(isset($_GET['do'])) {

		$do = $_GET['do'];
	} else {

		$do = 'Manage';
	}

	echo $do;


	// If the Page Is Main Page

	if($do == 'Manage') {
		echo'Welcome You Are In Manage Category Page';
	} elseif($do == 'Add') {
		echo 'You Are In Add Category Page';
	} elseif($do =='Insert') {
		echo'Welcome You Are In Insert Category Page';
	}
	 else {
		echo 'Error There Is No page With This Name';
	}





