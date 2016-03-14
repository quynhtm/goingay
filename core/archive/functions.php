<?php
function leading_zeros($length, $source){
	/*$des = $source;
	$n = $length - strlen($source);
	for($i = 0; $i < $n; $i++){
		$des = "0".$des;
	}
	return $des;*/
	return sprintf("%0{$length}d", $source);
}

function parse_data($text){
	$text = preg_replace('#(<[/]?a.*>)#iU', '', $text);	
	return $text;
}

function end_month($timestamp){
    if (!isset($timestamp) || $timestamp==""){ 	
        return false;
    }
	$date2_temp = date("Y-m-d",$timestamp);
	$date2 = new DateTime($date2_temp);	
	$date2->modify("+1 month");
	$timestamp =  datetime2timestamp($date2->format("Y-m-d"));
    return $timestamp;
}

function datetime2timestamp($datetime){
    $datetime = str_replace('-', ' ', $datetime);
    $datetime = str_replace('/', ' ', $datetime);
    $datetime = str_replace(':', ' ', $datetime);
    $array = explode(' ', $datetime);

    $year   = $array[0];
    $month  = $array[1];
    
    $day    = isset($array[2]) ? $array[2] : '01';
    $hour   = isset($array[3]) ? $array[3] : '00';
    $minute = isset($array[4]) ? $array[4] : '00';
    $second = isset($array[5]) ? $array[5] : '00';
   
    if (preg_match("/^(\d{4}) (\d{2}) (\d{2}) ([01][0-9]|2[0-3]) ([0-5][0-9]) ([0-5][0-9])$/", "$year $month $day $hour $minute $second", $matches)) {
        if (checkdate($matches[2], $matches[3], $matches[1])) {
       		return mktime(intval($hour), intval($minute), intval($second), intval($month), intval($day), intval($year));
        } 
        else{
        	return time();
        }       
    } 
    else {
    	return time();
    }
}

//Simple cache for RB Archive
//Author : Nova
//date 21.10.08
function cache_check($file , $expire = 0){
	if(!_CACHE_ON){
		return false;
	}
	if(@file_exists($file)){		
		$filemtime = filemtime($file);
		if(time() < $filemtime + $expire){				
			return true;
		}		
	}
	return false;		
}


function cache_set($file,$data){
	if(!_CACHE_ON){
		return false;
	}
	
	if(!CheckDir(dirname($file))){
		return false;
	}
	
	if($file){
		if(@file_put_contents($file,$data)){
			@chmod($file,0777);
			return true;	    			
		}
	}
	return false;		
}	

function cache_get($file){
	if(!_CACHE_ON){
		return false;
	}	
	if($file){
		if($data = @file_get_contents($file)){
			return $data;	    			
		}
	}
	return false;		
}

//Simple pagging
/*
	Class phan trang. Khi can phan trang search san pham hay tin tuc. ta dung class nay
    Dau vao: $numHits: Tong so trang, $limit: Tong so bai post moi trang, $page: So trang hien tai.
    Dau ra: select * from tintuc order by ID limit $offset," .$info["posts_per_page"];
    ta se co $offset va $limit
    $offset : Diem bat dau cua trang tin.;
    $limit : Diem ket thuc cua trang tin;
    $numPages : So trang;
    $page: Trang hien tai .
*/
class Pager{
   function getPagerData($numHits, $limit, $page){
        $numHits  = (int) $numHits;
        $limit    = max((int) $limit, 1);
        $page     = (int) $page;
        $numPages = ceil($numHits / $limit);
        $page = max($page, 1);
        $page = min($page, $numPages);
		$page = ($page < 1) ? 1 : $page;
        $offset = ($page - 1) * $limit;
        $ret = new stdClass;

        $ret->offset   = $offset;
        $ret->limit    = $limit;
        $ret->numPages = $numPages;
        $ret->page     = $page;
        return $ret;
   }
}

