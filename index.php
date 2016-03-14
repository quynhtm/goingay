<?php
$start_rb 	= microtime(true);
require_once 'core/config.php';//System Config...
require_once 'core/Debug.php'; //System Debug...
require_once 'core/Init.php';  //System Init...
tbug('Load core files');
EnBac::Run();//System process & output...
tbug('End of Page');
$end_rb = microtime(true);			
$page_load_time = round(($end_rb - $start_rb),5)."s";
$color = (is_debug()) ? "red" : "#FFFFFF";
if(User::is_root()){
echo "<br clear='left'><font style='color:$color;'>Total load time ({$_SERVER['SERVER_ADDR']}) : $page_load_time</font>";
}