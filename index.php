<?

/**
* @package CandyCMS
* @version 0.1
* @copyright Copyright 2012 (C) Cocoon Design Ltd. - All Rights Reserved
* 
* This file loads the bootstrap and sets up CandyCMS
*/

if (!file_exists('core/config.php')) {
	header('Location: install.php');
	exit(1);
}

require_once 'core/bootstrap.php';