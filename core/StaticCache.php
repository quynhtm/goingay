<?php
StaticCache::delCache();
class StaticCache{
	static $curentCacheFilePath='';
	static $handleContent='';
	static $curentContent='';
	static $cacheFilesList='';
	static $curentExpTime=0;
	static $pNum=0;
	static $cNum=0;
	/* 
		- Kiem ra file cache co ton tai khong
		- Tham so: 
				$filePath: Ten file (Bao gom ca duong dan)
		- Tra ve: true or false
	*/
	static function notExistCache($filePath,$exp_time=0,$handleContent=false,$subDir=''){
		self::$curentContent='';
		self::$handleContent=$handleContent;
		  
		if(!CACHE_ON)//Nếu tắt chế độ cache
		return true;
		
		if(MEMCACHE_ON){//Nếu bật chế độ mem_cache
			
			if($subDir!=''){
				$filePath=$subDir.'/'.$filePath;
			}
			
			self::$curentCacheFilePath	= $filePath;
			self::$curentExpTime		= $exp_time;
			
			if (isset($_GET['delscache']) && (int)$_GET['delscache']=='1'){
				self::delCache($filePath);
				return true;
			}
			
			$s_content = eb_memcache::do_get("scache:$filePath");
			
			if($s_content!=''){
				$arr = unserialize($s_content);
				
				if(isset($arr['content'],$arr['exp_time'])){
					
					if($exp_time>0){
						$filemtime = $arr['exp_time'];
						if(TIME_NOW > $arr['exp_time']){
							return true;	
						}
					}
					else{
						$filemtime = $arr['exp_time'];
					}
					
					if(is_debug()){
						self::$cNum++;
						self::$pNum++;
						
						if(class_exists('Module') && Module::$name!=''){
							$module_name = Module::$name;
						}
						else{								
							$module_name = "-- Enbac system";
						}
						
						$info="<b>".$module_name."</b><br /><font color=red><b>".self::$curentCacheFilePath."</b></font><br /><b>Cache Time:</b> ".$exp_time."s ";
						
						
						if($exp_time>0){
							$info.="<b>Created:</b> ".date('d/m/Y H:i:s',($filemtime-$exp_time));
							$info.="<b> Expire:</b> ".date('d/m/Y H:i:s',$filemtime);
						}
						else
							$info.="<b> Expire:</b> forever";
						
						self::$cacheFilesList.="<li>".$info."</li>";
					}
					
					if(self::$handleContent){
						self::$curentContent = $arr['content'];
					}
					else 
						echo $arr['content'];
						
					return false;
				}
			}
		}
		else{
			if($subDir!=''){
				EnBacLib::CheckDir(DIR_CACHE.'html/'.$subDir.'/');
				$filePath=$subDir.'/'.$filePath;
			}
			else{
				EnBacLib::CheckDir(DIR_CACHE.'html/');
			}
			
			self::$curentCacheFilePath	= DIR_CACHE.'html/'.$filePath.'.html';
			self::$curentExpTime		= $exp_time;
			
			if (isset($_GET['delscache']) && (int)$_GET['delscache']=='1'){
				self::delCache($filePath);
				return true;
			}
			
			if (file_exists(self::$curentCacheFilePath)){
				if($exp_time>0){
					$filemtime= filemtime(self::$curentCacheFilePath);
					if(TIME_NOW > $filemtime+$exp_time){
						return true;	
					}
				}
				else{
					$filemtime = 0;
				}
				
				if(is_debug()){
					self::$cNum++;
					self::$pNum++;
					
					if(class_exists('Module') && Module::$name!=''){
						$module_name = Module::$name;
					}
					else{								
						$module_name = "-- Enbac system";
					}
					
					$info="<b>".$module_name."</b><br /><font color=red><b>".self::$curentCacheFilePath."</b></font><br /><b>Cache Time:</b> ".$exp_time."s ";
					
					
					
					$info.="<b>Created:</b> ".date('d/m/Y H:i:s',$filemtime);
					if($exp_time>0)
						$info.="<b> Expire:</b> ".date('d/m/Y H:i:s',$filemtime + $exp_time);
					else
						$info.="<b> Expire:</b> forever";
					
					self::$cacheFilesList.="<li>".$info."</li>";
				}
				
				if(self::$handleContent){
					self::$curentContent= file_get_contents(self::$curentCacheFilePath);
				}
				else 
					echo file_get_contents(self::$curentCacheFilePath);
				return false;
			}
		}
		return true;
	}
	
