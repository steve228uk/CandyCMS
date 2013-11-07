<?

/**
* @package CandyCMS
* @version 1.0
* @since 0.1
* @copyright Copyright 2012 (C) Cocoon Design Ltd. - All Rights Reserved
* 
* Functions for loading from the Options table in the DB
*/

class Options {
	
	public function __invoke($name = null, $default = null) {

		if (!is_null($name)) {
			
			static $options;

			if(!isset($options)) {
				$options = CandyDB::keyvalue('SELECT option_key, option_value FROM '. DB_PREFIX .'options');
			}

			if(isset($options[$name])) {
				return $options[$name];
			} else {
				return $default;
			}

		}
	}

	public function set($name, $value) {
		CandyDB::q('INSERT INTO ' . DB_PREFIX . 'options (option_key, option_value) VALUES (:name, :value) ON DUPLICATE KEY UPDATE option_value = :value', compact('name', 'value'));
	}

	public function test(){
		echo 'testing 123';
	}

}
