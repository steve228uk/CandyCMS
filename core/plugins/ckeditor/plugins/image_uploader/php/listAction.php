 <?php
// Show all files in directory and clining cache
//lining cache (TEMP_dir) directory

$delpath = $config['public'] . $config['temp_dir'];
if(!is_dir($config['public'] . $config['temp_dir']))
{
	if(@mkdir($config['public'] . $config['temp_dir'], 0777))
	{
		$create = @chmod($config['public'] . $config['temp_dir'], 0777);
	}
}
$handler = @opendir($delpath);
while ($file = @readdir($handler)) {
	if ($file != '.' && $file != '..')
	{
		if(!is_dir( $delpath.'/'.$file ) )
		@unlink( $delpath.'/'.$file );
	}
}

$param = $_POST['param'];

// If search result
// Search POST '/////' 
// Search separator '#_!_#' 

if(strstr($param,'/////'))
{
		
	list($directory, $p) = explode('#_!_#',$param);		
	$param = str_replace('/////','',$p);
	$ret = array();
	if (file_exists($config['public'].$config['pictures'].$directory))
	{
		dirtree($config['public'],$config['pictures'].$directory, $ret, $param, $directory);
	}
	foreach($ret as $item)
	{
		$file_parts = pathinfo($item['src']);
		$param = $file_parts['dirname'];
		$file = $file_parts['basename'];
		if (file_exists($config['public'].$config['pictures'].$param))
		{
			$handler = @opendir($config['public'].$config['pictures'].$param);
				
			$lenght = strlen($param);
			if($param[$lenght -1] != '/')
			{
				$param = $param.'/';
			}
			if(!is_dir($config['public'].$config['pictures'].$param.$file))
			{
				if(strtolower($file_parts['extension']) == 'jpeg' || strtolower($file_parts['extension']) == 'jpg' || strtolower($file_parts['extension']) == 'png' || strtolower($file_parts['extension']) == 'gif' || strtolower($file_parts['extension']) == 'bmp')
				{
					// Try directory to file
					tryThumbnail($config, $param, $file);
				}
			}
		}
	}
	$return = array('picture' =>$ret);
	echo json_encode($return);
}

// If print directory files (not search)

else
{
	$pictureList = array();
	$lenght = strlen($param);
	if($lenght > 0 && $param[$lenght -1] == '/')
	{
		$param = substr($param, 0, -1);
	}

	if (file_exists($config['public'].$config['pictures'].$param))
	{
		$handler = @opendir($config['public'].$config['pictures'].$param);

		if($param != '')
		$param.='/';
		while ($file = @readdir($handler))
		{
			if ($file != '.' && $file != '..')
			{
				$file_parts = pathinfo($file);
				$item = array('src' => $param.$file, 'file' => $file);
				if(!is_dir($config['public'].$config['pictures'].$param.$file))
				{
					if(strtolower($file_parts['extension']) == 'jpeg' || strtolower($file_parts['extension']) == 'jpg' || strtolower($file_parts['extension']) == 'png' || strtolower($file_parts['extension']) == 'gif' || strtolower($file_parts['extension']) == 'bmp')
					{
						// Try directory to file
						tryThumbnail($config, $param, $file);
						@$size = getimagesize($config['public'].$config['pictures'].$param.$file);
						@$item['x'] = $size[0];
						@$item['y'] = $size[1];
						array_push($pictureList, $item);
					}
				}
			}
		}
	}
	$return = array('picture' =>$pictureList);
	echo json_encode($return);
}