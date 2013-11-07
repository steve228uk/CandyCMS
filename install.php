<?
/**
* @package CandyCMS
* @version 0.7
* @since 0.1
* @copyright Copyright 2012 (C) Cocoon Design Ltd. - All Rights Reserved
* 
* CandyCMS installer. Creates config.php and creates db structure
*/

if (version_compare(phpversion(), '5.3', '<=')) {
	echo 'Sorry, CandyCMS requires PHP version 5.3, you\'re currently running: ' . phpversion();
	exit(1);
}

if (file_exists('core/config.php')) {
	header('Location: index.php');
}

function diehard($msg) {
	echo $msg;
	echo "<Br/><Br/><a href=\"index.php\" class=\"button\">Well, at least we tried</a>";
	die();
}

$path = dirname(__FILE__);

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Candy Installer</title>
	<style type="text/css">
		/* @group Reset */
		/* http://meyerweb.com/eric/tools/css/reset/ 
		   v2.0 | 20110126
		   License: none (public domain)
		*/
		
		html, body, div, span, applet, object, iframe,
		h1, h2, h3, h4, h5, h6, p, blockquote, pre,
		a, abbr, acronym, address, big, cite, code,
		del, dfn, em, img, ins, kbd, q, s, samp,
		small, strike, strong, sub, sup, tt, var,
		b, u, i, center,
		dl, dt, dd, ol, ul, li,
		fieldset, form, label, legend,
		table, caption, tbody, tfoot, thead, tr, th, td,
		article, aside, canvas, details, embed, 
		figure, figcaption, footer, header, hgroup, 
		menu, nav, output, ruby, section, summary,
		time, mark, audio, video {
			margin: 0;
			padding: 0;
			border: 0;
			font-size: 100%;
			font: inherit;
			vertical-align: baseline;
		}
		/* HTML5 display-role reset for older browsers */
		article, aside, details, figcaption, figure, 
		footer, header, hgroup, menu, nav, section {
			display: block;
		}
		body {
			line-height: 1;
		}
		ol, ul {
			list-style: none;
		}
		blockquote, q {
			quotes: none;
		}
		blockquote:before, blockquote:after,
		q:before, q:after {
			content: '';
			content: none;
		}
		table {
			border-collapse: collapse;
			border-spacing: 0;
		}
		/* @end */
		
		body{
			background: #eee;
			font: 75%/1.5em "Helvetica Neue", Arial, Helvetica, Geneva, sans-serif;
		}
		
		#container{
			background: #fff;
			width: 960px;
			padding: 20px;
			margin: 50px auto;
		}
		
		h1{
			font-weight: lighter;
			font-size: 2.3em;
			margin: 0 0 20px;
		}
		
		h3{
			font-size: 1.5em;
			font-weight: lighter;
			color: #666;
			margin: 0 0 20px;
		}
		
		p.leadin{
			font-size: 1.2em;
			font-weight: lighter;
			color: #666;
			padding: 0 0 15px;
		}
		fieldset{
			border-bottom: 1px solid #ccc;
			padding: 20px 0;
		}
		
		fieldset label{
			width: 100px;
			float: left;
		}
		
		fieldset input, .inputstyle {
			background-image: -webkit-gradient(linear, left bottom, left top, from(white), to(#eeeeee));
		
			background-image: -webkit-linear-gradient(90deg, white 0%, #eeeeee 100%);
			background-image: -moz-linear-gradient(90deg, white 0%, #eeeeee 100%);
			background-image: -o-linear-gradient(90deg, white 0%, #eeeeee 100%);
			background-image: -ms-linear-gradient(90deg, white 0%, #eeeeee 100%);
			background-image: linear-gradient(90deg, white 0%, #eeeeee 100%);
			border: 1px solid #ccc;
			padding: 8px;
			font-size: 1.2em;
			font-weight: lighter;
		
			-webkit-border-radius: 5px;
			-moz-border-radius: 5px;
			border-radius: 5px;
			width: 300px;
		
			-webkit-box-shadow: inset 0 1px 0 #ffffff;
			-moz-box-shadow: inset 0 1px 0 #ffffff;
			box-shadow: inset 0 1px 0 #ffffff;
		}
		
		fieldset input:focus, .inputstyle:focus {
			outline: none;
		}
		
		.button {
			background-image: -webkit-gradient(linear, left bottom, left top, from(#013fab), to(#117cff));
		
			background-image: -webkit-linear-gradient(90deg, #013fab 0%, #117cff 100%);
			background-image: -moz-linear-gradient(90deg, #013fab 0%, #117cff 100%);
			background-image: -o-linear-gradient(90deg, #013fab 0%, #117cff 100%);
			background-image: -ms-linear-gradient(90deg, #013fab 0%, #117cff 100%);
			background-image: linear-gradient(90deg, #013fab 0%, #117cff 100%);
			border: 1px solid #013fab;
			color: #fff;
			font-size: 1.2em;
			font-weight: lighter;
		
			-webkit-border-radius: 5px;
			-moz-border-radius: 5px;
			border-radius: 5px;
			padding: 5px;
		
			-webkit-box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.42);
			-moz-box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.42);
			box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.42);
			cursor: pointer;
			text-decoration: none;
		}
		
	</style>
	<!--[if lt IE 9]>
	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
</head>
<body>
	<div id="container">
		<? if (isset($_GET['install'])) : ?>
		
		<h1>Candy Installer</h1>
		
		<?
			
			$currentmodal = substr(sprintf('%o', fileperms('./core')), -4);
			
			if ($currentmodal != "0755" && $currentmodal != "0777") {
			
				$result = @chmod($path."core", 0755);
				
				if (!$result) {
				
					diehard("Sorry, we couldn't modify the directory permissions of /core.");
				
				}
			
			}
			
			$dir = trim($_SERVER['PHP_SELF'], 'install.php');
		
			$dbhost = $_POST['dbhost'];
			$dbusername = $_POST['dbusername'];
			$dbpassword = $_POST['dbpassword'];
			$dbname = $_POST['dbname'];
			$dbprefix = $_POST['dbprefix'];
		
			$config = "<?\n\n";
			$config .= "/**\n";
			$config .= "* @package CandyCMS\n";
			$config .= "* @version 0.1\n";
			$config .= "* @copyright Copyright 2012 (C) Cocoon Design Ltd. - All Rights Reserved\n";
			$config .= "*\n";
			$config .= "* Config for CandyCMS - Will be generated by installer\n";
			$config .= "*/\n\n";
								
			$config .= "# This is set to MySQL by default but can be changed to your DB of choice\n";
			$config .= "define('DB_DRIVER', 'mysql');\n\n";
			
			$config .= "define('DB_HOST', '$dbhost');\n";
			$config .= "define('DB_USERNAME', '$dbusername');\n";
			$config .= "define('DB_PASSWORD', '$dbpassword');\n";
			$config .= "define('DB_NAME', '$dbname');\n";
			$config .= "define('DB_PREFIX', '$dbprefix');\n\n";
			
			$config .= "define('SALT', '873hjcbdi1kammcvjnj0u3jn');\n\n";
			
			$config .= "# Define where CandyCMS is installed WITH trailing slash\n";
			$config .= "define('CMS_PATH', \$_SERVER['DOCUMENT_ROOT'].'$dir');\n\n";
			
			$config .= "define('URL_PATH', '$dir');\n";
			
			$config .= "define('THEME_PATH', CMS_PATH.'themes/');\n";
			
			$config .= "define('THEME_URL', URL_PATH.'themes/');\n";
			
			$config .= "define('PLUGIN_PATH', CMS_PATH.'plugins/');\n";
			
			$config .= "define('PLUGIN_URL', URL_PATH.'plugins/');";
			
			
			$fp = @fopen('core/config.php', 'w');
			
			if (!$fp) {
				diehard("Sorry, we couldn't write to core/config.php.");
			} else {
			
				fwrite($fp, $config);
				fclose($fp);
			
			}
			
			#Write the HTACCESS file
//			$dir = (trim($_SERVER['PHP_SELF'], '/install.php') == '') ? '/' : trim($_SERVER['PHP_SELF'], 'install.php');
				
			$htaccess = "RewriteEngine On\n\n";	
			$htaccess .= "RewriteCond %{REQUEST_FILENAME} !-d\n";
			$htaccess .= "RewriteCond %{REQUEST_FILENAME} !-f\n";
			$htaccess .= "RewriteCond %{REQUEST_FILENAME} !-l\n\n";
			$htaccess .= "RewriteRule ^([^/.]*)/?([^/.]*)/?([^/.]*)$ ".$dir."index.php?page=$1&category=$2&post=$3 [QSA,L]";
			
			
			$currentmodal = substr(sprintf('%o', fileperms($path)), -4);
			
			if ($currentmodal != "0755" && $currentmodal != "0777")
				$result = @chmod($path, 0755);

			$fp = @fopen('./.htaccess', 'a');
			
			if (!$fp) {
			
				diehard("Sorry, we couldn't write to ~/.htaccess");
			
			} else {
			
				fwrite($fp, $htaccess);
				fclose($fp);
			
			}
			
	
			#Include the file once we've created it!
			$configfinal = @include('core/config.php');
			
			if (!$configfinal)
				diehard("Sorry, we couldn't create core/config.php properly.");

			try{ 
				$dbh = new PDO(DB_DRIVER.':dbname='.DB_NAME.';host='.DB_HOST, DB_USERNAME, DB_PASSWORD);
			} catch(Exception $e){
				unlink('core/config.php');
				die('Candy couldn\'t connect to the database, please try again.');
			}

			#Create the Options table if not exists
			$dbh->exec("CREATE TABLE IF NOT EXISTS `".DB_PREFIX."options` (`id` int(11) NOT NULL AUTO_INCREMENT, PRIMARY KEY (`id`), `option_key` varchar(256) NOT NULL, UNIQUE KEY (`option_key`), `option_value` varchar(256) NOT NULL)");
			
			#Set some defaults for the options table
			$options = array('site_title' => $_POST['title'],
							 'site_url' => $_POST['url'],
							 'theme' => 'default',
							 'homepage' => 'home',
							 'enabled_plugins' => '["Sitemap", "PagesWidget"]',
							 'colors' => '{"bg":"#EEEEEE","link":"#E64C4C","h1":"#E64C4C","nav":"#F2F2F2","hover":"#D9D9D9","active":"#E64C59"}',
							 'nav' => '[]'
							 );
			
			#Populate the Options table
			foreach ($options as $key => $value) {
				$dbh->exec("INSERT INTO `".DB_PREFIX."options` (option_key, option_value) VALUES ('$key', '$value')");
			}
			
			#Create the Pages table if not exists
			$dbh->exec("CREATE TABLE IF NOT EXISTS `".DB_PREFIX."pages` (`page_id` int(11) NOT NULL AUTO_INCREMENT, PRIMARY KEY (`page_id`), `page_title` varchar(256) NOT NULL, `page_body` text NOT NULL, `page_template` varchar(256) NOT NULL, `rewrite` varchar(256) NOT NULL)");
			
			$sql = "INSERT INTO `".DB_PREFIX."pages` (`page_title`, `page_body`, `page_template`, `rewrite`) VALUES ('Home', 'Welcome to CandyCMS, this page can be changed in the admin dashboard.', 'onecol', 'home');";
			
			#Populate the Pages table with a default Page
			$dbh->exec($sql);
			
			# Create the Fields table if not exists
			$dbh->exec("CREATE TABLE IF NOT EXISTS `".DB_PREFIX."fields` (`field_id` int(11) NOT NULL AUTO_INCREMENT, PRIMARY KEY (`field_id`), `post_id` int(11), `field_name` varchar(256) NOT NULL, `field_type` varchar(256) NOT NULL, `field_title` varchar(256) NOT NULL, `field_desc` varchar(256) NOT NULL, `field_value` text NOT NULL)");
			
			#Create user table
			$dbh->exec("CREATE TABLE IF NOT EXISTS `".DB_PREFIX."users` (`userid` int(11) NOT NULL AUTO_INCREMENT, PRIMARY KEY (`userid`), `username` varchar(256) NOT NULL, `password` varchar(256) NOT NULL, `email` varchar(256) NOT NULL, `name` varchar(256) NOT NULL, `role` varchar(256) NOT NULL, UNIQUE KEY(`username`, `email`))");
			
			$username = $_POST['username'];
			$password = sha1($_POST['password'].SALT);
			$name = $_POST['name'];
			$email = $_POST['email'];
			
			#insert the user into the DB
			$dbh->exec("INSERT INTO `".DB_PREFIX."users` (`username`, `password`, `name`, `email`, `role`) VALUES ('$username', '$password', '$name', '$email', 'admin')");
		?>
		
		<p class="leadin">
			Thanks for installing Candy!
		</p>
		<a href="index.php" class="button">Continue To <? echo $_POST['title'] ?></a>
		
		<? else : ?>
		
		<h1>Candy Installer</h1>
		<p class="leadin">
			Hello, welcome to Candy! Follow the steps below to install it.
		</p>
		<form action="install.php?install" method="post">
			<fieldset>
				<h3>Site Information</h3>
				<ul>
					<li><label>Site URL</label><input type="text" name="url" value="http://<? echo$_SERVER['HTTP_HOST'].trim($_SERVER['PHP_SELF'], 'install.php') ?>"/></li>
					<li><label>Site Title</label><input type="text" name="title" placeholder="Site TItle" /></li>
				</ul>
			</fieldset>
			<fieldset>
				<h3>Database Details</h3>
				<ul>
					<li><label>DB Host</label><input type="text" name="dbhost" value="localhost" /></li>
					<li><label>DB Name</label><input type="text" name="dbname" placeholder="Database Name" /></li>
					<li><label>DB Prefix</label><input type="text" name="dbprefix" value="cms_" /></li>
					<li><label>DB Username</label><input type="text" name="dbusername" placeholder="Database Username" /></li>
					<li><label>DB Password</label><input type="text" name="dbpassword" placeholder="Database Password" /></li>
				</ul>
			</fieldset>
			<fieldset>
				<h3>User Details</h3>
				<ul>
					<li><label>Name</label><input type="text" name="name" placeholder="Name" /></li>
					<li><label>Email</label><input type="email" name="email" placeholder="email" />
					<li><label>Username</label><input type="text" name="username" value="admin" /></li>
					<li><label>Password</label><input type="password" name="password" placeholder="Password" /></li>
				</ul>
			</fieldset>
			<input type="submit" name="submit" value="Install Away!" class="button" />
		</form>
		<? endif; ?>
		
	</div>
</body>
</html>