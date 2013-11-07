<?

/**
* @package CandyCMS
* @version 1.0
* @copyright Copyright 2012 (C) Cocoon Design Ltd. - All Rights Reserved
* 
* Login class for CandyCMS
*/

class Login {
	
	public static function signin($username, $password){

		$name = CandyDB::val(
			'SELECT name FROM '. DB_PREFIX .'users WHERE username = :username AND password = :password',
			array(
				'username' => $username,
				'password' => sha1($password.SALT)
			)
		);

		return $name;

	}
	
}