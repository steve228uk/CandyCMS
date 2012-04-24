 <?php
// Delete selected image

$param = $_POST['url'];
$param = urldecode($param);
$lenght = strlen($param);
if($param[$lenght -1] == '/')
{
	$param = substr($param, 0, -1);
}

$create = @unlink($config['public'] .$config['pictures']. $param);
@unlink($config['public'] .$config['temp_dir'].'.thumbnail/'. $param);

if($create)
{
	echo '{"create":"true"}';
}
else
{
	echo '{"create":"false"}';
}
return;