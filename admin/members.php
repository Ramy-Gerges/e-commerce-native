<?php

session_start();

	$PageTitle = 'Members';

	if(isset($_SESSION['Username'])) {

		include 'init.php';

		$do = isset($_GET['do']) ? $_GET['do'] :'Manage';

		if($do == 'Manage') { // Manage Mmebers Page

			$query = '';

			if (isset($_GET['page']) && $_GET['page'] == 'Pending') {

				$query = 'AND RegStatus = 0';
			}
		


			$stmt = $con->prepare("SELECT * FROM users WHERE GroupID != 1 $query ORDER BY UserID DESC");
			$stmt->execute();

			$rows = $stmt->fetchAll();

			if(! empty($rows)) { 

			?>

			<h1 class="text-center">Manage Members</h1>
			<div class="container">
				<div class="table-responsive">
					<table class="table main-table manage-members text-center table-bordered">
						<tr>
							<td>#ID</td>
							<td>Avatar</td>
							<td>Username</td>
							<td>Email</td>
							<td>Full Name</td>
							<td>Registerd Date</td>
							<td>Control</td>
						</tr>
		

						<tr>
							<?php
								foreach($rows as $row) {

									echo "<tr>";
										echo "<td>" . $row['UserID'] . "</td>";
										echo "<td>";
											if(empty($row['avatar'])){
												echo "<img src='default/avatars/img.png' />";
											} else { 
												echo "<img src='uploads/avatars/" . $row['avatar'] . "' />";
											} 
											
										"</td>";
										echo "<td>" . $row['Username'] . "</td>";
										echo "<td>" . $row['Email'] . "</td>";
										echo "<td>" . $row['FullName'] . "</td>";
										echo "<td>" . $row['Date'] . "</td>";
										echo "<td>
												<a href='members.php?do=Edit&userid=" . $row['UserID'] . "  ' class='btn btn-success'><i class='fa fa-edit'></i>Edit</a>
												<a href='members.php?do=Delete&userid=" . $row['UserID'] . "  'class='btn btn-danger confirm'><i class='fa fa-close'></i>Delete</a>";

												if($row['RegStatus'] == 0) {
													echo "<a href='members.php?do=Activate&userid=" . $row['UserID'] . "  'class='btn btn-info activate'><i class='fa fa-check'></i>Activate</a>";

												}
												
											echo "</td>";
									echo "</tr>";
								}

							?>
						</tr>
						</tr>
					</table>
				</div>
				<a href="members.php?do=Add" class="btn btn-primary"><i class="fa fa-plus"></i> Add New Member</a>	
			</div>
			<?php } else {

						echo '<div class="container">';
						echo '<div class="alert alert-info">There Is No Record To Show</div>';
						echo '<a href="members.php?do=Add" class="btn btn-primary"><i class="fa fa-plus"></i> Add New Member</a>';
					echo '</div>';
				} ?>
	
			

	<?php } elseif($do == 'Add') { // Add Members Page ?>
			
			<h1 class="text-center">Add New Member</h1>
					<div class="container">
						<form class="form-horizontal" action="?do=Insert" method="POST" enctype="multipart/form-data">
							<!-- Start Username Field -->
							<div class="form-group">
								<label class="col-sm-2 control-label">Username</label>
								<div class="col-sm-10 col-md-6">
									<input type="text" name="username" class="form-control" required="required" autocomplete="off" placeholder="Username To Login Into Shop">
								</div>
							</div>
							<!-- End Username Field -->
							<!-- Start Password Field -->
							<div class="form-group">
								<label class="col-sm-2 control-label">Password</label>
									<div class="col-sm-10 col-md-6">
									  <input type="password" name="password" class="password form-control" autocomplete="new-password"  required="required" placeholder="Password Must Be Hard">
									  <i class="show-pass fa fa-eye fa-2x"></i>
								</div>
							</div>
							<!-- Start Password Field -->
							<div class="form-group">
								<label class="col-sm-2 control-label">Email</label>
								<div class="col-sm-10 col-md-6">
									<input type="email" name="email" class="form-control" required="required" placeholder="Email Must Be Valid">
								</div>
							</div>
							<!-- Start Email Field -->
							<div class="form-group">
								<label class="col-sm-2 control-label">Full Name</label>
								<div class="col-sm-10 col-md-6">
									<input type="text" name="full" class="form-control" placeholder="FullName Appear In Your Profile Page">
								</div>
							</div>
							<!-- End FullName Field -->
							<!-- Start Profile Image Field -->
							<div class="form-group">
								<label class="col-sm-2 control-label">User Avatar</label>
								<div class="col-sm-10 col-md-6">
									<input type="file" name="avatar" class="form-control">
								</div>
							</div>
							<!-- End Profile Image Field -->
							<!-- Start Button Field -->
							<div class="form-group">
								<div class="col-sm-offset-2 col-sm-10">
									<input type="submit" value="Add Member" class="btn btn-primary">
								</div>
							</div>
							<!-- End Button Field -->
						</form>
					</div>

		
	<?php 

		} elseif($do == 'Insert'){
			// Insert Member Page
			if ($_SERVER['REQUEST_METHOD'] == 'POST') {
				echo "<h1 class='text-center'>Insert Member</h1>";
				echo "<div class='container'>";
				// Upload Variables
				$avatarName = $_FILES['avatar']['name'];
				$avatarSize = $_FILES['avatar']['size'];
				$avatarTmp	= $_FILES['avatar']['tmp_name'];
				$avatarType = $_FILES['avatar']['type'];
				// List Of Allowed File Typed To Upload
				$avatarAllowedExtension = array("jpeg", "jpg", "png", "gif");
				// Get Avatar Extension
				$Explosion = explode('.', $avatarName);
				$endedVar = end($Explosion);
				$avatarExtension = strtolower($endedVar); 
				// Get Variables From The Form
				$user 	= $_POST['username'];
				$pass 	= $_POST['password'];
				$email 	= $_POST['email'];
				$name 	= $_POST['full'];
				$hashPass = sha1($_POST['password']);
				// Validate The Form
				$formErrors = array();
				if (strlen($user) < 4) {
					$formErrors[] = 'Username Cant Be Less Than <strong>4 Characters</strong>';
				}
				if (strlen($user) > 20) {
					$formErrors[] = 'Username Cant Be More Than <strong>20 Characters</strong>';
				}
				if (empty($user)) {
					$formErrors[] = 'Username Cant Be <strong>Empty</strong>';
				}
				if (empty($pass)) {
					$formErrors[] = 'Password Cant Be <strong>Empty</strong>';
				}
				if (empty($name)) {
					$formErrors[] = 'Full Name Cant Be <strong>Empty</strong>';
				}
				if (empty($email)) {
					$formErrors[] = 'Email Cant Be <strong>Empty</strong>';
				}
				if (! empty($avatarName) && ! in_array($avatarExtension, $avatarAllowedExtension)) {
					$formErrors[] = 'This Extension Is Not <strong>Allowed</strong>';
				}
				if (empty($avatarName)) {
					$formErrors[] = 'Avatar Is <strong>Required</strong>';
				}
				if ($avatarSize > 4194304) {
					$formErrors[] = 'Avatar Cant Be Larger Than <strong>4MB</strong>';
				}
				// Loop Into Errors Array And Echo It
				foreach($formErrors as $error) {
					echo '<div class="alert alert-danger">' . $error . '</div>';
				}
				// Check If There's No Error Proceed The Update Operation
				if (empty($formErrors)) {
					$avatar = rand(0, 100000000) . '_' . $avatarName;
					move_uploaded_file($avatarTmp, "uploads\avatars\\" . $avatar);

					// Check If User Exist in Database
					$check = checkItem("Username", "users", $user);
					if ($check == 1) {
						$theMsg = '<div class="alert alert-danger">Sorry This User Is Exist</div>';
						redirectHome($theMsg, 'back');
					} else {
						// Insert Userinfo In Database
						$stmt = $con->prepare("INSERT INTO 
													users(Username, Password, Email, FullName, RegStatus, Date, avatar)
												VALUES(:zuser, :zpass, :zmail, :zname, 1, now(), :zavatar) ");
						$stmt->execute(array(
							'zuser' 	=> $user,
							'zpass' 	=> $hashPass,
							'zmail' 	=> $email,
							'zname' 	=> $name,
							'zavatar'	=> $avatar
						));
						// Echo Success Message
						$theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Inserted</div>';
						redirectHome($theMsg, 'back');
					}


				}
			} else {
				echo "<div class='container'>";
				$theMsg = '<div class="alert alert-danger">Sorry You Cant Browse This Page Directly</div>';
				redirectHome($theMsg);
				echo "</div>";


			}
			echo "</div>";


		
		} elseif($do == 'Edit') { //Edit Page 
		$userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;
		$stmt = $con->prepare("SELECT * FROM users WHERE UserID = ?  LIMIT 1");
		$stmt->execute(array($userid));
		$row = $stmt->fetch();
		$count = $stmt->rowCount();
		if($count > 0) { ?>

			<h1 class="text-center">Edit Member</h1>
					<div class="container">
						<form class="form-horizontal" action="?do=Update" method="POST">
							<input type="hidden" name="userid" value="<?php echo $userid ?>">
							<!-- Start Username Field -->
							<div class="form-group">
								<label class="col-sm-2 control-label">Username</label>
								<div class="col-sm-10 col-md-6">
									<input type="text" name="username" class="form-control" required="required" autocomplete="off" value="<?php echo $row['Username'] ?>">
								</div>
							</div>
							<!-- End Username Field -->
							<!-- Start Password Field -->
							<div class="form-group">
								<label class="col-sm-2 control-label">Password</label>
									<div class="col-sm-10 col-md-6">
									  <input type="hidden" name="oldpassword" value="<?php echo $row['Password'] ?>">
									  <input type="password" name="newpassword" class="form-control" autocomplete="new-password">
								</div>
							</div>
							<!-- End Password Field -->
							<!-- Start Email Field -->
							<div class="form-group">
								<label class="col-sm-2 control-label">Email</label>
								<div class="col-sm-10 col-md-6">
									<input type="email" name="email" class="form-control" required="required" value="<?php echo $row['Email'] ?>">
								</div>
							</div>
							<!-- End Email Field -->
							<!-- Start FullName Field -->
							<div class="form-group">
								<label class="col-sm-2 control-label">Full Name</label>
								<div class="col-sm-10 col-md-6">
									<input type="text" name="full" class="form-control" value="<?php echo $row['FullName'] ?>">
								</div>
							</div>
							<!-- End FullName Field -->
							

							<!-- Start Button Field -->
							<div class="form-group">
								<div class="col-sm-offset-2 col-sm-10">
									<input type="submit" value="Save" class="btn btn-primary">
								</div>
							</div>
							<!-- End Button Field -->
						</form>
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

		 	echo "<h1 class='text-center'>Update Member</h1>";
		 	echo "<div class='container'>";

	 		// Get Variables From The Form

	 		$id 	= $_POST['userid'];
	 		$user 	= $_POST['username'];
	 		$email 	= $_POST['email'];
	 		$name 	= $_POST['full'];

	 		// Password Trick 
	 		$pass = empty($_POST['newpassword']) ? $_POST['oldpassword'] : sha1($_POST['newpassword']);

	 		// Validate The Form 

	 		$formErros = array();
	 		if(empty($user)) {
	 			$formErros[] = 'Username Cant Be Empty';
	 		}

	 		if(strlen($user > 20)) {
	 			$formErros[] = 'Username Cant Be More Than 20 Characters';
	 		}
	 		
	 		if(empty($name)) {
	 			$formErros[] = 'Name Cant Be Empty';
	 		}
	 		if(empty($email)) {
	 			$formErros[] = 'Email Cant Be Empty';
	 		}

	 		foreach($formErros as $error) {

	 			echo '<div class="alert alert-danger">' . $error . '</div>';
	 		}

	 		// Check If There's No Error Proceed The Update Operation
	 		if(empty($formErros)){ 


	 			$stmt2 = $con->prepare("SELECT 
												*
											FROM 
												users
											WHERE
												Username = ?
											AND 
												UserID != ?");
					$stmt2->execute(array($user, $id));
					
					$count = $stmt2->rowCount();
					if ($count == 1) {
						$theMsg = '<div class="alert alert-danger">Sorry This User Is Exist</div>';
						redirectHome($theMsg, 'back');
					} else { 
						// Update The Database With This Info
						$stmt = $con->prepare("UPDATE users SET Username = ?, Email = ?, FullName = ?, Password = ? WHERE UserID = ?");
						$stmt->execute(array($user, $email, $name, $pass, $id));
						// Echo Success Message
						$theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Updated</div>';
						redirectHome($theMsg, 'back');
					}
				}

	 		





	 	} else {

	 		$theMsg ='<div class="alert alert-danger">Sorry You Cant Browse This Page Directly</div>';

	 		redirectHome($theMsg);
	 	}

	 	echo "</div>";



	 } elseif($do == 'Delete') { // Delete Member Page

	 	echo "<h1 class='text-center'>Delete Memeber</h1>";
	 	echo "<div class=container>";

	 	$userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;

	 	$check = checkItem('userid', 'users', $userid);
	
		if($check > 0) { 

			$stmt = $con->prepare("DELETE FROM users WHERE UserID = :zuser");
			$stmt->bindParam(":zuser", $userid);

			$stmt->execute();

			$theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Deleted</div>';

			redirectHome($theMsg);



		} else {

			$theMsg = '<div class="alert alert-danger">This ID is Not Exist</div>';

			redirectHome($theMsg);
		}

		echo '</div>';


	 } elseif($do == 'Activate'){

	 	echo "<h1 class='text-center'>Activate Memeber</h1>";
	 	echo "<div class=container>";

	 	$userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;

	 	$check = checkItem('userid', 'users', $userid);
	
		if($check > 0) { 

			$stmt = $con->prepare("UPDATE users SET RegStatus = 1 WHERE UserID = ?");

			$stmt->execute(array($userid));

			$theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Activated</div>';

			redirectHome($theMsg);



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


