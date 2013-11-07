<?

/**
* @package CandyCMS
* @version 0.1
* @copyright Copyright 2012 (C) Cocoon Design Ltd. - All Rights Reserved
* 
* Methods for loading and enabling plugins
*/

class Plugins {

	public static function listPlugins(){
		
		$plugins = PLUGIN_PATH;
		$plugins = scandir($plugins);
		array_shift($plugins);
		array_shift($plugins);
		
		$plugininfo = array();
		
		if (!empty($plugins)) {
		
			foreach ($plugins as $plugin) {
				
				$file = file_get_contents(PLUGIN_PATH.$plugin.'/'.$plugin.'.php', 'r');
				
				$pieces = explode('*/', $file);
				
				$info = explode('*', $pieces[0]);
				
				array_shift($info);
				array_shift($info);
				
				$i = 0;
				
				$pluginarr = array();
				
				foreach ($info as $key => $value) {
					$trimmed = trim($value);
					$pieces = explode(' ', $trimmed);
					$key = trim($pieces[0], '@');
					
					array_shift($pieces);
					
					$value = implode(' ', $pieces);
					
					$pluginarr[$key] = $value;
				}
				
				$pluginarr['dir'] = $plugin;
				
				$plugininfo[] = $pluginarr;	
			}
			
			return $plugininfo;
			
		} else {
			return false;
		}
		
	}
	
	public static function enabledPlugins() {
	
		$dbh = new CandyDB();
		$sth = $dbh->prepare('SELECT option_value FROM '. DB_PREFIX .'options WHERE option_key = "enabled_plugins"');
		$sth->execute();
		
		$plugins = $sth->fetchColumn();
		
		if ($plugins != false) {
			$plugins = json_decode($plugins);	
			return $plugins;
		} else {
			return false;
		}
	
	}

}

?>