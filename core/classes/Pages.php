<?

/**
* @package CandyCMS
* @version 1.0
* @since 0.1
* @copyright Copyright 2012 (C) Cocoon Design Ltd. - All Rights Reserved
* 
* Methods for loading pages
*/

class Pages {
	
	public function loadPage($page){
		return CandyDB::results('SELECT * FROM '. DB_PREFIX .'pages WHERE rewrite = :page', array('page' => $page));
	}
	
	public function getInfo($col, $page){
		return CandyDB::col('SELECT '.$col.' FROM '. DB_PREFIX .'pages WHERE rewrite = :page', array('page' => $page));
	}
	 
	public function listPages(){
		return CandyDB::results('SELECT * FROM '. DB_PREFIX .'pages');
	}

	public function test(){
		echo 'test';
	}
}