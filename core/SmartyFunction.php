<?php
function insert_getImageNews($arr) {
	$img = trim($arr['img']);
	$type= trim($arr['type']);
	$id     = intval($arr['id']);
	return ImageUrl::getNewsImage($type,true,true,$img,$id);
}
/* mb string */
function insert_mb_substr ($arr) {
	// kiem tra xem do dai cua chuoi co dai hon length ko
	$check = 0;
	$arr["str"] = trim($arr["str"]);
	$str = $arr["str"];
	if( mb_strlen($arr["str"], "utf-8") > $arr["length"] ) {
		$surfix = "...";
		$check = 1;
		$strTmp = mb_substr($arr["str"], 0, $arr["length"], "utf-8");
		$intPos = mb_strrpos($strTmp, " ", 0, "utf-8");
		$str = mb_substr($strTmp, 0, $intPos, 'utf-8').$surfix;
	}
	/*$arr = array("str" => $str, "check" => $check);
	return $arr;*/
	return $str;
}

function insert_code_news ($arr) {
	return EnBacLib::safe_title($arr['str']);
}

function insert_vardump ($arr) {
	return var_dump($arr['value']);
}
// ---------------------- function use in smarty plugin ----------------------- //
//money format string
function bm_money_format($number = 0){
	return number_format((int)$number,0,'','.');
}
//lay url chuan
function get_url($str = ''){
	$params = explode('&',$str);
	$page = explode('=',$params[0]);
	$page = array_pop($page);
	$len  = count($params);
	$arr  = array();
	for($i=1;$i<$len;$i++){
	  $keys = explode('=', $params[$i]);
	  $arr[$keys[0]] = $keys[1];
	}
	return Url::build($page,$arr);;
}


/**
 * Smarty regex_replace modifier plugin
 *
 * Type:     modifier<br>
 * Name:     substring
 * Purpose:  substring like in php
 * @param string
 * @return string
 */
function smarty_modifier_substring($sString, $dFirst = 0, $dLast = 0, $ext = '') {
    if($dLast == 0) {
       return substr($sString, $dFirst);
    } else {
       return substr($sString, $dFirst, $dLast).$ext;
    }
} 
?>