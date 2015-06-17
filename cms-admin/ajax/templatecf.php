<?php

ini_set('display_errors', 1);

function __autoload($class_name) {
	
	if (file_exists("../classes/$class_name.php")) {
		include '../classes/'. $class_name . '.php';
	} else {
		include CMS_PATH.'core/classes/'. $class_name . '.php';
	}
}

require_once '../../core/config.php';


$Candy = array();
$Candy['options'] = new Options;

if (isset($_POST['template'])) {
	CustomFields::templateFields($_POST['template']);	
} else {

	if($_POST['title'] != '' && $_POST['title'] != NULL) {

	$desc = (string) $_POST['desc'];
	$key = (string) $_POST['key'];
	$name = (string) $_POST['name'];
	$title = (string) $_POST['title'];

		$html = '<h3>'.$title.'</h3><p>'.$desc.'</p>'.CustomFields::getInput($_POST['key'], $name);
		$html .= '<input type="hidden" name="cfield['.$name.']" value="'.$key.'">';
		$html .= '<input type="hidden" name="cf-title['.$name.']" value="'.$title.'">';
		$html .= '<input type="hidden" name="cf-desc['.$name.']" value="'.$desc.'">';
		echo $html;
	}
}