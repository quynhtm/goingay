<?php
class Debug {
	function __construct() {}
	
	function set_ajax_debug() {
		$_SESSION['ary_ajax_debug'][] = array(
			'time' => TIME_NOW,
			'params' => $_REQUEST,
			'key' => 'ajax.php?act='.(isset($_REQUEST['act']) ? $_REQUEST['act'] : ''). (isset($_REQUEST['code']) ? '&code='.$_REQUEST['code'] : ''),
			'query_debug' => CGlobal::$query_debug,			
			'aryMemcacheDebug' => CGlobal::$aryMemcacheDebug,
			'list_file_loaded' => AutoLoader::$list_file_loaded,
			'$_'				=> CGlobal::$_
		);
	}
	
	function get_ajax_debug() {
		return isset($_SESSION['ary_ajax_debug']) ? $_SESSION['ary_ajax_debug'] : array();
	}
	
	function clear_data_ajax_debug() {
		if(isset($_SESSION['ary_ajax_debug'])) {
			$_SESSION['ary_ajax_debug'] = array();
		}
	}
	
	function start_ajax_debug() {
		$_SESSION['is_ajax_debug'] = 1;
	}
	
	function is_ajax_debug() {
		return isset($_SESSION['is_ajax_debug']);
	}
	
	function stop_ajax_debug() {
		if(isset($_SESSION['is_ajax_debug'])) {
			unset($_SESSION['is_ajax_debug']);
		}
		
		$this->clear_data_ajax_debug();
	}
	
	function __destruct() {
		if(is_debug() && $this->is_ajax_debug()) {
			if(preg_match('#.*ajax\.php#', $_SERVER['SCRIPT_FILENAME'])) {
				$this->set_ajax_debug();
			}
		}
	}
}

	$is_search_engine_array = array("Google", "Fast", "Slurp", "Ink", "Atomz", "Scooter", "Crawler", "MSNbot", "Poodle", "Genius"); 
	$is_search_engine = 0; 
	foreach($is_search_engine_array as $key => $val)  {
		if(strstr($_SERVER['HTTP_USER_AGENT'], $val)) 
			$is_search_engine++; 
	}
	
	if(isset($_GET['page']) && $_GET['page']=='error'){
		define('ERROR_PAGE',1);
	}
	else{
		define('ERROR_PAGE',0);
	}
	
	
	if($is_search_engine == 0 && !defined('NO_SESSION') && !ERROR_PAGE){
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
	}
/**
 * END Session START
 */
	
	function loadTime()
	{
		global $start_rb;
		
		/*$mtime = microtime();
		$mtime = explode(" ",$mtime);
		$mtime = $mtime[1] + $mtime[0];*/
		$end_rb = microtime(true);			
		$page_load_time = round(($end_rb - $start_rb),5)."s";	
		
		$color = (is_debug()) ? "red" : "#FFFFFF";
		echo "<br clear='left'><font style='color:$color;'><b>Load time: $page_load_time</b></font>";	
		exit();
	}
	
	function startLoadTime()
	{
		global $start_rb;
		
		$start_rb = microtime(true);
	}
	//error_reporting  (E_ERROR | E_WARNING | E_PARSE);
