<?php

/**
* @package CandyCMS
* @version 0.7
* @since 0.1
* @copyright Copyright 2012 (C) Cocoon Design Ltd. - All Rights Reserved
* 
* Methods for loading pages
*/

class Pages {
	
	public function loadPage($page){
		
		$dbh = new CandyDB();
		$sth = $dbh->prepare('SELECT * FROM '. DB_PREFIX .'pages WHERE rewrite = "' . $page . '"');
		$sth->execute();
		
		return $sth->fetchAll(PDO::FETCH_CLASS);
	}
	
	public function getInfo($col, $page){
		$dbh = new CandyDB();
		$sth = $dbh->prepare('SELECT '.$col.' FROM '. DB_PREFIX .'pages WHERE rewrite = "' . $page . '"');
		$sth->execute();
		
		return $sth->fetchColumn();
	}
	 
	 public function listPages(){
	 
	 	$dbh = new CandyDB();
	 	$sth = $dbh->prepare('SELECT * FROM '. DB_PREFIX .'pages WHERE innav = "1" ORDER BY navpos');
	 	$sth->execute();
	 	
	 	return $sth->fetchAll(PDO::FETCH_CLASS);
	 	
	 }
}