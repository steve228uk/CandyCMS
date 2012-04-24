<?php

/**
 * @plugin Blog
 * @description A simple blog for CandyCMS
 * @author Cocoon Design
 * @authorURI http://www.wearecocoon.co.uk/
 * @copyright 2012 (C) Cocoon Design  
 * 
 */
 
 class Blog {
 
 	public static function install() {
 		
 		$dbh = new CandyDB();
 		$dbh->exec("CREATE TABLE ". DB_PREFIX ."posts (post_id INT NOT NULL AUTO_INCREMENT, PRIMARY KEY(post_id), post_title VARCHAR(64), post_body TEXT, permalink VARCHAR(64) ADD UNQIUE(permalink))");
 	
 		# todo: ensure the unique is working
 		
 		# echo '<p class="message success">The blog can be accessed from the top navigation</p>';	
 		
 	}
 
 	public static function adminNav(){
 		return array('Blog' => 'blog');
 	}
 
 	
// 	public static function adminSettings(){
// 		
// 		$ddown = Pages::dropdownPages('blog');
// 		
// 		$html = "<ul>";
// 		$html .= "<li>";
// 		$html .= "<label>Blog Page</label>";
// 		
// 		$html .= $ddown;
// 		
// 		$html .= "</li>";
// 		$html .= "</ul>";
// 		
// 		return $html;
// 	}
// 	
// 	public static function saveSettings(){
// 	
// 	}
 	
 	public static function postsTable(){
 	
 		$posts = listBlogPosts();
 		
 		$html = '<table>';
 		$html .= '<thead><tr><th>Post Title</th><th></th><th></th></tr></thead>';
 		
 		foreach ($posts as $post) {
 			$html .= '<tr>';
 			$html .= '<td>'.$post->post_title.'</td>';
 			$html .= '<td><a href="dashboard.php?page=blog&edit='.$post->post_id.'" title="Edit Page">Edit</a></td>';
 			$html .= '<td><a href="dashboard.php?page=blog&delete='.$post->post_id.'" title="Delete Page">[x]</a></td>';
 			$html .= '</tr>';	
 		}
 		
 		$html .= '</table>';
 		
 		echo $html;
 		
 	}
 	
 	public static function addPost($post_title, $post_body){
 		
 		$dbh = new CandyDB();
 		$sth = $dbh->prepare('INSERT INTO '. DB_PREFIX .'posts (post_title, post_body) VALUES ("'. $post_title .'", "'. addslashes($post_body) .'")');
 		$sth->execute();	
 	
 	}
 
 	public static function editPost($post_title, $post_body, $pid){
 		
 		$dbh = new CandyDB();
 		$sth = $dbh->prepare('UPDATE '. DB_PREFIX .'posts SET post_title="'. $post_title .'", post_body="'. addslashes($post_body) .'" WHERE post_id="' . $pid . '"');
 		$sth->execute();	
 		
 	}
 	
 	public static function deletePost($id){
 		
 		$dbh = new CandyDB();
 		$sth = $dbh->prepare('DELETE FROM '. DB_PREFIX .'posts WHERE post_id="'. $id .'"');
 		$sth->execute();
 		
 	}
 	
 	public static function latestPost(){
 		
 		$dbh = new CandyDB();
 		$sth = $dbh->prepare('SELECT * FROM '. DB_PREFIX .'posts ORDER BY post_id DESC LIMIT 1');
 		$sth->execute();
 		
 		$array = $sth->fetchAll(PDO::FETCH_CLASS);
 		
 		$html = '';
 		foreach ($array as $value) {
 			$html .= "<h2><a href='news/{$value->post_id}'>{$value->post_title}</a></h2>";
 			$pieces = explode('.', $value->post_body);
 			$html .= $pieces[0].'&hellip;';
 		}
 		
 		return $html;
 	
 	}
 	
 	public static function addShorttag(){
 		$replace = self::latestPost();
 		return array('{{latestpost}}' => $replace);	
 	}
 	
 }
 
 /**
  * @returns array
  */
 
 function listBlogPosts(){
 	$dbh = new CandyDB();
 	$sth = $dbh->prepare('SELECT * FROM '. DB_PREFIX .'posts ORDER BY post_id DESC');
 	$sth->execute();
 	
 	return $sth->fetchAll(PDO::FETCH_CLASS);
 }
 
 /**
  * @returns array
  */
 
 function getBlogPost($id){
 	$dbh = new CandyDB();
 	$sth = $dbh->prepare('SELECT * FROM '. DB_PREFIX .'posts WHERE post_id = '. $id .'');
 	$sth->execute();
 	
 	return $sth->fetchAll(PDO::FETCH_CLASS);
 }