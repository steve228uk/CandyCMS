 <?php
// Edit picture action

$param = $_POST['url'];
$param = urldecode($param);
list($tempDomain, $p) = explode('////',$param);
$param = $p;
$param = str_replace('//','/',$param);
$name = $_POST['name'];

if($param[0] == '/')
	$param = substr($param, 1, $lenght);
$newParam = '';
$param2 = $param;
while($p = strpos($param2, '/'))
{
	$newParam .= substr($param2,0,$p).'/';
	$param2 = substr($param2,$p+1);
}
$lenght = strlen($newParam);
$fileOld = pathinfo($name);
$fileNew = pathinfo($param);
$create = false;
if(strtolower($fileOld['extension']) == strtolower($fileNew['extension']))
{
	$create = @rename($config['public'].$config['pictures'].$param,$config['public'].$config['pictures'].$newParam.$name);
	@rename($config['public'].$config['temp_dir'].'.thumbnail/'.$param,$config['public'].$config['temp_dir'].'.thumbnail/' .$newParam.$name);
}
if($create)
echo '{"create":"'.$newParam.$name.'", "file":"'.$name.'"}';
else
echo '{"create":"false"}';
return;