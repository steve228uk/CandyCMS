<?php if (isset($_GET['post']) && $_GET['post'] != '') { ?>
	
	<?php $post = getBlogPost($_GET['post']);?>
	<h1><?php echo $post[0]->post_title ?></h1>
	<?php echo $post[0]->post_body ?>
	
<?php } else { ?>

	<?php $posts = listBlogPosts(); 
	
	if (!empty($posts)) :
	
		foreach ($posts as $post) : ?>
			<div class="post">
				<h2><a href="<?php echo $_SERVER['REQUEST_URI'].'/'.str_replace(' ', '-', strtolower($post->post_title)) ?>"><?php echo $post->post_title ?></a></h2>
				<?php echo $post->post_body; ?>
			</div>
		<?php endforeach; else : ?>
		
			Sorry, there are no posts available
			
	<?php endif; ?>

<?php } ?>
