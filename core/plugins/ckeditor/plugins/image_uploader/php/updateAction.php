 <?php

// This block is start when user add file
// This function copy all files to temp-dir, after copy start add block

$url = "";
@$url = $_POST['url'];
$url = explode('/',$url);
unset($url[0]);
$url = join('/',$url);

// Multidata is special parameter. Is set only when user not use fancy uploader
// Multidata is counter of upload filres
$multidata = 0;
@$multidata = (int)$_GET['multidata'];
$multidata--;
$is_multi = true;
if($multidata < 1)
{
	$is_multi = false;
		
}
if($multidata < 0)
{
	$multidata = 1;
}
$multi_return = array();

// If user use fancy uploader multidata == 1
for($i=1; $i<= $multidata ; $i++)
{
	if(!$is_multi)
	$i='';
	$error = false;
		
	$file_name = $_FILES['Filedata'.$i]['name'];
	$file_path = $config['public'] . $config['temp_dir'] . $file_name;
	$pathinfo = pathinfo($file_path);
	// Error checking
	if (!isset($_FILES["Filedata".$i]) || !is_uploaded_file($_FILES["Filedata".$i]['tmp_name']))
	{
		var_dump($_FILES["Filedata".$i]);
		$error = 'Invalid Upload';
	}

	if (!$error && $_FILES['Filedata'.$i]['size'] > $config['max_file_size'] * 1024 * 1024)
	{
		$error = 'Invalid Upload max '.$config['max_file_size'].'MB';
	}
		
	if (file_exists($file_path) )
	{
		// Check, if file with the same name exists
		// If yes - add counter to the end of file name

		$i = 0;
		do
		{
			++$i;
			if(strlen($url) > 2 )
			$new_file_path = $pathinfo['dirname'].'/'.$url.'/'.$pathinfo['filename'].sprintf("%02d", $i).'.'.$pathinfo['extension'];
			else
			$new_file_path = $pathinfo['dirname'].'/'.$pathinfo['filename'].sprintf("%02d", $i).'.'.$pathinfo['extension'];
		}
		while (file_exists($new_file_path)==true);
		$file_path = $new_file_path;
		$pathinfo = pathinfo($file_path);
	}
		
	// Return fail
	if ($error)
	{
		$return = array('code' => 0, 'error' => $error);
	}
	else
	{
		// Move file to destination folder
		@move_uploaded_file($_FILES['Filedata'.$i]['tmp_name'], $file_path);
			
		// Return success
		$return = array('code' => 1, 'name' => $pathinfo['basename']);

		if (isset($size) && $size) {
			$return['width'] = $size[0];
			$return['height'] = $size[1];
			$return['mime'] = $size['mime'];
		}
	}
	if(!$is_multi)
	$i=100;
	else
	array_push($multi_return, $return);
}
if($is_multi)
$return = $multi_return;
// Send return data in JSON
echo json_encode($return);