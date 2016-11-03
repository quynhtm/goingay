<?php

class ShopVipController extends BaseShopController
{
    private $arrStatus = array(-1 => '--Chọn trạng thái--', CGlobal::status_hide => 'Ẩn', CGlobal::status_show => 'Hiện');
    private $arrTarget = array(-1 => '--Chọn target link--', CGlobal::BANNER_NOT_TARGET_BLANK => 'Link trên site', CGlobal::BANNER_TARGET_BLANK => 'Mở tab mới');
    private $arrRunTime = array(-1 => '--Chọn thời gian chạy--', CGlobal::BANNER_NOT_RUN_TIME => 'Chạy mãi mãi', CGlobal::BANNER_IS_RUN_TIME => 'Chạy theo thời gian');
    private $arrIsShop = array(-1 => '--Tất cả--', CGlobal::BANNER_NOT_SHOP => 'Banner của site', CGlobal::BANNER_IS_SHOP => 'Banner của shop');
    private $arrRel = array(CGlobal::LINK_NOFOLLOW => 'Nofollow', CGlobal::LINK_FOLLOW => 'Follow');
    private $arrTypeBanner = array(-1 => '---Chọn loại Banner--',
        CGlobal::BANNER_TYPE_HOME_BIG => 'Banner shop home ',
        CGlobal::BANNER_TYPE_HOME_LEFT => 'Banner trái-phải',
        CGlobal::BANNER_TYPE_HOME_LIST => 'Banner trang list');

    private $arrPage = array(-1 => '--Chọn page--',
        CGlobal::BANNER_PAGE_HOME => 'Page trang chủ',
        CGlobal::BANNER_PAGE_LIST => 'Page danh sách');

    private $error = array();
    private $shop_id = 0;
    private $shop_name = '';
    public function __construct()
    {
        parent::__construct();
        //check khong phai shop VIP
        if(isset($this->user_shop->is_shop) && $this->user_shop->is_shop != CGlobal::SHOP_VIP){
            Redirect::route('shop.adminShop',array('error'=>1))->send();
        }
        $this->shop_id = isset($this->user_shop->shop_id)?$this->user_shop->shop_id:0;
        $this->shop_name = isset($this->user_shop->shop_name)?$this->user_shop->shop_name:'';
    }

