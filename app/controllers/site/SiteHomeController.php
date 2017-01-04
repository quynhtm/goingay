<?php

class SiteHomeController extends BaseSiteController
{
    public function __construct(){
        parent::__construct();
        FunctionLib::site_css('lib/owl.carousel/owl.carousel.css', CGlobal::$POS_HEAD);
        FunctionLib::site_js('lib/owl.carousel/owl.carousel.min.js', CGlobal::$POS_END);
    }

	private $str_field_items_get = 'item_id,item_name,item_type_price,item_price_sell,item_content,item_image,item_image_other,item_category_id,item_category_name,item_number_view,item_status,item_is_hot,item_province_id,item_province_name,item_district_id,customer_id,is_customer,customer_name,time_ontop';//cac truong can lay

    //trang chu
    public function index(){
		$banner_page = $this->getControllerAction();
    	$this->header($banner_page);
    	$this->menuLeft($banner_page);
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
    	}
    	FunctionLib::SEO($meta_img, $meta_title, $meta_keywords, $meta_description);
		$resultHomeList = $resultHomeTop = $resultHomeSlider = array();

		//List san pham noi bat TOP
		$number_show_hot = 3;
		$searchHomeTop['field_get'] = $this->str_field_items_get;
		$resultHomeTop = self::getItemHot($searchHomeTop,$number_show_hot);

		//List san pham noi bat SLIDE
		$number_show_slider = 10;
		$searchHomeSlider['field_get'] = $this->str_field_items_get;
		$resultHomeSlider = self::getItemHot($searchHomeSlider,$number_show_slider,$number_show_hot);

		//lay du lieu hien thi theo danh mục
		//lay mang danh mục hiển thị ra ngoài trang chủ
		$cateShowFront = Category::getCategoryShowFrontSite();
		if(!empty($cateShowFront)){
			foreach($cateShowFront as $keyCat=>$inforCat){
				$resultHomeList[$keyCat]['category_icons'] = $inforCat['category_icons'];
				$resultHomeList[$keyCat]['category_name'] = $inforCat['category_name'];
				$resultHomeList[$keyCat]['dataItem'] = Items::getItemsHomeSite($keyCat);
			}
		}

