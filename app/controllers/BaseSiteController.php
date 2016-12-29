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
    public function header($banner_page = 0, $category_id = 0, $province_id = 0, $keyword = ''){
		//tim kiem
		$keyword = htmlspecialchars(Request::get('keyword', ''));
        $messages = FunctionLib::messages('messages');
		$user_customer = $this->user_customer;
		if(empty($user_customer)){
			$this->popupHide();
		}

		//banner header quang cáo
		$arrBanner = Banner::getBannerAdvanced(CGlobal::BANNER_TYPE_TOP, $banner_page, $category_id);
		$arrBannerHead = $this->getBannerWithPosition($arrBanner);// hi?n th? theo: TOP, CENTER, BOTTOM

		//cap nhat luot click tu cac site gan link
		$url_source = trim(Request::get('url_source', ''));
		if(trim($url_source) != ''){
			$nameSite = base64_decode($url_source);
			$hostIp = Request::getClientIp();
			$userShareClick = ClickShare::checkIpShareObject(13);
			if(!in_array($hostIp,array_keys($userShareClick))){
				$clickBanner = ClickShare::addData(array('share_ip'=>$hostIp,
					'share_time'=>time(),
					'object_id'=>13,
					'object_name'=>$nameSite));
			}
		}

		//cap nhat luot click CTV click link
		$sv_share = trim(Request::get('sv_share', ''));
		if(trim($sv_share) != ''){
			$stringUserShare = base64_decode($sv_share);
			$pos1 = strrpos($stringUserShare, "_");
			$object_id = (int)substr($stringUserShare, 0, $pos1);
			$object_name = substr($stringUserShare, $pos1+1, strlen($stringUserShare));

			$hostIp = Request::getClientIp(); //$ip = $_SERVER['REMOTE_ADDR'];
			$userShare = ClickShare::checkIpShareObject($object_id);
			if(!in_array($hostIp,array_keys($userShare))){
				$clickBanner = ClickShare::addData(array('share_ip'=>$hostIp,
					'share_time'=>time(),
					'object_id'=>$object_id,
					'object_name'=>$object_name));
			}
		}

		$this->layout->header = View::make("site.BaseLayouts.header")
								->with('keyword', $keyword)
								->with('category_id', $category_id)//dung cho search
								->with('province_id', $province_id)//dung cho search
								->with('user_customer', $user_customer)
								->with('messages', $messages)
								->with('arrBannerHead', $arrBannerHead);
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
	public function popupHide(){
		$this->layout->popupHide = View::make("site.BaseLayouts.popupHide");
	}
	public function menuLeft($banner_page = 0, $category_id = 0, $province_id = 0){
		$menuCategoriessAll = Category::getCategoriessAll();

		$arrBannerLeft = Banner::getBannerAdvanced(CGlobal::BANNER_TYPE_LEFT, $banner_page, $category_id, $province_id);
		$arrBannerShow = $this->getBannerWithPosition($arrBannerLeft);// hi?n th? theo: TOP, CENTER, BOTTOM

		$this->layout->menuLeft = View::make("site.BaseLayouts.menuLeft")
								->with('arrBannerShow', $arrBannerShow)
								->with('catid', $category_id)
								->with('menuCategoriessAll', $menuCategoriessAll);
	}
	//dung chung quang cao cac page
	public function bannerRight($banner_type = 0, $banner_page = 0, $banner_category_id = 0, $banner_province_id = 0){
		$arrBannerRight = Banner::getBannerAdvanced($banner_type, $banner_page, $banner_category_id, $banner_province_id);
		$arrBannerShow = $this->getBannerWithPosition($arrBannerRight); // hi?n th? theo: TOP, CENTER, BOTTOM
		return $arrBannerShow;
	}
	public function getBannerWithPosition($arrBanner = array()){
		$arrBannerShow = array();
		if(sizeof($arrBanner) > 0){
			foreach($arrBanner as $id_banner =>$valu){
				$banner_is_run_time = 1;
				if($valu->banner_is_run_time == CGlobal::BANNER_NOT_RUN_TIME){
					$banner_is_run_time = 1;
				}else{
					$banner_start_time = $valu->banner_start_time;
					$banner_end_time = $valu->banner_end_time;
					$date_current = time();
					if($banner_start_time > 0 && $banner_end_time > 0 && $banner_start_time <= $banner_end_time){
						if($banner_start_time <= $date_current && $date_current <= $banner_end_time){
							$banner_is_run_time = 1;
						}
					}else{
						$banner_is_run_time = 0;
					}
				}
				if($banner_is_run_time == 1){
					$arrBannerShow[$valu->banner_position][] = $valu;
				}
			}
		}
		return $arrBannerShow;
	}

	public function getControllerAction(){
		$controller = Route::currentRouteAction();
		$action = substr($controller, (strpos($controller, '@')+1));
		return $pageCurrent = isset(CGlobal::$arrPageCurrent[$action]) ? CGlobal::$arrPageCurrent[$action] : 0;
	}

}