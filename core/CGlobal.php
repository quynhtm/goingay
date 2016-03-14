<?php
class CGlobal{
	static $js_ver	= '2.0';
	static $css_ver	= '2.0';
	static $img_ver	= '1.0';
	static $ip = 0;

    //dung de login
    static $clock_user		=	1;
    static $status_user		=	1;
    static $domain_site		=	'goingay.com';

    //trang thai
    static $arrStatus = array(0=>'Ẩn',1=>'Hiện');

    const size_image_40 = 40;
    const size_image_80 = 80;
    const size_image_100 = 100;
    const size_image_120 = 120;
    const size_image_136 = 136;
    const size_image_150 = 100;
    const size_image_180 = 180;
    const size_image_250 = 250;
    const size_image_350 = 350;
    const size_image_450 = 450;
    const size_image_700 = 700;

    const status_error = 13;

   static $product_other_image_sizes = array(
			40  => array('width' => 40,   'height' => 40),
			300 => array('width' => 300,  'height' => 300)
	);    
    static $image_product = array(
			self::size_image_40  => array('width' => 40,   'height' => 40),//list admin
            self::size_image_80 => array('width' => 80,   'height' => 80),//popup insert
            self::size_image_120 => array('width' => 120,   'height' => 120),//Site home Right
            self::size_image_250 => array('width' => 250,  'height' => 250),//list admin
            self::size_image_700 => array('width' => 700,  'height' => 700)//popup insert nội dung
	);
	//QuynhTM size cho anh quang cáo   
    static $adv_image_sizes = array(
			280 => array('width' => 280,  'height' => 90), //List top
			220 => array('width' => 220,  'height' => 190), //List righ
			40  => array('width' => 40,   'height' => 40)//list admin
		);
	
	//QuynhTM size cho anh tin tức
    static $image_news = array(
        self::size_image_40  => array('width' => 40,   'height' => 40),//list admin
        self::size_image_80 => array('width' => 80,   'height' => 80),//popup insert
        self::size_image_150 => array('width' => 150,   'height' => 100),//Site home left
        self::size_image_250 => array('width' => 250,  'height' => 250),//list admin
        self::size_image_450 => array('width' => 450,  'height' => 450),//Site Home
        self::size_image_700 => array('width' => 700,  'height' => 700)//popup insert nội dung
	);

	static $configs	= array();
	static $item_vip		=	'';
	static $curCategory		=	0;

	static $curCity			=	0;
	static $curItemType		=	0;
	static $query_debug		= 	"";	
	static $aryMemcacheDebug	= 	array();
	static $aryModuleDebug	= 	array();
	static $query_time;
	static $conn_debug 		= 	"";
	static $error_handle 	= 	"";
	static $ftp_image_connect_id = false;
	static $ftp_file_connect_id = false;
	static $allCategories	=	false;
	static $subCategories	=	false;
	static $categoriesTree	=	false;
	static $item_table	=	'';
	static $provinces		=	false;
	static $my_server 		= 	array (); //for server mememcache
	static $request_uri;
	static $referer_url;
	static $query_string	=	'';
	static $keywords = 'Rắn Lệ Mật, rắn hổ mang, làng nghề Lệ Mât, Làng nghề truyền thống';
	static $meta_desc = 'langquetoi.com - Quê hương Lệ Mật, làng quê Việt Nam';
	static $website_title = '';
	static $robotContent = 'INDEX, FOLLOW';
	static $gBContent ="index,follow,archive";
	static $memcache_connect_id=false;
	static $memcache_server=false;
	static $memcache_time=0;
	static $query_solr_time = 0;
	static $currency = array ();
	static $pg_noIndex = array ('sv_register', 'sign_in', 'sign_out', 'reg_success', 'error');
	
	//Shop
	static $user_profile = array ();
	static $shop_label 	 = array ();
	//user mặc đollows 	 = '77'; //(77:hienthu)

    /*
    * title page admin
    */
    static $arrPageAdmin = array(
        'mng_news'      =>'Admin | QL tin tức',
        'mng_product'   =>'Admin | QL sản phẩm',
        'mng_bill'      =>'Admin | QL đơn hàng',
        'admin'         =>'Admin | Control panel',
        'mng_category'  =>'Admin | QL danh mục',
        'banner_adv'    =>'Admin | QL quảng cáo',
        'yahoo'         =>'Admin | QL yahoo',
        'sign_in'       =>'Đăng nhập',
        'user'          =>'Admin | QL User',
        'module'        =>'Admin | QL Module',
        'edit_page'     =>'Admin | QL Sửa page',
        'page'          =>'Admin | QL page',
    );
    static $password_user = 'admin@1@!';
    //Phân quyền mới

