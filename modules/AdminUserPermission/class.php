<?php
class AdminUser extends Module{
    var $table_action = TABLE_ACCOUNT;
	function AdminUser($row){
		define('BAN_NICK_DATE',7);
		CGlobal::$website_title = 'Quản lý thành viên';
		Module::Module($row);
		if(User::is_login()){
			switch(Url::get('act')){
                /*
                 * Phần quản trị mới user
                 * User hoạt đông: status=1 và clock_user = 1
                 */

                case 'edit':
                    require_once 'forms/Edit.php';
                    $this->add_form(new EditForm());
                    break;
                case 'add':
                    if(User::is_root()) {
                        require_once 'forms/Edit.php';
                        $this->add_form(new EditForm());
                    }else{
                        Url::redirect('admin');
                    }
                    break;
                case 'copy':
                    if(User::is_root()) {
                        require_once 'forms/Copy.php';
                        $this->add_form(new CopyForm());
                    }else{
                        Url::redirect('admin');
                    }
                    break;
                case 'save':
                case 'apply':
                    $this->saveItem();
                    break;
                case 'clock_user':
                    if(User::is_manager()) {
                        $id=(int)Url::get('cid',0);
                        $clock_user=(int)Url::get('clock_user',0);
                        if($id){
                            DB::update ( $this->table_action, array('clock_user'=>($clock_user == 1)? 0 : 1), 'id='. $id);
                        }
                        Url::redirect_current();
                    }
                    else {
                        Url::access_denied();
                    }
                    break;
                case 'status':
                    $id = (int) Url::get('id', 0);
                    $status = (int) Url::get('status', 0);
                    if ($id) {
                        DB::update($this->table_action, array('status' => ($status == 1) ? 0 : 1), 'id=' . $id);
                    }
                    Url::redirect_current();
                    break;
                default:

                    if(User::is_root()) {
                        require_once 'forms/List.php';
                        $this->add_form(new ListForm());
                    }else{
                        Url::redirect('admin');
                    }
                    break;
			}
		}
		else{
            Url::redirect('admin');
		}
	}
    function saveItem(){
        require_once ROOT_PATH.'core/lib/function.php';
        $new_row = array();

        $user_name = Url::tget('user_name');
        $full_name = Url::tget('full_name');
        $email = Url::tget('email');
        $mobile_phone = Url::tget('mobile_phone');
        $password = Url::tget('password');
        $address = Url::tget('address');

        $new_row = array(
            'full_name'     => $full_name,
            'email'         => $email,
            'mobile_phone'  => $mobile_phone,
            'address'       => $address,);
        //ảnh khác
        $permit = Url::get('permit',array());
        if(!empty($permit)){
            $new_row['permit_action'] = implode(',',$permit);
        }

        if($user_name != ''){
            $new_row['user_name'] = $user_name;
        }
        //them mới
        $id = (int) Url::get('id',0);
        if ($id == 0) {
            $new_row['password'] = ($password != '')? $password: User::encode_password(CGlobal::$password_user);
            $new_row['create_time'] = TIME_NOW;
            $new_row['modify_time'] = TIME_NOW;
            $id = DB::insert($this->table_action, $new_row);
        } else {
            if($password != ''){
                $new_row['password'] = User::encode_password($password);
            }
            $new_row['modify_time'] = TIME_NOW;
        }

        DB::update($this->table_action, $new_row, 'id=' . $id);
        if(EnBacLib::getParam('act') == 'apply'){
            Url::redirect_current(array('act'=>'edit','id'=>$id));
        }
        else {
            if(User::is_root()) {
                Url::redirect_current();
            }else{
                Url::redirect('admin');
            }
        }
    }
}
?>
