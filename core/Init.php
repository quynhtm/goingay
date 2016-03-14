<?php
require_once ROOT_PATH.'core/AutoLoader.php';
if(isset($_GET["ebug"])){
	EnBacLib::set_cookie('ebug', (int)(boolean)$_GET["ebug"], TIME_NOW + 172800);// 2 ngày
}
require_once ROOT_PATH.'core/Define.php';
require_once ROOT_PATH.'core/CGlobal.php';
require_once ROOT_PATH.'core/DB.php';
CGlobal::$my_server = $server_list;

require_once ROOT_PATH.'includes/memcache.class.php';


require_once ROOT_PATH.'core/archive/functions.php';
require_once ROOT_PATH.'core/SmartyFunction.php';

if(isset($_REQUEST['trigger']) && (int)$_REQUEST['trigger']==1){
	exit();
}

require_once ROOT_PATH.'includes/display.class.php';
//Các hàm, biến, hằng cho Item

global $display;
$display = new TplLoad();

if(isset($_GET['type'])){	
	CGlobal::$curItemType = (int)$_GET['type'];
}

// Disable ALL magic_quote
//set_magic_quotes_runtime(0);
if (get_magic_quotes_gpc()){
	function stripslashes_deep($value){
		$value = is_array($value) ? array_map('stripslashes_deep', $value) : stripslashes($value);
		return $value;
	}
	$_REQUEST = array_map('stripslashes_deep', $_REQUEST);
	$_COOKIE  = array_map('stripslashes_deep', $_COOKIE);
}

if(!ERROR_PAGE){
	if(!User::is_login()){
		if(isset($_COOKIE['user_cc'])){
			$user = @unserialize($_COOKIE['user_cc']);//..user_cookie
			if(!empty($user)) {
				User::check_cookie_login($user['id'], $user['pass']);
			}
		}
	}
	else {
		if (isset($_GET['login_as'])||isset($_GET['login_as_id'])){
			if(User::is_admin() || User::have_permit(ADMIN_LOGIN_AS)){
				$tmp_saved_admin_user = array('data'=>User::$data, 'groups'=>User::$groups);
				
				$user_id = (int)Url::get('login_as_id',0);
				if(!$user_id){
					$user_name = Url::get('login_as');
					if($user_name){
						$user=DB::select('account','user_name="'.$user_name.'" ',__LINE__.__FILE__);
						if($user){
							$user_id=$user['id'];
						}
					}
				}
				
				if($user_id){
					$user=User::getUser($user_id);
					if ($user){
						if(User::is_root()  || !$user['gids'] || ($user['gids'] && !preg_match("/(".$user['gids'].")/is","9"))){
							if(User::LogIn($user_id)) {
								$_SESSION['id_login_as_user'] = $tmp_saved_admin_user['data']['id'];
								$_SESSION['ary_saved_login_as_user'] = $tmp_saved_admin_user;
								
								//LOG::do_push(array(), LOG::LOG_LOGIN_AS, LOG::ACT_DEFAULT, __FILE__, __LINE__);
							}
							
						}
					}
				}
			}
			Url::redirect_url(Url::build_all(array('login_as','login_as_id')));
		}
	}
}


if(preg_match('#index\.php#',$_SERVER["SCRIPT_NAME"])) {
	//Title mac dinh cho website
	$breakcumb = null;
	global $breakcumb;
	$breakcumb= SvLib::getPathWay();
}
//Tiền tệ:
CGlobal::$currency = array('1'=>'VNĐ');
?>