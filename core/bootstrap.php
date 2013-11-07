<?

/**
* @package CandyCMS
* @version 1.0.1
* @since 0.1
* @copyright Copyright 2012 (C) Cocoon Design Ltd. - All Rights Reserved
* 
* This file is the main bootstrap for CandyCMS
*/

define('CANDYVERSION', '1.0.1');

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
	echo 'Sorry, Candy requires PHP version 5.3, you\'re currently running: ' . phpversion();
	exit(1);
}

# Load our user defined config file

require_once 'config.php';

# Fire up the autoloader I'm going back to 1977!

spl_autoload_register(function ($class_name) {
	include 'classes/'. $class_name . '.php';
});

# Define the $Candy global for back-compatibality

$Candy = array();

# Load the core classes into an array

Candy::init();

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

# Run the system to create the frontend

Candy::run();