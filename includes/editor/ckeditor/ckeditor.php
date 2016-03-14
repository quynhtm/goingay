<?php
 function getEditor($name,$content='',$width=0,$height=0,$config=array(),$events=array()){
	include_once ROOT_PATH.'includes/editor/ckeditor/ckeditor/ckeditor.php';
	$ckeditor = new CKEditor();
	$ckeditor->basePath = WEB_DIR.'includes/editor/ckeditor/ckeditor/';
	$ckeditor->config['filebrowserBrowseUrl'] = WEB_DIR.'includes/editor/ckeditor/ckfinder/ckfinder.html';

	$config['toolbar_Full'] =array(
		array('Source','-','Save','NewPage','DocProps','Preview','Print','-','Templates'),
		array('Cut','Copy','Paste','PasteText','PasteFromWord','-','Undo','Redo'),
		array('Find','Replace','-','SelectAll','-','SpellChecker', 'Scayt'),
		array('Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 'HiddenField'),
		array('Bold','Italic','Underline','Strike','Subscript','Superscript','-','RemoveFormat'),
		array('NumberedList','BulletedList','-','Outdent','Indent','-','Blockquote','CreateDiv','-','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock','-','BidiLtr','BidiRtl'),
		array('Link','Unlink','Anchor'),
		array('Image','Flash','MediaEmbed','Table','HorizontalRule','Smiley','SpecialChar','PageBreak','Iframe'),
		array('Styles','Format','Font','FontSize','TextColor','BGColor'),
		array('Maximize', 'ShowBlocks','-','About'),
	);
	//Default
	$config["resize_dir"]='vertical';
	if($width){
		$config["width"]=$width;
	}
 	if($height){
		$config["height"]=$height;
	}
	ob_start();
	$ckeditor->editor($name,$content,$config,$events);
	$displayEditor=ob_get_contents();
	ob_end_clean();
	return $displayEditor;
 	
 }
 ?>