<?

/**
* @package CandyCMS
* @version 0.1
* @copyright Copyright 2012 (C) Cocoon Design Ltd. - All Rights Reserved
* 
* Mainly gets colors for the theme from the db
*/

class Theme {
	
	public static function getColors(){
		
		$dbh = new CandyDB();
		$sth = $dbh->prepare('SELECT option_value FROM '. DB_PREFIX .'options WHERE option_key = "colors"');
		$sth->execute();
		
		$colors = $sth->fetchColumn();
		$colors = json_decode($colors);
		
		return $colors;
					
	}
	
}