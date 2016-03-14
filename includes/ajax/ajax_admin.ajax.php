<?php
/*
+--------------------------------------------------------------------------
|   Web: http://www.enbac.com 
|   Started date : 30/06/2008
+---------------------------------------------------------------------------
|   > Script written by Nova
+---------------------------------------------------------------------------
*/

if (preg_match ( "/".basename ( __FILE__ )."/", $_SERVER ['PHP_SELF'] )) {
	die ("<h1>Incorrect access</h1>You cannot access this file directly.");
}

class ajax_admin {
	function playme(){
		$code = EnBacLib::getParam('code');
		switch( $code ){
			case 'add_admin':
				$this->fn_add_admin();
				break;
			case 'item_del_admin':
				$this->fn_item_del_admin();
				break;					
			case 'reset_success':
				$this->fn_reset_pas();
				break;
						
			case 'grant_permit':
				$this->grant_permit();
				break;		
			case 'grant_category':
				$this->grant_category();
				break;
			case 'active_user':
				$this->fn_active_user();
				break;
			case 'send_email_active':
				$this->fn_send_email_active();
				break;
			case 'add_up_item':
				$this->fn_add_up_item(1);
				break;
			
			case 'del_item_reason':
				$this->fn_del_item_reason();
				break;
			case 'del_reason':
				$this->fn_del_reason();
				break;				
			case 'del_static_cache':
				$this->fn_del_static_cache();
				break;
			case 'del_product_network':
				$this->del_product_network();
				break;
			
			case 'del_bill_permit' :
				$this->fnDeletePermitBill();
				break;
			case 'regis_bill_permit' :
				$this->fnRegisterPermitBill();
				break;
            case 'upload_image_news' :
				$this->upload_image_news();
				break;
			default:
				$this->home();
				break;
		}
	}
	
	function home(){
		global $display;
		die("Nothing to do...");
	}
	/**
	 * upload ảnh TIN TUC
	 */
	function upload_image_news() {
		$id = Url::get('id', 0);
        $dataImg = $_FILES["multipleFile"];
        $aryData = array();
        $aryData['intIsOK'] = -1;
        $aryData['msg'] = "Dữ liệu không tồn tại";
        //SvLib::FunctionDebug($dataImg);
        if (!empty($dataImg)) {
            $aryError = $tmpImg = array();
            $old_file = '';
            $file_name = SvImg::uploadImages($dataImg['tmp_name'], $dataImg['name'], $old_file, CGlobal::$image_news, $aryError, $id, SvImg::FOLDER_NEWS);
            //SvLib::FunctionDebug($file_name);
            if ($file_name != '' && empty($aryError)) {
                $tmpImg['name_img'] = $file_name;
                $tmpImg['id_key'] = rand(10000, 99999);
                $tmpImg['src'] = SvImg::getImageBySize($file_name, CGlobal::size_image_80, $id, SvImg::FOLDER_NEWS, OPT_GET_IMAGE);
            }
            $aryData['intIsOK'] = 1;
            $aryData['info'] = $tmpImg;
        }
		echo json_encode($aryData);
		exit();
	}

    function fnDeletePermitBill() {
		//Check quyen cao nhat neu can
		$id = Url::get('id', 0);
		$aryData = array();
		if($id > 0) {
			$del = DB::delete('account_permit_bill', 'id='.$id);
			if($del) {
				$aryData['intIsOK'] = 1;
			}
			else {
				$aryData['intIsOK'] = -1;
				$aryData['msg'] = "Dữ liệu không tồn tại";
			}
		}
		else {
			$aryData['intIsOK'] = -1;
			$aryData['msg'] = "Dữ liệu không tồn tại";
		}
		echo json_encode($aryData);
		exit();
	}
	
