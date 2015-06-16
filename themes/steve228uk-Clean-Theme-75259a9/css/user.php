<?php header("Content-type: text/css");
include '../../../core/classes.php';
$colors = Theme::getColors();  ?>

body{
	background-color: <?php echo $colors->bg ?>;
}

a:link, a:visited{
	color: <?php echo $colors->link ?>;
}

#site-title a{
	color: <?php echo $colors->accent ?>;
}

.nav > li.active-page > a, .nav > li:hover > a, .nav > li > ul, .nav > li > ul li a:hover{
	border-bottom: 3px solid <?php echo $colors->accent ?>;
}

blockquote{
	border-left: 3px solid <?php echo $colors->accent ?>;
}

.button{
	background: <?php echo $colors->button_bg ?>;
	color: <?php echo $colors->button_text ?> !important;
}

.button:hover{
	background: <?php echo $colors->button_hover ?>;
}