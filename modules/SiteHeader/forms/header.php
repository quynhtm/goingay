<?php
class SiteHeaderForm extends Form{
	function __construct(){
		Form::Form('HeaderForm');
		$this->link_css('style/site_css/quehuonglemat.css');
		$this->link_css('style/site_css/web_common.css');

		$this->link_js('javascripts/slidershow/jssor.slider.min.js');
	}
function draw(){
		global $display;

		if(!isset($_SESSION['is_load_page_first'])){
			$_SESSION['is_load_page_first'] = 0;
		}
		$display->add('url_root',WEB_ROOT);
		$display->add('STATIC_URL',STATIC_URL);

		//Top menu
		if (User::id()){
			$display->add('user_id',User::id());
			$display->add('user_name',User::$data['user_name']);
			$status = (User::$data['status'] == ACC_NOMAL) ? 1 : 0;
			$display->add('is_member_login', $status);
			$display->add('email', User::$data['email']);
		}
		elseif(isset($_COOKIE['user_cc'])) {
			$user = @unserialize($_COOKIE['user_cc']);
			if(!empty($user)) $display->add('save_login', 1);
		}

		$referer_login_url = base64_encode($_SERVER['REQUEST_URI']);
		if(isset($_SESSION['openid_url']) && ($_SESSION['user_id']!=0)){
			$display->add('show_openid',false);
		}
		
		
		$display->add('show_time',1);
		$display->add('is_root',User::is_root());
		$display->add('referer_login_url',$referer_login_url);
		$display->add('is_login',(int)User::is_login());
		$display->add('is_admin',(int)User::is_admin());
		$display->add('is_debug',(int)is_debug());		
		$display->add('is_admin_item',(int)User::have_permit(ADMIN_ITEM));
		$display->add('keywords',EnBacLib::cleanHtml(Url::get('keywords','')));
		$display->add('is_load_page_first',$_SESSION['is_load_page_first']);

		$display->add('page_url',Url::get('page'));

		if($_SESSION['is_load_page_first']==1){
			$_SESSION['is_load_page_first'] = 0;
		}
		$display->add('my_save', (User::is_login()) ? Url::build('account'):"javascript: Bm.show_popup_message('Bạn phải đăng nhập mới được thực hiện chức năng này.','Thông báo',-1); ");
		
		//menu chinh
		$menuArr = SvLib::getMenuArr();
		$page = Url::get('page', '');
		$menuActive = SvLib::getActiveMenu($page);
		$menuArr[$menuActive]['active'] = true;
		
		//menu con
		require_once ROOT_PATH.'core/lib/function.php';
		$menu = buildMenuHeader();
		
		if(!empty($menu)){
			foreach ($menuArr as $depart_id=>&$arrMenu){
				foreach ($menu as $k=>$arrInfor){
					if($depart_id == $arrInfor['id']){
						if($arrInfor['parent_id'] == 0 && isset($arrInfor['sub']) && !empty($arrInfor['sub'])){
							$arrMenu['sub'] = $arrInfor['sub'];
						}
					}
				}
			}
		}
		
		$display->add('arrMenu', $menuArr);

		$arrImageHeader = array(
			1=>STATIC_URL.'flash/banner.jpg',
			2=>STATIC_URL.'flash/le_mat_1.jpg',
			3=>STATIC_URL.'flash/le_mat_2.jpg',
			4=>STATIC_URL.'flash/le_mat_3.jpg',
			5=>STATIC_URL.'flash/le_mat_4.jpg',
		);
		$display->add('arrImageHeader',$arrImageHeader);
		//$display->add('url_banner_2',STATIC_URL.'flash/slide-nude3.jpg');
		$display->output("Header");
	}
}