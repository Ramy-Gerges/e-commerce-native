<?php

	session_start();

	$pageTitle = 'Edit Profile';


	if(isset($_SESSION['user'])) {

	include 'init.php'; 

	$do = isset($_GET['do']) ? $_GET['do'] :'Manage';

	if($do == 'Edit') {
		$userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;
		$stmt = $con->prepare("SELECT * FROM users WHERE UserID = ?");
		$stmt->execute(array($userid));
		$row = $stmt->fetch();
		$count = $stmt->rowCount();


		?> 

			<h1 class="text-center">Edit Profile</h1>
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

					} 
						// Update The Database With This Info
						$stmt = $con->prepare("UPDATE users SET Username = ?, Email = ?, FullName = ?, Password = ? WHERE UserID = ?");
						$stmt->execute(array($user, $email, $name, $pass, $id));
						// Echo Success Message
						$theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Updated</div>';
						redirectHome($theMsg, 'back');
					

	 		
	 	} else {

	 		$theMsg ='<div class="alert alert-danger">Sorry You Cant Browse This Page Directly</div>';

	 		redirectHome($theMsg);
	 	}

	 	echo "</div>";

	

 	}

 	include $tpl . 'footer.php';

 	 } else {

 	 	header("Location: index.php");
 	 }


?>

