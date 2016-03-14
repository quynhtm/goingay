<?php
class eb_memcache{
	static $identifier, $crashed = 0, $encoding_mode, $debug = 1;
	function eb_memcache(){}
	static function connect(){
		if(!CGlobal::$memcache_connect_id && !eb_memcache::$crashed){
			if( !function_exists('memcache_connect') ){			
				//dl("php_memcache.dll");
				//dl("php_xdebug.dll");
				eb_memcache::$crashed = 1;
				return FALSE;
			}
			
			eb_memcache::$identifier = 'boxmobi';
			
			if(!CGlobal::$memcache_server || !count(CGlobal::$memcache_server) ){
				eb_memcache::$crashed = 1;
				return FALSE;
			}
					
			if (DEBUG) {
				$rtime = microtime();
				$rtime = explode(" ",$rtime);
				$rtime = $rtime[1] + $rtime[0];
				$start_rb = $rtime;
			}
				
		    for ($i = 0, $n = count(CGlobal::$memcache_server); $i < $n; $i++){
		        $server = CGlobal::$memcache_server[$i];
		        if( $i < 1 ) {
		       		 CGlobal::$memcache_connect_id = memcache_connect($server['host'], $server['port']);
		        }
		        else {
					memcache_add_server( CGlobal::$memcache_connect_id, $server['host'], $server['port'] );	        	
		        }
		        
				if (DEBUG) { 
					$mtime = microtime();
					$mtime = explode(" ",$mtime);
					$mtime = $mtime[1] + $mtime[0];
					$end_rb = $mtime;			
					$load_time = round(($end_rb - $start_rb),5)."s";					 		
			    	CGlobal::$conn_debug.= " <b>Connect to Memcache server : {$server['host']} : {$server['port']} </b> [in $load_time]<br>\n";
				}
				        
		    }
		  
			if( !CGlobal::$memcache_connect_id ){
				eb_memcache::$crashed = 1;
				return FALSE;
			}
			
			if( function_exists('memcache_set_compress_threshold') ){
				memcache_set_compress_threshold( CGlobal::$memcache_connect_id, 20000, 0.2 );
			}
			
			//Dungbt them @
			@memcache_debug( eb_memcache::$debug );
		}
		return CGlobal::$memcache_connect_id;
	}
	
	
	static function disconnect(){
		if( CGlobal::$memcache_connect_id ){
			memcache_close( CGlobal::$memcache_connect_id );
		}
		
		return TRUE;
	}

	static function stats(){
		if(self::connect()){
			if( CGlobal::$memcache_connect_id ){
				return	memcache_get_stats( CGlobal::$memcache_connect_id );
			}
		}
		
		return TRUE;
	}
	
	/**
	 *@param int $ttl: thoi gian song cua memcached: tinh = giay 
	 */
	static function do_put( $key, $value, $ttl=0, $tag = '' ){
		$result = false;
		if(self::connect()){
			$result = memcache_replace(CGlobal::$memcache_connect_id, md5( eb_memcache::$identifier . $key ), eb_memcache::encode($value) );
			if( $result == false ){
			    //$result = $memcache->set( $key, $var );			
				$result = memcache_set( CGlobal::$memcache_connect_id, md5( eb_memcache::$identifier . $key ),
									eb_memcache::encode($value),
									MEMCACHE_COMPRESSED,
									intval($ttl) );
				if($result && $tag != '') {
					self::addMemcachedToTag($tag, $key);
				}
			}
		}
		return $result;
	}
	
	static function do_get( $key ){
		if(self::connect()){
			if (DEBUG) {
				$start_rb = microtime ( true );
			}
			
			$hash_key 	= md5( eb_memcache::$identifier . $key );
			$return_val = memcache_get( CGlobal::$memcache_connect_id, $hash_key);
	  		if($return_val){
				if(DEBUG){
					$end_rb = microtime ( true );
					$load_time = $end_rb - $start_rb;
					
					CGlobal::$memcache_time +=  $load_time;
					
					$load_time = round ( ($load_time), 5 ) . "s";
					
					if(isset($_REQUEST["level"]) && intval($_REQUEST["level"]) == 1){	      			
							CGlobal::$query_debug .= "<li> <span style='color:blue'>Memcache get $key in ($load_time);</span><br /><br />\n</li>";
					}
					else{
						CGlobal::$query_debug .= "<table width='95%' border='1' cellpadding='6' cellspacing='0' bgcolor='#FEFEFE'  align='center'>
											 <tr>
											  <td style='font-size:14px' bgcolor='#EFEFEF'><span style='color:blue'><b>Memcache</b></span></td>
											 </tr>
											 <tr>
											  <td style='font-family:courier, monaco, arial;font-size:14px;color:blue'>Memcache Get $key in  $load_time </td>
											 </tr>
											 <tr>
											  <td style='font-size:11px' bgcolor='#EFEFEF'>hash_key: $hash_key</td>
											 </tr>
											</table><br />\n\n";	     			
					}
					
					
				}
				return eb_memcache::decode($return_val);
	  		}
  		}
  		return false;		
	}
	
	static function do_remove( $key ){
		if(self::connect()){
			memcache_delete( CGlobal::$memcache_connect_id, md5( eb_memcache::$identifier . $key ) );
		}
	}
	
	static function clear(){
		if(self::connect()){
			memcache_flush (CGlobal::$memcache_connect_id );
		}
		return true;	    	    
    }

    static function encode($data){
    	return $data;/*
        if (eb_memcache::$encoding_mode == 'base64') { 
            return base64_encode(serialize($data));
        } else { 
            return serialize($data);
        }*/
    } 
    
    static function decode($data){
    	return $data;/*
        if (eb_memcache::$encoding_mode == 'base64') {
            return unserialize(base64_decode($data));
        } else {
            return unserialize($data);
        }*/
    }
    
    
	static function removeMemcacheByTags($key_tag) {
		$tags = eb_memcache::do_get($key_tag);
		if(!empty($tags) && is_array($tags)) {
			foreach($tags as $key_memcached) {
				eb_memcache::do_remove($key_memcached);
			}
		}
		return eb_memcache::do_put($key_tag , array());
	}
	
    
	
	static function addMemcachedToTag($key_tag, $key_memcached) {
		$tags = eb_memcache::do_get($key_tag);
					
		if(empty($tags) || !is_array($tags)) {
			$tags = array();
		}
		
		
		if(empty($tags) || !in_array($key_memcached, $tags)) {
			$tags[] = $key_memcached;
			eb_memcache::do_put($key_tag , $tags);
		}
		
		return true;		
	}
	

	static function removeMemcacheFromTags($key_tag, $key_memcached) {
		$tags = eb_memcache::do_get($key_tag);
		if(!empty($tags)) {
			$key = array_search($key_memcached, $tags);
			if((int)$key > 0) {
				unset($tags[$key]);
			}
		}
		return eb_memcache::do_put($key_tag , $tags);
	}
}
?>