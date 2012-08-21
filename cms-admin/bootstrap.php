<?php

/**
* @package CandyCMS
* @version 0.7.4
* @since 0.1
* @copyright Copyright 2012 (C) Cocoon Design Ltd. - All Rights Reserved
* 
* Admin bootstrap
*/

#ini_set('display_errors', 1);
error_reporting(E_ALL);

define('CANDYVERSION', '0.7.4');

require_once '../core/config.php';

# Fire up the autoloader I'm going back to 1977!

function __autoload($class_name) {
	
	if (file_exists("classes/$class_name.php")) {
		include 'classes/'. $class_name . '.php';
	} else {
		include CMS_PATH.'core/classes/'. $class_name . '.php';
	}
}

CandyCMS::init();

# Include our admin functions file

include_once 'functions.php';

# Load all of our enabled plugins and include the files

$plugins = Plugins::enabledPlugins(); 
if (is_array($plugins)) {
	foreach ($plugins as $plugin) {
		include_once PLUGIN_PATH.$plugin.'/'.$plugin.'.php';
	}	
}
