<?php

/**
 * @plugin Blog
 * @description A simple blog for CandyCMS. Use {{blog}}
 * @author Cocoon Design
 * @authorURI http://www.wearecocoon.co.uk/
 * @copyright 2012 (C) Cocoon Design  
 * @version 0.5
 * @since 0.1
 */
 
 class Blog {
 
 	public static function install() {
 		
 		$dbh = new CandyDB();
 		$dbh->exec("CREATE TABLE IF NOT EXISTS ". DB_PREFIX ."posts (post_id INT(11) NOT NULL AUTO_INCREMENT, PRIMARY KEY(post_id), post_title VARCHAR(64) NOT NULL, post_body TEXT NOT NULL, post_date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP)");
 		
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
 	
 		echo $_SERVER['REQUEST_URI'].'/'.str_replace(' ', '-', strtolower($title));
 	
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