	//Bat dau cache 
	static function delCache($cache_file='',$ext='html'){
		if($cache_file!=''){
			if(MEMCACHE_ON){
  				eb_memcache::do_remove("scache:$cache_file");
  			}
  			else{
				if(is_array(CGlobal::$my_server)){
					foreach (CGlobal::$my_server as $server){
						$link = "http://{$server}/?trigger=1&cache_file={$cache_file}&ext={$ext}";	
						
						if(@fopen($link,"r")){
							//if(DEBUG){echo "run service in $link<br>";}					
						}
						else{
							if(is_debug()){echo "error in $link<br>";}	
						}
					}				
				}
  			}
			return true;
  		}
		//trigger delscache
		elseif(isset($_REQUEST['trigger'],$_REQUEST['ext'],$_REQUEST['cache_file']) && $_REQUEST['trigger'] && $_REQUEST['cache_file'] && $_REQUEST['ext']){
			
			$file_path  = $_REQUEST['cache_file'];
			
			$cache_file = $file_path.'.'.$_REQUEST['ext'];
			
			@unlink(DIR_CACHE.'html/'.$cache_file);
			
			if(MEMCACHE_ON){
				eb_memcache::do_remove("scache:$file_path");			
			}
			
			if(is_debug()){
				echo "Deleted HTML cache file: {$cache_file}";
			}
			exit;
		}
		
	}
  	  
	static function startCache(){
		//if(CACHE_ON)
		ob_start();
	}
	
	/* Ket thuc cache 
		$filePath: Neu truyen vao file name, ham se sinh ra file cache, dong thoi output content
		Neu $filePath=false: chi output noi dung, ko ghi file
	*/
	static function endCache($return=false){
		//if(!CACHE_ON)
		//return ;
		
		self::$curentContent=ob_get_contents();
		ob_end_clean();
		
		if(CACHE_ON){
			if(MEMCACHE_ON){
				if(self::$curentCacheFilePath!=''){
					$arr = array(
								'content'  => self::$curentContent,	
								'exp_time' => self::$curentExpTime + TIME_NOW
								);
					
					eb_memcache::do_put("scache:".self::$curentCacheFilePath, serialize($arr));
					
					if(is_debug()){
						self::$pNum++;if(class_exists('Module'))
						if(class_exists('Module') && Module::$name!=''){
							$module_name = Module::$name;
						}
						else{								
							$module_name = "-- Enbac system";
						} 
						
						$info="<b>".$module_name."</b><br /><font color=red><b>scache:".self::$curentCacheFilePath."</b></font><br /><b>Created:</b> ".date('d/m/Y H:i:s',TIME_NOW)." <b>Expire:</b> ".(self::$curentExpTime?date('d/m/Y H:i:s',self::$curentExpTime+TIME_NOW):'Forever');
						self::$cacheFilesList.="<li>".$info."</li>";
					}
					
					self::$curentCacheFilePath		='';
					self::$curentExpTime			=0;
				}
				else{
					if(is_debug()){
						self::$pNum++;
						
						if(class_exists('Module') && Module::$name!=''){
							$module_name = Module::$name;
						}
						else{								
							$module_name = "-- Enbac system";
						} 
						
						$info="<b>".$module_name."</b><br /><font color=red><b>No file</b></font><br />";
						self::$cacheFilesList.="<li>".$info."</li>";
					}
					self::$curentExpTime = 0;
				}
			}
			else{
				if(self::$curentCacheFilePath!=''){
					@file_put_contents(self::$curentCacheFilePath,self::$curentContent);
					if(is_debug()){
						self::$pNum++;
						if(class_exists('Module') && Module::$name!=''){
							$module_name = Module::$name;
						}
						else{								
							$module_name = "-- Enbac system";
						}
						
						$info="<b>".$module_name."</b><br /><font color=red><b>".self::$curentCacheFilePath."</b></font><br /><b>Created:</b> ".date('d/m/Y H:i:s',TIME_NOW)." <b>Expire:</b> ".(self::$curentExpTime?date('d/m/Y H:i:s',self::$curentExpTime+TIME_NOW):'Forever');
						self::$cacheFilesList.="<li>".$info."</li>";
					}
					
					self::$curentCacheFilePath	= '';
					self::$curentExpTime		= 0;
				}
				else{
					if(is_debug()){
						self::$pNum++;
						
						if(class_exists('Module') && Module::$name!=''){
							$module_name = Module::$name;
						}
						else{								
							$module_name = "-- Enbac system";
						}
						
						$info="<b>".$module_name."</b><br /><font color=red><b>No file</b></font><br />";
						self::$cacheFilesList.="<li>".$info."</li>";
					}
					self::$curentExpTime			=0;
				}
			}
		}
		
		if($return)
			return self::$curentContent;
		elseif(!self::$handleContent)
			echo self::$curentContent;
		
		return true;
	}
}

/*
//Example
$filePath='cachTest.html';
if (getParam('cmd','')=='del_c')
	@unlink($filePath);
	
if (!self::existCache($filePath,1000))
{
	self::startCache();
	echo "Chào cả nhà nhé, tôi đi  <font color=red><b>chơi đây</b></font>";	
	self::endCache();
}
*/
?>