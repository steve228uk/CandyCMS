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

<?php } elseif (isset($_GET['category']) && $_GET['category'] == 'search') { ?>

	<?php $posts = searchBlog($_GET['q']);
		
		// Include search
		
		$themeSearch = THEME_PATH.Options::currentTheme().'/blog/search.php';
		
		if (file_exists($themeSearch)) {
			include $themeSearch;
		} else {
			include 'templates/search.php';
		}
		
	?>
	
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