	function fnRegisterPermitBill() {
		$aryData = array();
		$strChk = Url::get('strChk');
		$chk = (int)Url::get('chk', 0);
		$user_name = trim(Url::get('user_name'));
		$email = Url::get('email');
		$user_id = Url::get('user_id');
		
		$aryUser = array();
		//Check phan quyen
		$cond = '';
		if($user_name != '') {
			$cond .= "user_name= '".$user_name. "'";
			$aryUser = User::getByUserName($user_name);
		}
		else {
			if($email != '') {
				$cond .= "email='".$email."'";
				$aryUser = DB::select('account', "email='".$email. "'");
			}
			else {
				if($user_id != '') {
					$cond .= 'user_id='.$user_id;
					$aryUser = User::getUser($user_id);
				}
			}
		}
		//Check trung
		$aryExits = DB::select('account_permit_bill', $cond);
		if(empty($aryExits)) {
			if(empty($aryUser)) {
				$aryData['intIsOK'] = -1;
				$aryData['msg'] = 'Không tông tại account trong hệ thống';
			}
			else {
				$aryDataInsert = array();
				$aryDataInsert['user_id'] = $aryUser['id'];
				$aryDataInsert['user_name'] = $aryUser['user_name'];
				$aryDataInsert['email'] = $aryUser['email'];
				$aryDataInsert['d_ids'] = ($chk == 0) ? "0" : $strChk;
				$aryDataInsert['create_id'] = User::id();
				$aryDataInsert['create_date'] = TIME_NOW;
				$id = DB::insert('account_permit_bill', $aryDataInsert);
				if($id) {
					$aryData['intIsOK'] = 1;
				}
			}
		}
		else {
			$aryData['intIsOK'] = -1;
			$aryData['msg'] = 'Account này đã được phần quyền quản trị hóa đơn';
		}
		echo json_encode($aryData);
		exit();
	}

	
	function fn_add_admin(){
		if(!User::is_admin()){
			echo 'no_perm';	
			exit;
		}
		
		$id_admin 			= (int)Url::get('id_admin');
		$user_name_admin 	= EnBacLib::getParam('user_name_admin');
		$group_id 		 	= (int)EnBacLib::getParam('group_id');
		
		if($group_id==G_ROOT && (!User::is_root() && !User::have_permit(ADMIN_PERMISSION))){//Nếu phân quyền root
			echo 'no_perm';	
			exit;
		}
		
		if($id_admin>0 || $user_name_admin!='') {
			if($id_admin)
			$user = User::getUser($id_admin);
			else{
				$user=DB::select('account','user_name="'.$user_name_admin.'"');
			}
			
			if($user){
				$groups=User::get_groups($user['gids']);
				
				if(isset($groups[$group_id])){
					User::getUser($user['id'],0,1);
					echo "exist_admin";
					exit;
				}
				else{
					if($user['gids']=='0'){
						$user['gids']=$group_id;
					}
					else{
						$user['gids'].='|'.$group_id;
					}
					
					if(DB::query('UPDATE account SET gids="'.$user['gids'].'" WHERE id='.$user['id'])){
						User::getUser($user['id'],0,1);
						echo "success";		
						exit;
					}
					else {
						echo "unsuccess";		
						exit;
					}
				}
			}
			else{
				echo "no_exist";
				exit;
			}
		}
		else {
			echo "invalid";
			exit;	
		}
	}
	
	function grant_permit(){
		if(!User::is_admin()){
			echo 'no_perm';	
			exit;
		}
		
		$type				= (int)Url::get('type');
		$ref_id				= (int)Url::get('ref_id');
		$pids 				= EnBacLib::getParam('pids');
		
		if($ref_id==0 && in_array($ref_id,array(G_ADMIN, G_ROOT))){//Không được phân quyền cho admin và root
			echo "unsuccess";	
			exit;
		}
		
		if($ref_id>0){
			if($type==0 && !isset(CGlobal::$group[$ref_id])){
				echo "invalid";
				exit;	
			}
			if($type==1 && !User::getUser($ref_id)){
				echo "invalid";
				exit;	
			}
			
			$permit=DB::select('account_permit','type='.$type.' AND ref_id='.$ref_id);
			if(!$permit){
				$permit=array (
								'type'	=>$type,
								'ref_id'=>$ref_id,
								'pids'	=>$pids
							 );
			}
			else{
				$permit['pids']=$pids;
			}
			
			if(DB::insert('account_permit',$permit,true)){
				User::getUser($ref_id,0,1);
				User::get_permits(1,$ref_id);
				echo "success";		
				exit;
			}
			else {
				echo "unsuccess";		
				exit;
			}
		}
		else {
			echo "invalid";
			exit;	
		}
	}
	
