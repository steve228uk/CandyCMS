<?php
/**
* @package CandyCMS
* @version 0.1
* @copyright Copyright 2012 (C) Cocoon Design Ltd. - All Rights Reserved
* 
* Update class for CandyCMS
*/

class Update {

	private static function xml(){
		$xml = simplexml_load_file('http://www.jquerycandy.com/update.xml'); 
		return $xml;
	}

	public static function checkUpdate(){
		
		$xml = self::xml();
		$curver = CANDYVERSION;
		
		foreach ($xml as $xml) {
			$newver = $xml->item->version;
		}
				
		if(version_compare($curver, $newver, '>=')){
			return false;
		} else {
			return "<p class='message notice update'>CandyCMS v$newver is available, you have v$curver. <a href='dashboard.php?page=update'>Learn More</a></p>";
		}
				
	}
	
	public static function getChangelog(){
		
		$xml = self::xml();
		
		foreach ($xml as $xml) {
			$version = 'CandyCMS v'.$xml->item->version; 
			$changelog = $xml->item->changelog;
			$updateurl = $xml->item->updateurl;
			$downloadurl = $xml->item->downloadurl;
		}
		
		if (self::checkUpdate() == false) {
			echo '<p class="leadin">CandyCMS is up to date!</p>';
		} else {
			echo "<h3>$version</h3>";
			echo '<p class="leadin">This update includes the following:</p>';
			echo $changelog;
			echo "<a href='$downloadurl' class='button dl-btn'>Download from Github</a>";
			echo "<a href='dashboard.php?page=update&update' class='button'>Update Automatically</a>";
		}
		
	}
	
	public static function updateUrl(){
	
		$xml = self::xml();
		
		foreach ($xml as $xml) {
			$updateurl = $xml->item->updateurl;
		}
		
		return $updateurl;
		
	}

}

?>