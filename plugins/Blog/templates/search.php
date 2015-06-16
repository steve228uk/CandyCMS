<?php
if (!empty($posts)) :

	foreach ($posts as $key => $post) : ?>

		<div class="post">
			
			<div class="post-heading">
				<h2>
					<a href="<?php Blog::postUri($post->post_id) ?>">
						<?php= $post->post_title ?>
					</a>
				</h2>
			</div>
			
		</div>
	<?php
    endforeach;
else:
    echo 'Sorry, there are no posts available';
endif;