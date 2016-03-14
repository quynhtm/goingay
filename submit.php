<?php
require_once('core/config.php');
require_once('core/Debug.php');
require_once('core/DB.php');
require_once('core/CGlobal.php');
require_once('core/Url.php');
/*require_once('core/Cache.php');
require_once(ROOT_PATH.'includes/memcache.class.php');
require_once('core/Product.php');*/

$objSubmit = new submit();
$action = isset($_GET['cmd']) ? $_GET['cmd'] : '';
if($action == 'reset'){
	$time = isset($_GET['time']) ? $_GET['time'] : 0;
	$objSubmit->resetTime($time);
}else{
	$objSubmit->processGenSiteMap();
}

class submit {
	
	/**
	 * xu ly gen sitemap
	 *
	 * @return unknown
	 */
	function processGenSiteMap() {
	 
		//get all news
		$aryNewsList = $this->getNewInfo();
		
		$this->genGMap($aryNewsList);
		$this->genYMap($aryNewsList);
	}
	
	/**
	 * gen sitemap
	 *
	 */
	public function genGMap($aryNewsList) {
		
		$strMap =  "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
		$strMap .= "<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">\n";
		$strMap .= $this->buildGoogleString($aryNewsList);
		$strMap .= "</urlset>\n";

		$urlPath = WEB_ROOT . "/";
		 
		 $fileName = $_SERVER['DOCUMENT_ROOT'].'/sitemap-google.xml';
		 $fp = fopen($fileName, 'w');
		 fwrite($fp, $strMap);
		 fclose($fp);
		 
		 //ping to google order to update sitemap, chi chay lan dau, hoac add link vao google
		 $url = 'www.google.com/webmasters/tools/ping?sitemap=' . urlencode($urlPath.$fileName);
		 $content = $this->getContent($url);
		 print_r($content);
		 echo "Gen google sitemap thanh cong";
	}

	/**
	 * buiGoogleString
	 */
	public function buildGoogleString($aryNewsList) {
		$strMap = '';
		
		$strMap .= "<url>\n";
		$strMap .= "<loc>" . Url::build('home', array()) . "</loc>\n";
		$strMap .= "<lastmod>".date("Y-m-d")."</lastmod>\n";
		$strMap .= "<changefreq>never</changefreq>\n";
		$strMap .= "</url>\n";
		
		$strMap .= "<url>\n";
		$strMap .= "<loc>" . Url::build('maytinh', array()) . "</loc>\n";
		$strMap .= "<lastmod>".date("Y-m-d")."</lastmod>\n";
		$strMap .= "<changefreq>never</changefreq>\n";
		$strMap .= "</url>\n";
		
		$strMap .= "<url>\n";
		$strMap .= "<loc>" . Url::build('dienthoai', array()) . "</loc>\n";
		$strMap .= "<lastmod>".date("Y-m-d")."</lastmod>\n";
		$strMap .= "<changefreq>never</changefreq>\n";
		$strMap .= "</url>\n";
		
		//create map, those are news of page
		if (is_array($aryNewsList)) foreach ($aryNewsList as $aryNews) {
			$url = $this->getUrl($aryNews);
			if($url) {
				$strMap .= "<url>\n";
				$strMap .= "<loc>" . $url . "</loc>\n";
				$strMap .= "<lastmod>".date("Y-m-d")."</lastmod>\n";
				$strMap .= "<changefreq>daily</changefreq>\n";
				$strMap .= "</url>\n";
			}
		}

		return $strMap;
	}
	
	/**
	 * gen yahoo map
	 *
	 */
	public function genYMap($aryNewsList) {
		
		$strMap =  "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>\n";
		
		$strMap .= "<rss version=\"2.0\">\n";
		$strMap .= "<channel>\n";
		$strMap .= "<title>Save.vn</title>\n";
		$strMap .= "<description>Mobile, máy tính, Laptop, nhạc chuông, phần mềm, game, sản phẩm, rao vặt, cửa hàng</description>\n";
		$strMap .= " <link>http://save.vn</link>\n";
		
		//get terms
		$strMap .= $this->buildYahooString($aryNewsList);
		
		$strMap .= "</channel>\n";
  		$strMap .= "</rss>\n";

		$urlPath = HOST_NAME . "/";
		 
		 $fileName = $_SERVER['DOCUMENT_ROOT'].'/sitemap-yahoo.xml';
		 $fp = fopen($fileName, 'w');
		 fwrite($fp, $strMap);
		 fclose($fp);
		 
		 //ping to google order to update sitemap
		 $url = 'http://ping.feeds.yahoo.com/rss/ping?u=' . urlencode($urlPath.$fileName);
		 $content = $this->getContent($url);
		 print_r($content);
		 echo "Gen yahoo sitemap thanh cong";
	}

