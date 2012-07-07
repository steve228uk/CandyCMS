<?php

/**
* @package CandyCMS
* @subpackage Blog
* @version 0.7.2
* @since 0.1
* @copyright Copyright 2012 (C) Cocoon Design Ltd. - All Rights Reserved
* 
* This file generates the pages for the blog admin
*/

?>

<?php if (isset($_GET['new'])) : ?>

<div id="title-bar">
	
	<div id="title-bar-cont">
	
		<h1 class="left">Add New Post</h1>
		
	</div>

</div>

<div id="container">
<form action="dashboard.php?page=blog" method="post">
	<ul id="post-info">
		<li id="post-title">
			<input type="text" class="inputstyle" name="title" placeholder="Title" />
		</li>
		<li><textarea class="ckeditor" name="body"></textarea></li>
		<li id="post-btn"><input type="submit" name="addnew" value="Add New Post" class="button" /><input type="submit" name="draft" value="Save As Draft" class="button" /></li>
	</ul>
	<?php Blog::adminCats() ?>
</form>
</div>
<?php elseif(isset($_GET['edit'])) : ?>

<?php $post = getBlogPostById($_GET['edit']) ?>
	
<div id="title-bar">
	
	<div id="title-bar-cont">
	
		<h1 class="left">Edit Post</h1>
		
	</div>

</div>

<div id="container">	
<form action="dashboard.php?page=blog" method="post">

	<ul id="post-info">
		<li id="post-title">
			<input type="text" class="inputstyle" name="title" placeholder="Title" value="<?php echo $post[0]->post_title ?>" />
		</li>
		<li><textarea class="ckeditor" name="body"><?php echo $post[0]->post_body ?></textarea></li>
		<li id="post-btn">
			<input type="submit" name="editpost" value="Save Changes" class="button" />
			<?php if ($post[0]->status == 'draft') : ?>
				<input type="submit" name="publish" value="Publish Post" class="button" />
			<?php endif ?>
		</li>
	</ul>
	<?php Blog::adminCats($post[0]->cat_id) ?>
	<input type="hidden" name="pid" value="<?php echo $_GET['edit'] ?>" />
</form>
</div>
<a href="<?php echo URL_PATH.Blog::getBlogPage().'/uncategorised/preview-'.$_GET['edit'] ?>" class="button right" style="margin-top:20px;">Preview Post</a>
<?php else: ?>

<div id="title-bar">
	
	<div id="title-bar-cont">
	
		<h1 class="left">Blog</h1>
		
		<div id="links" class="clearfix">
		<a class="box-link active-tab" href="#box1">Posts</a>
		<a class="box-link" href="#box2">Categories</a>
		</div>
		
	</div>

</div>

<div id="container">

<div id="box1" class="boxes active">
	
	<h3 class="left">Posts</h3>
	
	<a href="dashboard.php?page=blog&new" class="button addnew right">Add New Post +</a>
	
	<?php if (isset($_POST['addnew'])) {
		if (isset($_POST['categories'])) {
			$categories = $_POST['categories'];
		} else {
			$categories = '';
		}
		Blog::addPost($_POST['title'], $_POST['body'], $categories, 'published');
		echo '<p class="message success">Post Added Successfully</p>';
	}

	if (isset($_POST['draft'])) {
		if (isset($_POST['categories'])) {
			$categories = $_POST['categories'];
		} else {
			$categories = '';
		}
	 	Blog::addPost($_POST['title'], $_POST['body'], $categories, 'draft');
		echo '<p class="message success">Post Saved As Draft</p>';
	} 
	
	if (isset($_POST['editpost'])) {
		if (isset($_POST['categories'])) {
			$categories = $_POST['categories'];
		} else {
			$categories = '';
		}
		Blog::editPost($_POST['title'], $_POST['body'], $categories, $_POST['pid']);
		echo '<p class="message success">Post Edited Sucessfully</p>';
	}

	if (isset($_POST['publish'])) {
		if (isset($_POST['categories'])) {
			$categories = $_POST['categories'];
		} else {
			$categories = '';
		}	
		Blog::editPost($_POST['title'], $_POST['body'], $categories, $_POST['pid'], 'published');
		echo '<p class="message success">Post Published Sucessfully</p>';
	}
	
	if (isset($_GET['delete'])) {
		Blog::deletePost($_GET['delete']);
		echo '<p class="message success">Post Deleted</p>';	
	}
	
	 ?>
	
	<?php Blog::postsTable() ?>
	
</div>

<div id="box2" class="boxes">

	<h3 class="left">Categories</h3>
	
	<a href="javascript:void(0);" id="addcategory" class="button right">Add +</a>
	<input type="text" name="addcategory" placeholder="Category" id="newcat" class="right">
	
	
	<?php Blog::catsTable() ?>

</div>

</div>

<?php endif; ?>