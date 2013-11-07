<?

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
	
		$html = '<h3>'.$_POST['title'].'</h3><p>'.$_POST['desc'].'</p>'.CustomFields::getInput($_POST['key'], $_POST['name']);
		$html .= '<input type="hidden" name="cfield['.$_POST['name'].']" value="'.$_POST['key'].'">';
		$html .= '<input type="hidden" name="cf-title['.$_POST['name'].']" value="'.$_POST['title'].'">';
		$html .= '<input type="hidden" name="cf-desc['.$_POST['name'].']" value="'.$_POST['desc'].'">';
		echo $html;
	}
}