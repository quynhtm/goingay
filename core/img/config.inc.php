<?php
@ini_set ('zend.ze1_compatibility_mode','off');
@putenv("Asia/Saigon");
@date_default_timezone_set('Asia/Bangkok');

// trên sever thi bat no lên
/*$_temp_root = $_SERVER['DOCUMENT_ROOT'];
if(substr($_temp_root, -1) == '/') {
	define('ROOT', $_temp_root.'website/');
}
else {
	define('ROOT', $_temp_root.'/website/');
}
unset($_temp_root);*/

/*$_temp_root = $_SERVER['DOCUMENT_ROOT'];
if(substr($_temp_root, -1) == '/') {
	define('ROOT', $_temp_root.'/');
}
else {
	define('ROOT', $_temp_root.'/');
}
unset($_temp_root);*/

//error code
define('IMAGE_NO_ERROR',-1);
define('IMAGE_ERROR',0);
define('IMAGE_INVALID_WIDTH',1);
define('IMAGE_INVALID_HEIGHT',2);
define('IMAGE_INVALID_CAPACITY',3);
define('IMAGE_SQL_ERROR',4);
define('IMAGE_UPLOAD_ERROR',5);

//sql connect
require_once('mySQL.class.php');

//localhost
define('DB_HOST','localhost');
define('DB_USER','root');
define('DB_PASS','');
define('DB_NAME','namdalat');

//Sever chay
/*define('DB_HOST','localhost');
define('DB_USER','nguyenan');
define('DB_PASS','aprg3954mnvq');
define('DB_NAME','nguyenan_shop');*/

/*define('DB_HOST','localhost');
define('DB_USER','minhnv_savevn');
define('DB_PASS','OjKWJUVF4A8');
define('DB_NAME','minhnv_savevn');*/

//connect db
$sql = new mySQL(DB_HOST, DB_USER, DB_PASS, DB_NAME);

//image config && function
define('TEMP_FOLDER', 'tmp/');
define('MAX_ITEM_FOLDER', 1000);
define('MAX_FOLDER_FOLDER', 100);

//image product
define("IMAGE_MIN_WIDTH", 350);
define("IMAGE_MIN_HEIGHT", 350);
define("IMAGE_CAPACITY", 3145728); //3145728 bytes = 3MB

$product_image_sizes = array(
	40  => array('width' => 40,   'height' => 40),
	170 => array('width' => 170,  'height' => 198),
	350 => array('width' => 350,  'height' => 350)
);

$product_category_image_sizes = array(
	70  => array('width' => 70,   'height' => 65),
	100 => array('width' => 100,  'height' => 90),
	150 => array('width' => 150,  'height' => 140)
);

$product_image_other_sizes = array(
	40  => array('width' => 40,   'height' => 40),
	170 => array('width' => 170,  'height' => 198),
	350 => array('width' => 350,  'height' => 350)
);

function remove_sign_file($filename='', $tail=''){
	if($tail == ''){
		if($filename != ''){
			$needle = explode('.', $filename);
			$length = count($needle);
			if($length >= 2){
				$tail   = $needle[$length-1];
			}else{
				$tail = 'jpg';
			}
		}else{
			$tail = 'jpg';
		}
	}
	$body   = implode( "", explode(" ", microtime()) );
	return $body.'.'.$tail;
}

function remove_sign_file2($filename='', $tail='', $id = 0){
	if($tail == ''){
		if($filename != ''){
			$needle = explode('.', $filename);
			$length = count($needle);
			if($length >= 2){
				$tail   = $needle[$length-1];
			}else{
				$tail = 'jpg';
			}
		}else{
			$tail = 'jpg';
		}
	}
	if($id > 0){
		$body   = 'product_'.$id.date("_d_m_y");
	}else{
		$body   = implode( "", explode(" ", microtime()) );
	}
	return $body.'.'.$tail;
}

function make_dir($path){
	$pathArr = explode('/',$path);
	$dir = '';
	$start = 0;
	foreach ($pathArr as $val){
		if($start == 0){
			$dir .= $val;
			$start = 1;
		}
		else {
			$dir .= '/'.$val;
		}
		if($dir == '/home') {
			continue;
		}
		if(!is_dir($dir)){
			@mkdir($dir, 0775);
		}
	}
}

function setMess($mess = ''){
	return '[error]'.$mess;
}
//xac thuc nguoi dung
function crossAccessDenied($sql,$uid, $sid){
	//can viet them vao khi len site that
	return true;
}