<?php

class SiteHomeController extends BaseSiteController
{
    public function __construct(){
        parent::__construct();
    }

    private $str_field_product_get = 'product_id,product_name,category_id,category_name,product_image,product_image_hover,product_status,product_price_sell,product_price_market,product_type_price,product_selloff,user_shop_id,user_shop_name,is_shop,is_block';//cac truong can lay
    //trang chu
    public function index(){
    	$this->header();
    	$this->menuLeft();
    	//Meta title
    	$meta_title='';
    	$meta_keywords='';
    	$meta_description='';
    	$meta_img='';
    	$arrMeta = Info::getItemByKeyword('SITE_SEO_HOME');
    	if(!empty($arrMeta)){
    		$meta_title = $arrMeta->meta_title;
    		$meta_keywords = $arrMeta->meta_keywords;
    		$meta_description = $arrMeta->meta_description;
    		$meta_img = $arrMeta->info_img;
    		if($meta_img != ''){
    			//$meta_img = ThumbImg::thumbBaseNormal(CGlobal::FOLDER_INFO, $arrMeta->info_id, $arrMeta->info_img, 550, 0, '', true, true);
    		}
    	}
    	FunctionLib::SEO($meta_img, $meta_title, $meta_keywords, $meta_description);
    	
        $this->layout->content = View::make('site.SiteLayouts.Home');
        $this->footer();
    }
    
	public function page404(){
    	
		$meta_title = $meta_keywords = $meta_description = '404';
		$meta_img= '';
		FunctionLib::SEO($meta_img, $meta_title, $meta_keywords, $meta_description);
		
		$this->header();
    	$this->layout->content = View::make('site.SiteLayouts.page404');
    	$this->footer();
    }
    
    public function pageCategory($catname, $catid){
    	$this->header();
    	$this->menuLeft($catid);
    	$this->layout->content = View::make('site.SiteLayouts.ListProduct');
    	$this->footer();
    }
    public function pageProductView(){
    	$this->header();
    	$this->menuLeft();
    	$this->layout->content = View::make('site.SiteLayouts.DetailProduct');
    	$this->footer();
    }
}

