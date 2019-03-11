<?php
	ob_start();
	session_start();
	
	if(isset($_SESSION['Username'])) {

		$pageTitle='Dashboard';

		include 'init.php';

		/* Start Dashboard Page */

		$numUsers = 9; // Number Of Latest User


		
		$latestUsers = getLatest("*", "users", "UserID", $numUsers);

		$numItems = 6; // Number Of Latest Items

		$latestItems = getLatest("*", "items", "items_ID", $numItems); // Latest Items Array

		$numComments = 4; // Number Of Comments
		

		?>

		<div class="container home-stats text-center">
			<h1>Dashboard</h1>
			<div class="row">
				<div class="col-md-3">
					<div class="stat st-members">
							<i class="fa fa-user"></i>
							<div class="info">
							Total Members
							<span><a href="members.php"><?php echo countItems('UserID', 'users') ?></a></span>
							</div>
						</div>
					</div>
				<div class="col-md-3">
					<div class="stat st-pending">
						<i class="fa fa-user-plus"></i>
						<div class="info">
							Pending Members
							<span><a href="members.php?do=Manage&page=Pending">
							  	<?php echo checkItem("RegStatus", "users", 0) ?>
							</a></span>
						</div>
					</div>
				</div>
					<div class="col-md-3">
						<div class="stat st-items">
							<i class="fa fa-tag"></i>
							<div class="info">
							Total Items
							<span><a href="items.php"><?php echo countItems('items_ID', 'items') ?></a></span>
							</div>
					</div>
				</div>
				<div class="col-md-3">
					<div class="stat st-comments">
						<i class="fa fa-comments"></i>
						<div class="info">
								Total Comments
							<span><a href="comments.php"><?php echo countItems('c_id', 'comments') ?></a></span>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="latest">
			<div class="container">
				<div class="row">
					<div class="col-sm-6">
						<div class="panel panel-default">
							<div class="panel-heading">
								<i class="fa fa-users">Latest <?php echo $numUsers ?> Registerd Users</i>
								<span class="toggle-info pull-right">
									<i class="fa fa-plus fa-lg"></i>
								</span>
							</div>
							<div class="panel-body">
								<ul class="list-unstyled latest-users">
									<?php
										if(! empty($latestUsers)) { 
										foreach($latestUsers as $user) {

											echo '<li>';
												echo $user['Username'];
														echo '<a href="members.php?do=Edit&userid=' . $user['UserID'] . '">';
														echo '<span class="btn btn-success pull-right">';
															echo '<i class="fa fa-edit"></i>Edit';
															if($user['RegStatus'] == 0) {
															echo "<a href='members.php?do=Activate&userid=" . $user['UserID'] . "  'class='btn btn-info pull-right activate'><i class='fa fa-check'></i>Activate</a>";

														}

														 echo'</span>';
												echo '</a>';
											echo '</li>';
										  }
										} else {
											echo 'There\'s No Users To Show';
										}
									?>
								</ul>
							</div>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="panel panel-default">
							<div class="panel-heading">
								<i class="fa fa-tag">Latest <?php echo $numItems ?> Items</i>
								<span class="toggle-info pull-right">
									<i class="fa fa-plus fa-lg"></i>
								</span>
							</div>

							<div class="panel-body">
								<ul class="list-unstyled latest-users">
									<?php
										if(! empty($latestItems)) { 
										foreach($latestItems as $item) {

											echo '<li>';
												echo $item['Name'];
														echo '<a href="items.php?do=Edit&itemid=' . $item['items_ID'] . '">';
														echo '<span class="btn btn-success pull-right">';
															echo '<i class="fa fa-edit"></i>Edit';
															if($item['Approve'] == 0) {
															echo "<a href='items.php?do=Activate&userid=" . $item['items_ID'] . "  'class='btn btn-info pull-right activate'><i class='fa fa-check'></i>Approve</a>";
														} 


														 echo'</span>';
												echo '</a>';
											echo '</li>';
											}

										} else {
											echo 'There Is No Items To Show';
										}
									?>
								</ul>
							</div>
						</div>
					</div>
				</div>
				<!-- Start Latest Comments -->
				<div class="row">
					<div class="col-sm-6">
						<div class="panel panel-default">
							<div class="panel-heading">
								<i class="fa fa-comments-o">Latest <?php echo $numComments ?> Comments</i>
								<span class="toggle-info pull-right">
									<i class="fa fa-plus fa-lg"></i>
								</span>
							</div>
							<div class="panel-body">
								<?php
									$stmt = $con->prepare("SELECT comments.*, users.Username AS Member

															FROM
																comments

															INNER JOIN 
															
																users
															ON 
																users.UserID = comments.user_id
															ORDER BY c_id DESC
															LIMIT $numComments	

										");

									$stmt->execute();

									$comments = $stmt->fetchAll();
										if(! empty($comments)){ 
										foreach($comments as $comment) {

											echo '<div class="comment-box">';
												echo '<span class="member-n">' . $comment['Member'] . '</span>';

												echo '<p class="member-c">' . $comment['comment'] . '</p>';
											echo '</div>';
											echo "<div>
												<a href='comments.php?do=Edit&comid=" . $comment['c_id'] . "  ' class='btn btn-success'><i class='fa fa-edit'></i>Edit</a>
												<a href='comments.php?do=Delete&comid=" . $comment['c_id'] . "  'class='btn btn-danger confirm'><i class='fa fa-close'></i>Delete</a>";

												if($comment['status'] == 0) {
													echo "<a href='comments.php?do=Approve&comid=" . $comment['c_id'] . "  'class='btn btn-info activate'><i class='fa fa-check'></i> Approve</a>";

												}
												
											echo "</div>";

										}


									} else {

										echo 'There Is No Comments To Show';
									}

								?>
							</div>
						</div>
					</div>	
				</div>
				<!-- End Latest Comments -->
			</div>
		</div>



		<?php


		/* End Dashboard Page */

		include $tpl . 'footer.php';
	} else {
		header('Location: index.php');
		exit();
	}

	ob_end_flush();

?>