    /**************************************************************************************************************************
     * Quản lý Banner shop
     **************************************************************************************************************************
     */
    public function listBanner(){
        //Include style.
        FunctionLib::link_css(array(
            'lib/upload/cssUpload.css',
        ));

        //Include javascript.
        FunctionLib::link_js(array(
            'lib/upload/jquery.uploadfile.js',
            'lib/ckeditor/ckeditor.js',
            'lib/ckeditor/config.js',
            'frontend/js/site.js',
            'js/common.js',
        ));

        CGlobal::$pageShopTitle = "QL banner quảng cáo | ".CGlobal::web_name;
        $pageNo = (int) Request::get('page_no',1);
        $limit = CGlobal::number_limit_show;
        $offset = ($pageNo - 1) * $limit;
        $search = $data = array();
        $total = 0;

        $search['banner_name'] = addslashes(Request::get('banner_name',''));
        $search['banner_status'] = (int)Request::get('banner_status',-1);
        $search['banner_page'] = (int)Request::get('banner_page',-1);
        $search['banner_type'] = (int)Request::get('banner_type',-1);
        $search['banner_shop_id'] = $this->shop_id;
        //$search['field_get'] = 'category_id,news_title,news_status';//cac truong can lay

        $dataSearch = Banner::searchByCondition($search, $limit, $offset,$total);
        $paging = $total > 0 ? Pagging::getNewPager(3, $pageNo, $total, $limit, $search) : '';

        //FunctionLib::debug($dataSearch);
        $optionStatus = FunctionLib::getOption($this->arrStatus, $search['banner_status']);
        $optionTypeBanner = FunctionLib::getOption($this->arrTypeBanner, $search['banner_type']);
        $optionPage = FunctionLib::getOption($this->arrPage, $search['banner_page']);
        $this->layout->content = View::make('site.ShopVip.ListBanner')
            ->with('paging', $paging)
            ->with('stt', ($pageNo-1)*$limit)
            ->with('total', $total)
            ->with('sizeShow', count($data))
            ->with('data', $dataSearch)
            ->with('search', $search)
            ->with('optionStatus', $optionStatus)
            ->with('optionTypeBanner', $optionTypeBanner)
            ->with('optionPage', $optionPage)
            ->with('arrStatus', $this->arrStatus)
            ->with('arrTypeBanner', $this->arrTypeBanner)
            ->with('arrPage', $this->arrPage)
            ->with('arrIsShop', $this->arrIsShop);
    }
    public function getAddBanner($banner_id = 0){
        //Include style.
        FunctionLib::link_css(array(
            'lib/upload/cssUpload.css',
        ));

        //Include javascript.
        FunctionLib::link_js(array(
            'lib/upload/jquery.uploadfile.js',
            'lib/ckeditor/ckeditor.js',
            'lib/ckeditor/config.js',
            'frontend/js/site.js',
            'js/common.js',
        ));
        $data = array();
        CGlobal::$pageShopTitle = "Thêm quảng cáo | ".CGlobal::web_name;
        $optionStatus = FunctionLib::getOption($this->arrStatus, CGlobal::status_show);
        $optionRunTime = FunctionLib::getOption($this->arrRunTime, CGlobal::BANNER_NOT_RUN_TIME);
        $optionTypeBanner = FunctionLib::getOption($this->arrTypeBanner, -1);
        $optionPage = FunctionLib::getOption($this->arrPage, -1);
        $optionTarget = FunctionLib::getOption($this->arrTarget, CGlobal::BANNER_TARGET_BLANK);
        $optionRel = FunctionLib::getOption($this->arrRel, CGlobal::LINK_NOFOLLOW);

        $this->layout->content = View::make('site.ShopVip.EditBanner')
            ->with('id', $banner_id)
            ->with('data', $data)
            ->with('optionStatus', $optionStatus)
            ->with('optionRunTime', $optionRunTime)
            ->with('optionTypeBanner', $optionTypeBanner)
            ->with('optionTarget', $optionTarget)
            ->with('optionRel', $optionRel)
            ->with('optionPage', $optionPage)
            ->with('arrStatus', $this->arrStatus);
    }
    public function getEditBanner($banner_id = 0){
        //Include style.
        FunctionLib::link_css(array(
            'lib/upload/cssUpload.css',
        ));

        //Include javascript.
        FunctionLib::link_js(array(
            'lib/upload/jquery.uploadfile.js',
            'lib/ckeditor/ckeditor.js',
            'lib/ckeditor/config.js',
            'frontend/js/site.js',
            'js/common.js',
        ));
        CGlobal::$pageShopTitle = "Sửa quảng cáo | ".CGlobal::web_name;
        $data = array();
        if($banner_id > 0) {
            $banner = Banner::getBannerShopByID($banner_id,$this->shop_id);
            $data = array('banner_id'=>$banner->banner_id,
                'banner_name'=>$banner->banner_name,
                'banner_image'=>$banner->banner_image,
                'banner_link'=>$banner->banner_link,
                'banner_order'=>$banner->banner_order,
                'banner_is_target'=>$banner->banner_is_target,
                'banner_is_rel'=>$banner->banner_is_rel,
                'banner_type'=>$banner->banner_type,
                'banner_page'=>$banner->banner_page,
                'banner_category_id'=>$banner->banner_category_id,
                'banner_is_run_time'=>$banner->banner_is_run_time,
                'banner_start_time'=>$banner->banner_start_time,
                'banner_end_time'=>$banner->banner_end_time,
                'banner_is_shop'=>$banner->banner_is_shop,
                'banner_shop_id'=>$banner->banner_shop_id,
                'banner_status'=>$banner->banner_status);
        }
        $optionStatus = FunctionLib::getOption($this->arrStatus, isset($data['banner_status'])? $data['banner_status']: CGlobal::status_show);
        $optionRunTime = FunctionLib::getOption($this->arrRunTime, isset($data['banner_is_run_time'])? $data['banner_is_run_time']: CGlobal::BANNER_IS_RUN_TIME);
        $optionTypeBanner = FunctionLib::getOption($this->arrTypeBanner, isset($data['banner_type'])? $data['banner_type']: -1);
        $optionPage = FunctionLib::getOption($this->arrPage, isset($data['banner_page'])? $data['banner_page']: -1);
        $optionTarget = FunctionLib::getOption($this->arrTarget, isset($data['banner_is_target'])? $data['banner_is_target']: CGlobal::BANNER_TARGET_BLANK);
        $optionRel = FunctionLib::getOption($this->arrRel, isset($data['banner_is_rel'])? $data['banner_is_rel']: CGlobal::LINK_NOFOLLOW);

        $this->layout->content = View::make('site.ShopVip.EditBanner')
            ->with('id', $banner_id)
            ->with('data', $data)
            ->with('optionStatus', $optionStatus)
            ->with('optionRunTime', $optionRunTime)
            ->with('optionTypeBanner', $optionTypeBanner)
            ->with('optionTarget', $optionTarget)
            ->with('optionRel', $optionRel)
            ->with('optionPage', $optionPage)
            ->with('arrStatus', $this->arrStatus);
    }
    public function postEditBanner($banner_id = 0){
        //Include style.
        FunctionLib::link_css(array(
            'lib/upload/cssUpload.css',
        ));

        //Include javascript.
        FunctionLib::link_js(array(
            'lib/upload/jquery.uploadfile.js',
            'lib/ckeditor/ckeditor.js',
            'lib/ckeditor/config.js',
            'frontend/js/site.js',
            'js/common.js',
        ));

        CGlobal::$pageShopTitle = "Sửa quảng cáo | ".CGlobal::web_name;
        $data['banner_name'] = addslashes(Request::get('banner_name'));
        $data['banner_link'] = addslashes(Request::get('banner_link'));
        $data['banner_image'] = addslashes(Request::get('image_primary'));//ảnh chính
        $data['banner_order'] = addslashes(Request::get('banner_order'));

        $data['banner_is_target'] = (int)Request::get('banner_is_target');
        $data['banner_is_rel'] = (int)Request::get('banner_is_rel');
        $data['banner_type'] = (int)Request::get('banner_type');
        $data['banner_page'] = (int)Request::get('banner_page');
        $data['banner_category_id'] = (int)Request::get('banner_category_id');
        $data['banner_start_time'] = Request::get('banner_start_time');
        $data['banner_end_time'] = Request::get('banner_end_time');
        $data['banner_status'] = (int)Request::get('banner_status');
        $data['banner_is_run_time'] = CGlobal::BANNER_IS_RUN_TIME;
        $data['banner_is_shop'] = CGlobal::BANNER_IS_SHOP;
        $data['banner_shop_id'] = $this->shop_id;
        $id_hiden = (int)Request::get('id_hiden', 0);

        if($this->validBanner($data) && empty($this->error)) {
            $id = ($banner_id == 0)?$id_hiden: $banner_id;
            if($id > 0) {
                //cap nhat
                $data['banner_start_time'] = strtotime($data['banner_start_time']);
                $data['banner_end_time'] = strtotime($data['banner_end_time']);
                if(Banner::updateData($id, $data)) {
                    return Redirect::route('shop.listBanner');
                }
            }
        }
        $optionStatus = FunctionLib::getOption($this->arrStatus, isset($data['banner_status'])? $data['banner_status']: CGlobal::STASTUS_HIDE);
        $optionRunTime = FunctionLib::getOption($this->arrRunTime, isset($data['banner_is_run_time'])? $data['banner_is_run_time']: CGlobal::BANNER_NOT_RUN_TIME);
        $optionTypeBanner = FunctionLib::getOption($this->arrTypeBanner, isset($data['banner_type'])? $data['banner_type']: -1);
        $optionPage = FunctionLib::getOption($this->arrPage, isset($data['banner_page'])? $data['banner_page']: -1);
        $optionTarget = FunctionLib::getOption($this->arrTarget, isset($data['banner_is_target'])? $data['banner_is_target']: CGlobal::BANNER_TARGET_BLANK);
        $optionRel = FunctionLib::getOption($this->arrRel, isset($data['banner_is_rel'])? $data['banner_is_rel']: CGlobal::LINK_NOFOLLOW);

        //để hien thi loi
        $data['banner_start_time'] = strtotime($data['banner_start_time']);
        $data['banner_end_time'] = strtotime($data['banner_end_time']);

        $this->layout->content =  View::make('site.ShopVip.EditBanner')
            ->with('id', $banner_id)
            ->with('error', $this->error)
            ->with('data', $data)
            ->with('optionStatus', $optionStatus)
            ->with('optionRunTime', $optionRunTime)
            ->with('optionTypeBanner', $optionTypeBanner)
            ->with('optionTarget', $optionTarget)
            ->with('optionRel', $optionRel)
            ->with('optionPage', $optionPage)
            ->with('arrStatus', $this->arrStatus);
    }
    public function validBanner($data=array()) {
        if(!empty($data)) {
            if(isset($data['banner_name']) && trim($data['banner_name']) == '') {
                $this->error[] = 'Tên banner không được bỏ trống';
            }
            if(isset($data['banner_link']) && trim($data['banner_link']) == '') {
                $this->error[] = 'Chưa có link view cho banner';
            }
            if(isset($data['banner_image']) && trim($data['banner_image']) == '') {
                $this->error[] = 'Chưa up ảnh banner quảng cáo';
            }
            if(isset($data['banner_is_run_time']) && $data['banner_is_run_time'] == 1) {
                if(isset($data['banner_start_time']) && $data['banner_start_time'] == '' ) {
                   $this->error[] = 'Chưa chọn thời gian bắt đầu chạy cho banner';
                }
                if(isset($data['banner_end_time']) && $data['banner_end_time'] == '') {
                    $this->error[] = 'Chưa chọn thời gian kết thúc cho banner';
                }
                if(isset($data['banner_end_time']) && isset($data['banner_start_time'])  && (strtotime($data['banner_start_time']) > strtotime($data['banner_end_time']))) {
                    $this->error[] = 'Thời gian bắt đầu lớn hơn thời gian kết thúc';
                }
            }
        }
        return true;
    }
    //Ajax
    public function deleteBanner(){
        $banner_id = (int)Request::get('banner_id',0);
        $data = array('isIntOk' => 0);
        if($this->shop_id > 0 && $banner_id > 0){
            $banner = Banner::getBannerShopByID($banner_id,$this->user_shop->shop_id);
            if(sizeof($banner) > 0){
                if(Banner::deleteData($banner_id)){
                    $data['isIntOk'] = 1;
                    return Response::json($data);
                }
            }else{
                return Response::json($data);
            }
        }
        return Response::json($data);
    }

