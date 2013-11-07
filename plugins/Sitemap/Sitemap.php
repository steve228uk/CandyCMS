<?

/**
 * @plugin XML Sitemap
 * @author Cocoon Design
 * @authorURI http://www.wearecocoon.co.uk/
 * @description Generates XML Sitemap whenever a page on the site is viewed to keep it up to date without the need for a cron
 * @copyright 2012 (C) Cocoon Design  
 */
 
 class Sitemap {
 
 }
 
$uri = $_SERVER['REQUEST_URI'];

if (!stristr($uri, 'cms-admin')) {

	$pages = Candy::Pages()->listPages();
	$homepage = Candy::Options('homepage');
	$url = Candy::Options('site_url');

	$sitemap = '<?xml version="1.0" encoding="UTF-8" ?>';
	$sitemap .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">';

	foreach ($pages as $page) {
		$sitemap .= '<url>';
		
		if ($page->rewrite == $homepage) {
			$sitemap .= "<loc>$url</loc>";	
			$sitemap .= "<changefreq>daily</changefreq>";
			$sitemap .= "<priority>1</priority>";
		} else{
			$sitemap .= "<loc>$url{$page->rewrite}</loc>";	
			$sitemap .= "<changefreq>daily</changefreq>";
			$sitemap .= "<priority>0.8</priority>";
		}
		
		$sitemap .= '</url>';
	}

	$sitemap .= '</urlset>';			

	# Write the sitemap to sitemap file!

	$fp = fopen(CMS_PATH.'sitemap.xml', 'w');
	fwrite($fp, $sitemap);
	fclose($fp);

}