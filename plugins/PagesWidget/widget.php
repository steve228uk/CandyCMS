<?
/**
 * @title Pages 
 * @plugin Pages Widget
 * @author Cocoon Design
 * @copyright 2012 (C) Cocoon Design  
 */

$pages = Pages::listPages();

if (!empty($pages)) {
	
	echo '<ul>';
	
	foreach($pages as $page){
		echo "<li class='lrg'><a href='dashboard.php?page=pages&edit={$page->page_id}'>{$page->page_title}</a></li>";
	}
	
	echo '</ul>';
		
} else {
	
	echo "<p>There are currently no pages</p>";
	
}