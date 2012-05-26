<?php

/**
* @package CandyCMS
* @version 0.1
* @copyright Copyright 2012 (C) Cocoon Design Ltd. - All Rights Reserved
* 
* Admin functions
*/

function adminNav(){
	$adminnav = array('pages' => 'Pages');
	$plugins = Plugins::enabledPlugins();
	
	$nav = $adminnav;
	
	foreach ($plugins as $plugin) {
		
		if (method_exists($plugin, 'adminNav')) {
			
			$array = $plugin::adminNav();
			
			$nav[] = $array;
			
		}
		
	}
	
	$theme = Options::currentTheme();
	
	if (file_exists(THEME_PATH.$theme.'/css/user.php') && $_SESSION['role'] == 'admin') {
		$nav[] = array('theme' => 'Appearance');
	}
	
	$nav[] = array('nav' => 'Navigation');
	
	if ($_SESSION['role'] == 'admin') {
		$nav[] = array('plugins' => 'Plugins', 'settings' => 'Settings');
	}
	
	return $nav;
}

function genAdminNav($key, $value, $active = false){

	$html = ($active == $value && $active != false) ? '<li class="active">' : '<li>';

	$html .= "<a href='dashboard.php?page=$value'>$key</a>";
	$html .= '</li>';			
	
	echo $html;
	
}

function deleteDir($dir) { 
   if (substr($dir, strlen($dir)-1, 1) != '/') 
       $dir .= '/'; 

   if ($handle = opendir($dir)) 
   { 
       while ($obj = readdir($handle)) 
       { 
           if ($obj != '.' && $obj != '..') 
           { 
               if (is_dir($dir.$obj)) 
               { 
                   if (!deleteDir($dir.$obj)) 
                       return false; 
               } 
               elseif (is_file($dir.$obj)) 
               { 
                   if (!unlink($dir.$obj)) 
                       return false; 
               } 
           } 
       } 

       closedir($handle); 

       if (!@rmdir($dir)) 
           return false; 
       return true; 
   } 
   return false; 
}  

function adminHead(){
	
	$plugins = Plugins::enabledPlugins();
	
	$html = '';
	
	foreach ($plugins as $plugin) {
		if (method_exists($plugin, 'adminHead')) {
			$html .= $plugin::adminHead();
		}
	}
	
	echo $html;
	
}