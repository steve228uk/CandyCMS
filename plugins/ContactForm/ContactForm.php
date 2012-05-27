<?php
/**
 * @plugin Contact Form
 * @author Cocoon Design
 * @authorURI http://www.wearecocoon.co.uk/
 * @description Use {{contactform}} in the wysiwig
 * @copyright 2012 (C) Cocoon Design  
 */
 
 class ContactForm {
 
 	public static function install(){
 		$dbh = new CandyDB();
 		$dbh->exec("INSERT INTO ". DB_PREFIX ."options (option_key, option_value) VALUES ('contactformto', 'theteam@wearecocoon.co.uk')");
 	}
 	
 	public static function getContactFormTo(){
 		$dbh = new CandyDB();
 		$sth = $dbh->prepare('SELECT option_value FROM '. DB_PREFIX .'options WHERE option_key = "contactformto"');
 		$sth->execute();
 		
 		return $sth->fetchColumn();
 	}
 	
 	public static function candyHead() {
 		$js = PLUGIN_URL.'ContactForm/js/ajax.js';
 		
 		$url = PLUGIN_URL.'ContactForm/mailer.php';
 		
 		$html = "<script> var cfurl='$url'</script>";
 		$html .= "<script type='text/javascript' src='$js'></script>";
 		return $html;
 	}
 	
 	public static function addShorttag(){
 		$replace = file_get_contents(PLUGIN_PATH.'ContactForm/htmlform.php');
 		return array('{{contactform}}' => $replace);	
 	}
 	
 	public static function adminSettings(){
 		
 		$html = "<ul>";
 		$html .= "<li>";
 		$html .= "<label>Contact Form To</label>";
 		
 		$html .= "<input type='text' name='contactformto' value='". self::getContactFormTo() ."'/>";
 		
 		$html .= "</li>";
 		$html .= "</ul>";
 		
 		return $html;
 		
 	}
 	
 	public static function saveSettings(){
 		$email = $_POST['contactformto'];
 		
 		$dbh = new CandyDB();
 		$dbh->exec('UPDATE '. DB_PREFIX .'options SET option_value="'. $email .'" WHERE option_key="contactformto"');
 		
 	}
 
 }