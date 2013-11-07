<?
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

# Load our user defined config file

require_once 'config.php';

# Fire up the autoloader I'm going back to 1977!

function __autoload($class_name) {
	include 'classes/'. $class_name . '.php';
}

$plugins = Plugins::enabledPlugins();

if (!empty($plugins) && in_array($_POST['action'], $plugins)) {
	
	$plugin = $_POST['action'];
	
	$file = PLUGIN_PATH."$plugin/$plugin.php";
	
	if (file_exists($file)) {
		
		include_once $file;
		
		if (method_exists($plugin, 'ajax')) {
			$plugin::ajax();	
		}
		
	}
		
}
