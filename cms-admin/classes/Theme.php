<?

/**
* @package CandyCMS
* @version 0.6.1
* @since 0.1
* @copyright Copyright 2012 (C) Cocoon Design Ltd. - All Rights Reserved
* 
* Methods for listing and changing the theme
*/

class Theme {

	/**
	 * @returns array
	 */
	
	public static function listThemes(){
		
		$themes = THEME_PATH;
		$themes = scandir($themes);
		array_shift($themes);
		array_shift($themes);
		
		$themeinfo = array();
		
		foreach ($themes as $theme) {
			
			$file = file_get_contents(THEME_PATH.$theme.'/css/styles.css', 'r');
			
			$pieces = explode('*/', $file);
			
			$info = explode('*', $pieces[0]);
			
			array_shift($info);
			
			$i = 0;
			
			$themearr = array();
			
			foreach ($info as $value) {
				
				$trimmed = trim($value);
				$pieces = explode(' ', $trimmed);
				$key = trim($pieces[0], '@');
				
				array_shift($pieces);
				
				$value = implode(' ', $pieces);
				
				$themearr[$key] = $value;
			}
			
			$themearr['dir'] = $theme;
			
			$themeinfo[] = $themearr;
		}
		
		return $themeinfo;
		
	}

	
	public static function setTheme($dir){
		
		$dbh = new CandyDB();
		$sth = $dbh->prepare('UPDATE '. DB_PREFIX .'options SET option_value="'. $dir .'" WHERE option_key="theme"');
		$sth->execute();
		
	}
	
	/**
	 * @returns array
	 */
	
	public static function listTemplates(){
		
		$theme = Candy::Options('theme');
		
		$templates = THEME_PATH.$theme.'/templates';
		$templates = scandir($templates);
		array_shift($templates);
		array_shift($templates);
		
		$templateinfo = array();
		
		foreach ($templates as $template) {
			
			$file = file_get_contents(THEME_PATH.$theme.'/templates/'.$template);
			
			$pieces = explode('*/', $file);
			
			$info = explode('*', $pieces[0]);
			
			array_shift($info);
			array_pop($info);
			
			$i = 0;
			
			$temparr = array();
			
			foreach ($info as $value) {
				
				$trimmed = trim($value);
				$pieces = explode(' ', $trimmed);
				$key = trim($pieces[0], '@');
				
				array_shift($pieces);
				
				$value = implode(' ', $pieces);
				
				$temparr[$key] = $value;
				
				$temparr['file'] = str_replace('.php', '', $template);
			}
			
			$templateinfo[] = $temparr;
			
		}
		
		return $templateinfo;
	}
	
	/**
	 * @returns echos <select>
	 */
	
	public static function dropdownTemplates($page = false, $name = 'template'){
		
		$templates = self::listTemplates();
		
		$html = "<select name='$name' id='$name'>";
		
		foreach ($templates as $template) {
			
			if ($page != false) {
				$pageinfo = Pages::pageInfo($page);
				
				if ($pageinfo[0]->page_template == $template['file']) {
					$html .= "<option value='{$template['file']}' selected='selected'>";	
				} else {
					$html .= "<option value='{$template['file']}'>";
				}
							
			} else {
				$html .= "<option value='{$template['file']}'>";
			}
		
			$html .= $template['template'];
			$html .= '</option>';	
		}
		
		$html .= "</select>";
		
		echo $html;
	}
	
	public static function setColors($array){
		
		$insert = addslashes(json_encode($array));
		
		$dbh = new CandyDB();
		$dbh->exec("UPDATE ". DB_PREFIX ."options SET option_value='$insert' WHERE option_key='colors'");
	}
	
	public static function getColors(){
		
		$dbh = new CandyDB();
		$sth = $dbh->prepare('SELECT option_value FROM '. DB_PREFIX .'options WHERE option_key = "colors"');
		$sth->execute();
		
		$colors = $sth->fetchColumn();
		$colors = json_decode($colors);
		
		return $colors;
					
	}
	
}