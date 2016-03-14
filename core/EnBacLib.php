<?php
class EnBacLib{
	static $check_uri = false;
	static $temp_instance 	= false;
	
	function __destruct() {		
	}
	
	static function get_config($update_cache = 0,$delcache = false){
		if(!CGlobal::$configs || $delcache || $update_cache){
			if(EBArrCache::is_not_cached('config_arr',0,'',$delcache)){
				if(!$delcache){
					$re = DB::query('SELECT * FROM configs',__LINE__.__FILE__);

					if($re){
						while ($value = mysql_fetch_assoc($re)){
							CGlobal::$configs[$value['conf_key']]=$value;
						}
					}

					EBArrCache::set(CGlobal::$configs);
				}
			}
			else{
				CGlobal::$configs 		= EBArrCache::$arr_cache;
				EBArrCache::$arr_cache 	= array();
			}
		}
	}
	

	/*-------------------------------------------------------------------------*/
	// Sets a cookie, abstract layer allows us to do some checking, etc
	//Hàm này ko đc dùng trong các function draw trong FORM
	/*-------------------------------------------------------------------------*/
	static function set_cookie($name, $value = "", $expires=""){
		$expires = ($expires)? $expires : time() + 60*60*24*365;
		if(!setcookie($name, $value, $expires,"/") && User::is_root()) {
			$debug = debug_backtrace();
			echo '<pre style="text-align: left">';
				print_r($debug[0]);
				print_r($debug[1]);
			echo '</pre>'; 
		}
		$_COOKIE[$name] = $value;
	}
	
	static function subString($str,$start,$num,$ext=false){
		$str=EnBacLib::plainText($str);

		if($num>strlen($str)-$start)
		$num=strlen($str)-$start;

		if($num<=0)
		return '';

		$pos=strpos(substr($str,$start+$num+1,strlen($str)-$start-$num-1),' ');

		$st=substr($str,$start,$num+$pos+1);

		if($ext && strlen($str)-$start>$num)
		$st.='..';

		return $st;
	}

	static function strippedLink($str,$length=68){
		if ( (strlen($str) - $length ) < 3 ){
			return $str;
		}
		return substr( $str , 0, floor(($length-3)/2) ).'...'.substr( $str , -floor(($length-3)/2) );
	}

	// ham tao descprtion trong tag DESCRIPTION
	static function descriptionText($str){
		$meta_desc = EnBacLib::post_db_parse_html($str);
		$meta_desc = EnBacLib::plainText(html_entity_decode($meta_desc, ENT_QUOTES, "UTF-8"));
		$meta_desc = str_replace('\'','',$meta_desc);
		$meta_desc = str_replace('"','',$meta_desc);
		return EnBacLib::delDoubleSpace(EnBacLib::trimSpace($meta_desc));
	}

	static function plainText($str){
		$arr_replace=array(
							'/\<p (.+?)\>(.+?)\<\/p\>/is'		=>	'$2'.' ',
							'/\<br \/\>/is'						=>  ' ',
							'/\<br\>/is'						=>  ' '
							);

		$str = preg_replace(array_keys($arr_replace),$arr_replace,$str);
		$str = strip_tags($str);

		//$filter = "\$|,,|@|\!|#|~|`|\%|\*|\^|\&|\(|\)|\+|\=|\[|\-|\_|\]|\[|\}|\{|\;|\:|\'|\"|\<|\>|\?|\||\\|\$|\.";
		//$filter = "\$|,,|@|\!|#|~|`|\%|\*|\^|\&|\(|\)|\+|\=|\[|\-|\_|\]|\[|\}|\{|\;|\:|\'|\"|\<|\>|\?|\||\\|\$|\.\.";
		//$str = preg_replace("/$filter/is", " ", $str);

		return self::delDoubleSpace(self::trimSpace(str_replace(array(chr(13),chr(9),chr(10),chr(239))," ",$str)));
	}

	static function buttonDel($url,$imageFile,$title=false,$alt=false,$target=false,$admin=false){
		if($admin){
			if(!User::is_admin())
			return '';
		}
		$st='&nbsp;<a href= "'.$url.'" onclick="return confirm(\'Bạn có chắc chắn muốn xóa không!?\');"';
		if($target)
		$st.=  ' target="'.$target.'"';
		if($title)
		$st.=  ' title=" '.addslashes($title).'"';
		if($alt)
		$st.=  ' alt=" '.addslashes($alt).'"';
		$st .=  '>'.'<img src="style/images/'.$imageFile.'" border="0"></a>';

		return $st;
	}

	static function button($url,$imageFile,$title=false,$alt=false,$target=false,$admin=false){
		if($admin){
			if(!User::is_admin())
			return '';
		}

		$st='<a href= "'.$url.'"';
		if($target)
		$st.=  ' target="'.$target.'"';
		if($title)
		$st.=  ' title=" '.addslashes($title).'"';
		if($alt)
		$st.=  ' alt=" '.addslashes($alt).'"';
		$st .=  '><img src="style/images/'.$imageFile.'" border="0"></a>';
		return $st;
	}
	
	static function base64_url_encode($input) {
		return str_replace('=','',strtr(base64_encode($input), '+/', '-_'));
	}

	

	static function _name_cleaner($name,$replace_string="_"){
		return preg_replace( "/[^a-zA-Z0-9\-\_]/", $replace_string , $name );
	}

	static function make_safe_name($name,$replace_string="_"){
		return preg_replace( "/[^\w\.]/", $replace_string , $name );
	}
	
	static function convertUnicodeCase($test){
		$uppercase_utf8=array("A","Á","À","Ả","Ã","Ạ","Â","Ấ","Ầ","Ẩ","Ẫ","Ậ","Ă","Ắ","Ằ","Ẳ","Ẵ","Ặ","E","É","È","Ẻ","Ẽ","Ẹ","Ê","Ế","Ề","Ể","Ễ","Ệ","I","Í","Ì","Ỉ","Ĩ","Ị","O","Ó","Ò","Ỏ","Õ","Ọ","Ô","Ố","Ồ","Ổ","Ỗ","Ộ","Ơ","Ớ","Ờ","Ở","Ỡ","Ợ","U","Ú","Ù","Ủ","Ũ","Ụ","Ư","Ứ","Ừ","Ử","Ữ","Ự","Y","Ý","Ỳ","Ỷ","Ỹ","Ỵ","Đ"," ", "~", "!", "@", "#", "$", "%", "^", "&", "*", "(", ")", "-", "_", "+", "=", "|", "\\", "{", "}",":", ";", "<", ">", "/", "?");
		$lowercase_utf8=array("a","á","à","ả","ã","ạ","â","ấ","ầ","ẩ","ẫ","ậ","ă","ắ","ằ","ẳ","ẵ","ặ","e","é","è","ẻ","ẽ","ẹ","ê","ế","ề","ể","ễ","ệ","i","í","ì","ỉ","ĩ","ị","o","ó","ò","ỏ","õ","ọ","ô","ố","ồ","ổ","ỗ","ộ","ơ","ớ","ờ","ở","ỡ","ợ","u","ú","ù","ủ","ũ","ụ","ư","ứ","ừ","ử","ữ","ự","y","ý","ỳ","ỷ","ỹ","ỵ","đ","", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "","", "", "", "", "", "", "", "", "");
		if(!$test){
			return $test;
		} else {
			$new_test=str_replace($uppercase_utf8,$lowercase_utf8,$test);
			return $new_test;
		}
	}
	//added by Nova....29.09.08 xu ly cac ky tu dac biet ngoai trang list
	static function filter_title($str){
		$str = EnBacLib::post_db_parse_html($str);
		$filter = "\$|,,|@|\!|#|~|`|\%|\*|\^|\&|\(|\)|\+|\=|\[|\-|\_|\]|\[|\}|\{|\;|\:|\'|\"|\<|\>|\?|\||\\|\$|\.\.";
		return preg_replace("/$filter/is", " ", $str);
	}

