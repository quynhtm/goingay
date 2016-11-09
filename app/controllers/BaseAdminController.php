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

        View::share('aryPermission',$this->permission);
        View::share('user',$this->user);
        View::share('is_root',$this->is_root);
    }

    public function menu(){
        $menu[] = array(
            'name'=>'Qu?n l� n?i dung', 'link'=>'javascript:void(0)', 'icon'=>'fa fa-angle-down',
            'sub'=>array(
                array('name'=>'Ki?u danh m?c', 'link'=>URL::route('admin.type'), 'icon'=>'fa fa-folder-open icon-4x'),
                array('name'=>'Danh m?c', 'link'=>URL::route('admin.category'), 'icon'=>'fa fa-sitemap icon-4x'),
                array('name'=>'S?n ph?m', 'link'=>URL::route('admin.product'), 'icon'=>'fa fa-file icon-4x'),
                array('name'=>'Tin t?c', 'link'=>URL::route('admin.news'), 'icon'=>'fa fa-file-text icon-4x'),
                array('name'=>'Qu?ng c�o', 'link'=>URL::route('admin.banner'), 'icon'=>'fa fa-globe icon-4x'),
                array('name'=>'Nick h? tr?', 'link'=>URL::route('admin.nicksupport'), 'icon'=>'fa fa-skype icon-4x'),
                array('name'=>'Li�n h?', 'link'=>URL::route('admin.contact'), 'icon'=>'fa fa-envelope icon-4x'),
            ),
        );
        $menu[] = array(
            'name'=>'Qu?n l� h? th?ng', 'link'=>'javascript:void(0)', 'icon'=>'fa fa-angle-down',
            'sub'=>array(
                array('name'=>'Nh�m quy?n', 'link'=>URL::route('admin.role'), 'icon'=>'fa fa-group icon-4x'),
                array('name'=>'Ng??i d�ng', 'link'=>URL::route('admin.user'), 'icon'=>'fa fa-user icon-4x'),
                array('name'=>'Th�ng tin chung', 'link'=>URL::route('admin.info'), 'icon'=>'fa fa-cogs icon-4x'),
                array('name'=>'Th�ng r�c', 'link'=>URL::route('admin.trash'), 'icon'=>'fa fa-trash icon-4x'),
            ),
        );

        return $menu;
    }
}