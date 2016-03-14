<?php
class UserDetailForm extends Form
{
	private $user = array();
	function UserDetailForm(){
		Form::Form('UserDetailForm');
		
		CGlobal::$website_title="Thông tin thành viên";	
		
		$this->link_css('style/manage_content.css');
		$this->link_css('style/ui.datepicker.css');		
		$this->link_js('javascripts/jquery/ui.datepicker.js');	
		
		$user_id = (int)Url::get('id');
		
		if($user_id){//Xoá 1 thành viên
			$this->user = DB::select('account',"id=$user_id");
		}
		
		if(!$this->user){
			Url::redirect_current();
		}
	}
	
	function on_submit(){
		
	}	
	
	function draw(){
		global $display;
		$this->beginForm();		
		
		$user = $this->user;
		
		if($user['show_home_phone'] == 0){
			$user['show_home_phone'] = '';
		}	
		else{
			$user['show_home_phone'] = '(Đã ẩn)';
		}
		
		if($user['show_email'] == 0){
			$user['show_email'] = '';
		}	
		else{
			$user['show_email'] = '(Đã ẩn)';
		}
		
		if($user['email_alert'] == 0){
			$user['email_alert'] = '';
		}	
		else{
			$user['email_alert'] = '(Nhận email thông báo)';
		}
		
		if($user['birth_day']){
			$arrBirtday = explode('-',$user['birth_day']);
			$user['birth_day'] = $arrBirtday['2'].'-'.$arrBirtday['1'].'-'.$arrBirtday['0'];
		}				
								
	
		if($user['avatar_url']!=""){
			//$user['avatar_url'] = '<img src="'.EnBacLib::getImageThumb($user['avatar_url'],94,94).'" />';
		}
		else{
			$user['avatar_url'] = '<img src="style/images/no_avatar_item.gif" width="94" height="94" />';
		}
		
		$user['create_time'] = date('d/m/y H:i',$user['create_time']);
		$user['reg_ip'] = ($user['reg_ip']?"RegIP: <b>{$user['reg_ip']}</b>":'').($user['last_ip']?"LastIP: <b>{$user['last_ip']}</b>":'');

		if($user['block_time']>TIME_NOW || $user['block_time']==-1){
			if($user['block_time']!=-1){
				$user['status'] = "<font color=red><b>".date('H:i d/m/y',$user['block_time']).'</b></font>';
			}
			else{
				$user['status'] = '<font color=red><b>Khóa vĩnh viễn</b></font>';
			}
		}elseif ($user['invalid_time']) {
			$user['status'] = "<font color=red><b>Đang bị kiểm duyệt</b></font>";
		}
		else{
			$user['status'] = "Bình thường";
		}
		
		$display->add('msg',$this->showFormErrorMessages(1));
		$display->add('user',$user);
		
		$openids=array();
		
		$re=DB::query("SELECT id, openid_url FROM openid WHERE user_id=".$user['id']);
		if($re){
			while ($openid=mysql_fetch_assoc($re)){
				$openid['openid']=$openid['openid_url'];
				$openids[$openid['id']]=$openid;
			}
		}
		$display->add('openids',$openids);
		$display->add('user',$user);
				
		$display->output('UserDetail');	
			
		$this->endForm();
	}
}
?>
