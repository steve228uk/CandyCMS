<?php if (isset($_GET['post']) && $_GET['post'] != '') { ?>
	
	<?php $post = getBlogPost($_GET['post']);

	if (!empty($post)) {
	
		// Include the single.php template from theme if it's there!
		
		$themeSingle = THEME_PATH.Options::currentTheme().'/blog/single.php';
		
		if (file_exists($themeSingle)) {
			include $themeSingle;
		} else {
			include 'templates/single.php';
		}
		
	} else {
	
		include THEME_PATH.Options::currentTheme().'/404.php';
	
	} ?>
	
<?php } elseif (isset($_GET['category']) && !is_numeric($_GET['category']) && $_GET['category'] != '' ) { ?>
	
	<?php $posts = listCategoryPosts();
	
		// Include the category.php template from theme if it's there!
		
		$themeCategory = THEME_PATH.Options::currentTheme().'/blog/category.php';
		
		if (file_exists($themeCategory)) {
			include $themeCategory;
		} else {
			include 'templates/category.php';
		}
		
	 ?>

<?php } else { ?>

	<?php $posts = listBlogPosts(); 
	
		// Include the main.php template from theme if it's there!
			
		$themeMain = THEME_PATH.Options::currentTheme().'/blog/main.php';
		
		if (file_exists($themeMain)) {
			include $themeMain;
		} else {
			include 'templates/main.php';
		}
		
	?>
	
<?php } ?>