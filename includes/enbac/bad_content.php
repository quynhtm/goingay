<?php
class BadContent{
	static function getBadContentItem($type,$id,$reason){	
				
		$href = CGlobal::$referer_url;
		
		if(!User::is_login()){
			return "not_login";
		}										
				
		if($type == "1"){
			if(BadContent::isNotice(User::$data['id'],1,$id)==0){
				$arr_data = array(
								'type' => 1,
								'id_item' => $id,
								'user_id' => User::$data['id'],
								'user_name' => User::$data['user_name'],
								'reason' => $reason,
								'time_post' => TIME_NOW
								);
				DB::insert('bad_content',$arr_data);
				return "success_bad";
			}
			else{
				return "fail_bad";
			}						
						
		}
		else{
			return "fail";
		}
	}
	
	static function isNotice($user_id,$type,$id){	
		if($user_id && $id){	
			$condition = 'user_id = '.(int)$user_id.' AND type = '.(int)$type.' AND id_item = '.(int)$id ;		
			return DB::count('bad_content',$condition);		
		}
		return 0;
	}
}
?>