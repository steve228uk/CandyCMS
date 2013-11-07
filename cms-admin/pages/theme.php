<? if (isset($_POST['colors'])) :?>
	<? Theme::setColors($_POST['colors']) ?>
<? else : ?>

<? if ($_SESSION['role'] != 'admin'){
 echo '<h1>Access Denied</h1>';
 exit(1);
}?>

<div id="title-bar">
	
	<div id="title-bar-cont">
	
		<h1 class="left">Theme Options</h1>
		
	</div>

</div>

<div id="container">

<form id="colorform">
<?

$themes = Theme::listThemes();
$current = Candy::Options('theme');

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
</div>
<? endif; ?>