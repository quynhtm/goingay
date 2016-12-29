<?php
class BaseAdminController extends BaseController
{
    protected $layout = 'admin.AdminLayouts.index';
    protected $permission = array();
    protected $user = array();
    protected $is_root = false;

    public function __construct()
    {
        if (!User::isLogin()) {
            Redirect::route('admin.login',array('url'=>self::buildUrlEncode(URL::current())))->send();
        }

        $this->user = User::user_login();
        if($this->user && sizeof($this->user['user_permission']) > 0){
            $this->permission = $this->user['user_permission'];
        }
        if(in_array('root',$this->permission)){
            $this->is_root = true;
        }
        $menu = $this->menu();
        View::share('menu',$menu);
        View::share('aryPermission',$this->permission);
        View::share('user',$this->user);
        View::share('is_root',$this->is_root);
    }

    public function menu(){
        $menu[] = array(
            'name'=>'QL user Admin',
            'link'=>'javascript:void(0)',
            'icon'=>'fa fa-user',
            'arr_link_sub'=>array('admin.user_view','admin.permission_view','admin.groupUser_view',),//dung de check menu left action
            'sub'=>array(
                array('name'=>'Tài khoản Admin', 'RouteName'=>'admin.user_view', 'icon'=>'fa fa-user icon-4x', 'showcontent'=>1, 'permission'=>'user_view'),
                array('name'=>'Danh sách quyền', 'RouteName'=>'admin.permission_view', 'icon'=>'fa fa-user icon-4x', 'showcontent'=>0, 'permission'=>'permission_full'),
                array('name'=>'Danh sách nhóm quyền', 'RouteName'=>'admin.groupUser_view', 'icon'=>'fa fa-user icon-4x', 'showcontent'=>0, 'permission'=>'group_user_view'),
            ),
        );

        $menu[] = array(
            'name'=>'QL hệ thống',
            'link'=>'javascript:void(0)',
            'icon'=>'fa fa-cogs',
            'arr_link_sub'=>array('admin.info','admin.trash','admin.contract'),
            'sub'=>array(
                array('name'=>'Liên hệ quản trị', 'RouteName'=>'admin.contract', 'icon'=>'fa fa-envelope-o icon-4x', 'showcontent'=>1, 'permission'=>'contract_view'),
                array('name'=>'Thông tin chung', 'RouteName'=>'admin.info', 'icon'=>'fa fa-cogs icon-4x', 'showcontent'=>1, 'permission'=>'abc'),
                array('name'=>'Thùng rác', 'RouteName'=>'admin.trash', 'icon'=>'fa fa-trash icon-4x', 'showcontent'=>1, 'permission'=>'abc', 'clear'=>1),
            ),
        );

        $menu[] = array(
            'name'=>'Đơn vị hành chính',
            'link'=>'javascript:void(0)',
            'icon'=>'fa fa-code-fork',
            'arr_link_sub'=>array('admin.province',),
            'sub'=>array(
                array('name'=>'Tỉnh/Thành', 'RouteName'=>'admin.province', 'icon'=>'fa fa-map-marker icon-4x', 'showcontent'=>1, 'permission'=>'province_full'),
            ),
        );

        $menu[] = array(
            'name'=>'QL đăng tin',
            'link'=>'javascript:void(0)',
            'icon'=>'fa fa-gift',
            'arr_link_sub'=>array('admin.customerView','admin.itemsView','admin.category_list',),
            'sub'=>array(
                array('name'=>'Khách đăng tin', 'RouteName'=>'admin.customerView', 'icon'=>'fa fa-users icon-4x', 'showcontent'=>1, 'permission'=>'user_customer_full'),
                array('name'=>'Danh mục tin', 'RouteName'=>'admin.category_list', 'icon'=>'fa fa-indent icon-4x', 'showcontent'=>1, 'permission'=>'category_full'),
                array('name'=>'Danh sách tin đăng', 'RouteName'=>'admin.itemsView', 'icon'=>'fa fa-file-text-o icon-4x', 'showcontent'=>1, 'permission'=>'items_full', 'clear'=>1),
            ),
        );

        $menu[] = array(
            'name'=>'QL nội dung',
            'link'=>'javascript:void(0)',
            'icon'=>'fa fa-book',
            'arr_link_sub'=>array('admin.newsView','admin.bannerView','admin.viewClickShare',),
            'sub'=>array(
                array('name'=>'Tin tức', 'RouteName'=>'admin.newsView', 'icon'=>'fa fa-book icon-4x', 'showcontent'=>1, 'permission'=>'news_full'),
                array('name'=>'Banner quảng cáo', 'RouteName'=>'admin.bannerView', 'icon'=>'fa fa-globe icon-4x', 'showcontent'=>1, 'permission'=>'banner_full'),
                array('name'=>'Lượt Share', 'RouteName'=>'admin.viewClickShare', 'icon'=>'fa fa-thumbs-o-up icon-4x', 'showcontent'=>1, 'permission'=>'toolsCommon_full'),
            ),
        );
        return $menu;
    }

    public function getControllerAction(){
        return $routerName = Route::currentRouteName();
    }
}