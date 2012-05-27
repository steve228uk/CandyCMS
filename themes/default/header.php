<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title><?php candyTitle('&raquo;') ?></title>
	<?php candyCss('styles.css') ?>
	<?php candyCss('user.php') ?>
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
	<!--[if lt IE 9]>
	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	<?php candyHead() ?>
</head>
<body>
<div id="container">
	<header>
		<?php echo Options::candytitle() ?>
	</header>
	<?php theNav() ?>
	