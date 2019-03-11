<?php
		/*
		** Get All function v1.0
		** Function to Get all Records From Any Database Table
		*/
		function getAllFrom($field, $table, $where = NULL, $and = NULL, $orderfield, $ordering = "DESC") {

		global $con;

		$getAll = $con->prepare("SELECT $field FROM $table $where $and ORDER BY $orderfield $ordering");

		$getAll->execute();

		$all = $getAll->fetchAll();

		return $all;
	}






		/*

		** Function To Get Categories From Database

		*/

		function getCat() {

		global $con;

		$getCat = $con->prepare("SELECT * FROM categories ORDER BY ID ASC");

		$getCat->execute();

		$cats = $getCat->fetchAll();

		return $cats;
	}


	/*

		** Function To Get items AD From Database

		*/

		function getItems($where, $value, $approve = NULL) {

		global $con;


		if ($approve == NULL) {

			$sql = 'AND approve = 1';
		} else {

			$sql = NULL;
		}

		$getItems = $con->prepare("SELECT * FROM items WHERE $where = ? $sql ORDER BY items_ID DESC");

		$getItems->execute(array($value));

		$items = $getItems->fetchAll();

		return $items;
	}

	/* Check If User Is Not Activated, Function To CHeck The Regstatus Of The User */

	function checkUserStatus($user) {

		global $con;

		$stmtx = $con->prepare("SELECT Username, RegStatus FROM users WHERE Username =  ? AND RegStatus =  0");
		$stmtx->execute(array($user));

		$status = $stmtx->rowCount();

		return $status;
	}


	function getTitle() {
		global $pageTitle;

		if(isset($pageTitle)) {
			
			echo $pageTitle;
		} else {
			echo 'Default';
		}
	}


/* Redirect Functuin [This Function Accept Parameters] */



function redirectHome($theMsg, $url = null, $seconds = 3) {

	if($url === null) {

		$url = 'index.php';

		$link = 'Homepage';
	} else {

		if(isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] !== '') {

			$url = $_SERVER['HTTP_REFERER'];

			$link = 'Previos Page';
		} else {

			$url = 'index.php';

			$link = 'HomePage';
		}

		
	
	}

	echo $theMsg;

	echo "<div class='alert alert-info'>You Will Be Reidrected to $link After $seconds Seconds</div>";

	header("refresh:$seconds;url=$url");

	exit();


	}


	function checkItem($select, $from, $value) {

		global $con;

		$statement = $con->prepare("SELECT $select FROM $from WHERE $select = ?");

		$statement->execute(array($value));

		$count = $statement->rowCount();

		return $count;
	}



	/*
	** Count Number Of Items v1.0
	** Function To Count Number Of Items Rows
	** $item = The Item To Count
	** $table = The Table To Choose From
	*/

	function countItems($item, $table) { 

	global $con;

	$stmt2 = $con->prepare("SELECT COUNT($item) FROM $table");

		$stmt2->execute();

		return $stmt2->fetchColumn();
	}


	/*
	** Get Latest Records Function v1.0
	** Function To Get Latest Items From Database [Users, Items, Comments]
	*/
	function getLatest($select, $table, $order, $limit = 5 ) {

		global $con;

		$getStmt = $con->prepare("SELECT $select FROM $table ORDER BY $order DESC LIMIT $limit");

		$getStmt->execute();

		$rows = $getStmt->fetchAll();

		return $rows;
	}