	static function convertUnicodeCaseWithoutHtml($test){
		$uppercase_utf8=array("A","Á","À","Ả","Ã","Ạ","Â","Ấ","Ầ","Ẩ","Ẫ","Ậ","Ă","Ắ","Ằ","Ẳ","Ẵ","Ặ","E","É","È","Ẻ","Ẽ","Ẹ","Ê","Ế","Ề","Ể","Ễ","Ệ","I","Í","Ì","Ỉ","Ĩ","Ị","O","Ó","Ò","Ỏ","Õ","Ọ","Ô","Ố","Ồ","Ổ","Ỗ","Ộ","Ơ","Ớ","Ờ","Ở","Ỡ","Ợ","U","Ú","Ù","Ủ","Ũ","Ụ","Ư","Ứ","Ừ","Ử","Ữ","Ự","Y","Ý","Ỳ","Ỷ","Ỹ","Ỵ","Đ","Q","W","R","T","U","S","D","F","G","H","J","K","L","Z","X","C","V","B","N","M","P");
		$lowercase_utf8=array("a","á","à","ả","ã","ạ","â","ấ","ầ","ẩ","ẫ","ậ","ă","ắ","ằ","ẳ","ẵ","ặ","e","é","è","ẻ","ẽ","ẹ","ê","ế","ề","ể","ễ","ệ","i","í","ì","ỉ","ĩ","ị","o","ó","ò","ỏ","õ","ọ","ô","ố","ồ","ổ","ỗ","ộ","ơ","ớ","ờ","ở","ỡ","ợ","u","ú","ù","ủ","ũ","ụ","ư","ứ","ừ","ử","ữ","ự","y","ý","ỳ","ỷ","ỹ","ỵ","đ","q","w","r","t","p","s","d","f","g","h","j","k","l","z","x","c","v","b","n","m","p");
		if(!$test){
			return $test;
		} else {
			$new_test=str_replace($uppercase_utf8,$lowercase_utf8,$test);
			return $new_test;
		}
	}

	static function safe_title($text){
		$text = EnBacLib::post_db_parse_html($text);
		$text = self::stripUnicode($text);
		$text = self::_name_cleaner($text,"-");
		$text = str_replace("----","-",$text);
		$text = str_replace("---","-",$text);
		$text = str_replace("--","-",$text);
		$text = trim($text, '-');

		if($text){
			return $text;
		}
		else{
			return "save.vn";
		}
	}


	static function convert_one_br($text){
		$text = str_replace("<br /><br /><br /><br /><br />","<br />",$text);
		$text = str_replace("<br /><br /><br /><br />","<br />",$text);
		$text = str_replace("<br /><br /><br />","<br />",$text);
		$text = str_replace("<br /><br />","<br />",$text);

		$text = trim($text, '<br />');


		return $text;
	}

	static function stripUnicode($str){
		if(!$str) return false;
		$marTViet=array("à","á","ạ","ả","ã","â","ầ","ấ","ậ","ẩ","ẫ","ă",
		"ằ","ắ","ặ","ẳ","ẵ","è","é","ẹ","ẻ","ẽ","ê","ề"
		,"ế","ệ","ể","ễ",
		"ì","í","ị","ỉ","ĩ",
		"ò","ó","ọ","ỏ","õ","ô","ồ","ố","ộ","ổ","ỗ","ơ"
		,"ờ","ớ","ợ","ở","ỡ",
		"ù","ú","ụ","ủ","ũ","ư","ừ","ứ","ự","ử","ữ",
		"ỳ","ý","ỵ","ỷ","ỹ",
		"đ",
		"À","Á","Ạ","Ả","Ã","Â","Ầ","Ấ","Ậ","Ẩ","Ẫ","Ă"
		,"Ằ","Ắ","Ặ","Ẳ","Ẵ",
		"È","É","Ẹ","Ẻ","Ẽ","Ê","Ề","Ế","Ệ","Ể","Ễ",
		"Ì","Í","Ị","Ỉ","Ĩ",
		"Ò","Ó","Ọ","Ỏ","Õ","Ô","Ồ","Ố","Ộ","Ổ","Ỗ","Ơ"
		,"Ờ","Ớ","Ợ","Ở","Ỡ",
		"Ù","Ú","Ụ","Ủ","Ũ","Ư","Ừ","Ứ","Ự","Ử","Ữ",
		"Ỳ","Ý","Ỵ","Ỷ","Ỹ",
		"Đ");

		$marKoDau=array("a","a","a","a","a","a","a","a","a","a","a"
		,"a","a","a","a","a","a",
		"e","e","e","e","e","e","e","e","e","e","e",
		"i","i","i","i","i",
		"o","o","o","o","o","o","o","o","o","o","o","o"
		,"o","o","o","o","o",
		"u","u","u","u","u","u","u","u","u","u","u",
		"y","y","y","y","y",
		"d",
		"A","A","A","A","A","A","A","A","A","A","A","A"
		,"A","A","A","A","A",
		"E","E","E","E","E","E","E","E","E","E","E",
		"I","I","I","I","I",
		"O","O","O","O","O","O","O","O","O","O","O","O"
		,"O","O","O","O","O",
		"U","U","U","U","U","U","U","U","U","U","U",
		"Y","Y","Y","Y","Y",
		"D");

		$str = str_replace($marTViet,$marKoDau,$str);
		return $str;
	}
	static function getParam($aVarName,$aVarAlt=""){
		$lVarName=@$_REQUEST[$aVarName];
		if (!Empty($lVarName)){
			if (is_array($lVarName)){
				$lReturnArray = array();
				foreach ($lVarName as $key => $value) {
					$value = self::clean_value($value);
					$key = self::clean_key($key);
					$lReturnArray[$key]=$value;
				}
				return $lReturnArray;
			}
			else
			return self::clean_value($lVarName); // Clean input and return it

		}
		else
		return $aVarAlt;
	}

	static function cleanHtml($aVarName,$aVarAlt=""){
		$lVarName=$aVarName;
		if (!Empty($lVarName)){
			if (is_array($lVarName)){
				$lReturnArray = array();
				foreach ($lVarName as $key => $value) {
					$value = self::clean_value($value);
					$key = self::clean_key($key);
					$lReturnArray[$key]=$value;
				}
				return $lReturnArray;
			}
			else
			return self::clean_value($lVarName); // Clean input and return it

		}
		else
		return $aVarAlt;
	}

	static function getParamInt($aVarName,$aVarAlt=0){
		$lNum = 0;
		if ($aVarName){
			if (isset($_POST[$aVarName]))
				$lNum = $_POST[$aVarName];
			elseif (isset($_GET[$aVarName]))
				$lNum = $_GET[$aVarName];
			else
				$lNum = $aVarAlt;
		}

		return (int)$lNum;
		//return (int)preg_replace('/\D+/', '', $lNum);
	}

