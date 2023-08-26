<?php 
	 

function lang($phrase){

	static $lang = array(

		// Dashboard Phrases Page
		// key => value
		// Navbat Links
		'HOME_ADMIN'         => 'Home',
		'CATEGORIES'		 => 'Categories',
	    'ITEMS'				 => 'Items',
		'MEMBERS'			 => 'Members',
		'STATISTICS'		 => 'Statistics',	
		'LOGS'				 => 'Logs',
		// 'Default'			 => 'Login'
		
	);
	return $lang[$phrase];

}


