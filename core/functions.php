<?php

/**
* @package CandyCMS
* @version 0.5.3
* @since 0.1
* @copyright Copyright 2012 (C) Cocoon Design Ltd. - All Rights Reserved
* 
* The main functions file, contains the biggies!
*/

function candytitle($separator = '|'){
	$title = Options::candytitle();
	$page = (isset($_GET['page'])) ? $_GET['page'] : Options::homePage();
	
	if (isset($_GET['post']) && $_GET['post'] != '') {
		
		echo $title, ' ', $separator, ' ', Pages::pageTitle($page), ' ', $separator, ' ', ucwords($_GET['post']);
		
	} else {
	
		echo $title, ' ', $separator, ' ', Pages::pageTitle($page);
	
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
	$page = (isset($_GET['page'])) ? $_GET['page'] : Options::homePage();
	echo Pages::theContent($page);	
}

function theTitle(){
	$page = (isset($_GET['page'])) ? $_GET['page'] : Options::homePage();
	echo Pages::theTitle($page);	
}

function theNav($class = 'nav'){
	$html = '<ul class="'. $class .'">';
	$pages = Pages::listPages();
	$path = URL_PATH;

	$curpage = (isset($_GET['page'])) ? $_GET['page'] : Options::homePage();
	$info = Pages::loadPage($curpage);
	$homepage = Options::homePage();
	
	foreach ($pages as $page) {
		if (!empty($info)) {
			$html .= ($page->page_id == $info[0]['page_id']) ? '<li class="active-page">' : '<li>';	
		} else {
			$html .= '<li>';
		}
		
		$html .= ($homepage == $page->rewrite) ? '<a href="'. $path .'">'. $page->page_title .'</a>' : '<a href="'. $path . $page->rewrite .'">'. $page->page_title .'</a>';
	

		$html .= '</li>';
	}
	
	$html .= '<li><a class="open-contact" href="javascript:void(0);">Contact</a></li>';
	
	$html .= '</ul>';
	echo $html;
}

function cmsPage($title, $page){
	$path = URL_PATH;
	echo '<a href="'. $page .'" title="'. $title .'">'. $title .'</a>';	
}

function candyCss($filename){
	$theme = Options::currentTheme();
	echo '<link rel="stylesheet" href="'.THEME_URL.$theme.'/css/'.$filename.'" type="text/css" />';
}

function candyScript($filename){
	$theme = Options::currentTheme();
	echo '<script type="text/javascript" src="'.THEME_URL.$theme.'/js/'.$filename.'"></script>';
}

function candyImg($filename, $alt){
	$theme = Options::currentTheme();
	echo '<img src="'.THEME_URL.$theme.'/images/'.$filename.'" alt="'.$alt.'" />';
}