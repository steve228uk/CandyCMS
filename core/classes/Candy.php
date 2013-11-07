<?

/**
 * @package CandyCMS
 * @version 0.7
 * @since 0.1
 * @copyright Copyright 2012 (C) Cocoon Design Ltd. - All Rights Reserved
 *
 * @property Options options
 * @property Pages pages
 * @property CandyCMS system
 *
 * The main router for CandyCMS
 */

class Candy {

	static $properties = array();
	
	public static function init() {
		self::import('Options');
		self::import('Pages');
		self::import('System', 'Candy');
	}

	public static function __callStatic($name, $parameters) {
		$return = self::$properties[strtolower($name)];
		if(is_callable($return)) {
			$return = call_user_func_array($return, $parameters);
		}
		return $return;
	}

	public static function import($reference, $classname = null) {
		if(is_null($classname)) {
			$classname = $reference;
		}
		self::$properties[strtolower($reference)] = new $classname;
	}

	public static function run() {
		$theme = Candy::Options('theme');

		$page = (isset($_GET['page'])) ? $_GET['page'] : Candy::Options('homepage');

		$pageInfo = Candy::Pages()->loadPage($page);

		if (empty($pageInfo)) { header("HTTP/1.0 404 Not Found"); }

		include(THEME_PATH.$theme.'/header.php');

		if (!empty($pageInfo)) {
			include(THEME_PATH.$theme.'/templates/'.$pageInfo[0]->page_template.'.php');
		} else {
			include(THEME_PATH.$theme.'/404.php');
		}

		include(THEME_PATH.$theme.'/footer.php');
	}
	
}