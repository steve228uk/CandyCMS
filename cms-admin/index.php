<?

/**
* @package CandyCMS
* @version 0.1
* @copyright Copyright 2012 (C) Cocoon Design Ltd. - All Rights Reserved
* 
* This file simply detirmines whether a user is logged in and redirects
*/

if(!isset($_SESSION['loggedin'])) header('Location: login.php');
else header('Location: dashboard.php');
exit();