		//tinh thanh
		$arrProvince = Province::getAllProvince();
        $this->layout->content = View::make('site.SiteLayouts.Home')
			->with('arrProvince', $arrProvince)
			->with('resultHomeTop', $resultHomeTop)
			->with('resultHomeSlider', $resultHomeSlider)
			->with('resultHomeList', $resultHomeList);
        $this->footer();
    }

	//tim kiem tin đăng
	public function searchItems(){
		$keyword = htmlspecialchars(trim(Request::get('keyword','')));
		$category_id = (int)(trim(Request::get('category_id',0)));
		$province_id = (int)(trim(Request::get('city_id',0)));

		if($keyword == ''){
			return Redirect::route('site.home');
		}
		$meta_title = $meta_keywords = $meta_description = 'Tìm kiếm nhanh'.($keyword != '')?$keyword:'';
		$meta_img= '';
		FunctionLib::SEO($meta_img, $meta_title, $meta_keywords, $meta_description);
		$banner_page = $this->getControllerAction();
		$this->header($banner_page, $category_id, $province_id, $keyword);
		$this->menuLeft($banner_page,0);

		//List san pham tim kiếm
		$search = $data = array();
		$totalSearch = 0;
		if($category_id > 0){
			$search['item_category_id'] = $category_id;
		}
		if($province_id > 0){
			$search['item_province_id'] = $province_id;
		}
		$search['item_name'] = $keyword;
		$search['field_get'] = $this->str_field_items_get;

		//danh sach tin dang cua danh m?c
		$pageNo = (int) Request::get('page_no',1);
		$limit = CGlobal::number_show_20;
		$offset = ($pageNo == 1)? 0: ($pageNo - 1) * $limit;
		$resultSearch = Items::getItemsSite($search,$limit,$offset,$totalSearch);
		$paging = $totalSearch > 0 ? Pagging::getNewPager(3, $pageNo, $totalSearch, $limit, $search) : '';

		//tỉnh thành
		$arrProvince = Province::getAllProvince();

		//quang cao ben phải
		$arrBannerRight = $this->bannerRight(CGlobal::BANNER_TYPE_RIGHT,$banner_page, $category_id, $province_id);

		$this->layout->content = View::make('site.SiteLayouts.searchItems')
			->with('arrProvince', $arrProvince)
			->with('arrCustomer', array())
			->with('paging', $paging)
			->with('total', $totalSearch)
			->with('arrBannerRight', $arrBannerRight)
			->with('resultSearch', $resultSearch);
		$this->footer();
	}

	//chi tiet tin rao
	public function pageDetailItem( $item_name, $item_category_id,$item_id){
		if((int)$item_id <= 0){
			return Redirect::route('site.home');
		}
		// tin hien th?
		$itemShow = Items::getItemsByID($item_id);
		if(empty($itemShow)){
			return Redirect::route('site.home');
		}
		if($itemShow->item_status != CGlobal::status_show || $itemShow->item_block != CGlobal::ITEMS_NOT_BLOCK){
			return Redirect::route('site.home');
		}

		$banner_page = $this->getControllerAction();
		$this->header($banner_page, $itemShow->item_category_id, $itemShow->item_province_id);
		$this->menuLeft($banner_page, $itemShow->item_category_id);

		//seo
		$meta_title = addslashes($itemShow->item_name);
		$meta_keywords = CGlobal::web_name.' - '.addslashes($itemShow->item_name);
		$meta_description = addslashes(FunctionLib::substring($itemShow->item_content,200));
		$meta_img= ThumbImg::getImageThumb(CGlobal::FOLDER_PRODUCT, $itemShow->item_id, $itemShow->item_image, CGlobal::sizeImage_200);
		$url_detail = FunctionLib::buildLinkDetailItem($itemShow->item_id, $itemShow->item_name, $itemShow->item_category_id);
		FunctionLib::SEO($meta_img, $meta_title, $meta_keywords, $meta_description,$url_detail);

		//thong tin khach dang tin
		$arrCustomer = UserCustomer::getByID($itemShow->customer_id);
		//FunctionLib::debug($itemShow);

		//t?nh thï¿½nh
		$arrProvince = Province::getAllProvince();

		//thong tin danh muc
		$arrCategory = Category::getCategoriessAll();//hien thi icons cua danh muc

		//tin dang cua cung danh muc
		$limit = CGlobal::number_show_15;
		$offset = 0;
		$search = $data = array();
		$totalSearch = 0;
		$search['str_not_item_id'] = $itemShow->item_id;
		$search['item_category_id'] = $itemShow->item_category_id;
		$search['field_get'] = $this->str_field_items_get;
		$resultItemCategory = Items::getItemsSite($search,$limit,$offset,$totalSearch);

		//quang cao ben phải
		$arrBannerRight = $this->bannerRight(CGlobal::BANNER_TYPE_RIGHT,$banner_page, $itemShow->item_category_id, $itemShow->item_province_id);

		$this->layout->content = View::make('site.SiteLayouts.DetailItem')
			->with('itemShow', $itemShow)
			->with('arrProvince', $arrProvince)
			->with('resultItemCategory', $resultItemCategory)
			->with('arrCategory', $arrCategory)
			->with('arrBannerRight', $arrBannerRight)
			->with('arrCustomer', $arrCustomer);
		$this->footer();
	}

	//danh sact tin dang theo danh muc
    public function pageCategory($catname, $catid){
		if((int)$catid <= 0){
			return Redirect::route('site.home');
		}
		//neu co tim kiem theo tinh thanh
		$province_id = Request::get('city_id',0);

		$meta_title = $meta_keywords = $meta_description = $meta_img= '';
		$url_seo = FunctionLib::buildLinkCategory($catid, $catname);
		FunctionLib::SEO($meta_img, $meta_title, $meta_keywords, $meta_description,$url_seo);

		$banner_page = $this->getControllerAction();
    	$this->header($banner_page, $catid, $province_id);
    	$this->menuLeft($banner_page, $catid);

		//tinh thanh
		$arrProvince = Province::getAllProvince();

		//thong tin danh muc
		$arrCategory = Category::getCategoriessAll();

		//List san pham noi bat TOP
		$number_show_hot = 3;
		$searchHot['item_category_id'] = $catid;
		$searchHot['field_get'] = $this->str_field_items_get;
		$resultHot = self::getItemHot($searchHot,$number_show_hot);

		//danh sach tin dang cua danh m?c
		$pageNo = (int) Request::get('page_no',1);
		$limit = CGlobal::number_limit_show;
		$offset = ($pageNo == 1)? $number_show_hot: ($pageNo - 1) * $limit;//b? 3 cï¿½i n?i b?t ? trï¿½n ?i
		$search = $data = array();
		$totalSearch = 0;
		$province_name = '';
		if($province_id > 0 && isset($arrProvince[$province_id])){
			$search['item_province_id'] = $province_id;
			$province_name = $arrProvince[$province_id];
		}
		$search['item_category_id'] = $catid;
		$search['field_get'] = $this->str_field_items_get;
		$resultItemCategory = Items::getItemsSite($search,$limit,$offset,$totalSearch);
		$paging = $totalSearch > 0 ? Pagging::getNewPager(3, $pageNo, $totalSearch, $limit, $search) : '';

		//quang cao ben phải
		$arrBannerRight = $this->bannerRight(CGlobal::BANNER_TYPE_RIGHT,$banner_page, $catid, $province_id);

    	$this->layout->content = View::make('site.SiteLayouts.ListItemCategory')
			->with('arrProvince', $arrProvince)
			->with('arrCategory', $arrCategory)
			->with('category_id', $catid)
			->with('province_name', $province_name)
			->with('paging', $paging)
			->with('total', $totalSearch)
			->with('resultHot', $resultHot)
			->with('arrBannerRight', $arrBannerRight)
			->with('resultItemCategory', $resultItemCategory);
    	$this->footer();
    }

	//Danh sach tin da dang cua khach
	public function pageListItemCustomer($customer_name,$customer_id){
		//thong tin khach dang tin
		$arrCustomer = UserCustomer::getByID($customer_id);
		if(empty($arrCustomer)){
			return Redirect::route('site.home');
		}
		$meta_title = $meta_keywords = $meta_description = $meta_img= '';
		$url_seo = FunctionLib::buildLinkItemsCustomer($arrCustomer->customer_id, $arrCustomer->customer_name);
		FunctionLib::SEO($meta_img, $meta_title, $meta_keywords, $meta_description,$url_seo);

		$banner_page = $this->getControllerAction();
		$this->header($banner_page);
		$this->menuLeft($banner_page,0);

		//List san pham cï¿½ng danh muc n?i b?t TOP
		$number_show_hot = 3;
		$searchHot['customer_id'] = $customer_id;
		$searchHot['field_get'] = $this->str_field_items_get;
		$resultHot = self::getItemHot($searchHot,$number_show_hot);

		//danh sach tin dang cua danh m?c
		$pageNo = (int) Request::get('page_no',1);
		$limit = CGlobal::number_show_20;
		$offset = ($pageNo == 1)? $number_show_hot: ($pageNo - 1) * $limit;
		$search = $data = array();
		$totalSearch = 0;
		$search['customer_id'] = $customer_id;
		$search['page_no'] = $pageNo;
		$resultItemCategory = Items::getItemsSite($search,$limit,$offset,$totalSearch);
		$paging = $totalSearch > 0 ? Pagging::getNewPager(3, $pageNo, $totalSearch, $limit, $search) : '';

		//t?nh thï¿½nh
		$arrProvince = Province::getAllProvince();

		//quang cao ben phải
		$arrBannerRight = $this->bannerRight(CGlobal::BANNER_TYPE_RIGHT, $banner_page);

		$this->layout->content = View::make('site.SiteLayouts.ListItemCustomer')
			->with('arrProvince', $arrProvince)
			->with('arrCustomer', $arrCustomer)
			->with('paging', $paging)
			->with('total', $totalSearch)
			->with('arrBannerRight', $arrBannerRight)
			->with('resultHot', $resultHot)
			->with('resultItemCategory', $resultItemCategory);
		$this->footer();
	}

	//ham dung common cho site
	public function getItemHot($search = array(),$limit=10,$offset = 0){
		$data = array();
		if(!empty($search)){
			$data = Items::getItemsSite($search,$limit,$offset,$totalSearch);
		}
		return $data;
	}

	public function pageNews(){
		$banner_page = CGlobal::BANNER_PAGE_SEARCH; //page tìm kiếm
		$this->header($banner_page);
		$this->menuLeft($banner_page);
		//list tin tuc lien quan
		$search['news_status'] = CGlobal::status_show;
		$search['field_get'] = 'news_id,news_title,news_status,news_image,news_desc_sort';//cac truong can lay
		$arrListNew = News::searchByCondition($search, CGlobal::number_show_15, 0,$total);

		$this->layout->content = View::make('site.SiteLayouts.pageNews')
			->with('arrListNew', $arrListNew);
		$this->footer();
	}
	//chi tiet tin tuc
	public function pageDetailNew($new_id, $new_name){
		$inforNew = News::getNewByID($new_id);
		if(empty($inforNew)){
			return Redirect::route('site.home');
		}
		if($inforNew->news_status != CGlobal::status_show){
			return Redirect::route('site.home');
		}
		$banner_page = $this->getControllerAction();
    	$this->header($banner_page);
    	$this->menuLeft($banner_page);
		//seo
		$meta_title = $inforNew->news_title;
		$meta_keywords = CGlobal::web_name;
		$meta_description = $inforNew->news_desc_sort;
		$meta_img= '';
		FunctionLib::SEO($meta_img, $meta_title, $meta_keywords, $meta_description);

		//list tin tuc lien quan
		$search['news_category'] = $inforNew->news_category;
		$search['news_status'] = CGlobal::status_show;
		$search['not_news_id'] = $new_id;
		$search['field_get'] = 'news_id,news_title,news_status';//cac truong can lay
		$arrListNew = News::searchByCondition($search, CGlobal::number_show_15, 0,$total);
		//FunctionLib::debug($arrListNew);

		//quang cao ben phải
		$arrBannerRight = $this->bannerRight(CGlobal::BANNER_TYPE_RIGHT,$banner_page);

    	$this->layout->content = View::make('site.SiteLayouts.DetailNews')
			->with('inforNew', $inforNew)
			->with('arrBannerRight', $arrBannerRight)
			->with('arrListNew', $arrListNew);
    	$this->footer();
    }

	public function page404(){
		$meta_title = $meta_keywords = $meta_description = '404';
		$meta_img= '';
		FunctionLib::SEO($meta_img, $meta_title, $meta_keywords, $meta_description);
		$banner_page = CGlobal::BANNER_PAGE_SEARCH; //page tìm kiếm
		$this->header($banner_page);
		$this->layout->content = View::make('site.SiteLayouts.page404');
		$this->footer();
	}
	public function pageContact(){
		$meta_title = $meta_keywords = $meta_description = 'Liên hệ Raovat30s.vn';
		$meta_img= '';
		FunctionLib::SEO($meta_img, $meta_title, $meta_keywords, $meta_description);

		$banner_page = $this->getControllerAction();
		$this->header($banner_page);
		$this->menuLeft($banner_page);
		$arrBannerRight = $this->bannerRight(CGlobal::BANNER_TYPE_RIGHT,$banner_page);

		$messages = FunctionLib::messages('messages');
		if(!empty($_POST)){
			$token = Request::get('_token', '');
			if(Session::token() === $token){
				$contact_name = addslashes(Request::get('txtName', ''));
				$contact_phone = addslashes(Request::get('txtMobile', ''));
				$contact_email = addslashes(Request::get('txtEmail', ''));
				$contact_title = addslashes(Request::get('txtTitle', ''));
				$contact_content = addslashes(Request::get('txtMessage', ''));
				$get_code = addslashes(Request::get('captcha', ''));
				$contact_created = time();
				$code = '';
				if(Session::has('security_code')){
					$code = Session::get('security_code');
				}
				if($contact_title != '' && $contact_name != '' && $contact_phone !=''  && $contact_content !='' && $get_code != '' && $code == $get_code){
					$dataInput = array(
							'contact_user_name_send'=>$contact_name,
							'contact_phone_send'=>$contact_phone,
							'contact_email_send'=>$contact_email,
							'contact_title'=>$contact_title,
							'contact_content'=>$contact_content,
							'contact_time_creater'=>$contact_created,
							'contact_status'=>0,
					);
					$query = Contact::addData($dataInput);
					if($query > 0){
						$messages = FunctionLib::messages('messages', 'Cảm ơn bạn đã gửi thông tin liên hệ. Chúng tôi sẽ liên hệ với bạn trong thời gian sớm nhất!');
						return Redirect::route('site.pageContact');
					}
				}else{
					$messages = FunctionLib::messages('messages', 'Mã xác nhận chưa đúng!', 'error');
					return Redirect::route('site.pageContact');
				}
				
			}
		}
		
		$this->layout->content = View::make('site.SiteLayouts.pageContact')
								->with('arrBannerRight', $arrBannerRight)
								->with('messages', $messages);
		$this->footer();
	}
	public function linkCaptcha(){
		$captchaImages = new captchaImages(60,30,4);
	}
	function captchaCheckAjax(){
		$code = '';
		if(Session::has('security_code')){
			$code = Session::get('security_code');
		}
		$get_code = addslashes(Request::get('captcha', ''));
		if($get_code != '' && $code == $get_code){
			echo 1;
		}else{
			echo 0;
			Session::forget('security_code');
		}
		exit();
	}
}
