<? if (!empty($posts)) :

	$count = count($posts);

	foreach ($posts as $key => $post) : ?>
		
		<div class="post">	
			
			<div class="post-heading">
				<h2>
					<a href="<? Blog::postUri($post->post_id) ?>">
						<?=$post->post_title ?>
					</a>
				</h2>
				
				<div class="post-date">
					<? Blog::postDate($post->post_id, "d/m/Y") ?>
				</div>
			</div>
			
			<div class="post-cont">
				<? Blog::postExcerpt($post->post_id, 400); ?>
			</div>	
			
			<a href="<? Blog::postUri($post->post_id) ?>" title="View Post" class="button">View Post</a>
			<? if ( Blog::disqusAccount() ): ?>
			    <a href="<? Blog::postUri($post->post_id) ?>#disqus_thread" data-disqus-identifier="<? echo $post->post_id ?>" class="comment-link"></a>
	        <? endif; ?>
		</div>
        <? if ( Blog::disqusAccount() ): ?>
		<script type="text/javascript">
		    /* * * CONFIGURATION VARIABLES: EDIT BEFORE PASTING INTO YOUR WEBPAGE * * */
		    var disqus_shortname = '<?= Blog::disqusAccount() ?>'; // required: replace example with your forum shortname

		    /* * * DON'T EDIT BELOW THIS LINE * * */
		    (function () {
		        var s = document.createElement('script'); s.async = true;
		        s.type = 'text/javascript';
		        s.src = 'http://' + disqus_shortname + '.disqus.com/count.js';
		        (document.getElementsByTagName('HEAD')[0] || document.getElementsByTagName('BODY')[0]).appendChild(s);
		    }());
		</script>
        <? endif; ?>
	<? endforeach;
		Blog::prevLink('&larr; Previous Posts', 'bloglink prev');
		Blog::nextLink('Next Posts &rarr;', 'bloglink next');
	else:
		echo 'Sorry, there are no posts available';
    endif;