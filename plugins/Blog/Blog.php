<?

/**
 * @plugin Blog
 * @description A simple blog for CandyCMS. Use {{blog}}
 * @author Cocoon Design
 * @authorURI http://www.wearecocoon.co.uk/
 * @copyright 2012 (C) Cocoon Design  
 * @version 1.0
 * @since 0.1
 */
 
 class Blog {
 
 	public static function install() {
 		
 		CandyDB::q("CREATE TABLE IF NOT EXISTS ". DB_PREFIX ."posts (post_id INT(11) NOT NULL AUTO_INCREMENT, PRIMARY KEY(post_id), post_title VARCHAR(64) NOT NULL, UNIQUE KEY (`post_title`), post_body TEXT NOT NULL, permalink TEXT NOT NULL, cat_id VARCHAR(256) NOT NULL, post_date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP, status TEXT NOT NULL)");
 		CandyDB::q("CREATE TABLE IF NOT EXISTS ". DB_PREFIX ."categories (cat_id INT(11) NOT NULL AUTO_INCREMENT, PRIMARY KEY (cat_id), cat_name VARCHAR(256), UNIQUE KEY (`cat_name`))");
 
 		CandyDB::q("INSERT INTO ".DB_PREFIX."options (option_key, option_value) VALUES (:key, :value)", array('key' => 'disqus', 'value' => ''));
 		CandyDB::q("INSERT INTO ".DB_PREFIX."options (option_key, option_value) VALUES (:key, :value)", array('key' => 'perpage', 'value' => 5));

 	}

 	public static function listCategories($cat_id) {
 		
 		$cats = array();		
 		$cat_id = json_decode(stripslashes($cat_id));
 		
 		foreach ($cat_id as $value)
 			$cats[] = CandyDB::col("SELECT cat_name FROM ".DB_PREFIX."categories WHERE cat_id = :id", array('id' => $value));

 		$html = '';
 		
 		if (!empty($cats)):
 			$html .= '<ul class="category-list">';

 			foreach ($cats as $value):
 				$catlink = str_replace(' ', '-', strtolower($value));
 				$html .= '<li class="cat-'.strtolower($value).'"><a href="'.URL_PATH.self::getBlogPage().'/'.$catlink.'" title="'.$value.'">'.$value.'</a></li>';
 		    endforeach;

 			$html .= '</ul>';	
 		endif;
 		
 		echo $html;
 	
 	}
 
 	public static function adminNav(){
 		return array('blog' => 'Blog');
 	}
 
 	public static function postsTable(){

 		$posts = CandyDB::results('SELECT * FROM '. DB_PREFIX .'posts ORDER BY post_id DESC');
 		
 		$html = '<table>';
 		$html .= '<thead><tr><th>Post Title</th><th>Posted</th><th>Status</th><th></th><th></th></tr></thead>';
 		
 		foreach ($posts as $post) {
 			$html .= '<tr>';
 			$html .= '<td>'.$post->post_title.'</td>';
 			$html .= '<td>'.date('d/m/Y H:i:s', strtotime($post->post_date)).'</td>';
 			$html .= '<td>'.ucwords($post->status).'</td>';
 			$html .= '<td width="20"><a href="dashboard.php?page=blog&edit='.$post->post_id.'" title="Edit Page"><i class="fa fa-pencil-square-o"></i></a></td>';
 			$html .= '<td width="20"><a href="dashboard.php?page=blog&delete='.$post->post_id.'" title="'.$post->post_title.'" class="delete"><i class="fa fa-trash-o"></i></a></td>';
 			$html .= '</tr>';	
 		}
 		
 		$html .= '</table>';
 		
 		echo $html;
 		
 	}
 	
 	public static function catsTable(){
 		
 		$cats = CandyDB::results('SELECT * FROM '.DB_PREFIX.'categories ORDER BY cat_id DESC');
 		
 		$html = '<table id="catstable">';
 		$html .= '<thead><tr><th>ID</th><th>Category Name</th><th></th><th></th></tr></thead>';
 		
 		foreach ($cats as $cat) {
 			$html .= '<tr>';
 			$html .= '<td>'.$cat->cat_id.'</td>';
 			$html .= '<td>'.$cat->cat_name.'</td>';
 			$html .= '<td><!--Edit--></td>';
 			$html .= '<td><a href="#'.$cat->cat_id.'" title="'.$cat->cat_name.'" class="delcat"><i class="fa fa-trash-o"></i></a></td>';
 			$html .= '</tr>';
 		}
 		
 		$html .= '</table>';
 		
 		echo $html;
 		
 	}
 	
 	public static function addPost($post_title, $post_body, $categories, $permalink, $status){
 		
 		$categories = json_encode($categories);
 		$cats = addslashes($categories);
 		$title = $post_title;
 		$body = $post_body;

		CandyDB::q("INSERT INTO ". DB_PREFIX ."posts (post_title, post_body, cat_id, permalink, status) VALUES (:title, :body, :cats, :permalink, :status)",
			array(
				'title' => $title,
				'body' => $body,
				'cats' => $cats,
				'permalink' => $permalink,
				'status' => $status
			)
		);
		 	
 	}
 
 	public static function editPost($post_title, $post_body, $categories, $permalink, $pid, $status=null){
 
 		$cats = addslashes(json_encode($categories));
 		$title = $post_title;
 		$body = $post_body;
 		
 		if (is_null($status)) {
 			CandyDB::q("UPDATE ".DB_PREFIX."posts SET post_title = :title, post_body = :body, cat_id = :cats, permalink = :permalink WHERE post_id = :id",
 				array(
 					'title' => $title,
					'body' => $body,
					'cats' => $cats,
					'permalink' => $permalink,
					'id' => $pid
 				)
 			);
 		} else {
 			CandyDB::q("UPDATE ".DB_PREFIX."posts SET post_title = :title, post_body = :body, cat_id = :cats, permalink = :permalink, status = :status WHERE post_id = :id",
 				array(
 					'title' => $title,
					'body' => $body,
					'cats' => $cats,
					'permalink' => $permalink,
					'status' => $status,
					'id' => $pid
 				)
 			);
 		}
 		
 	}
 	
 	public static function deletePost($id){
 		CandyDB::q('DELETE FROM '. DB_PREFIX .'posts WHERE post_id = :id', compact('id')); 		
 	}
 	
 	public static function postDate($id, $format = "d/m/Y H:i:s"){
 		$dbdate = CandyDB::col("SELECT post_date FROM ". DB_PREFIX ."posts WHERE post_id = :id", compact('id'));
 		echo date($format, strtotime($dbdate));
 	}
 	
 	public static function addShorttag(){
 		
 		$theme = Candy::Options('theme');
 		
		ob_start();
		include 'frontend.php';
		$include = ob_get_clean();
		
		ob_start();
		$sidebar = THEME_PATH.$theme.'/blog/sidebar.php';
		if (file_exists($sidebar)) {
			include($sidebar);
		} else {
			include('templates/sidebar.php');
		}
		$sidebar = ob_get_clean();
	  
 		return array('{{blog}}' => $include, '{{sidebar}}' => $sidebar);	
 		
 	}
 	
 	public static function getPostUri($id){

 		$permalink = CandyDB::col("SELECT permalink FROM ". DB_PREFIX ."posts WHERE post_id = :id", compact('id'));
 		
 		$cats = CandyDB::col("SELECT cat_id FROM ". DB_PREFIX ."posts WHERE post_id = :id", compact('id'));
 		$cats = json_decode(stripslashes($cats));
 		if (empty($cats)) {
 			$cat = false;
 		} else {
 			$cat = CandyDB::col("SELECT cat_name FROM ". DB_PREFIX ."categories WHERE cat_id = :cat", array('cat' => $cats[0]));
 		}
 		$catname = ($cat == false) ? 'uncategorised' : str_replace(' ', '-', strtolower($cat));
 		
 		$uri = self::getBlogPage();

 		return URL_PATH.$uri.'/'.$catname.'/'.$permalink;
 		
 	}
 	
 	public static function postUri($id){
 	 	echo self::getPostUri($id);
 	}
 	
 	public static function postExcerpt($id, $length = 200){
 		
 		$body = CandyDB::col("SELECT post_body FROM ". DB_PREFIX ."posts WHERE post_id = :id", compact('id'));
 		
 		if (strlen($body) >= $length) {
 			echo substr($body, 0, $length).'&hellip;';
 		} else {
 			echo $body;
 		}
 		
 	}
 	
 	public static function getCats(){
 		return CandyDB::results("SELECT * FROM ". DB_PREFIX ."categories");
 	}
 	
 	public static function adminCats($selected = false){
 		
 		$cats = self::getCats();
 		
 		$html = '<div id="blog-cats">';
 		$html .= '<h3>Categories</h3>';
 		$html .= '<ul>';
 		
 		if (!empty($cats)) {
 		
 			foreach ($cats as $cat) {
 				
 				if ($selected == false) {
 			
 					$html .= "<li>{$cat->cat_name}<input type='checkbox' value='{$cat->cat_id}' name='categories[]' /></li>";
 					
 				} else {
 					
 					$cats = json_decode(stripslashes($selected));	
 					
 					if (is_array($cats) && in_array($cat->cat_id, $cats)) {
 						$html .= "<li>{$cat->cat_name}<input type='checkbox' value='{$cat->cat_id}' name='categories[]' checked='checked' /></li>";	
 					} else {
 						$html .= "<li>{$cat->cat_name}<input type='checkbox' value='{$cat->cat_id}' name='categories[]' /></li>";
 					}
 					
 				}
 				
 			}	
 			
 		} else {
 			$html .= '<li>Add a category to begin</li>';
 		}
 		
 		$html .= '</ul>';
 		
 		$html .= '<div><input type="text" name="addcat" placeholder="Category" id="newcat" /><a href="javascript:void(0);" id="addcat" class="button">Add +</a></div>';
 		
 		echo $html;
 			
 	}
 	
 	public static function adminHead(){
 	 	return '<script type="text/javascript" src="'.PLUGIN_URL.'Blog/js/admin.jquery.js"></script>';
 	}
 	
 	public static function ajax(){
 		
 		if (isset($_POST['catname'])) {
 			
 			CandyDB::q("INSERT INTO ".DB_PREFIX."categories (`cat_name`) VALUES (:name)", array('name' => $_POST['catname']));
 			echo CandyDB::col("SELECT cat_id FROM ".DB_PREFIX."categories WHERE cat_name = :name", array('name' => $_POST['catname']));
 		
 		} elseif (isset($_POST['search'])) {
 		
 			$posts = searchBlog($_POST['q']['term']);
 			echo json_encode($posts);
 			
 		} else {
 			
 			$id = $_POST['id'];
 			CandyDB::q("DELETE FROM ".DB_PREFIX."categories WHERE cat_id = :id", compact('id'));
				
 		}
 		
 	}
 	
 	public static function disqusAccount(){
 		$disqus = CandyDB::col("SELECT option_value FROM ". DB_PREFIX ."options WHERE option_key = :key", array('key' => 'disqus'));

        if ( $disqus != '' )
            return $disqus;
        else
            return false;
 	}
 	
 	public static function commentForm(){
 		
 		$post = getBlogPost($_GET['post']);
 	
 		$url = Candy::Options('site_url');
 		
 		$html = '<div id="disqus_thread"></div>'."\n";
 		$html .= '<script type="text/javascript">'."\n";
 		      
 		$html .= "var disqus_shortname = '".self::disqusAccount()."';\n";
 		
 		if (!empty($post)) $html .= "var disqus_identifier = '".$post[0]->post_id."';\n";
 		
 		$html .= "var disqus_url = '$url".$_GET['page']."/".$_GET['category']."/".$_GET['post']."';\n";
 		   
 		$html .= "(function() {\n";
 		$html .= "var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;\n";
 		$html .= "dsq.src = 'http://' + disqus_shortname + '.disqus.com/embed.js';\n";
 		$html .= "(document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);\n";
 		$html .= "})();\n";
 		$html .= "</script>";
 
 		echo $html;
 		
 	}
 	
 	public static function adminSettings(){

 		$limit = CandyDB::col("SELECT `option_value` FROM `".DB_PREFIX."options` WHERE `option_key` = :key", array('key' => 'perpage'));
 		
 		$disqus = self::disqusAccount();
 		
 		$html = "<h3>Blog Settings</h3>";
 		
 		$html .= "<ul>";
 		$html .= "<li>";
 		$html .= "<label>Disqus Account</label>";
 		$html .= "<input type='text' name='disqus' value='$disqus'/>";
 		$html .= "</li>";
 		
 		$html .= "<label>Posts Per Page</label>";
 		$html .= "<input type='text' name='perpage' value='$limit'/>";
 		$html .= "</li>";
 		
 		$html .= "</ul>";
 		
 		return $html;
 	}
 	
 	public static function saveSettings(){
 		$account = $_POST['disqus'];
 		$limit = $_POST['perpage'];
 
 		CandyDB::q('UPDATE '. DB_PREFIX .'options SET option_value = :value WHERE option_key = :key', array('value' => $account, 'key' => 'disqus'));
 		CandyDB::q('UPDATE '. DB_PREFIX .'options SET option_value = :value WHERE option_key = :key', array('value' => $limit, 'key' => 'perpage'));
 		
 	}
 	
 	public static function nextLink($text = 'Next', $class = false){
 	
 		$site_url = Candy::Options('site_url');

 		$count = CandyDB::col("SELECT COUNT(*) FROM `".DB_PREFIX."posts` WHERE status = 'published' AND ");

 		$limit = CandyDB::col("SELECT option_value FROM ".DB_PREFIX."options WHERE option_key = :key", array('key' => 'perpage'));

 		if (isset($_GET['page'])) {
 			$uri = $_GET['page'];
 		} else {
 			$uri = Candy::Options('homepage');
 		}
 
 		if (isset($_GET['category']) && is_numeric($_GET['category'])) {
 			$offset = $_GET['category']+1;
 			$offset = $offset*$limit;
 			$offset = $offset-$limit;
 		
 			$posts = CandyDB::results('SELECT * FROM '. DB_PREFIX .'posts ORDER BY post_id DESC LIMIT '.$limit.' OFFSET '.$offset);
 			
 			$page = $_GET['category']+1;
 			
 			if ($posts != false) {
 				if ($class !=false) {
 					echo "<a href='".$site_url."$uri/$page' class='$class'>$text</a>";	
 				} else {
 					echo "<a href='".$site_url."$uri/$page'>$text</a>";
 				}
 			}
 			
 		} elseif ($count > $limit) {
 			if ($class !=false) {
 				echo "<a href='".$site_url."$uri/2' class='$class'>$text</a>";
 			} else {
 				echo "<a href='".$site_url."$uri/2'>$text</a>";
 			}
 		}

 	}
	
	
	public static function prevLink($text = 'Prev', $class = false){
		
		$site_url = Candy::Options('site_url');
		
		if (isset($_GET['category']) && is_numeric($_GET['category'])):

			$limit = CandyDB::col("SELECT option_value FROM ".DB_PREFIX."options WHERE option_key = :key", array('key' => 'perpage'));
			
			if (isset($_GET['page'])):
	 			$uri = explode('/', $_SERVER['REQUEST_URI']);
	 			$uri = $uri[1];
	 		else:
	 			$uri = Candy::Options('homepage');
	 		endif;
			
			if ($_GET['category'] == 2):
				if ($class !=false)
					echo "<a href='".$site_url.Blog::getBlogPage()."' class='$class'>$text</a>";
				else
					echo "<a href='".$site_url."'>$text</a>";

            else:
				$page = $_GET['category']-1;
				
				if ($class !=false)
					echo "<a href='".$site_url."$uri/$page' class='$class'>$text</a>";
				else
					echo "<a href='".$site_url."$uri/$page'>$text</a>";
			endif;

        endif;
	
	}
	
	public static function theCategories(){
		
		$cats = CandyDB::results('SELECT cat_name FROM '.DB_PREFIX.'categories ORDER BY cat_id DESC');
		
		$html = '';
		
		if (!empty($cats)) {
			
			$path = URL_PATH;
			$html .= '<ul>';
		
			foreach ($cats as $cat) {
				$html .= "<li><a href='".$path.self::getBlogPage()."/".str_replace(' ', '-', strtolower($cat->cat_name))."'>".$cat->cat_name."</a></li>";
			}	
			
			$html .= '</ul>';
		}
		
		echo $html;
		
	}
	
	public static function getBlogPage() {
		return CandyDB::col('SELECT rewrite FROM '.DB_PREFIX.'pages WHERE page_body LIKE "%{{blog}}%"');
	}

	public static function getPostTitle($permalink){
		return CandyDB::col('SELECT post_title FROM '.DB_PREFIX.'posts WHERE permalink = :permalink', compact('permalink'));
	}
	
 }
 
 function listBlogPosts(){
 
 	$limit = CandyDB::col("SELECT `option_value` FROM `".DB_PREFIX."options` WHERE `option_key` = :key", array('key' => 'perpage'));
 	
 	if (isset($_GET['category']) && is_numeric($_GET['category'])) {
 		
 		$page = $_GET['category'];
 		
		$offset = $page*$limit;
		$offset = $offset-$limit;
 		
 		$results = CandyDB::results('SELECT * FROM '. DB_PREFIX .'posts WHERE `status` = :status ORDER BY post_id DESC LIMIT '.$limit.' OFFSET '.$offset,
 			array(
 				'status' => 'published'
 			)
 		);
 		
 	} else {
	 	$results = CandyDB::results('SELECT * FROM '. DB_PREFIX .'posts WHERE `status` = :status ORDER BY post_id DESC LIMIT '.$limit,
	 		array(
	 			'status' => 'published'
	 		)
	 	);
 	}

 	return $results;

 }
 
 function listCategoryPosts(){
  	
  	$category = str_replace('-', ' ', $_GET['category']);

	$catid = CandyDB::col('SELECT cat_id FROM '.DB_PREFIX.'categories WHERE cat_name = :cat', array('cat' => $category));
  	$posts = CandyDB::results('SELECT post_id, cat_id FROM '.DB_PREFIX.'posts WHERE status = :status', array('status' => 'published'));
  	
  	$return = array();
  	
  	foreach ($posts as $post) {
  		$ids = json_decode(stripslashes($post->cat_id));
  		
  		if (is_array($ids) && in_array($catid, $ids)) {
  			$return[] = $post->post_id;
  		}
  	}
  	
  	$ids = join(',', $return);

  	return CandyDB::results("SELECT * FROM ". DB_PREFIX ."posts WHERE `post_id` IN (".$ids.") ORDER BY post_title ASC");
 
  }
  
  function searchBlog($query){
  	$search = addslashes($query);
  	return CandyDB::results("SELECT * FROM ".DB_PREFIX."posts WHERE (`post_title` LIKE :title) OR (`post_body` LIKE :body)", array('title' => "%$search%", 'body' => "%$search%"));
  }

 function getBlogPost($uri){
 	return CandyDB::results('SELECT * FROM '. DB_PREFIX .'posts WHERE `permalink` = :permalink', array('permalink' => $uri));
 }
 
 function getBlogPostById($id){
 	return CandyDB::results('SELECT * FROM '. DB_PREFIX .'posts WHERE `post_id` = :id', compact('id'));
 }
 
