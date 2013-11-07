<?
/**
* @package CandyCMS
* @version 1.0
* @copyright Copyright 2012 (C) Cocoon Design Ltd. - All Rights Reserved
* 
* The view for the pages page in the admin dashboard
*/

$site_url = Candy::Options('site_url');
$homepage = Candy::Options('homepage');	
	
?>

<? if ( isset($_GET['edit']) ) : ?>
	
	<? $page = Pages::pageInfo($_GET['edit']) ?>
	
	<div id="title-bar">
		
		<div id="title-bar-cont">
		
			<h1 class="left">Edit Page</h1>
			
			<button class="button right icon-wrench" id="cfbtn">Custom Fields</button>
			
		</div>
	
	</div>
	
	<div id="container">
	
	<form action="<? echo $_SERVER['PHP_SELF'] ?>?page=pages" method="POST" class="clear">
		<ul>
			<li class="left">
				<input type="text" class="inputstyle" name="title" placeholder="Title" value="<? echo $page[0]->page_title ?>" />
			</li>
			
			<li class="viewed-at right clearr">
				This page can be viewed at 
				<? echo $site_url?>
				<? if ($page[0]->rewrite != $homepage) : ?>
					<input type="text" name="rewrite" class="url-box" value="<? echo $page[0]->rewrite ?>" />
				<? else : ?>
					<input type="hidden" name="rewrite" value="<? echo $page[0]->rewrite ?>" />
				<? endif; ?>
				<a href="<? echo $site_url.$page[0]->rewrite ?>" title="View Page" target="_blank">View</a>
			</li>
			<li class="left clearl p-templates"><label>Page Template</label><? Theme::dropdownTemplates($_GET['edit']) ?></li>
			<li class="clear"><textarea class="ckeditor" name="body"><? echo $page[0]->page_body ?></textarea></li>
			<li><ul id="cf-area"><? CustomFields::getAdminFields($_GET['edit']) ?></ul></li>
			<li><input name="update" type="submit" value="Save Page" class="button" /></li>
		</ul>
		<input type="hidden" name="id" value="<? echo $_GET['edit'] ?>" />
	</form>
	
	</div>
	
<? elseif ( isset($_GET['new']) ) :?>
	
	<div id="title-bar">
		
		<div id="title-bar-cont">
		
			<h1 class="left">Add New Page</h1>
			
			<button class="button right icon-wrench" id="cfbtn">Custom Fields</button>
			
		</div>
	
	</div>
	
	<div id="container">
	
	<form action="<? echo $_SERVER['PHP_SELF'] ?>?page=pages" method="POST" class="clear">
		<ul>
			<li class="left">
				<input type="text" class="inputstyle" name="title" placeholder="Title" id="page-title" />
			</li>
						
			<li class="viewed-at right clearr">
				This page can be viewed at 
				<? echo $site_url?>
				<input type="text" name="rewrite" class="url-box" id="rewrite" />
			</li>
			<li class="left clearl p-templates"><label>Page Template</label><? Theme::dropdownTemplates() ?></li>
			<li class="clear"><textarea name="body" class="ckeditor"></textarea></li>
			<li><ul id="cf-area"></ul></li>
			<li><input type="submit" value="Add Page" name="addnew" class="button" /></li> 
		</ul>
	</form>
	
	</div>
	
<? else : ?>
	
	<div id="title-bar">
		
		<div id="title-bar-cont">
		
			<h1 class="left">Pages</h1>
			
			<a href="dashboard.php?page=pages&new" class="addnew button right">Add New Page +</a>
			
		</div>
	
	</div>
	
	<div id="container">
	
	<? if (isset($_POST['addnew'])) {
		echo '<p class="message success">Page Added</p>';
		if (isset($_POST['innav'])) {
			$innav = 'on';
		} else {
			$innav = 'off';
		}
		
		if (isset($_POST['cfield'])) {
			Pages::addPage($_POST['title'], $_POST['body'], $_POST['template'], $_POST['rewrite'], $innav, $_POST['cfield']);
		} else {
			Pages::addPage($_POST['title'], $_POST['body'], $_POST['template'], $_POST['rewrite'], $innav);	
		}
		
	} ?>
	
	<? if (isset($_POST['update'])) {
		if (isset($_POST['innav'])) {
			$innav = 'on';
		} else {
			$innav = 'off';
		}
		
		if (isset($_POST['cfield'])) {
			Pages::updatePage($_POST['title'], $_POST['body'], $_POST['rewrite'], $_POST['template'], $innav, $_POST['id'], $_POST['cfield']);
		} else {
			Pages::updatePage($_POST['title'], $_POST['body'], $_POST['rewrite'], $_POST['template'], $innav, $_POST['id']);
		}	
			
		echo '<p class="message success">Post Updated</p>';
	} ?>
	
	<? if (isset($_GET['delete'])) {
		echo '<p class="message success">Page deleted!</p>';
		Pages::deletePage($_GET['delete']);
	} ?>

	<? Pages::pagesTable() ?>
	
	</div>
	
<? endif; ?>