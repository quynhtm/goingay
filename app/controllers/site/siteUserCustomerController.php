<?php
/*
* @Created by: DUYNX
* @Author    : nguyenduypt86@gmail.com
* @Date      : 11/2016
* @Version   : 1.0
*/

class SiteUserCustomerController extends BaseSiteController{
    protected $user_customer = array();
	private $arrStatusProduct = array(-1 => '---- Trạng thái sản phẩm----',CGlobal::status_show => 'Hiển thị',CGlobal::status_hide => 'Ẩn');
	private $arrTypePrice = array(CGlobal::TYPE_PRICE_NUMBER => 'Hiển thị giá bán', CGlobal::TYPE_PRICE_CONTACT => 'Liên hệ với shop');
	private $error = array();

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
		$this->menuLeft();
		
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
		$messages = FunctionLib::messages('messages');
		if(isset($_POST) && !empty($_POST)){
			$token = Request::get('_token', '');
			$mail = Request::get('sys_change_email', '');
			$pass = Request::get('sys_change_pass', '');
			$repass = Request::get('sys_change_re_pass', '');
			$hash_pass = '';
			if(Session::token() === $token){
				$session_member = $this->user_customer;
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
		
		if(Session::has('user_customer')){
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
    		$arrUser = UserCustomer::getUserCustomerByEmail($mail);
    		if(sizeof($arrUser) != 0){
    			//Send mail
    			$password = FunctionLib::randomString(5);
    			$customer_id = $arrUser->customer_id;
    			if($password != ''){
    				$dataUpdate = array(
    					'customer_password'=>UserCustomer::encode_password($password),
    				);
    				UserCustomer::updateData($customer_id, $dataUpdate);
    				//Send mail
    				$emails = [$mail, CGlobal::emailAdmin];
    				$dataTheme = array(
    						'customer_email'=>$mail,
    						'customer_name'=>$arrUser->customer_name,
    						'customer_password'=>$password,
    				);
    				Mail::send('emails.ForgetPass', array('data'=>$dataTheme), function($message) use ($emails){
    					$message->to($emails, 'mailUserCustomer')
    							->subject('Hướng dẫn thay đổi mật khẩu '.date('d/m/Y h:i',  time()));
    				});
    				echo 1; die;
    			}else{
    				$error = 'Không tồn tại chuỗi bảo mật!';
    			}
    		}
    	}else{
    		$error = 'Phiên làm việc hết hạn!';
    	}
    	
    	echo $error;die;
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
	public function getAddItem($item_id = 0){
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
			'lib/number/autoNumeric.js',
			'frontend/js/site.js',
		));

		CGlobal::$pageShopTitle = "Đăng tin| ".CGlobal::web_name;
		$product = array();
		$arrViewImgOther = array();
		$imagePrimary = $imageHover = '';

		//danh muc
		$arrCategory = Category::getAllParentCategoryId();
		$optionCategory = FunctionLib::getOption(array(-1=>'---Chọn danh mục----') + $arrCategory, -1);

		$optionStatusProduct = FunctionLib::getOption($this->arrStatusProduct,CGlobal::status_hide);
		$optionTypePrice = FunctionLib::getOption($this->arrTypePrice,CGlobal::TYPE_PRICE_NUMBER);

		$this->layout->content = View::make('site.CustomerLayouts.ItemEdit')
			->with('error', array())
			->with('item_id', $item_id)
			->with('user_shop', array())
			->with('data', $product)
			->with('arrViewImgOther', $arrViewImgOther)
			->with('imagePrimary', $imagePrimary)
			->with('imageHover', $imageHover)
			->with('optionCategory', $optionCategory)
			->with('optionStatusProduct', $optionStatusProduct)
			->with('optionTypePrice', $optionTypePrice);
		$this->footer();
	}
	public function getEditItem($item_id = 0){
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
		if(isset($this->user_shop->shop_id) && $this->user_shop->shop_id > 0 && $item_id > 0){
			$product = Product::getProductByShopId($this->user_shop->shop_id,$item_id);
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
						$url_thumb = ThumbImg::getImageThumb(CGlobal::FOLDER_PRODUCT, $item_id, $val, CGlobal::sizeImage_100);
						$url_thumb_content = ThumbImg::getImageThumb(CGlobal::FOLDER_PRODUCT, $item_id, $val, CGlobal::sizeImage_600);
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
			->with('item_id', $item_id)
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
	public function postEditItem($item_id = 0){
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

		$dataSave['item_name'] = addslashes(Request::get('item_name'));
		$dataSave['item_category_id'] = addslashes(Request::get('item_category_id'));
		$dataSave['item_status'] = addslashes(Request::get('item_status'));
		$dataSave['item_content'] = Request::get('item_content');
		$dataSave['item_type_price'] = addslashes(Request::get('item_type_price',CGlobal::TYPE_PRICE_NUMBER));
		$dataSave['item_price_sell'] = (int)str_replace('.','',Request::get('item_price_sell'));

		$dataSave['item_image'] = $imagePrimary = addslashes(Request::get('image_primary'));

		$id_hiden = Request::get('id_hiden',0);
		$item_id = ($item_id >0)? $item_id: $id_hiden;

		//danh muc san pham cua shop
		$arrCategory = Category::getAllParentCategoryId();

		//lay lai vi tri sap xep cua anh khac
		$arrInputImgOther = array();
		$getImgOther = Request::get('img_other',array());
		if(!empty($getImgOther)){
			foreach($getImgOther as $k=>$val){
				if($val !=''){
					$arrInputImgOther[] = $val;

					//show ra anh da Upload neu co loi
					$url_thumb = ThumbImg::getImageThumb(CGlobal::FOLDER_PRODUCT, $item_id, $val, CGlobal::sizeImage_100);
					$url_thumb_content = ThumbImg::getImageThumb(CGlobal::FOLDER_PRODUCT, $item_id, $val, CGlobal::sizeImage_600);
					$arrViewImgOther[] = array('img_other'=>$val,'src_img_other'=>$url_thumb,'src_thumb_content'=>$url_thumb_content);
				}
			}
		}
		if (!empty($arrInputImgOther) && count($arrInputImgOther) > 0) {
			//neu ko co anh chinh, lay anh chinh la cai anh dau tien
			if($dataSave['item_image'] == ''){
				$dataSave['item_image'] = $arrInputImgOther[0];
			}
			$dataSave['item_image_other'] = serialize($arrInputImgOther);
		}

		//FunctionLib::debug($dataSave);
		$this->validInforItem($dataSave);
		if(empty($this->error)){
			//lay tên danh mục
			$dataSave['item_category_name'] = isset($arrCategory[$dataSave['category_id']])?$arrCategory[$dataSave['category_id']]: '';
			$dataSave['customer_id'] = $this->user_customer['customer_id'];
			$dataSave['customer_name'] = $this->user_customer['customer_name'];
			$dataSave['is_customer'] = $this->user_customer['is_customer'];
			$dataSave['item_province_id'] = $this->user_customer['customer_province_id'];
			$dataSave['item_district_id'] = $this->user_customer['customer_district_id'];
			$dataSave['item_block'] = CGlobal::PRODUCT_NOT_BLOCK;
			$dataSave['time_update'] = time();
			if($item_id > 0){
				$items = array();
				if(isset($this->user_customer['customer_id']) && $this->user_customer['customer_id'] > 0 && $item_id > 0){
					$items = Items::getItemByCustomerId($this->user_customer['customer_id'], $item_id);
				}
				if(!empty($items)){
					if($item_id > 0){//cap nhat
						if(Items::updateData($item_id,$dataSave)){
							return Redirect::route('customer.ItemsList');
						}
					}
				}else{
					return Redirect::route('customer.ItemsList');
				}
			}
			//tạo mới
			else{
				$dataSave['time_created'] = time();
				if(Items::addData($dataSave)){
					return Redirect::route('customer.ItemsList');
				}
			}
		}
		//FunctionLib::debug($dataSave);
		$optionCategory = FunctionLib::getOption(array(-1=>'---Chọn danh mục----') + $arrCategory,$dataSave['item_category_id']);
		$optionStatusProduct = FunctionLib::getOption($this->arrStatusProduct,$dataSave['item_status']);
		$optionTypePrice = FunctionLib::getOption($this->arrTypePrice,$dataSave['item_type_price']);

		$this->layout->content = View::make('site.CustomerLayouts.ItemEdit')
			->with('error', $this->error)
			->with('item_id', $item_id)
			->with('user_customer',$this->user_customer)
			->with('data', $dataSave)
			->with('arrViewImgOther', $arrViewImgOther)
			->with('imagePrimary', $imagePrimary)
			->with('imageHover', $imageHover)
			->with('optionCategory', $optionCategory)
			->with('optionStatusProduct', $optionStatusProduct)
			->with('optionTypePrice', $optionTypePrice);
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