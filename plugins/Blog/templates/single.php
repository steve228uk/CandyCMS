<div class="post">
	<div class="post-heading">
		<h1><?php echo $post[0]->post_title ?></h1>
		<div class="post-date"><?php Blog::postDate($post[0]->post_id, "d/m/Y") ?></div>
	</div>
	
	<div class="post-cont">
		<?php echo $post[0]->post_body ?>
	</div>
</div>

<?php Blog::commentForm() ?>