	/*-------------------------------------------------------------------------*/
	// Key Cleaner - ensures no funny business with form elements
	/*-------------------------------------------------------------------------*/
	static function clean_key($key){
		if ($key == ""){
			return "";
		}

		$key = htmlspecialchars(urldecode($key));
		$key = preg_replace( "/\.\./"           , ""  , $key );
		$key = preg_replace( "/\_\_(.+?)\_\_/"  , ""  , $key );
		$key = preg_replace( "/^([\w\.\-\_]+)$/", "$1", $key );
		return $key;
	}

	/*-------------------------------------------------------------------------*/
	// Clean value
	/*-------------------------------------------------------------------------*/

	static function clean_value($val){
		$strip_space_chr = 1;
		$get_magic_quotes = @get_magic_quotes_gpc();

		if ($val == ""){
			return "";
		}

		$val = str_replace( "&#032;", " ", $val );

		if ( $strip_space_chr ){
			$val = str_replace( chr(0xCA), "", $val );  //Remove sneaky spaces
		}
		//$val = str_replace( "&"            , "&amp;"         , $val );
		$val = str_replace( "<!--"         , ""  , $val ); //&#60;&#33;--
		$val = str_replace( "-->"          , ""       , $val ); //--&#62;
		$val = preg_replace( "/<script/i"  , "&#60;script"   , $val );
		$val = str_replace( ">"            , "&gt;"          , $val );
		$val = str_replace( "<"            , "&lt;"          , $val );
		$val = str_replace( "\""           , "&quot;"        , $val );
		//$val = preg_replace( "/\n/"        , "<br />"        , $val ); // Convert literal newlines
		$val = preg_replace( "/\\\$/"      , "&#036;"        , $val );
		$val = preg_replace( "/\r/"        , ""              , $val ); // Remove literal carriage returns
		$val = str_replace( "!"            , "&#33;"         , $val );
		$val = str_replace( "'"            , "&#39;"         , $val ); // IMPORTANT: It helps to increase sql query safety.

		if ( $get_magic_quotes ){
			$val = stripslashes($val);
		}

		$val = preg_replace( "/\\\(?!&amp;#|\?#)/", "&#092;", $val );

		return $val;
	}

	//-----------------------------------------
	// parse_html
	// Converts the doHTML tag
	//-----------------------------------------
	static function post_db_parse_html($t=""){
		if ( $t == "" ){
			return $t;
		}

		//-----------------------------------------
		// Remove <br>s 'cos we know they can't
		// be user inputted, 'cos they are still
		// &lt;br&gt; at this point :)
		//-----------------------------------------

		/*		if ( $this->pp_nl2br != 1 )
		{
		$t = str_replace( "<br>"    , "\n" , $t );
		$t = str_replace( "<br />"  , "\n" , $t );
		}*/

		$t = str_replace( "&#39;"   , "'", $t );
		$t = str_replace( "&#33;"   , "!", $t );
		$t = str_replace( "&#036;"  , "$", $t );
		$t = str_replace( "&#124;"  , "|", $t );
		$t = str_replace( "&amp;"   , "&", $t );
		$t = str_replace( "&gt;"    , ">", $t );
		$t = str_replace( "&lt;"    , "<", $t );
		$t = str_replace( "&quot;"  , '"', $t );

		//-----------------------------------------
		// Take a crack at parsing some of the nasties
		// NOTE: THIS IS NOT DESIGNED AS A FOOLPROOF METHOD
		// AND SHOULD NOT BE RELIED UPON!
		//-----------------------------------------

		$t = preg_replace( "/javascript/i" , "j&#097;v&#097;script", $t );
		$t = preg_replace( "/alert/i"      , "&#097;lert"          , $t );
		$t = preg_replace( "/about:/i"     , "&#097;bout:"         , $t );
		$t = preg_replace( "/onmouseover/i", "&#111;nmouseover"    , $t );
		$t = preg_replace( "/onmouseout/i", "&#111;nmouseout"    , $t );
		$t = preg_replace( "/onclick/i"    , "&#111;nclick"        , $t );
		$t = preg_replace( "/onload/i"     , "&#111;nload"         , $t );
		$t = preg_replace( "/onsubmit/i"   , "&#111;nsubmit"       , $t );
		$t = preg_replace( "/object/i"   , "&#111;bject"       , $t );
		$t = preg_replace( "/frame/i"   , "fr&#097;me"       , $t );
		$t = preg_replace( "/applet/i"   , "&#097;pplet"       , $t );
		$t = preg_replace( "/meta/i"   , "met&#097;"       , $t );
		$t = preg_replace( "/embed/i"   , "met&#097;"       , $t );

		return $t;
	}
	
	//-----------------------------------------
	// parse_html
	// Converts the doHTML tag, alow opject, embed
	//-----------------------------------------
	static function post_db_parse_html_2($t=""){
		if ( $t == "" ){
			return $t;
		}

		//-----------------------------------------
		// Remove <br>s 'cos we know they can't
		// be user inputted, 'cos they are still
		// &lt;br&gt; at this point :)
		//-----------------------------------------

		/*		if ( $this->pp_nl2br != 1 )
		{
		$t = str_replace( "<br>"    , "\n" , $t );
		$t = str_replace( "<br />"  , "\n" , $t );
		}*/

		$t = str_replace( "&#39;"   , "'", $t );
		$t = str_replace( "&#33;"   , "!", $t );
		$t = str_replace( "&#036;"  , "$", $t );
		$t = str_replace( "&#124;"  , "|", $t );
		$t = str_replace( "&amp;"   , "&", $t );
		$t = str_replace( "&gt;"    , ">", $t );
		$t = str_replace( "&lt;"    , "<", $t );
		$t = str_replace( "&quot;"  , '"', $t );

		//-----------------------------------------
		// Take a crack at parsing some of the nasties
		// NOTE: THIS IS NOT DESIGNED AS A FOOLPROOF METHOD
		// AND SHOULD NOT BE RELIED UPON!
		//-----------------------------------------

		$t = preg_replace( "/javascript/i" , "j&#097;v&#097;script", $t );
		$t = preg_replace( "/alert/i"      , "&#097;lert"          , $t );
		$t = preg_replace( "/about:/i"     , "&#097;bout:"         , $t );
		$t = preg_replace( "/onmouseover/i", "&#111;nmouseover"    , $t );
		$t = preg_replace( "/onmouseout/i", "&#111;nmouseout"    , $t );
		$t = preg_replace( "/onclick/i"    , "&#111;nclick"        , $t );
		$t = preg_replace( "/onload/i"     , "&#111;nload"         , $t );
		$t = preg_replace( "/onsubmit/i"   , "&#111;nsubmit"       , $t );
		//$t = preg_replace( "/object/i"   , "&#111;bject"       , $t );
		$t = preg_replace( "/frame/i"   , "fr&#097;me"       , $t );
		$t = preg_replace( "/applet/i"   , "&#097;pplet"       , $t );
		$t = preg_replace( "/meta/i"   , "met&#097;"       , $t );
		//$t = preg_replace( "/embed/i"   , "met&#097;"       , $t );

		return $t;
	}
	
	static function word_limit($string, $length, $ellipsis="...") {
		return (count($words = explode(' ', $string)) > $length) ? implode(' ', array_slice($words, 0, $length)) . $ellipsis : $string;
	}
	
	static function mb_substr($string, $length, $ellipsis="...") {
		return (mb_strlen($string) > $length) ? mb_substr($string, 0, $length) . $ellipsis : $string;
	}
	
	static function remove_special_char($string, $special_char = '~!@\#\$%^&*()') {
		return preg_replace('#['.$special_char.']#', '', $string);
	}