    static $arrPermitAuthen = array (
        0 =>array(
            'name_group_permit'=>'Quyền Root',
            'group_permit'=>array(
                PERMIT_ROOT =>'Root',
                PERMIT_SHOP =>'Chủ shop',
                PERMIT_MEMBER_SHOP =>'Shop thành viên',
                PERMIT_SETUP_PERMIT =>'Setup quyền',)
        ),
        1 =>array(
            'name_group_permit'=>'Quyền thành viên',
            'group_permit'=>array(
                PERMIT_ADMIN =>'Admin',
                PERMIT_MEMBER =>'Thành viên',)
        ),
        2 =>array(
            'name_group_permit'=>'Quyền sản phẩm',
            'group_permit'=>array(
                PERMIT_FULL_PRODUCTS =>'Full sản phẩm',
                PERMIT_VIEW_PRODUCT =>'Xem SP',
                PERMIT_EDIT_PRODUCT =>'Thêm, sửa SP',
                PERMIT_DELETE_PRODUCT =>'Xóa SP',
                PERMIT_APPROVE_PRODUCT =>'Duyệt SP',)
        ),
        3 =>array(
            'name_group_permit'=>'Quyền tin tức',
            'group_permit'=>array(
                PERMIT_FULL_NEWS =>'Full Tin tức',
                PERMIT_ADD_NEWS =>'Thêm tin',
                PERMIT_EDIT_NEWS =>'Sửa tin',
                PERMIT_DELETE_NEWS =>'Xóa tin',
                PERMIT_APPROVE_NEWS =>'Duyệt tin')
        ),
        4 =>array(
            'name_group_permit'=>'Quyền bán hàng',
            'group_permit'=>array(
                PERMIT_SALE =>'Bán hàng',
                PERMIT_INPUT_STORE =>'Nhập kho',
                PERMIT_LOG_STORE =>'Log kho',)
        ),
    );

    static $number_per_page = 30;
    static $number_pages_show = 6;
    /**
     * QuynhTM add dinh nghia vi tri
     */
    const POSITION_LEFT = 1;
    const POSITION_RIGHT = 2;

    static $arrRadioPosition = array(self::POSITION_LEFT => 'Bên trái',self::POSITION_RIGHT => 'Bên phải');
    const MENU_TRANG_CHU = 10;
    const MENU_LOI_GIOI_THIEU = 11;
    const MENU_TIN_TUC_CHUNG = 12;
    const MENU_CAC_DONG_HO = 13;
    const MENU_THAP_TAM_TRAI = 17;
    const MENU_LANG_NGHE = 20;

    static $arymNameMenuTop = array(  self::MENU_TRANG_CHU => 'Trang chủ'
                , self::MENU_LOI_GIOI_THIEU => 'Lời giới thiệu'
                , self::MENU_TIN_TUC_CHUNG => 'Tin tức chung'
                , self::MENU_CAC_DONG_HO => 'Các dòng họ'
                , self::MENU_THAP_TAM_TRAI => 'Thập tam trại'
                , self::MENU_LANG_NGHE => 'Làng nghề Rắn'
                );
    static $aryUrlMenuTop = array(
        self::MENU_LOI_GIOI_THIEU => 'loi-gioi-thieu'
        , self::MENU_TIN_TUC_CHUNG => 'tin-tuc-chung'
        , self::MENU_CAC_DONG_HO => 'cac-dong-ho'
        , self::MENU_THAP_TAM_TRAI => 'thap-tam-trai'
        , self::MENU_LANG_NGHE => 'lang-nghe-ran'
    );

    const TIN_TUC_CHUNG = 12;
    const TIN_LANG_NGHE = 25;
    const TIN_NOI_BAT = 1;
   static $arrCatgoryNew = array(
         self::TIN_TUC_CHUNG => 'Tin tức chung'
        , self::TIN_LANG_NGHE => 'Tin làng nghề'
        , self::TIN_NOI_BAT => 'Tin nổi bật'
    );

    //End QuynhTM

    //dịnh nghĩa giới hạn đăng sản phẩm shop
    const NUMBER_PRODUCT_SHOP_0 = 0;
    const NUMBER_PRODUCT_SHOP_10 = 10;
    const NUMBER_PRODUCT_SHOP_20 = 20;
    const NUMBER_PRODUCT_SHOP_30 = 30;
    const NUMBER_PRODUCT_SHOP_40 = 40;
    const NUMBER_PRODUCT_SHOP_50 = 50;
    static $arrLimitProductShop = array(
        self::NUMBER_PRODUCT_SHOP_0 => 'Không giới hạn',
        self::NUMBER_PRODUCT_SHOP_10 => '10 sản phẩm trong shop',
        self::NUMBER_PRODUCT_SHOP_20 => '20 sản phẩm trong shop',
        self::NUMBER_PRODUCT_SHOP_30 => '30 sản phẩm trong shop',
        self::NUMBER_PRODUCT_SHOP_40 => '40 sản phẩm trong shop',
        self::NUMBER_PRODUCT_SHOP_50 => '50 sản phẩm trong shop',
    );

    //định nghĩa loại user
    const IS_SHOP = 1;
    const IS_MEMBER = 2;

    const VND=0;//Gia VND
    const USD=1;// Gia USD
    static $arrCurrency = array(self::VND=>'VNĐ',self::USD=>'USD');

    static $Fone_MienNam = '0946.146.565';
    static $Fone_MienBac = '0903.187.988';
    //static $Fone_MienBac = '04.3350.7740';
    static $diachi_mienNam = '79E - Hai Bà Trưng - P6 - Đà Lạt - Lâm Đồng';
    static $diachi_mienBac = 'Số nhà 37- Tổ 6 - Lệ Mật - Việt Hưng - Long Biên - Hà Nội';
    //103.243.107.67
}
