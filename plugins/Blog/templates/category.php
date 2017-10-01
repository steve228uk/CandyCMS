<?php if (!empty($posts)):

	foreach ($posts as $key => $post): ?>

		<div class="post">
			
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
		
	<?php endforeach;
    else:
    	echo 'Sorry, there are no posts available';
    endif;