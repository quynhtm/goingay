<?php
class SignInForm extends Form{
	function SignInForm(){
		Form::Form('SignInForm');
		$this->link_css('style/site_css/style_form_login.css');

		//$this->link_css('style/bootstrap_2/bootstrap.css');
		/*$this->link_css('style/bootstrap_2/bootstrap.min.css');
        //$this->link_css('style/bootstrap_2/font-awesome.css');
        $this->link_css('style/bootstrap_2/font-awesome.min.css');
        $this->link_css('style/bootstrap_2/fonts.css');
        $this->link_css('style/bootstrap_2/ace.css');
        $this->link_css('style/bootstrap_2/ace.min.css');

        $this->link_js('style/bootstrap_2/ace-extra.js');*/

	}
	
	function on_submit(){
		$user_name 	= EnBacLib::getParam('email');
		$password 	= EnBacLib::getParam('password');
		$aryError = array();
		if($user_name == '') {
			$aryError[] = 'Bạn chưa nhập địa chỉ email!';
		}
		if($password == '') {
			$aryError[] = 'Bạn chưa nhập mật khẩu!';
		}
		
		// check de ban IP
		$ip = EnBacLib::ip();
		if (empty($aryError)){
			$user_data = DB::fetch('SELECT id, user_name, password, is_active, block_time,clock_user,status FROM '.TABLE_ACCOUNT.' WHERE user_name="'.$user_name.'"');
			if(!USER_ACTIVE_ON  && $user_data && !$user_data['is_active']){
				DB::query("UPDATE ".TABLE_ACCOUNT." SET is_active=1 WHERE id=".$user_data['id']);
				DB::delete('account_active','user_id='.$user_data['id']);
				User::getUser($user_data['id'], 0, 1);
			}
			if($user_data && $user_data['password'] == User::encode_password($password)){
				if(USER_ACTIVE_ON && !$user_data['is_active']){//Chưa kích hoạt
					$aryError[] = "Bạn chưa kích hoạt tài khoản!<br /><br />Bạn hãy check lại mail để kích hoạt lại tài khoản<br />
					hoặc <a href=''>click vào đây</a> để hệ thống gửi lại email kích hoạt!";
				}
				else{
					$alert = '';
					$href = base64_decode(Url::get('href',''));
					if(!$href){
						$href=Url::build('admin');
					}

					if($user_data['clock_user'] == 0){
						$aryError[] = 'Account của bạn đã bị khóa';
					}elseif($user_data['status'] == 0){
						$aryError[] = 'Account của bạn đã bị Tạm dừng hoạt động';
					}elseif($user_data['block_time'] == -1){
						$aryError[] = 'Email hoặc mật khẩu không đúng! Hãy nhập lại';
					}elseif($user_data['block_time'] > TIME_NOW){
						$acc_lock = DB::select('acc_lock','user_id='.$user_data['id']);
						if($acc_lock){
							if($acc_lock['type']==1){//Khoá vĩnh viễn
								User::LogOut();
								DB::delete(_SESS_TABLE,'user_id='.$user_data['id'],__LINE__.__FILE__);
								Url::access_denied();
							}		
							elseif($acc_lock['type']==3){//Khoá vĩnh viễn + cookie
								User::lock4Ever(true,$user_data['id']);
								Url::access_denied();
							}
							else{
								if($acc_lock['note'])
								$acc_lock['note']='\nLý do: '.str_replace(array('"',"'"),'',$acc_lock['note']);
								$alert='<script>
											alert("Tài khoản của bạn đang tạm khoá tới '.date('h:i, d/m/Y',$user_data['block_time']).'!'.$acc_lock['note'].'");
											window.location="'.$href.'";
										</script>';
							}
						}
						
						$_SESSION['user_lock']=true;
					}
					
					if(Url::get('set_cookie_save_login') == 'on'){
						$user = array('id'=>$user_data['id'],'name'=>$user_data['user_name'],'pass'=>$user_data['password']);
						EnBacLib::set_cookie("user_cc", serialize($user), 60 * 60 * 24 * 365 + TIME_NOW);//user_cc
					}
	
					$_SESSION['is_load_page_first'] = 1;// dung jQueryUI de load bang thong bao						

                    //du dieu kien login
                    if(is_array($aryError) && count($aryError) == 0){
                        User::LogIn($user_data['id']);
                        if(isset($_SESSION['user_lock']) && $_SESSION['user_lock']){
                            echo $alert;
                            exit;
                        }
                        else {
                            Url::redirect_url($href);
                        }
                    }

				}
			}
			else {
				$aryError[] = 'Email hoặc mật khẩu không đúng! Hãy nhập lại';		
			}
		}
		global $display;
		$strError = (is_array($aryError) && count($aryError) > 0) ? join('<br/>', $aryError) : '';
		$display->add('msg', $strError);
		/*
		if(User::checkLock4Ever(1)){
			Url::redirect_current();
		}*/
		
	}

	function draw(){
		global $display;		
		$this->beginForm('true');
		$user_name 	= EnBacLib::getParam('email');
		$password 	= EnBacLib::getParam('password');
		$display->add('email', $user_name);
		$display->add('password', $password);
		$display->output('SignIn');
		$this->endForm();
	}
}