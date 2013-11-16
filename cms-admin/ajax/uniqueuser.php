<?
ini_set('display_errors', 1);

function __autoload($class_name) {

    if (file_exists("../classes/$class_name.php")) {
        include '../classes/'. $class_name . '.php';
    } else {
        include CMS_PATH.'core/classes/'. $class_name . '.php';
    }
}

require_once '../../core/config.php';

if ( User::uniqueUser( $_POST['username'] ) ){
	echo 1;
} else {
	echo 0;
}