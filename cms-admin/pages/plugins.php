<h1>Plugins</h1>

<?php if (isset($_POST['save'])) :?>
<p class="message success">Plugins Saved</p>
<?php Plugins::savePlugins($_POST['enabled']) ?>
<?php endif; ?>

<form action="dashboard.php?page=plugins" method="post">
<?php 
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