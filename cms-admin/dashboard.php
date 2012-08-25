<?php

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
	<?php $array = adminNav();?>
	<title><?php echo (isset($_GET['page'])) ? ucfirst($_GET['page']) : 'Dashboard' ?> &raquo; Admin &raquo; <?php echo Candy::Options('site_title'); ?></title>
	<link rel="stylesheet" href="css/admin.css" type="text/css" />
		<link rel="stylesheet" href="../core/plugins/redactor/css/redactor.css" type="text/css" />
	<link type="text/css" rel="stylesheet" href="css/jquery.miniColors.css" />
	<script type="text/javascript">
		var adminpath = '<?php echo URL_PATH.'cms-admin/' ?>';
	</script>
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/jquery-ui.min.js"></script>
	<script type="text/javascript" src="js/jquery.miniColors.min.js"></script>
	<script type="text/javascript" src="js/jquery.nestable.js"></script>
	<script type="text/javascript" src="../core/plugins/redactor/redactor.min.js"></script>
	<script type="text/javascript" src="js/jquery.scripts.min.js"></script>
	<!--[if lt IE 9]>
	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	<?php adminHead() ?>
</head>
<body>
	<header>	
		<div id="head-cont">
			<a href="dashboard.php" id="head-logo"> </a>
			<button class="user-btn"><?php echo $_SESSION['username'] ?></button>
			<ul id="usernav">
				<li><a href="dashboard.php?page=profile">Account Settings</a></li>
				<li><a href="logout.php" title="Logout">Logout</a></li>
			</ul>
			<ul class="nav">
				<?php 
				
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
	
		
		<?php 
		
			if (!isset($_GET['page']) || $_GET['page'] != 'update') {
				echo Update::checkUpdate();
			}
			
		?>
		
		<?php if( isset($_GET['page']) ) : ?>
		
			<?php 
				
				if (file_exists('pages/'.$_GET['page'].'.php')) {
					include 'pages/'.$_GET['page'].'.php';	
				} else {
					include PLUGIN_PATH.ucwords($_GET['page']).'/admin.php';
				}
				
			?>
		
		<?php else :?>
			
			<div id="title-bar">
				
				<div id="title-bar-cont">
				
					<h1>Dashboard</h1>
				
				</div>
			
			</div>
			
			<div id="container">
			
			
			<?php Plugins::getWidgets() ?>
			
			
			</div>
			
		<?php endif; ?>
	
	<footer>
		<p>Copyright &copy;<?php echo date('Y') ?> Cocoon Design - Built with <a href="http://www.candycms.org" title="Candy CMS">Candy</a> v<?php echo CANDYVERSION ?> - <a href="<?php echo URL_PATH ?>" title="View Site">View Site</a></p>
		<a href="http://www.wearecocoon.co.uk" title="Made By Cocoon" target="_blank" class="footer-logo"> </a>
	</footer>
</body>
</html>