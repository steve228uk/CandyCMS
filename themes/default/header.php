<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title><? candyTitle('&raquo;') ?></title>
	<? candyCss('styles.css') ?>
	<? candyCss('user.php') ?>
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
	<!--[if lt IE 9]>
	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	<? candyHead() ?>
</head>
<body>
<div id="container">
	<header>
		<? echo Candy::Options('site_title') ?>
	</header>
	<? theNav() ?>
	