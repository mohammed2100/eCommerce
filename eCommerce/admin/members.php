
	<?php
	/*
	===================================================

	=== Manage Memebers Page 
	=== You Can Add | Edit| Delete Members From Here

	====================================================
	*/




	session_start();

	$pageTitle = 'Members'; 

	if(isset($_SESSION['Username'])) { 

	include 'init.php';

	$do = isset($_GET['do']) ?  $_GET['do'] : 'Manage';

	if ($do == 'Manage') { # Manage Members Page 


		$query = '';

		if (isset($_GET['page']) && $_GET['page'] == 'Pending') {
			
			$query = 'AND RegStatus = 0';
		}
		

		$stmt = $con ->prepare("SELECT * FROM users WHERE GroupID !=1 $query");//Select All Users Except Admin
		//Execute The Statement
		$stmt ->execute();

		//Assign To Variable 

		$rows = $stmt->fetchAll();



?>

	<h1 class="text-center">Manage Members</h1>
	<div class="container">
		<div class="table-responsive">
			<table class="main-table text-center table table-bordered">
				<tr>
					<td>#ID</td>
					<td>Username</td>
					<td>Email</td>
					<td>Full Name</td>
					<td>Registered Date</td>
					<td>Control</td>
				</tr>


				<?php

					foreach ($rows as $row) {
						echo "<tr>";

							echo "<td>" . $row['UserID']  ."</td>";
							echo "<td>" . $row['Username']."</td>";
							echo "<td>" . $row['Email']   ."</td>";
							echo "<td>" . $row['FullName']."</td>";
							echo "<td>" . $row['Date']    . "</td>";
							echo  "<td>
							<a href='members.php?do=Edit&userid=" . $row['UserID']."' class='btn btn-success'><i class='fa fa-edit'></i>Edit</a>

							<a href='members.php?do=Delete&userid=" . $row['UserID']."'class='btn btn-danger confirm'><i class='fa fa-close'></i>Delete</a>";
							   	
							   	if ($row['RegStatus'] == 0) {
							   		echo "<a href='members.php?do=Activate&userid=" . $row['UserID']."'class='btn btn-info activate'><i class='fa fa-close'></i>Activate </a>";
							   	}



							   echo "</td>";
						echo "</tr>";
					}


		       ?>	
			</table>
		</div>
		<a href="members.php?do=Add" class=" add-member btn btn-primary"><i class="fa fa-plus"></i> New Member </a>
	</div>

	
	<?php 
	
	} elseif ($do == 'Add') { //Add Members Page  ?>


	<h1 class="text-center">Add New Member</h1>

	<div class="container">
	<form class="form-horizontal" action="?do=Insert" method="POST">


	<!--  Start Username Field -->
	<div class="form-group form-group-lg" >
	<label class="col-sm-2 control-label">Username</label>
	<div class="col-sm-10 col-md-6 ">

		<input type="text" name="username" class ="form-control"autocomplete="off" required="required" placeholder="Username To Login Into Shop" />

	</div>
	</div>
	<!--  End Username Field -->



	<!--  Start Password Field -->
	<div class="form-group form-group-lg">
	<label class="col-sm-2 control-label ">Password</label>
	<div class="col-sm-10 col-md-6">
		
		<input type="password" name="password" class = "password form-control" autocomplete="new-password"required="required" placeholder=" Password Must Be Hard & Complex" />
		<i class="show-pass fa fa-eye fa-2x"></i>

	</div>
	</div>
	<!--  End Password Field -->




	<!--  Start Email Field -->
	<div class="form-group form-group-lg">
	<label class="col-sm-2 control-label">Email</label>
	<div class="col-sm-10 col-md-6">


		<input type="email" name="email" class ="form-control" required="required" placeholder="Email Must Be Valid">

	</div>
	</div>
	<!--  End Email Field -->



	<!--  Start Full Name Field -->
	<div class="form-group form-group-lg">
	<label class="col-sm-2 control-label">Full Name</label>
	<div class="col-sm-10 col-md-6">


		<input type="text" name="full" class ="form-control" required="required" placeholder="Full Name Apear In Your Profile Page " />

	</div>
	</div>
	<!--  End Full Name Field -->



	<!--  Start Submit Field -->
	<div class="form-group">

	<div class="col-sm-offset-2 col-sm-10">

		<input type="submit" value="Add Member" class ="btn btn-primary btn-lg">

	</div>
	</div>
	<!--  End Submit Field -->
	</form>
	</div>


	<?php

	} elseif ($do=='Insert') {
	//Insert Member Page

	if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	echo "<h1 class='text-center'>Insert Member</h1>";
	echo "<div class = 'container'>";
	// Get Variable From The Form 

	$user  = $_POST['username'];
	$pass  = $_POST['password']; 
	$email = $_POST['email'];
	$name  = $_POST['full'];

	$hashPass= sha1($_POST['password']);
	// Validate The Form 

	$formErrors = array();
	if ( strlen($user) < 4 || strlen($user) > 20 ) {

	$formErrors[] = 'Username must Be Less Than 20 Characters And More Than 4 Characters';
	}
	if (empty($user)) {

	$formErrors[] = 'Username Cant Be Empty';
	}
	if (empty($pass)) {

	$formErrors[] = 'Password Cant Be Empty';
	}

	if (empty($name)) {
	$formErrors[] =  'Full Name Cant Be Empty';
	}
	if (empty($email)) {
	$formErrors[] =  ' Email Cant Be Empty';
	}
	// Loop Into Errors Array And Echo It.
	foreach ($formErrors as $error) {
	echo '<div class = "alert alert-danger">' . $error.'</div>' ;
	}
	//Check If There's No Error Proceed The Update Operation
	if (empty($formErrors)) {

		// Check If User Exists In Database

		$check = checkItem("Username","users",$user);

		if ($check == 1) {  
			$theMsg = '<div class="alert alert-danger">Sorry This Username Is Used</div>';
			redirectHome($theMsg,'back');
		} else { 
				// Insert Userinfo In Database
					$stmt = $con->prepare("INSERT INTO users(Username,Password,Email,FullName, RegStatus,  Date) VALUES(:zuser, :zpass, :zmail, :zname, 1, now()) "); 
					$stmt->execute(array(
							'zuser' => $user, // which is $_POST['username']
							'zpass' => $hashPass,
							'zmail' => $email,
							'zname' => $name 
						));
			


			// Echo Sucsess Message 
			$theMsg =  "<div class ='alert alert-success'>" . $stmt->rowCount() . 'Record Inserted</div>';
			redirectHome($theMsg, 'back',3);

	}  

 }

} else {

	echo "<div class='container'>";

	$theMsg = '<div class="alert alert-danger">Sorry You Cannot Browse This Page Directly</div>';
	redirectHome($theMsg, 'BACK',3);

	echo "</div>";
	}

	echo "</div>";




	} elseif ($do == 'Edit') { // Edit Page 

	// Check If Get Request userid Is numeric & Get The Integer Value Of It

	$userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;

	// Select All Data Depend On This ID

	$stmt = $con->prepare("SELECT * FROM users WHERE UserID = ? LIMIT 1");

	// Execute Query

	$stmt->execute(array($userid));

	// Fetch The Data 
	$row = $stmt->fetch();
											/*IT IS YOUR BIRTHDAY*/
	// 'if there is changing',The Row Count   
	$count = $stmt->rowCount();

	// If There's Such ID Show The Form (//if > 0 this id exists_)
	if ($count > 0) { ?>

		<h1 class="text-center">Edit Member</h1>

		<div class="container">
			<form class="form-horizontal" action="?do=Update" method="POST">
				<input type="hidden" name="userid" value="<?php echo $userid ?>"/>

				<!--  Start Username Field -->
				<div class="form-group form-group-lg" >
					<label class="col-sm-2 control-label">Username</label>
					<div class="col-sm-10 col-md-6 ">

						<input type="text" name="username" class ="form-control" value="<?php echo $row['Username'] ?>" autocomplete="off" required="required"/>

					</div>
				</div>
				<!--  End Username Field -->



				<!--  Start Password Field -->
				<div class="form-group form-group-lg">
					<label class="col-sm-2 control-label ">Password</label>
					<div class="col-sm-10 col-md-6">
						<input type="hidden" name="oldpassword" value="<?php echo $row['Password'] ?>" />
						<input type="password" name="newpassword" class ="form-control" autocomplete="new-password" placeholder=" Leave The Blank If You Don't Want To Change" />


					</div>
				</div>
				<!--  End Password Field -->




				<!--  Start Email Field -->
				<div class="form-group form-group-lg">
					<label class="col-sm-2 control-label">Email</label>
					<div class="col-sm-10 col-md-6">
					

						<input type="email" name="email" value="<?php echo $row['Email'] ?>" class ="form-control" required="required">

					</div>
				</div>
				<!--  End Email Field -->



				<!--  Start Full Name Field -->
				<div class="form-group form-group-lg">			
					<label class="col-sm-2 control-label">Full Name</label>
					<div class="col-sm-10 col-md-6">
					

						<input type="text" name="full" class ="form-control" value="<?php echo $row['FullName'] ?>" required="required"/>

					</div>
				</div>
				<!--  End Full Name Field -->



				<!--  Start Submit Field -->
				<div class="form-group">
					
					<div class="col-sm-offset-2 col-sm-10">

						<input type="submit" value="Save" class ="btn btn-primary btn-lg">

					</div>
				</div>
				<!--  End Submit Field -->
			</form>
		</div>



	<?php 


	// If There's No Such ID Show Error Message


	} else {

	echo "<div class='container'>";
	$theMsg = '<div class="alert alert-danger">There Is No Such ID</div> ' ;
	redirectHome($theMsg);

	echo "</div>";
	}  

	} elseif ($do == 'Update') { //Update Page

	echo "<h1 class='text-center'>Update Member</h1>";
	echo "<div class = 'container'>";

	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	// Get Variable From The Form 
	$id    = $_POST['userid'];
	$user  = $_POST['username'];
	$email = $_POST['email'];
	$name  = $_POST['full'];


	//Password Trick 
	$pass = '';
	if (empty($_POST['newpassword'])) {

	$pass = $_POST['oldpassword'] ;

	} else {

	$pass = sha1($_POST['newpassword']);
	}
	// Validate The Form 

	$formErrors = array();
	if ( strlen($user) < 4 || strlen($user) > 20 ) {

	$formErrors[] = '<div class = "alert alert-danger"> Username must Be Less Than 20 Characters And More Than 4 Characters</div>';
	}
	if (empty($user)) {

	$formErrors[] = '<div class = "alert alert-danger"> Username Cant Be Empty</div>';
	}

	if (empty($name)) {
	$formErrors[] =  '<div class = "alert alert-danger"> Full Name Cant Be Empty</div>';
	}
	if (empty($email)) {
	$formErrors[] =  '<div class = "alert alert-danger"> Email Cant Be Empty</div>';
	}
	// Loop Into Errors Array And Echo It.
	foreach ($formErrors as $error) {
	echo $error ;
	}
	//Check If There's No Error Proceed The Update Operation
	if (empty($formErrors)) {
			// Update The Database With This Info
		$stmt = $con->prepare("UPDATE users SET Username = ?,Email = ?,FullName = ?, Password = ? WHERE UserID = ?");
		$stmt->execute(array($user, $email, $name, $pass, $id));
		// Echo Sucsess Message 
		$theMsg = "<div class ='alert alert-success'>" . $stmt->rowCount() . 'Record Updated</div>';
		redirectHome($theMsg);

	} 



	} else {

	$theMsg =  '<div class="alert alert-danger">Sorry You Cannot Browse This Page Directly</div>';
	redirectHome($theMsg);
	}

	echo "</div>";

	} elseif ($do == 'Delete') { //Delete Mmeber Page

       echo "<h1 class='text-center'>Delete Mmeber</h1>";
       echo "<div class='container'>"; 

		// Check If Get Request userid Is numeric & Get The Integer Value Of It

	$userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;

	// Select All Data Depend On This ID

	$stmt = $con->prepare("SELECT * FROM users WHERE UserID = ? LIMIT 1");

	$check = checkItem('userid', 'users', $userid);


	// If There's Such ID Show The Form 
	if ($check > 0) { //if > 0 this id exists

			$stmt = $con->prepare("DELETE From users WHERE userID =:zuser");
			$stmt->bindParam(":zuser", $userid);
			$stmt->execute();
			$theMsg = "<div class ='alert alert-success'>" . $stmt->rowCount() . 'Record Deleted</div>';
			redirectHome($theMsg);

		} else {

			$theMsg ='<div class="alert alert-danger">This ID Does Not Exist</div>';
			redirectHome($theMsg);
		}

	 echo '</div>';


			
  } elseif ($do == 'Activate') {
  	
  	 	//Activate  Mmeber Page

  		echo "<h1 class='text-center'>Activate Member</h1>";
       echo "<div class='container'>";


		// Check If Get Request userid Is numeric & Get The Integer Value Of It

	$userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;

	// Select All Data Depend On This ID

	$stmt = $con->prepare("SELECT * FROM users WHERE UserID = ? LIMIT 1");

	$check = checkItem('userid', 'users', $userid);


	// If There's Such ID Show The Form 
	if ($check > 0) { //if > 0 this id exists

			$stmt = $con->prepare("UPDATE users SET RegStatus = 1 WHERE UserID = ?");
			
			$stmt->execute(array($userid));

			$theMsg = "<div class ='alert alert-success'>" . $stmt->rowCount() . 'Record Updated</div>';
			redirectHome($theMsg);

		} else {

			$theMsg ='<div class="alert alert-danger">This ID Does Not Exist</div>';
			redirectHome($theMsg);
		}

	 echo '</div>';	


  }


		include $tpl . 'footer.php';

	} else {

	header('Location: index.php');

	exit();
	
}

