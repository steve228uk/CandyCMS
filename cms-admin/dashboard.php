<?

/**
* @package CandyCMS
* @version 1.0
* @since 0.1
* @copyright Copyright 2012 (C) Cocoon Design Ltd. - All Rights Reserved
* 
* Admin dashboard for CandyCMS admin
*/

ini_set('display_errors', 1);

session_start();

if(!isset($_SESSION['loggedin'])) header('Location: login.php');

require('bootstrap.php');

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<? $array = adminNav();?>
	<title><? echo (isset($_GET['page'])) ? ucfirst($_GET['page']) : 'Dashboard' ?> &raquo; Admin &raquo; <? echo Candy::Options('site_title'); ?></title>
	<link rel="stylesheet" href="css/admin.css" type="text/css" />
		<link rel="stylesheet" href="js/redactor/css/redactor.css" type="text/css" />
	<link type="text/css" rel="stylesheet" href="css/jquery.miniColors.css" />
	<script type="text/javascript">
		var adminpath = '<? echo URL_PATH.'cms-admin/' ?>';
	</script>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
	<script type="text/javascript" src="js/jquery.miniColors.min.js"></script>
	<script type="text/javascript" src="js/jquery.nestable.js"></script>
	<script type="text/javascript" src="js/redactor/redactor.min.js"></script>
	<script type="text/javascript" src="js/jquery.scripts.min.js"></script>
	<!--[if lt IE 9]>
	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	<? adminHead() ?>
</head>
<body id="wrapper">
	<header>
		<div id="head-cont">
			<a href="dashboard.php" id="head-logo"> </a>
			<a href="<? echo URL_PATH ?>" class="view-site">View Site &rarr;</a>
			<button class="user-btn"><? echo $_SESSION['username'] ?></button>
			<ul id="usernav">
				<li><a href="dashboard.php?page=profile">Account Settings</a></li>
				<li><a href="logout.php" title="Logout">Logout</a></li>
			</ul>
			<ul class="nav">
				<?
				
					$array = adminNav($_SESSION['role']);
					if (isset($_GET['page'])) {
						array_walk_recursive($array, 'genAdminNav', $_GET['page']);
					} else {
						array_walk_recursive($array, 'genAdminNav');
					}
					
				?>
			</ul>
 		</div>
	</header>
	
		
		<?
		
			if (!isset($_GET['page']) || $_GET['page'] != 'update') {
				echo Update::checkUpdate();
			}
			
		?>
		
		<? if( isset($_GET['page']) ) : ?>
		
			<?
				
				if (file_exists('pages/'.$_GET['page'].'.php')) {
					include 'pages/'.$_GET['page'].'.php';	
				} else {
					include PLUGIN_PATH.ucwords($_GET['page']).'/admin.php';
				}
				
			?>
		
		<? else :?>
			
			<div id="title-bar">
				
				<div id="title-bar-cont">
				
					<h1>Dashboard</h1>
				
				</div>
			
			</div>
			
			<div id="container">
			
			
			<? Plugins::getWidgets() ?>
			
			
			</div>
			
		<? endif; ?>
	
	<footer>
        <p>Copyright &copy;<? echo date('Y') ?> Adam Patterson - Built with <a href="http://www.candycms.org" title="Candy CMS">Candy</a> v<? echo CANDYVERSION ?> - <a href="<? echo URL_PATH ?>" title="View Site">View Site</a></p>
        <a href="http://www.adampatterson.ca" title="Made By Adam Patterson" target="_blank" class="footer-logo"> </a>
	</footer>
</body>
</html>