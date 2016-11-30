<?php
/**
 * Created by JetBrains PhpStorm.
 * User: QuynhTM
 */
class CGlobal{
    static $css_ver = 1;
    static $js_ver = 1;
    public static $POS_HEAD = 1;
    public static $POS_END = 2;
    public static $extraHeaderCSS = '';
    public static $extraHeaderJS = '';
    public static $extraFooterCSS = '';
    public static $extraFooterJS = '';
    public static $extraMeta = '';
    public static $pageAdminTitle = 'Dashboard Admin';
    public static $pageShopTitle = 'Shop Admin';

    const code_shop_share = 'raovat30s.vn';
    const web_name = 'Raovat30s.vn';
    public static $pageTitle = 'Raovat30s.vn';

    const phoneSupport = '0985.10.10.26 - 0913.922.986';

    const num_scroll_page = 2;
    const number_limit_show = 30;
    const number_show_30 = 30;
    const number_show_40 = 40;
    const number_show_20 = 20;
    const number_show_15 = 15;
    const number_show_10 = 10;
    const number_show_5 = 5;
    const number_show_8 = 8;

    const max_num_buy_item_product = 10;
    /**
     * Dinh nghi kich thuoc anh Sản phẩm
     */
    const type_thumb_image_product = 1;
    const type_thumb_image_banner = 2;
    
    const sizeImage_80 = 80;
    const sizeImage_100 = 100;//dung common
    const sizeImage_200 = 200;
    const sizeImage_300 = 300;
    const sizeImage_450 = 450;
    const sizeImage_600 = 600;
    const sizeImage_750 = 750;
    const sizeImage_1020 = 1020;

    const freeSizeImage_300 = 301;
    
    public static $arrSizeImage = array(
        self::sizeImage_80 =>array('w'=>self::sizeImage_80,'h'=>self::sizeImage_80),
        self::sizeImage_100 =>array('w'=>self::sizeImage_100,'h'=>self::sizeImage_100),
        self::sizeImage_200 =>array('w'=>self::sizeImage_200,'h'=>self::sizeImage_200),
        self::sizeImage_300 =>array('w'=>self::sizeImage_300,'h'=>self::sizeImage_300),
    	self::sizeImage_450 =>array('w'=>self::sizeImage_450,'h'=>self::sizeImage_450),
    	self::sizeImage_600 =>array('w'=>self::sizeImage_600,'h'=>self::sizeImage_600),
    );

    /**
     * Dinh nghi kich thuoc anh Banner
     */
    public static $arrBannerSizeImage = array(
        self::sizeImage_100 =>array('w'=>self::sizeImage_100,'h'=>self::sizeImage_100),
        self::sizeImage_200 =>array('w'=>self::sizeImage_200,'h'=>self::sizeImage_200),
        self::sizeImage_300 =>array('w'=>self::sizeImage_300,'h'=>self::sizeImage_300),
    	self::sizeImage_450 =>array('w'=>self::sizeImage_450,'h'=>self::sizeImage_450),
    	self::sizeImage_750 =>array('w'=>self::sizeImage_750,'h'=>self::sizeImage_450),
    	self::sizeImage_1020 =>array('w'=>self::sizeImage_1020,'h'=>0),
    	self::freeSizeImage_300 =>array('w'=>self::freeSizeImage_300,'h'=>0),
    );
	
    
    const status_show = 1;
    const status_hide = 0;
    const status_block = -2;
	
    //is_login Customer
    const not_login = 0;
    const is_login = 1;
    
    //Tin tuc
    const NEW_CATEGORY_CUSTOMER = 1;
    const NEW_CATEGORY_SHOP = 2;
    const NEW_CATEGORY_GIOI_THIEU = 3;
    const NEW_CATEGORY_GIAI_TRI = 4;
    const NEW_CATEGORY_THI_TRUONG = 5;
    const NEW_CATEGORY_GOC_GIA_DINH = 6;
    const NEW_CATEGORY_TIN_TUC_CHUNG = 7;
    const NEW_CATEGORY_QUANG_CAO = 8;
    const NEW_TYPE_DAC_BIET = 1;// di voi danh muc: 1,2,3
    const NEW_TYPE_NOI_BAT = 2;// di voi danh muc: 4,5,6,7
    const NEW_TYPE_TIN_TUC = 3;// di voi danh muc: 4,5,6,7
    const NEW_TYPE_QUANG_CAO = 4;// di voi danh muc: 8
    public static $arrCategoryNew = array(-1 => '--- Chọn danh mục ---',
        self::NEW_CATEGORY_TIN_TUC_CHUNG => 'Tin tức chung',
        self::NEW_CATEGORY_GOC_GIA_DINH => 'Góc gia đinh',
        self::NEW_CATEGORY_THI_TRUONG => 'Thị trường',
        self::NEW_CATEGORY_GIAI_TRI => 'Giải trí',
        self::NEW_CATEGORY_GIOI_THIEU => 'Tin giới thiệu',
        self::NEW_CATEGORY_SHOP => 'Tin của Shop',
        self::NEW_CATEGORY_CUSTOMER => 'Tin của khách',
        self::NEW_CATEGORY_QUANG_CAO => 'Tin quảng cáo',
    );
    public static $arrTypeNew = array(-1 => '--- Chọn kiểu tin ---',
        self::NEW_TYPE_TIN_TUC => 'Tin tức chung',
        self::NEW_TYPE_NOI_BAT => 'Tin nổi bật',
        self::NEW_TYPE_DAC_BIET => 'Tin đặc biệt',
        self::NEW_TYPE_QUANG_CAO => 'Tin quảng cáo',
    );

    const IMAGE_ERROR = 133;
    const FOLDER_NEWS = 'news';
    const FOLDER_BANNER = 'banner';
    const FOLDER_PRODUCT = 'product';
    const FOLDER_CATEGORY = 'category';
    const FOLDER_LOGO_SHOP = 'logo_shop';
	
	const FOLDER_INFO = 'info';
    //shop
    const CUSTOMER_FREE = 1;
    const CUSTOMER_NOMAL = 2;
    const CUSTOMER_VIP = 3;
    const CUSTOMER_ONLINE = 1;
    const CUSTOMER_OFFLINE = 0;

    //product
    const TYPE_PRICE_NUMBER = 1;
    const TYPE_PRICE_CONTACT = 2;
    const ITEMS_NOMAL = 1;
    const ITEMS_HOT = 2;
    const ITEMS_SELLOFF = 3;
    const ITEMS_BLOCK = 0;
    const ITEMS_NOT_BLOCK = 1;


    //banner
    const BANNER_NOT_RUN_TIME = 0;
    const BANNER_IS_RUN_TIME = 1;
    const BANNER_NOT_TARGET_BLANK = 0;
    const BANNER_TARGET_BLANK = 1;

    const BANNER_TYPE_TOP = 1;
    const BANNER_TYPE_LEFT = 2;
    const BANNER_TYPE_RIGHT = 3;
    const BANNER_TYPE_BOTTOM = 4;
    const BANNER_TYPE_CENTER = 5;

    const BANNER_PAGE_HOME = 1;
    const BANNER_PAGE_LIST = 2;
    const BANNER_PAGE_DETAIL = 3;
    const BANNER_PAGE_CATEGORY = 4;
    const BANNER_PAGE_OTHER = 6;

    const LINK_NOFOLLOW = 0;
    const LINK_FOLLOW = 1;
    
    const banner_slider_default_shop = 'uploads/default/default-banner-shop.jpg';
	
    //Duy bo sung
    const emailAdmin = 'nguyenduypt86@gmail.com';
}