function safe_title($text){
	$text = post_db_parse_html($text);
	$text = stripUnicode($text);
	$text = _name_cleaner($text,"-");
	$text = str_replace("----","-",$text);
	$text = str_replace("---","-",$text);
	$text = str_replace("--","-",$text);
	$text = trim($text, '-');
	return $text;
}

function CheckDir($pDir){
	if (is_dir($pDir))
		return true;
	if (!@mkdir($pDir,0777,true)){
		return false;
	}
	chmod_dir($pDir,0777);
	return true;
}

function chmod_dir($dir,$mod=0777){
	$parent_dir=dirname(str_replace(_ROOT_PATH,'',$dir));
	if($parent_dir!='' && $parent_dir!='.'){
		//echo $parent_dir.'/<br />';
		@chmod($dir,$mod);
		chmod_dir($parent_dir,$mod);
	}
	return true;
}


function post_db_parse_html($t=""){
	if ( $t == "" ){
		return $t;
	}
	$t = str_replace( "&#39;"   , "'", $t );
	$t = str_replace( "&#33;"   , "!", $t );
	$t = str_replace( "&#036;"   , "$", $t );
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
function _name_cleaner($name,$replace_string="_"){
	return preg_replace( "/[^a-zA-Z0-9\-\_]/", $replace_string , $name );
}

function do_includes(){
	require_once '../core/config.php';//System Config...
	require_once ROOT_PATH.'core/CGlobal.php';
	require_once ROOT_PATH.'core/DB.php';	
}


function compress($srcName, $dstName){
	$fp = fopen($srcName, "r");
	$data = fread ($fp, filesize($srcName));
	fclose($fp);
	
	$zp = gzopen($dstName, "w9");
	gzwrite($zp, $data);
	gzclose($zp);
}

function gzFileLink($scrFile,$data){
	$str = $data;
	cache_set($scrFile,$str);
	$gz = gzopen($scrFile,'w9');
	gzwrite($gz, $str);
	gzclose($gz);
	return true;
}



class zip
{
    public function infosZip ($src, $data=true)
    {
        if (($zip = zip_open(realpath($src))))
        {
            while (($zip_entry = zip_read($zip)))
            {
                $path = zip_entry_name($zip_entry);
                if (zip_entry_open($zip, $zip_entry, "r"))
                {
                    $content[$path] = array (
                        'Ratio' => zip_entry_filesize($zip_entry) ? round(100-zip_entry_compressedsize($zip_entry) / zip_entry_filesize($zip_entry)*100, 1) : false,
                        'Size' => zip_entry_compressedsize($zip_entry),
                        'NormalSize' => zip_entry_filesize($zip_entry));
                    if ($data)
                        $content[$path]['Data'] = zip_entry_read($zip_entry, zip_entry_filesize($zip_entry));
                    zip_entry_close($zip_entry);
                }
                else
                    $content[$path] = false;
            }
            zip_close($zip);
            return $content;
        }
        return false;
    }
    public function extractZip ($src, $dest)
    {
        $zip = new ZipArchive;
        if ($zip->open($src)===true)
        {
            $zip->extractTo($dest);
            $zip->close();
            return true;
        }
        return false;
    }
    public function makeZip ($src, $dest)
    {
        $zip = new ZipArchive;
        $src = is_array($src) ? $src : array($src);
        if ($zip->open($dest, ZipArchive::CREATE) === true)
        {
            foreach ($src as $item)
                if (file_exists($item))
                    $this->addZipItem($zip, realpath(dirname($item)).'/', realpath($item).'/');
            $zip->close();
            return true;
        }
        return false;
    }
    private function addZipItem ($zip, $racine, $dir)
    {
        if (is_dir($dir))
        {
            $zip->addEmptyDir(str_replace($racine, '', $dir));
            $lst = scandir($dir);
                array_shift($lst);
                array_shift($lst);
            foreach ($lst as $item)
                $this->addZipItem($zip, $racine, $dir.$item.(is_dir($dir.$item)?'/':''));
        }
        elseif (is_file($dir))
            $zip->addFile($dir, str_replace($racine, '', $dir));
    }
}
?>