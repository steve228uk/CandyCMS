<?php
ini_set('display_errors', 1);

# Fire up the autoloader, using an anonymous function as of PHP 5.3.0
spl_autoload_register(function ($class) {
    if (file_exists("../classes/$class.php")) {
        include '../classes/'. $class . '.php';
    } else {
        include CMS_PATH.'core/classes/'. $class . '.php';
    }
});

require_once '../../core/config.php';

if ( User::uniqueUser( $_POST['username'] ) ){
	echo 1;
} else {
	echo 0;
}