//	error_reporting  (0);
	
	//debug enable
	$is_debug = null;

	function enbac_error_handle($errno, $errmsg, $filename, $linenum, $vars)
	{
	   $dt = date("Y-m-d h:i:s");
	   $errortype = array (
				   E_USER_ERROR        => 'ENBAC Fatal Error',
				   E_ERROR              => 'ENBAC Error',
				   E_WARNING            => 'ENBAC Warning',
				   E_PARSE              => 'ENBAC Parsing Error',
				   E_NOTICE            => 'ENBAC Notice',
				   E_CORE_ERROR        => 'ENBAC Core Error',
				   E_CORE_WARNING      => 'ENBAC Core Warning',
				   E_COMPILE_ERROR      => 'ENBAC Compile Error',
				   E_COMPILE_WARNING    => 'ENBAC Compile Warning',
				   E_USER_ERROR        => 'ENBAC User Error',
				   E_USER_WARNING      => 'ENBAC User Warning',
				   E_USER_NOTICE        => 'ENBAC User Notice'
				  // E_STRICT            => 'ENBAC Runtime Notice',
				  // E_RECOVERABLE_ERROR  => 'ENBAC Catchable Fatal Error'
				   );

	
	 $errortype = $errortype["$errno"];	 
	 CGlobal::$error_handle .= "<tr>
								  <td style='font-size:14px' bgcolor='#FFFFFF'>
								  <b>$errortype</b> [Error num : $errno] -- date : $dt <br>
								  File: $filename - Line: $linenum<br>
	 							  $errmsg
								  </td>
								 </tr>";
	}
		
	/**
	 * kiem tra xem he thong dang duoc debug hay ko?
	 * @return unknown_type
	 */
	function is_debug() {
		//return true;
		
		global $is_debug;
		if($is_debug === null) {
			if(isset($_GET["ebug"])){
				$is_debug = (int)(boolean)$_GET["ebug"];
			}
			elseif ((isset($_REQUEST["ebug"]) && intval($_REQUEST["ebug"]) == 1) || (isset($_COOKIE["ebug"]) && intval($_COOKIE["ebug"]) == 1)){
				$is_debug = 1;
			}
			else{
				$is_debug = 0;
			}
			//chỉ khi status debug=1 và là root thì mới show debug
			$is_debug = ($is_debug == 1 && (isset($_SESSION['user_id']) && ($_SESSION['user_id'] == 1)))? true : false;
			//$is_debug = ($is_debug == 1 && (isset($_SESSION['user_id']) && (User::is_root())))?true:false;
		}
		return $is_debug;
		//return 1;
	}

	if( is_debug() ){
		ini_set('display_errors', 1);
		ini_set('error_reporting', E_ALL);
	}

		
	if(isset($rtime)){
		$time_check = $rtime;
	}

	function tbug($str=''){
		static $count=1,$display=0;
		if(!$display){
			if(!$display && isset($_GET['tbug'])){
				if($_GET['tbug']==1){
					$display=1;	
				}
				else
					$display=2;
			}
			elseif(!$display && isset($_REQUEST['tbug'])){
				if($_REQUEST['tbug']==1){
					$display=1;	
				}
				else
					$display=2;
			}
		}
		
		if($display==1){
			global $start_rb,$time_check;
			$end_rb = microtime(true);
				
			$module_load_time 	= round(($end_rb - $time_check),4)."s";	
			$page_load_time 	= round(($end_rb - $start_rb),4)."s";	
			
			$time_check = $end_rb;	
			
			echo "<br /><font style='color:#F00;'>".($count++).") $str $page_load_time".($page_load_time!=$module_load_time?" ($module_load_time)":"")."</font>";	
		}
	}

