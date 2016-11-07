<?php
/*
* @Created by: DUYNX
* @Author    : nguyenduypt86@gmail.com
* @Date      : 06/2016
* @Version   : 1.0
*/

class SiteUserCustomerController extends BaseSiteController{
    protected $userCustomer = array();
    private $arrStatus = array(
    		-1 => '---Chọn trạng thái---',
    		0 => 'Chưa kiểm duyệt',
    		1 => 'Đã kiểm duyệt',
    		2 => 'Hủy đơn hàng',
    		3 => 'Đã gửi',
    		4 => 'Bị trả',
    		5 => 'Đã thu tiền',
    		6 => 'Đã lấy hàng hoàn',
    );
	public function __construct(){
		parent::__construct();
		FunctionLib::site_js('frontend/js/site.js', CGlobal::$POS_END);
		FunctionLib::site_js('frontend/js/usercustomer.js', CGlobal::$POS_END);
        FunctionLib::site_css('frontend/css/usercustomer.css', CGlobal::$POS_HEAD);
		
		if(Session::has('userCustomer')){
			$this->userCustomer = Session::get('userCustomer');
		}
	}
	//Register - Login
    public function pageLogin($url=''){
    	
    	if(Session::has('userCustomer')){
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
    	if(Session::has('member')){
        	Session::forget('member');
        }
        return Redirect::route('site.index');
    }
    public function pageRegister(){
    	
    	if(Session::has('userCustomer')){
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
	    				'customer_status'=>CGlobal::status_show,
	    			);
	    			$id = UserCustomer::addData($data);
	    			$data['customer_id'] = $id;
	    			Session::put('userCustomer', $data, 60*24);
	    			Session::save();
	    			$userCustomer = UserCustomer::getUserCustomerByEmail($mail);
	    			UserCustomer::updateLogin($userCustomer);
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
	//Change Info - Chage Pass
	public function pageChageInfo(){
		if(!Session::has('member')){
			return Redirect::route('site.index');
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
	public function pageHistoryOrder(){
		if(!Session::has('member')){
			return Redirect::route('site.index');
		}
		$session_member = $this->member;
		if($session_member['member_id'] > 0){
			Loader::loadCSS('libs/fontAwesome/4.2.0/css/font-awesome.min.css', CGlobal::$postHead);
			$this->header();
			//Config Page
			$pageNo = (int) Request::get('page', 1);
			$pageScroll = CGlobal::num_scroll_page;
			$limit = CGlobal::num_record_per_page;
			$offset = ($pageNo - 1) * $limit;
			$search = $data = array();
			$total = 0;
			$paging = '';
			$search['order_user_buy'] = (int)Request::get('order_user_buy', $session_member['member_id']);
			$search['field_get'] = 'order_id,order_title,order_phone,order_num,order_total,order_created,order_status';
			
			$dataSearch = Order::searchByCondition($search, $limit, $offset, $total);
			$paging = $total > 0 ? Pagging::getPager($pageScroll, $pageNo, $total, $limit, $search) : '';
			
			if(sizeof($dataSearch) != 0){
				foreach($dataSearch as $v){
					$data[] = array(
							'order_id'=>$v->order_id,
							'order_title'=>$v->order_title,
							'order_phone'=>$v->order_phone,
							'order_num'=>$v->order_num,
							'order_total'=>$v->order_total,
							'order_created'=>$v->order_created,
							'order_status'=>$v->order_status,
					
					);
				}
			}
			
			$this->layout->content = View::make('site.member.pageHistoryOrder')
									->with('data',$data)
									->with('paging',$paging)
									->with('arrStatus', $this->arrStatus);
			$this->footer();
		}else{
			return Redirect::route('site.index');
		}
	}
	public function pageHistoryViewOrder(){
		if(!Session::has('member')){
			return Redirect::route('site.index');
		}
		$html = '';
		$str_content = '';
		if(isset($_POST)){
			$session_member = $this->member;
			if($session_member['member_id'] > 0){
				$orderId = (int)Request::get('item', 0);
				if($orderId > 0){
					$data = Order::getById($orderId);
					$arrStatus = $this->arrStatus;
					if(sizeof($data) != 0){
						$order_content = $data->order_content;
						if($order_content != ''){
							$order_content = unserialize($order_content);
							if(is_array($order_content)){
								$str_content .= '<table class="content-order">';
								$str_content .= '<tr>
											<th width="1%">Mã[ID]</th>
				                    		<th width="50%">Tên Sản phẩm</th>
				                    		<th width="5%">Cỡ</th>
				                    		<th width="5%">SL</th>
				                    		<th width="10%">Giá</th>
										  </tr>';
								foreach($order_content as $item){
									$str_content .= '<tr>
											<td>'.$item['id'].'</td>
				                    		<td><a href="'.FuncLib::buildLinkDetailProduct($item['id'], $item['title']).'" target="_blank">'.$item['title'].'</a></td>
				                    		<td>'.$item['size'].'</td>
				                    		<td>'.$item['num'].'</td>
				                    		<td>'.FuncLib::numberFormat((int)$item['price']).'<sup>đ</sup></td>
										  </tr>';
								}
								$str_content .='<tr>
									            <td colspan="4"><b>Tổng số tiền mua hàng:</b></td>
									            <td colspan="1"><b>'.FuncLib::numberFormat((int)$data->order_total).'</b><sup>đ</sup></td>
									        </tr>';
								$str_content .= '<table>';
							}
						}
						
						
						$html .= '<div>1.Ngày tạo đơn: <b>'.date('d/m/Y h:i',$data->order_created).'</b></div>';
						$status = isset($arrStatus[$data->order_status]) ? $arrStatus[$data->order_status] : 'Chưa biết';
						$html .= '<div>2. Trạng thái: <b>'.$status.'</b></div></br>';
						
						$html .= '<div><b>Thông tin của bạn:</b></div>';
						$html .= '<div>1.Họ tên: <b>'.$data->order_title.'</b></div>';
						$html .= '<div>2.SĐT: <b>'.$data->order_phone.'</b></div>';
						$html .= '<div>3.Địa chỉ: <b>'.$data->order_address.'</b></div>';
						$html .= '<div>4.Yêu cầu: <br/>'.$data->order_note.'</div></br>';
						
						$html .= '<div><b>Thông tin đơn hàng:</b></div>';
						$html .= '<div>'.$str_content.'</div>';
					}
				}
			}
		}
		return json_encode($html);
	}
}