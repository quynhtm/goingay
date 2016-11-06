<?php
class BaseAdminController extends BaseController
{
    protected $layout = 'admin.AdminLayouts.index';
    protected $permission = array();
    protected $user = array();
    protected $is_root = false;

    public function __construct(){
        
		FunctionLib::site_css('libs/jAlert/jquery.alerts.css', CGlobal::$POS_HEAD);
		FunctionLib::site_js('libs/jAlert/jquery.alerts.js', CGlobal::$POS_HEAD);
		
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
	
	public function header(){
		$menu = $this->menu();
		$this->layout->header = View::make("admin.AdminLayouts.header")->with('menu', $menu)->with('user', $this->user);
	}
	
	public function menu(){
		$menu[] = array(
				'name'=>'Đơn vị hành chính', 'link'=>'javascript:void(0)', 'icon'=>'fa fa-angle-down',
				'sub'=>array(
						array('name'=>'Tỉnh/Thành', 'link'=>URL::route('admin.provice'), 'icon'=>'fa fa-map-marker icon-4x', 'showcontent'=>1),
				),
		);
		
		$menu[] = array(
				'name'=>'QL hệ thống', 'link'=>'javascript:void(0)', 'icon'=>'fa fa-angle-down',
				'sub'=>array(
						array('name'=>'Người dùng', 'link'=>URL::route('admin.user_view'), 'icon'=>'fa fa-user icon-4x', 'showcontent'=>1),
						array('name'=>'Thông tin chung', 'link'=>URL::route('admin.info'), 'icon'=>'fa fa-cogs icon-4x', 'showcontent'=>1),
						array('name'=>'Thùng rác', 'link'=>URL::route('admin.trash'), 'icon'=>'fa fa-trash icon-4x', 'showcontent'=>1),
				),
		);
		return $menu;
	}
}