<?php
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

		$getCat = $con->prepare("SELECT * FROM categories ORDER BY ID DESC");

		$getCat->execute();

		$cats = $getCat->fetchAll();

		return $cats;
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

			$link = 'Previuos Page';
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

		$statement->execute(array($select));

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

	function getLatest($select, $table, $order, $limit) {



		global $con;

		$getStmt3 = $con->prepare("SELECT $select FROM $table  ORDER BY $order DESC LIMIT $limit");

		$getStmt3->execute();

		$rows = $getStmt3->fetchAll();

		return $rows;


	}