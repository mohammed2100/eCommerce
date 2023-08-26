<?php 

 /*
	Categoreies => [ Manage | Edit | Update | Add | Insert | Delete | Stats(statistics) ]

	Condition ? True : False 
	so it can be  ::   
$do = isset($_GET['do']) ?  $_GET['do'] : 'Manage'
 */
	$do = '';

	if (isset($_GET['do'])) {
 
		$do =  $_GET['do'] ; 
	} else {
		$do = 'Manage';

	}
// If The Page Is Main Page 

if ($do == 'Manage') {

 	echo ' 	Welcome You Are In Manage Category Page';
 	echo ' <a href="page.php?do=Add">Add New Category +</a>';
 
 } elseif ($do == 'Add') {

 	echo ' 	Welcome You Are In Add Category Page';

 } elseif ($do == 'Insert') {

 	echo ' 	Welcome You Are In Insert Category Page';

 } else {

 	echo 'Error There Is No Page In That Name ';
 }

		
