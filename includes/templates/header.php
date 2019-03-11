<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title><?php getTitle() ?></title>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
	
		<link rel="stylesheet" href="<?php echo $css; ?>font-awesome.css">
		<link rel="stylesheet" href="<?php echo $css; ?>bootstrap.css">
		<link rel="stylesheet" href="<?php echo $css; ?>frontend.css">
	</head>
  <body>

  	  <div class="upper-bar">
  		<div class="container text-right">
  			<?php
  				if(isset($_SESSION['user'])) { ?>
  				<img class="my-avatar img-thumbnail img-circle" src="img.png">
  				<div class="btn-group my-info pull-right">
	  				<span class="btn dropdown-toggle" data-toggle="dropdown">
	  						<?php echo $sessionUser ?>
	  					<span class="caret"></span>
	  				</span>
	  					<ul class="dropdown-menu">
	  						<li><a href="profile.php">My Profile</a></li>
	  						<li><a href="newad.php">New Item</a></li>
	  						<li><a href="profile.php#my-ads">My Items</a></li>
	  						<li><a href="logout.php">LogOut</a></li>
	  					</ul>
  				</div>

  				<?php 

  				} else { 

  			?>
  			<a href="login.php">
  				<span class="pull-right">Login/Signup</span>
  			</a>
  			<?php } ?>
  		</div>
  	  </div>
	  <nav class="navbar navbar-inverse">
	  <div class="container">
	    <div class="navbar-header">
	      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-nav" aria-expanded="false">
	        <span class="sr-only">Toggle navigation</span>
	        <span class="icon-bar"></span>
	        <span class="icon-bar"></span>
	        <span class="icon-bar"></span>
	      </button>
	      <a class="navbar-brand" href="index.php">HomePage</a>
	    </div>
	    <div class="collapse navbar-collapse" id="app-nav">
	    	<ul class="nav navbar-nav navbar-right">
		<?php
			
			$allCats = getAllFrom("*", "categories", "where parent = 0", "", "ID", "ASC");

			foreach($allCats  as $cat) {

				echo '<li>
				<a href="categories.php?pageid=' . $cat['ID'] . '">
						' . $cat['Name'] . '
					</a>
				</li>';
			}


		?>

	    </div>
	  </div>
	</nav>









