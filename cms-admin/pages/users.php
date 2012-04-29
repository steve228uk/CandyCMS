<?php if ($_SESSION['role'] != 'admin'){
 echo '<h1>Access Denied</h1>';
 exit(1);
}?>

<?php if(isset($_GET['addnew'])) :?>
	
	<h1>Add New User</h1>
	
	<form action="dashboard.php?page=users" method="post">
		<fieldset>
			<ul>
				<li>
					<label>Username</label>
					<input type="text" name="username" placeholder="Username" />
				</li>
				<li>
					<label>Full Name</label>
					<input type="text" name="name" placeholder="Full Name" />
				</li>
				<li>
					<label>Email Address</label>
					<input type="email" name="email" placeholder="Email Address" autocomplete="off" />
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
		<input type="submit" name="adduser" value="Add New User" class="button settings-btn" />
	</form>
<?php elseif(isset($_GET['edit'])) : ?>
	
	<?php $info = User::getUserInfo($_GET['edit']); ?>
	
	<h1>Edit User</h1>
	
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
	
	
<?php else : ?>

	<h1 class="left">User Settings</h1>
	<a href="dashboard.php?page=users&addnew" class="button right">Add New User +</a>
	<p class="leadin left clearl">
		Add, edit or delete.
	</p>
	
	<?php if (isset($_POST['adduser'])) : ?>
		<?php User::addUser($_POST['username'], $_POST['name'], $_POST['email'], $_POST['password'], $_POST['role']) ?>
		<p class="message success">User Added</p>
	<?php endif; ?>
	
	<?php if (isset($_POST['edituser'])) : ?>
		<?php User::editUser($_POST['userid'], $_POST['username'], $_POST['name'], $_POST['email'], $_POST['role']) ?>
		<p class="message success">User Edited Successfully</p>	
	<?php endif;?>
	
	<?php User::getUserTable() ?>
	
<?php endif; ?>