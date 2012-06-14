<?php

/**
 * @plugin Blog
 * @description A simple blog for CandyCMS. Use {{blog}}
 * @author Cocoon Design
 * @authorURI http://www.wearecocoon.co.uk/
 * @copyright 2012 (C) Cocoon Design  
 * @version 0.6.1
 * @since 0.1
 */
 
 class Blog {
 
 	public static function install() {
 		
 		$dbh = new CandyDB();
 	
 		$dbh->exec("CREATE TABLE IF NOT EXISTS ". DB_PREFIX ."posts (post_id INT(11) NOT NULL AUTO_INCREMENT, PRIMARY KEY(post_id), post_title VARCHAR(64) NOT NULL, UNIQUE KEY (`post_title`), post_body TEXT NOT NULL, cat_id VARCHAR(256) NOT NULL, post_date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP)");
 	
 		$dbh->exec("CREATE TABLE IF NOT EXISTS ". DB_PREFIX ."categories (cat_id INT(11) NOT NULL AUTO_INCREMENT, PRIMARY KEY (cat_id), cat_name VARCHAR(256), UNIQUE KEY (`cat_name`))");
 		
 		$sth = $dbh->prepare("INSERT INTO ".DB_PREFIX."options (option_key, option_value) VALUES ('disqus', '')");
 		$sth->execute();
 		
 		$sth = $dbh->prepare("INSERT INTO ".DB_PREFIX."options (option_key, option_value) VALUES ('perpage', '5')");
 		$sth->execute();
 	}
 
 	public static function adminNav(){
 		return array('blog' => 'Blog');
 	}
 
 	
 	public static function postsTable(){
 	
 		$dbh = new CandyDB();
 		$sth = $dbh->prepare('SELECT * FROM '. DB_PREFIX .'posts ORDER BY post_id DESC');
 		$sth->execute();
 		
 		$posts = $sth->fetchAll(PDO::FETCH_CLASS);
 		
 		$html = '<table>';
 		$html .= '<thead><tr><th>Post Title</th><th>Posted</th><th></th><th></th></tr></thead>';
 		
 		foreach ($posts as $post) {
 			$html .= '<tr>';
 			$html .= '<td>'.$post->post_title.'</td>';
 			$html .= '<td>'.date('d/m/Y H:i:s', strtotime($post->post_date)).'</td>';
 			$html .= '<td><a href="dashboard.php?page=blog&edit='.$post->post_id.'" title="Edit Page">Edit</a></td>';
 			$html .= '<td><a href="dashboard.php?page=blog&delete='.$post->post_id.'" title="'.$post->post_title.'" class="delete">[x]</a></td>';
 			$html .= '</tr>';	
 		}
 		
 		$html .= '</table>';
 		
 		echo $html;
 		
 	}
 	
 	public static function catsTable(){
 		
 		$dbh = new CandyDB();
 		$sth = $dbh->prepare('SELECT * FROM '.DB_PREFIX.'categories ORDER BY cat_id DESC');
 		$sth->execute();
 		
 		$cats = $sth->fetchAll(PDO::FETCH_CLASS);
 		
 		$html = '<table id="catstable">';
 		$html .= '<thead><tr><th>ID</th><th>Category Name</th><th></th><th></th></tr></thead>';
 		
 		foreach ($cats as $cat) {
 			$html .= '<tr>';
 			$html .= '<td>'.$cat->cat_id.'</td>';
 			$html .= '<td>'.$cat->cat_name.'</td>';
 			$html .= '<td><!--Edit--></td>';
 			$html .= '<td><a href="#'.$cat->cat_id.'" title="'.$cat->cat_name.'" class="delcat">[x]</a></td>';
 			$html .= '</tr>';
 		}
 		
 		$html .= '</table>';
 		
 		echo $html;
 		
 	}
 	
 	public static function addPost($post_title, $post_body, $categories){
 		
 		$categories = json_encode($categories);
 		
 		$cats = addslashes($categories);
 		
 		$dbh = new CandyDB();
 		$sth = $dbh->prepare("INSERT INTO ". DB_PREFIX ."posts (post_title, post_body, cat_id) VALUES ('$post_title', '".addslashes($post_body)."', '$cats')");
 		$sth->execute();	
 	
 	}
 
 	public static function editPost($post_title, $post_body, $categories, $pid){
 		
 		$categories = json_encode($categories);
 		
 		$cats = addslashes($categories);
 		
 		$dbh = new CandyDB();
 		$sth = $dbh->prepare("UPDATE ".DB_PREFIX."posts SET post_title='$post_title', post_body='".addslashes($post_body)."', cat_id='$cats' WHERE post_id='$pid'");
 		$sth->execute();	
 		
 	}
 	
 	public static function deletePost($id){
 		
 		$dbh = new CandyDB();
 		$sth = $dbh->prepare('DELETE FROM '. DB_PREFIX .'posts WHERE post_id="'. $id .'"');
 		$sth->execute();
 		
 	}
 	
 	public static function postDate($id, $format = "d/m/Y H:i:s"){
 	
 		$dbh = new CandyDB();
 		$sth = $dbh->prepare("SELECT post_date FROM ". DB_PREFIX ."posts WHERE post_id='".$id."'");
 		$sth->execute();
 		$dbdate = $sth->fetchColumn();
 	
 		echo date($format, strtotime($dbdate));
 	
 	}
 	
 	public static function addShorttag(){
 		
		ob_start();
		include 'frontend.php';
		$include = ob_get_clean();
	  
 		return array('{{blog}}' => $include);	
 		
 	}
 	
 	public static function postUri($id){
 	
 		$dbh = new CandyDB();
 		$sth = $dbh->prepare("SELECT post_title FROM ". DB_PREFIX ."posts WHERE post_id='".$id."'");
 		$sth->execute();
 		$title = $sth->fetchColumn();
 		
 		$sth = $dbh->prepare("SELECT cat_id FROM ". DB_PREFIX ."posts WHERE post_id='".$id."'");
 		$sth->execute();
 		$cats = $sth->fetchColumn();
 		
 		$cats = json_decode($cats);
 		
 		$sth = $dbh->prepare("SELECT cat_name FROM ". DB_PREFIX ."categories WHERE cat_id='". $cats[0] ."'");
 		$sth->execute();
 		
 		$cat = $sth->fetchColumn();
 		
 		$catname = ($cat == false) ? 'uncategorised' : str_replace(' ', '-', strtolower($cat));
 		
 		$uri = explode('/', $_SERVER['REQUEST_URI']);
 		$uri = $uri[1];
 		
 		
 		echo Options::siteUrl().$uri.'/'.$catname.'/'.str_replace(' ', '-', strtolower($title));
 	
 	}
 	
 	public static function postExcerpt($id, $length = 200){
 		
 		$dbh = new CandyDB();
 		$sth = $dbh->prepare("SELECT post_body FROM ". DB_PREFIX ."posts WHERE post_id='".$id."'");
 		$sth->execute();
 		$body = $sth->fetchColumn();
 		
 		if (strlen($body) >= 200) {
 			echo substr($body, 0, $length).'&hellip;';
 		} else {
 			echo $body;
 		}
 		
 	}
 	
 	public static function getCats(){
 	
 		$dbh = new CandyDB();
 		$sth = $dbh->prepare("SELECT * FROM ". DB_PREFIX ."categories");
 		$sth->execute();
 		
 		return $sth->fetchAll(PDO::FETCH_CLASS);
 		
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
 					
 					$cats = json_decode($selected);	
 					
 					if (in_array($cat->cat_id, $cats)) {
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
 			
 			$dbh = new CandyDB();
 			$sth = $dbh->prepare("INSERT INTO ".DB_PREFIX."categories (`cat_name`) VALUES ('{$_POST['catname']}')");
 			$sth->execute();
 			
 			$sth = $dbh->prepare("SELECT cat_id FROM ".DB_PREFIX."categories WHERE cat_name='{$_POST['catname']}'");
 			$sth->execute();
 			echo $sth->fetchColumn();
 			
 		} else {
 			
 			$id = $_POST['id'];
 			
 			$dbh = new CandyDB();
 			$sth = $dbh->prepare("DELETE FROM ".DB_PREFIX."categories WHERE cat_id=$id");
 			$sth->execute();
 				
 		}
 		
 	}
 	
 	public static function disqusAccount(){
 	
 		$dbh = new CandyDB();
 		$sth = $dbh->prepare("SELECT option_value FROM ". DB_PREFIX ."options WHERE option_key='disqus'");
 		$sth->execute();
 		return $sth->fetchColumn();
 	
 	}
 	
 	public static function commentForm(){
 	
 		$post = getBlogPost($_GET['post']);
 	
 		$url = Options::siteUrl();
 	
 		$html = '<div id="disqus_thread"></div>'."\n";
 		$html .= '<script type="text/javascript">'."\n";
 		   
 		   
 		$html .= "var disqus_shortname = '".self::disqusAccount()."';\n";
 		$html .= "var disqus_identifier = '".$post[0]->post_id."';\n";
 		
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
 		
 		$dbh = new CandyDB();
 		
 		$sth = $dbh->prepare("SELECT `option_value` FROM `".DB_PREFIX."options` WHERE `option_key` = 'perpage'");
 		$sth->execute();
 		$limit = $sth->fetchColumn();
 		
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
 		 		
 		$dbh = new CandyDB();
 		$dbh->exec('UPDATE '. DB_PREFIX .'options SET option_value="'. $account .'" WHERE option_key="disqus"');
 		
 		$dbh->exec('UPDATE '. DB_PREFIX .'options SET option_value="'. $limit .'" WHERE option_key="perpage"');
 		
 	}
 	
 	public static function nextLink($text = 'Next', $class = false){
 	
 		$dbh = new CandyDB();
 		$sth = $dbh->prepare("SELECT COUNT(*) FROM `".DB_PREFIX."posts`");
 		$sth->execute();
 		$count = $sth->fetchColumn();
 		
 		$sth = $dbh->prepare("SELECT option_value FROM ".DB_PREFIX."options WHERE option_key='perpage'");
 		$sth->execute();
 		$limit = $sth->fetchColumn();

 		$uri = explode('/', $_SERVER['REQUEST_URI']);
 		$uri = $uri[1];
 
 		if (isset($_GET['category']) && is_numeric($_GET['category'])) {
 			$offset = $_GET['category']+1;
 			$offset = $offset*$limit;
 			$offset = $offset-$limit;
 			
 			$sth = $dbh->prepare('SELECT * FROM '. DB_PREFIX .'posts ORDER BY post_id DESC LIMIT '. $limit . ' OFFSET ' . $offset);
 			$sth->execute();
 			$posts = $sth->fetchAll();
 			
 			$page = $_GET['category']+1;
 			
 			
 			if ($posts != false) {
 				if ($class !=false) {
 					echo "<a href='".Options::siteUrl()."$uri/$page' class='$class'>$text</a>";	
 				} else {
 					echo "<a href='".Options::siteUrl()."$uri/$page'>$text</a>";
 				}
 			}
 			
 		} elseif ($count > $limit) {
 			if ($class !=false) {
 				echo "<a href='".Options::siteUrl()."$uri/2' class='$class'>$text</a>";
 			} else {
 				echo "<a href='".Options::siteUrl()."$uri/2'>$text</a>";
 			}
 		}

 	}
	
	
	public static function prevLink($text = 'Prev', $class = false){
		
		if (isset($_GET['category']) && is_numeric($_GET['category'])) {
			
			$dbh = new CandyDB();
			
			$sth = $dbh->prepare("SELECT option_value FROM ".DB_PREFIX."options WHERE option_key='perpage'");
			$sth->execute();
			$limit = $sth->fetchColumn();
			
			$uri = explode('/', $_SERVER['REQUEST_URI']);
			$uri = $uri[1];
			
			if ($_GET['category'] == 2) {
				if ($class !=false) {
					echo "<a href='".Options::siteUrl()."$uri' class='$class'>$text</a>";
				} else {
					echo "<a href='".Options::siteUrl()."$uri'>$text</a>";
				}
			} else {
				
				$page = $_GET['category']-1;
				
				if ($class !=false) {
					echo "<a href='".Options::siteUrl()."$uri/$page' class='$class'>$text</a>";
				} else {
					echo "<a href='".Options::siteUrl()."$uri/$page'>$text</a>";
				}
			}
			
		}
	
	}
	
 }
 
 function listBlogPosts(){
 	
 	$dbh = new CandyDB();
 	
 	$sth = $dbh->prepare("SELECT `option_value` FROM `".DB_PREFIX."options` WHERE `option_key` = 'perpage'");
 	$sth->execute();
 	$limit = $sth->fetchColumn();
 	
 	if (isset($_GET['category']) && is_numeric($_GET['category'])) {
 		
 		$page = $_GET['category'];
 		
		$offset = $page*$limit;
		$offset = $offset-$limit;
 		
 		$sth = $dbh->prepare('SELECT * FROM '. DB_PREFIX .'posts ORDER BY post_id DESC LIMIT '. $limit . ' OFFSET ' . $offset);
 		
 	} else {
 
	 	$sth = $dbh->prepare('SELECT * FROM '. DB_PREFIX .'posts ORDER BY post_id DESC LIMIT '. $limit);
 	}
 	
 	$sth->execute();
 	
 	return $sth->fetchAll(PDO::FETCH_CLASS);

 }
 
 function listCategoryPosts(){
  	
  	$category = str_replace('-', ' ', $_GET['category']);
  	
  	$dbh = new CandyDB();
  	
  	$sth = $dbh->prepare('SELECT cat_id FROM '.DB_PREFIX.'categories WHERE cat_name="'.$category.'"');
	$sth->execute();
	$catid = $sth->fetchColumn();
  
  	$sth = $dbh->prepare('SELECT post_id, cat_id FROM '.DB_PREFIX.'posts');
  	$sth->execute();
  	$posts = $sth->fetchAll(PDO::FETCH_CLASS);
  	
  	$return = array();
  	
  	foreach ($posts as $post) {
  		$ids = json_decode($post->cat_id);
  		
  		if (in_array($catid, $ids)) {
  			$return[] = $post->post_id;
  		}
  	}
  	
  	$ids = join(',', $return);
 
 	
 	$sth = $dbh->prepare("SELECT * FROM ". DB_PREFIX ."posts WHERE `post_id` IN ($ids) ORDER BY post_id DESC");
  	$sth->execute();
  	
  	return $sth->fetchAll(PDO::FETCH_CLASS);
 
  }
  
  function searchBlog($query){
  	
  	$search = addslashes($query);
  	
  	$dbh = new CandyDB();
  	
  	$sth = $dbh->prepare("SELECT * FROM ".DB_PREFIX."posts WHERE (`post_title` LIKE ?) OR (`post_body` LIKE ?)");
  	$sth->execute(array("%$search%", "%$search%"));
  	
  	return $sth->fetchAll(PDO::FETCH_CLASS);
  	
  }

 function getBlogPost($uri){
 
 	$uri = str_replace('-', ' ', $uri);
 
 	$dbh = new CandyDB();
 	$sth = $dbh->prepare('SELECT * FROM '. DB_PREFIX .'posts WHERE `post_title` = "'. $uri .'"');
 	$sth->execute();
 	
 	return $sth->fetchAll(PDO::FETCH_CLASS);
 }
 
 function getBlogPostById($id){
 
 	$dbh = new CandyDB();
 	$sth = $dbh->prepare('SELECT * FROM '. DB_PREFIX .'posts WHERE `post_id` = "'. $id .'"');
 	$sth->execute();
 	
 	return $sth->fetchAll(PDO::FETCH_CLASS);
 }
 

// The following will generate and rss feed in the root of the CandyCMS install

$xml = '<?xml version="1.0" encoding="UTF-8"?>';
$xml .= '<rss version="2.0">';
$xml .=	'<channel>';
$xml .= '<title>'.Options::candytitle().'</title>';
$xml .=	'<link>'.Options::siteUrl().'</link>';
$xml .= '<description>'.Options::candytitle().' Blog</description>';
$xml .= '<pubDate>'.date('Y-m-d H:i:s').'</pubDate>';

$posts = listBlogPosts();

foreach ($posts as $post) {
	
	$xml .= '<item>';
	$xml .= '<title>'.$post->post_title.'</title>';
	$xml .= '<pubDate>'.$post->post_date.'</pubDate>';
	$xml .= '<description><![CDATA['.$post->post_body.']]></description>';
	$xml .= '</item>';
}

$xml .= '</channel>';
$xml .= '</rss>';

$fp = fopen(CMS_PATH.'rss.xml', 'w');
fwrite($fp, $xml);
fclose($fp);