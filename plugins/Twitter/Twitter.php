<?php
/**
 * @plugin Twitter Widget
 * @author Cocoon Design
 * @authorURI http://www.wearecocoon.co.uk/
 * @description Adds a Twitter account feed to the dashboard
 * @copyright 2012 (C) Cocoon Design  
 */
 
 class Twitter {
 	public static function install(){
 		
 		# todo: only allow install to run once!
 		
 		$dbh = new CandyDB();
 		$dbh->exec("INSERT INTO ". DB_PREFIX ."options (option_key, option_value) VALUES ('twitterwidget', 'cocoonuk')");
 		
 	}
 	
 	public static function adminSettings(){
 		
 		$twitter = self::twitterAccount();
 		
 		$html = "<ul>";
 		$html .= "<li>";
 		$html .= "<label>Twitter Account</label>";
 		
 		$html .= "<input type='text' name='twitterwidget' value='$twitter'/>";
 		
 		$html .= "</li>";
 		$html .= "</ul>";
 		
 		return $html;
 	}
 	
 	public static function saveSettings(){
 		$account = $_POST['twitterwidget'];
 		
 		$dbh = new CandyDB();
 		$dbh->exec('UPDATE '. DB_PREFIX .'options SET option_value="'. $account .'" WHERE option_key="twitterwidget"');
 		
 	}
 	
 	public static function twitterAccount(){
 	
 		$dbh = new CandyDB();
 		$sth = $dbh->prepare('SELECT option_value FROM '. DB_PREFIX .'options WHERE option_key = "twitterwidget"');
 		$sth->execute();
 		
 		return $sth->fetchColumn();
 	
 	}
 }