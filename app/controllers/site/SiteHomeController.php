<?php
/*
* @Created by: DUY NGUYEN
* @Author	 : nguyenduypt86@gmail.com
* @Date 	 : 01/2016
*/

class SiteHomeController extends BaseSiteController{
    public function __construct(){
        parent::__construct();
        FunctionLib::site_css('lib/font-awesome/4.2.0/css/font-awesome.min.css', CGlobal::$POS_HEAD);
    }

    public function index(){
    	
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
				$meta_img = ThumbImg::thumbBaseNormal(CGlobal::FOLDER_INFO, $arrMeta->info_id, $arrMeta->info_img, 550, 0, '', true, true);
			}
		}
		SeoMeta::SEO($meta_img, $meta_title, $meta_keywords, $meta_description);
		
		$this->header();
        $this->layout->content = View::make('site.SiteLayouts.Home');
        $this->footer();
    }
}