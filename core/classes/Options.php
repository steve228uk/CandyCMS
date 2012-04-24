<?php

/**
* @package CandyCMS
* @version 0.1
* @copyright Copyright 2012 (C) Cocoon Design Ltd. - All Rights Reserved
* 
* Functions for loading from the Options table in the DB
*/


class Options {
	
	/**
	 * @returns string or false
	 */
	
	public static function candytitle(){
		
		$dbh = new CandyDB();
		$sth = $dbh->prepare('SELECT option_value FROM '. DB_PREFIX .'options WHERE option_key = "site_title"');
		$sth->execute();
		
		return $sth->fetchColumn();
		
	}
	
	/**
	 * @returns string or false
	 */
	
	public static function currentTheme(){
		
		$dbh = new CandyDB();
		$sth = $dbh->prepare('SELECT option_value FROM '. DB_PREFIX .'options WHERE option_key = "theme"');
		$sth->execute();
		
		return $sth->fetchColumn();
		
	}
	
	/**
	 * @returns string or false
	 */
	
	public static function homePage(){
		
		$dbh = new CandyDB();
		$sth = $dbh->prepare('SELECT option_value FROM '. DB_PREFIX .'options WHERE option_key = "homepage"');
		$sth->execute();
		
		return $sth->fetchColumn();
		
	}
	
	/**
	 * @returns string or false
	 */
	 
	public static function siteUrl(){
		
		$dbh = new CandyDB();
		$sth = $dbh->prepare('SELECT option_value FROM '. DB_PREFIX .'options WHERE option_key = "site_url"');
		$sth->execute();
		
		return $sth->fetchColumn();
		
	}
	
}
