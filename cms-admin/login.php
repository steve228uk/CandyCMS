<?

/**
* @package CandyCMS
* @version 1.0
* @since 0.1
* @copyright Copyright 2012 (C) Cocoon Design Ltd. - All Rights Reserved
* 
* Login page for CandyCMS admin
*/

ini_set('display_errors', 1);

session_start();

if(isset($_SESSION['loggedin'])) header('Location: dashboard.php');

require('bootstrap.php');

if (isset($_POST['username'])) {
	
	$login = Login::signin($_POST['username'], $_POST['password']);
	
	if ($login != false) {
		
		$role = User::getRole($_POST['username']);
		
		$_SESSION['loggedin'] = 'true';
		$_SESSION['username'] = $_POST['username'];
		$_SESSION['role'] = $role;

		header('Location: dashboard.php');
	}
		
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>CMS Login</title>
	<link rel="stylesheet" href="css/login.css" type="text/css" />
	<!--[if lt IE 9]>
	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
</head>
<body>
	<div id="container">
		<div id="box">
			<h1>Login</h1>
			<form action="<? echo $_SERVER['PHP_SELF'] ?>" method="post">
				<input type="text" name="username" placeholder="Username" /><br />
				<input type="password" name="password" placeholder="Password" /><br />
				<input type="submit" value="Login" class="button" />
				<a href="iforgot.php" class="right">Forgot Your Password?</a>
			</form>
		</div>
		<a href="<? echo URL_PATH ?>" title="View Site">&larr;Back to <? echo Candy::Options('site_title') ?></a>
	</div>
</body>
</html>