<?
/**
 * @template Two Column
 * @fields sidebar-wysi-Sidebar-Right Column Content
 * @author Cocoon Design
 * @copyright 2012 (c) Cocoon Design
 */	
?>
<div id="content">
	<h1><? theTitle() ?></h1>
	<? theContent() ?>
</div>
<div id="sidebar">
	<? theField('sidebar') ?>
</div>