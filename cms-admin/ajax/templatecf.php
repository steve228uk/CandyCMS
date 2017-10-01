<?php

ini_set('display_errors', 1);

# Fire up the autoloader, using an anonymous function as of PHP 5.3.0
spl_autoload_register(function ($class) {
    if (file_exists("../classes/$class.php")) {
        include '../classes/'. $class . '.php';
    } else {
        include CMS_PATH.'core/classes/'. $class . '.php';
    }
});

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