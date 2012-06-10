<?php

/**
* @class CustomFields
* @version 0.6
* @since 0.6
* 
* Methods for Custom Fields
*/ 

class CustomFields {
	
	public static function listFields($name = false, $value = false){
		
		$fields = array();
		
		$fields['wysi'] = array('title' => 'WYSIWYG', 'desc' => 'WYSIWYG Text Area', 'icon' => 'icon-pencil', 'input' => '<textarea class="ckeditor" name="'.$name.'">'.$value.'</textarea>');
		$fields['box'] = array('title' => 'Text Box', 'desc' => 'Single Line Text Field', 'icon' => 'icon-font', 'input' => '<textarea name="'.$name.'">'.$value.'</textarea>');
		$fields['field'] = array('title' => 'Text Field', 'desc' => 'A Blank Text Field', 'icon' => 'icon-text-width', 'input' => '<input type="text" name="'.$name.'" value="'.$value.'" />');
		
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
	
}