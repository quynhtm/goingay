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

		CGlobal::$pageShopTitle = "Quản lý sản phẩm | ".CGlobal::web_name;
		$pageNo = (int) Request::get('page_no',1);
		$limit = CGlobal::number_limit_show;
		$offset = ($pageNo - 1) * $limit;
		$search = $data = array();
		$total = 0;

		$search['item_name'] = addslashes(Request::get('item_name',''));
		$search['item_status'] = addslashes(Request::get('item_status',-1));
		$search['item_category_id'] = Request::get('item_category_id',-1);
		$search['customer_id'] = (isset($this->user_customer['customer_id']) && $this->user_customer['customer_id'] > 0)?(int)$this->user_customer['customer_id']: 0;//tìm theo khach
		//$search['field_get'] = 'order_id,order_product_name,order_status';//cac truong can lay

		//FunctionLib::debug($search);
		$dataSearch = (isset($this->user_customer['customer_id']) && $this->user_customer['customer_id'] > 0) ? Items::searchByCondition($search, $limit, $offset,$total): array();
		$paging = $total > 0 ? Pagging::getNewPager(3, $pageNo, $total, $limit, $search) : '';

		//Banner right
		$arrBannerRight = Banner::getBannerAdvanced(CGlobal::BANNER_TYPE_RIGHT, $banner_page = 0, $banner_category_id = 0, $banner_province_id = 0);
		//danh muc
		$arrCategory = Category::getAllParentCategoryId();
		$optionCategory = FunctionLib::getOption(array(-1=>'---Chọn danh mục----') + $arrCategory, $search['item_category_id']);

		$optionStatus = FunctionLib::getOption($this->arrStatusProduct,$search['item_status']);
		$this->layout->content = View::make('site.CustomerLayouts.ItemList')
			->with('paging', $paging)
			->with('stt', ($pageNo-1)*$limit)
			->with('total', $total)
			->with('sizeShow', count($data))
			->with('data', $dataSearch)
			->with('search', $search)
			->with('optionCategory', $optionCategory)
			->with('optionStatus', $optionStatus)
			->with('user_customer',$this->user_customer)
			->with('arrBannerRight',$arrBannerRight);
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
		//Banner right
		$arrBannerRight = Banner::getBannerAdvanced(CGlobal::BANNER_TYPE_RIGHT, $banner_page = 0, $banner_category_id = 0, $banner_province_id = 0);
		
		//danh muc
		$arrCategory = Category::getAllParentCategoryId();
		$optionCategory = FunctionLib::getOption(array(-1=>'---Chọn danh mục----') + $arrCategory, -1);

		$optionStatusProduct = FunctionLib::getOption($this->arrStatusProduct,CGlobal::status_show);
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
			->with('optionTypePrice', $optionTypePrice)
			->with('arrBannerRight', $arrBannerRight);
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
						$url_thumb = ThumbImg::getImageThumb(CGlobal::FOLDER_PRODUCT, $item_id, $val, CGlobal::sizeImage_100);
						$url_thumb_content = ThumbImg::getImageThumb(CGlobal::FOLDER_PRODUCT, $item_id, $val, CGlobal::sizeImage_600);
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
			'item_content'=>$items->item_content,
			'item_type_price'=>$items->item_type_price,
			'item_price_sell'=>$items->item_price_sell,
			'item_image'=>$items->item_image);
		//Banner right
		$arrBannerRight = Banner::getBannerAdvanced(CGlobal::BANNER_TYPE_RIGHT, $banner_page = 0, $banner_category_id = 0, $banner_province_id = 0);
		
		//danh muc san pham cua shop
		$arrCategory = Category::getAllParentCategoryId();
		$optionCategory = FunctionLib::getOption(array(-1=>'---Chọn danh mục----') + $arrCategory,isset($items->item_category_id)? $items->item_category_id: -1);

		$optionStatusProduct = FunctionLib::getOption($this->arrStatusProduct,isset($items->item_status)? $items->item_status :CGlobal::status_hide);
		$optionTypePrice = FunctionLib::getOption($this->arrTypePrice,isset($items->item_type_price)? $items->item_type_price:CGlobal::TYPE_PRICE_NUMBER);

		$this->layout->content = View::make('site.CustomerLayouts.ItemEdit')
			->with('error', $this->error)
			->with('item_id', $item_id)
			->with('user_customer',$this->user_customer)
			->with('data', $dataShow)
			->with('arrViewImgOther', $arrViewImgOther)
			->with('imagePrimary', $imagePrimary)
			->with('imageHover', $imageHover)
			->with('optionCategory', $optionCategory)
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

		$this->validInforItem($dataSave);
		if(empty($this->error)){
			//lay tên danh mục
			$dataSave['item_category_name'] = isset($arrCategory[$dataSave['item_category_id']])?$arrCategory[$dataSave['item_category_id']]: '';
			$dataSave['customer_id'] = $this->user_customer['customer_id'];
			$dataSave['customer_name'] = $this->user_customer['customer_name'];
			$dataSave['is_customer'] = $this->user_customer['is_customer'];
			$dataSave['item_province_id'] = $this->user_customer['customer_province_id'];
			$dataSave['item_district_id'] = $this->user_customer['customer_district_id'];
			$dataSave['item_block'] = CGlobal::PRODUCT_NOT_BLOCK;

			if($item_id > 0){
				$items = array();
				if(isset($this->user_customer['customer_id']) && $this->user_customer['customer_id'] > 0 && $item_id > 0){
					$items = Items::getItemByCustomerId($this->user_customer['customer_id'], $item_id);
				}
				if(!empty($items)){
					if($item_id > 0){//cap nhat
						$dataSave['time_update'] = time();
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
				//FunctionLib::debug($dataSave);
				$dataSave['time_created'] = time();
				$dataSave['time_ontop'] = time();
				$dataSave['time_update'] = time();
				if(Items::addData($dataSave)){
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
			->with('optionTypePrice', $optionTypePrice)
			->with('arrBannerRight', $arrBannerRight);
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
	//ajaz set Top tin dang
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
				//check trong cung 1 ngay chi duoc 5 lan set ontop
				$numberUpTopCurrent = isset($inforCustomer['customer_number_ontop_in_day']) ? $inforCustomer['customer_number_ontop_in_day']: 5;

				if(!empty($inforCustomer)){
					//check cung 1 ngày set top
					if(isset($inforCustomer['customer_date_ontop']) && strcmp($inforCustomer['customer_date_ontop'],$today) == 0){
						if($numberUpTopCurrent < 5){
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
									$data['isIntOk'] = 1;
									$data['msg'] = 'OnTop tin thành công';
									return Response::json($data);
								}
							}
						}else{
							$data['msg'] = 'Bạn đã up đủ số lượt cho ngày hôm nay';
							return Response::json($data);
						}
					}
					//check khác ngày settop
					elseif(isset($inforCustomer['customer_date_ontop']) && strcmp($inforCustomer['customer_date_ontop'],$today) != 0 && ($numberUpTopCurrent == 5 || $numberUpTopCurrent == 0)){
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
								$data['isIntOk'] = 1;
								$data['msg'] = 'OnTop tin thành công';
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


	public function loginFacebook(){
		
		$fb = new Facebook\Facebook ([
				'app_id' => '1806153732995309',
				'app_secret' => '9ffa193548158f07eb1e28eaff4a5403',
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
			$loginUrl = $helper->getLoginUrl(Config::get('config.WEB_ROOT').'/facebooklogin', $permissions);
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
	public function loginGoogle(){
	$client_id = '803912434754-0lpl6oc4t68ld167qn90i4uhldrlsi33.apps.googleusercontent.com'; 
		$client_secret = 'BZJ1GVA-mG57HHOeJSKJBKeB';
		$redirect_uri = 'http://dev.sanphamredep.com/googlelogin';
		
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