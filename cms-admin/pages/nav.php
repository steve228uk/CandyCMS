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

<h1>Navigation</h1>

<p class="leadin">Drag and drop the pages below to rearrange the navigation.</p>

<?php Pages::sortPages() ?>

<?php endif; ?>

