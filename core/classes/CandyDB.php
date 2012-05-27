<?php

/**
* @package CandyCMS
* @version 0.1
* @copyright Copyright 2012 (C) Cocoon Design Ltd. - All Rights Reserved
* 
* Extends PDO
*/

class CandyDB extends PDO {
	
	/**
	 * @method __construct()
	 * @returns nothing
	 * 
	 * Connects to the database using defined constants
	 */
	
	function __construct(){
		parent::__construct(DB_DRIVER.':dbname='.DB_NAME.';host='.DB_HOST, DB_USERNAME, DB_PASSWORD);
	}
	
}