<?php

/**
* @package CandyCMS
* @version 0.7
* @since 0.1
* @copyright Copyright 2012 (C) Cocoon Design Ltd. - All Rights Reserved
* 
* The main functions file, contains the biggies!
*/


function candytitle($separator = '|'){
	global $Candy;
	$title = $Candy['options']->getOption('site_title');
	
	$page = (isset($_GET['page'])) ? $_GET['page'] : $Candy['options']->getOption('homepage');
	
	$page_title = $Candy['pages']->getInfo('page_title', $page);
	
	if (isset($_GET['post']) && $_GET['post'] != '') {
		echo $title, ' ', $separator, ' ', $page_title, ' ', $separator, ' ', ucwords(str_replace('-', ' ', $_GET['post']));
	} else {
		echo $title, ' ', $separator, ' ', $page_title;
	}
}

function candyHead(){
	$plugins = Plugins::enabledPlugins();
	$return = '';
	foreach ($plugins as $plugin) {
		if (method_exists($plugin, 'candyHead')) {
			$return .= $plugin::candyHead();
		}
	}
	echo $return;
}

function theContent(){
	global $Candy;
	$page = (isset($_GET['page'])) ? $_GET['page'] : $Candy['options']->getOption('homepage');
	$content =  $Candy['pages']->getInfo('page_body', $page);	
	
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
	global $Candy;
	$page = (isset($_GET['page'])) ? $_GET['page'] : $Candy['options']->getOption('homepage');
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
	$page = (isset($_GET['page'])) ? $_GET['page'] : $Candy['options']->getOption('homepage');
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
	$page = (isset($_GET['page'])) ? $_GET['page'] : $Candy['options']->getOption('homepage');
	echo $Candy['pages']->getInfo('page_title', $page);
}

function theNav($class = 'nav'){
	global $Candy;
	$html = '<ul class="'. $class .'">';
	$pages = Pages::listPages();
	$path = URL_PATH;

	$curpage = (isset($_GET['page'])) ? $_GET['page'] : $Candy['options']->getOption('homepage');
	$info = $Candy['pages']->loadPage($curpage);
	$homepage = $Candy['options']->getOption('homepage');
	
	foreach ($pages as $page) {
		if (!empty($info)) {
			$html .= ($page->page_id == $info[0]->page_id) ? '<li class="active-page">' : '<li>';	
		} else {
			$html .= '<li>';
		}
		
		$html .= ($homepage == $page->rewrite) ? '<a href="'. $path .'" title="'.$page->page_title.'">'. $page->page_title .'</a>' : '<a href="'. $path . $page->rewrite .'">'. $page->page_title .'</a>';
	
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
	global $Candy;
	$theme = $Candy['options']->getOption('theme');
	echo '<link rel="stylesheet" href="'.THEME_URL.$theme.'/css/'.$filename.'" type="text/css" />';
}

function candyScript($filename){
	global $Candy;
	$theme = $Candy['options']->getOption('theme');
	echo '<script type="text/javascript" src="'.THEME_URL.$theme.'/js/'.$filename.'"></script>';
}

function candyImg($filename, $alt){
	global $Candy;
	$theme = $Candy['options']->getOption('theme');
	echo '<img src="'.THEME_URL.$theme.'/images/'.$filename.'" alt="'.$alt.'" />';
}
