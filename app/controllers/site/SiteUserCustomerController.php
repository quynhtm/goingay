<?php
/*
* @Created by: DUYNX
* @Author    : nguyenduypt86@gmail.com
* @Date      : 06/2016
* @Version   : 1.0
*/

class SiteUserCustomerController extends BaseSiteController{
    protected $user_customer = array();

	public function __construct(){
		parent::__construct();
		FunctionLib::site_js('frontend/js/site.js', CGlobal::$POS_END);
		FunctionLib::site_js('frontend/js/usercustomer.js', CGlobal::$POS_END);
        FunctionLib::site_css('frontend/css/usercustomer.css', CGlobal::$POS_HEAD);
		
		if(Session::has('user_customer')){
			$this->user_customer = Session::get('user_customer');
		}
	}
	//Register - Login
    public function pageLogin($url=''){
    	
    	if(Session::has('user_customer')){
    		return Redirect::route('site.index');
    	}
    	
    	$token = addslashes(Request::get('token', ''));
    	$mail = addslashes(Request::get('sys_login_mail', ''));
    	$pass = addslashes(Request::get('sys_login_pass', ''));
    	$error = '';
    	if(Session::token() === $token){
	    	if($mail != '' && $pass != ''){
	    		$checkMail = ValidForm::checkRegexEmail($mail);
				if(!$checkMail) {
	    			$error = 'Email đăng nhập không đúng!';
	    		}else{
	    			$member = Member::getMemberByEmail($mail);
	    			if($member != ''){
	    				if($member->member_status == 0 || $member->member_status == -1){
	    					$error = 'Tài khoản đang bị khóa!';
	    				}elseif($member->member_status == 1){
	    					$encode_password = Member::encode_password($pass);
	    					if($member->member_pass == $encode_password){
	    						$data = array(
		    								'member_id' => $member->member_id,
	    									'member_full_name' => $member->member_full_name,
	    									'member_phone' => $member->member_phone,
		    								'member_mail' => $member->member_mail,
	    									'member_address' => $member->member_address,
	    									'member_status' => $member->member_status,
	    									'member_created' => $member->member_created,
	    								);
	    						Session::put('member', $data, 60*24);
	    						Session::save();
	    						Member::updateLogin($member);
	    					}else{
	    						$error = 'Mật khẩu chưa đúng!';
	    					}
	    				}
	    			}else{
	    				$error = 'Không tồn tại tên đăng nhập!';
	    			}
	    		}
	    	}else{
	    		$error = 'Thông tin đăng nhập chưa đúng!';
	    	}
    	}else{
    		$error = 'Phiên làm việc hết hạn!';
    		return Redirect::route('site.index');
    	}
    	echo $error;die;
    }
    public function logout(){
    	if(Session::has('user_customer')){
        	Session::forget('user_customer');
        }
        return Redirect::route('site.home');
    }
    public function pageRegister(){
    	
    	if(Session::has('user_customer')){
    		return Redirect::route('site.home');
    	}
    	
    	$token = addslashes(Request::get('token', ''));
    	$mail = addslashes(Request::get('sys_reg_email', ''));
    	$pass = addslashes(Request::get('sys_reg_pass', ''));
    	$repass = addslashes(Request::get('sys_reg_re_pass', ''));
    	$fullname = addslashes(Request::get('sys_reg_full_name', ''));
    	$phone = addslashes(Request::get('sys_reg_phone', ''));
    	$address = addslashes(Request::get('sys_reg_address', ''));
    	$error = '';
    	$hash_pass = '';
    	if(Session::token() === $token){
    		//Mail
    		if($mail != ''){
	    		$checkMail = ValidForm::checkRegexEmail($mail);
	    		if(!$checkMail) {
	    			$error .= 'Email đăng nhập không đúng!';
	    		}
    		}else{
    			$error .= 'Email đăng nhập không được trống!';
    		}
    		//Pass
    		if($pass != '' && ($pass === $repass)){
    			$check_valid_pass = ValidForm::checkRegexPass($pass, 5);
    			if($check_valid_pass){
    				$hash_pass = UserCustomer::encode_password($pass);
    			}else{
    				$error .= 'Mật không được ít hơn 5 ký tự và không được có dấu!'.'<br/>';
    			}
    		}
    		if($pass == '' && $repass == ''){
    			$error .= 'Mật khẩu không được trống!'.'<br/>';
    		}elseif($pass != $repass){
    			$error .= 'Mật khẩu không khớp!'.'<br/>';
    		}
    		
    		//Check Member Exists
    		$check = UserCustomer::getUserCustomerByEmail($mail);
    		if(sizeof($check) != 0){
    			$error .= 'Email đăng nhập này đã tồn tại!'.'<br/>';
    		}
    		if($mail != '' && $pass != '' && $repass != '' && $fullname != '' && $phone != '' && $address != ''){
    			if($error == ''){
	    			$data = array(
	    				'customer_email'=>$mail,
	    				'customer_password'=>$hash_pass,
	    				'customer_name'=>$fullname,
	    				'customer_phone'=>$phone,
	    				'customer_address'=>$address,
	    				'customer_time_created'=>time(),
	    				'customer_status'=>CGlobal::status_block,
	    			);
	    			$id = UserCustomer::addData($data);
	    			//Send mail active
	    			$key_secret = base64_encode($mail .'/'.$phone);
	    			if($key_secret != '' && $id > 0){
	    				$emails = [$mail, CGlobal::emailAdmin];
	    				$dataTheme = array(
	    						'key_secret'=>$key_secret,
	    						'customer_email'=>$mail,
	    						'customer_password'=>$pass,
	    						'customer_name'=>$fullname,
	    				);
	    				$dataActive = array(
    									'customer_id'=>$id,
    									'key_secret'=>$key_secret,
    								);
	    				Session::put('customer_active_code_register', $dataActive, 5);
	    				Session::save();
	    			
	    				Mail::send('emails.userCustomerRegister', array('data'=>$dataTheme), function($message) use ($emails){
	    					$message->to($emails, 'user_customer')
	    							->subject('Kích hoạt tài khoản trên website '.CGlobal::web_name.' '.date('d/m/Y h:i',  time()));
	    				});
	    			}
    			}
    		}else{
    			$error .= 'Thông tin đăng ký chưa đầy đủ!';
    		}
    	}else{
    		$error .= 'Phiên làm việc hết hạn!';
    		return Redirect::route('site.home');
    	}
    	echo $error;die;
    }
    public function pageActiveRegister(){
    	$key = Request::get('k', '');
    	if(Session::has('customer_active_code_register')){
    		if($key != ''){
    			$dataActive = Session::get('customer_active_code_register');
    			if(sizeof($dataActive) > 0){
    				if(isset($dataActive['key_secret']) && $dataActive['key_secret'] == $key){
    					$dataUpdate = array(
    							'customer_status'=>CGlobal::status_show,
    							'is_login'=>1,
    							'customer_time_active'=>time(),
    					);
    					if(isset($dataActive['customer_id'])){
    						UserCustomer::updateData((int)$dataActive['customer_id'], $dataUpdate);
    						$customer = UserCustomer::getByID((int)$dataActive['customer_id']);
    						$data = array(
    								'customer_id' => $customer->customer_id,
    								'customer_name' => $customer->customer_name,
    								'customer_phone' => $customer->customer_phone,
    								'customer_address' => $customer->customer_address,
    								'customer_email' => $customer->customer_email,
    								'customer_province' => $customer->customer_province,
    								'customer_about' => $customer->customer_about,
    								'customer_status' => $customer->customer_status,
    								'customer_up_item' => $customer->customer_up_item,
    								'customer_time_login' => $customer->customer_time_login,
    								'customer_time_created' => $customer->customer_time_created,
    								'customer_time_active' => $customer->customer_time_active,
    								'is_customer' => $customer->is_customer,
    								'time_start_vip' => $customer->time_start_vip,
    								'time_end_vip' => $customer->time_end_vip,
    								'is_login' => $customer->is_login,
    						);
    						Session::put('user_customer', $data, 60*24);
    						Session::save();
    						return Redirect::route('site.home');
    					}
    				}
    			}
    		}
    	}
    	echo "Liên kết kích hoạt tài khoản không đúng!";die;
    }
	//Change Info - Chage Pass
	public function pageChageInfo(){
		if(!Session::has('user_customer')){
			return Redirect::route('site.home');
		}
		$this->header();
		
		$error = '';
		$messages = Utility::messages('messages');
		if(isset($_POST) && !empty($_POST)){
			$token = Request::get('_token', '');
			$mail = Request::get('sys_change_email', '');
			$full_name = Request::get('sys_change_full_name', '');
			$phone = Request::get('sys_change_phone', '');
			$address = Request::get('sys_change_address', '');
			
			if(Session::token() === $token){
				$session_member = $this->member;
				$sessionMail = $session_member['member_mail'];
				if($sessionMail == $mail){
					if($mail != '' && $full_name != '' && $phone !='' && $address != ''){
						$data = array(
								'member_full_name' =>$full_name,
								'member_phone' =>$phone,
								'member_address' =>$address,
								);
						Member::updateData($session_member['member_id'], $data);
						Utility::messages('messages', 'Thay đổi thông tin thành công', 'success');
						//Upate Session
						$dataSess = array(
								'member_id' => $session_member['member_id'],
								'member_mail'=>$mail,
								'member_full_name'=>$full_name,
								'member_phone'=>$phone,
								'member_address'=>$address,
								'member_created'=>$session_member['member_created'],
								'member_status'=>$session_member['member_status'],
						);
						Session::put('member', $dataSess, 60*24);
						Session::save();
						$this->member = $dataSess;
						return Redirect::route('member.pageChageInfo');
					}
				}else{
					$error .= 'Email của bạn không đúng!';
				}
			}
		}
		
		$this->layout->content = View::make('site.member.pageChageInfo')
								->with('member',$this->member)
								->with('error',$error)
								->with('messages',$messages);
		$this->footer();
	}
	public function pageChagePass(){
		if(!Session::has('member')){
			return Redirect::route('site.index');
		}
		$this->header();
		
		$error = '';
		$messages = Utility::messages('messages');
		if(isset($_POST) && !empty($_POST)){
			$token = Request::get('_token', '');
			$mail = Request::get('sys_change_email', '');
			$pass = Request::get('sys_change_pass', '');
			$repass = Request::get('sys_change_re_pass', '');
			$hash_pass = '';
			if(Session::token() === $token){
				$session_member = $this->member;
				$sessionMail = $session_member['member_mail'];
				if($sessionMail == $mail){
					//Pass
					if($pass != '' && ($pass === $repass)){
						$check_valid_pass = ValidForm::checkRegexPass($pass, 5);
						if($check_valid_pass){
							$hash_pass = Member::encode_password($pass);
						}else{
							$error .= 'Mật không được ít hơn 5 ký tự và không được có dấu!'.'<br/>';
						}
					}
					if($pass == '' && $repass == ''){
						$error .= 'Mật khẩu không được trống!'.'<br/>';
					}elseif($pass != $repass){
						$error .= 'Mật khẩu không khớp!'.'<br/>';
					}
					
					if($mail != '' && $pass != '' && $repass !=''){
						if($error == ''){
							$data = array(
									'member_pass' =>$hash_pass,
									);
							Member::updateData($session_member['member_id'], $data);
							Utility::messages('messages', 'Thay đổi mật khẩu thành công', 'success');
							//Upate Session
							$dataSess = array(
									'member_id' => $session_member['member_id'],
									'member_mail'=>$mail,
									'member_full_name'=>$session_member['member_full_name'],
									'member_phone'=>$session_member['member_phone'],
									'member_address'=>$session_member['member_address'],
									'member_created'=>$session_member['member_created'],
									'member_status'=>$session_member['member_status'],
							);
							Session::put('member', $dataSess, 60*24);
							Session::save();
							$this->member = $dataSess;
							return Redirect::route('member.pageChagePass');
						}
					}
				}else{
					$error .= 'Email của bạn không đúng!';
				}
			}
		}
		
		$this->layout->content = View::make('site.member.pageChagePass')
								->with('member',$this->member)
								->with('error',$error)
								->with('messages',$messages);
		$this->footer();
	}
	public function pageForgetPass(){
		
		if(Session::has('member')){
    		return Redirect::route('site.index');
    	}
    	
    	$token = addslashes(Request::get('token', ''));
    	$mail = addslashes(Request::get('sys_forget_mail', ''));
 
    	if(Session::token() === $token){
    		if($mail != ''){
    			$checkMail = ValidForm::checkRegexEmail($mail);
    			if(!$checkMail) {
    				$error .= 'Email đăng nhập không đúng!';
    			}
    		}else{
    			$error .= 'Email đăng nhập không được trống!';
    		}
    		//Check mail exists
    		$arrUser = Member::getMemberByEmail($mail);
    		if(sizeof($arrUser) != 0){
    			//Send mail
    			$key_secret = Utility::randomString(32);
    			if($key_secret != ''){
    				$emails = [$mail, CGlobal::emailAdmin];
    				$dataTheme = array(
    						'key_secret'=>$key_secret,
    						'phone_support'=>CGlobal::phoneSupport,
    						'domain'=>CGlobal::domain,
    				);
    				
    				$data_session = array(
    						'key_secret'=>$key_secret,
    						'mail'=>$mail,
    				);
    				$data_session = serialize($data_session);
	    			Session::put('get_new_forget_pass', $data_session, 5);
	    			Session::save();
	    			
    				Mail::send('site.member.mailTempForgetPass', array('data'=>$dataTheme), function($message) use ($emails){
    					$message->to($emails, 'Member')
    							->subject('Hướng dẫn thay đổi mật khẩu '.date('d/m/Y h:i',  time()));
    				});
    				echo 1; die;
    			}else{
    				$error = 'Không tồn tại chuỗi bảo mật!';
    			}
    		}
    	}else{
    		$error = 'Phiên làm việc hết hạn!';
    		return Redirect::route('site.index');
    	}
    	
    	echo $error;die;
	}
	public function pageGetForgetPass(){
		if(!Session::has('get_new_forget_pass')){
			return Redirect::route('site.index');
		}
		$sessionGetNewPass = Session::get('get_new_forget_pass');
		$arrSession = unserialize($sessionGetNewPass);
		$error = '';
		if(empty($arrSession)){
			return Redirect::route('site.index');
		}
		$key_secret = $arrSession['key_secret'];
		$mail = $arrSession['mail'];
		//Post
		if(isset($_POST) && !empty($_POST)){
			$token = Request::get('_token', '');
			$pass = Request::get('sys_change_new_pass', '');
			$repass = Request::get('sys_change_new_re_pass', '');
			$hash_pass = '';
				
			if(Session::token() === $token){
				if($mail != ''){
					if($pass != '' && ($pass === $repass)){
						$check_valid_pass = ValidForm::checkRegexPass($pass, 5);
						if($check_valid_pass){
							$hash_pass = Member::encode_password($pass);
						}else{
							$error .= 'Mật không được ít hơn 5 ký tự và không được có dấu!'.'<br/>';
						}
					}
					if($pass == '' && $repass == ''){
						$error .= 'Mật khẩu không được trống!'.'<br/>';
					}elseif($pass != $repass){
						$error .= 'Mật khẩu không khớp!'.'<br/>';
					}
		
					if($pass != '' && $repass !=''){
		
						//Check mail exists
						$arrUser = Member::getMemberByEmail($mail);
						if(sizeof($arrUser) == 0){
							$error .= 'Email đăng nhập không tồn tại!'.'<br/>';
						}
		
						if($error == ''){
							$data = array(
									'member_pass' =>$hash_pass,
							);
							Member::updateData($arrUser->member_id, $data);
							Utility::messages('messages', 'Thay đổi mật khẩu thành công', 'success');
							//Upate Session
							$dataSess = array(
									'member_id' => $arrUser->member_id,
									'member_mail'=>$mail,
									'member_full_name'=>$arrUser->member_full_name,
									'member_phone'=>$arrUser->member_phone,
									'member_address'=>$arrUser->member_address,
									'member_created'=>$arrUser->member_created,
									'member_status'=>$arrUser->member_status,
							);
								
							Session::forget('get_new_forget_pass');
							Session::put('member', $dataSess, 60*24);
							Session::save();
								
							return Redirect::route('member.pageChageInfo');
						}
					}
				}else{
					$error .= 'Email của bạn không đúng!';
				}
			}
		}
		//Get
		$key = addslashes(Request::get('k', ''));
		if($key != ''){
			if($key_secret != $key){
				return Redirect::route('site.index');
			}
			
		}
		
		$this->header();
		$this->layout->content = View::make('site.member.pageGetNewPass')
								->with('error', $error);
		$this->footer();
	}
}