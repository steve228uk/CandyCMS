<?php

/**
* @package CandyCMS
* @version 0.1
* @copyright Copyright 2012 (C) Cocoon Design Ltd. - All Rights Reserved
* 
* Manage and create navigation for your site
*/

?>

<?php if (isset($_GET['savenavigation'])) :?>
	<?php Pages::saveNav($_POST['nav']) ?>
<?php else : ?>

<div id="title-bar">
	
	<div id="title-bar-cont">
	
		<h1>Navigation</h1>
	
	</div>

</div>

<div id="container">

<p class="leadin">Drag and drop the pages below to rearrange the navigation.</p>

<?php Pages::sortPages() ?>

</div>

<?php endif; ?>

