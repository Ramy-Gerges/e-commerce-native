<?php


	ob_start();

	session_start();

	$pageTitle = 'Items';

	if(isset($_SESSION['Username'])) {

		include 'init.php';

		$do = isset($_GET['do']) ? $_GET['do'] : 'Manage';


		if($do == 'Manage') {
			$stmt = $con->prepare("SELECT items.*, categories.Name AS category_Name, users.Username FROM items INNER JOIN categories ON categories.ID = items.Cat_ID INNER JOIN users ON users.UserID = items.Member_ID ORDER BY items_ID DESC ");

			$stmt->execute();

			$items = $stmt->fetchAll();

			if(! empty($items)) { 

			?>

			<h1 class="text-center">Manage Items</h1>
			<div class="container">
				<div class="table-responsive">
					<table class="table main-table text-center table-bordered">
						<tr>
							<td>#ID</td>
							<td>Name</td>
							<td>Description</td>
							<td>price</td>
							<td>Adding Date</td>
							<td>Category</td>
							<td>Username</td>
							<td>Control</td>
						</tr>
		

						<tr>
							<?php
								foreach($items as $item) {

									echo "<tr>";
										echo "<td>" . $item['items_ID'] . "</td>";
										echo "<td>" . $item['Name'] . "</td>";
										echo "<td>" . $item['Description'] . "</td>";
										echo "<td>" . $item['Price'] . "</td>";
										echo "<td>" . $item['Add_Date'] . "</td>";
										echo "<td>" . $item['category_Name'] . "</td>";
										echo "<td>" . $item['Username'] . "</td>";
										echo "<td>
												<a href='items.php?do=Edit&itemid=" . $item['items_ID'] . "  ' class='btn btn-success'><i class='fa fa-edit'></i>Edit</a>
												<a href='items.php?do=Delete&itemid=" . $item['items_ID'] . "' class='btn btn-danger confirm'><i class='fa fa-close'></i> Delete </a>";
												if($item['Approve'] == 0) {
													echo "<a href='items.php?do=Approve&itemid=" . $item['items_ID'] . "  'class='btn btn-info activate'><i class='fa fa-check'></i>Approve</a>";

												}
												
											echo "</td>";
									echo "</tr>";
								}

							?>
							</tr>
						</tr>
					</table>
				</div>
				<a href="items.php?do=Add" class="btn btn-primary"><i class="fa fa-plus"></i> Add New item</a>	
			</div>

			<?php } else {

				echo '<div class="container">';
					echo '<div class="alert alert-info">There Is No Items To Show</div>';
					echo '<a href="items.php?do=Add" class="btn btn-primary"><i class="fa fa-plus"></i> Add New Items</a>';
				echo '</div>';
				
				


			}?>


		<?php

		} elseif ($do == 'Add') { ?>
			<h1 class="text-center">Add New Item</h1>
					<div class="container">
						<form class="form-horizontal" action="?do=Insert" method="POST">
							<!-- Start Name Field -->
							<div class="form-group">
								<label class="col-sm-2 control-label">Name</label>
								<div class="col-sm-10 col-md-6">
									<input type="text" name="name" class="form-control" required="required" placeholder="Name Of The item">
								</div>
							</div>
							<!-- End Username Field -->
							<!-- Start Description Field -->
							<div class="form-group">
								<label class="col-sm-2 control-label">Description</label>
								<div class="col-sm-10 col-md-6">
									<input type="text" name="description" class="form-control" required="required" placeholder="Description Of The item">
								</div>
							</div>
							<!-- End Description Field -->
							<!-- Start Price Field -->
							<div class="form-group">
								<label class="col-sm-2 control-label">Price</label>
								<div class="col-sm-10 col-md-6">
									<input type="text" name="price" class="form-control"   required="required" placeholder="Price Of The item">
								</div>
							</div>
							<!-- End Price Field -->
							<!-- Start Country Field -->
							<div class="form-group">
								<label class="col-sm-2 control-label">Country</label>
								<div class="col-sm-10 col-md-6">
									<input type="text" name="country" class="form-control" required="required" placeholder="Country Of Made">
								</div>
							</div>
							<!-- End Country Field -->
							<!-- Start Status Field -->
							<div class="form-group">
								<label class="col-sm-2 control-label">Status</label>
								<div class="col-sm-10 col-md-6">
									<select class="form-control" name="status">
										<option value="0">...</option>
										<option value="1">New</option>
										<option value="2">Like New</option>
										<option value="3">Used</option>
										<option value="4">Very Old</option>
									</select>
								</div>
							</div>
							<!-- End Status Field -->
							<!-- Start Members Field -->
							<div class="form-group">
								<label class="col-sm-2 control-label">Member</label>
								<div class="col-sm-10 col-md-6">
									<select class="form-control" name="member">
										<option value="0">...</option>
										<?php
											$allMembers = getAllFrom("*", "users", "", "", "UserID");

											foreach($allMembers as $user) {

												echo "<option value='" . $user['UserID'] . "'>" . $user['Username'] . "</option>";

											}

										?>
									</select>
								</div>
							</div>
							<!-- End Members Field -->
							<!-- Start Categories Field -->
							<div class="form-group">
								<label class="col-sm-2 control-label">Categories</label>
								<div class="col-sm-10 col-md-6">
									<select class="form-control" name="category">
										<option value="0">...</option>
										<?php
											$allCats = getAllFrom("*", "categories", "where parent = 0", "", "ID");
											foreach($allCats as $cat) {
												echo "<option value='" . $cat['ID'] . "'>" . $cat['Name'] . "</option>";
												$childCats = getAllFrom("*", "categories", "where parent = {$cat['ID']}", "", "ID");
												foreach ($childCats as $child) {
													echo "<option value='" . $child['ID'] . "'>--- " . $child['Name'] . "</option>";
												}
											}

										?>
									</select>
								</div>
							</div>
							<!-- End Categories Field -->
							<!-- Start Tags Field -->
							<div class="form-group">
								<label class="col-sm-2 control-label">Tags</label>
								<div class="col-sm-10 col-md-6">
									<input type="text" name="tags" class="form-control" placeholder="Separate Tags With Comma (,)">
								</div>
							</div>
							<!-- End Tags Field -->
							<!-- Start Button Field -->
							<div class="form-group">
								<div class="col-sm-offset-2 col-sm-10">
									<input type="submit" value="Add Item" class="btn btn-primary">
								</div>
							</div>
							<!-- End Button Field -->
						</form>
					</div>

			<?php


		} elseif($do == 'Insert') {

			if($_SERVER['REQUEST_METHOD'] == 'POST') {

		 	echo "<h1 class='text-center'>Insert item</h1>";
		 	echo "<div class='container'>";

	 		// Get Variables From The Form

	 		$name 		= $_POST['name'];
	 		$desc 		= $_POST['description'];
	 		$price 		= $_POST['price'];
	 		$country 	= $_POST['country'];
	 		$status 	= $_POST['status'];
	 		$member 	= $_POST['member'];
	 		$cat 		= $_POST['category'];
	 		$tags 		= $_POST['tags'];


	 		// Validate The Form

	 		$formErros = array();

	 		if(empty($name)) {
	 			$formErros[] = 'Name Can\'t Be Empty';
	 		}

	 		if(empty($desc)) {
	 			$formErros[] = 'Description Can\'t Be Empty';
	 		}
	 		
	 		if(empty($price)) {
	 			$formErros[] = 'Price Can\'t Be Empty';
	 		}
	 		if(empty($country)) {
	 			$formErros[] = 'Country Can\'t Be Empty';
	 		}
	 		if($status == 0) {
	 			$formErros[] = 'You Must Choose The Status';
	 		}
	 		if($member == 0) {
	 			$formErros[] = 'You Must Choose The Member';
	 		}

			if($cat == 0) {
	 			$formErros[] = 'You Must Choose The Category';
	 		}


	 		foreach($formErros as $error) {

	 			echo '<div class="alert alert-danger">' . $error . '</div>';
	 		}

	 		// Check If There's No Error Proceed The Update Operation

	 		if(empty($formErros)) { 

 		
		 		// Insert items In Database
		 		$stmt = $con->prepare("INSERT INTO items(Name, Description, Price, Country_Made, Status, Add_Date, Cat_ID, Member_ID, tags)VALUES(:zname, :zdesc, :zprice, :zcountry, :zstatus, now(), :zcat, :zmember, :ztags)");
		 		
		 		$stmt->execute(array(
		 			'zname' 	=> $name,
		 			'zdesc' 	=> $desc,
		 			'zprice'	=> $price,
		 			'zcountry' 	=> $country,
		 			'zstatus' 	=> $status,
		 			'zcat'		=> $cat,
		 			'zmember'   => $member,
		 			'ztags'		=> $tags

		 		));


	 		$theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Inserted</div>';

	 		redirectHome($theMsg, 'back');


	 	   }	
	 		
	 	 } else {
	 	 	echo "<div class='container'>";

	 		$theMsg = '<div class="alert alert-danger">Sorry You Cant Browse This Page Directly</div>';

	 		redirectHome($theMsg, 'back');

	 		echo "</div>";
	 	 }

	 	echo "</div>";


		} elseif($do == 'Edit') {
		$itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;
		$stmt = $con->prepare("SELECT * FROM items WHERE items_ID = ?");
		$stmt->execute(array($itemid));
		$item = $stmt->fetch();
		$count = $stmt->rowCount();
		if($count > 0) { ?>

		<h1 class="text-center">Edit Item</h1>
					<div class="container">
						<form class="form-horizontal" action="?do=Update" method="POST">
						<input type="hidden" name="itemid" value="<?php echo $itemid ?>">
							<!-- Start Name Field -->
							<div class="form-group">
								<label class="col-sm-2 control-label">Name</label>
								<div class="col-sm-10 col-md-6">
									<input type="text" name="name" class="form-control" required="required" placeholder="Name Of The item" value="<?php echo $item['Name']; ?>">
								</div>
							</div>
							<!-- End Username Field -->
							<!-- Start Description Field -->
							<div class="form-group">
								<label class="col-sm-2 control-label">Description</label>
								<div class="col-sm-10 col-md-6">
									<input type="text" name="description" class="form-control" required="required" placeholder="Description Of The item" value="<?php echo $item['Description'] ?>">
								</div>
							</div>
							<!-- End Description Field -->
							<!-- Start Price Field -->
							<div class="form-group">
								<label class="col-sm-2 control-label">Price</label>
								<div class="col-sm-10 col-md-6">
									<input type="text" name="price" class="form-control"   required="required" placeholder="Price Of The item" value="<?php echo $item['Price'] ?>">
								</div>
							</div>
							<!-- End Price Field -->
							<!-- Start Country Field -->
							<div class="form-group">
								<label class="col-sm-2 control-label">Country</label>
								<div class="col-sm-10 col-md-6">
									<input type="text" name="country" class="form-control" required="required" placeholder="Country Of Made" value="<?php echo $item['Country_Made'] ?>">
								</div>
							</div>
							<!-- End Country Field -->
							<!-- Start Status Field -->
							<div class="form-group">
								<label class="col-sm-2 control-label">Status</label>
								<div class="col-sm-10 col-md-6">
									<select class="form-control" name="status">
										<option value="0">...</option>
										<option value="1" <?php if($item['Status'] == 1) {echo 'selected';} ?>>New</option>
										<option value="2"<?php if($item['Status'] == 2) {echo 'selected';} ?>>Like New</option>
										<option value="3"<?php if($item['Status'] == 3) {echo 'selected';} ?>>Used</option>
										<option value="4"<?php if($item['Status'] == 4) {echo 'selected';} ?>>Very Old</option>
									</select>
								</div>
							</div>
							<!-- End Status Field -->
							<!-- Start Members Field -->
							<div class="form-group">
								<label class="col-sm-2 control-label">Member</label>
								<div class="col-sm-10 col-md-6">
									<select class="form-control" name="member">
										<option value="0">...</option>
										<?php
											$stmt = $con->prepare("SELECT * FROM users");

											$stmt->execute();

											$users = $stmt->fetchAll();

											foreach($users as $user) {

												echo "<option value='" . $user['UserID'] . "'"; if($item['Member_ID'] == $user['UserID']) {echo 'selected';} echo ">" . $user['Username'] . "</option>";
											}

										?>
									</select>
								</div>
							</div>
							<!-- End Members Field -->
							<!-- Start Categories Field -->
							<div class="form-group">
								<label class="col-sm-2 control-label">Categories</label>
								<div class="col-sm-10 col-md-6">
									<select class="form-control" name="category">
										<option value="0">...</option>
										<?php
											$stmt2 = $con->prepare("SELECT * FROM categories");

											$stmt2->execute();

											$cats = $stmt2->fetchAll();

											foreach($cats as $cat) {

												echo "<option value='" . $cat['ID'] . "'";
												if($item['Cat_ID'] == $cat['ID']) {echo 'selected';} echo ">" . $cat['Name'] . "</option>";
											}

										?>
									</select>
								</div>
							</div>
							<!-- End Categories Field -->
							<!-- Start Tags Field -->
							<div class="form-group">
								<label class="col-sm-2 control-label">Tags</label>
								<div class="col-sm-10 col-md-6">
									<input type="text" name="tags" class="form-control" placeholder="Separate Tags With Comma (,)" value="<?php echo $item['tags'] ?>">
								</div>
							</div>
							<!-- End Tags Field -->
							<!-- Start Button Field -->
							<div class="form-group">
								<div class="col-sm-offset-2 col-sm-10">
									<input type="submit" value="Save Item" class="btn btn-primary">
								</div>
							</div>
							<!-- End Button Field -->
						</form>
						<?php
								$stmt = $con->prepare("SELECT comments.*, users.Username

											FROM
												comments

											INNER JOIN 
											
												users
											ON 
												users.UserID = comments.user_id
											WHERE
											    items_id = ?

						");

					$stmt->execute(array($itemid));

					$rows = $stmt->fetchAll();

					if(! empty($rows)) {


				

					?>
					<h1 class="text-center">Manage [<?php echo $item['Name']; ?>] Comments</h1>
						<div class="table-responsive">
							<table class="table main-table text-center table-bordered">
								<tr>
									<td>Comment</td>
									<td>User Name</td>
									<td>Added Date</td>
									<td>Control</td>
								</tr>
				

								<tr>
									<?php
										foreach($rows as $row) {

											echo "<tr>";
												echo "<td>" . $row['comment'] . "</td>";
												echo "<td>" . $row['user_id'] . "</td>";
												echo "<td>" . $row['comment_date'] . "</td>";
												echo "<td>
														<a href='comments.php?do=Edit&comid=" . $row['c_id'] . "  ' class='btn btn-success'><i class='fa fa-edit'></i>Edit</a>
														<a href='comments.php?do=Delete&comid=" . $row['c_id'] . "  'class='btn btn-danger confirm'><i class='fa fa-close'></i>Delete</a>";

														if($row['status'] == 0) {
															echo "<a href='comments.php?do=Approve&comid=" . $row['c_id'] . "  'class='btn btn-info activate'><i class='fa fa-check'></i> Approve</a>";

														}
														
													echo "</td>";
											echo "</tr>";
										}

									?>
								</tr>
								</tr>
							</table>
						</div>
						<?php } ?>
					</div>




	<?php
		} else{
			echo "<div class='container'>";

			$theMsg ='<div class="alert alert-danger">There Is No SUch ID</div>';

			redirectHome($theMsg);

			echo "</div>";
		}


		} elseif($do == 'Update') {

			if($_SERVER['REQUEST_METHOD'] == 'POST') {

		 	echo "<h1 class='text-center'>Update Item</h1>";
		 	echo "<div class='container'>";

	 		// Get Variables From The Form

	 		$id 		= $_POST['itemid'];
	 		$name       = $_POST['name'];
	 		$desc 		= $_POST['description'];
	 		$price 		= $_POST['price'];
	 		$country 	= $_POST['country'];
	 		$status 	= $_POST['status'];
	 		$member 	= $_POST['member'];
	 		$cat 		= $_POST['category'];
	 		$tags 		= $_POST['tags'];
	 		
	 		// Validate The Form 

	 		$formErros = array();

	 		if(empty($name)) {
	 			$formErros[] = 'Name Can\'t Be Empty';
	 		}

	 		if(empty($desc)) {
	 			$formErros[] = 'Description Can\'t Be Empty';
	 		}
	 		
	 		if(empty($price)) {
	 			$formErros[] = 'Price Can\'t Be Empty';
	 		}
	 		if(empty($country)) {
	 			$formErros[] = 'Country Can\'t Be Empty';
	 		}
	 		if($status == 0) {
	 			$formErros[] = 'You Must Choose The Status';
	 		}
	 		if($member == 0) {
	 			$formErros[] = 'You Must Choose The Member';
	 		}

			if($cat == 0) {
	 			$formErros[] = 'You Must Choose The Category';
	 		}


	 		foreach($formErros as $error) {

	 			echo '<div class="alert alert-danger">' . $error . '</div>';
	 		}


	 		// Check If There's No Error Proceed The Update Operation
	 		if(empty($formErros)){ 

	 		// Update The Database With This Info

		 		$stmt = $con->prepare("UPDATE 
													items 
												SET 
													Name = ?, 
													Description = ?, 
													Price = ?, 
													Country_Made = ?,
													Status = ?,
													Cat_ID = ?,
													Member_ID = ?,
													tags = ?
												WHERE 
													items_ID = ?");
						$stmt->execute(array($name, $desc, $price, $country, $status, $cat, $member, $tags, $id));
						// Echo Success Message
						$theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Updated</div>';
						redirectHome($theMsg, 'back');
					}
				} else {
					$theMsg = '<div class="alert alert-danger">Sorry You Cant Browse This Page Directly</div>';
					redirectHome($theMsg);
				}
			echo "</div>";



		} elseif($do == 'Delete') {

			echo "<h1 class='text-center'>Delete item</h1>";
		 	echo "<div class=container>";

		 	$itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;

		 	$check = checkItem('items_ID', 'items', $itemid);
		
			if($check > 0) { 

				$stmt = $con->prepare("DELETE FROM items WHERE Items_ID = :zid");

				$stmt->bindParam(":zid", $itemid);

				$stmt->execute();

				$theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Deleted</div>';

				redirectHome($theMsg, 'back');



			} else {

				$theMsg = '<div class="alert alert-danger">This ID is Not Exist</div>';

				redirectHome($theMsg);
			}

			echo '</div>';


		} elseif($do == 'Approve') {

			echo "<h1 class='text-center'>Approve items</h1>";
			 	echo "<div class=container>";

			 	$itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;

			 	$check = checkItem('items_ID', 'items', $itemid);
			
				if($check > 0) { 

					$stmt = $con->prepare("UPDATE items SET Approve = 1 WHERE items_ID = ?");

					$stmt->execute(array($itemid));

					$theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Activated</div>';

					redirectHome($theMsg, 'back');



				} else {

					$theMsg = '<div class="alert alert-danger">This ID is Not Exist</div>';

					redirectHome($theMsg);
				}

			echo '</div>';


				
			}

		include $tpl . 'footer.php';
	} else {

		header('Location: index.php');

		exit();
	}
		ob_end_flush();

?>	