	static function remove_4_js($t){
		$t =  self::make_single_space($t);
//		$t = str_replace( "'","&#39;"  ,  $t );
		$t = str_replace( "'","&quot;"  ,  $t );
		$t = str_replace( "&#39;",""  ,  $t );
		$t = str_replace( "!","&#33;"  ,  $t );
		$t = str_replace( "$","&#036;"  , $t );
		$t = str_replace( "|","&#124;"  , $t );
		//$t = str_replace( "&","&amp;"   , $t );
		$t = str_replace( ">", "&gt;"   , $t );
		$t = str_replace( "<", "&lt;"   , $t );
		$t = str_replace( '"', "&quot;" , $t );
		//$t = str_replace( '"', "&quot;" , $t );

		$t = str_replace(chr(10),"",$t);
		$t = str_replace(chr(13),"",$t);

		return trim($t);
	}

	static function make_single_space($t=""){
		if($t==""){
			return;
		}
		return preg_replace("/[[:space:]]+/", " ", $t);
	}

	static function CheckDir($pDir){
		if (is_dir($pDir))
		return true;
		if (!@mkdir($pDir,0777,true)){
			return false;
		}
		self::chmod_dir($pDir,0777);
		return true;
	}

	static function chmod_dir($dir,$mod=0777){
		$parent_dir=dirname(str_replace(ROOT_PATH,'',$dir));
		if($parent_dir!='' && $parent_dir!='.'){
			//echo $parent_dir.'/<br />';
			@chmod($dir,$mod);
			self::chmod_dir($parent_dir,$mod);
		}
		return true;
	}

	static function getOption($options_array,$selected = ''){
		$input='';
		if ($options_array)
		foreach($options_array as $key=>$text){
			$input .= '<option value="'.$key.'"';
			if($key==='' && $selected==='')
			{
				$input .=  ' selected';
			}
			else
			if( $selected!=='' && $key==$selected )
			{
				$input .=  ' selected';
			}
			$input .= '>'.$text.'</option>';
		}
		return $input;
	}

	static function getOptionMulti($options,$select_array){
		$input='';
		if ($options)
		foreach($options as $key=>$text){
			$input .= '<option value="'.$key.'"';
			if(in_array($key,$select_array))
			{
				$input .=  ' selected';
			}

			$input .= '>'.$text.'</option>';
		}
		return $input;
	}

	static function getOptionNum($min,$max,$default=1){
		$options = '';
		for($i=$min;$i<=$max;$i++){
			$options .= '<option value="';
			if ( $i<10 )
			$options .= '0'.$i.'"';
			else
			$options .= $i.'"';
			if ( $i == $default )
			{
				$options .= ' selected';
			}
			$options .= '>'.$i.'</option>';
		}
		return $options;
	}
	//Tuantq add 2010/11/05
	static function getRadioList($name,$radios_array,$checked,$distance='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'){
		$input='';
		if ($radios_array)
		{
			$i=0;
			foreach($radios_array as $key=>$text){
				$input .= '<input name="'.$name.'" id="'.$name.'_'.$i.'" type="radio" value="'.$key.'"';
				if($key==='' && $checked==='')
				{
					$input .=  ' checked="checked"';
				}
				else
				if( $checked!=='' && $key==$checked )
				{
					$input .=  ' checked="checked"';
				}
				$input .= ' /> <label for="'.$name.'_'.$i.'" >&nbsp;&nbsp; '.$text.'</label>';
				$input .= $distance;
				$i++;
			}
		}
		return $input;
	}
	
	static function getCheckboxList($name,$checkbox_array,$checked_array,$distance='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'){
		$input='';
		if(!is_array($checked_array)){
			$checked_array=array(0=>$checked_array);
		}
		if ($checkbox_array){
			$i=0;
			foreach($checkbox_array as $key=>$text){
				$input .= '<input name="'.$name.'[]" id="'.$name.'_'.$i.'"  type="checkbox" value="'.$key.'"';
				if(in_array($key,$checked_array))
				{
					$input .=  ' checked="checked"';
				}
				$input .= ' /><label for="'.$name.'_'.$i.'">&nbsp;&nbsp;'.$text.'</label>';
				$input .= $distance;
				$i++;
			}
		}
		return $input;
	}
	//E add

	static function deleteBadWord($id,$type){
		return DB::query('DELETE FROM bad_content WHERE id_item = '.$id.' AND type = '.$type,__LINE__.__FILE__);
	}

	static function duration($duration){
		if($duration>0){
			$time 	= $duration;
			$year 	= floor($time/(365*3600*24));
			$month 	= floor($time/(30*3600*24));
			$week 	= floor($time/(7*3600*24));
			$day 	= floor($time/(3600*24));
			$hour 	= floor(($time%(3600*24))/(3600));
			$minute = floor(($time%(3600))/(60));

			if($year!=0){
				return $year.' năm ';
			}

			if($month!=0){
				return $month.' tháng ';
			}
			if($week!=0){
				return $week.' tuần ';
			}
			if($day!=0){
				return $day.' ngày ';
			}
			if($hour!=0){
				return $hour.' giờ ';
			}

			if($minute!=0){
				return $minute.' phút ';
			}

			return $time.' giây ';
		}
		else{
			return ' vài giây';
		}
	}

