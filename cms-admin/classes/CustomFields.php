<?php

/**
* @class CustomFields
* @version 0.6
* @since 0.6
* 
* Methods for Custom Fields
*/ 

class CustomFields {
	
	public static function listFields($name = false){
		
		$fields = array();
		
		$fields['wysi'] = array('title' => 'WYSIWYG', 'desc' => 'WYSIWYG Text Area', 'icon' => 'icon-pencil', 'input' => '<textarea class="ckeditor" name="'.$name.'"></textarea>');
		$fields['box'] = array('title' => 'Text Box', 'desc' => 'Single Line Text Field', 'icon' => 'icon-font', 'input' => '<textarea name="'.$name.'"></textarea>');
		$fields['field'] = array('title' => 'Text Field', 'desc' => 'A Blank Text Field', 'icon' => 'icon-text-width', 'input' => '<input type="text" name="'.$name.'" />');
		
		return $fields;
	}
	
	public static function getInput($key, $name){
	
		$fields = self::listFields($name);
		
		$input = $fields[$key]['input'];
		
		return $input;
		
	}
	
}