	function grant_category(){
		if(!User::is_admin()){
			echo 'no_perm';	
			exit;
		}
		
		$user_id			= (int)Url::get('user_id');
		$cids 				= EnBacLib::getParam('cids');
		
		if($user_id>0){
			$user=User::getUser($user_id);
			if(!$user){
				echo "invalid";
				exit;	
			}
			
			$cid_arr=explode(',',$cids);
			$cids='';
			if($cid_arr){
				EnBacLib::getCats();
				
				foreach ($cid_arr as $cid){
					if(isset(CGlobal::$allCategories[$cid]))
					$cids.=($cids?',':'').$cid;
				}
			}
			
			$permit=DB::select('account_permit','type=1 AND ref_id='.$user_id);
			if(!$permit){
				$permit=array(
								'type'	=>1,
								'ref_id'=>$user_id,
								'pids'	=>$permit['pids'],
								'cids'	=>$cids
								);
			}
			else{
				$permit['cids']=$cids;
			}
			
			if(DB::insert('account_permit',$permit,true)){
				User::getUser($user_id,0,1);
				echo "success";		
				exit;
			}
			else {
				echo "unsuccess";		
				exit;
			}
		}
		else {
			echo "invalid";
			exit;	
		}
	}
	
	function fn_reset_pas(){
		$user_id = EnBacLib::getParam('user_id');
		$user 	 = User::getUser($user_id);
		
		//dungbt sua de user dc phan quyen co the su dung
		if(!$user_id || !$user || ($user_id !=User::id() && !User::have_permit(ADMIN_USER))){
			echo "no_perm";
			exit;
		}		
		
//		$gid 		  = User::check_admin($user['gids']);
		
//		if($user_id !=User::id() && ($gid ==  G_ROOT || ($gid== G_ADMIN && !User::is_root() && !have_permit(ADMIN_PERMISSION)) )){//root ko đc đổi pass của root, admin ko đc đổi pass admin
		/*if($user_id !=User::id() && !User::have_permit(ADMIN_USER)) {//root ko đc đổi pass của root, admin ko đc đổi pass admin
			echo "no_perm";
			exit;
		}*/
		
		$checked 	= EnBacLib::getParam('checked');		
		//EnBacLib::getParam('pas');//Chú ý đối với mật khẩu ko đc dùng qua hàm này vì dữ liệu sẽ bị biến dạng
		$pas 		= Url::get('pas');
		$user_name 	= $user['user_name'];		
		
		if($checked=='on'){
				
			$messenger=file_get_contents('templates/SoForgotPassword/reset_password.html');
			$message=str_replace('[[|user_name|]]',$user_name,$messenger);
			$message=str_replace('[[|password|]]',$pas,$message);
			$subject = 'Khôi phục mật khẩu!';
			
			$row = DB::fetch('SELECT email FROM account WHERE id="'.$user_id.'"');	
			
			if(System::sendSVEmail($row['email'],$subject,$message)){
					$id_update = DB::update('account',array('password'=>User::encode_password($pas)),"id =$user_id");
					if($id_update){
						echo "success";
						exit;
					}
				}
			else
				{
					echo "unsuccess";
					exit;
				}		
		}
		else{
			$id_update = DB::update('account',array('password'=>User::encode_password($pas)),'id ="'.$user_id.'"');
			if($id_update){
				echo "success";
				exit;
			}
		}				
	}	
	


