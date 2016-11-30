<?php

class SiteHomeController extends BaseSiteController
{
    public function __construct(){
        parent::__construct();
    }

    private $str_field_items_get = 'item_id,item_name,item_type_price,item_price_sell,item_content,item_image,item_image_other,item_category_id,item_category_name,item_number_view,item_status,item_is_hot,item_province_id,item_district_id,customer_id,is_customer,customer_name,time_ontop';//cac truong can lay

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

	//chi tiet tin rao
	public function pageDetailItem($item_id, $item_name, $item_category_id){
		$this->header();
		$this->menuLeft();
		$this->layout->content = View::make('site.SiteLayouts.DetailItem');
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

	//danh sact tin dang theo danh muc
    public function pageCategory($catname, $catid){
		$meta_title = $meta_keywords = $meta_description = $catname;
		$meta_img= '';
		FunctionLib::SEO($meta_img, $meta_title, $meta_keywords, $meta_description);

    	$this->header();
    	$this->menuLeft($catid);

		//List san pham cùng danh muc n?i b?t TOP
		$number_show_hot = 3;
		$searchHot['item_category_id'] = $catid;
		$searchHot['item_image'] = 1;//check có ?nh ??i di?n
		$searchHot['field_get'] = $this->str_field_items_get;
		$resultHot = self::getItemHot($searchHot,$number_show_hot);

		//danh sach tin dang cua danh m?c
		$pageNo = (int) Request::get('page_no',1);
		$limit = CGlobal::number_limit_show;
		$offset = ($pageNo == 1)? $number_show_hot: ($pageNo - 1) * $limit;//b? 3 cái n?i b?t ? trên ?i
		$search = $data = array();
		$totalSearch = 0;
		$search['item_category_id'] = $catid;
		$search['field_get'] = $this->str_field_items_get;
		$resultItemCategory = Items::getItemsSite($search,$limit,$offset,$totalSearch);
		$paging = $totalSearch > 0 ? Pagging::getNewPager(3, $pageNo, $totalSearch, $limit, $search) : '';

		//t?nh thành
		$arrProvince = Province::getAllProvince();

		//thong tin danh m?c
		$arrCategory = Category::getAllParentCategoryId();

    	$this->layout->content = View::make('site.SiteLayouts.ListItemCategory')
			->with('arrProvince', $arrProvince)
			->with('arrCategory', $arrCategory)
			->with('category_id', $catid)
			->with('paging', $paging)
			->with('total', $totalSearch)
			->with('resultHot', $resultHot)
			->with('resultItemCategory', $resultItemCategory);
    	$this->footer();
    }

	//chi tiet tin tuc
	public function pageDetailNew($new_id, $new_name){
    	$this->header();
    	$this->menuLeft();
    	$this->layout->content = View::make('site.SiteLayouts.DetailNews');
    	$this->footer();
    }

    //Danh sach tin da dang cua khach
	public function pageListItemCustomer($customer_id, $customer_name){
    	$this->header();
    	$this->menuLeft();
    	$this->layout->content = View::make('site.SiteLayouts.ListItemCustomer');
    	$this->footer();
    }

	//ham dung common cho site
	public function getItemHot($search = array(),$limit){
		$data = array();
		if(!empty($search)){
			$data = Items::getItemsSite($search,$limit,0,$totalSearch);
		}
		return $data;
	}
}

