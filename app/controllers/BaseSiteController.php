<?php
/*
* @Created by: DUYNX
* @Author    : nguyenduypt86@gmail.com
* @Date      : 11/2016
* @Version   : 1.0
*/

class BaseSiteController extends BaseController
{
    protected $layout = 'site.BaseLayouts.index';
    protected $user_customer = array();
    
    public function __construct(){
    	FunctionLib::site_css('font-awesome/4.2.0/css/font-awesome.min.css', CGlobal::$POS_HEAD);
    	FunctionLib::site_css('frontend/css/usercustomer.css', CGlobal::$POS_HEAD);
    	FunctionLib::site_js('frontend/js/usercustomer.js', CGlobal::$POS_END);
    	FunctionLib::site_js('frontend/js/site.js', CGlobal::$POS_END);
    	FunctionLib::site_css('lib/jAlert/jquery.alerts.css', CGlobal::$POS_HEAD);
    	FunctionLib::site_js('lib/jAlert/jquery.alerts.js', CGlobal::$POS_END);
        $this->user_customer = Session::has('user_customer') ? Session::get('user_customer') : array();
		
		FunctionLib::site_css('lib/ResponsiveSlides/responsiveslides.css', CGlobal::$POS_HEAD);
    	FunctionLib::site_js('lib/ResponsiveSlides/responsiveslides.min.js', CGlobal::$POS_END);
    	
    	FunctionLib::site_js('lib/sticky/jquery.sticky.js', CGlobal::$POS_END);
    }
    public function header(){
		//tim kiem
		$keyword = htmlspecialchars(Request::get('keyword', ''));

        $messages = FunctionLib::messages('messages');
		$user_customer = $this->user_customer;
		if(empty($user_customer)){
			$this->popupHide();
		}
		$arrBannerHead = Banner::getBannerAdvanced(CGlobal::BANNER_TYPE_TOP, $banner_page = 0, $banner_category_id = 0, $banner_province_id = 0);
		/*
		$userAdmin = User::user_login();
		if(!empty($userAdmin)){
			FunctionLib::debug($arrBannerHead);
		}*/
		$this->layout->header = View::make("site.BaseLayouts.header")
								->with('keyword', $keyword)
								->with('user_customer', $user_customer)
								->with('messages', $messages)
								->with('arrBannerHead', $arrBannerHead);
    }
	public function popupHide(){
		$this->layout->popupHide = View::make("site.BaseLayouts.popupHide");
	}
	public function menuLeft($catid = 0){
		$menuCategoriessAll = Category::getCategoriessAll();
		$arrBannerLeft = Banner::getBannerAdvanced(CGlobal::BANNER_TYPE_LEFT, $banner_page = 0, $banner_category_id = 0, $banner_province_id = 0);
		$this->layout->menuLeft = View::make("site.BaseLayouts.menuLeft")
								->with('arrBannerLeft', $arrBannerLeft)
								->with('catid', $catid)
								->with('menuCategoriessAll', $menuCategoriessAll);
	}
	//dung chung quang cao cac page
	public function bannerRight($banner_type = 0, $banner_page = 0, $banner_category_id = 0, $banner_province_id = 0){
		$arrBannerRight = Banner::getBannerAdvanced($banner_type, $banner_page, $banner_category_id, $banner_province_id);
		return $arrBannerRight;
	}
    public function footer(){
		$address='';
		$arrAddress = Info::getItemByKeyword('SITE_FOOTER_LEFT');
		if(!empty($arrAddress)){
			$address = $arrAddress->info_content;
		}
        $this->layout->footer = View::make("site.BaseLayouts.footer")
								->with('address', $address);
    }
}