$uri = $_SERVER['REQUEST_URI'];

if (!stristr($uri, 'cms-admin') && !stristr($uri, 'ajax.php')) {

	//The following will generate and rss feed in the root of the CandyCMS install

	$xml = '<?xml version="1.0" encoding="UTF-8"?>';
	$xml .= '<rss version="2.0">';
	$xml .=	'<channel>';
	$xml .= '<title>'.Candy::Options('site_title').'</title>';
	$xml .=	'<link>'.Candy::Options('site_url').'</link>';
	$xml .= '<description>'.Candy::Options('site_title').' Blog</description>';
	$xml .= '<pubDate>'.date('Y-m-d H:i:s').'</pubDate>';

	$posts = listBlogPosts();

	foreach ($posts as $post) {
		$xml .= '<item>';
		$xml .= '<title>'.$post->post_title.'</title>';
		$xml .= '<link>'.Blog::getPostUri($post->post_id).'</link>';
		$xml .= '<pubDate>'.$post->post_date.'</pubDate>';
		$xml .= '<description><![CDATA['.$post->post_body.']]></description>';
		$xml .= '</item>';
	}

	$xml .= '</channel>';
	$xml .= '</rss>';

	$fp = fopen(CMS_PATH.'rss.xml', 'w');
	fwrite($fp, $xml);
	fclose($fp);
}