	static function duration_time($time){
		$time = TIME_NOW - $time;

		if($time>0){
			if($time>(365*86400)){
				return floor($time/(365*86400)).' năm trước';
			}

			if($time>(30*86400)){
				return floor($time/(30*86400)).' tháng trước';
			}

			if($time>(7*86400)){
				return floor($time/(7*86400)).' tuần trước';
			}
			if($time>86400){
				return floor($time/(86400)).' ngày trước';
			}

			if($time>3600){
				return floor($time/(3600)).' giờ trước';
			}

			if($time>60){
				return floor($time/(60)).' phút trước';
			}
		}
		return ' vài giây trước';
	}
	static function parseBBCode($text,$direct = false){
		$old_text=$text;

		$text = stripslashes($text);

		//  $text = htmlspecialchars($text);
		//$text = nl2br($text);

		// First: If there isn't a "[" and a "]" in the message, don't bother.
		if (strpos($old_text, "[")!==false && strpos($old_text, "]")!==false){
			$arr_replace=array(

			'/\[font\=(.*?)\](.+?)\[\/font\]/is'		=>	'<span style="font-family: $1;">$2</span>',
			'/\[font\=(.*?)\](\s*)\[\/font\]/is'		=>	'',

			'/\[size\=(.*?)\](.+?)\[\/size\]/is'		=>	'<span style="font-size: $1;">$2</span>',
			'/\[size\=(.*?)\](\s*)\[\/size\]/is'		=>	'',

			'/\[color\=(.*?)\](.+?)\[\/color\]/is'      =>  '<span style="color: $1;">$2</span>',
			'/\[color\=(.*?)\](\s*)\[\/color\]/is'      =>  '',

			//'/\[img\](.+?)\[\/img\]/is'     			=>  '<img src="$1" alt="Picture" border="0"/>',
			'/\[img\](.+?)\[\/img\]/is'     			=>  '',
			'/\[img\](\s*)\[\/img\]/is'     			=>  '',

			/*"/\\[b\\](.+?)\[\/b\]/is"					=>	'<b>$1</b>',
			"/\\[b\\](\s*)\[\/b\]/is"					=>	'',
			"/\\[i\\](.+?)\[\/i\]/is"					=>	'<i>$1</i>',
			"/\\[i\\](\s*)\[\/i\]/is"					=>	'',
			"/\\[u\\](.+?)\[\/u\]/is"					=>	'<u>$1</u>',
			"/\\[u\\](\s*)\[\/u\]/is"					=>	'',*/

			"/\\[b\\]/is"								=>	'<b>',
			"/\\[\/b\]/is"								=>	'</b>',
			"/\\[i\\]/is"								=>	'<i>',
			"/\\[\/i\]/is"								=>	'</i>',
			"/\\[u\\]/is"								=>	'<u>',
			"/\\[\/u\]/is"								=>	'</u>',



//          '/\[url\=(.*?)\](.*?)\[\/url\]/is'			=>	'<a href="$1" target="_blank" title="$2">$2</a>',
			'/\[url\=(.*?)\](.*?)\[\/url\]/is'			=>	'<a href="$1" target="_blank">$2</a>',
//          '/\[url\](.*?)\[\/url\]/is'					=>	'<a href="$1" target="_blank">$1</a>',
			'/\[url\](.*?)\[\/url\]/is'					=>	'<a href="$1" target="_blank">$1</a>',
			'/\[url\](\s*)\[\/url\]/is'					=>	'',
//			'/\[img\](.*?)\[\/img\]/is' 				=>  '<img src="$1" border="0"/>',
			"/\[s\](.+?)\[\/s\]/is"						=>	'<s>\1</s>',
			"/\[s\](\s*)\[\/s\]/is"						=>	'',

			//"/\[quote\](.+?)\[\/quote\]/is"				=>	'<blockquote>$1</blockquote>',
			//"/\[quote\](\s*)\[\/quote\]/is"				=>	'',

			"/\[quote\]/is"								=>	'<div class="block_mess_sub">',
			"/\[\/quote\]/is"							=>	'</div>',

			"/\[hr\]/is"								=>	'<hr>',

			"/\[dotter\]/is"							=>	'<div style=" border-top:1px dotter #ccc">',
			"/\[\/dotter\]/is"							=>	'</div>',

			);

			$text = preg_replace(array_keys($arr_replace),$arr_replace,$text);
			$text = eregi_replace("\\[color=([^\\[]*)\\]([^\\[]*)\\[/color\\]","<font color=\"\\1\">\\2</font>",$text);
			//            $text = eregi_replace("\\[alink=([^\\[]*)\\]([^\\[]*)\\[/alink\\]","<a href=\"\\1\" target=\"_blank\" title=\"Liên kết\">\\2</a>",$text);
			$text = eregi_replace("\\[alink=([^\\[]*)\\]([^\\[]*)\\[/alink\\]","<a href=\"\\1\" target=\"_blank\">\\2</a>",$text);
		}

		

		unset($old_text);
		return $text;
		//        return self::BBCode($text);
	}

	static function parseEmoticon($text,$direct = false){
		
		if(trim($text) == '') return '';
		 
		//$text = html_entity_decode($text);
		$emoticon_dir = ($direct?WEB_ROOT:'').'style/images/boxmobi/emoticons/';

		
		$arr_replace = array(
		
		'/;;\)/is'	=>	'<img src="'.$emoticon_dir.'5.gif" />'
		,'/;\)\)/is'	=>	'<img src="'.$emoticon_dir.'6.gif" />'
		,'/>:D</is'	=>	'<img src="'.$emoticon_dir.'61.gif" />'
		,'/:-\//is'	=>	'<img alt=":-/" title=":-/" src="'.$emoticon_dir.'7.gif" />'
		
		,'/:-\*/is'	=>	'<img alt=":-*" title=":-*" src="'.$emoticon_dir.'11.gif" />'
		,'/=\(\(/is'	=>	'<img alt="=((" title="=((" src="'.$emoticon_dir.'12.gif" />'
		,'/:-O/is'	=>	'<img alt=":-O" title=":-O" src="'.$emoticon_dir.'13.gif" />'
		
		,'/:>/is'	=>	'<img alt=":>" title=":>" src="'.$emoticon_dir.'15.gif" />'
		,'/B-\)/is'	=>	'<img src="'.$emoticon_dir.'16.gif" />'
		
		,'/#:-S/is'	=>	'<img src="'.$emoticon_dir.'18.gif" />'
		,'/:-SS/is'	=>	'<img src="'.$emoticon_dir.'42.gif" />'
		,'/:-S/is'	=>	'<img alt=":-S" title=":-S" src="'.$emoticon_dir.'17.gif" />'
		
		
		,'/>:\)/is'	=>	'<img src="'.$emoticon_dir.'19.gif" />'
		,'/:\(\(/is'	=>	'<img src="'.$emoticon_dir.'20.gif" />'
		,'/:\)\)/is'	=>	'<img src="'.$emoticon_dir.'21.gif" />'
		
		,'/\/:\)/is'	=>	'<img src="'.$emoticon_dir.'23.gif" />'
		,'/=\)\)/is'	=>	'<img alt="=))" title="=))" src="'.$emoticon_dir.'24.gif" />'
		,'/O:-\)/is'	=>	'<img alt="O:-)" title="O:-)" src="'.$emoticon_dir.'25.gif" />'
		
		,'/=;/is'	=>	'<img alt="=;" title="=;" src="'.$emoticon_dir.'27.gif" />'
		,'/I-\)/is'	=>	'<img alt="I-)" title="I-)" src="'.$emoticon_dir.'28.gif" />'
		,'/8-\|/is'	=>	'<img alt="8-|" title="8-|" src="'.$emoticon_dir.'29.gif" />'
		,'/L-\)/is'	=>	'<img alt="L-)" title="L-)" src="'.$emoticon_dir.'30.gif" />'
		,'/:-&/is'	=>	'<img alt=":-&" title=":-&" src="'.$emoticon_dir.'31.gif" />'
		,'/:-\$/is'	=>	'<img alt=":-$" title=":-$" src="'.$emoticon_dir.'32.gif" />'
		,'/\[-\(/is'	=>	'<img alt="[-(" title="[-(" src="'.$emoticon_dir.'33.gif" />'
		,'/:O\)/is'	=>	'<img alt=":O)" title=":O)" src="'.$emoticon_dir.'34.gif" />'
		,'/8-\}/is'	=>	'<img alt="8-}" title="8-}" src="'.$emoticon_dir.'35.gif" />'
		,'/<:-P/is'	=>	'<img src="'.$emoticon_dir.'36.gif" />'
		,'/\(:\|/is'	=>	'<img src="'.$emoticon_dir.'37.gif" />'
		,'/=P\~/is'	=>	'<img alt="=P~" title="=P~" src="'.$emoticon_dir.'38.gif" />'
		,'/:-\?/is'	=>	'<img alt=":-?" title=":-?" src="'.$emoticon_dir.'39.gif" />'
		,'/#-o/is'	=>	'<img alt="#-o" title="#-o" src="'.$emoticon_dir.'40.gif" />'
		,'/=D>/is'	=>	'<img alt="=D>" title="=D>" src="'.$emoticon_dir.'41.gif" />'
		
		,'/@-\)/is'	=>	'<img alt="@-)" title="@-)" src="'.$emoticon_dir.'43.gif" />'
		,'/:\^o/is'	=>	'<img alt=":^o" title=":^o" src="'.$emoticon_dir.'44.gif" />'
		,'/:-w/is'	=>	'<img alt=":-w" title=":-w" src="'.$emoticon_dir.'45.gif" />'
		,'/:-</is'	=>	'<img alt=":-<" title=":-<" src="'.$emoticon_dir.'46.gif" />'
		,'/>:P/is'	=>	'<img src="'.$emoticon_dir.'47.gif" />'
		,'/<\):\)/is'	=>	'<img src="'.$emoticon_dir.'48.gif" />'
		,'/\^#\(\^/is'	=>	'<img alt="^#(^" title="^#(^" src="'.$emoticon_dir.'49.gif" />'
		,'/:\)\]/is'	=>	'<img src="'.$emoticon_dir.'50.gif" />'
		,'/:-c/is'	=>	'<img alt=":-c" title=":-c" src="'.$emoticon_dir.'51.gif" />'
		,'/\~X\(/is'	=>	'<img src="'.$emoticon_dir.'52.gif" />'
		,'/:-h/is'	=>	'<img alt=":-h" title=":-h" src="'.$emoticon_dir.'53.gif" />'
		,'/:-t/is'	=>	'<img alt=":-t" title=":-t" src="'.$emoticon_dir.'54.gif" />'
		,'/8->/is'	=>	'<img alt="8->" title="8->" src="'.$emoticon_dir.'55.gif" />'
		,'/X_X/is'	=>	'<img alt="X_X" title="X_X" src="'.$emoticon_dir.'56.gif" />'
		,'/:!!/is'	=>	'<img alt=":!!" title=":!!" src="'.$emoticon_dir.'57.gif" />'
		,'/\\\m\//is'	=>	'<img alt="\m/" title="\m/" src="'.$emoticon_dir.'58.gif" />'
		,'/:-q/is'	=>	'<img alt=":-q" title=":-q" src="'.$emoticon_dir.'59.gif" />'
		,'/:-bd/is'	=>	'<img src="'.$emoticon_dir.'60.gif" />'
		,'/:x/is'	=>	'<img alt=":x" title=":x" src="'.$emoticon_dir.'8.gif" />'
		,'/:">/is'	=>	'<img alt=":&quot;>" title=":&quot;>" src="'.$emoticon_dir.'9.gif" />'
		
		,'/X\(/is'	=>	'<img alt="X(" title="X(" src="'.$emoticon_dir.'14.gif" />'
		,'/:-B/is'	=>	'<img alt=":-B" title=":-B" src="'.$emoticon_dir.'26.gif" />'
		,'/:\)/is'	=>	'<img alt=":)" title=":)" src="'.$emoticon_dir.'1.gif" />'
		,'/:\(/is'	=>	'<img alt=":(" title=":(" src="'.$emoticon_dir.'2.gif" />'
		,'/;\)/is'	=>	'<img alt=";)" title=";)" src="'.$emoticon_dir.'3.gif" />'
		,'/:D/is'	=>	'<img alt=":D" title=":D" src="'.$emoticon_dir.'4.gif" />'
		,'/:\|/is'	=>	'<img alt=":|" title=":|" src="'.$emoticon_dir.'22.gif" />'
		,'/:P/is'	=>	'<img alt=":P" title=":P" src="'.$emoticon_dir.'10.gif" />'
		);
		
		$text_replace = array();
		foreach (array_keys($arr_replace) as $value){
			$text_replace[] = htmlspecialchars($value);
			
		}
		$text = preg_replace($text_replace,$arr_replace,$text);

		return $text;
	}
	
