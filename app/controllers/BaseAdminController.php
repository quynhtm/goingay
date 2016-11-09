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
            'name'=>'QL hệ thống', 'link'=>'javascript:void(0)', 'icon'=>'fa fa-angle-down',
            'sub'=>array(
                array('name'=>'Người dùng', 'link'=>URL::route('admin.user_view'), 'icon'=>'fa fa-user icon-4x', 'showcontent'=>1),
                array('name'=>'Thông tin chung', 'link'=>URL::route('admin.info'), 'icon'=>'fa fa-cogs icon-4x', 'showcontent'=>1),
                array('name'=>'Thùng rác', 'link'=>URL::route('admin.trash'), 'icon'=>'fa fa-trash icon-4x', 'showcontent'=>1),
            ),
        );

        $menu[] = array(
            'name'=>'Đơn vị hành chính', 'link'=>'javascript:void(0)', 'icon'=>'fa fa-angle-down',
            'sub'=>array(
                array('name'=>'Tỉnh/Thành', 'link'=>URL::route('admin.provice'), 'icon'=>'fa fa-map-marker icon-4x', 'showcontent'=>1, 'clear'=>1),
            ),
        );

        $menu[] = array(
            'name'=>'QL đăng tin', 'link'=>'javascript:void(0)', 'icon'=>'fa fa-angle-down',
            'sub'=>array(
                array('name'=>'Khách đăng tin', 'link'=>URL::route('admin.customerView'), 'icon'=>'fa fa-users icon-4x', 'showcontent'=>1),
                array('name'=>'Danh sách tin đăng', 'link'=>URL::route('admin.itemsView'), 'icon'=>'fa fa-file-text-o icon-4x', 'showcontent'=>1),
            ),
        );

        $menu[] = array(
            'name'=>'QL nội dung', 'link'=>'javascript:void(0)', 'icon'=>'fa fa-angle-down',
            'sub'=>array(
                array('name'=>'Tin tức', 'link'=>URL::route('admin.newsView'), 'icon'=>'fa fa-book icon-4x', 'showcontent'=>1),
                array('name'=>'Banner quảng cáo', 'link'=>URL::route('admin.bannerView'), 'icon'=>'fa fa-globe icon-4x', 'showcontent'=>1),
            ),
        );
        return $menu;
    }
}