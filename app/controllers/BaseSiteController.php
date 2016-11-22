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
    }
    public function header(){
        $messages = FunctionLib::messages('messages');
		$user_customer = $this->user_customer;
		if(empty($user_customer)){
			$this->popupHide();
		}
		$this->layout->header = View::make("site.BaseLayouts.header")
								->with('user_customer', $user_customer)
								->with('messages', $messages);
    }
	public function popupHide(){
		$this->layout->popupHide = View::make("site.BaseLayouts.popupHide");
	}
	public function menuLeft(){
		$this->layout->menuLeft = View::make("site.BaseLayouts.menuLeft");
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