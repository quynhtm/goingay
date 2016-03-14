<?php
class BW{
	static function get_badword($update_cache = 0,$delcache = false){
		$badword = array();
		$subDir = 'badword';
		$badword = EBCache::cache('SELECT * FROM bad_words ORDER By exact DESC',__LINE__.__FILE__,86400,$update_cache,'',$subDir,$delcache);
		usort( $badword ,  array( 'BW', 'word_length_sort' ) );	
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
	
	static function check_badwords($str_check='', $return = false, $del_cache = false){
	
		if ($str_check == "" && !$del_cache){		
			return false;
		}	
	
		for( $i = 65; $i <= 90; $i++ ){
			$str_check = str_replace( "&#".$i.";", chr($i), $str_check );
		}
		
		for( $i = 97; $i <= 122; $i++ ){
			$str_check = str_replace( "&#".$i.";", chr($i), $str_check );
		}
				
		$str_check = strip_tags($str_check);						
				
		$matches=array();
		$check  =0;
		
		$arr_badword = BW::get_badword();
		
		if(!$del_cache){
					
			foreach($arr_badword as $badword){	
				$badword['contents'] = preg_quote($badword['contents']);
				$badword['contents'] = str_replace( array('\*','\?'), array('(.{0,4})','(.+)') , $badword['contents'] );			
				
				if($badword['exact']){
					if(preg_match( '#(^|\s|\b)'.$badword['contents'].'(\b|\s|!|\?|\.|,|$)#ui', $str_check,$match)){						
						if($return){
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
							$matches[]=$match[0];
						}
						else{
							return true;
						}
					}
				}
			}
			
			if($return && $check){
				return array(							
							'bad' =>implode(', ',$matches)
							);
			}
			else{
				return false;
			}
		}
	}		
}	
?>