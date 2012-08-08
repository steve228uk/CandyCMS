<?php

/**
* @package CandyCMS
* @version 0.7
* @since 0.1
* @copyright Copyright 2012 (C) Cocoon Design Ltd. - All Rights Reserved
* 
* Functions for loading from the Options table in the DB
*/


class Options {
	
	public function getOption($option){
	
		$dbh = new CandyDB();
		$sth = $dbh->prepare('SELECT option_value FROM '. DB_PREFIX .'options WHERE option_key = "'.$option.'"');
		$sth->execute();
		
		return stripslashes($sth->fetchColumn());
	
	}	
}
