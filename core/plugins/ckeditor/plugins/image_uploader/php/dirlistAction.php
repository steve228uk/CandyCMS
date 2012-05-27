 <?php
// This block do all function with directory tree

$param="";
@$param = $_POST['param'];
@$type = $_POST['type'];
$param = urldecode($param);
$lenght = strlen($param);
if($lenght > 0 && $param[0] == '/')
$param = substr($param, 1, $lenght);
$lenght = strlen($param);
if($lenght > 0 && $param[$lenght -1] == '/')
{
	$param = substr($param, 0, -1);
}

// Add new directory

if($type == 'add')
{
	$create = false;

	$dir = $config['new_dir_name'];
	// Find first free number
	if (is_dir($config['public'].$config['pictures'].$param.'/'.$dir) )
	{
		$i = 0;
		do
		{
			++$i;
			$new_dir = $config['new_dir_name'].sprintf("%02d", $i);
		}
		while (is_dir($config['public'].$config['pictures'].$param.'/'.$new_dir));
		$dir = $new_dir;
	}
	// Try create new dir
	if(@mkdir($config['public'] . $config['pictures'].$param.'/'.$dir, 0777))
	{
		$create = @chmod($config['public'] . $config['pictures'].$param.'/'.$dir, 0777);
	}
	if($create)
	echo '{"create":"'.$dir.'"}';
	else
	echo '{"create":"false"}';
	return;
}

// Del directory action

else if($type == 'del')
{
	if(is_dir($config['public'] .$config['pictures']. $param))
	{
		$create = delTree($config['public'] .$config['pictures']. $param,$config['temp_dir']);
		delTree($config['public'] .$config['temp_dir'].'.thumbnail/'. $param,$config['temp_dir']);
	}
	if($create)
	echo '{"create":"true"}';
	else
	echo '{"create":"false"}';
	return;
}

// Edit directory action

else if($type == 'edit')
{
	$name = $_POST['name'];
	$paramNew = explode('/',$param);
	$l = count($paramNew);
	if($l > 0)
	unset($paramNew[$l-1]);
	$paramNew = join('/',$paramNew);
	$lenght = strlen($paramNew);
	if($lenght > 0 && $paramNew[$lenght -1] == '/')
	{
		$paramNew = substr($paramNew, 0, -1);
	}
	$create = @rename($config['public'] .$config['pictures']. $param,$config['public'] .$config['pictures']. $paramNew.'/'.$name);
	if(!@rename($config['public'] .$config['temp_dir'].'.thumbnail/'. $param,$config['public'] .$config['temp_dir'].'.thumbnail/'. $paramNew.'/'.$name))
	@rename($config['public'] .$config['temp_dir'].'.thumbnail/'. $param,$config['public'] .$config['temp_dir'].'.thumbnail/'. $paramNew.'/'.$name);
	if($create)
	echo '{"create":"true"}';
	else
	echo '{"create":"false"}';
	return;
}

// Print directory tree

else
{
	$ret = array();
	if (is_dir($config['public'].$config['pictures']))
	{
		dirtree($config['public'],$config['pictures'], $ret);
		$ret[0]['name'] = '/';
	}
	else
	{
		$ret[0]['name'] = 'Wrong URL to dir '.$config['public'].$config['pictures'];
		$ret[0]['items'] = array();
	}
	echo json_encode($ret);
}