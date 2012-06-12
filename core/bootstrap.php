<?php

/**
* @package CandyCMS
* @version 0.6.1
* @since 0.1
* @copyright Copyright 2012 (C) Cocoon Design Ltd. - All Rights Reserved
* 
* This file is the main bootstrap for CandyCMS
*/

define('CANDYVERSION', '0.6.1');

/**
 * Set the development enviornment
 * @options development or production
 */

define('ENVIRONMENT', 'dev');

if (ENVIRONMENT == 'dev') {
	ini_set('display_errors', 1);
} else {
	ini_set('display_errors', 0);
}

error_reporting(E_ALL);

# Check which version of PHP is running

if (version_compare(phpversion(), '5.3', '<=')) {
	echo 'Sorry, CandyCMS requires PHP version 5.3, you\'re currently running: ' . phpversion();
	exit(1);
}

# Load our user defined config file

require_once 'config.php';

# Fire up the autoloader I'm going back to 1977!

function __autoload($class_name) {
	include 'classes/'. $class_name . '.php';
}

# Let's load in our functions file. It's gonna be big!

require_once 'functions.php';

# Load all of our enabled plugins and include the files

$plugins = Plugins::enabledPlugins(); 
if (is_array($plugins)) {
	foreach ($plugins as $plugin) {
		include PLUGIN_PATH.$plugin.'/'.$plugin.'.php';
	}	
}

# RUN!

CandyCMS::run();