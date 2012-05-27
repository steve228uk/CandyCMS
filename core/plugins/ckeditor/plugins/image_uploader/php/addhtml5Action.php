 <?php
// Place to set downloaded images
$url = $_GET['url'];
$upload_folder = $config['public'].$config['pictures'].$url;

// If browser operate with sendAsBinary() function then we capture data with $_FILES array
if(count($_FILES)>0) {

	if (file_exists($upload_folder.'/'.$_FILES['upload']['name']) )
	{
		$pathinfo = pathinfo($_FILES['upload']['name']);
		$i = 0;
		do
		{
			++$i;
			$newpath = str_replace(' ', '_', $pathinfo['filename'].sprintf("%02d", $i)).'.'.$pathinfo['extension'];
		}
		while (file_exists($upload_folder.'/'.$newpath) == true);
		move_uploaded_file($_FILES['upload']['tmp_name'] , $upload_folder.'/'.$newpath );
	}
		
	if( move_uploaded_file($_FILES['upload']['tmp_name'] , $upload_folder.$_FILES['upload']['name'] ) ) {
	
	}
	exit();
} else if(isset($_GET['up'])) {
	// If browser sended data not by sendAsBinary() function
	if(isset($_GET['base64'])) {
		$content = base64_decode(file_get_contents('php://input'));
	} else {
		$content = file_get_contents('php://input');
	}

	$headers = getallheaders();
	$headers = array_change_key_case($headers, CASE_UPPER);


	if (file_exists($upload_folder.'/'.$headers['UP-FILENAME']) )
	{
		$pathinfo = pathinfo($headers['UP-FILENAME']);
		$i = 0;
		do
		{
			++$i;
			$newpath = str_replace(' ', '_',$pathinfo['filename'].sprintf("%02d", $i)).'.'.$pathinfo['extension'];
		}
		while (file_exists($upload_folder.'/'.$newpath) == true);
		if(file_put_contents($upload_folder.'/'.$newpath, $content)) {
	
		}
	} else {
		if(file_put_contents($upload_folder.'/'.$headers['UP-FILENAME'], $content)) {
	
		}

	}

	exit();
}
