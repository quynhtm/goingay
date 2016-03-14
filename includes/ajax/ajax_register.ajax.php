<?php
if (preg_match ( "/".basename ( __FILE__ )."/", $_SERVER ['PHP_SELF'] )) {
	die ("<h1>Incorrect access</h1>You cannot access this file directly.");
}

class ajax_register {
	static $errorList = array();
	
	function playme() {
		$code = Url::get ( 'code' );
		switch ($code) {
			/*
			case 'change_step' :
				$step_now = Url::get ( 'step_now' );
				$this->change_step ( $step_now );
				
				break;
			case 'get_list_mobile' :
				$idType = ( int ) Url::get ( 'id' );
				if ($idType == 0)
					break;
				$mobi_code = Url::get ( 'mobi_code', null );
				$this->get_list_mobile ( $idType, $mobi_code );
				
				break;
				*/
			case 'valid' :	
				$this->validData(Url::get ( 'id' ), Url::get ( 'value' ));
				break;
			case 'submitForm' :	
				$this->submitForm();
				if(count(self::$errorList) > 0 ) {
					echo json_encode(array('aryErr'=>self::$errorList, 'intReturn' => -1));
				}
				else {
					echo json_encode(array('intReturn' => 1));
				}
				break;
			default :
				$this->home ();
				break;
		}
		System::halt();
	}
	
	function home() {
            global $display;
            die ( "Nothing to do..." );
	}
	
	function validData($id, $value) {
            $err = '';
            switch ($id) {
		case 'username':
				if(!preg_match('/^[a-zA-Z0-9_]+$/', $value)) {
					$err = "<b>Username</b> không đúng định dạng. Hãy nhập lại!";
				}
				elseif (strpos(strtolower($value), 'admin') !== false ||  strpos(strtolower($value), 'boxmobi') !== false ||  DB::exists ( 'SELECT id FROM `account` WHERE `user_name`="' . strtolower($value) . '"' )) {			
					$err = "<b>Username</b> bạn chọn đã tồn tại, hãy chọn <b>Username</b> khác!";
					//$err = 'SELECT id FROM `account` WHERE `user_name`="' . strtolower($value) . '"';
				}
		    break;
		case 'tel':
			break;
                    if (trim($value) == '' || DB::exists ( 'SELECT id FROM `account` WHERE `mobile_phone`="' . $value . '"' )) {			
                        $err = "<b>Số điện thoại</b> bạn chọn đã tồn tại, hãy chọn <b>số điện thoại</b> khác!";
						//$err = 'SELECT id FROM `account` WHERE `mobile_phone`="' . $value . '"';
                    }                    
                    break;
		case 'email':
			break;
		    if (DB::exists ( 'SELECT id FROM `account` WHERE `email`="' . $value . '"' )) {			
                        $err = "<b>Email</b> bạn chọn đã tồn tại, hãy chọn <b>Email</b> khác!";
                    }                    
                    break;
        default:
				$err = "Unknow error...";
				break;
	    }
                
            if($err != '')
                echo json_encode(array('err'=>$err, 'intReturn' => -1));
            else
                echo json_encode(array('intReturn' => 1));
	}
    
	function submitForm() {
		
		$email = Url::get ( 'email' );		
			
		//$user_name = strtolower( trim( Url::get ( 'username' ) ) );
		$user_name =$email;
		
		$mobile_phone = trim ( Url::get ( 'tel','' ) );
		
		$address =  Url::get ( 'address','');
		$yahoo = Url::get ( 'yahoo','');
		$skype = Url::get ( 'skype','');
		$subscriptions = Url::get ('subscriptions', 0);
		
		$password = EnBacLib::trimSpace ( Url::get ( 'pass' ) );

 		$keycode = Url::get ( 'keycode' );
		$emailRegex = '/^[a-z0-9_]+(?:\.[a-z0-9_]+)*@' . 
				'(?:[a-z0-9][-a-z0-9]*\.)*(?:[a-z0-9][-a-z0-9]{0,62})\.(?:(?:[a-z]{2}\.)?[a-z]{2,4}|museum|travel)' . 
				'$/i';

		if (strpos(strtolower($user_name), 'admin') !== false ||  strpos(strtolower($user_name), 'boxmobi') !== false || DB::exists ( 'SELECT id FROM `account` WHERE `user_name`="' . $user_name . '"' )) {
			$this->setError ( 'username', "<b>Tên truy cập</b> bạn chọn đã tồn tại, hãy chọn <b>Tên truy cập</b> khác!" );
		}
		if(!preg_match($emailRegex, $email)) {
			$this->setError('email', '<b>Email</b> bạn chọn không hợp lệ, hãy chọn <b>Email</b> khác!');
		} elseif (DB::exists ( 'SELECT id FROM `account` WHERE `email`="' . $email . '"' )) {
			$this->setError ( 'email', "<b>Email</b> bạn chọn đã tồn tại, hãy chọn <b>Email</b> khác!" );
		}
		if(strlen($password) < 6) {
			$this->setError ( 'pass', "<b>Mật khẩu</b> tối thiểu có 6 ký tự!" );
		}
		
		if($_SESSION["enbac_validate"] != $keycode) {
			$this->setError ( 'keycode', "Mã bảo mật không chính xác. Bạn hãy nhập chính xác các ký tự ở bức ảnh bên cạnh!" );	
		}	
		
		if(! count(self::$errorList) > 0 ) {
			$user_info = array (//'user_name' => $user_name,
								 'user_name' => $email,
								 'email' => $email, 
								 'password' => User::encode_password ( $password ),
								 'mobile_phone' => $mobile_phone, 
								 'yahoo_id' => $yahoo,
								 'skype_id' => $skype,
								 'address' => $address,
								 'create_time' => TIME_NOW, 
								 'reg_ip' => EnBacLib::ip (),
								 'gids' => G_MEMBER, 
								 'is_active' => 1,
								 'status' => ACC_NOMAL);
			$id = DB::insert ( 'account', $user_info );
			
			//Insert table mail daily deal & offers
			SvLib::insertMailDailyOffer($email, $subscriptions);
						
			if ($id && $id > 0) {
				$new_row = array();
				$aryError = array();
				if(isset($_FILES ['avatar'])) {
					$aryResult = SoImg::uploadImages($_FILES, $aryError, $id, SoImg::FOLDER_AVATAR, TIME_NOW);
					if($aryResult['avatar'] != '') {
						$new_row['avatar_url'] = $aryResult['avatar'];
					}
					DB::update('account',$new_row,'id = '.$id);
				}
				User::LogIn($id);
			} else {
				$this->setError ( '', "Chưa đăng ký được, mời bạn thử lại!" );
			}
		}
	}
	
	function setError($key, $value) {
		self::$errorList[$key] = $value;
	}
	
} //class