    /**************************************************************************************************************************
     * Quản lý Nhà cung cấp
     **************************************************************************************************************************
     */
    public function listProvider(){
        FunctionLib::link_js(array(
            'js/jquery.min.js',
            'frontend/js/site.js',
        ));

        CGlobal::$pageShopTitle = "QL nhà cung cấp | ".CGlobal::web_name;
        $pageNo = (int) Request::get('page_no',1);
        $limit = CGlobal::number_limit_show;
        $offset = ($pageNo - 1) * $limit;
        $search = $data = array();
        $total = 0;

        $search['provider_id'] = addslashes(Request::get('provider_id',''));
        $search['provider_name'] = addslashes(Request::get('provider_name',''));
        $search['provider_phone'] = addslashes(Request::get('provider_phone',''));
        $search['provider_email'] = addslashes(Request::get('provider_email',''));
        $search['provider_status'] = (int)Request::get('provider_status',-1);
        $search['provider_shop_id'] = $this->shop_id;
        //$search['field_get'] = 'category_id,category_name,category_status';//cac truong can lay

        $dataSearch = Provider::searchByCondition($search, $limit, $offset,$total);
        $paging = $total > 0 ? Pagging::getNewPager(3, $pageNo, $total, $limit, $search) : '';

        //FunctionLib::debug($dataSearch);
        $optionStatus = FunctionLib::getOption($this->arrStatus, $search['provider_status']);
        $this->layout->content = View::make('site.ShopVip.ListProvider')
            ->with('paging', $paging)
            ->with('stt', ($pageNo-1)*$limit)
            ->with('total', $total)
            ->with('sizeShow', count($data))
            ->with('data', $dataSearch)
            ->with('search', $search)
            ->with('optionStatus', $optionStatus);

    }
    public function getAddProvider($provider_id = 0){
        FunctionLib::link_js(array(
            'js/jquery.min.js',
            'frontend/js/site.js',
        ));

        CGlobal::$pageShopTitle = "Thêm nhà cung cấp | ".CGlobal::web_name;
        $data = array();
        //FunctionLib::debug($data);
        $optionStatus = FunctionLib::getOption($this->arrStatus, CGlobal::status_hide);
        $this->layout->content = View::make('site.ShopVip.EditProvider')
            ->with('id', $provider_id)
            ->with('error', $this->error)
            ->with('data', $data)
            ->with('optionStatus', $optionStatus)
            ->with('optionIsShop', array())
            ->with('arrStatus', $this->arrStatus);
    }
    public function getEditProvider($provider_id = 0){
        FunctionLib::link_js(array(
            'js/jquery.min.js',
            'frontend/js/site.js',
        ));

        CGlobal::$pageShopTitle = "Sửa nhà cung cấp | ".CGlobal::web_name;
        $data = array();
        if($provider_id > 0) {
            $item = Provider::getProviderShopByID($provider_id,$this->shop_id);
            if(sizeof($item) > 0){
                $data['provider_id'] = $item->provider_id;
                $data['provider_name'] = $item->provider_name;
                $data['provider_phone'] = $item->provider_phone;
                $data['provider_address'] = $item->provider_address;
                $data['provider_email'] = $item->provider_email;
                $data['provider_shop_id'] = $item->provider_shop_id;
                $data['provider_shop_name'] = $item->provider_shop_name;
                $data['provider_status'] = $item->provider_status;
                $data['provider_note'] = $item->provider_note;
                $data['provider_time_creater'] = $item->provider_time_creater;
            }
        }
        //FunctionLib::debug($data);
        $optionStatus = FunctionLib::getOption($this->arrStatus, isset($data['provider_status'])? $data['provider_status'] : -1);
        $this->layout->content = View::make('site.ShopVip.EditProvider')
            ->with('id', $provider_id)
            ->with('error', $this->error)
            ->with('data', $data)
            ->with('optionStatus', $optionStatus)
            ->with('optionIsShop', array())
            ->with('arrStatus', $this->arrStatus);
    }
    public function postEditProvider($provider_id = 0){
        //Include style.
        FunctionLib::link_js(array(
            'js/jquery.min.js',
            'frontend/js/site.js',
        ));

        CGlobal::$pageShopTitle = "Sửa nhà cung cấp | ".CGlobal::web_name;
        $dataSave['provider_name'] = addslashes(Request::get('provider_name'));
        $dataSave['provider_phone'] = addslashes(Request::get('provider_phone'));
        $dataSave['provider_address'] = addslashes(Request::get('provider_address'));
        $dataSave['provider_email'] = addslashes(Request::get('provider_email'));
        $dataSave['provider_shop_id'] = $this->shop_id;
        $dataSave['provider_shop_name'] = $this->shop_name;
        $dataSave['provider_note'] = addslashes(Request::get('provider_note'));
        $dataSave['provider_time_creater'] = time();
        $dataSave['provider_status'] = (int)Request::get('provider_status', CGlobal::status_hide);

        if($this->validProvider($dataSave) && empty($this->error)) {
            if($provider_id > 0) {
                //cap nhat
                if(Provider::updateData($provider_id, $dataSave)) {
                    return Redirect::route('shop.listProvider');
                }
            } else {
                //them moi
                if(Provider::addData($dataSave)) {
                    return Redirect::route('shop.listProvider');
                }
            }
        }
        $optionStatus = FunctionLib::getOption($this->arrStatus, isset($dataSave['shop_status'])? $dataSave['shop_status'] : -1);
        $this->layout->content =  View::make('site.ShopVip.EditProvider')
            ->with('id', $provider_id)
            ->with('data', $dataSave)
            ->with('error', $this->error)
            ->with('optionStatus', $optionStatus)
            ->with('arrStatus', $this->arrStatus);
    }
    private function validProvider($data=array()) {
        if(!empty($data)) {
            if(isset($data['provider_name']) && trim($data['provider_name']) == '') {
                $this->error[] = 'Tên nhà cung cấp không được bỏ trống';
            }
            return true;
        }
        return false;
    }
    //Ajax
    public function deleteProvider(){
        $provider_id = (int)Request::get('provider_id',0);
        $data = array('isIntOk' => 0);
        if($this->shop_id > 0 && $provider_id > 0){
            $provider = Provider::getProviderShopByID($provider_id,$this->shop_id);
            if(sizeof($provider) > 0){
                if(Provider::deleteData($provider_id)){
                    $data['isIntOk'] = 1;
                    return Response::json($data);
                }
            }else{
                return Response::json($data);
            }
        }
        return Response::json($data);
    }

