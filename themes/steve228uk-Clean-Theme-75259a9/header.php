<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title><?php candytitle('&raquo;') ?></title>
	<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0;">
	<link href='http://fonts.googleapis.com/css?family=Lato:400,700,900' rel='stylesheet' type='text/css'>
	<?php candyCss('styles.css') ?>
	<?php candyCss('user.php') ?>
	<!--[if lt IE 9]>
	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	<?php candyHead() ?>
</head>
<body>
<div class="container">
<header id="site-header" class="clearfix">
	<div id="site-title">
		<a href="<?php echo URL_PATH ?>" title="Home"><?php echo Candy::Options('site_title') ?></a>
	</div>	
	<?php theNav() ?>
</header>
<div id="content" class="clearfix">