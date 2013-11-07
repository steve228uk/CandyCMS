<?

/**
* @package CandyCMS
* @version 0.1
* @copyright Copyright 2012 (C) Cocoon Design Ltd. - All Rights Reserved
* 
* Login page for CandyCMS admin
*/

session_start();

if(isset($_SESSION['loggedin'])) header('Location: dashboard.php');

require('bootstrap.php');

?>

<? if(isset($_POST['submit'])) {
	User::resetPassword($_POST['email']);
} ?>

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
			<h1>Forgot?</h1>
			<? if (isset($_POST['submit'])) : ?>
				<p>Your password is on its way!</p>
			<? else: ?>
			<form action="<? $_SERVER['PHP_SELF']?>" method="post">
				<input type="email" name="email" placeholder="Email Address" />
				<input type="submit" name="submit" value="Reset Password" class="button" />
			</form>
			<? endif; ?>
		</div>
		<a href="login.php" title="View Site">&larr;Back to Login</a>
	</div>
</body>
</html>