<?php
if (preg_match ( "/".basename ( __FILE__ )."/", $_SERVER ['PHP_SELF'] )) {
	die ("<h1>Incorrect access</h1>You cannot access this file directly.");
}

class ajax_user {
	function playme(){
		$code = Url::get('code');
		switch( $code ){
			case 'user_info':
				$this->get_user_info();
				break;
			case 'update':
				$this->edit_user_info();
				break;
			case 'login_user':
				$this->login_user();
				break;
			case 'register':
				$this->check_exist_account();
				break;
			case 'captcha_register':
				$this->fn_captcha_register();
				break;
			case 'password':
				$this->check_password();
				break;
			case 'forgot_password':
				$this->forgot_password();
				break;
			
			case 'remove_email_alert':
				$this->fn_remove_email_alert();
				break;
			
			case 'del_openid':
				$this->del_openid();
				break;
			
			case 'invalid_user':
				$this->fn_invalid_user();
				break;
			case 'check_online':
				$this->check_online();
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

	function fn_captcha_register(){
		if(User::checkLock4Ever(1)){
			echo "false";
			exit;
		}
		$captcha_register = EnBacLib::getParam('captcha_register');
	
		if(isset($_SESSION["enbac_validate"]) && $captcha_register!='' && $captcha_register == $_SESSION["enbac_validate"]){
			echo "true";
			exit;
		}
		else{
			echo "false";
			exit;
		}
	}

	function get_user_info(){
		global $display;
	
		$user_id  	= EnBacLib::getParam('user_id');
		$info  		= EnBacLib::getParam('id');
	
		$info_array =  array('blast','address','mobile_phone','home_phone','yahoo_id','skype_id','email','website','signature','up_item');
	
		if(!in_array($info,$info_array)){
			die("no_info");
		}
	
		if($user_id && (User::have_permit(ADMIN_USER) ||  (User::id() == $user_id && !User::is_block()))){
			$sql = "SELECT $info FROM account WHERE id='$user_id'";
			DB::query($sql);
			$row = DB::fetch_row();
			echo str_replace('&#33;','!',$row["$info"]);
		}
		else{
			die("no_perm");
		}
	}

	function edit_user_info(){
		$user_id	= (int)Url::get('user_id',0);
		$info  		= EnBacLib::getParam('id');
		$value  	= EnBacLib::getParam('value');
		$input      = array();
		$output 	= '';
	
		if($user_id && (User::have_permit(ADMIN_USER) ||  (User::id() == $user_id && !User::is_block()))){
			if($info == 'up_item'){//Sửa số lượt up tin
				if(User::have_permit(ADMIN_USER)){
					$value = (int)$value;
					$input = array('up_item'=>($value>0?$value:0));
					$output = '<b>'.$value.'</b>';
					echo $output;
	
					$user 	= DB::select('account',"id=$user_id");
					$admin 	= User::$data;
					if($user){
						$up_count 	= $value - $user['up_item'];
	
						if($up_count!=0){
							$up_log_sql = "INSERT INTO up_log (`user_id`,	`user_name`,			`admin_id`,		`admin_name`,			`time`,	 `up_count`,`up_before`,		`up_after`)
												VALUES ({$user['id']},	'{$user['user_name']}',{$admin['id']},	'{$admin['user_name']}',".TIME_NOW.",$up_count,'{$user['up_item']}',$value)";
	
							DB::query($up_log_sql);
	
							if($up_count>0){
								$update = DB::query('UPDATE account SET up_item=up_item + '.$up_count.' WHERE id='.$user_id);
							}
							else{
								$update = DB::query('UPDATE account SET up_item=up_item - '.abs($up_count).' WHERE id='.$user_id);
							}
	
							//DB::Update('account',$input,"id=$user_id");
							User::getUser($user_id,0,1);
						}
					}
					exit;
				}
			}
			elseif(!EnBacLib::checkBadWord($value) || User::have_permit(ADMIN_USER)){
				$output = 'Ch&#7913;c n&#259;ng n&#224;y &#273;ang &#273;&#432;&#7907;c b&#7893; sung. &#7844;n F5 &#273;&#7875; t&#7843;i l&#7841;i trang.';
	
				if($info == 'blast'){
					$input 		= array('blast'=>$value);
					$userblast 	= ' '.EnbacLib::BBCode(EnBacLib::cleanHtml($value));
	
					if(strpos($userblast,'http://')){
						$user_blast = $userblast;
						while(strpos($user_blast,'http://')){
							$tmp = substr($user_blast,strpos($user_blast,'http://'));
							if(strpos($tmp,' ') || strpos($tmp,'<')){
								if(strpos($tmp,' ') && strpos($tmp,'<') && (strpos($tmp,' ') > strpos($tmp,'<'))){
									$blast_url = substr($tmp,0,strpos($tmp,'<'));
								}
								else{
									$blast_url = substr($tmp,0,strpos($tmp,' '));
								}
							}
							else{
								$blast_url = $tmp;
							}
							$user_blast = str_replace($blast_url,'',$user_blast);
						}
						$new_blast_url = ' <a href="'.$blast_url.'" target="_blank">Click here</a>';
						$userblast = substr($user_blast.$new_blast_url,1);
					}
	
					$user 	= User::getUser($user_id);
	
	
					if($value){//blast không trống
						if($value!=$user['blast']){//Thay đổi blast
							DB::delete("feed","user_id=$user_id AND type = 8");
	
							//thêm vào feed cho các thành viên theo đuôi
							DB::query("INSERT INTO 	feed 	(type, 	user_id,  act_user_id,  time)
													VALUES	(8,		$user_id, $user_id, ".TIME_NOW.")");
						}
					}
					else{//Xoá blast
						DB::delete("feed","user_id=$user_id AND type = 8");
					}
	
					$output = $userblast.' <img src="style/images/icon/icon_edit.gif" title="Click để sửa..." alt="Click để sửa..." class="hand_point" rel="blast" align="absmiddle">';
				}
				elseif($info == 'address'){
					$input = array('address'=>trim($value));
					$output = EnBacLib::word_limit($value,12,'');
				}
				elseif($info == 'mobile_phone') {
	
					$value = preg_replace("/[^0-9]/", "", $value);
	
					if(!EnBacLib::is_mobile($value)){
						$value = '';
					}
	
					$input = array('mobile_phone'=>trim($value));
					$output = EnBacLib::word_limit($value,10,'');
	
				}
				elseif($info == 'home_phone'){
	
					if(User::have_permit(ADMIN_USER) || User::$data['phone_verify']==0){
						$value = preg_replace("/[^0-9]/", "", $value);
	
						if(EnBacLib::is_mobile($value) || substr($value,0,1)!="0"){
							$value = '';
						}
	
						$input = array('home_phone'=>trim($value));
						$output = EnBacLib::word_limit($value,10,'');
					}
				}
				elseif($info == 'yahoo_id'){
					$input = array('yahoo_id'=>trim($value));
					$output = EnBacLib::word_limit($value,12,'');
				}
				elseif($info == 'skype_id'){
					$input = array('skype_id'=>trim($value));
					$output = EnBacLib::word_limit($value,12,'');
				}
				elseif($info == 'website'){
					$input = array('website'=>trim($value));
					$website = $value;
					if($website!=''){
						if(strrpos($website,'ttp://')!=1){
							$website = 'http://'.$website;
						}
	
						if(strlen($website) > 8){
							if(strpos($website,'/',8)>0){
								$website = substr($website,0,strpos($website,'/',8));
							}
						}
					}
					$website = '<a href="'.$value.'" target="_blank" class="lineHeight18"><strong>'.EnBacLib::strippedLink($website,26).'</strong></a>';
					$output = $website;
				}
				elseif($info == 'email' && User::is_admin()){
					$input = array('email'=>trim($value));
					$output = $value;
				}
				elseif($info == 'signature'){
					$input 	= array('signature'=>trim($value));
					$output = EnbacLib::parseBBCode(EnBacLib::cleanHtml($value));
				}
				else{
					$output = '';
				}
	
				echo $output;
			}
			else{
				echo 'N&#7897;i dung c&#243; t&#7915; x&#7845;u! Click &#273;&#7875; s&#7917;a nhanh.';
				exit;
			}
		}
		else{
			echo('B&#7841;n kh&#244;ng c&#243; quy&#7873;n s&#7917;a th&#244;ng tin th&#224;nh vi&#234;n');
			exit;
		}
	
		if($input){
			DB::Update('account',$input,"id=$user_id");
			User::getUser($user_id,0,1);
			User::$current = new User();
		}
		exit;
	}

	function login_user(){
		echo User::LoginByUserNameOrEmail();
		die();
	}



	function check_exist_account(){
	
		if(user::checkLock4Ever(1)){
			echo "false";
			exit;
		}
	
		if(isset($_REQUEST['register_user_name'])) {
			$username = trim($_REQUEST['register_user_name']);
	
			if (!preg_match('/^[a-zA-Z0-9\_]+$/', $username)) {
			   $resp = 'false';
			 }
			 else {
				  $sql = "select id from account where user_name = '".$username."'";
				  DB::query($sql);
				  if(DB::num_rows()) {
						$resp = 'false';
					}
				  else {
						$resp = 'true';
					}
			 }
	
			echo $resp;
			exit;
		}
		elseif(isset($_REQUEST['email'])) {
			$email = trim($_REQUEST['email']);
	
			$sql = "SELECT id FROM account WHERE email = '".$email."'";
			DB::query($sql);
			if(DB::num_rows()){
				$resp = 'false';
				echo $resp;
				exit;
			}
			else {
				$resp = 'true';
				echo $resp;
				exit;
			 }
	
		}
	}

	function check_password(){
		if(isset($_REQUEST['old_password']) && User::is_login()){
			$password = $_REQUEST['old_password'];
			$sql = "select id from account where password = '".User::encode_password($password)."' and id='".User::$data['id']."'";
			DB::query($sql);
			if(DB::num_rows()){
				$resp = 'true';
			 }
			else {
				$resp = 'false';
			 }
	
			echo $resp;
			exit;
		}
		else {
			echo "no_login";
			exit;
		}
	}

	function forgot_password(){
		$email = Url::get("email","");
		$captcha_register = EnBacLib::getParam('captcha_register');
		$str_error = "";
	
		if($email && $captcha_register){
	
			$sql = "SELECT id FROM account WHERE email = '$email'";
			DB::query($sql);
	
			if(!DB::num_rows()){
				$str_error .= "<div>Email này không tồn tại</div>";
			}
	
			if(!isset($_SESSION["enbac_validate"]) || $captcha_register=='' || $captcha_register != $_SESSION["enbac_validate"]){
				$str_error .= "<div>Mã bảo mật không đúng</div>";
			}
	
			if(!$str_error){
				if($row=DB::fetch("SELECT id,user_name,email FROM account WHERE email ='$email'")){
	
					$id 	= $row['id'];
					$user 	= $row['user_name'];
					$email 	= $row['email'];
	
					$link = Url::build('forgot_password',array('u'=>md5($user.$email),'id'=>$id));
				
					$link1 = '<a href="'.$link.'"><b>Khôi phục Mật khẩu</b></a>';
					$link2 = '<a href="'.$link.'"><b>Khoi phuc Mat khau</b></a>';
	
					$message = file_get_contents('templates/SvForgotPassword/messenger.html');
	
					$message = str_replace('[[|link1|]]',$link1,$message);
					$message = str_replace('[[|link2|]]',$link2,$message);
					$message = str_replace('[[|user|]]',$user,$message);
					$message = str_replace('[[|STATIC_URL|]]',STATIC_URL,$message);
	
					if(System::sendSVEmail($email,'Khôi phục mật khẩu!',$message)){
						$str_error = "";
					}
					else{
						$str_error .= "<div>Email chưa được gửi đi. Hãy thử lại lần nữa</div>";
					}
				}
			}
		}
		else{
			$str_error = "<div>Có lỗi xẩy ra. Không thực hiện được</div>";
		}
	
		echo $str_error;
		exit();
	}
	
	
	
	
	
	
	function fn_remove_email_alert(){
		$user_id 	 = (int)Url::get('user_id');
		$active_code = Url::get('active_code');
	
		if(!$user_id || !$active_code){
			echo "unsuccess";
			exit;
		}
	
		$arrUserCurrent = User::getUser($user_id);
		$time_del = TIME_NOW-24*3600;
		if(md5($arrUserCurrent["id"].$arrUserCurrent["password"].$arrUserCurrent["user_name"]) == $active_code){
	
			$id1 = DB::query('UPDATE account SET email_alert=0 WHERE  id='.$user_id);
			$id2 = DB::query('DELETE cron_job WHERE  user_id="'.$user_id.'"');
	
			User::getUser($user_id,0,1);
	
			if($id1 && $id2){
				echo Url::get('user_id');
				exit;
			}
			else{
				echo "unsuccess";
				exit;
			}
		}
		else{
			echo "unsuccess";
			exit;
		}
	}




	function del_openid(){
		$o_id = (int)Url::get('o_id',0);
		if(!User::is_login()){
			echo "not_login";
			exit;
		}
	
		if(User::checkLock4Ever(1) || !$o_id){
			echo "no_perm";
			exit;
		}
		else{
			$openid=DB::select("openid",'id='.$o_id." AND user_id=".User::id());
			if($openid){
				DB::delete('openid','id='.$o_id);
				echo "success";
			}
			else{
				echo "invalid";
				exit;
			}
		}
	}


	function fn_invalid_user(){
		if(!User::is_login() || !User::have_permit(array(ADMIN_USER,MOD_VALID_USER))){
			echo "no_perm";
			exit;
		}

		$user_id 	= (int)Url::get('user_id',0);
		$invalid_time = (int)Url::get('invalid_time',0);
		$date_invalid 	= (int)Url::get('date_invalid',0);
		$type_invalid 	= (int)Url::get('type_invalid',0);
		$reason_invalid = EnbacLib::getParam('reason_invalid','');
		$reason_invalid = ($reason_invalid) ? $reason_invalid : 'Không nhập lý do kiểm duyệt' ;
		$user = User::getUser($user_id);

		if (($user['invalid_time'] > 0) || ($user['invalid_time'] == -1)){
			if(DB::update('account',array('invalid_time'=>"0"),'id ='.$user_id)){
				$sql_select_reason = 'SELECT id,admin_name,time FROM acc_lock WHERE user_id = '.$user_id.' AND type = 2 ORDER BY id DESC LIMIT 1';
				$user_invalid = DB::fetch($sql_select_reason);

				if(MEMCACHE_ON){
					$sql 	= "SELECT * FROM item
							   WHERE user_id = $user_id AND status = 2 AND valid_time = {$user_invalid['time']} AND modify_time_user = 0 AND valid_user ='{$user_invalid['admin_name']}'";
					$re 	= DB::query($sql);

					while($item_memcache = mysql_fetch_assoc($re)){
						$item_memcache['status'] 			= 1;
						$item_memcache['valid_time'] 		= TIME_NOW;
						$item_memcache['valid_user'] 	= User::user_name();
						eb_memcache::do_put("item:".$item_memcache['id'],$item_memcache);
					}
				}
				if(User::have_permit(array(ADMIN_USER))){ // chi admin quyen User moi duoc mo kiem duyet thanh vien
					DB::update('item',array('status'=>1,'valid_time'=>TIME_NOW,'valid_user'=>User::user_name()),'user_id = '.$user_id.' AND status = 2 AND valid_time = '.$user_invalid['time'].' AND modify_time_user = 0 AND valid_user ="'.$user_invalid['admin_name'].'"');
					DB::update('acc_lock',array('unlock_time'=>TIME_NOW,'unlock_user'=>User::user_name()),'id = '.$user_invalid['id']);
				}
				User::getUser($user_id,1,0); // update lai cache user
				echo $user['id'];
				exit;
			}
		}
		elseif ($user['invalid_time'] == 0){
			if($type_invalid==1 && $date_invalid){
				$timeInvalid = TIME_NOW+($date_invalid*3600*24);
			}
			elseif($type_invalid == 2){
				$timeInvalid = -1;
			}
			else {
				echo 'fail_valid';
				exit;
			}
			if(DB::update('account',array('invalid_time'=>$timeInvalid),'id ='.$user_id)){

				$user=DB::fetch('SELECT id,user_name FROM account WHERE id  = '.$user_id);

				if($user){
					DB::insert('acc_lock',array('time'=>TIME_NOW,'time_expire'=>$timeInvalid,'user_id'=>$user['id'],'user_name'=>$user['user_name'],'type'=>2,'note'=>$reason_invalid,'admin_id'=>User::id(),'admin_name'=>User::user_name()));
				}
				$sql_item = 'SELECT id FROM item where user_id = '.$user_id.' AND status = 1';
				$re_item=DB::query($sql_item);
				while ($item=mysql_fetch_assoc($re_item)){
					$reason = "KDTV : $reason_invalid";
					$sql_insert = "INSERT INTO bad_content (`type`,`id_item`,`user_id`,`user_name`,`reason`,`time_post`) VALUES (2,{$item['id']},".User::id().",'".User::user_name()."','".$reason."',".TIME_NOW.")";
					DB::query($sql_insert);
				}

				if(MEMCACHE_ON){
					//$sql 	= "SELECT  id, name, sapo, created_time, auction_end_time, up_time, user_id, user_name, brief, description, read_count, bid_count,reply_count, status, modify_time, modify_user_name, province_id, category_id, transaction_type, currency_id, price, price_out,step_price ,buy_now_price , winner_price, winner_id, winner_name, original_image_url, auction_start_time, level_1_category_id, bad_words, search_tag, is_up_auto, state, shop_order, have_image
					$sql 	= "SELECT * FROM item
							   WHERE user_id = $user_id AND status = 1";
					$re 	= DB::query($sql);

					while($item_memcache = mysql_fetch_assoc($re)){
						$item_memcache['status'] 			= 2;
						$item_memcache['valid_time'] 		= TIME_NOW;
						$item_memcache['valid_user'] 	= User::user_name();
						eb_memcache::do_put("item:".$item_memcache['id'],$item_memcache);
					}
				}

				DB::update('item',array('status'=>"2",'valid_time'=>TIME_NOW,'valid_user'=>User::user_name()),'user_id = '.$user_id.' AND status = 1');
				User::getUser($user_id,1,0); // update lai cache user
				echo $user['id'];
				exit;
			}
		}else{
			echo 'fail_valid';
			exit;
		}
	}

	function check_online(){
		$user_id =	(int)Url::get('user_id');

		if($user_id){
			$json = '';

			$sql="SELECT user_id, user_name, session_expires FROM "._SESS_TABLE." WHERE user_id=$user_id ORDER BY session_expires DESC LIMIT 1";

			$re=DB::query($sql);
			if($re){

				$user = mysql_fetch_assoc($re);
				if($user && $user['session_expires']>( TIME_NOW - 900 )){
					echo 1;
					exit;
				}
			}
		}
		echo 0;
		exit;
	}	
}//class