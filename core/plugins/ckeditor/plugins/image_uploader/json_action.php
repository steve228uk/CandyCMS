<?php
/**
 * Main plugin PHP script file. 
 */
	$config = parse_ini_file("ckeplugin.ini");	
	include_once("php/resizeimage.php");
	include_once("php/dirTree.php");
	
	// Main variables initialization
	@ini_set('memory_limit', $config['max_file_size'].'M');
	@ini_set('post_max_size', $config['max_file_size'].'M');
	@ini_set('upload_max_filesize', $config['max_file_size'].'M');
	
	// Read destination folder from configuration
	$config['public'] = $config['root'];
	if($config['public'] == '')
	{
		$lenght = strlen($_SERVER["DOCUMENT_ROOT"]);
		if($_SERVER["DOCUMENT_ROOT"][$lenght -1] != '/')
		{
			$config['public'] = $_SERVER["DOCUMENT_ROOT"].'/';
		
		}
		else
		{
			$config['public'] = $_SERVER["DOCUMENT_ROOT"];

		}
	}
	else
	{
		$lenght = strlen($_SERVER["DOCUMENT_ROOT"]);
		if($_SERVER["DOCUMENT_ROOT"][$lenght -1] != '/')
		{

			$config['public'] = $_SERVER["DOCUMENT_ROOT"].$config['root'];
		}
		else
		{
				die('b');
			$config['public'] = $_SERVER["DOCUMENT_ROOT"].'/'.$config['root'] .'/';
		}
	}
	if($config['temp_dir'] =='')
	{
		$config['temp_dir'] = $config['pictures'];
	}
	
	$config['pictures'] .='/';
	$config['temp_dir'] .='/.temp_pic/';
	
	// Read selected plugin action
	$action = $_GET['action'];
	
	switch ($action) {
		case 'edit': include('php/editAction.php'); break; // Edit file properties
		case 'list_action': include('php/listAction.php'); break; // Generate list of files in directory
		case 'dir_list': include('php/dirlistAction.php'); break; // Generate directories list
		case 'del': include('php/delAction.php'); break; // Delete file
		case 'update': include('php/updateAction.php'); break; // Update file
		case 'add': include('php/addAction.php'); break; // Add new files using standard methods
		case 'addhtml5': include('php/addhtml5Action.php'); break; // Add new files using HTML 5 drag & drop efect
	}
	
?>