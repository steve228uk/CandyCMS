<?php
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
	background: <?php echo $colors->bg ?>;
}

a:link, a:visited{
	color: <?php echo $colors->link ?>;
}

.nav li a{
	background: <?php echo $colors->nav ?>;
}

.nav li a:hover{
	background: <?php echo $colors->hover ?>;
}

.nav li.active-page a, .nav li.active-page a:hover{
	background: <?php echo $colors->active ?>;
}

h1{
	color: <?php echo $colors->h1 ?>;
}

header{
	background: <?php echo $colors->active ?>;
}