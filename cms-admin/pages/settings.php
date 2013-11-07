<?

/**
* @package CandyCMS
* @version 0.1
* @copyright Copyright 2012 (C) Cocoon Design Ltd. - All Rights Reserved
* 
* Settings page for CandyCMS
*/

?>
<? if ($_SESSION['role'] != 'admin'){
 echo '<h1>Access Denied</h1>';
 exit(1);
}?>

<div id="title-bar">
	
	<div id="title-bar-cont">
	
		<h1 class="left">Settings</h1>
		
		<a href="dashboard.php?page=users" class="right button">User Settings</a>
		<a href="dashboard.php?page=profile" class="right button dl-btn">Account Settings</a>
		
	</div>

</div>

<div id="container">


<? if (isset($_POST['save'])) {
	Settings::updateSettings($_POST['site_title'], $_POST['theme'], $_POST['pages'], $_POST['site_url']);
	echo '<p class="message success">Settings Updated</p>';	
} ?>

<form action="<? echo $_SERVER['PHP_SELF'] ?>?page=settings" method="post" class="clear">
	<fieldset>
		<ul>
			<li><label>Site Title</label><input type="text" name="site_title" placeholder="Site Title" value="<? echo Candy::Options('site_title') ?>" /></li>
			<li><label>Site URL</label><input type="text" name="site_url" placeholder="Site URL" value="<? echo Candy::Options('site_url') ?>" /></li>
		</ul>
	</fieldset>
	<fieldset>
		<ul>
			<li>
				<label>Theme</label>
				<select name="theme">
					
					<?
						$themes = $themes = Theme::listThemes();
						foreach ($themes as $value) {
							
							if (Candy::Options('theme') == $value['dir']) {
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
				<? $homepage = Candy::Options('homepage') ?>
				<label>Homepage</label><? Pages::dropdownPages('pages', $homepage) ?>
			</li>
		</ul>
	</fieldset>
	<? Settings::pluginSettings() ?>
	<input type="submit" name="save" class="button settings-btn" value="Save Settings" />
</form>
</div>