	static function BBCode($text){
		$text = stripslashes($text);
		//  $text = htmlspecialchars($text);
		// $text = nl2br($text);

		$arr_replace=array(
		'/<b>(.+?)<\/b>/is'													=>	'[b]$1[/b]',
		'/<i>(.+?)<\/i>/is'													=>	'[i]$1[/i]',
		'/<u>(.+?)<\/u>/is'													=>	'[u]$1[/u]',
		'/<a href="(.*?)" target="_blank">(.*?)<\/a>/is'					=>	'[url=$1]$2[/url]',
		'/<a href="(.*?)">(.*?)<\/a>/is'									=>	'[url=$1]$2[/url]',
		'/<s>(.+?)<\s>/is'													=>	'[s]$1[/s]',
		'/<blockquote>(.+?)<\/blockquote>/is'								=>	'[quote]$1[/quote]',
		'/<br \/>/is'														=>	"\n",
		'/<br\/>/is'														=>	"\n",
		'/<br>/is'															=>	"\n",
		'/&lt;br&gt;/is'															=>	"\n"
		);

		$text = preg_replace(array_keys($arr_replace),$arr_replace,$text);

		return $text;
	}

	function getListFriendofUser($user_id){
		$sql = 'SELECT user_id_friend FROM `friends_list` WHERE user_id = "'.$user_id.'"';

		$str = '';
		$subDir='user/'.floor($user_id/1000);
		if($items =  EBCache::cache($sql,__LINE__.__FILE__,'1',0,'',$subDir)){
			foreach($items as $value){
				$str .= $value['user_id_friend'].",";
			}
		}
		return $str;
	}

	function showJqueryMessage($content,$header = '',$theme = 'default',$sticky = 'false'){
		echo '
			<script type="text/javascript">
			(function($){

				$(document).ready(function(){

					$.jGrowl("'.$content.'", {
						header  : 	\''.$header.'\',
						opacity : 	\'hide\',

						sticky	: 	'.$sticky.',
						theme  	:	\''.$theme .'\'

					});

				});
			})(jQuery);
			</script>
		';
	}

	
	static function get_yahoo_avatar($yahoo_id,$user_id=0){
		$cache_path=ROOT_PATH.'cache/avatar/';
		$up_file  =TIME_NOW.'_'.$yahoo_id.'.gif';
		$up_path ='uploaded/ava_new/'.floor($user_id/1000).'/';

		if(self::checkDir($cache_path)){
			@file_put_contents($cache_path.$up_file,@file_get_contents('http://img.msg.yahoo.com/avatar.php?yids='.$yahoo_id.'&format=gif'));
			if(file_exists($cache_path.$up_file)){
				if(self::ftp_image_connect()){
					self::ftp_check_dir($up_path);

					if(self::ftp_image_put_file($up_path.$up_file,$cache_path.$up_file))
					{
						@unlink($cache_path.$up_file);
						return $up_path.$up_file;
					}
				}
				@unlink($cache_path.$up_file);
			}
		}
		return '';
	}

	static function getParamSearch($str_search){
		$str_search = str_replace( array('+','/','|','-','*') , "", $str_search );
		$str_search = self::trimSpace($str_search);
		$str_search = str_replace( "'" , '"', $str_search );
		$str_search = str_replace( "&#39;" , '"', $str_search );
		$str_search = str_replace( "&quot;" , '"', $str_search );

		if (eregi('"',$str_search) ){
			$pattern = '#\"(.+?)\"#is';
			preg_match_all($pattern, $str_search, $matches);
			$chars = preg_split($pattern, $str_search);

			$results .= implode(" ",$matches[0]);
			foreach ($chars as $row){
				if ($row){
					$row_array = explode(' ', $row);
					if (is_array($row_array)){
						foreach ($row_array as $word){
							if ($word) $results.=" +".trim($word)."";
						}
					}
					else{
						$results.=" +".trim($row)."";
					}
				}
			}
			return $results;
		}
		else{
			$search_array = explode(' ', $str_search);
			$content = implode(" +",$search_array);
			$content ="+".$content.'';
			return $content;
		}
	}

