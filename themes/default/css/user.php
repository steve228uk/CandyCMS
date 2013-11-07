<?
/**
* @package CandyCMS
* @theme Default
* @version 0.1
* @copyright Copyright 2012 (C) Cocoon Design Ltd. - All Rights Reserved
* 
* This file is for user styles defined in the admin
*/

header("Content-type: text/css");
include '../../../core/classes.php';

$colors = Theme::getColors();

?>

body{
	background: <? echo $colors->bg ?>;
}

a:link, a:visited{
	color: <? echo $colors->link ?>;
}

.nav li a{
	background: <? echo $colors->nav ?>;
}

.nav li a:hover{
	background: <? echo $colors->hover ?>;
}

.nav li.active-page a, .nav li.active-page a:hover{
	background: <? echo $colors->active ?>;
}

h1{
	color: <? echo $colors->h1 ?>;
}

header{
	background: <? echo $colors->active ?>;
}