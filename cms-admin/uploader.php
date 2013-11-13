<?

// todo: Make this a little more secure! 

require_once '../core/config.php';

// files storage folder
$dir = '../uploads/';

$_FILES['file']['type'] = strtolower($_FILES['file']['type']);
 
if ($_FILES['file']['type'] == 'image/png' 
|| $_FILES['file']['type'] == 'image/jpg' 
|| $_FILES['file']['type'] == 'image/gif' 
|| $_FILES['file']['type'] == 'image/jpeg'
|| $_FILES['file']['type'] == 'image/pjpeg')
{	
    // setting file's mysterious name
    $file = md5(date('YmdHis')).'.jpg';
 
    // copying
    copy($_FILES['file']['tmp_name'], $dir.$file);
 
    // displaying file
    $array = array('filelink' => URL_PATH.'uploads/'.$file);
	
    echo stripslashes(json_encode($array));   
}
//
//{
//    "error": "Hi! It's error message"
//}