	static function trimSpace($str=""){
		if($str==""){
			return;
		}
		$str = str_replace("&nbsp;", " ", $str);
		$str = preg_replace('![\t ]*[\r\n]+[\t ]*!', ' ', $str);
		return trim(preg_replace('/[[:space:]]/', ' ', trim($str)));

	}

	static function delDoubleSpace($str){
		if (preg_match('/  /',$str)){
			$str = preg_replace('/  /',' ',$str);
			$str = self::delDoubleSpace($str);
			return $str;
		}
		else{
			return $str;
		}
	}

	//TuấnNK add ( 2008/05/23 12h17 ) hàm đếm ký tự viết hoa
	static function countUpChars($str){
		if($str!=''){
			$strNotAllow = "A B C D E F G H I J K L M N O P Q R S T U V W X Y Z Á À Ã Ạ Â Ấ Ầ Ẫ Ậ Ă Ắ Ằ Ẵ Ặ É È Ẽ Ẹ Ê Ế Ề Ễ Ệ Í Ì Ĩ Ị Ó Ò Õ Ọ Ô Ố Ồ Ỗ Ộ Ơ Ớ Ờ Ỡ Ợ Ú Ù Ũ Ụ Ư Ứ Ừ Ữ Ự Ý Ỳ Ỹ Ỵ";
			$checkArray=(explode(' ',$strNotAllow));
			$intCount = 0;

			foreach ($checkArray as $checkChar) {
				$intCount+=substr_count($str,$checkChar);
			}
			return ($intCount<=floor(strlen($str)/3));
		}
		return true;
	}

	static function IsSearchE(){
		$lSearchEngineArray=array("Google","yahoo","Fast", "Slurp", "Ink", "Atomz", "Scooter", "Crawler", "MSNbot", "Poodle", "Genius");
		$SearchEngineList =  join('|',$lSearchEngineArray);
		if(preg_match("/($SearchEngineList)/is",$_SERVER['HTTP_USER_AGENT'])){
			return true; // search engine
		}
		return false; // user
	}

	

	static function priceFomart($price,$currency_id=false){
		if($price){
			if($currency_id){
				if(isset(CGlobal::$currency[$currency_id])){
					$currency_id=" <font color='#B90404'>".CGlobal::$currency[$currency_id]."</font>";
				}
				else $currency_id=" <font color='#B90404'>VNĐ</font>";
			}
			else{
				$currency_id='';
			}
			if(eregi('\.',$price))
				return $price.$currency_id;
			else
				return number_format($price,0,',','.').$currency_id;
		}
		else{
			return "Liên hệ";
		}
	}
	static function show_error_mes($mess=""){
		Url::access_denied();
		//global $display;
		//$display->add('content',$mess);
		//$display->output('../error/error');

	}
	static function mouse_hover($color='#EAF1FB',$return=false){
		$str= ' onmouseover="tr_color=this.style.backgroundColor;this.style.backgroundColor=\''.$color.'\'" onmouseout="if(typeof(tr_color)!=\'undefined\'){this.style.backgroundColor=tr_color;}" ';
		if($return)return $str;else echo $str;
	}

	static function reload_captcha()
	{
		$alphanum		= "abcdefghiklmopqrstuvwxyz0123456789";
		$new_string	= substr(str_shuffle($alphanum), 0, 3);
		$_SESSION["enbac_validate"] = $new_string;
	}

	//get real IP - by TuanNV - 26/09/08
	static function ip_first($ips) {
	  if (($pos = strpos($ips, ',')) != false) {
	    return substr($ips, 0, $pos);
	  } else {
	    return $ips;
	  }
	}

	static function ip_valid($ips) {
	  if (isset($ips)) {
	    $ip    = self::ip_first($ips);
	    $ipnum = ip2long($ip);
	    if ($ipnum !== -1 && $ipnum !== false && (long2ip($ipnum) === $ip)) { // PHP 4 and PHP 5
	      if (($ipnum < 167772160   || $ipnum >   184549375) && // Not in 10.0.0.0/8
	          ($ipnum < -1408237568 || $ipnum > -1407188993) && // Not in 172.16.0.0/12
	          ($ipnum < -1062731776 || $ipnum > -1062666241))   // Not in 192.168.0.0/16
	        return true;
	    }
	  }
	  return false;
	}

	static function ip() {
		  if(CGlobal::$ip == 0) {
		  
			  $check = array('HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED',
			                 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED',
			                 'HTTP_VIA', 'HTTP_X_COMING_FROM', 'HTTP_COMING_FROM');
			
			  foreach ($check as $c) {
			    if (isset($_SERVER[$c]) && self::ip_valid($_SERVER[$c])) {
			    	CGlobal::$ip = self::ip_first($_SERVER[$c]);
			    	break;
			    }
			  }
			  
			  if(CGlobal::$ip == 0) CGlobal::$ip = $_SERVER['REMOTE_ADDR'];
		  }
		  return CGlobal::$ip;
	}

	static function session_started(){
	     if(isset($_SESSION)){ return true; }else{ return false; }
	}

	function limit_char_per_word($str="",$limit=10){
		if(!EnBacLib::countUpChars($str)){
			$str = EnBacLib::convertUnicodeCaseWithoutHtml($str);
		}

		$arr_tmp = explode(' ',$str);
		$str_tmp = '';
		foreach($arr_tmp as $ar){
			if(strlen($ar)>$limit){
				$str_tmp .= ' '.substr($ar,0,$limit);
			}
			else{
				$str_tmp .= ' '.$ar;
			}
		}

		return trim($str_tmp);
	}


	//check_badword

	static function get_badword($update_cache = 0,$delcache = false){
		$badword = array();
		$subDir = 'badword';
		$badword = EBCache::cache('SELECT * FROM bad_words ORDER By exact DESC',__LINE__.__FILE__,86400,$update_cache,'',$subDir,$delcache);
		usort( $badword ,  array( 'EnBacLib', 'word_length_sort' ) );
		if($badword && !$delcache){
			return $badword;
		}
		return $badword;
	}

	static function word_length_sort($a, $b){
		if ( mb_strlen($a['contents'],'UTF-8') == mb_strlen($b['contents'],'UTF-8') ){
			return 0;
		}
		return ( mb_strlen($a['contents'],'UTF-8') > mb_strlen($b['contents'],'UTF-8') ) ? -1 : 1;
	}

	static function checkBadWord($str_check='', $return = false, $del_cache = false){

		if ($str_check == "" && !$del_cache){
			return false;
		}

		for( $i = 65; $i <= 90; $i++ ){
			$str_check = str_replace( "&#".$i.";", chr($i), $str_check );
		}

		for( $i = 97; $i <= 122; $i++ ){
			$str_check = str_replace( "&#".$i.";", chr($i), $str_check );
		}

		$str_check = preg_replace("/<br[^>]*>/", "\n", $str_check);
		//$str_check = eregi_replace("<br[^>]*>", "\n", $str_check);
		$str_check = preg_replace("/<p[^>]*>/", "\n", $str_check);
		//$str_check = eregi_replace("<p[^>]*>", "\n", $str_check);
    	$str_check = preg_replace("/<\/p[^>]*>/", "\n", $str_check);
    	//$str_check = eregi_replace("</p[^>]*>", "\n", $str_check);

		$str_check = strip_tags($str_check);

		$str_check = str_replace(chr(9), ' ', $str_check);

		$str_check = str_replace("&nbsp;", " ", $str_check);

		$matches=array();
		$arr_badword = EnBacLib::get_badword();

		if(!$del_cache){

			foreach($arr_badword as $badword){
				$bad 				 = preg_quote($badword['contents']);
				$badword['contents'] = preg_quote($badword['contents']);
				$badword['contents'] = str_replace( array('\*','\?'), array('(.{0,3})','(.+)') , $badword['contents'] );

				if($badword['exact']){
					if(preg_match( '#(^|\s|\b)'.$badword['contents'].'(\b|\s|!|\?|\.|,|$)#ui', $str_check,$match)){
						if($return){
							$bad_arrs[$bad]=$bad;
							$matches[]=$match[0];
						}
						else{
							return true;
						}
					}
				}
				else{
					if(preg_match('#'.$badword['contents'].'#ui', $str_check, $match)){
						if($return){
							$bad_arrs[$bad]=$bad;
							$matches[]=$match[0];
						}
						else{
							return true;
						}
					}
				}
			}
			if($return && isset($bad_arrs)){
				return array(
							'bad' =>implode(', ',$matches),
							'bad_key' 	=>str_replace(array('\*','\?'),'',implode(', ',$bad_arrs))
							);
			}
			else{
				return false;
			}
		}

	}

