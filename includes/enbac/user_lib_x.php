<?php
class UserLib{
	static function sendPM4Friend($id,$user_id,$user_id_friend,$action = 'getFriend'){
		return true;
	}

	static function isUserOnline($user_id){				
		if((int)$user_id && User::is_login() && User::id()==$user_id){
			return true;
		}
		elseif ((int)$user_id){
					
			$sql = 'SELECT session_expires FROM '._SESS_TABLE.' WHERE user_id = '.(int)$user_id.' ORDER BY session_expires DESC LIMIT 0,1';			
			$re=DB::query($sql);		
			if($re){
				while ($ss=mysql_fetch_assoc($re)){
					if($ss['session_expires']>( TIME_NOW - 900 )){
						return true;
						break;
					}
				}
			}
		}
		return false;
	}
}
?>