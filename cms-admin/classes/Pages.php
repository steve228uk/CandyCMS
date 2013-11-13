<?

/**
* @package CandyCMS
* @version 1.0
* @since 0.1
* @copyright Copyright 2012 (C) Cocoon Design Ltd. - All Rights Reserved
* 
* Methods for editing pages in the admin panel
*/

class Pages {
	
	public static function listPages(){
	
		return CandyDB::results('SELECT * FROM '. DB_PREFIX .'pages');
		
	}
	
	public static function inNav(){
	
		return CandyDB::results('SELECT * FROM '. DB_PREFIX .'pages WHERE innav = 1 ORDER BY navpos');
		
	}
	
	public static function sortPages(){
		
		$pages = Candy::Options('nav');
		$order = json_decode($pages);  // Holy bajeesus, what in the living hell is this?

		$html = '<ol>';
		
		foreach ($order as $page) {
			
			$title = CandyDB::val('SELECT page_title FROM '. DB_PREFIX .'pages WHERE page_id = :page_id', array('page_id' => $page->id));
		
			$html .= "<li class='dd-item' data-id='{$page->id}'><div class='dd-handle'>{$title}<button class='icon-remove rm-nav right' value='{$page->id}'></button></div>";
			
				if (isset($page->children)) {
					$html .= '<ol>';
					foreach ($page->children as $child) {

						$title = CandyDB::val('SELECT page_title FROM '. DB_PREFIX .'pages WHERE page_id = :page_id', array('page_id' => $child->id));

						$html .= "<li class='dd-item' data-id='{$child->id}'> <div class='dd-handle'>{$title}<button class='icon-remove rm-nav right' value='{$child->id}'></button></div>";
						
							if (isset($child->children)) {
								$html .= '<ol>';
								foreach ($child->children as $grandchild) {
									$title = CandyDB::val('SELECT page_title FROM '. DB_PREFIX .'pages WHERE page_id = :page_id', array('page_id' => $grandchild->id));

									$html .= "<li class='dd-item' data-id='{$grandchild->id}'> <div class='dd-handle'>{$title}<button class='icon-remove rm-nav right' value='{$grandchild->id}'></button></div></li>";
								}
								$html .= '</ol>';
							}
						
						$html .= "</li>";
					}
					$html .= '</ol>';
				}
			
			$html .= "</li>";
		}
		
		$html .= '</ol>';
		
		echo $html;
	}

	public static function saveNav($nav){
		
		$decode = json_decode($nav);
		
		// Candy::Options()->set('nav', $nav);

		CandyDB::q('UPDATE '.DB_PREFIX.'options SET option_value = :value WHERE option_key = :key', array('value' => $nav, 'key' => 'nav'));

	}
	
	public static function dropdownPages($name = "pages", $selected = false){
		
		$pages = self::listPages();
		
		$html = "<select name='$name'>";
		
		foreach ($pages as $page) {
			$html .= ($selected == $page->rewrite) ? "<option value='{$page->rewrite}' selected='selected'>" : "<option value='{$page->rewrite}'>";
			$html .= $page->page_title;
			$html .= '</option>';
		}
		
		$html .= "</select>";
		
		echo $html;
		
	}

	public static function pagesTable(){
		
		$pages = self::listPages();
		
		$html = '<table>';
		$html .= '<thead><tr><th>Page Title</th><th></th><th></th></tr></thead>';
		
		foreach ($pages as $page) {
			$html .= '<tr>';
			$html .= '<td>'.$page->page_title.'</td>';
			$html .= '<td width="20"><a href="dashboard.php?page=pages&edit='.$page->page_id.'" title="Edit Page"><i class="fa fa-pencil-square-o"></i></a></td>';
			$html .= '<td width="20"><a class="delete" href="dashboard.php?page=pages&delete='.$page->page_id.'" title="'.$page->page_title.'"><i class="fa fa-trash-o"></i></a></td>';
			$html .= '</tr>';	
		}
		
		$html .= '</table>';
		
		echo $html;
		
	}
	
	public static function pageInfo($page){
		
		return CandyDB::results('SELECT * FROM '. DB_PREFIX .'pages WHERE page_id = :page', compact('page'));
		
	}
	
	public static function updatePage($title, $body, $rewrite, $template, $innav, $id, $cfields = false){

		$innav = ($innav == 'on') ? 1 : 0;

		$dbh = new CandyDB();

		$sth = $dbh->prepare('UPDATE '. DB_PREFIX .'pages SET page_title="'. $title .'", page_body="'. addslashes($body) .'", page_template="'. $template .'", rewrite="'. $rewrite .'" WHERE page_id="' . $id . '"');
		$sth->execute();

		if (isset($_POST['cf-update'])) {
			foreach ($_POST['cf-update'] as $key => $value) {

				$value = addslashes($value);

				$sth = $dbh->prepare("UPDATE ".DB_PREFIX."fields SET field_value='$value' WHERE field_name='$key' AND post_id='$id'");
				$sth->execute();

			}
		}


		// Insert the custom fields
		if ($cfields != false) {
			foreach ($cfields as $key => $value) {

				$data = addslashes($_POST['cf-update'][$key]);

				$title = addslashes($_POST['cf-title'][$key]);

				$desc = addslashes($_POST['cf-desc'][$key]);

				$sth = $dbh->prepare("INSERT INTO ".DB_PREFIX."fields (post_id, field_name, field_type, field_value, field_title, field_desc) VALUES ($id, '$key', '$value', '$data', '$title', '$desc')");
				$sth->execute();

			}
		}

	}

	public static function addPage($title, $body, $template, $rewrite, $innav, $cfields = false){

		$innav = ($innav == 'on') ? 1 : 0;

		// Insert the post
		$dbh = new CandyDB();
		$sth = $dbh->prepare('INSERT INTO '. DB_PREFIX .'pages (page_title, page_body, page_template, rewrite) VALUES ("'. $title .'", "'. addslashes($body) .'", "'. $template .'", "'. $rewrite .'")');
		$sth->execute();	

		// Get the last inserted ID

		$sth = $dbh->prepare("SELECT page_id FROM ".DB_PREFIX."pages WHERE page_title='$title' AND rewrite='$rewrite' AND page_template='$template'");
		$sth->execute();
		$id = $sth->fetchColumn();

		// Insert the custom fields
		if ($cfields != false) {
			foreach ($cfields as $key => $value) {

				$data = addslashes($_POST['cf-update'][$key]);

				$title = addslashes($_POST['cf-title'][$key]);

				$desc = addslashes($_POST['cf-desc'][$key]);

				$sth = $dbh->prepare("INSERT INTO ".DB_PREFIX."fields (post_id, field_name, field_type, field_value, field_title, field_desc) VALUES ($id, '$key', '$value', '$data', '$title', '$desc')");
				$sth->execute();

			}
		}

	}
		
	public static function deletePage($id){
		
		CandyDB::q('DELETE FROM ' . DB_PREFIX . 'pages WHERE page_id = :id', compact('id'));
		
	}
	
	public static function listAddPages(){
		$pages = self::listPages();
		$html = '<ul class="add-pages-ul">';
		foreach ($pages as $key => $value) {
			$html .= '<li><label for="navpage-'.$value->page_id.'">'.$value->page_title.'</label><input type="checkbox" id="navpage-'.$value->page_id.'" value="'.$value->page_id.'" /></li>';
		}
		$html .= '</ul>';
		echo $html;
	}
	
}