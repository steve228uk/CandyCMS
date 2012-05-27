<?php if (isset($_GET['post']) && $_GET['post'] != '') { ?>
	
	<?php $post = getBlogPost($_GET['post']);?>
	
	<?php if (!empty($post)) : ?>
		
		<h1><?php echo $post[0]->post_title ?></h1>
		<div class="post-date"><?php Blog::postDate($post[0]->post_id, "d/m/Y") ?></div>
		<?php echo $post[0]->post_body ?>
	
	<?php else : ?>
	
		<?php include THEME_PATH.Options::currentTheme().'/404.php' ?>
	
	<?php endif ?>
	
<?php } else { ?>

	<?php $posts = listBlogPosts(); 
	
	if (!empty($posts)) :
	
		foreach ($posts as $post) : ?>
		
			<div class="post">
				<h2>
					<a href="<?php Blog::postUri($post->post_id) ?>">
						<?php echo $post->post_title ?>
					</a>
				</h2>
				
				<div class="post-date">
					<?php Blog::postDate($post->post_id, "d/m/Y") ?>
				</div>
				
				<?php Blog::postExcerpt($post->post_id, 400); ?>
				
				<div class="divide"></div>
					
			</div>
			
			
		<?php endforeach; else : ?>
		
			Sorry, there are no posts available
			
	<?php endif; ?>

<?php } ?>
