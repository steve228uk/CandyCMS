<? if ($_SESSION['role'] != 'admin'){
 echo '<h1>Access Denied</h1>';
 exit(1);
}?>

<div id="title-bar">
	
	<div id="title-bar-cont">
	
		<h1 class="left">Plugins</h1>
		
		<a href="http://www.candycms.org/plugin-gallery" class="button right icon-wrench" target="_blank">Find More Plugins</a>
		
	</div>

</div>

<div id="container">

<? if (isset($_POST['save'])) :?>
<p class="message success">Plugins Saved</p>
<? Plugins::savePlugins($_POST['enabled']) ?>
<? endif; ?>

<form action="dashboard.php?page=plugins" method="post">
<?
	$plugins = Plugins::listPlugins();
	$enabled = Plugins::enabledPlugins();
	
	if ($plugins != false) {
		
		echo '<ul class="list">';
			
			foreach ($plugins as $plugin) {
				echo '<li>';
				echo '<p class="plugin-ttl">',$plugin['plugin'], '</p>', $plugin['description'] ,'<br /><span>Author: <a href="'. $plugin['authorURI'] .'" target="_blank">', $plugin['author'], '</a></span>';
				
				$check = (in_array($plugin['dir'], $enabled)) ? '<input type="checkbox" value="'. $plugin['dir'] .'" name="enabled[]" checked="checked" class="right" />' : '<input type="checkbox" value="'. $plugin['dir'] .'" name="enabled[]" class="right" />';
				
				echo $check;
				echo '</li>';
			}
			
		echo '</ul>';
		
		echo '<input type="submit" class="button" value="Save" name="save" />';	
	}
?>
</form>
</div>