<?php

/**
* @package CandyCMS
* @version 0.6
* @since 0.1
* @copyright Copyright 2012 (C) Cocoon Design Ltd. - All Rights Reserved
* 
* Methods for loading pages
*/

class Pages {
	
	/**
	 * @returns array
	 */
	
	public static function loadPage($page){
		
		$dbh = new CandyDB();
		$sth = $dbh->prepare('SELECT * FROM '. DB_PREFIX .'pages WHERE rewrite = "' . $page . '"');
		$sth->execute();
		
		return $sth->fetchAll();
		
	}
	
	/**
	 * @returns string
	 */
	
	public static function pageTitle($page){
		$dbh = new CandyDB();
		$sth = $dbh->prepare('SELECT page_title FROM '. DB_PREFIX .'pages WHERE rewrite = "' . $page . '"');
		$sth->execute();
		
		return $sth->fetchColumn();
	}
	
	/**
	 * @returns string
	 */
	
	public static function theContent($page){
		$dbh = new CandyDB();
		$sth = $dbh->prepare('SELECT page_body FROM '. DB_PREFIX .'pages WHERE rewrite = "' . $page . '"');
		$sth->execute();
		
		$content = $sth->fetchColumn();
		
		$plugins = Plugins::enabledPlugins();
		
		foreach ($plugins as $plugin) {
			
			if (method_exists($plugin, 'addShorttag')) {
				$replace = $plugin::addShorttag();
				
				foreach ($replace as $key => $value) {
					$content = str_replace($key, $value, $content);	
				}
				
			}
			
		}
		
		echo $content;
	}
	
	/**
	 * @returns string
	 */
	 
	 public static function theTitle($page){
	 	$dbh = new CandyDB();
	 	$sth = $dbh->prepare('SELECT page_title FROM '. DB_PREFIX .'pages WHERE rewrite = "' . $page . '"');
	 	$sth->execute();
	 	
	 	return $sth->fetchColumn();
	 }
	 
	 /**
	  * @returns array
	  */
	 
	 public static function listPages(){
	 
	 	$dbh = new CandyDB();
	 	$sth = $dbh->prepare('SELECT * FROM '. DB_PREFIX .'pages WHERE innav = "1" ORDER BY navpos');
	 	$sth->execute();
	 	
	 	return $sth->fetchAll(PDO::FETCH_CLASS);
	 	
	 }
	 
	 public static function getPageId($page){
	 	
	 	$dbh = new CandyDB();
	 	$sth = $dbh->prepare('SELECT page_id FROM '. DB_PREFIX .'pages WHERE rewrite = "' . $page . '"');
	 	$sth->execute();
	 	
	 	return $sth->fetchColumn();
	 	
	 }
	
}