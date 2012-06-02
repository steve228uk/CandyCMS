<?php

/**
 * @plugin Blog
 * @description A simple blog for CandyCMS. Use {{blog}}
 * @author Cocoon Design
 * @authorURI http://www.wearecocoon.co.uk/
 * @copyright 2012 (C) Cocoon Design  
 * @version 0.5.2
 * @since 0.1
 */
 
 class Blog {
 
 	public static function install() {
 		
 		$dbh = new CandyDB();
 	
 		$dbh->exec("CREATE TABLE IF NOT EXISTS ". DB_PREFIX ."posts (post_id INT(11) NOT NULL AUTO_INCREMENT, PRIMARY KEY(post_id), post_title VARCHAR(64) NOT NULL, UNIQUE KEY (`post_title`), post_body TEXT NOT NULL, cat_id VARCHAR(256) NOT NULL, post_date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP)");
 	
 		$dbh->exec("CREATE TABLE IF NOT EXISTS ". DB_PREFIX ."categories (cat_id INT(11) NOT NULL AUTO_INCREMENT, PRIMARY KEY (cat_id), cat_name VARCHAR(256), UNIQUE KEY (`cat_name`))");
 		
 	}
 
 	public static function adminNav(){
 		return array('blog' => 'Blog');
 	}
 
 	
 	public static function postsTable(){
 	
 		$posts = listBlogPosts();
 		
 		$html = '<table>';
 		$html .= '<thead><tr><th>Post Title</th><th>Posted</th><th></th><th></th></tr></thead>';
 		
 		foreach ($posts as $post) {
 			$html .= '<tr>';
 			$html .= '<td>'.$post->post_title.'</td>';
 			$html .= '<td>'.date('d/m/Y H:i:s', strtotime($post->post_date)).'</td>';
 			$html .= '<td><a href="dashboard.php?page=blog&edit='.$post->post_id.'" title="Edit Page">Edit</a></td>';
 			$html .= '<td><a href="dashboard.php?page=blog&delete='.$post->post_id.'" title="Delete Page">[x]</a></td>';
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
 		
 		var_dump($cats);
 		
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
 		$catname = str_replace(' ', '-', strtolower($sth->fetchColumn()));
 		
 		echo $_SERVER['REQUEST_URI'].'/'.$catname.'/'.str_replace(' ', '-', strtolower($title));
 	
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
 		
		$dbh = new CandyDB();
		$sth = $dbh->prepare("INSERT INTO ".DB_PREFIX."categories (`cat_name`) VALUES ('{$_POST['catname']}')");
		$sth->execute();
		
		$sth = $dbh->prepare("SELECT cat_id FROM ".DB_PREFIX."categories WHERE cat_name='{$_POST['catname']}'");
		$sth->execute();
		echo $sth->fetchColumn();
			
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
 		
 		$html .= "var disqus_url = '/".$_GET['page']."/".$_GET['category']."/".$_GET['post']."';\n";
 		   
 		   
 		$html .= "(function() {\n";
 		$html .= "var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;\n";
 		$html .= "dsq.src = 'http://' + disqus_shortname + '.disqus.com/embed.js';\n";
 		$html .= "(document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);\n";
 		$html .= "})();\n";
 		$html .= "</script>";
 
 		
 		echo $html;
 		
 	}
 	
 	public static function adminSettings(){
 		
 		$disqus = self::disqusAccount();
 		
 		$html = "<ul>";
 		$html .= "<li>";
 		$html .= "<label>Disqus Account</label>";
 		
 		$html .= "<input type='text' name='disqus' value='$disqus'/>";
 		
 		$html .= "</li>";
 		$html .= "</ul>";
 		
 		return $html;
 	}
 	
 	public static function saveSettings(){
 		$account = $_POST['disqus'];
 		
 		$dbh = new CandyDB();
 		$dbh->exec('UPDATE '. DB_PREFIX .'options SET option_value="'. $account .'" WHERE option_key="disqus"');
 		
 	}
 	
 }
 
 function listBlogPosts(){
 	$dbh = new CandyDB();
 	$sth = $dbh->prepare('SELECT * FROM '. DB_PREFIX .'posts ORDER BY post_id DESC');
 	$sth->execute();
 	
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