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
    					'customer_time_login'=>time(),
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
		if (!UserCustomer::isLogin()) {
			return Redirect::route('site.home');
		}
		$this->header();
		
		$messages = '';
		$this->user_customer = $dataShow = Session::get('user_customer');
		//FunctionLib::debug($customer);

		//khi sửa thông tin KH
		if(isset($_POST) && !empty($_POST) && !empty($this->user_customer)){
			$token = Request::get('_token', '');
			$dataUpdate['customer_name'] = Request::get('customer_name', '');
			$dataUpdate['customer_phone'] = Request::get('customer_phone', '');
			$customer_email = Request::get('customer_email', '');
			$dataUpdate['customer_show_email'] = Request::get('customer_show_email', 0);
			$dataUpdate['customer_address'] = Request::get('customer_address', '');
			$dataUpdate['customer_birthday'] = Request::get('customer_birthday', '');
			$dataUpdate['customer_about'] = Request::get('customer_about', '');
			$dataUpdate['customer_province_id'] = Request::get('customer_province_id', 0);
			$dataUpdate['customer_district_id'] = Request::get('customer_district_id', 0);
			$dataUpdate['customer_gender'] = Request::get('customer_gender', 0);

			$error = $this->validChageInfo($dataUpdate);
			if(Session::token() === $token){
				$sessionMail = isset($this->user_customer['member_mail']) ? $this->user_customer['member_mail']:'';
				if($sessionMail == $customer_email){
					if(!empty($error)){
						$messages = FunctionLib::alertMessage($error, 'error');
					}else{
						if(UserCustomer::updateData($this->user_customer['customer_id'],$dataUpdate)){
							$dataNew = UserCustomer::getByID($this->user_customer['customer_id']);
							Session::forget('user_customer');
							Session::put('user_customer', $dataNew, 60*24);
							Session::save();
							$messages = FunctionLib::alertMessage('Bạn đã cập nhật thành công!', 'success');
						}
					}
				}else{
					$messages = FunctionLib::alertMessage('Email của bạn không đúng!', 'error');
				}
			}
			$dataUpdate['customer_email'] = $customer_email;
			$dataShow = $dataUpdate;
		}
		$this->layout->content = View::make('site.CustomerLayouts.EditCustomer')
								->with('user_customer',$dataShow)
								->with('messages',$messages);
		$this->footer();
	}
	private function validChageInfo($data=array()) {
		$error = array();
		if(!empty($data)) {
			if(isset($data['customer_name']) && trim($data['customer_name']) == '') {
				$error[] = 'Tên khách hàng không được bỏ trống';
			}
			if(isset($data['customer_address']) && trim($data['customer_address']) == '') {
				$error[] = 'Địa chỉ không được bỏ trống';
			}
			if(isset($data['customer_phone']) && trim($data['customer_phone']) == '') {
				$error[] = 'Số điện thoại không được bỏ trống';
			}
		}
		return $error;
	}
	public function pageChagePass(){
		if (!UserCustomer::isLogin()) {
			return Redirect::route('site.home');
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
		if (!UserCustomer::isLogin()) {
			return Redirect::route('site.home');
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
		if (!UserCustomer::isLogin()) {
			return Redirect::route('site.home');
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

	//QuanLy tin dang cua khach
	public function itemsList(){
		if(!Session::has('user_customer')){
			return Redirect::route('site.home');
		}
		$this->header();

		CGlobal::$pageShopTitle = "Quản lý sản phẩm | ".CGlobal::web_name;
		$pageNo = (int) Request::get('page_no',1);
		$limit = CGlobal::number_limit_show;
		$offset = ($pageNo - 1) * $limit;
		$search = $data = array();
		$total = 0;

		$search['item_name'] = addslashes(Request::get('item_name',''));
		$search['customer_id'] = (isset($this->user_customer['customer_id']) && $this->user_customer['customer_id'] > 0)?(int)$this->user_customer['customer_id']: 0;//tìm theo khach
		//$search['field_get'] = 'order_id,order_product_name,order_status';//cac truong can lay

		//FunctionLib::debug($search);
		$dataSearch = (isset($this->user_customer['customer_id']) && $this->user_customer['customer_id'] > 0) ? Items::searchByCondition($search, $limit, $offset,$total): array();
		$paging = $total > 0 ? Pagging::getNewPager(3, $pageNo, $total, $limit, $search) : '';

		$this->layout->content = View::make('site.CustomerLayouts.ItemList')
			->with('paging', $paging)
			->with('stt', ($pageNo-1)*$limit)
			->with('total', $total)
			->with('sizeShow', count($data))
			->with('data', $dataSearch)
			->with('search', $search)
			->with('user_customer',$this->user_customer);
		$this->footer();
	}
	public function getAddItem($product_id = 0){
		if (!UserCustomer::isLogin()) {
			return Redirect::route('site.home');
		}
		$this->header();
		//Include style.
		FunctionLib::link_css(array(
			'lib/upload/cssUpload.css',
		));

		//Include javascript.
		FunctionLib::link_js(array(
			'lib/upload/jquery.uploadfile.js',
			'lib/ckeditor/ckeditor.js',
			'lib/ckeditor/config.js',
			'lib/dragsort/jquery.dragsort.js',
			'lib/number/autoNumeric.js',
			'frontend/js/site.js',
		));

		CGlobal::$pageShopTitle = "Thêm sản phẩm | ".CGlobal::web_name;
		$product = array();
		$arrViewImgOther = array();
		$imagePrimary = $imageHover = '';

		//danh muc san pham cua shop
		$arrCateShop = array();
		$optionCategory = FunctionLib::getOption(array(-1=>'---Chọn danh mục----') + $arrCateShop, -1);

		//danh sach NCC cua shop
		$arrNCC = array();
		//FunctionLib::debug($arrNCC);
		$optionNCC = FunctionLib::getOption(array(-1=>'---Chọn nhà cung cấp ----') + $arrNCC, -1);

		$optionStatusProduct = FunctionLib::getOption(array(),CGlobal::status_hide);
		$optionTypePrice = FunctionLib::getOption(array(),CGlobal::TYPE_PRICE_NUMBER);
		$optionTypeProduct = FunctionLib::getOption(array(),CGlobal::PRODUCT_NOMAL);
		$optionIsSale = FunctionLib::getOption(array(),CGlobal::PRODUCT_IS_SALE);

		$this->layout->content = View::make('site.CustomerLayouts.ItemEdit')
			->with('error', array())
			->with('product_id', $product_id)
			->with('user_shop', array())
			->with('data', $product)
			->with('arrViewImgOther', $arrViewImgOther)
			->with('imagePrimary', $imagePrimary)
			->with('imageHover', $imageHover)
			->with('optionCategory', $optionCategory)
			->with('optionNCC', $optionNCC)
			->with('optionStatusProduct', $optionStatusProduct)
			->with('optionTypePrice', $optionTypePrice)
			->with('optionIsSale', $optionIsSale)
			->with('optionTypeProduct', $optionTypeProduct);
		$this->footer();
	}
	public function getEditItem($product_id = 0){
		if (!UserCustomer::isLogin()) {
			return Redirect::route('site.home');
		}
		$this->header();
		//Include style.
		FunctionLib::link_css(array(
			'lib/upload/cssUpload.css',
		));

		//Include javascript.
		FunctionLib::link_js(array(
			'lib/upload/jquery.uploadfile.js',
			'lib/ckeditor/ckeditor.js',
			'lib/ckeditor/config.js',
			'lib/dragsort/jquery.dragsort.js',
			//'js/common.js',
			'lib/number/autoNumeric.js',
			'frontend/js/site.js',
		));

		CGlobal::$pageShopTitle = "Sửa sản phẩm | ".CGlobal::web_name;
		$product = array();
		$arrViewImgOther = array();
		$imagePrimary = $imageHover = '';
		if(isset($this->user_shop->shop_id) && $this->user_shop->shop_id > 0 && $product_id > 0){
			$product = Product::getProductByShopId($this->user_shop->shop_id,$product_id);
		}
		if(empty($product)){
			return Redirect::route('shop.listProduct');
		}

		//lấy ảnh show
		if(sizeof($product) > 0){
			//lay ảnh khác của san phẩm
			if(!empty($product->product_image_other)){
				$arrImagOther = unserialize($product->product_image_other);
				if(sizeof($arrImagOther) > 0){
					foreach($arrImagOther as $k=>$val){
						$url_thumb = ThumbImg::getImageThumb(CGlobal::FOLDER_PRODUCT, $product_id, $val, CGlobal::sizeImage_100);
						$url_thumb_content = ThumbImg::getImageThumb(CGlobal::FOLDER_PRODUCT, $product_id, $val, CGlobal::sizeImage_600);
						$arrViewImgOther[] = array('img_other'=>$val,'src_img_other'=>$url_thumb,'src_thumb_content'=>$url_thumb_content);
					}
				}
			}
			//ảnh sản phẩm chính
			$imagePrimary = $product->product_image;
			$imageHover = $product->product_image_hover;
		}

		$dataShow = array('product_id'=>$product->product_id,
			'product_name'=>$product->product_name,
			'category_id'=>$product->category_id,
			'provider_id'=>$product->provider_id,
			'product_price_sell'=>$product->product_price_sell,
			'product_price_market'=>$product->product_price_market,
			'product_price_input'=>$product->product_price_input,
			'product_type_price'=>$product->product_type_price,
			'product_selloff'=>$product->product_selloff,
			'product_is_hot'=>$product->product_is_hot,
			'is_sale'=>$product->is_sale,
			'product_code'=>$product->product_code,
			'product_sort_desc'=>$product->product_sort_desc,
			'product_content'=>$product->product_content,
			'product_image'=>$product->product_image,
			'product_image_hover'=>$product->product_image_hover,
			'product_image_other'=>$product->product_image_other,
			'product_order'=>$product->product_order,
			'quality_input'=>$product->quality_input,
			'product_status'=>$product->product_status);


		//danh muc san pham cua shop
		$arrCateShop = UserShop::getCategoryShopById($this->user_shop->shop_id);
		$optionCategory = FunctionLib::getOption(array(-1=>'---Chọn danh mục----') + $arrCateShop,isset($product->category_id)? $product->category_id: -1);

		//danh sach NCC cua shop
		$arrNCC = ($this->user_shop->is_shop == CGlobal::SHOP_VIP)?Provider::getListProviderByShopId($this->user_shop->shop_id): array();
		$optionNCC = FunctionLib::getOption(array(-1=>'---Chọn nhà cung cấp ----') + $arrNCC, isset($product->provider_id)? $product->provider_id:-1);

		$optionStatusProduct = FunctionLib::getOption($this->arrStatusProduct,isset($product->product_status)? $product->product_status:CGlobal::status_hide);
		$optionTypePrice = FunctionLib::getOption($this->arrTypePrice,isset($product->product_type_price)? $product->product_type_price:CGlobal::TYPE_PRICE_NUMBER);
		$optionTypeProduct = FunctionLib::getOption($this->arrTypeProduct,isset($product->product_is_hot)? $product->product_is_hot:CGlobal::PRODUCT_NOMAL);
		$optionIsSale = FunctionLib::getOption($this->arrIsSale,isset($product->is_sale)? $product->is_sale:CGlobal::PRODUCT_IS_SALE);

		$this->layout->content = View::make('site.CustomerLayouts.ItemEdit')
			->with('error', $this->error)
			->with('product_id', $product_id)
			->with('user_shop', $this->user_shop)
			->with('data', $dataShow)
			->with('arrViewImgOther', $arrViewImgOther)
			->with('imagePrimary', $imagePrimary)
			->with('imageHover', $imageHover)
			->with('optionCategory', $optionCategory)
			->with('optionNCC', $optionNCC)
			->with('optionStatusProduct', $optionStatusProduct)
			->with('optionTypePrice', $optionTypePrice)
			->with('optionIsSale', $optionIsSale)
			->with('optionTypeProduct', $optionTypeProduct);
		$this->footer();
	}
	public function postEditItem($product_id = 0){
		if (!UserCustomer::isLogin()) {
			return Redirect::route('site.home');
		}
		$this->header();
		//Include style.
		FunctionLib::link_css(array(
			'lib/upload/cssUpload.css',
		));

		//Include javascript.
		FunctionLib::link_js(array(
			'lib/upload/jquery.uploadfile.js',
			'lib/ckeditor/ckeditor.js',
			'lib/ckeditor/config.js',
			'lib/dragsort/jquery.dragsort.js',
			//'js/common.js',
			'lib/number/autoNumeric.js',
			'frontend/js/site.js',
		));

		CGlobal::$pageShopTitle = "Sửa sản phẩm | ".CGlobal::web_name;
		$shopVip = ( isset($this->user_shop->is_shop) && $this->user_shop->is_shop == CGlobal::SHOP_VIP)? 1: 0;
		$product = array();
		$arrViewImgOther = array();
		$imagePrimary = $imageHover = '';

		$dataSave['product_name'] = addslashes(Request::get('product_name'));
		$dataSave['category_id'] = addslashes(Request::get('category_id'));
		$dataSave['product_selloff'] = addslashes(Request::get('product_selloff'));
		$dataSave['product_status'] = addslashes(Request::get('product_status'));
		$dataSave['product_type_price'] = addslashes(Request::get('product_type_price',CGlobal::TYPE_PRICE_NUMBER));

		$dataSave['product_sort_desc'] = addslashes(Request::get('product_sort_desc'));
		$dataSave['product_content'] = Request::get('product_content');
		$dataSave['product_order'] = addslashes(Request::get('product_order'));
		$dataSave['quality_input'] = addslashes(Request::get('quality_input'));

		$dataSave['product_price_sell'] = (int)str_replace('.','',Request::get('product_price_sell'));
		$dataSave['product_price_market'] = (int)str_replace('.','',Request::get('product_price_market'));
		$dataSave['product_price_input'] = (int)str_replace('.','',Request::get('product_price_input'));

		$dataSave['product_image'] = $imagePrimary = addslashes(Request::get('image_primary'));
		$dataSave['product_image_hover'] = $imageHover = addslashes(Request::get('product_image_hover'));

		//danh cho shop VIP
		$dataSave['is_sale'] = ($shopVip == 1)? addslashes(Request::get('is_sale',CGlobal::PRODUCT_IS_SALE)): CGlobal::PRODUCT_IS_SALE;
		$dataSave['product_code'] = ($shopVip == 1)? addslashes(Request::get('product_code')): '';
		$dataSave['product_is_hot'] = ($shopVip == 1)? addslashes(Request::get('product_is_hot',CGlobal::PRODUCT_NOMAL)): CGlobal::PRODUCT_NOMAL;
		$dataSave['provider_id'] = ($shopVip == 1)? addslashes(Request::get('provider_id')): 0;

		//check lại xem SP co phai cua Shop nay ko
		$id_hiden = Request::get('id_hiden',0);
		$product_id = ($product_id >0)? $product_id: $id_hiden;

		//danh muc san pham cua shop
		$arrCateShop = UserShop::getCategoryShopById($this->user_shop->shop_id);

		//danh sach NCC cua shop
		$arrNCC = ($shopVip == 1)?Provider::getListProviderByShopId($this->user_shop->shop_id): array();

		//lay lai vi tri sap xep cua anh khac
		$arrInputImgOther = array();
		$getImgOther = Request::get('img_other',array());
		if(!empty($getImgOther)){
			foreach($getImgOther as $k=>$val){
				if($val !=''){
					$arrInputImgOther[] = $val;

					//show ra anh da Upload neu co loi
					$url_thumb = ThumbImg::getImageThumb(CGlobal::FOLDER_PRODUCT, $product_id, $val, CGlobal::sizeImage_100);
					$url_thumb_content = ThumbImg::getImageThumb(CGlobal::FOLDER_PRODUCT, $product_id, $val, CGlobal::sizeImage_600);
					$arrViewImgOther[] = array('img_other'=>$val,'src_img_other'=>$url_thumb,'src_thumb_content'=>$url_thumb_content);
				}
			}
		}
		if (!empty($arrInputImgOther) && count($arrInputImgOther) > 0) {
			//neu ko co anh chinh, lay anh chinh la cai anh dau tien
			if($dataSave['product_image'] == ''){
				$dataSave['product_image'] = $arrInputImgOther[0];
			}
			//neu ko co anh hove, lay anh hove la cai anh dau tien
			if($dataSave['product_image_hover'] == ''){
				$dataSave['product_image_hover'] = (isset($arrInputImgOther[1]))?$arrInputImgOther[1]:$arrInputImgOther[0];
			}
			$dataSave['product_image_other'] = serialize($arrInputImgOther);
		}

		//FunctionLib::debug($dataSave);
		$this->validInforProduct($dataSave);
		if(empty($this->error)){
			if($product_id > 0){
				if(isset($this->user_shop->shop_id) && $this->user_shop->shop_id > 0 && $product_id > 0){
					$product = Product::getProductByShopId($this->user_shop->shop_id, $product_id);
				}
				if(!empty($product)){
					if($product_id > 0){//cap nhat
						if($id_hiden == 0){
							$dataSave['time_created'] = time();
							$dataSave['time_update'] = time();
						}else{
							$dataSave['time_update'] = time();
						}
						//lay tên danh mục
						$dataSave['category_name'] = isset($arrCateShop[$dataSave['category_id']])?$arrCateShop[$dataSave['category_id']]: '';
						$dataSave['user_shop_id'] = $this->user_shop->shop_id;
						$dataSave['user_shop_name'] = $this->user_shop->shop_name;
						$dataSave['is_shop'] = $this->user_shop->is_shop;
						$dataSave['shop_province'] = $this->user_shop->shop_province;
						$dataSave['is_block'] = CGlobal::PRODUCT_NOT_BLOCK;

						if(Product::updateData($product_id,$dataSave)){
							return Redirect::route('shop.listProduct');
						}
					}
				}else{
					return Redirect::route('shop.listProduct');
				}
			}
			else{
				return Redirect::route('shop.listProduct');
			}
		}
		//FunctionLib::debug($dataSave);
		$optionNCC = FunctionLib::getOption(array(-1=>'---Chọn nhà cung cấp ----') + $arrNCC, $dataSave['provider_id']);
		$optionCategory = FunctionLib::getOption(array(-1=>'---Chọn danh mục----') + $arrCateShop,$dataSave['category_id']);
		$optionStatusProduct = FunctionLib::getOption($this->arrStatusProduct,$dataSave['product_status']);
		$optionTypePrice = FunctionLib::getOption($this->arrTypePrice,$dataSave['product_type_price']);
		$optionTypeProduct = FunctionLib::getOption($this->arrTypeProduct,$dataSave['product_is_hot']);
		$optionIsSale = FunctionLib::getOption($this->arrIsSale,$dataSave['is_sale']);

		$this->layout->content = View::make('site.CustomerLayouts.ItemEdit')
			->with('error', $this->error)
			->with('product_id', $product_id)
			->with('user_shop', $this->user_shop)
			->with('data', $dataSave)
			->with('arrViewImgOther', $arrViewImgOther)
			->with('imagePrimary', $imagePrimary)
			->with('imageHover', $imageHover)
			->with('optionCategory', $optionCategory)
			->with('optionNCC', $optionNCC)
			->with('optionStatusProduct', $optionStatusProduct)
			->with('optionTypePrice', $optionTypePrice)
			->with('optionIsSale', $optionIsSale)
			->with('optionTypeProduct', $optionTypeProduct);
		$this->footer();
	}
	private function validInforItem($data=array()) {
		if(!empty($data)) {
			if(isset($data['product_name']) && trim($data['product_name']) == '') {
				$this->error[] = 'Tên sản phẩm không được bỏ trống';
			}
			if(isset($data['product_image']) && trim($data['product_image']) == '') {
				$this->error[] = 'Chưa up ảnh sản phẩm';
			}
			if(isset($data['category_id']) && $data['category_id'] == -1) {
				$this->error[] = 'Chưa chọn danh mục';
			}
			if(isset($data['product_type_price']) && $data['product_type_price'] == CGlobal::TYPE_PRICE_NUMBER) {
				if(isset($data['product_price_sell']) && $data['product_price_sell'] <= 0) {
					$this->error[] = 'Chưa nhập giá bán';
				}
			}
			return true;
		}
		return false;
	}
}