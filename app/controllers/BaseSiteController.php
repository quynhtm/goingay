<?php
/*
* @Created by: DUY NGUYEN
* @Author	 : nguyenduypt86@gmail.com
* @Date 	 : 01/2016
*/

class BaseSiteController extends BaseController{
    protected $layout = 'site.BaseLayouts.index';
    public function __construct(){
       //Init
    }

    public function header(){
        $this->layout->header = View::make("site.BaseLayouts.header");
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
}