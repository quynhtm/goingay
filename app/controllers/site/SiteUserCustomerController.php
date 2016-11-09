<?php
/*
* @Created by: DUYNX
* @Author    : nguyenduypt86@gmail.com
* @Date      : 11/2016
* @Version   : 1.0
*/

class SiteUserCustomerController extends BaseSiteController{
    protected $user_customer = array();

	public function __construct(){
		parent::__construct();
		FunctionLib::site_css('libs/fontAwesome/4.2.0/css/font-awesome.min.css', CGlobal::$POS_HEAD);
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
    		return Redirect::route('site.home');
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
	    			$customer = UserCustomer::getUserCustomerByEmail($mail);
	    			if(sizeof($customer) > 0){
	    				if($customer->customer_status == CGlobal::status_hide || $customer->customer_status == CGlobal::status_block){
	    					$error = 'Tài khoản đang bị khóa!';
	    				}elseif($customer->customer_status == CGlobal::status_show){
	    					$encode_password = UserCustomer::encode_password($pass);
	    					if($customer->customer_password == $encode_password){
	    						$timeLogin = time();
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
    								'customer_time_login' => $timeLogin,
    								'customer_time_created' => $customer->customer_time_created,
    								'customer_time_active' => $customer->customer_time_active,
    								'is_customer' => $customer->is_customer,
    								'time_start_vip' => $customer->time_start_vip,
    								'time_end_vip' => $customer->time_end_vip,
    								'is_login' => 1,
    							);
	    						Session::put('user_customer', $data, 60*24);
	    						Session::save();
	    						
	    						$dataUpdate = array(
	    								'is_login'=>1,
	    								'customer_time_login'=>$timeLogin,
	    						);
	    						UserCustomer::updateData($customer->customer_id, $dataUpdate);
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
    	}
    	echo $error;die;
    }
    public function logout(){
    	if(Session::has('user_customer')){
    		$dataSess = Session::get('user_customer');
    		if(isset($dataSess['customer_id']) && (int)$dataSess['customer_id'] > 0){
    			$dataUpdate = array(
    					'is_login'=>0,
    					'customer_time_logout'=>time(),
    			);
    			UserCustomer::updateData($dataSess['customer_id'], $dataUpdate);
    		}
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
	    				'is_customer' => CGlobal::CUSTOMER_FREE,
	    				'customer_status'=>CGlobal::status_hide,
	    			);
	    			$id = UserCustomer::addData($data);
	    			//Send mail active
	    			if($id > 0){
	    				$key_secret = base64_encode($mail .'/'.$phone.'/'.$id);
	    				$emails = [$mail, CGlobal::emailAdmin];
	    				$dataTheme = array(
	    						'key_secret'=>$key_secret,
	    						'customer_email'=>$mail,
	    						'customer_password'=>$pass,
	    						'customer_name'=>$fullname,
	    				);
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
    		$error .= 'Phiên làm việc hết hạn. Bạn refresh lại trang web!';
    	}
    	echo $error;die;
    }
    public function pageActiveRegister(){
    	$key = Request::get('k', '');
    	if($key != ''){
    		$strKey = base64_decode($key);
    		$arrKey = explode('/', $strKey);
    		if(count($arrKey) == 3){
    			$customer_id =  (int)$arrKey[2];
    			$dataUpdate = array(
    					'customer_status'=>CGlobal::status_show,
    					'is_login'=>1,
    					'customer_time_active'=>time(),
    			);
    			UserCustomer::updateData($customer_id, $dataUpdate);
    			$customer = UserCustomer::getByID($customer_id);
    			if(sizeof($customer) > 0){
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
    				FunctionLib::messages('messages', 'Kích hoạt tài khoản thành công!', 'success');
    				return Redirect::route('site.home');
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
		$messages = FunctionLib::messages('messages');
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
						return Redirect::route('customer.pageChageInfo');
					}
				}else{
					$error .= 'Email của bạn không đúng!';
				}
			}
		}
		
		$this->layout->content = View::make('site.CustomerLayouts.EditCustomer')
								->with('member',$this->user_customer)
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