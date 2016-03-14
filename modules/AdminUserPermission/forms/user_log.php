<?php
class UserLogForm extends Form{
	private $user = array();
	function UserLogForm(){
		Form::Form('UserLogForm');
		CGlobal::$website_title="Danh sách lỗi của thành viên";	
		$user_id = intval(Url::get('user_id'));
		
		if($user_id){
			$this->user = User::getUser($user_id);
		}
		else{
			Url::redirect_current();
		}
	}
	
	function draw(){
		global $display;
		
		$items = array();		
		$total = 0;
		
		if($this->user && isset($this->user['id'])){
			$sql = 'SELECT id, time, time_expire, user_name,type,note,admin_name,unlock_user,unlock_time FROM acc_lock WHERE user_id='.$this->user['id'].' ORDER BY time  DESC';
			$result = DB::query($sql);
			if($result){
				while ($row=mysql_fetch_assoc($result)){						
					$total++;
					$row['time'] 	=  date('d/m/y H:i',$row['time']);
					if($row['unlock_time'] )
						$row['unlock_time'] =  date('d/m/y H:i',$row['unlock_time']);
					
					if($row['time_expire'] )
						$row['time_expire'] =  date('d/m/y H:i',$row['time_expire']);
					else{
						$row['time_expire'] =  '';
					}
						
					$items[$row['id']]=$row;
				}		
			}
		}
		
		$display->add('total',$total);
		$display->add('user',$this->user);
		$display->add('items',$items);
		$display->output('user_log');	
	}
}
?>
