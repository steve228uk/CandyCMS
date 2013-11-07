<?

/**
 * This file is simply for use of plugins and themes when core classes are needed without the header etc. of the full bootstrap
 */

require_once 'config.php';

function __autoload($class_name) {
	include 'classes/'. $class_name . '.php';
}