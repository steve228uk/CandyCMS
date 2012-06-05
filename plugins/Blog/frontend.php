<?php if (isset($_GET['post']) && $_GET['post'] != '') { ?>
	
	<?php $post = getBlogPost($_GET['post']);?>
	
	<?php if (!empty($post)) : ?>
		<div class="post last">
			<div class="post-heading">
				<h1><?php echo $post[0]->post_title ?></h1>
				<div class="post-date"><?php Blog::postDate($post[0]->post_id, "d/m/Y") ?></div>
			</div>
			
			<div class="post-cont">
				<?php echo $post[0]->post_body ?>
			</div>
			
			<div class="paper"></div>
			<div class="paper"></div>
			<div class="paper"></div>
			
		</div>
		
		
		<?php Blog::commentForm() ?>
		
		
	<?php else : ?>
	
		<?php include THEME_PATH.Options::currentTheme().'/404.php' ?>
	
	<?php endif ?>
	
<?php } elseif (isset($_GET['category']) && !is_numeric($_GET['category']) && $_GET['category'] != '' ) { ?>
	
	<?php $posts = listCategoryPosts(); ?>

	<?php if (!empty($posts)) :
	
		$count = count($posts);
	
		foreach ($posts as $key => $post) : ?>
			
			
			<?php if($key === $count-1) : ?>
			
			<div class="post last">
			
			<?php else : ?>
			
			<div class="post">
			
			<?php endif ?>
			
				<?php if($key != 0) : ?>
				
				<div class="divider left"></div>
				<div class="divider right"></div>
				
				<?php endif; ?>
				
				<div class="post-heading">
					<h2>
						<a href="<?php Blog::postUri($post->post_id) ?>">
							<?php echo $post->post_title ?>
						</a>
					</h2>
					
					<div class="post-date">
						<?php Blog::postDate($post->post_id, "d/m/Y") ?>
					</div>
				</div>
				
				<div class="post-cont">
					<?php Blog::postExcerpt($post->post_id, 400); ?>
				</div>	
				
				<a href="<?php Blog::postUri($post->post_id) ?>" title="View Post" class="button">View Post</a>
				
				<a href="<?php Blog::postUri($post->post_id) ?>#disqus_thread" data-disqus-identifier="<?php echo $post->post_id ?>" class="comment-link"></a>
				
				<?php if($key === $count-1) : ?>
				
				<div class="paper"></div>
				<div class="paper"></div>
				<div class="paper"></div>
				
				<?php endif ?>
				
			</div>
			
			<script type="text/javascript">
			    /* * * CONFIGURATION VARIABLES: EDIT BEFORE PASTING INTO YOUR WEBPAGE * * */
			    var disqus_shortname = '<?php echo Blog::disqusAccount() ?>'; // required: replace example with your forum shortname
			
			    /* * * DON'T EDIT BELOW THIS LINE * * */
			    (function () {
			        var s = document.createElement('script'); s.async = true;
			        s.type = 'text/javascript';
			        s.src = 'http://' + disqus_shortname + '.disqus.com/count.js';
			        (document.getElementsByTagName('HEAD')[0] || document.getElementsByTagName('BODY')[0]).appendChild(s);
			    }());
			</script>
			
		<?php endforeach; else : ?>
		
			Sorry, there are no posts available
	
			
	<?php endif; ?>
	
	
<?php } else { ?>

	<?php $posts = listBlogPosts(); 
	
	if (!empty($posts)) :
	
		$count = count($posts);
	
		foreach ($posts as $key => $post) : ?>
			
			
			<?php if($key === $count-1) : ?>
			
			<div class="post last">
			
			<?php else : ?>
			
			<div class="post">
			
			<?php endif ?>
			
				<?php if($key != 0) : ?>
				
				<div class="divider left"></div>
				<div class="divider right"></div>
				
				<?php endif; ?>
				
				<div class="post-heading">
					<h2>
						<a href="<?php Blog::postUri($post->post_id) ?>">
							<?php echo $post->post_title ?>
						</a>
					</h2>
					
					<div class="post-date">
						<?php Blog::postDate($post->post_id, "d/m/Y") ?>
					</div>
				</div>
				
				<div class="post-cont">
					<?php Blog::postExcerpt($post->post_id, 400); ?>
				</div>	
				
				<a href="<?php Blog::postUri($post->post_id) ?>" title="View Post" class="button">View Post</a>
				
				<a href="<?php Blog::postUri($post->post_id) ?>#disqus_thread" data-disqus-identifier="<?php echo $post->post_id ?>" class="comment-link"></a>
				
				<?php if($key === $count-1) : ?>
				
				<div class="paper"></div>
				<div class="paper"></div>
				<div class="paper"></div>
				
				<?php endif ?>
				
			</div>
			
			<script type="text/javascript">
			    /* * * CONFIGURATION VARIABLES: EDIT BEFORE PASTING INTO YOUR WEBPAGE * * */
			    var disqus_shortname = '<?php echo Blog::disqusAccount() ?>'; // required: replace example with your forum shortname
			
			    /* * * DON'T EDIT BELOW THIS LINE * * */
			    (function () {
			        var s = document.createElement('script'); s.async = true;
			        s.type = 'text/javascript';
			        s.src = 'http://' + disqus_shortname + '.disqus.com/count.js';
			        (document.getElementsByTagName('HEAD')[0] || document.getElementsByTagName('BODY')[0]).appendChild(s);
			    }());
			</script>
			
		<?php endforeach; else : ?>
		
			Sorry, there are no posts available
			
	<?php endif; ?>
	
<?php } ?>