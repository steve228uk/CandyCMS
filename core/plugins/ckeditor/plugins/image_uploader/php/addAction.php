 <?php
// Copy updated files to select directory
try{
	$param = $_POST['url'];

	// Converting url
	$param = urldecode($param);
	$lenght = strlen($param);
	if($lenght > 0 && $param[$lenght -1] == '/')
	{
		$param = substr($param, 0, -1);
	}
	if(isset($param[0]))
	$param.='/';
		
		
	$data = array();
			
	// Copy file
	$data['name'] = trim(stripslashes(substr($_GET['file'],0,100))); // File name with extension
	$data['path'] = $param . str_replace(' ', '_', $data['name']); // File path

	$new_file_path = $_GET['file'];
	$pi = pathinfo($_GET['file']);
	//$new_file_path = str_replace(' ','_',$pi['filename'].'.'.$pi['extension']);
		
	$target_file_path = str_replace(' ','_',$pi['filename'].'.'.$pi['extension']);

	if($param == '//////')
	{
		echo '{"error":"true", "src":"NULL", "file":"NULL"}';
		return;
	}
	if (file_exists($config['public'].$config['pictures'].$param.$_GET['file']) )
	{
		// Check, if file with the same name exists
		// If yes - add counter to the end of file name
		$pathinfo = pathinfo($_GET['file']);
		$i = 0;
		do
		{
			++$i;
			$new_file_path = str_replace(' ','_',$pathinfo['filename']).sprintf("%02d", $i).'.'.$pathinfo['extension'];
		}
		while (file_exists($config['public'].$config['pictures'].$param.$target_file_path) == true);
	}
	@$size = getimagesize($config['public'].$config['temp_dir'].$_GET['file']);
	@$x = $size[0];
	@$y = $size[1];
	$copy = @copy($config['public'].$config['temp_dir'].$_GET['file']  , $config['public'].$config['pictures'].$param.$target_file_path);
	tryThumbnail($config, $param,$target_file_path);

	@unlink($config['public'].$config['temp_dir'].$_GET['file']);
	if($copy)
	echo '{"src":"'.$data['path'].'", "file":"'.$target_file_path.'", "x":"'.$x.'", "y":"'.$y.'"}';
	else
	echo '{"error":"true", "src":"'.$data['path'].'", "file":"'.$target_file_path.'"}';
}
catch (Exception $e)
{
	echo '{"error":"true", "src":"'.$e->getMessage().'", "file":"'.$e->getMessage().'"}';
}