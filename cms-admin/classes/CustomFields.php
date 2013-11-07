<?

/**
* @class CustomFields
* @version 0.7
* @since 0.6
* 
* Methods for Custom Fields
*/ 

class CustomFields {
	
	public static function listFields($name = false, $value = false){
		
		$fields = array();
		
		$fields['wysi'] = array('title' => 'WYSIWYG', 'desc' => 'WYSIWYG Text Area', 'icon' => 'icon-pencil', 'input' => '<textarea class="ckeditor" name="cf-update['.$name.']">'.$value.'</textarea>');
		$fields['box'] = array('title' => 'Text Box', 'desc' => 'Single Line Text Field', 'icon' => 'icon-font', 'input' => '<textarea name="cf-update['.$name.']">'.$value.'</textarea>');
		$fields['field'] = array('title' => 'Text Field', 'desc' => 'A Blank Text Field', 'icon' => 'icon-text-width', 'input' => '<input type="text" name="cf-update['.$name.']" value="'.$value.'" />');
		
		return $fields;
	}
	
	public static function getInput($key, $name, $value = false){
	
		$fields = self::listFields($name, $value);
		
		$input = $fields[$key]['input'];
		
		return $input;
		
	}
	
	public static function getAdminFields($page) {

		$dbh = new CandyDB();
		$sth = $dbh->prepare("SELECT * FROM ".DB_PREFIX."fields WHERE post_id=$page");
		$sth->execute();
		$fields = $sth->fetchAll(PDO::FETCH_CLASS);
		
		$return = '';
		
		foreach ($fields as $value) {
			$input = self::getInput($value->field_type, $value->field_name, $value->field_value);
			$return .= '<li>';
			$return .= '<h3>'.$value->field_title.'</h3>';
			$return .= '<p>'.$value->field_desc.'</p>';
			$return .= $input;
			$return .= '</li>';
		}
		
		echo $return;
		
	}
	
	public static function templateFields($template) {

		$theme = CandyDB::col('SELECT option_value FROM '.DB_PREFIX.'options WHERE option_key = :key', array('key' => 'theme'));
		
		$file = THEME_PATH.$theme.'/templates/'.$template.'.php';
		
		$contents = file_get_contents($file);
		
		$pieces = explode('*/', $contents);
		
		$info = explode('*', $pieces[0]);
		
		array_shift($info);
		array_shift($info);
		
		$temparr = array();
		
		foreach ($info as $value) {
			
			$trimmed = trim($value);
			$pieces = explode(' ', $trimmed);
			$key = trim($pieces[0], '@');
			
			array_shift($pieces);
			
			$value = implode(' ', $pieces);
			
			$temparr[$key] = $value;
		}
		
		$fieldarr = array();
		
		$fields = explode(',', $temparr['fields']);
		
		foreach ($fields as $key => $value) {
			$full = trim($value);
			$pieces = explode('-', $full);
			$fieldarr[] = array('name' => $pieces[0], 'type' => $pieces[1], 'title' => $pieces[2], 'desc' => $pieces[3]);
		}

		echo json_encode($fieldarr);
	
	}	
	
}