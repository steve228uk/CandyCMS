<article>
	
	<div class="clearfix">
		<h1 class="left"><?php echo $post[0]->post_title ?></h1>
		<div class="right post-date single">
			<?php Blog::postDate($post[0]->post_id, "d/m/Y") ?>
		</div>
	</div>
	
	<?php echo $post[0]->post_body ?>
	
</article>

<?php Blog::commentForm() ?>