	/**
	 * buildYahooString 
	 */
	public function buildYahooString($aryNewsList) {
		
		$strMap = '';
		
		$strMap .= "<item>\n";
		$strMap .= "<title>Save.vn</title>\n";
		$strMap .= "<link>" . Url::build('home', array())  . "</link>\n";
		$strMap .= "<pubDate>".date("Y-m-d")."</pubDate>\n";
		$strMap .= "</item>\n";
				
		$strMap .= "<item>\n";
		$strMap .= "<title>Máy tính | Save.vn</title>\n";
		$strMap .= "<link>" . Url::build('maytinh', array())  . "</link>\n";
		$strMap .= "<pubDate>".date("Y-m-d")."</pubDate>\n";
		$strMap .= "</item>\n";
				
		$strMap .= "<item>\n";
		$strMap .= "<title>Điện thoại | Save.vn</title>\n";
		$strMap .= "<link>" . Url::build('dienthoai', array())  . "</link>\n";
		$strMap .= "<pubDate>".date("Y-m-d")."</pubDate>\n";
		$strMap .= "</item>\n";
		
		//create map, those are news of page
		if (is_array($aryNewsList)) foreach ($aryNewsList as $aryNews) {
			$url = $this->getUrl($aryNews);
			if($url) {
				$strMap .= "<item>\n";
				$strMap .= "<title>" . $aryNews['category_name'] . " | Save.vn</title>\n";
				$strMap .= "<link>" . $url  . "</link>\n";
				$strMap .= "<pubDate>".date("Y-m-d")."</pubDate>\n";
				$strMap .= "</item>\n";
			}
		}
		
		return $strMap;
	}
	
	/*
	  * @return string
	  * @param string $url
	  * @desc Return string content from a remote file
	*/
	function getContent($url) {
	   $ch = curl_init();
	   curl_setopt ($ch, CURLOPT_URL, $url);
	   curl_setopt ($ch, CURLOPT_HEADER, 0);
	   ob_start();
	   curl_exec ($ch);
	   curl_close ($ch);
	   $string = ob_get_contents();
	   ob_end_clean();
	   
	   return $string;
	}
	
	/**
	*getUrl get url of sitemap
	*
	* @return  $strAction 
	*/
	function getUrl($row) {

		$strAction= '';
		
		$currentDepart = $row['depart_id'];
		
		switch ($currentDepart) {
			case CGlobal::MAY_TINH :
				$strAction .= Url::build('maytinh/c'.$row['id'].'/'.$this->safe_title($row['name']));
				break;

			case CGlobal::DIEN_THOAI :
				$strAction .= Url::build('dienthoai/c'.$row['id'].'/'.$this->safe_title($row['name']));
				break;
		}

		return $strAction;
	}

	/**
	 * get data
	 *
	 */
	function getNewInfo() {
		$aryResult = array();
		$aryResult = DB::fetch_all("SELECT * FROM `so_products_category`");

		return $aryResult;
	}
	
	function resetTime($time = 0) {
		$conn = mysql_connect(DB_MASTER_SERVER, DB_MASTER_USER, DB_MASTER_PASSWORD);

		if (!$conn) {
		   echo "Unable to connect to DB: " . mysql_error();
		   exit;
		}

		//set charset to utf8
		mysql_query("SET NAMES 'utf8'", $conn);
		 
		if (!mysql_select_db(DB_MASTER_NAME)) {
		   echo "Unable to select mydbname: " . mysql_error();
		   exit;
		}
		mysql_query("DELETE FROM configs WHERE conf_key = 'cronjob_gmap_ymap_time'");

		mysql_query("INSERT INTO configs SET conf_val=$time,conf_key = 'cronjob_gmap_ymap_time'");

		mysql_close();
		
		echo 'Reset time success! Your time has changed to '.$time;
		exit();
	}
//	--------------------- SOME FUNCTION -----------------------------
	function safe_title($text){
		$text = $this->post_db_parse_html($text);
		$text = $this->stripUnicode($text);
		return $this->_name_cleaner($text,"-");
	}
	
	//-----------------------------------------
	// parse_html
	// Converts the doHTML tag
	//-----------------------------------------
	static function post_db_parse_html($t=""){
		if ( $t == "" ){
			return $t;
		}

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
	
	function stripUnicode($str){
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
	
	function _name_cleaner($name,$replace_string="-"){
		$name = preg_replace( "/[^a-zA-Z0-9\-\_]/", $replace_string , $name );
		return preg_replace( "/[-]+/", $replace_string , $name );
	}
}
?>