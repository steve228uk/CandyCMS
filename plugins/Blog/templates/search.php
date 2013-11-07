<?
if (!empty($posts)) :

	foreach ($posts as $key => $post) : ?>

		<div class="post">
			
			<div class="post-heading">
				<h2>
					<a href="<? Blog::postUri($post->post_id) ?>">
						<?= $post->post_title ?>
					</a>
				</h2>
			</div>
			
		</div>
	<?
    endforeach;
else:
    echo 'Sorry, there are no posts available';
endif;