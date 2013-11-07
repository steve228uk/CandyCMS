<?

/**
* @package CandyCMS
* @version 0.1
* @copyright Copyright 2012 (C) Cocoon Design Ltd. - All Rights Reserved
* 
* Logout - Destroys session
*/


session_start();
$_SESSION = array();
session_destroy();

header('Location: login.php');