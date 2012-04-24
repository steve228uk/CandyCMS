<?php 
/**
 * @template Blog - Requires Plugin
 * @author Cocoon Design
 * @copyright 2012 (c) Cocoon Design
 */	
?>
<div id="content">
	<?php if(function_exists('listBlogPosts')) : ?>
		
		<?php if (isset($_GET['post']) && $_GET['post'] != '') { ?>
			
			<?php $post = getBlogPost($_GET['post']);?>
			<h1><?php echo $post[0]->post_title ?></h1>
			<?php echo $post[0]->post_body ?>
			
		<?php } else { ?>
		
			<h1><?php theTitle() ?></h1>
			<?php theContent() ?>
		
		<?php $posts = listBlogPosts(); 
			
			if (!empty($posts)) :
			
				foreach ($posts as $post) : ?>
					<div class="post">
						<h2><a href="<?php echo $_SERVER['REQUEST_URI'].'/'.$post->post_id ?>"><?php echo $post->post_title ?></a></h2>
						<?php echo $post->post_body; ?>
					</div>
				<?php endforeach; else : ?>
				
					Sorry, there are no posts available
					
			<?php endif; ?>
			
		<?php } ?>
	
	<?php else: ?>
	
		<h1><?php theTitle() ?></h1>
		<?php theContent() ?>
	
	<?php endif; ?>
</div>
<div id="sidebar">
	This is the sidebar
</div>