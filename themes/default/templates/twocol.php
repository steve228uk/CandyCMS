<?php
/**
 * @template Two Column
 * @fields sidebar-wysi-Sidebar-Right Column Content
 * @author Cocoon Design
 * @copyright 2012 (c) Cocoon Design
 */	
?>
<div id="content">
	<h1><?php theTitle() ?></h1>
	<?php theContent() ?>
</div>
<div id="sidebar">
	<?php theField('sidebar') ?>
</div>