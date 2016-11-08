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
    }

    public function header(){
    	if(empty($this->user_customer)){
    		$this->popupHide();
    	}
    	
    	$this->layout->header = View::make("site.BaseLayouts.header")->with('user_customer', $this->user_customer);
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