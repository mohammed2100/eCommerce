<?php 

/*
---------------------------------

===== 	
			Template Page
=====

----------------------------------
*/

session_start();

$pageTitle = '';

if (isset($_SESSION['Username'])) {
	
	include 'init.php';

		$do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

		if ($do == 'Manage') {
			
			echo '';

		} elseif ($do == 'Add') {
			

		} elseif ($do == 'Insert') {
			# code...

		} elseif ($do == 'Edit') {
			# code...

		} elseif ($do == 'Update') {
			# code...

		} elseif ($do == 'Delete') {
			# code...

		} elseif ($do == 'Activate') {
			# code...

		} 

	include $tpl . 'footer.php';

} else {

	header('Location: index.php');

	exit();
}

?>