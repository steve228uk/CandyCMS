<?php

/**
* @package CandyCMS
* @version 0.7.4
* @since 0.1
* @copyright Copyright 2012 (C) Cocoon Design Ltd. - All Rights Reserved
* 
* This file is the main bootstrap for CandyCMS
*/

define('CANDYVERSION', '0.7.4');


# Load our user defined config file

require_once 'config.php';

/**
 * Set the development environment
 * @options development or production
 */

if(!defined('ENVIRONMENT')) {
	define('ENVIRONMENT', 'production');
}

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

# Fire up the autoloader I'm going back to 1977!

function __autoload($class_name) {
	include 'classes/'. $class_name . '.php';
}

# Load the core classes into an array

CandyCMS::init();

# Let's load in our functions file. It's gonna be big!

require_once 'functions.php';

# Load all of our enabled plugins and include the files
$Plugins = array();
$plugins = Plugins::enabledPlugins();

if (is_array($plugins)) {
	foreach ($plugins as $plugin) {
		include PLUGIN_PATH.$plugin.'/'.$plugin.'.php';
		$Plugins[$plugin] = new $plugin;
	}	
}

CandyCMS::run();
