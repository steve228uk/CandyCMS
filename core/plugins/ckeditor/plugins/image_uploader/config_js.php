<?php
/**
 * Load configuration ini for ImageUploader plugin
 */ 
	 
	$lenght = strlen($_SERVER["DOCUMENT_ROOT"]);
	if($_SERVER["DOCUMENT_ROOT"][$lenght -1] == '/')
	{
		$server = substr($_SERVER["DOCUMENT_ROOT"], 0, $lenght -1);
	}
	else
	{
		$server = $_SERVER["DOCUMENT_ROOT"];
	}
	list($domain, $url) = explode($_SERVER["SERVER_NAME"], $_GET['link']);
	$config = parse_ini_file($server.$url.'plugins/image_uploader/ckeplugin.ini');
	
	?>
	var configPlugin = new Class({
		config_link:CKEDITOR.basePath,
		hide_advanced_panel:<?php if($config['hide_advanced_panel'] == true) echo 'true'; else echo 'false';?>,
		hide_link_panel:<?php if($config['hide_link_panel'] == true) echo 'true'; else echo 'false';?>,	
		
		all_action: '<?php if($config['json_action'] =='') echo $_GET['link'].'plugins/image_uploader/json_action.php'; else echo $config['json_action'];?>',
		server_main_dir: '<?php if(strlen($config['domain']) > 0) echo $config['domain'].'/'.$config['pictures']; else echo '/'.$config['pictures']; ?>',
		server_temp_dir: '<?php if($config['temp_dir'] == '') if(strlen($config['domain']) > 0) echo $config['domain'].'/'.$config['pictures']; else echo '/'.$config['pictures']; else if(strlen($config['domain']) > 0) echo $config['domain'].'/'.$config['temp_dir']; else echo '/'.$config['temp_dir']; ?>',
		
		use_fancy_uploader:<?php if($config['use_fancy_uploader'] == true) echo 'true'; else echo 'false';?>,
		fancy_uploader_z_index: <?php echo $config['fancy_uploader_z_index'];?>,
		uploader_swf: '/<?php echo $config['uploader_swf'];?>',
		file_size_max: <?php echo $config['max_file_size'];?>,
		verbose: false,
		appendCookieData: <?php if($config['appendCookieData'] == true) echo 'true'; else echo 'false';?>,
		fileListMax: <?php echo $config['fileListMax'];?>,
		typeFilter: '<?php echo $config['typeFilter'];?>',
		auto_config_fancy: <?php if($config['auto_locate_file'] == true) echo 'true'; else echo 'false';?>
		
	});
	
