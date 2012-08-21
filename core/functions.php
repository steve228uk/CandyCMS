<?php

/**
* @package CandyCMS
* @version 0.7.4
* @since 0.1
* @copyright Copyright 2012 (C) Cocoon Design Ltd. - All Rights Reserved
* 
* The main functions file, contains the biggies!
*/


function candytitle($separator = '|'){
	$title = CandyCMS::Options('site_title');
	
	$page = (isset($_GET['page'])) ? $_GET['page'] : CandyCMS::Options('homepage');
	
	$page_title = CandyCMS::Pages()->getInfo('page_title', $page);
	
	if (isset($_GET['post']) && $_GET['post'] != '') {

		$postTitle = Blog::getPostTitle($_GET['post']);

		echo $title, ' ', $separator, ' ', $page_title, ' ', $separator, ' ', $postTitle;
	} else {
		echo $title, ' ', $separator, ' ', $page_title;
	}
}

function candyHead(){
	$plugins = Plugins::enabledPlugins();
	$return = '';
	foreach ($plugins as $plugin) {
		if (method_exists($plugin, 'candyHead')) {
			$return .= $plugin::candyHead()."\n";
		}
	}
	$return .= '<meta name="generator" content="Candy '.CANDYVERSION.'" />'."\n";
	echo $return;
}

function theContent(){
	$page = (isset($_GET['page'])) ? $_GET['page'] : CandyCMS::Options('homepage');
	$content = CandyCMS::Pages()->getInfo('page_body', $page);
	
	$plugins = Plugins::enabledPlugins();
	
	foreach ($plugins as $plugin) {
		
		if (method_exists($plugin, 'addShorttag')) {
			$replace = $plugin::addShorttag();
			
			foreach ($replace as $key => $value) {
				$content = str_replace($key, $value, $content);	
			}
			
		}
		
	}
	
	echo $content;
	
}

function theField($field){
	$page = (isset($_GET['page'])) ? $_GET['page'] : CandyCMS::Options('homepage');
	$id = $Candy['pages']->getInfo('page_id', $page);
	
	$dbh = new CandyDB();
	$sth = $dbh->prepare("SELECT field_value FROM ".DB_PREFIX."fields WHERE field_name='$field' AND post_id=$id");
	$sth->execute();
	
	$content = $sth->fetchColumn();
	
	$plugins = Plugins::enabledPlugins();
	
	foreach ($plugins as $plugin) {
		
		if (method_exists($plugin, 'addShorttag')) {
			$replace = $plugin::addShorttag();
			
			foreach ($replace as $key => $value) {
				$content = str_replace($key, $value, $content);	
			}
			
		}
		
	}
	
	echo $content;
	
}

function getField($field){
	global $Candy;
	$page = (isset($_GET['page'])) ? $_GET['page'] : CandyCMS::Options('homepage');
	$id = $Candy['pages']->getInfo('page_id', $page);
	
	$dbh = new CandyDB();
	$sth = $dbh->prepare("SELECT field_value FROM ".DB_PREFIX."fields WHERE field_name='$field' AND post_id=$id");
	$sth->execute();
	
	$content = $sth->fetchColumn();	
	
	$plugins = Plugins::enabledPlugins();
	
	foreach ($plugins as $plugin) {
		
		if (method_exists($plugin, 'addShorttag')) {
			$replace = $plugin::addShorttag();
			
			foreach ($replace as $key => $value) {
				$content = str_replace($key, $value, $content);	
			}
			
		}
		
	}
	
	return $content;
}

function theTitle(){
	global $Candy;
	$page = (isset($_GET['page'])) ? $_GET['page'] : CandyCMS::Options('homepage');
	echo CandyCMS::Pages()->getInfo('page_title', $page);
}

function theNav($class = 'nav', $active = 'active-page'){
	global $Candy;
	
	$html = '<ul class="'. $class .'">';
	$pages = CandyCMS::Options('nav');
	
	$pages = json_decode($pages);
	
	$path = URL_PATH;

	$curpage = (isset($_GET['page'])) ? $_GET['page'] : CandyCMS::Options('homepage');
	$info = CandyCMS::Pages()->loadPage($curpage);
	$homepage = CandyCMS::Options('homepage');
	
	foreach ($pages as $page) {
		
		$dbh = new CandyDB();
		$sth = $dbh->prepare('SELECT page_title, rewrite FROM '. DB_PREFIX .'pages WHERE page_id = '.$page->id);
		$sth->execute();
		
		$pages_info = $sth->fetchAll(PDO::FETCH_CLASS); 
	
	
		if (!empty($info)) {
			$html .= ($page->id == $info[0]->page_id) ? '<li class="'.$active.'">' : '<li>';	
		} else {
			$html .= '<li>';
		}
		
		$html .= ($homepage == $pages_info[0]->rewrite) ? '<a href="'. $path .'" title="'.$pages_info[0]->page_title.'">'. $pages_info[0]->page_title .'</a>' : '<a href="'. $path . $pages_info[0]->rewrite .'">'. $pages_info[0]->page_title .'</a>';
		
		
		if (isset($page->children)) {
			$html .= '<ul class="candy-dropdown">';
			foreach ($page->children as $child) {
				
				$sth = $dbh->prepare('SELECT page_title, rewrite FROM '. DB_PREFIX .'pages WHERE page_id = '.$child->id);
				$sth->execute();
				
				$child_info = $sth->fetchAll(PDO::FETCH_CLASS); 
				
				$html .= '<li>';
				$html .= '<a href="'. $path . $child_info[0]->rewrite .'">'. $child_info[0]->page_title .'</a>';
				$html .= '</li>';	
			}
			$html .= '</ul>';
		}
		

		$html .= '</li>';
	}
	
	$html .= '</ul>';
	echo $html;
}

function cmsPage($title, $page, $class=false){
	$path = URL_PATH;
	if ($class == false) {
		echo '<a href="'.$path. $page .'" title="'. $title .'">'. $title .'</a>';	
	} else {
		echo '<a href="'.$path. $page .'" title="'. $title .'" class="'.$class.'">'. $title .'</a>';
	}	
}

function candyCss($filename){
	$theme = CandyCMS::Options('theme');
	echo '<link rel="stylesheet" href="'.THEME_URL.$theme.'/css/'.$filename.'" type="text/css" />';
}

function candyScript($filename){
	$theme = CandyCMS::Options('theme');
	echo '<script type="text/javascript" src="'.THEME_URL.$theme.'/js/'.$filename.'"></script>';
}

function candyImg($filename, $alt){
	$theme = CandyCMS::Options('theme');
	echo '<img src="'.THEME_URL.$theme.'/images/'.$filename.'" alt="'.$alt.'" />';
}
