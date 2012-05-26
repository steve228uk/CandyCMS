/*
Copyright (c) 2003-2011, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license
*/

CKEDITOR.editorConfig = function( config )
{
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
	
	// This is actually the default value.
	config.toolbar_Full =
	[
	    { name: 'document',    items : [ 'Source','-','Save','NewPage','DocProps','Preview','Print','-','Templates' ] },
	    { name: 'clipboard',   items : [ 'Cut','Copy','Paste','PasteText','PasteFromWord','-','Undo','Redo' ] },
	    { name: 'editing',     items : [ 'Find','Replace','-','SelectAll','-','SpellChecker', 'Scayt' ] },
	    '/',
	    { name: 'basicstyles', items : [ 'Bold','Italic','Underline','Strike','Subscript','Superscript','-','RemoveFormat' ] },
	    { name: 'paragraph',   items : [ 'NumberedList','BulletedList','-','Outdent','Indent','-','Blockquote','CreateDiv','-','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock','-','BidiLtr','BidiRtl' ] },
	    { name: 'links',       items : [ 'Link','Unlink','Anchor' ] },
	    { name: 'insert',      items : [ 'Image','Flash','Table'] },
	    '/',
	    { name: 'styles',      items : [ 'Styles','Format','Font','FontSize' ] },
	    { name: 'colors',      items : [ 'TextColor','BGColor' ] },
	    { name: 'tools',       items : [ 'Maximize', 'ShowBlocks','-','About' ] }
	];
	
	CKEDITOR.scriptLoader.load( CKEDITOR.basePath + 'plugins/image_uploader/plugin.js' );
	
	//config.filebrowserUploadUrl = CKEDITOR.basePath + 'ckupload.php';
	
};
