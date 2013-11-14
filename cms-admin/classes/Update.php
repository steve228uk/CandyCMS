<?
/**
* @package CandyCMS
* @version 0.5.3
* @since 0.3
* @copyright Copyright 2012 (C) Cocoon Design Ltd. - All Rights Reserved
* 
* Update class for CandyCMS
*/

class Update {

    private static function xml(){

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'http://api.candycms.org/get/core/');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        curl_close($ch);

        $xml = simplexml_load_string($output);

        return $xml;
    }

    public static function checkUpdate(){

        $xml = self::xml();
        $curver = CANDYVERSION;

        foreach ($xml->channel->item as $item) {
            $newver = $item->version;

            if(version_compare($curver, $newver, '>=')){
                $return = false;
            } else {
                $return = "<p class='message notice update'>CandyCMS v$newver is available, you have v$curver. <a href='dashboard.php?page=update'>Learn More</a></p>";
                break;
            }
        }

        return $return;
    }
	
	public static function getChangelog(){
		
		$xml = self::xml();
		
		$curver = CANDYVERSION;
		
		foreach ($xml->channel->item as $item) {
			$newver = $item->version;
			
			if(!version_compare($curver, $newver, '>=')){
				$version = 'CandyCMS v'.$item->version; 
				$changelog = $item->changelog;
				$updateurl = $item->updateurl;
				$downloadurl = $item->downloadurl;
				break;
			}
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
		
		$curver = CANDYVERSION;
		
		foreach ($xml->channel->item as $item) {
			$newver = $item->version;
			
			if(version_compare($curver, $newver, '>=')){
				$return = false;
			} else {
				$return = $item->updateurl;
				break;
			}
		}
		
		return $return;
		
	}

}

?>