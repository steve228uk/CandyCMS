<?php

/**
* @package CandyCMS
* @subpackage Blog
* @version 0.5.2
* @since 0.1
* @copyright Copyright 2012 (C) Cocoon Design Ltd. - All Rights Reserved
* 
* This file generates the pages for the blog admin
*/

?>

<?php if (isset($_GET['new'])) : ?>

<h1>Add New Post</h1>	
<form action="dashboard.php?page=blog" method="post">
	<ul id="post-info">
		<li id="post-title">
			<input type="text" class="inputstyle" name="title" placeholder="Title" />
		</li>
		<li><textarea class="ckeditor" name="body"></textarea></li>
		<li id="post-btn"><input type="submit" name="addnew" value="Add New Post" class="button" /></li>
	</ul>
	<?php Blog::adminCats() ?>
</form>

<?php elseif(isset($_GET['edit'])) : ?>

<?php $post = getBlogPostById($_GET['edit']) ?>
	
<h1>Edit Post</h1>	
<form action="dashboard.php?page=blog" method="post">

	<ul id="post-info">
		<li id="post-title">
			<input type="text" class="inputstyle" name="title" placeholder="Title" value="<?php echo $post[0]->post_title ?>" />
		</li>
		<li><textarea class="ckeditor" name="body"><?php echo $post[0]->post_body ?></textarea></li>
		<li id="post-btn"><input type="submit" name="editpost" value="Save Post" class="button" /></li>
	</ul>
	<?php Blog::adminCats($post[0]->cat_id) ?>

	<input type="hidden" name="pid" value="<?php echo $_GET['edit'] ?>" />
</form>
<?php else: ?>

<h1 class="left">Blog</h1>


<div id="links" class="clearfix">
<a class="box-link active-tab" href="#box1">Posts</a> <!-- THE HREF HAS TO BE THE SAME AS THE ID OF THE BOX -->
<a class="box-link" href="#box2">Categories</a>
</div>


<div id="box1" class="boxes active">
	
	<a href="dashboard.php?page=blog&new" class="button addnew right">Add New Post +</a>
	
	<?php if (isset($_POST['addnew'])) {
		
		Blog::addPost($_POST['title'], $_POST['body'], $_POST['categories']);
		echo '<p class="message success">Post Added Successfully</p>';
			
	} 
	
	if (isset($_POST['editpost'])) {
		
		Blog::editPost($_POST['title'], $_POST['body'], $_POST['categories'], $_POST['pid']);
		echo '<p class="message success">Post Edited Sucessfully</p>';
		
	}
	
	if (isset($_GET['delete'])) {
		Blog::deletePost($_GET['delete']);
		echo '<p class="message success">Post Deleted</p>';	
	}
	
	 ?>
	
	<?php Blog::postsTable() ?>
	
</div>

<div id="box2" class="boxes">Something else</div>

<?php endif; ?>