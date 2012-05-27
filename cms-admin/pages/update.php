<?php

/**
* @package CandyCMS
* @version 0.5
* @since 0.3
* @copyright Copyright 2012 (C) Cocoon Design Ltd. - All Rights Reserved
* 
* Update page for CandyCMS
*/

?>

<?php if (isset($_GET['update'])) : ?>
	
	<h1>Updating CandyCMS</h1>
	
	<?php
	
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


<?php else : ?>

	<h1>Update CandyCMS</h1>
	<?php Update::getChangelog() ?>

<?php endif; ?>