function getDebug(){
	global $start_rb;
	$page_load_time = round ( (microtime (true) - $start_rb), 5 ) . "s";
	$time_now = date ( 'H:i:s - d-m-Y', TIME_NOW );

	$queries_count = DB::num_queries ();

	$sql_load_time = round ( CGlobal::$query_time, 5 ) . "s";
	$buildPage = Url::build ( 'edit_page', array ('id' => EnBac::$page ['id'] ) );
	$editPage = Url::build ( 'page', array ('id' => EnBac::$page ['id'], 'cmd' => 'edit' ) );
	$delCache = Url::build ( 'page', array ('id' => EnBac::$page ['id'], 'cmd' => 'refresh', 'href' => '?' . $_SERVER ['QUERY_STRING'] ) );
	$includeFile = get_included_files();
	
	$txt ="
	<style type='text/css'>
		#debug_area td {padding: 5px;}
	</style>
	<center style='margin: 20px auto; padding: 10px 30px; background: #fff' id='debug_area'>
		<div>
			Server: <b><font color=red>{$_SERVER ['SERVER_ADDR']}</font></b> |
			Số lượng query: <b>$queries_count</b> |
			Thời gian load trang: <b><font color=".(($page_load_time > 0.2)? "'red'" : "'green'").">$page_load_time </font></b> |
			Thời gian hiện tại: <b>$time_now</b>
		</div>
		<div style='margin-top:5px'>
			<a href='$buildPage'>Bố cục trang</a> |
			<a href='$editPage'>Sửa trang</a> |
			<a href='$delCache'>Xoá cache trang</a>
		</div>";
	
	$txt .= "<div>
			<div>
				<h1>SQL Total Time: $sql_load_time for  $queries_count query</h1>
				<div style='color: #666'> ". CGlobal::$conn_debug ." </div>";
	
	if(CGlobal::$query_debug){
		$txt.= 	"<div style='margin-top:20px; padding: 2px; border: #FFD6DC 1px solid; font-size:12px;'>
					<table width='100%' border='0' cellpadding='6' cellspacing='1' bgcolor='#ababab' align='center'>
						<tr>
							<td colspan='8' style='background-color: #FFD6DC;font-size:16px;color:#000'><b>MySql Query</b></td>
						</tr>
						". CGlobal::$query_debug ."
					</table>
				</div>";
	}
	
	if(!empty(CGlobal::$aryMemcacheDebug)){
		$txt.= 	"<div style='margin-top:20px; padding: 2px; border: green 1px solid; font-size:12px;'>
					<div>
						<div style='background-color:green;font-size:16px;color:#fff; margin-bottom: 10px;'><b>MemCache</b></div>";
		foreach (CGlobal::$aryMemcacheDebug as $module_name => $list) {
			$txt.= 	"<table width='100%' border='0' cellpadding='6' cellspacing='1' bgcolor='#ababab'  align='center' style='margin-bottom: 10px;'>
							<tr>
								<td style='background-color:#cccccc;font-size:13px;'><b>". $module_name ."</b></td>
							</tr>";
			foreach ($list as $v) {
				$txt.= 	$v;
			}
			
			$txt.= 	"</table>";
		}							
		$txt.= 					"
					</div> 
				</div>";
	}
	if(!empty(CGlobal::$aryModuleDebug)) {
		$txt.= 	"<div style='margin-top:20px; padding: 2px; border: blue 1px solid; font-size:12px;'>
					<div style='background-color:blue;font-size:16px;color:#fff; margin-bottom: 10px;'><b>DEBUG MODULE</b></div>
							<table width='100%' border='1' cellpadding='6' cellspacing='1' style='border-collapse: collapse; border-color: #cccccc' align='left'>
								<tr bgcolor='#CCCCCC'>
									<td width='200'><b>NAME</b></td>
									<td><b>LOAD TIME</b></td>
								</tr>";
		$txt.= 	@join('', CGlobal::$aryModuleDebug);
		$txt.= 	"			</table> 
					<div style='clear: both'></div>
				</div>";
	}
	if(!empty(AutoLoader::$list_file_loaded)) {
		$txt.= 	"<div style='margin-top:20px; padding: 2px; border: #ffd850 1px solid; font-size:12px;'>
					<div style='background-color: #ffd850;font-size:16px;color:#f20000; margin-bottom: 10px;'><b>AUTOLOAD</b></div>
							<table width='100%' border='1' cellpadding='6' cellspacing='1' style='border-collapse: collapse; border-color: #cccccc' align='left'>
								<tr bgcolor='#CCCCCC'>
									<td style='padding-left: 50px;' bgcolor='#ffffb0'>
										<ul style='list-style-type: decimal;'><li> ". join('</li><li>', AutoLoader::$list_file_loaded) ."</li></ul>
									</td>
								</tr>";
		$txt.= 	"			</table> 
					<div style='clear: both'></div>
				</div>";
	}
	if(StaticCache::$cacheFilesList!=''){
		echo "<table width='95%' border='1' cellpadding='6' cellspacing='0' bgcolor='#FEFEFE'  align='center'>
			 <tr>
				  <td style='font-size:14px' bgcolor='#EFEFEF' align='center'><span style='color:green'><b>STATIC CACHES</b></span></td>
				 </tr>
				<tr>
			  <td style='font-family:courier, monaco, arial;font-size:14px;color:green'>
			 <ol> ".StaticCache::$cacheFilesList."</ol>
			  </td>
			 </tr>
			 <tr>
			</table><br />";
	}
	if(EBArrCache::$cache_list!=''){
		echo "<table width='95%' border='1' cellpadding='6' cellspacing='0' bgcolor='#FEFEFE'  align='center'>
			 <tr>
				  <td style='font-size:14px' bgcolor='#EFEFEF' align='center'><span style='color:green'><b>ARRAY CACHES</b></span></td>
				 </tr>
				<tr>
			  <td style='font-family:courier, monaco, arial;font-size:14px;color:green'>
			 <ol> ".EBArrCache::$cache_list."</ol>
			  </td>
			 </tr>
			 <tr>
			</table><br />\n\n";
	}
	
	$txt.= "
			</div>
		</div>
	</center>";
	
	return $txt;
}
function praseTrace($backTrace){
	$traceText = '';
	if(!empty($backTrace)){
		$traceText = 
		"<table width='100%' border='0' cellpadding='6' cellspacing='0' align='center'>";
		$i = 0;
		//$except = array('index.php','Module.php','Layout.php','Form.php','_cache','LayoutGenerate.php','CacheLib.php');
		$except = array();
		foreach ($backTrace as $b){
			$show = true;
			foreach ($except as $e){
				if (stripos($b['file'], $e) > 0) {
					$show = false;
					break;
				}
			}
			if ($show) {
				$traceText .= '<tr>';
				$traceText .= '<td '.(($i !=0) ? 'style ="border-top:1px solid #ccc"' : '' ).'>';
				$traceText .= '<div style="overflow:hidden;height:17px">';
				$file = $b['file'];
				$lenFile = strlen($file);
				if($lenFile > 35){
					$file = '...'.substr($file, ($lenFile - 35), $lenFile);
				}
				$traceText .= '<div style="float:left;width:350px"><b>File : </b><span title=\''.$b['file'].'\'>'.$file.'</span></div>';
				$traceText .= '<div style="float:left;width:80px"><b>Line:</b> '.$b['line'].'</div>';
				if(isset($b['class']) || isset($b['function'])){
					$traceText .= '<div style="float:left;margin:0 20px;width:500px"> ';
					$funcText = '';
					if(isset($b['class'])){
						$funcText = $b['class'].((isset($b['type'])) ? $b['type'] : '');
					}
					if(isset($b['function'])){
						$funcText .= $b['function'];
					}
					$funcText .= '(';
					if(isset($b['args'])){
						$valText = '';
						foreach ($b['args'] as $v){
							if(is_integer($v)) {
								$valText .= $v.',';
							}
							elseif (is_bool($v)) {
								$valText .= ($v ? 'true' : 'false').',';
							}
							elseif(is_object($v)) {
								$valText .= '"'.var_export($v, true).'",';
							}
							else {
								//$valText .= '"'.$v.'",';
							}
						}
						$funcText .= (strlen($valText) > 1) ? substr($valText,0,-1) : $valText;
					}
					$funcText .= ');';
					$shortText = $funcText;
					if(strlen($shortText) > 60){
						$shortText = substr($funcText, 0, 60).'...';
					}
					$traceText .= '<span title=\''.$funcText.'\'>'.$shortText.'</span></div>';
				}
				$traceText .= '<div style="clear:both;height:0;overflow:hidden"></div></div></td></tr>';
				$i++;
			}
		}
		$traceText .= "</table>";
	}
	return $traceText;
}