	static function del_reason_mod($id){
		if($id>0){

			DB::query("DELETE FROM bad_content WHERE id_item = ".$id." AND type = 3");
			return true;
		}else return false;

	}

	

	function convertCurrency($price,$currency_id){
		if($currency_id==2){
			$price = $price*CURRENCY_USD;
		}
		elseif($currency_id==3){
			$price = $price*CURRENCY_EUR;
		}
		return $price;
	}
	
	function is_mobile($value){
		//return preg_match('#^(0120|0121|0122|0123|0124|0125|0126|0127|0128|0129|0163|0164|0165|0166|0167|0168|0169|0188|0199|090|091|092|093|094|095|096|097|098|099)(\d{7})$#', $value);
		return preg_match('#^(01([0-9]{2})|09[0-9])(\d{7})$#', $value);
	}

	static function  check_uri(){
		if(!self::$check_uri){
			CGlobal::$request_uri = $_SERVER['REQUEST_URI'];
			if(isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] != ''){
				CGlobal::$referer_url = $_SERVER['HTTP_REFERER'];
			}

			CGlobal::$query_string=$_SERVER['QUERY_STRING']?'?'.$_SERVER['QUERY_STRING']:'';
			$dir=(dirname($_SERVER['SCRIPT_NAME'])?dirname($_SERVER['SCRIPT_NAME']):'');

			$dir = str_replace('\\','/',$dir);

			if($dir && $dir!='/' && $dir!='./'){
				if($dir[0]!='/'){
					$dir='/'.$dir;
				}
				$dir.=$dir[strlen($dir)-1]!='/'?'/':'';
				CGlobal::$query_string = str_replace($dir,'',CGlobal::$request_uri);
			}
			else{
				$uri=CGlobal::$request_uri;
				if(strlen($uri)>1){

					while($uri[0]=='/'){
						$uri=substr($uri,1,strlen($uri)-1);
					}

					CGlobal::$query_string = $uri;
					unset($uri);
				}
				else{
					CGlobal::$query_string = '';
				}
			}

			self::$check_uri = true;
		}
	}

	static function del_product_telecom($id_product) {

		$product = DB::select('bm_network_product',"id = $id_product");

		if($product){
			DB::query("UPDATE bm_network_product SET status = -1 WHERE id = $id_product");
			if($product['type'] == 1){
				DB::query('UPDATE bm_mobile_network SET service = service - 1 WHERE service > 0 AND id = '.$product['id_telecom']);
				//xoa cache list
				StaticCache::delCache("BmProfileProduct_service_".$product['user_id']);
			}
			else{
				DB::query('UPDATE bm_mobile_network SET product = product - 1 WHERE product > 0 AND id = '.$product['id_telecom']);
				//xoa cache list
				StaticCache::delCache("BmProfileProduct_product_".$product['user_id']);
			}
			//xoa static cache list
			StaticCache::delCache("BmProfileProduct_".$product['user_id']);
			StaticCache::delCache("BmProfileProductView_".$product['id']);
			
			//xoa memcache detail
			if(MEMCACHE_ON){
				eb_memcache::do_remove("bm_network_product:".$product['id']);
			}
			return $id_product;
		}
		return false;
	 }
	static function upcase_first_char($str){
		$str_first = mb_substr($str, 0, 1,"UTF-8");
		$str_first_upcase = mb_strtoupper($str_first,"UTF-8");
		$str_len = mb_strlen($str);
		$str = $str_first_upcase.mb_substr($str, 1, $str_len,"UTF-8");
		return $str;
	}
	static function update_read_count($id, $type=0){
		if($type==0)
			DB::query("UPDATE bm_item SET read_count  = read_count + 1 WHERE id=$id ");
	}
	static function update_faqs_read_count($id)
	{
		DB::query("UPDATE `bm_question` SET `read_count`  = `read_count` + 1 WHERE id=$id ");
	}
	
	static function getExtension($file) {		
		$tail = strtolower(strrchr($file,"."));
		return substr($tail, 1);
	}
	

	/**
	 * Copy from src to dest (file or directory)
	 *
	 * @param string $src
	 * @param string $dest
	 * @param boolean $overwrite
	 * @return boolean
	 */
	static function copyDir($src, $dest, $overwrite = false) {

		$res = true;

	 	if(!preg_match('#/$#', $src)) $src .= '/';
	 	if(!preg_match('#/$#', $dest)) $dest .= '/';
	 	
		if ($hd = opendir($src)) {
			$aryNotRequire = array('.', '..', '.svn', 'sitemap.xml');

			while(false !== ($entry = readdir($hd))){
				
				if(!in_array($entry, $aryNotRequire)){
					if(is_file($src . $entry)) {
						// Check overwrite
						if (!$overwrite && is_file($dest . $entry)) {
							$res = false;
							break;
						}
						// copy file
						if (!copy($src . $entry, $dest . $entry)) {
							$res = false;
							break;
						}

					} elseif(is_dir($src . $entry)){
						
						if(!is_dir($dest . $entry)) {
							$curUmask = umask(0000);
							if (!mkdir($dest . $entry, 0755)) {
								$res = false;
								break;
							}
							umask($curUmask);
						}

						//recurse!
						$res = self::copyDir($src . $entry . '/', $dest . $entry . '/', $overwrite);
						if (!$res) {
							break;
						}
					}
				}
			}
			closedir($hd);
		}
		return $res;
	}
	
	
	
	/**
	 * 
	 * @param unknown_type $dirname
	 * @param boolean(default = true) $delete_root_folder: xóa folder gốc hay ko \n
	 * delFolder('../root/2010/', true) => xóa thư mục 2010 \n
	 * delFolder('../root/2010/', false) => không thư mục 2010 \n 
	 */
	static function delFolder($dirname, $delete_root_folder = true) {
		//$dirname = '../'.$dirname;
		
	   if (is_dir($dirname))
	      $dir_handle = opendir($dirname);
	      
	   if (!isset($dir_handle) || !$dir_handle)
	      return false;
	      
	   while($file = readdir($dir_handle)) {
	      if ($file != "." && $file != "..") {
	         if (!is_dir($dirname."/".$file))
	            unlink($dirname."/".$file);
	         else
	            self::delFolder($dirname.'/'.$file, true);    
	      }
	   }
	   closedir($dir_handle);
	   
	   if($delete_root_folder == true) {
	   		rmdir($dirname);
	   }
	   return true;
	}
}
?>