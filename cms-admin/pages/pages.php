<?php 
/**
* @package CandyCMS
* @version 0.1
* @copyright Copyright 2012 (C) Cocoon Design Ltd. - All Rights Reserved
* 
* The view for the pages page in the admin dashboard
*/	
?>

<?php if ( isset($_GET['edit']) ) : ?>
	
	<?php $page = Pages::pageInfo($_GET['edit']) ?>
	
	<h1>Edit Page</h1>
	<form action="<?php echo $_SERVER['PHP_SELF'] ?>?page=pages" method="POST">
		<ul>
			<li class="left">
				<input type="text" class="inputstyle" name="title" placeholder="Title" value="<?php echo $page[0]['page_title'] ?>" />
			</li>
			<li class="right">
				<label for="innav">Display In Navigation?</label><input type="checkbox" id="innav" name="innav" <?php if($page[0]['innav'] == 1) : ?>checked="checked"<?php endif; ?> />
			</li>
			<li class="viewed-at right clearr">
				This page can be viewed at 
				<?php echo Options::siteUrl()?>
				<?php if ($page[0]['rewrite'] != Options::homePage()) : ?>
					<input type="text" name="rewrite" class="url-box" value="<?php echo $page[0]['rewrite'] ?>" /> 
				<?php else : ?>
					<input type="hidden" name="rewrite" value="<?php echo $page[0]['rewrite'] ?>" />
				<?php endif; ?>
				<a href="<?php echo Options::siteUrl().$page[0]['rewrite'] ?>" title="View Page" target="_blank">View</a>
			</li>
			<li class="left clearl"><label>Page Template</label><?php Theme::dropdownTemplates($_GET['edit']) ?></li>
			<li class="clear"><textarea class="ckeditor" name="body"><?php echo $page[0]['page_body'] ?></textarea></li>
			<li><input name="update" type="submit" value="Save Page" class="button" /></li>
		</ul>
		<input type="hidden" name="id" value="<?php echo $_GET['edit'] ?>" />
	</form>
	
<?php elseif ( isset($_GET['new']) ) :?>
	
	<h1>Add New Page</h1>
	<form action="<?php echo $_SERVER['PHP_SELF'] ?>?page=pages" method="POST">
		<input type="text" name="title" placeholder="Title" /><br/>
		<input type="rewrite" name="rewrite" placeholder="URL" /><br/>
		<textarea name="body" class="ckeditor"></textarea><br/>
		<input type="submit" value="Add Page" name="addnew" /> 
		<input type="hidden" value="onecol" name="template" />
	</form>
	
<?php else : ?>
	
	<h1 class="left">Pages</h1>
	<a href="dashboard.php?page=pages&new" class="addnew right">Add New Page +</a>
	<?php if (isset($_POST['addnew'])) {
		echo 'Page Added';
		Pages::addPage($_POST['title'], $_POST['body'], $_POST['template'], $_POST['rewrite']);
	} ?>
	
	<?php if (isset($_POST['update'])) {
		if (isset($_POST['innav'])) {
			$innav = 'on';
		} else {
			$innav = 'off';
		}
		Pages::updatePage($_POST['title'], $_POST['body'], $_POST['rewrite'], $_POST['template'], $innav, $_POST['id']);
		echo '<p class="message success">Post Updated</p>';
	} ?>
	
	<?php if (isset($_GET['delete'])) {
		echo 'Page deleted!';
		Pages::deletePage($_GET['delete']);
	} ?>

	<?php Pages::pagesTable() ?>

<?php endif; ?>