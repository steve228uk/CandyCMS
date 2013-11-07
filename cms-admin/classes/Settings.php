<?

class Settings {

	public static function updateSettings($site_title, $theme, $homepage, $site_url) {
		
		$data = array('site_title' => $site_title, 'theme' => $theme, 'homepage' => $homepage, 'site_url' => $site_url);
		
		$dbh = new CandyDB();
		
		foreach ($data as $key => $value) {
			$sth = $dbh->prepare('UPDATE '. DB_PREFIX .'options SET option_value="'. $value .'" WHERE option_key="'. $key .'"');
			$sth->execute();
		}
		
		$plugins = Plugins::enabledPlugins();
		
		foreach ($plugins as $plugin) {
			if (method_exists($plugin, 'saveSettings')) {
				
				$plugin::saveSettings();
				
			}	
		}
		
	}
	
	public static function pluginSettings(){
	
		$plugins = Plugins::enabledPlugins();
		
		$html = '';
		
		foreach ($plugins as $plugin) {
			
			if (method_exists($plugin, 'adminSettings')) {
				$html .= "<fieldset>";
						
				$html .= $plugin::adminSettings();
						
				$html .= "</fieldset>";
			}
				
		}
		
		echo $html;
	
	}

}