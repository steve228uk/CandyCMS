<?

/**
* @package CandyCMS
* @version 0.5.3
* @since 0.1
* @copyright Copyright 2012 (C) Cocoon Design Ltd. - All Rights Reserved
* 
* Methods for loading and enabling plugins
*/

class Plugins {

	public static function listPlugins(){
		
	    chdir(PLUGIN_PATH);
        $plugins = array_filter(glob('*'), 'is_dir');
		
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
	
	public static function savePlugins($enabled) {
		
		$json = json_encode($enabled);

		$dbh = new CandyDB();
		$sth = $dbh->prepare("UPDATE ". DB_PREFIX ."options SET option_value='". $json ."' WHERE option_key='enabled_plugins'");
		$sth->execute();

		self::installPlugin($enabled);
	}
	
	private static function installPlugin($plugins){
		
		foreach ($plugins as $plugin) {
			
			$file = PLUGIN_PATH."$plugin/$plugin.php";
			
			if (file_exists($file)) {
				
				include_once $file;
				
				if (method_exists($plugin, 'install')) {
					$plugin::install();	
				}
				
			}
			
		}
		
	}
	
	private static function getWidgetTitle($plugin){
		
		$file = PLUGIN_PATH."$plugin/widget.php";
		
		$conts = file_get_contents($file);
		
		$pieces = explode('*/', $conts);
		
		$info = explode('*', $pieces[0]);
		
		array_shift($info);
		array_shift($info);
		array_shift($info);
		
		$title = explode(' ', $info[0]);
		
		array_shift($title);
		array_shift($title);
		
		$title = implode(' ', $title);
		
		return $title;
		
	}
	
	public static function getWidgets(){
		
		$plugins = self::enabledPlugins();
		
		$i = 1;
		
		foreach ($plugins as $plugin) {
			$file = PLUGIN_PATH."$plugin/widget.php";
			if (file_exists($file)) {
				
				$title = self::getWidgetTitle($plugin);
				
				echo ($i%2 == 0) ? "<div class='widget right clearr'>" : "<div class='widget left clearl'>";
				
				$i++;
				
				echo "<div class='widget-ttl'>$title</div>";
				echo "<div class='widget-cont'>";
				include_once $file;
				echo "</div></div>";
			}
		}
		
	}
}