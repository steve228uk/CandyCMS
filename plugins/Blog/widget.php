<?

/**
 * @title Blog Posts
 */

$posts = listBlogPosts();

if (!empty($posts)):
	
	echo '<ul>';
	
	foreach($posts as $post)
		echo "<li class='lrg'><a href='dashboard.php?page=blog&edit={$post->post_id}'>{$post->post_title}</a></li>";

	echo '</ul>';
		
else:
	
	echo "<p>There are currently no blog posts</p>";

endif;