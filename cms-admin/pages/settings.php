<?php

/**
* @package CandyCMS
* @version 0.1
* @copyright Copyright 2012 (C) Cocoon Design Ltd. - All Rights Reserved
* 
* Settings page for CandyCMS
*/

?>
<?php if ($_SESSION['role'] != 'admin'){
 echo '<h1>Access Denied</h1>';
 exit(1);
}?>

<h1 class="left">Settings</h1>

<a href="dashboard.php?page=users" class="right button">User Settings</a>
<a href="dashboard.php?page=profile" class="right button dl-btn">Account Settings</a>


<?php if (isset($_POST['save'])) {
	Settings::updateSettings($_POST['site_title'], $_POST['theme'], $_POST['pages'], $_POST['site_url']);
	echo '<p class="message success">Settings Updated</p>';	
} ?>

<form action="<?php echo $_SERVER['PHP_SELF'] ?>?page=settings" method="post" class="clear">
	<fieldset>
		<ul>
			<li><label>Site Title</label><input type="text" name="site_title" placeholder="Site Title" value="<?php echo Options::candytitle() ?>" /></li>
			<li><label>Site URL</label><input type="text" name="site_url" placeholder="Site URL" value="<?php echo Options::siteUrl() ?>" /></li>
		</ul>
	</fieldset>
	<fieldset>
		<ul>
			<li>
				<label>Theme</label>
				<select name="theme">
					
					<?php 
						$themes = $themes = Theme::listThemes();
						foreach ($themes as $value) {
							
							if (Options::currentTheme() == $value['dir']) {
								echo '<option value="'. $value['dir'] .'" selected="selected">' . $value['theme'] . ' By ' . $value['author'] . '</option>';
							} else {
								echo '<option value="'. $value['dir'] .'">' . $value['theme'] . ' By ' . $value['author'] . '</option>';
							}
							
						}
					?>
					
				</select>
			</li>
		</ul>
	</fieldset>
	<fieldset>
		<ul>
			<li>
				<?php $homepage = Options::homePage() ?>
				<label>Homepage</label><?php Pages::dropdownPages('pages', $homepage) ?>
			</li>
		</ul>
	</fieldset>
	<?php Settings::pluginSettings() ?>
	<input type="submit" name="save" class="button settings-btn" value="Save Settings" />
</form>