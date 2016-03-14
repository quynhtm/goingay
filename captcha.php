<?php
require_once './core/config.php';//System Config...
require_once ROOT_PATH.'core/CGlobal.php';
require_once ROOT_PATH.'core/DB.php';

if(SESSION_TYPE == 'db'){
	//Session db store
	require_once ROOT_PATH.'includes/session.class.php';
}
elseif(SESSION_TYPE == 'memcache'){
	//Session memcache store
	require_once(ROOT_PATH."includes/memcache.session.php");	
}
else{		
	session_start(); 
}
global $in_img;
$in_img = 1;
$im = ImageCreate(50, 20);  
$white = ImageColorAllocate($im, 255, 255, 255); 
$black = ImageColorAllocate($im, 0, 0, 0); 

$alphanum		= "abcdefghikmopqrstuvwxyz023456789"; //bo so 1 va chu l vi nhin gan giong nhau
$new_string	= substr(str_shuffle($alphanum), 0, 3);

header("Content-type: image/png");
ImageFill($im, 0, 0, $black);
ImageString($im, 5, 12, 2, $new_string, $white); 
$_SESSION["enbac_validate"] = $new_string;

ImagePNG($im); 
ImageDestroy($im); 
?>