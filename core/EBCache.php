<?php
//Xoá cache
EBCache::auto_delete();

class EBCache {   
	static $expire = 3600, $subDir = '', $result, $key, $createdTime = TIME_NOW;
  	static function auto_delete($cache_key=''){
  		if($cache_key!=''){
  			if(MEMCACHE_ON){
				eb_memcache::do_remove("qcache:$cache_key");
  			}	
  			else{
  				if(is_array(CGlobal::$my_server)){
					foreach (CGlobal::$my_server as $server){
						$link = "http://{$server}/?trigger=1&cache_key={$cache_key}";	
						if(@fopen($link,"r")){
							//if(DEBUG){echo "run service in $link <br>";}
						}
						else{
							if(is_debug()){echo "error in $link  <br>";}
						}
					}					
				}			
  			}
  			return true;
  		}
  		//trigger delcache
  		elseif(isset($_REQUEST['trigger']) && isset($_REQUEST['cache_key']) && $_REQUEST['trigger'] && $_REQUEST['cache_key']  ){
			$cache_key=$_REQUEST['cache_key'];
			@unlink(DIR_CACHE . "db/{$cache_key}");
			if(is_debug()){
				echo "Deleted DB cache file : {$cache_key}";
			}
			exit;			
		}
  	}

  	static function getRows($sql,$call_pos=''){
		{
			self::$result = DB::query($sql,$call_pos);
		}
		
	  	if(!self::is_select($sql)){
  			return true;
  		}
  		
    	$rows = array();

    	while ($row = mysql_fetch_assoc(self::$result)) {
			$rows[] = $row;
    	}

    	mysql_free_result(self::$result);
	
    	return $rows;
  	}
	
  	static function cache($sql , $call_pos = '', $expire = 3600 , $update_type = 0 , $key = '',$subDirCache='',$del_cache=false){
		// $update_type:
		// 0: auto
		// 1: Xoá cache ( multi server ) và tạo lại cache
		// 2: Tạo lại cache
	
  		if(!self::is_select($sql)){
  			self::$result = DB::query($sql,$call_pos);			
  			return;
  		}
	
  		if($subDirCache!=''){
  			self::$subDir=$subDirCache;			
  		}
  		else{
  			self::$subDir='system';
  		}
  		
    	if (CACHE_ON && EnBacLib::CheckDir(DIR_CACHE.'db/'.self::$subDir.'/')){
    		self::$key = ($key) ? $key : md5($sql);
    		
    		if($del_cache){//Nếu chỉ xoá cache
    			self::auto_delete(self::_my_file());
				return true;
    		}
    		
    		if($expire<0)
    		$expire=0;
    		
    		self::$expire = $expire;
    		
    		if($update_type==1){//Xoá cache ( multi server ) và tạo lại cache
    			self::auto_delete(self::_my_file());
    			$result = false;//$result = self::get();
    		} 
    		/*elseif ($update_type==2){
    			$result=false;
    		}*/
			else{
				$result = self::get();
			}
    				
      		//if (empty($result)){     
      		if ($result === false){ 	
	    		$result = self::getRows($sql,$call_pos);
				self::set( $result ); 
      		}
      		else{
      			if(is_debug()){
      				if(class_exists('Module') && Module::$name!=''){
						$module_name = Module::$name;
					}
					else{								
						$module_name = "-- Enbac system";
					}
									
					if(isset($_REQUEST["level"]) && intval($_REQUEST["level"]) == 1){	      			
	      				CGlobal::$query_debug .= "<li> <span style='color:green'>$sql</span> [ Cache time : {$expire}s - <b>Created:</b> ".date('d/m/Y H:i:s',self::$createdTime)."<b> Expire:</b> ".date('d/m/Y H:i:s',self::$createdTime+self::$expire)." ]<br /><b>File:</b> ".DIR_CACHE . 'db/'. self::_my_file()."<br />-- Module : <span style='color:red;font-weight:bold'>".$module_name."</span> <br>".($call_pos?"<br /><b>Run at:</b> $call_pos<br />":"")."<br> \n \n</li>";
					}
					else{
						CGlobal::$query_debug .= "<table width='95%' border='1' cellpadding='6' cellspacing='0' bgcolor='#FEFEFE'  align='center'>
											 <tr>
											  <td style='font-size:14px' bgcolor='#EFEFEF'><span style='color:green'><b>Query cache</b> -- Module : <span style='color:red;font-weight:bold'>".$module_name."</span></span> ".($call_pos?"<br /><b>Run at:</b> $call_pos":"")."</td>
											 </tr>
											 <tr>
											  <td style='font-family:courier, monaco, arial;font-size:14px;color:green'>$sql</td>
											 </tr>
											 <tr>
											  <td style='font-size:14px' bgcolor='#EFEFEF'>[ Cache time : {$expire}s  - <b>Created:</b> ".date('d/m/Y H:i:s',self::$createdTime)."<b> Expire:</b> ".(self::$expire?date('d/m/Y H:i:s',self::$createdTime+self::$expire):'forever')." ]<br /><b>File:</b> ".DIR_CACHE . 'db/'. self::_my_file()."</span></td>
											 </tr>
											</table><br />\n\n";	      			
					}
      			}
      		}
    	}
    	else { 
      		$result = self::getRows($sql,$call_pos);      		
    	}

    	return ($result);
  	}

		
  	static function set($value) {
  		if(MEMCACHE_ON){
  			eb_memcache::do_put('qcache:'.self::_my_file(),serialize(array('array'=>$value,'exp_time' =>TIME_NOW + self::$expire)));  			
  		}
  		else{
  			@file_put_contents(DIR_CACHE . 'db/' . self::_my_file(),addslashes(serialize($value)));
  		}
		return TRUE;	    			
  	}

  	static function get(){
		if(isset($_GET['delcache']) && (int)$_GET['delcache']==1){
			self::auto_delete(self::_my_file());
			return false;
		}
		if(MEMCACHE_ON){
			$s_content = eb_memcache::do_get("qcache:".self::_my_file());
    			
   			if($s_content!=''){ 
				$arr = unserialize($s_content);
			
				if(isset($arr['array'],$arr['exp_time'])){
					if(self::$expire ==0 || (self::$expire>0 && TIME_NOW < $arr['exp_time'])){
						self::$createdTime = $arr['exp_time'] - self::$expire;
							
						return $arr['array'];
					}
				}
			}
		}
		else{
			$cfile = DIR_CACHE . 'db/'. self::_my_file();
			
			if(file_exists($cfile)){		
				self::$createdTime = filemtime($cfile);
						
				if((self::$expire>0 && TIME_NOW < self::$createdTime+self::$expire) || self::$expire == 0){
					return unserialize(stripslashes((@file_get_contents($cfile))));
				}
			}
		}
  		return false;
  	}
  	  	
	static function _my_file(){
		return self::$subDir.'/'.'cache.' . self::$key;
	}
  	 	
  	static function is_select($sql_str){
  		if(stristr($sql_str, 'SELECT'))	{
  			return true;
  		}
  		return false;  	
  	}
}