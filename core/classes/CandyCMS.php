<?php

/**
* @package CandyCMS
* @version 0.1
* @copyright Copyright 2012 (C) Cocoon Design Ltd. - All Rights Reserved
* 
* The main router for CandyCMS
*/

class CandyCMS {
	
	public static function run(){
		
		$theme = Options::currentTheme();
		
		$page = (isset($_GET['page'])) ? $_GET['page'] : Options::homePage();
		
		$pageInfo = Pages::loadPage($page);
		
		if (empty($pageInfo)) { header("HTTP/1.0 404 Not Found"); }
		
		include(THEME_PATH.$theme.'/header.php');
		
		if (!empty($pageInfo)) {
			include(THEME_PATH.$theme.'/templates/'.$pageInfo[0]['page_template'].'.php');
		} else {
			include(THEME_PATH.$theme.'/404.php');
		}
		
		include(THEME_PATH.$theme.'/footer.php');
			
	}
	
}