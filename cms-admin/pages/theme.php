<?php if (isset($_POST['colors'])) :?>
	<?php Theme::setColors($_POST['colors']) ?>
<?php else : ?>

<?php if ($_SESSION['role'] != 'admin'){
 echo '<h1>Access Denied</h1>';
 exit(1);
}?>

<h1>Theme Options</h1>
<p class="leadin">Use the colour pickers below to change the colours on your site</p>
<form id="colorform">
<?php

$themes = Theme::listThemes();
$current = Options::currentTheme();

foreach($themes as $theme){

	if ($theme['dir'] == $current) {
		
		$colors = explode(',', $theme['colors']);
		
		$groups = array();
		
		foreach ($colors as $value) {
			$pieces = explode('-', $value);
			$arrkey = $pieces[0];
			$groups[$arrkey][] = $pieces[1];
		}

		
		$colorvals = Theme::getColors();
		
		foreach ($groups as $key => $value) {
			
			echo '<fieldset>';
			echo "<h3>$key Colours</h3><ul>";
		
			
			foreach ($value as $value) {
		
				echo "<li><label>". ucwords($value) ."</label><input type='text' name='colors[".trim($value)."]' class='colorpicker' value='{$colorvals->$value}' /></li>";
			}
			
			echo '</ul></fieldset>';
			
		}

		
	}
	
}
?>
</form>
<?php endif; ?>