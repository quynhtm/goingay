<?php
define('PAGE_CACHE_DIR',DIR_CACHE.'pages/');
define('PAGE_CACHE_ON',true);
EnBac::del_page_cache();

class EnBac{
	static $current = false,$page = false,$page_cache_file='',$extraHeader = '',$extraFooter = '',$extraHeaderCSS = '',$extraHeaderJS = '';
	static function Run(){
		EnBacLib::CheckDir(PAGE_CACHE_DIR);		
		if(isset($_REQUEST['page'])){
			$page_name = strtolower($_REQUEST['page']);
		}
		else{
			$page_name = 'home';
		}
		
		EnBac::$page_cache_file = PAGE_CACHE_DIR.$page_name.'.php';
		
		if(Url::get('refresh_page')==1){
			self::del_page_cache($page_name);
		}
		
		if(Url::get('refresh_page')!=1 && PAGE_CACHE_ON && file_exists(EnBac::$page_cache_file)){
			require_once EnBac::$page_cache_file;
		}
		else{
			$re = DB::query('SELECT id, name, title, layout  FROM page WHERE name="'.addslashes($page_name).'"',__LINE__.__FILE__);

			if($re){
                $row = mysql_fetch_assoc($re);
                EnBac::$page = $row;
            }
			
			if(!EnBac::$page){Url::redirect_url(WEB_ROOT);}
			
			EnBacGen::PageGenerate();
		}
	}
	
	static function update_page($ids){//$ids là danh sách id dạng "1,2,3";
		$re=DB::query('SELECT name FROM page WHERE id IN ('.$ids.')',__LINE__.__FILE__);
		$pages=array();
		if($re){
			while ($page=mysql_fetch_assoc($re)){
				if($page && $page['name']){
					self::del_page_cache($page['name']);
				}
			}
		}
		return true;  	
	}
	static function update_all_page(){
		$re=DB::query('SELECT name FROM page',__LINE__.__FILE__);
		$pages=array();
		if($re){
			while ($page=mysql_fetch_assoc($re)){
				if($page && $page['name']){
					self::del_page_cache($page['name']);
				}
			}
		}
		return true;  	
	}
	
	static function del_page_cache($page=''){
		return ;
		if($page!=''){
			if(is_array(CGlobal::$my_server)){
				foreach (CGlobal::$my_server as $server){
					$link = "http://{$server}/?trigger=1&page_cache_file={$page}";
					if(@fopen($link,"r")){
						//if(DEBUG){echo "run service in $link<br>";}					
					}
					else{
						if(is_debug()){echo "error in $link<br>";}	
					}
				}				
			}
			return true;
  		}
		//trigger delscache
		elseif(isset($_REQUEST['trigger'])  && isset($_REQUEST['page_cache_file']) && $_REQUEST['trigger'] && $_REQUEST['page_cache_file']){
			$page_cache_file=$_REQUEST['page_cache_file'];
			@unlink(PAGE_CACHE_DIR.$page_cache_file.'.php');
			if(is_debug()){
				echo "Deleted Page cache file: {$page_cache_file}";
			}
			exit;
		}
	}
}