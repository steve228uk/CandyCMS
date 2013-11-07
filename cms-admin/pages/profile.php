<? $info = User::getUserInfo($_SESSION['username']) ?>

<div id="title-bar">
	
	<div id="title-bar-cont">
	
		<h1 class="left">Account Settings</h1>
		
	</div>

</div>

<div id="container">

<? if (isset($_POST['save'])) : ?>
	<? User::saveUserInfo($_SESSION['username'], $_POST['name'], $_POST['email']) ?>
	<p class="message success">Account Settings Saved</p>
	
	<? if ($_POST['current'] != '' && $_POST['new'] != '' && $_POST['confirm'] != '') {
	
		if ($_POST['new'] != $_POST['confirm']) {
			echo '<p class="message notice">Sorry, your new passwords don\'t match!</p>';
		} else {
			User::changePassword($_SESSION['username'], $_POST['current'], $_POST['new']);
		}
		
	} ?>
	
<? endif; ?>
<form action="dashboard.php?page=profile" method="post">
	<fieldset>
		<ul>
			<li>
				<label>Full Name</label>
				<input type="text" name="name" value="<? echo $info[0]->name ?>" placeholder="Full Name" />
			</li>
			<li>
				<label>Email Address</label>
				<input type="email" name="email" value="<? echo $info[0]->email ?>" placeholder="Email Address" />
			</li>
		</ul>
	</fieldset>
	<fieldset>
		<ul>
			<li>
				<label>Current Password</label>
				<input type="password" name="current" placeholder="Current Password" />
			</li>
			<li>
				<label>New Password</label>
				<input type="password" name="new" placeholder="New Password" />
			</li>
			<li>
				<label>Confirm Password</label>
				<input type="password" name="confirm" placeholder="Confirm Password" />
			</li>
		</ul>
	</fieldset>
	<input type="submit" name="save" value="Save Settings" class="button settings-btn" />
</form>
</div>