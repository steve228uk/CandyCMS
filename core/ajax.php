<?php
/**
* @package CandyCMS
* @version 0.5
* @since 0.5
* @copyright Copyright 2012 (C) Cocoon Design Ltd. - All Rights Reserved
* 
* Ajax for CandyCMS
*/

if ( !isset($_POST['action']) ) {
	echo 'Action not defined!';
	exit(1);
}

include 'bootstrap.php';

$plugins = Plugins::enabledPlugins();

if (!empty($plugins)) {
	
	foreach($plugins as $plugin){
	
		$file = PLUGIN_PATH."$plugin/$plugin.php";
		
		if (file_exists($file)) {
			
			include_once $file;
			
			if (method_exists($plugin, 'ajax')) {
				$plugin::ajax();	
			}
			
		}
	
	}
		
}