    /**************************************************************************************************************************
     * Quản lý bán hàng offline
     **************************************************************************************************************************
     */
    public function orderShopOffline(){
        FunctionLib::link_js(array(
            'js/jquery.min.js',
            'frontend/js/orderShop.js',
        ));
        CGlobal::$pageShopTitle = "Bán hàng tại Shop | ".CGlobal::web_name;

        $inforCustomer = $inforShopCart = array();
        $str_product_id = Request::get('product_id','');
        $customer_phone = Request::get('customer_phone','');
        /*
         * ***************************************************************
         * Thông tin khách mua hàng
         * ***************************************************************
         * */
        if($this->shop_id > 0 && $customer_phone != ''){
            $customer = CustomerShop::getCustomerByPhone(trim($customer_phone));

            if(sizeof($customer) > 0){
                $inforCustomer['customer_shop_full_name'] = isset($customer->customer_shop_full_name)?$customer->customer_shop_full_name:'';
                $inforCustomer['customer_shop_email'] = isset($customer->customer_shop_email)?$customer->customer_shop_email:'';
                $inforCustomer['customer_shop_address'] = isset($customer->customer_shop_address)?$customer->customer_shop_address:'';
            }
            $inforCustomer['customer_shop_phone'] = $customer_phone;
        }

        /*
         * ***************************************************************
         * Add sản phẩm vào shop cart
         * ***************************************************************
         * */
        //get gio hang cua shop
        $shopCart = Session::has('shop_cart') ?Session::get('shop_cart') : array();

        if(!empty($shopCart)){
            foreach($shopCart as $k_pro_id =>$number_buy){
                $inforProduct = Product::getProductByShopId($this->shop_id,$k_pro_id);
                if(sizeof($inforProduct) > 0){
                    $inforShopCart[] = array(
                        'number_buy'=>$number_buy,

                        'product_id'=>$inforProduct->product_id,
                        'product_name'=>$inforProduct->product_name,
                        'category_name'=>$inforProduct->category_name,
                        'product_status'=>$inforProduct->product_status,
                        'is_block'=>$inforProduct->is_block,
                        'is_sale'=>$inforProduct->is_sale,//0 hết hàng, 1 con hàng

                        'product_image'=>$inforProduct->product_image,
                        'product_price_sell'=>$inforProduct->product_price_sell,
                        'product_type_price'=>$inforProduct->product_type_price,
                    );
                }
            }
        }

        $this->layout->content = View::make('site.ShopVip.OrderShopOffline')
            ->with('error', $this->error)
            ->with('str_product_id', $str_product_id)
            ->with('customer_phone', $customer_phone)
            ->with('inforCustomer', $inforCustomer)
            ->with('inforShopCart', $inforShopCart)
            ->with('arrStatus', $this->arrStatus);
    }
    //ajax
    public function orderBuyShopCart(){
        $customer_shop_phone = Request::get('customer_shop_phone','');
        $customer_shop_full_name = Request::get('customer_shop_full_name','');
        $customer_shop_email = Request::get('customer_shop_email','');
        $customer_shop_address = Request::get('customer_shop_address','');
        $customer_shop_note = Request::get('customer_shop_note','');

        //get gio hang cua shop
        $shopCart = Session::has('shop_cart') ?Session::get('shop_cart') : array();
        if(empty($shopCart)){
            $arrAjax = array('isIntOk' => 0, 'msg' => 'Đơn hàng không tồn tại');
            return Response::json($arrAjax);
        }
        //lấy thông tin sản phẩm add vào order
        else{
            $dataOrderInput = array(
                'order_customer_name'=>$customer_shop_full_name,
                'order_customer_phone'=>$customer_shop_phone,
                'order_customer_email'=>$customer_shop_email,
                'order_customer_address'=>$customer_shop_address,
                'order_customer_note'=>$customer_shop_note,
                'order_time'=>time(),
                'order_status'=>CGlobal::ORDER_STATUS_SUCCESS,
            );
            $dataOrder = array();
            $orde_id = 0;
            foreach($shopCart as $k_pro_id =>$number_buy){
                $inforProduct = Product::getProductByShopId($this->shop_id,$k_pro_id);
                if(sizeof($inforProduct) > 0){
                    if(isset($inforProduct->product_id) && $inforProduct->product_id == $k_pro_id){
                        $dataOrderInput['order_product_id'] = $inforProduct->product_id;
                        $dataOrderInput['order_product_name'] = $inforProduct->product_name;
                        $dataOrderInput['order_product_price_sell'] = $inforProduct->product_price_sell;
                        $dataOrderInput['order_product_image'] = $inforProduct->product_image;
                        $dataOrderInput['order_product_type_price'] = $inforProduct->product_type_price;
                        $dataOrderInput['order_category_id'] = $inforProduct->category_id;
                        $dataOrderInput['order_category_name'] = $inforProduct->category_name;

                        $dataOrderInput['order_quality_buy'] = $number_buy;
                        $dataOrderInput['order_user_shop_id'] = $inforProduct->user_shop_id;
                        $dataOrderInput['order_user_shop_name'] = $inforProduct->user_shop_name;
                        $dataOrderInput['order_product_province'] = $inforProduct->shop_province;

                        $dataOrder[] = $dataOrderInput;
                        $orde_id = Order::addData($dataOrderInput);
                    }
                }
            }
            if(Session::has('shop_cart')){
                Session::forget('shop_cart');
                //guui mail cho quản trị
                $dataCustomer = array(
                    'txtName'=>$customer_shop_full_name,
                    'txtMobile'=>$customer_shop_phone,
                    'txtEmail'=>$customer_shop_email,
                    'txtAddress'=>$customer_shop_address,
                    'txtMessage'=>$customer_shop_note,
                    'dataItem'=>$dataOrder,
                );
                $emailsQuantri = ['shoponlinecuatui@gmail.com'];
                Mail::send('emails.SendOrderToMailCustomer', array('data'=>$dataCustomer), function($message) use ($emailsQuantri){
                    $message->to($emailsQuantri, 'OrderToCustomer')
                        ->subject(CGlobal::web_name.'-'.$this->shop_name.' đã bán hàng tại shop ngày'.date('d/m/Y h:i',  time()));
                });
            }

            $arrAjax = array('isIntOk' => ($orde_id >0)? 1:0,);
            return Response::json($arrAjax);
        }
    }
    //ajax xóa 1 item trong giỏ hàng
    public function deleteOneItemShopCart(){
        $id = (int)Request::get('product_id', 0);
        if($id > 0){
            if(Session::has('shop_cart')){
                $shop_cart = Session::get('shop_cart');
                if(isset($shop_cart[$id])){
                    unset($shop_cart[$id]);
                }
                Session::put('shop_cart', $shop_cart, 60*24);
                Session::save();

                $arrAjax = array('isIntOk' => 1);
                return Response::json($arrAjax);
            }
        }
        $arrAjax = array('isIntOk' => 0);
        return Response::json($arrAjax);
    }
    //ajax thay doi SL mua
    public function changeNumberBuyShopCart(){
        $id = (int)Request::get('product_id', 0);
        $number_buy = (int)Request::get('number_buy', 0);
        if($id > 0){
            if(Session::has('shop_cart')){
                $shop_cart = Session::get('shop_cart');
                if(isset($shop_cart[$id])){
                    $shop_cart[$id] = $number_buy;
                }
                Session::put('shop_cart', $shop_cart, 60*24);
                Session::save();

                $arrAjax = array('isIntOk' => 1);
                return Response::json($arrAjax);
            }
        }
        $arrAjax = array('isIntOk' => 0);
        return Response::json($arrAjax);
    }
    //ajax
    public function getInforShopCart(){
        $str_product_id = Request::get('product_id','');
        $customer_phone = (int)Request::get('customer_phone','');
        $data = array('isIntOk' => 0);

        if($this->shop_id > 0 && $str_product_id != '' && $customer_phone != ''){
            /*
             * ***************************************************************
             * Thông tin khách mua hàng
             * ***************************************************************
             * */
            $inforCustomer = array();
            if($this->shop_id > 0 && $customer_phone != ''){
                $customer = CustomerShop::getCustomerByPhone(trim($customer_phone));
                if(sizeof($customer) > 0){
                    $inforCustomer['customer_shop_full_name'] = isset($customer->customer_shop_full_name)?$customer->customer_shop_full_name:'';
                    $inforCustomer['customer_shop_email'] = isset($customer->customer_shop_email)?$customer->customer_shop_email:'';
                    $inforCustomer['customer_shop_address'] = isset($customer->customer_shop_address)?$customer->customer_shop_address:'';
                }
                $inforCustomer['customer_shop_phone'] = $customer_phone;
            }

            /*
             * ***************************************************************
             * Add sản phẩm vào shop cart
             * ***************************************************************
             * */
            //get gio hang cua shop
            $shopCart = Session::has('shop_cart') ?Session::get('shop_cart') : array();

            //lấy mang id sản phẩm đặt mua
            $array_product_id = explode(',',$str_product_id);
            $arrProIdAddToBuy = array();
            if(is_array($array_product_id) && !empty($array_product_id)){
                foreach($array_product_id as $k =>$val_pro){
                    $pro_id = (int)trim($val_pro);
                    //check sản phẩm ko có trong giỏ hàng shop thì lấy
                    if($pro_id > 0 && !in_array($pro_id,array_keys($shopCart))){
                        $product = Product::getProductByShopId($this->shop_id,$pro_id);
                        if(sizeof($product) > 0){
                            $arrProIdAddToBuy[$product->product_id] = isset($product->product_id)? $product->product_id : 0;
                        }
                    }
                }
            }
            //add san phâm vào gio hang cua shop
            if(!empty($arrProIdAddToBuy)){
                foreach($arrProIdAddToBuy as $k_pro => $va){
                    if(!isset($shopCart[$k_pro])){
                        $shopCart[$k_pro] = 1;
                    }
                }
            }
            //lưu vào gio hàng shop
            if(!empty($shopCart)){
                Session::put('shop_cart', $shopCart, 60*24);
            }

            /*
             * ***************************************************************
             * Lấy thông tin để show ra
             * ***************************************************************
             * */
            $inforShopCart = array();

            if(!empty($shopCart)){
                foreach($shopCart as $k_pro_id =>$number_buy){
                    $inforProduct = Product::getProductByShopId($this->shop_id,$k_pro_id);
                    if(sizeof($inforProduct) > 0){
                        $inforShopCart[] = array(
                            'number_buy'=>$number_buy,

                            'product_id'=>$inforProduct->product_id,
                            'product_name'=>$inforProduct->product_name,
                            'category_name'=>$inforProduct->category_name,
                            'product_status'=>$inforProduct->product_status,
                            'is_block'=>$inforProduct->is_block,
                            'is_sale'=>$inforProduct->is_sale,//0 hết hàng, 1 con hàng

                            'product_image'=>$inforProduct->product_image,
                            'product_price_sell'=>$inforProduct->product_price_sell,
                            'product_type_price'=>$inforProduct->product_type_price,
                        );
                    }
                }
            }
            $html = View::make('site.ShopVip.OrderProductShopBuy')
                ->with('inforShopCart', $inforShopCart)
                ->with('inforCustomer', $inforCustomer)
                ->render();
            $arrAjax = array('isIntOk' => 1, 'infor' => $html);
            return Response::json($arrAjax);
            //FunctionLib::debug($dataShopCart);
            //684,683,682,680
        }
        return Response::json($data);
    }
}

