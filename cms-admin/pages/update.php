<?

/**
* @package CandyCMS
* @version 0.7
* @since 0.5
* @copyright Copyright 2012 (C) Cocoon Design Ltd. - All Rights Reserved
* 
* Update page for CandyCMS
*/

?>

<? if (isset($_GET['update'])) : ?>
	
	<div id="title-bar">
		
		<div id="title-bar-cont">
		
			<h1 class="left">Updating Candy&hellip;</h1>
			
		</div>
	
	</div>
	
	<div id="container">
	
	<?
	
		if (Update::checkUpdate() == false) {
			echo '<p class="leadin">CandyCMS is up to date!</p>';
		} else {
	
			$client = curl_init(Update::updateUrl());
			curl_setopt($client, CURLOPT_RETURNTRANSFER, 1);  //fixed this line
			$filedata = curl_exec($client);
			file_put_contents(CMS_PATH.'update.zip', $filedata);
			
			if (file_exists(CMS_PATH.'update.zip')) {
				echo '<p class="leadin">File downloaded!</p>';
			}
			
			$zip = new ZipArchive;
			
			if ($zip->open(CMS_PATH.'update.zip') === TRUE) {
			    $zip->extractTo(CMS_PATH);
			    $zip->close();
			    include CMS_PATH.'update/updater.php';
			} else {
			    echo 'Something Went Wrong!';
			}
			
		}
	
	?>
	
	</div>
	
<? else : ?>

	<div id="title-bar">
		
		<div id="title-bar-cont">
		
			<h1 class="left">Update Candy</h1>
			
		</div>
	
	</div>
	
	<div id="container">
	<? Update::getChangelog() ?>
	</div>

<? endif; ?>