  	function fn_active_user(){
		if(!User::is_login()){
			echo "not_login";
			exit;
		}
		
		if(!User::have_permit(ADMIN_USER)){
			echo "no_perm";
			exit;
		}	
		
		$user_id = EnBacLib::getParam('user_id');
		$gids 	 = EnBacLib::getParam('gids');
		$action 	 = EnBacLib::getParam('action');	
			
		if(!User::check_higher_permis(User::$data['gids'],$gids)){
			echo "no_perm";
			exit;
		}
		
		if($user_id && $action=='de_active'){
			$user_info = DB::fetch('SELECT password FROM account WHERE id="'.$user_id.'"');
			$active_code = md5(TIME_NOW.$user_info['password']);
			
			$id_update = DB::update('account',array('is_active'=>1),'id="'.$user_id.'"');
			$id_insert = DB::insert('account_active',array('user_id'=>$user_id,'active_code'=>$active_code,'time'=>TIME_NOW));
		
			if($id_update && $id_insert ){
				echo "success";
				exit;
			}else{
				echo "unsuccess";
				exit;
			}		
		}
		elseif($user_id && $action=='active'){
			$id_update = DB::update('account',array('is_active'=>0),'id="'.$user_id.'"');
			//$id_delete = DB::delete('account_active','user_id="'.$user_id.'"');
			
			if($id_update ){
				echo "success";
				exit;
			}else{
				echo "unsuccess";
				exit;
			}
			
		}
		else{
			echo "unsuccess";
			exit;
		}
  	}

  	function fn_send_email_active(){
  
	if(!User::is_login()){
			echo "not_login";
			exit;
	}
	
	if(!User::have_permit(ADMIN_USER)){
		echo "no_perm";
		exit;
	}	
	
	$user_id = EnBacLib::getParam('user_id');
	
	if($user_id){
		$user_info = DB::fetch('SELECT a.is_active, a.user_name,a.email,aa.active_code FROM account a, account_active aa WHERE a.id="'.$user_id.'" AND aa.user_id="'.$user_id.'"');
		if($user_info['is_active']==1){									
			global $display;
			$display->add('eb_url',WEB_ROOT);
			$display->add('user_id',$user_id);
			$display->add('user_name',$user_info['user_name']);
			$display->add('active_code',$user_info['active_code']);			
			$content_email = $display->output('send_active_mail',1,'RegisterSuccess');
			
			if(System::sendSVEmail($user_info['email'],'Kích hoạt tài khoản',$content_email,'Enbac.com')){
				echo "success";
				exit;
			}
			else{
				echo "unsuccess";
				exit;
			}
		}		
	}
	else{
		echo "unsuccess";
		exit;
	}	  	
  }
    

	
	
	

	function fn_del_reason(){	
		if(!User::is_login()){
			echo "not_login";
			exit;
		}
		if(!User::have_permit(ADMIN_ITEM)){
			echo "no_perm";
			exit;
		}
	
		$id = (int)Url::get('id',0);
		if (EnBacLib::del_reason_mod($id)){
			echo $id;
			exit();
		}
		else{
			echo "unsuccess";
			exit;
		}
					
	}
	
	function fn_del_static_cache(){
		if(!User::is_login()){
			echo "not_login";
			exit;
		}
		if(!User::have_permit(ADMIN_ITEM)){
			echo "no_perm";
			exit;
		}
		$cache_file = Url::get('cache_file');
		StaticCache::delCache($cache_file);
		echo 'success';
		exit;
	}
	
	function del_product_network(){		
		if(!User::is_admin()){
			echo "no_perm";
			exit;
		}
		$product_id = (int)Url::get('id',0);
		
		if($product_id){
			
			$success_id = EnBacLib::del_product_telecom($product_id);
			
			echo $success_id;
			exit();
			
		}
		else{
			echo "unsuccess";
			exit();
		}
		
	}
}//class
?>