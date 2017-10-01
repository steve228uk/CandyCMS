<?php if ($_SESSION['role'] != 'admin'){
 echo '<h1>Access Denied</h1>';
 exit(1);
}?>

<?php if(isset($_GET['addnew'])) {?>
	
	<div id="title-bar">
		
		<div id="title-bar-cont">
			<h1 class="left">Add New User</h1>
		</div>

	</div>

	<div id="container">

        <form action="dashboard.php?page=users" method="post">

			<fieldset>
				<ul>
					<li>
						<label>Username</label>
						<input type="text" name="username" placeholder="Username" id="username" />
						<div id="message"></div>
					</li>
					<li>
						<label>Full Name</label>
						<input type="text" name="name" placeholder="Full Name" />
					</li>
					<li>
						<label>Email Address</label>
						<input type="email" name="email" placeholder="Email Address" id="useremail" autocomplete="off" />
					</li>
				</ul>
			</fieldset>
			<fieldset>
				<ul>
					<li>
						<label>User Role</label>
						<select name="role">
							<option value="user" selected="selected">User</option>
							<option value="admin">Admin</option>
						</select>
					</li>
				</ul>
			</fieldset>
			<fieldset>
				<ul>
					<li>
						<label>Password</label>
						<input type="password" name="password" placeholder="Password" autocomplete="off" />
					</li>
				</ul>
			</fieldset>
			<input type="submit" name="adduser" id="save" value="Add New User" class="button settings-btn" />
		</form>
	</div>
<?php } elseif(isset($_GET['edit'])) { ?>
	
	<?php $info = User::getUserInfo($_GET['edit']); ?>
	
	<div id="title-bar">
		
		<div id="title-bar-cont">
		
			<h1 class="left">Edit User</h1>
			
		</div>
	
	</div>
	
	<div id="container">
	
	<form action="dashboard.php?page=users" method="post">
		<fieldset>
			<ul>
				<li>
					<label>Username</label>
					<input type="text" name="username" placeholder="Username" value="<?php echo $info[0]->username ?>" />
				</li>
				<li>
					<label>Full Name</label>
					<input type="text" name="name" placeholder="Full Name" value="<?php echo $info[0]->name ?>" />
				</li>
				<li>
					<label>Email Address</label>
					<input type="email" name="email" placeholder="Email Address" value="<?php echo $info[0]->email ?>" autocomplete="off" />
				</li>
			</ul>
		</fieldset>
		<fieldset>
			<ul>
				<li>
					<label>User Role</label>
					<select name="role">
						<option value="user" <?php if($info[0]->role == 'user') echo 'selected="selected"'; ?>>User</option>
						<option value="admin" <?php if($info[0]->role == 'admin') echo 'selected="selected"'; ?>>Admin</option>
					</select>
				</li>
			</ul>
		</fieldset>
		<input type="hidden" name="userid" value="<?php echo $info[0]->userid ?>" />
		<input type="submit" name="edituser" value="Edit User" class="button settings-btn" />
	</form>
	
	</div>
	
<?php } else { ?>

	<div id="title-bar">
		
		<div id="title-bar-cont">
		
			<h1 class="left">User Settings</h1>
			<a href="dashboard.php?page=users&addnew" class="button right">Add New User +</a>
			
		</div>
	
	</div>
	
	<div id="container">

    <?php if (isset($_POST['userName'])) { ?>

    <?php } ?>

	<?php if (isset($_POST['adduser'])) { ?>
		<?php User::addUser($_POST['username'], $_POST['name'], $_POST['email'], $_POST['password'], $_POST['role']) ?>
		<p class="message success">User Added</p>
	<?php } ?>
	
	<?php if (isset($_POST['edituser'])) { ?>
		<?php User::editUser($_POST['userid'], $_POST['username'], $_POST['name'], $_POST['email'], $_POST['role']) ?>
		<p class="message success">User Edited Successfully</p>	
	<?php } ?>
	
	<?php if (isset($_GET['delete'])) { ?>
		<?php User::deleteUser($_GET['delete']) ?>
		<p class="message success">User Deleted</p>
	<?php } ?>
	
	<?php User::getUserTable() ?>
	
	</div>
	
<?php } ?>