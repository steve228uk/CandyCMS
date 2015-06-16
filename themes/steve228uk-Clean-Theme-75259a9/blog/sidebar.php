<h4>Search</h4>
<form method="get" action="<?php echo URL_PATH.$_GET['page'] ?>/search">
	<input type="text" name="q" placeholder="Search" id="search-box" />
</form>

<h4>Categories</h4>
<?php Blog::theCategories() ?>