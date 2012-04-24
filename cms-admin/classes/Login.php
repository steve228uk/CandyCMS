<?php

/**
* @package CandyCMS
* @version 0.1
* @copyright Copyright 2012 (C) Cocoon Design Ltd. - All Rights Reserved
* 
* Login class for CandyCMS
*/

class Login {
	
	public static function signin($username, $password){
		
		$salt = SALT;
		$user = $username;
		$pass = sha1($password.$salt);
		
		$dbh = new CandyDB();
		$sth = $dbh->prepare('SELECT name FROM '. DB_PREFIX .'users WHERE username = "'. $user .'" AND password = "'. $pass .'"');
		$sth->execute();
		
		$result = $sth->fetchColumn();
		
		$return = ($result != false) ? true : false;
	
		return $return;

	}
	
}