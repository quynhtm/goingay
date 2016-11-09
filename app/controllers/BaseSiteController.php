<?php
/*
* @Created by: DUY NGUYEN
* @Author	 : nguyenduypt86@gmail.com
* @Date 	 : 01/2016
*/

class BaseSiteController extends BaseController{
    protected $layout = 'site.BaseLayouts.index';
    protected $user_customer = array();
    
    public function __construct(){
       //Init
    	$this->user_customer = UserCustomer::user_login();
    	
    	FunctionLib::site_js('libs/jAlert/jquery.alerts.js', CGlobal::$POS_END);
    	FunctionLib::site_css('libs/jAlert/jquery.alerts.css', CGlobal::$POS_HEAD);
    }

    public function header(){
    	if(empty($this->user_customer)){
    		$this->popupHide();
    	}
    	
    	$messages = FunctionLib::messages('messages');
    	
    	$this->layout->header = View::make("site.BaseLayouts.header")->with('user_customer', $this->user_customer)->with('messages', $messages);
    }

    public function footer(){
    	//So dien thoai
    	$address='';
    	$arrAddress = Info::getItemByKeyword('SITE_FOOTER_LEFT');
    	if(!empty($arrAddress)){
    		$address = stripslashes($arrAddress->info_content);
    	}
    	$this->layout->footer = View::make("site.BaseLayouts.footer")
    							->with('address', $address);
    }
    public function popupHide(){
    	$this->layout->popupHide = View::make("site.BaseLayouts.popupHide");
    }
}