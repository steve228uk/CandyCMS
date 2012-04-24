<?php

/**
* @package CandyCMS
* @version 0.1
* @copyright Copyright 2012 (C) Cocoon Design Ltd. - All Rights Reserved
* 
* Admin functions
*/

function adminNav(){
	$adminnav = array('Pages' => 'pages');
	$plugins = Plugins::enabledPlugins();
	
	$nav = $adminnav;
	
	foreach ($plugins as $plugin) {
		
		if (method_exists($plugin, 'adminNav')) {
			
			$array = $plugin::adminNav();
			
			$nav[] = $array;
			
		}
		
	}
	
	$theme = Options::currentTheme();
	
	if (file_exists(THEME_PATH.$theme.'/css/user.php')) {
		$nav[] = array('Apperance' => 'theme');
	}
	
	$nav[] = array('Navigation' => 'nav', 'Plugins' => 'plugins', 'Settings' => 'settings');
	
	return $nav;
}

function genAdminNav($value, $key){

	$html = '<li>';
	$html .= "<a href='dashboard.php?page=$value'>$key</a>";
	$html .= '</li>';			
	
	echo $html;
	
}