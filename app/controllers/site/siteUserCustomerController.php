<?php
/*
* @Created by: DUYNX
* @Author    : nguyenduypt86@gmail.com
* @Date      : 11/2016
* @Version   : 1.0
*/
if(session_status() == PHP_SESSION_NONE){
	session_start();
}
class SiteUserCustomerController extends BaseSiteController{
    protected $user_customer = array();
	private $arrStatusProduct = array(-1 => '---- Trạng thái----',CGlobal::status_show => 'Hiển thị',CGlobal::status_hide => 'Ẩn');
	private $arrTypePrice = array(CGlobal::TYPE_PRICE_NUMBER => 'Hiển thị giá bán', CGlobal::TYPE_PRICE_CONTACT => 'Liên hệ với người đăng');
	private $arrTypeAction = array(CGlobal::ITEMS_TYPE_ACTION_1 => 'Cần bán/ Tuyển sinh', CGlobal::ITEMS_TYPE_ACTION_2 => 'Cần mua/ Tuyển dụng');
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

		//seo
		$meta_title = CGlobal::web_name;
		$meta_keywords = CGlobal::web_name;
		$meta_description = CGlobal::web_name;;
		$meta_img= '';
		FunctionLib::SEO($meta_img, $meta_title, $meta_keywords, $meta_description);
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
	    						Session::put('user_customer', $customer, 60*24);
	    						Session::save();
	    						$dataUpdate = array(
	    								'is_login'=>CGlobal::is_login,
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
    					'is_login'=>CGlobal::not_login,
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
    		if(sizeof($check) > 0){
    			$error .= 'Email đăng nhập này đã tồn tại!'.'<br/>';
    		}else{
				if($mail != '' && $pass != '' && $repass != '' && $fullname != '' && $phone != '' && $address != ''){
					if($error == ''){
						$data = array(
							'customer_email'=>$mail,
							'customer_password'=>$hash_pass,
							'customer_name'=>$fullname,
							'customer_phone'=>$phone,
							'customer_address'=>$address,
							'customer_time_created'=>time(),
							'is_login'=>1,
							'customer_time_login'=>time(),
							'is_customer' => CGlobal::CUSTOMER_FREE,
							'customer_status'=>CGlobal::status_show,
						);
						$id = UserCustomer::addData($data);
						//Send mail active
						if($id > 0){
							//tam thời cho login luôn
							$customer = UserCustomer::getByID($id);
							Session::put('user_customer', $customer, 60*24);
							Session::save();

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
    					'is_login'=>CGlobal::is_login,
    					'customer_time_active'=>time(),
    					'customer_time_login'=>time(),
    			);
    			UserCustomer::updateData($customer_id, $dataUpdate);
    			$customer = UserCustomer::getByID($customer_id);
    			if(sizeof($customer) > 0){
    				Session::put('user_customer', $customer, 60*24);
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
		$this->menuLeft();
		$dataNew = array();
		$messages = '';
		$this->user_customer = $dataShow = Session::get('user_customer');
		$customer_province_id = isset($this->user_customer['customer_province_id'])?$this->user_customer['customer_province_id']: 0;
		$customer_district = isset($this->user_customer['customer_district_id'])?$this->user_customer['customer_district_id']: 0;
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
				$sessionMail = isset($this->user_customer['customer_email']) ? $this->user_customer['customer_email']:'';
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
		
		//Banner Right
		$arrBannerRight = Banner::getBannerAdvanced(CGlobal::BANNER_TYPE_RIGHT, $banner_page = 0, $banner_category_id = 0, $banner_province_id = 0);
		//thong tin tinh thanh
		$province = Province::getAllProvince();
		$optionProvince = FunctionLib::getOption(array(0=>'---Chọn tỉnh thành----') + $province, $customer_province_id);
		$district = ($customer_province_id > 0)?Districts::getDistrictByProvinceId($customer_province_id): array();
		$optionDistrict = FunctionLib::getOption(array(0=>'---Chọn quận huyện----') + $district,$customer_district);

		$this->layout->content = View::make('site.CustomerLayouts.EditCustomer')
								->with('user_customer',$dataShow)
								->with('optionProvince',$optionProvince)
								->with('optionDistrict',$optionDistrict)
								->with('arrBannerRight',$arrBannerRight)
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
			if(isset($data['customer_province_id']) && trim($data['customer_province_id']) == 0) {
				$error[] = 'Bạn chưa chọn tỉnh thành';
			}
			if(isset($data['customer_district_id']) && trim($data['customer_district_id']) == 0) {
				$error[] = 'Bạn chưa chọn quận huyện';
			}
		}
		return $error;
	}
	//lay thong tin quận huyện cua KH
	public function getDistrictCustomer(){
		$data = array('isIntOk' => 0,'msg' => 'Không lấy được thông tin quận huyện');
		$customer_province_id = (int)Request::get('customer_province_id', 0);
		if ($customer_province_id > 0) {
			$district = Districts::getDistrictByProvinceId($customer_province_id);
			if(!empty($district)){
				$str_option = '<option value="">Chọn quận/huyện</option>';
				foreach($district as $dis_id =>$dis_name){
					$str_option .='<option value="'.$dis_id.'">'.$dis_name.'</option>';
				}
				$data['html_option'] = $str_option;
				$data['isIntOk'] = 1;
			}
		}
		return Response::json($data);
	}
	public function pageChagePass(){
		$data = array('isIntOk' => 0,'msg' => 'Không thay đổi được pass');
		if (!UserCustomer::isLogin()) {
			return Response::json($data);
		}
		$customer_password = trim(Request::get('customer_password', ''));
		if(!empty($this->user_customer) && $customer_password != ''){
			$dataUpdate['customer_password'] = UserCustomer::encode_password($customer_password);
			if(UserCustomer::updateData($this->user_customer['customer_id'],$dataUpdate)){
				//Send mail
				if($this->user_customer['customer_email'] != ''){
					$emails = [$this->user_customer['customer_email'], CGlobal::emailAdmin];
					$dataTheme = array(
						'customer_email'=>$this->user_customer['customer_email'],
						'customer_name'=>$this->user_customer['customer_name'],
						'customer_password'=>$customer_password,
					);
					Mail::send('emails.ForgetPass', array('data'=>$dataTheme), function($message) use ($emails){
						$message->to($emails, 'mailUserCustomer')
							->subject('Thay đổi mật khẩu tại '.date('d/m/Y h:i',  time()));
					});
					$data['isIntOk'] = 1;
					$data['msg'] = 'Đã cập nhật mật khẩu thành công';
					return Response::json($data);
				}
			}
		}
	}

	public function pageForgetPass(){
		if(Session::has('user_customer')){
    		return Redirect::route('site.home');
    	}
    	$token = addslashes(Request::get('token', ''));
    	$mail = addslashes(Request::get('sys_forget_mail', ''));
		$error = '';
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
		$this->menuLeft();
		
		CGlobal::$pageShopTitle = "Quản lý sản phẩm | ".CGlobal::web_name;
		$pageNo = (int) Request::get('page_no',1);
		$limit = CGlobal::number_limit_show;
		$offset = ($pageNo - 1) * $limit;
		$search = $data = array();
		$total = 0;

		$search['item_name'] = addslashes(Request::get('item_name',''));
		$search['item_status'] = addslashes(Request::get('item_status',-1));
		$search['item_type_action'] = addslashes(Request::get('item_type_action',0));
		$search['item_category_id'] = Request::get('item_category_id',-1);
		$search['customer_id'] = (isset($this->user_customer['customer_id']) && $this->user_customer['customer_id'] > 0)?(int)$this->user_customer['customer_id']: 0;//tìm theo khach
		//$search['field_get'] = 'order_id,order_product_name,order_status';//cac truong can lay

		//FunctionLib::debug($search);
		$dataSearch = (isset($this->user_customer['customer_id']) && $this->user_customer['customer_id'] > 0) ? Items::searchByCondition($search, $limit, $offset,$total): array();
		$paging = $total > 0 ? Pagging::getNewPager(3, $pageNo, $total, $limit, $search) : '';

		//danh muc
		$arrCategory = Category::getAllParentCategoryId();
		$optionCategory = FunctionLib::getOption(array(-1=>'---Chọn danh mục----') + $arrCategory, $search['item_category_id']);

		$optionStatus = FunctionLib::getOption($this->arrStatusProduct,$search['item_status']);
		$optionTypeAction = FunctionLib::getOption(array(0=>'--- Chọn loại tin đăng ---')+$this->arrTypeAction, $search['item_type_action']);
		$this->layout->content = View::make('site.CustomerLayouts.ItemList')
			->with('paging', $paging)
			->with('stt', ($pageNo-1)*$limit)
			->with('total', $total)
			->with('sizeShow', count($data))
			->with('data', $dataSearch)
			->with('search', $search)
			->with('optionTypeAction', $optionTypeAction)
			->with('optionCategory', $optionCategory)
			->with('optionStatus', $optionStatus)
			->with('arrTypeAction', $this->arrTypeAction)
			->with('user_customer',$this->user_customer);
		$this->footer();
	}
	public function getAddItem($item_id = 0){
		if (!UserCustomer::isLogin()) {
			return Redirect::route('site.home');
		}
		$this->header();
		$this->menuLeft();
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
		//Banner right
		$arrBannerRight = Banner::getBannerAdvanced(CGlobal::BANNER_TYPE_RIGHT, $banner_page = 0, $banner_category_id = 0, $banner_province_id = 0);
		
		//danh muc
		$arrCategory = Category::getAllParentCategoryId();
		$optionCategory = FunctionLib::getOption(array(-1=>'---Chọn danh mục----') + $arrCategory, -1);

		$optionStatusProduct = FunctionLib::getOption($this->arrStatusProduct,CGlobal::status_show);
		$optionTypePrice = FunctionLib::getOption($this->arrTypePrice,CGlobal::TYPE_PRICE_CONTACT);
		$optionTypeAction = FunctionLib::getOption($this->arrTypeAction,CGlobal::ITEMS_TYPE_ACTION_1);

		//thong tin tinh thanh
		$province = Province::getAllProvince();
		$optionProvince = FunctionLib::getOption(array(0=>'---Chọn tỉnh thành----') + $province, CGlobal::province_id_hanoi);

		$this->layout->content = View::make('site.CustomerLayouts.ItemEdit')
			->with('error', array())
			->with('item_id', $item_id)
			->with('user_shop', array())
			->with('data', $product)
			->with('arrViewImgOther', $arrViewImgOther)
			->with('imagePrimary', $imagePrimary)
			->with('imageHover', $imageHover)
			->with('optionCategory', $optionCategory)
			->with('optionTypeAction', $optionTypeAction)
			->with('optionProvince', $optionProvince)
			->with('optionStatusProduct', $optionStatusProduct)
			->with('optionTypePrice', $optionTypePrice)
			->with('arrBannerRight', $arrBannerRight);
		$this->footer();
	}
	public function getEditItem($item_id = 0){
		if (!UserCustomer::isLogin()) {
			return Redirect::route('site.home');
		}
		$this->header();
		$this->menuLeft();
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

		CGlobal::$pageShopTitle = "Sửa tin đăng | ".CGlobal::web_name;
		$items = array();
		$arrViewImgOther = array();
		$imagePrimary = $imageHover = '';
		if(isset($this->user_customer['customer_id']) && $this->user_customer['customer_id'] > 0 && $item_id > 0){
			$items = Items::getItemByCustomerId($this->user_customer['customer_id'], $item_id);
		}
		if(empty($items)){
			return Redirect::route('customer.ItemsList');
		}

		//lấy ảnh show
		if(sizeof($items) > 0){
			//lay ảnh khác của san phẩm
			if(!empty($items->item_image_other)){
				$arrImagOther = unserialize($items->item_image_other);
				if(sizeof($arrImagOther) > 0){
					foreach($arrImagOther as $k=>$val){
						$url_thumb = ThumbImg::getImageForSite(CGlobal::FOLDER_PRODUCT, $item_id,0 ,$val, CGlobal::sizeImage_300);
						$url_thumb_content = ThumbImg::getImageForSite(CGlobal::FOLDER_PRODUCT, $item_id,0, $val, CGlobal::sizeImage_600);
						$arrViewImgOther[] = array('img_other'=>$val,'src_img_other'=>$url_thumb,'src_thumb_content'=>$url_thumb_content);
					}
				}
			}
			//ảnh sản phẩm chính
			$imagePrimary = $items->item_image;
		}
		$dataShow = array('product_id'=>$items->product_id,
			'item_name'=>$items->item_name,
			'item_category_id'=>$items->item_category_id,
			'item_status'=>$items->item_status,
			'item_type_action'=>$items->item_type_action,
			'item_content'=>$items->item_content,
			'item_type_price'=>$items->item_type_price,
			'item_price_sell'=>$items->item_price_sell,
			'item_province_id'=>$items->item_province_id,
			'item_infor_contract'=>$items->item_infor_contract,
			'item_image'=>$items->item_image);
		//Banner right
		$arrBannerRight = Banner::getBannerAdvanced(CGlobal::BANNER_TYPE_RIGHT, $banner_page = 0, $banner_category_id = 0, $banner_province_id = 0);
		
		//danh muc san pham cua shop
		$arrCategory = Category::getAllParentCategoryId();
		$optionCategory = FunctionLib::getOption(array(-1=>'---Chọn danh mục----') + $arrCategory,isset($items->item_category_id)? $items->item_category_id: -1);

		$optionStatusProduct = FunctionLib::getOption($this->arrStatusProduct,isset($items->item_status)? $items->item_status :CGlobal::status_hide);
		$optionTypePrice = FunctionLib::getOption($this->arrTypePrice,isset($items->item_type_price)? $items->item_type_price:CGlobal::TYPE_PRICE_NUMBER);
		$optionTypeAction = FunctionLib::getOption($this->arrTypeAction,isset($items->item_type_action)? $items->item_type_action:CGlobal::ITEMS_TYPE_ACTION_1);

		//thong tin tinh thanh
		$province = Province::getAllProvince();
		$optionProvince = FunctionLib::getOption(array(0=>'---Chọn tỉnh thành----') + $province, isset($items->item_province_id)? $items->item_province_id :CGlobal::province_id_hanoi);

		$this->layout->content = View::make('site.CustomerLayouts.ItemEdit')
			->with('error', $this->error)
			->with('item_id', $item_id)
			->with('user_customer',$this->user_customer)
			->with('data', $dataShow)
			->with('arrViewImgOther', $arrViewImgOther)
			->with('imagePrimary', $imagePrimary)
			->with('optionTypeAction', $optionTypeAction)
			->with('imageHover', $imageHover)
			->with('optionCategory', $optionCategory)
			->with('optionProvince', $optionProvince)
			->with('optionStatusProduct', $optionStatusProduct)
			->with('optionTypePrice', $optionTypePrice)
			->with('arrBannerRight', $arrBannerRight);
		$this->footer();
	}
	public function postEditItem($item_id = 0){
		if (!UserCustomer::isLogin()) {
			return Redirect::route('customer.ItemsList');
		}
		$this->header();
		$this->menuLeft();
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

		CGlobal::$pageShopTitle = "Sửa sản phẩm | ".CGlobal::web_name;
		$arrViewImgOther = array();
		$imagePrimary = $imageHover = '';

		$dataSave['item_name'] = addslashes(Request::get('item_name'));
		$dataSave['item_category_id'] = addslashes(Request::get('item_category_id'));
		$dataSave['item_status'] = addslashes(Request::get('item_status'));
		$dataSave['item_content'] = FunctionLib::strReplace(addslashes(Request::get('item_content')),CGlobal::$arrIconSpecals,'');
		$dataSave['item_type_price'] = addslashes(Request::get('item_type_price',CGlobal::TYPE_PRICE_CONTACT));
		$dataSave['item_type_action'] = (int)(Request::get('item_type_action',CGlobal::ITEMS_TYPE_ACTION_1));
		$dataSave['item_price_sell'] = (int)str_replace('.','',Request::get('item_price_sell'));
		$dataSave['item_image'] = $imagePrimary = addslashes(Request::get('image_primary'));

		$dataSave['item_province_id'] = (int)(Request::get('item_province_id',0));
		$dataSave['item_infor_contract'] = trim(addslashes(Request::get('item_infor_contract','')));

		if($dataSave['item_content'] != ''){
			$content = $dataSave['item_content'];
			$content = FunctionLib::strReplace($content, CGlobal::$arrIconSpecals, '');
			$dataSave['item_content'] = $content;
		}
		
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

		$this->validInforItem($dataSave);
		if(empty($this->error)){
			//tinh thanh
			$arrProvince = Province::getAllProvince();
			//lay tên danh mục
			$dataSave['item_category_name'] = isset($arrCategory[$dataSave['item_category_id']])?$arrCategory[$dataSave['item_category_id']]: '';
			$dataSave['customer_id'] = $this->user_customer['customer_id'];
			$dataSave['customer_name'] = $this->user_customer['customer_name'];
			$dataSave['is_customer'] = $this->user_customer['is_customer'];
			$dataSave['item_province_id'] = ($dataSave['item_province_id'] > 0) ?$dataSave['item_province_id'] : $this->user_customer['customer_province_id'];
			$dataSave['item_infor_contract'] = ($dataSave['item_infor_contract'] !='') ?$dataSave['item_infor_contract'] :$this->user_customer['customer_about'];
			$dataSave['item_province_name'] = isset($arrProvince[$dataSave['item_province_id']])? $arrProvince[$dataSave['item_province_id']] : 'Toàn quốc';
			$dataSave['item_district_id'] = $this->user_customer['customer_district_id'];
			$dataSave['item_block'] = CGlobal::ITEMS_NOT_BLOCK;

			if($item_id > 0){
				$items = array();
				if(isset($this->user_customer['customer_id']) && $this->user_customer['customer_id'] > 0 && $item_id > 0){
					$items = Items::getItemByCustomerId($this->user_customer['customer_id'], $item_id);
				}
				if(!empty($items)){
					if($item_id > 0){//cap nhat
						$dataSave['time_update'] = time();
						$itemID = Items::updateData($item_id,$dataSave);
						if($itemID){
							$itemShow = Items::getItemsByID($itemID);
							ThumbImg::getImageThumb(CGlobal::FOLDER_PRODUCT, $itemShow->item_id, $itemShow->item_image, CGlobal::sizeImage_500);
							return Redirect::route('customer.ItemsList');
						}
					}
				}else{
					return Redirect::route('customer.ItemsList');
				}
			}
			//tạo mới
			else{
				//FunctionLib::debug($dataSave);
				$dataSave['time_created'] = time();
				$dataSave['time_ontop'] = time();
				$dataSave['time_update'] = time();
				$itemID = Items::addData($dataSave);
				if($itemID){
					$itemShow = Items::getItemsByID($itemID);
					ThumbImg::getImageThumb(CGlobal::FOLDER_PRODUCT, $itemShow->item_id, $itemShow->item_image, CGlobal::sizeImage_500);
					//cập nhật số lượng up tin
					$dataCustomer['customer_up_item'] = $this->user_customer['customer_up_item'] + 1;;
					if(UserCustomer::updateData($this->user_customer['customer_id'],$dataCustomer)){
						$dataNew = UserCustomer::getByID($this->user_customer['customer_id']);
						Session::forget('user_customer');
						Session::put('user_customer', $dataNew, 60*24);
						Session::save();
					}
					return Redirect::route('customer.ItemsList');
				}
			}
		}
		//Banner right
		$arrBannerRight = Banner::getBannerAdvanced(CGlobal::BANNER_TYPE_RIGHT, $banner_page = 0, $banner_category_id = 0, $banner_province_id = 0);
		
		//FunctionLib::debug($dataSave);
		$optionCategory = FunctionLib::getOption(array(-1=>'---Chọn danh mục----') + $arrCategory,$dataSave['item_category_id']);
		$optionStatusProduct = FunctionLib::getOption($this->arrStatusProduct,$dataSave['item_status']);
		$optionTypePrice = FunctionLib::getOption($this->arrTypePrice,$dataSave['item_type_price']);
		$optionTypeAction = FunctionLib::getOption($this->arrTypeAction,$dataSave['item_type_action']);

		//thong tin tinh thanh
		$province = Province::getAllProvince();
		$optionProvince = FunctionLib::getOption(array(0=>'---Chọn tỉnh thành----') + $province, $dataSave['item_province_id']);

		$this->layout->content = View::make('site.CustomerLayouts.ItemEdit')
			->with('error', $this->error)
			->with('item_id', $item_id)
			->with('user_customer',$this->user_customer)
			->with('data', $dataSave)
			->with('arrViewImgOther', $arrViewImgOther)
			->with('imagePrimary', $imagePrimary)
			->with('imageHover', $imageHover)
			->with('optionCategory', $optionCategory)
			->with('optionProvince', $optionProvince)
			->with('optionTypeAction', $optionTypeAction)
			->with('optionStatusProduct', $optionStatusProduct)
			->with('optionTypePrice', $optionTypePrice)
			->with('arrBannerRight', $arrBannerRight);
		$this->footer();
	}
	public function getAllImageItem(){
		$item_id = (int)Request::get('item_id', 0);
        $data = array('isIntOk' => 0);
        if(isset($this->user_customer->customer_id) && $this->user_customer->customer_id > 0 && $item_id > 0){
            $result = Items::getItemByCustomerId($this->user_customer->customer_id, $item_id);
            
            if(sizeof($result) > 0){
                if($result->item_image_other != ''){
                    $arrViewImgOther = array();
                    $arrImagOther = unserialize($result->item_image_other);
                    if(sizeof($arrImagOther) > 0){
                        foreach($arrImagOther as $k=>$val){
                            $url_thumb = ThumbImg::getImageForSite(CGlobal::FOLDER_PRODUCT, $item_id,0, $val, CGlobal::sizeImage_300);
                            $url_thumb_content = ThumbImg::getImageForSite(CGlobal::FOLDER_PRODUCT, $item_id,0, $val, CGlobal::sizeImage_600);
                            $arrViewImgOther[] = array('item_name'=>$result->item_name,
                                'src_img_other'=>$url_thumb,
                                'src_thumb_content'=>$url_thumb_content);
                        }
                    }
                    $data['dataImage'] = $arrViewImgOther;
                    $data['isIntOk'] = 1;
                    return Response::json($data);
                }
            }else{
                return Response::json($data);
            }
        }
        return Response::json($data);
	}
	public function removeImage(){
		$item_id = Request::get('id',0);
		$name_img = Request::get('nameImage','');
		$aryData = array();
		$aryData['intIsOK'] = -1;
		$aryData['msg'] = "Error";
		$aryData['nameImage'] = $name_img;
		if($item_id > 0 && $name_img != ''){
			//get mang anh other
			$customer_id = $this->user_customer->customer_id;
			$inforItem = Items::getItemByCustomerId($customer_id, $item_id);
			if($inforItem) {
				$arrImagOther = unserialize($inforItem->item_image_other);
				foreach($arrImagOther as $ki => $img){
					if(strcmp($img,$name_img) == 0){
						unset($arrImagOther[$ki]);
						break;
					}
				}
				$itemUpdate['item_image_other'] = serialize($arrImagOther);
				Items::updateData($item_id,$itemUpdate);
			}
			//anh upload
			FunctionLib::deleteFileUpload($name_img, $item_id,CGlobal::FOLDER_PRODUCT);
			//xoa anh thumb
			$arrSizeThumb = CGlobal::$arrSizeImage;
			foreach($arrSizeThumb as $k=>$size){
				$sizeThumb = $size['w'].'x'.$size['h'];
				FunctionLib::deleteFileThumb($name_img,$item_id,CGlobal::FOLDER_PRODUCT,$sizeThumb);
			}
			$aryData['intIsOK'] = 1;
		}
		return Response::json($aryData);
	}
	private function validInforItem($data=array()) {
		if(!empty($data)) {
			if(isset($data['item_name']) && trim($data['item_name']) == '') {
				$this->error[] = 'Tiêu đề tin đăng không được bỏ trống';
			}
			if(isset($data['item_category_id']) && $data['item_category_id'] == -1) {
				$this->error[] = 'Chưa chọn danh mục đăng tin';
			}
			if(isset($data['item_type_price']) && $data['item_type_price'] == CGlobal::TYPE_PRICE_NUMBER) {
				if(isset($data['item_price_sell']) && $data['item_price_sell'] <= 0) {
					$this->error[] = 'Chưa nhập giá bán';
				}
			}
			return true;
		}
		return false;
	}
	//ajax set Top tin dang
	public function setTopItems(){
		$data = array('isIntOk' => 0,'msg' => 'Không set top tin đăng này được');
		if (!UserCustomer::isLogin()) {
			return Response::json($data);
		}
		$item_id = (int)trim(Request::get('item_id', 0));
		if(!empty($this->user_customer) && $item_id > 0){
			$items = array();
			if(isset($this->user_customer['customer_id']) && $this->user_customer['customer_id'] > 0 && $item_id > 0){
				$items = Items::getItemByCustomerId($this->user_customer['customer_id'], $item_id);
			}
			if(!empty($items)){
				$inforCustomer = Session::get('user_customer');
				$today = date('d-m-Y',time());
				//check trong cung 1 ngay chi duoc 5 lan set ontop + so luot da share
				$numberUpTopCurrent = isset($inforCustomer['customer_number_ontop_in_day']) ? $inforCustomer['customer_number_ontop_in_day']: 5;
				$numberMaxUpTop = isset($inforCustomer['customer_number_share']) ? ($inforCustomer['customer_number_share']+5): 5;
				if(!empty($inforCustomer)){
					//check cung 1 ngày set top
					if(isset($inforCustomer['customer_date_ontop']) && strcmp($inforCustomer['customer_date_ontop'],$today) == 0){
						if($numberUpTopCurrent < $numberMaxUpTop){
							if($item_id > 0){//set top
								$dataSave['time_ontop'] = time();
								$dataSave['time_update'] = time();
								if(Items::updateData($item_id,$dataSave)){
									$number_set_top = $numberUpTopCurrent + 1;//cộng thêm lượt settop
									//cập nhật số lượng ontop tin đăng
									$dataCustomer['customer_number_ontop_in_day'] = $number_set_top;
									$dataCustomer['customer_date_ontop'] = date('d-m-Y');
									if(UserCustomer::updateData($this->user_customer['customer_id'],$dataCustomer)){
										$dataNew = UserCustomer::getByID($this->user_customer['customer_id']);
										Session::forget('user_customer');
										Session::put('user_customer', $dataNew, 60*24);
										Session::save();
									}
									$numerAction = $numberMaxUpTop - $numberUpTopCurrent - 1;
									$data['isIntOk'] = 1;
									$data['msg'] = 'OnTop tin thành công. Uptop hôm nay còn: '.$numerAction.' lượt';
									return Response::json($data);
								}
							}
						}else{
							$data['msg'] = 'Bạn đã up đủ số lượt cho ngày hôm nay';
							return Response::json($data);
						}
					}
					//check khác ngày settop
					elseif(isset($inforCustomer['customer_date_ontop']) && strcmp($inforCustomer['customer_date_ontop'],$today) != 0 && ($numberUpTopCurrent == $numberMaxUpTop || $numberUpTopCurrent == 0 || $numberUpTopCurrent < $numberMaxUpTop)){
						if($item_id > 0){//set top
							$dataSave['time_ontop'] = time();
							$dataSave['time_update'] = time();
							if(Items::updateData($item_id,$dataSave)){
								$number_set_top = 1; // gan lại lượt up cho 1 ngày
								//cập nhật số lượng ontop tin đăng
								$dataCustomer['customer_number_ontop_in_day'] = $number_set_top;
								$dataCustomer['customer_date_ontop'] = date('d-m-Y');
								if(UserCustomer::updateData($this->user_customer['customer_id'],$dataCustomer)){
									$dataNew = UserCustomer::getByID($this->user_customer['customer_id']);
									Session::forget('user_customer');
									Session::put('user_customer', $dataNew, 60*24);
									Session::save();
								}
								$numerAction = $numberMaxUpTop - $numberUpTopCurrent -1;
								$data['isIntOk'] = 1;
								$data['msg'] = 'OnTop tin thành công. Uptop hôm nay còn: '.$numerAction.' lượt';
								return Response::json($data);
							}
						}
					}
				}
				else{
					$data['msg'] = 'Hết phiên làm việc, hãy đăng nhập lại';
					return Response::json($data);
				}
			}else{
				$data['msg'] = 'Tin đăng này không phải của bạn';
				return Response::json($data);
			}
		}
	}

	//dat lich set top tin dang tu dong
	public function getInforEditCalendarUp($feed_home_id){
		$dataEdit = array();
		$dataResponse = CalendarUp::show($feed_home_id);
		if($dataResponse['code'] == 200 && $dataResponse['intIsOK'] == 1 && !empty($dataResponse['data'])){
			foreach($dataResponse['data'] as $k=>$val){
				$dataEdit['calendar_up_id'] = $val['calendar_up_id'];
				$dataEdit['feed_home_id'] = $val['product_sale_id'];
				$dataEdit['supplier_id'] = $val['supplier_id'];
				$dataEdit['campaign_id'] = $val['product_id'];
				$dataEdit['location_id'] = $val['location_id'];
				$dataEdit['calendar_up_status'] = $val['calendar_up_status'];

				$dataEdit['calendar_up_date']['thu_'.$val['calendar_up_date']] = $val['calendar_up_date'];
				$dataEdit['calendar_up_time'][$val['calendar_up_time']] = $val['calendar_up_time'];
			}
		}

		if(!empty($dataEdit) && isset($dataEdit['calendar_up_time']) && !empty($dataEdit['calendar_up_time'])){
			$dataEdit['number_up_1'] = 0;//Từ 0h00 đến 5h 59
			$dataEdit['number_up_2'] = 0;//Từ 6h00 đến 11h59
			$dataEdit['number_up_3'] = 0;//Từ 12h00 đến 17h59
			$dataEdit['number_up_4'] = 0;//Từ 18h00 đến 23h59
			foreach($dataEdit['calendar_up_time'] as $key_time =>&$timeRun){
				if($timeRun <600){
					$dataEdit['number_up_1']++;
				}elseif(600<= $timeRun && $timeRun<1200){
					$dataEdit['number_up_2']++;
				}elseif(1200<= $timeRun && $timeRun<1800){
					$dataEdit['number_up_3']++;
				}elseif(1800<= $timeRun && $timeRun<2400){
					$dataEdit['number_up_4']++;
				}
				//build string time
				$timeRun = ($timeRun >0)? ($timeRun <1000)? '0'.substr_replace($timeRun, ':', -2, 0): substr_replace($timeRun, ':', -2, 0) :'00:00';
			}
			return $dataEdit;
		}
		return array();
	}
	public function getAjaxPushUpTimeProduct(){
		$arrData = array();
		$arrAjax = array('intReturn' => 0, 'info' => $arrData,'msg'=>'Có lỗi cập nhật dữ liệu');

		//ngày chạy
		$dataDate = array();
		$thu_2 = Request::get('thu_2',0);
		$thu_3 = Request::get('thu_3',0);
		$thu_4 = Request::get('thu_4',0);
		$thu_5 = Request::get('thu_5',0);
		$thu_6 = Request::get('thu_6',0);
		$thu_7 = Request::get('thu_7',0);
		$thu_8 = Request::get('thu_8',0);
		if($thu_2 >0){ $dataDate[] = $thu_2; }
		if($thu_3 >0){ $dataDate[] = $thu_3; }
		if($thu_4 >0){ $dataDate[] = $thu_4; }
		if($thu_5 >0){ $dataDate[] = $thu_5; }
		if($thu_6 >0){ $dataDate[] = $thu_6; }
		if($thu_7 >0){ $dataDate[] = $thu_7; }
		if($thu_8 >0){ $dataDate[] = $thu_8; }

		//thời gian chạy
		$timeSetting = Request::get('timeSetting',array());
		$dataTimeUp = array();
		if(!empty($timeSetting)){
			foreach($timeSetting as $k =>$strTime){
				if($strTime !=''){
					$number = str_replace(':','',$strTime);
					if(!in_array($number,$dataTimeUp)){
						$dataTimeUp[] = (int)$number;
					}
				}
			}
		}

		//data khác
		$campaign_id = Request::get('campaign_id',0);
		$feed_home_id = Request::get('feed_home_id',0);
		$location_id = Request::get('location_id',0);

		$number_up_hold = Request::get('number_up_hold',0);
		$numberCanUser = Request::get('sys_number_up_can_user_shop',0);
		$hidden_hold_con_lai = Request::get('sys_hidden_hold_con_lai',0);

		$data['product_id'] = $campaign_id;
		$data['product_sale_id'] = $feed_home_id;
		$data['location_id'] = $location_id;

		//check số lần up có vượt quá lượt up cho phép không
		if(($numberCanUser + $hidden_hold_con_lai) < $number_up_hold){
			$arrAjax['msg'] = 'Bạn không còn đủ lượt up để thực hiện! <br/>  Tổng số lượt dùng cho deal này > số lượt up bạn có thể dùng';
			return Response::json($arrAjax);
		}

		if($number_up_hold == 0){
			$arrAjax['msg'] = 'Bạn phải nhập Tổng số lượt dùng cho deal này!';
			return Response::json($arrAjax);
		}

		if(empty($dataDate)){
			$arrAjax['msg'] = 'Bạn chưa chọn ngày trong tuần để Up tin';
			return Response::json($arrAjax);
		}
		if(empty($dataTimeUp)){
			$arrAjax['msg'] = 'Bạn chưa chọn thời gian để up tin';
			return Response::json($arrAjax);
		}

		//check tông số đặt lịch xem có cho phép ko
		$totalSetup = count($dataDate)*count($dataTimeUp);
		if($totalSetup > $number_up_hold){
			$arrAjax['msg'] = 'Số lượt up của bạn không đủ thiết lập lịch up tự động này! <br/> Tổng lịch chạy up deal tự động là: '.$totalSetup.'<br/>Tổng số lượt dùng cho deal này: '.$number_up_hold;
			return Response::json($arrAjax);
		}

		$dataInsert['data'] = json_encode($data);
		$dataInsert['date'] = json_encode($dataDate);
		$dataInsert['time'] = json_encode($dataTimeUp);
		$dataInsert['product_sale_num_up_hold'] = $number_up_hold;
		//$dataInsert['key'] = Session::get('key_shop');
		$dataInsert['key'] = $this->key;

		//insert
		$dataResponse = CalendarUp::insert($dataInsert);

		if(!empty($dataResponse) && $dataResponse['intIsOK'] == 1 && $dataResponse['code'] == 200){
			$arrAjax['intReturn'] = 1;
			$arrAjax['msg'] = 'Bạn đã thiết lập lịch up tự động thành công';
			return Response::json($arrAjax);
		}
		return Response::json($arrAjax);
	}

	//ajax xóa tin đăng
	public function removeItems(){
		$data = array('isIntOk' => 0,'msg' => 'Không set top tin đăng này được');
		if (!UserCustomer::isLogin()) {
			return Response::json($data);
		}
		$item_id = (int)trim(Request::get('item_id', 0));
		if(!empty($this->user_customer) && $item_id > 0){
			$items = array();
			if(isset($this->user_customer['customer_id']) && $this->user_customer['customer_id'] > 0 && $item_id > 0){
				$items = Items::getItemByCustomerId($this->user_customer['customer_id'], $item_id);
			}
			if(!empty($items)){
				if ($item_id > 0 && Items::deleteData($item_id)) {
					$data['isIntOk'] = 1;
					$data['msg'] = 'Đã xóa thành công tin đăng';
					return Response::json($data);
				}
			}
		}
	}

	//Login Facebook - Google
	public function loginFacebook(){
		
		$fb = new Facebook\Facebook ([
				'app_id' => '732736640216505',
				'app_secret' => 'fcc290c4ee0cc38231a736c9fd272fa2',
				'default_graph_version' => 'v2.8',
				'persistent_data_handler' => 'session'
				]);
			
		$helper = $fb->getRedirectLoginHelper();
			
		try{
			$accessToken = $helper->getAccessToken();
		}catch(Facebook\Exceptions\FacebookResponseException $e) {
			//When Graph returns an error
			echo 'Graph returned an error: ' . $e->getMessage();
			exit;
		}catch(Facebook\Exceptions\FacebookSDKException $e) {
			//When validation fails or other local issues
			echo 'Facebook SDK returned an error: ' . $e->getMessage();
			exit;
		}
			
		if (!isset($accessToken)) {
			$permissions = array('public_profile','email'); //Optional permissions
			$loginUrl = $helper->getLoginUrl(Config::get('config.WEB_ROOT').'facebooklogin', $permissions);
			header("Location: ".$loginUrl);
			exit;
		}
			
		try{
			//Returns a 'Facebook\FacebookResponse' object
			$fields = array('id', 'name', 'email','first_name', 'last_name', 'birthday', 'gender', 'locale');
			$response = $fb->get('/me?fields='.implode(',', $fields).'', $accessToken);
		}catch(Facebook\Exceptions\FacebookResponseException $e) {
			echo 'Graph returned an error: ' . $e->getMessage();
			exit;
		}catch(Facebook\Exceptions\FacebookSDKException $e) {
			echo 'Facebook SDK returned an error: ' . $e->getMessage();
			exit;
		}
			
		$user = $response->getGraphUser();
		
		if(sizeof($user) > 0){
			$data = array();
			
			if(isset($user['id'])){
				$data['customer_id_facebook'] = $user['id'];
			}
			if(isset($user['email'])){
				$data['customer_email'] = $user['email'];
			}
			if(isset($user['name'])){
				$data['customer_name'] = $user['name'];
			}else{
				$data['customer_name'] = '';
			}
			if(isset($user['gender'])){
				if($user['gender'] == 'male'){
					$data['customer_gender'] = 1;//Nam
				}else{
					$data['customer_gender'] = 0;//Nu
				}
			}else{
				$data['customer_gender'] = 0;//Nu
			}
			if(isset($data['customer_id_facebook']) && $data['customer_id_facebook'] != ''){
				if(isset($data['customer_email']) && $data['customer_email'] != ''){
			
					$customer = UserCustomer::getUserCustomerByEmail($data['customer_email']);
					if(sizeof($customer) > 0){
						if(($customer->customer_id_facebook == '' || $customer->customer_id_facebook == null) && $customer->customer_status != CGlobal::status_block){
							$dataUpdate = array(
									'customer_id_facebook' => $data['customer_id_facebook'],
									'customer_status' => CGlobal::status_show,
									'is_login' => CGlobal::is_login,
									'customer_time_login' => time(),
							);
							UserCustomer::updateData($customer->customer_id, $dataUpdate);
							$customer = UserCustomer::getUserCustomerByEmail($data['customer_email']);
						}
					}else{
						$data['customer_time_created'] = time();
						$data['customer_status'] = CGlobal::status_show;
						$data['customer_time_login'] = time();
						$data['customer_phone'] = '';
						$data['customer_address'] = '';
						$data['customer_id_facebook'] = $data['customer_id_facebook'];
						$data['customer_email'] = $data['customer_email'];
						$data['customer_gender'] = $data['customer_gender'];
						$data['customer_name'] = $data['customer_name'];
						$data['is_customer'] = CGlobal::CUSTOMER_FREE;
						$data['is_login'] = CGlobal::is_login;
						$data['customer_province_id'] = CGlobal::province_id_hanoi;
						
						UserCustomer::addData($data);
						$customer = UserCustomer::getUserCustomerByEmail($data['customer_email']);
					}
			
					Session::put('user_customer', $customer, 60*24);
					Session::save();
			
				}else{
					echo '<script>alert("Bạn chưa công khai email!"); window.close();</script>';
				}
			}
			
			echo '<script>window.close();</script>';
		}
	}
	public function loginFacebookFast(){
		if (UserCustomer::isLogin()) {
			return Redirect::route('site.home');
		}
		$fb = new Facebook\Facebook ([
				'app_id' => '732736640216505',
				'app_secret' => 'fcc290c4ee0cc38231a736c9fd272fa2',
				'default_graph_version' => 'v2.8',
				'persistent_data_handler' => 'session'
				]);
			
		$helper = $fb->getRedirectLoginHelper();
			
		try{
			$accessToken = $helper->getAccessToken();
		}catch(Facebook\Exceptions\FacebookResponseException $e) {
			//When Graph returns an error
			echo 'Graph returned an error: ' . $e->getMessage();
			exit;
		}catch(Facebook\Exceptions\FacebookSDKException $e) {
			//When validation fails or other local issues
			echo 'Facebook SDK returned an error: ' . $e->getMessage();
			exit;
		}
			
		if (!isset($accessToken)) {
			$permissions = array('public_profile','email'); //Optional permissions
			$loginUrl = $helper->getLoginUrl(Config::get('config.WEB_ROOT').'hop-tac.html', $permissions);
			header("Location: ".$loginUrl);
			exit;
		}
			
		try{
			//Returns a 'Facebook\FacebookResponse' object
			$fields = array('id', 'name', 'email','first_name', 'last_name', 'birthday', 'gender', 'locale');
			$response = $fb->get('/me?fields='.implode(',', $fields).'', $accessToken);
		}catch(Facebook\Exceptions\FacebookResponseException $e) {
			echo 'Graph returned an error: ' . $e->getMessage();
			exit;
		}catch(Facebook\Exceptions\FacebookSDKException $e) {
			echo 'Facebook SDK returned an error: ' . $e->getMessage();
			exit;
		}
			
		$user = $response->getGraphUser();
		
		if(sizeof($user) > 0){
			$data = array();
				
			if(isset($user['id'])){
				$data['customer_id_facebook'] = $user['id'];
			}
			if(isset($user['email'])){
				$data['customer_email'] = $user['email'];
			}
			if(isset($user['name'])){
				$data['customer_name'] = $user['name'];
			}else{
				$data['customer_name'] = '';
			}
			if(isset($user['gender'])){
				if($user['gender'] == 'male'){
					$data['customer_gender'] = 1;//Nam
				}else{
					$data['customer_gender'] = 0;//Nu
				}
			}else{
				$data['customer_gender'] = 0;//Nu
			}
			if(isset($data['customer_id_facebook']) && $data['customer_id_facebook'] != ''){
				if(isset($data['customer_email']) && $data['customer_email'] != ''){
						
					$customer = UserCustomer::getUserCustomerByEmail($data['customer_email']);
					if(sizeof($customer) > 0){
						if(($customer->customer_id_facebook == '' || $customer->customer_id_facebook == null) && $customer->customer_status != CGlobal::status_block){
							$dataUpdate = array(
									'customer_id_facebook' => $data['customer_id_facebook'],
									'customer_status' => CGlobal::status_show,
							);
							UserCustomer::updateData($customer->customer_id, $dataUpdate);
							$customer = UserCustomer::getUserCustomerByEmail($data['customer_email']);
						}
					}else{
						$data['customer_time_created'] = time();
						$data['customer_status'] = CGlobal::status_show;
						$data['customer_time_login'] = time();
						$data['customer_phone'] = '';
						$data['customer_address'] = '';
						$data['customer_email'] = $data['customer_email'];
						$data['customer_gender'] = $data['customer_gender'];
						$data['customer_name'] = $data['customer_name'];
						$data['is_customer'] = CGlobal::CUSTOMER_FREE;
						$data['is_login'] = CGlobal::is_login;
						
						UserCustomer::addData($data);
						$customer = UserCustomer::getUserCustomerByEmail($data['customer_email']);
					}
						
					Session::put('user_customer', $customer, 60*24);
					Session::save();
					echo "<center>Cảm ơn bạn đã hợp tác</center>";die;
				}else{
					echo '<script>alert("Bạn chưa công khai email!"); window.close();</script>';
				}
			}
				
			echo '<script>window.close();</script>';
		}
	}
	public function loginGoogle(){
		$client_id = '50590659500-rlpjharjl0bt68o9706rar8mkquf7p56.apps.googleusercontent.com'; 
		$client_secret = 'qOoBdgVyas-_ESlQk_KGlMrv'; 
		$redirect_uri = Config::get('config.WEB_ROOT').'googlelogin';
		
		$client = new Google_Client();
		$client->setClientId($client_id);
		$client->setClientSecret($client_secret);
		$client->setRedirectUri($redirect_uri);
		$client->addScope("email");
		$client->addScope("profile");
		
		$service = new Google_Service_Oauth2($client);
		$access_token = '';
		$customer = array();
		
		if(isset($_GET['code'])){
			
			$client->authenticate($_GET['code']);
			$access_token = $client->getAccessToken();
			
			$client->setAccessToken($access_token);
			$user = $service->userinfo->get();
			
			if(sizeof($user) > 0){
				$data = array();
				
				if(isset($user['id'])){
					$data['customer_id_google'] = $user['id'];
				}
				if(isset($user['email'])){
					$data['customer_email'] = $user['email'];
				}
				if(isset($user['name'])){
					$data['customer_name'] = $user['name'];
				}else{
					$data['customer_name'] = '';
				}
				if(isset($user['gender'])){
					if($user['gender'] == 'male'){
						$data['customer_gender'] = 1;//Nam
					}else{
						$data['customer_gender'] = 0;//Nu
					}
				}else{
					$data['customer_gender'] = 0;//Nu
				}
				
				if(isset($data['customer_id_google']) && $data['customer_id_google'] != ''){
					if(isset($data['customer_email']) && $data['customer_email'] != ''){
						
						$customer = UserCustomer::getUserCustomerByEmail($data['customer_email']);
						if(sizeof($customer) > 0){
							if(($customer->customer_id_google == '' || $customer->customer_id_google == null) && $customer->customer_status != CGlobal::status_block){
								$dataUpdate = array(
									'customer_id_google' => $data['customer_id_google'],
									'customer_status' => CGlobal::status_show,
									'is_login' => CGlobal::is_login,
									'customer_time_login' => time(),
								);
								UserCustomer::updateData($customer->customer_id, $dataUpdate);
								$customer = UserCustomer::getUserCustomerByEmail($data['customer_email']);
							}
						}else{
							$data['customer_time_created'] = time();
							$data['customer_status'] = CGlobal::status_show;
							$data['customer_time_login'] = time();
							$data['customer_phone'] = '';
							$data['customer_address'] = '';
							$data['customer_id_google'] = $data['customer_id_google'];
							$data['customer_email'] = $data['customer_email'];
							$data['customer_gender'] = $data['customer_gender'];
							$data['customer_name'] = $data['customer_name'];
							$data['is_customer'] = CGlobal::CUSTOMER_FREE;
							$data['is_login'] = CGlobal::is_login;
							$data['customer_province_id'] = CGlobal::province_id_hanoi;

							UserCustomer::addData($data);
							$customer = UserCustomer::getUserCustomerByEmail($data['customer_email']);
						}
						
						Session::put('user_customer', $customer, 60*24);
						Session::save();
						
					}
				}
			}
			echo '<script>window.close();</script>';
		}else{
			$authUrl = $client->createAuthUrl();
			header("Location: ".$authUrl);
		}
		die;
	}
}