<?php
User::$current = new User();
class User{
    static  $groups = array(),
        $privilege = array(),
        $data=array('id'=>'0','email'=>'','user_name'=>'guest'),
        $current=false,
        $permits='' // Các quyền fix đc định nghĩa trong CGlobal
    ,$permit_cats='' //$permit_cats - cái này là của hệ thống cũ - sẽ bỏ sau
    ,$p_cat = 0 //phân quyền cho bảng so_category
    ,$p_depart = array() //phân quyền cho bảng so_products_category - nhưng chỉ lấy riêng các depart ra
    ,$p_cat_product = array(); //phân quyền cho bảng so_products_category - toàn bộ các category_id

    function User(){
        if(!isset($_SESSION['user_id'])){
            $_SESSION['user_id']=0;
        }
        if($_SESSION['user_id']){
            $user = User::getUser((int)$_SESSION['user_id']);
            if($user && (!USER_ACTIVE_ON || (USER_ACTIVE_ON && $user['is_active']==0))){
                self::$groups = User::get_groups($user['permit_action']);
                if(!self::checkLock4Ever(true)){
                    if(!isset(self::$groups[1]) && !isset(self::$groups[2]) && $_SESSION['user_id']!=4 && (trim($user['user_name'])=='' || $user['block_time'] > TIME_NOW || $user['block_time']==-1)){
                        if($user['block_time']==-1){//Khoá vĩnh viễn
                            $acc_lock = DB::select('acc_lock','user_id='.$user['id'].' AND type IN(1,3) ORDER BY id DESC',__LINE__.__FILE__);
                            if($acc_lock){
                                if($acc_lock['type']==3){//Khoá cookie
                                    self::lock4Ever(true,$user['id']);
                                }
                            }
                            self::LogOut();
                        }
                        else{
                            $_SESSION['user_lock']=true;
                            self::$data=$user;
                            $_SESSION['user_name']=$user['user_name'];
                        }
                    }
                    else{
                        self::$data=$user;
                        $_SESSION['user_name']=$user['user_name'];
                        if(isset($_SESSION['user_lock'])){
                            $_SESSION['user_lock']='';
                            unset($_SESSION['user_lock']);
                        }
                    }
                }
            }
            else{
                self::LogOut();
            }
        }
    }

    static function checkLock4Ever($kick_out=false){//Hàm kiểm tra khoá người dùng vĩnh viễn từ cookie
        if(isset(User::$groups[1])||isset(User::$groups[2])||$_SESSION['user_id']==4){
            if(isset($_SESSION['lock_4ever']))$_SESSION['lock_4ever']=0;
            if(isset($_COOKIE['lock_4ever'])) EnBacLib::set_cookie('lock_4ever',0,TIME_NOW-1);
            return false;
        }
        else{
            if(isset($_COOKIE['lock_4ever']) || (isset($_SESSION['lock_4ever'])&&$_SESSION['lock_4ever']) ){
                EnBacLib::set_cookie('lock_4ever',1);

                if($kick_out){
                    self::lock4Ever(true);
                }
                else{
                    $_SESSION['lock_4ever']=1;
                }
                return true;
            }
            return false;
        }
    }

    static function lock4Ever($kick_out=false,$user_id=false){
        EnBacLib::set_cookie('lock_4ever',1);
        User::LogOut();
        if($kick_out && $user_id){
            DB::delete(_SESS_TABLE,'user_id='.$user_id,__LINE__.__FILE__);
        }
        else{
            $_SESSION['lock_4ever']=1;
        }
    }

    static function getUser($user_id,$update_cache=false,$delcache=false){
        $user=array();
        if($user_id){
            if(MEMCACHE_ON){
                if($delcache){//Xoá cache
                    if(MEMCACHE_ON){
                        eb_memcache::do_remove("user:$user_id");
                    }
                    return true;
                }
                else{
                    if(!$update_cache && MEMCACHE_ON){
                        $user = eb_memcache::do_get("user:$user_id");
                    }
                    if(!$user){
                        $sql 	= "SELECT * FROM ".TABLE_ACCOUNT." WHERE id=".(int)$user_id." LIMIT 1";
                        $user 	= mysql_fetch_assoc(DB::query($sql));

                        if(!$user){
                            return;
                        }
                        $user['is_block'] = ($user['block_time']>TIME_NOW || $user['block_time']==-1)?true:false;
                        if(MEMCACHE_ON && $user){
                            eb_memcache::do_put("user:$user_id" , $user, 0);
                        }
                    }
                }
            }
            else{//cache file
                $subDir='user/'.floor($user_id/1000);
                $user = EBCache::cache('SELECT * FROM '.TABLE_ACCOUNT.' WHERE id='.(int)$user_id.' LIMIT 0,1',__LINE__.__FILE__,2592000,$update_cache,'',$subDir,$delcache);
                if($user&&!$delcache){
                    $user[0]['is_block'] = ($user[0]['block_time']>TIME_NOW || $user[0]['block_time']==-1)?true:false;
                    return $user[0];
                }
            }
        }
        return $user;
    }

    static function getByUserName($user_name,$update_cache=false,$delcache=false){
        $user=array();

        if($user_name){
            $user_id = 0;
            $user_id = ($user_id > 0) ? $user_id : (int)DB::get_one("SELECT id FROM ".TABLE_ACCOUNT." WHERE user_name='". addslashes((trim($user_name))) ."' LIMIT 1");
            if($user_id > 0) {
                $user = self::getUser($user_id, $update_cache, $delcache);
            }
        }
        return $user;
    }

    static function updateUserCache($user_id){
        if($user_id)
            $user = User::getUser($user_id,true);
        if(isset($user))
            return true;
        return false;
    }

    static function LogIn($user_or_id){
        if(is_array($user_or_id) && isset($user_or_id['id']))
            $user_id=(int)$user_or_id['id'];
        else
            $user_id = $user_or_id;
        $_SESSION['user_id']	= $user_id;

        if($user_id){
            DB::query("UPDATE account SET last_ip='".EnBacLib::ip()."' WHERE id=".$user_id,__LINE__.__FILE__);
            $user=User::getUser($user_id);
            if($user){
                User::$data=$user;
                $_SESSION['user_name']=$user['user_name'];
                return true;
            }
        }
        return false;
    }

    static function LogInAs($user_id){

    }

    static function LogOut(){
        if((int)$_SESSION['user_id']){
            DB::query("UPDATE ".TABLE_ACCOUNT." SET last_ip='".EnBacLib::ip()."' WHERE id=".(int)$_SESSION['user_id'],__LINE__.__FILE__);
        }

        $_SESSION['user_id']	=0;
        $_SESSION['user_name']  ='';

        if(isset($_SESSION['user_lock'])){
            $_SESSION['user_lock']=null;
            unset($_SESSION['user_lock']);
        }


        if(isset($_SESSION['openid_url'])){
            $_SESSION['openid_url']=null;
            unset($_SESSION['openid_url']);
        }

        if(isset($_SESSION['verify_close'])){
            $_SESSION['verify_close']=null;
            unset($_SESSION['verify_close']);
        }

        //Remove remember password cookies:
        if(isset($_COOKIE['user_cc'])){
            EnBacLib::set_cookie('user_cc',"",TIME_NOW-3600);
        }

        if(isset($_SESSION['id_login_as_user'])) {
            $tempId = $_SESSION['id_login_as_user'];
            unset($_SESSION['id_login_as_user']);
            unset($_SESSION['ary_saved_login_as_user']);
            self::LogIn($tempId);
        }
    }

    static function is_block(){
        return (isset($_SESSION['user_lock']) && $_SESSION['user_lock']);
    }

    static function is_login(){
        return (isset($_SESSION['user_id']) && $_SESSION['user_id']!=0);
    }

    static function check_cookie_login($user_id,$password){
        if((int)$user_id <= 0 || $password == '') return;

        $user_data=DB::fetch('SELECT id, user_name, password, block_time, gids FROM '.TABLE_ACCOUNT.' WHERE id='.(int)$user_id,false,false,__LINE__.__FILE__);

        if($user_data && $user_data['password'] == $password){
            if($user_data['block_time'] > TIME_NOW){//Nếu User bị khóa chưa hết hạn!
                EnBacLib::set_cookie('user_cc',"",TIME_NOW-3600);
                return;
            }
            else{
                //SoLib::Log_Daily_Active_User_Of_VCC($user_data['user_name']);

                User::Login($user_data);
                $url = (preg_match('#^/#', $_SERVER['REQUEST_URI'])) ? substr($_SERVER['REQUEST_URI'], 1) :  $_SERVER['REQUEST_URI'];
                header('Location:http://'.$_SERVER['HTTP_HOST'].'/'.$url);
            }
        }
        else{
            EnBacLib::set_cookie('user_cc',"",TIME_NOW-3600);
            return;
        }
    }

    static function encode_password($password){
        return md5($password.md5('_simlematdotcom'));
    }

    static function is_root(){//power admin
        return self::is_login()?(isset(self::$groups[PERMIT_ROOT])):false;
    }

    static function is_shop(){//power shop
        if(self::is_login()) {
            if(isset(self::$data)) {
                $user = self::$data;
                if(isset($user['is_shop']) && $user['is_shop'] == CGlobal::IS_SHOP){
                    return true;
                }
            }
        }
        return false;
    }

    static function is_manager(){//power admin
        return (self::is_admin() || self::is_root()) ? true : false;
    }

    static function is_admin(){
        if(self::is_login()) {
            if(isset(self::$groups[PERMIT_ADMIN]) || self::is_root()) {
                return true;
            }
        }
        return false;
    }

    //quyền sản phẩm
    static function is_manager_product(){
        if(self::is_login()) {
            if(isset(self::$groups[PERMIT_FULL_PRODUCTS]) || self::is_manager() || self::is_shop()) {
                return true;
            }
        }
        return false;
    }
    static function is_view_product(){
        if(self::is_login()) {
            if(isset(self::$groups[PERMIT_VIEW_PRODUCT]) || self::is_manager_product()) {
                return true;
            }
        }
        return false;
    }
    static function is_edit_product(){
        if(self::is_login()) {
            if(isset(self::$groups[PERMIT_EDIT_PRODUCT]) || self::is_manager_product()) {
                return true;
            }
        }
        return false;
    }
    static function is_delete_product(){
        if(self::is_login()) {
            if(isset(self::$groups[PERMIT_DELETE_PRODUCT]) || self::is_manager_product()) {
                return true;
            }
        }
        return false;
    }
    static function check_permit_product(){
        if(self::is_login()) {
            if(self::is_manager_product()) {
                return true;
            }
            if(self::is_view_product()) {
                return true;
            }
            if(self::is_edit_product()) {
                return true;
            }
            if(self::is_delete_product()) {
                return true;
            }
        }
        return false;
    }
    // end quyền sản phẩm

    static function is_manager_new(){
        if(self::is_login()) {
            if(isset(self::$groups[PERMIT_FULL_NEWS]) || self::is_manager()) {
                return true;
            }
        }
        return false;
    }
    static function is_sale(){
        if(self::is_login()) {
            if(isset(self::$groups[PERMIT_SALE]) || self::is_manager() || self::is_shop()) {
                return true;
            }
        }
        return false;
    }
    static function is_setup_permit(){
        if(self::is_login()) {
            if(isset(self::$groups[PERMIT_SETUP_PERMIT]) || self::is_root()) {
                return true;
            }
        }
        return false;
    }

    static function is_login_as(){
        return (isset($_SESSION['id_login_as_user']) && $_SESSION['id_login_as_user']!=0);
    }

    static function check_admin($gids){
        if($gids && $gids!='0'){
            if(preg_match("/([\D])9([\D])/i","|$gids|")) return 9;//Root
            elseif(preg_match("/([\D])1([\D])/i","|$gids|")) return 1;//Admin
            elseif(preg_match("/([\D])2([\D])/i","|$gids|")) return 2;//Mod
        }
        return 0;
    }

    static function get_groups($gids){
        $groups=array();
        if($gids){
            $gids_arr=explode(',',$gids);
            //lay danh sách quyền
            $arrPermit = array();
            foreach(CGlobal::$arrPermitAuthen as $k=>$val_per){
                foreach($val_per['group_permit'] as $k_per =>$name_per){
                    $arrPermit[$k_per] = $name_per;
                }
            }
            if($gids_arr){
                foreach ($gids_arr as $gid){
                    if(isset($arrPermit[$gid])){
                        $groups[$gid] = $arrPermit[$gid];
                    }
                }
            }
        }
        return $groups;
    }

    static function id(){
        return isset($_SESSION['user_id'])?(int)$_SESSION['user_id']:0;
    }

    static function user_name(){
        if(isset($_SESSION['user_id'])){
            if(isset($_SESSION['user_name'])&&$_SESSION['user_name']){
                return $_SESSION['user_name'];
            }
            elseif(isset(User::$data['user_name'])){
                return User::$data['user_name'];
            }
        }
        return '';
    }


    static function have_permit($pids, $cat_id = 0){
        //self::login_as_have_permit($pids);
        //die();
        $result = false;
        if(self::is_login()){

            //dungbt sua: chi co root moi co tat ca cac quyen
            if(self::is_root()){
                return true;
            }

            if(is_array($pids)){
                foreach ($pids as $pemiss){
                    if(self::have_permit($pemiss))
                        return true;
                }
                return false;
            }

            if(self::$groups){//Nếu đã phân nhóm
                self::get_permits();
                $result = self::$permits!='' && self::$permits!='0' && preg_match("/([\D])".$pids."([\D])/is",'|'.self::$permits.'|');
            }
        }

        return $result;
    }

    /**
     * phongct added - nếu ko có quyền với user hiện thời thì kiểm tra quyền với user login as xem có quyền ko?
     */
    static function login_as_have_permit($pids, $cat_id = 0){
        $result = false;

        $user_id 	= $_SESSION['id_login_as_user'];
        $user 		= $_SESSION['ary_saved_login_as_user'];

        //nếu là admin hoặc root thì ok
        if(isset($user['groups'][G_ROOT]) || isset($user['groups'][G_ADMIN])) return true;

        $gids = '';
        if($user['data']['gids']) {
            $gids = str_replace('|', ',', $user['data']['gids']);
        }
        if($gids != '') {
            $permits=EBCache::cache("SELECT type,ref_id,pids,cids FROM account_permit WHERE (ref_id IN(".$gids.") AND type=0) OR (ref_id=".$user_id." AND type=1)",__LINE__.__FILE__,36000,0,'','', false);
            $result = $permits!='' && $permits!='0' && preg_match("/([\D])".$pids."([\D])/is",'|'.$permits.'|');
        }

        return $result;
    }


    static function get_permits($del_cache=false,$user_id=false){
        static $get_permits=0;

        if($del_cache && $user_id>0 && $user_id!=self::id()){
            $user=self::getUser($user_id);
            if($user){
                $gids=str_replace('|',',',$user['gids']);
            }
            else{
                return false;
            }
        }
        elseif($del_cache || !$get_permits){
            $user_id=self::id();
            $gids	=str_replace('|',',',self::$data['gids']);
        }

        if($del_cache || !$get_permits){
            $permits=EBCache::cache("SELECT type,ref_id,pids,cids FROM account_permit WHERE (ref_id IN(".$gids.") AND type=0) OR (ref_id=".$user_id." AND type=1)",__LINE__.__FILE__,36000,0,'','',$del_cache);
        }

        if(!$get_permits && !$del_cache){
            if($permits){
                foreach ($permits as $permit){
                    if($permit['pids'])
                        self::$permits.=(self::$permits?'|':'').$permit['pids'];
                    if($permit['cids']){
                        $permit['cids']=str_replace(',','|',$permit['cids']);
                        self::$permit_cats.=(self::$permit_cats?'|':'').$permit['cids'];
                    }
                }
            }
            $get_permits=1;
        }
    }


    static function get_permits_by_id($user_id, $gids){

        $sql = "SELECT type,ref_id,pids,cids, cat_id, depart_id, cat_product_id FROM account_permit WHERE (ref_id IN(".$gids.") AND type=0) OR (ref_id=".$user_id." AND type=1)";

        $permits = DB::get_assoc($sql);

        $aryPermit = array();

        $aryPermit['pids'] = '';
        $aryPermit['cat_id'] = '';
        $aryPermit['depart_id'] = '';
        $aryPermit['cat_product_id'] = '';

        if($permits){
            foreach ($permits as $permit){

                if($permit['pids'])
                    $aryPermit['pids']  .= (!empty($aryPermit['pids']) ? '|' : '') . $permit['pids'];

                if($permit['cat_id'])
                    $aryPermit['cat_id']  .= (!empty($aryPermit['cat_id']) ? '|' : '') . $permit['cat_id'];

                if($permit['depart_id'])
                    $aryPermit['depart_id']  .= (!empty($aryPermit['depart_id']) ? '|' : '') . $permit['depart_id'];

                if($permit['cat_product_id'])
                    $aryPermit['cat_product_id']  .= (!empty($aryPermit['cat_product_id']) ? '|' : '') . $permit['cat_product_id'];
            }
        }

        return $aryPermit;

    }

    static function check_get_user(){
        if(Url::get('user_id')){
            if(self::is_login() && self::id()==Url::get('user_id')){
                CGlobal::$user_profile = self::$data;
            }
            else
                CGlobal::$user_profile = self::getUser(Url::get('user_id'));
        }

        if(!CGlobal::$user_profile && Url::get('user_name')){
            if(self::is_login() && self::user_name()==Url::get('user_name')){
                CGlobal::$user_profile = self::$data;
            }
            else{
                CGlobal::$user_profile = self::getByUserName(Url::get('user_name'));
            }
        }
        if(!CGlobal::$user_profile && Url::get('id')){
            if(self::is_login() && self::user_name()==Url::get('id')){
                CGlobal::$user_profile = self::$data;
            }
            else{
                CGlobal::$user_profile = self::getByUserName(Url::get('id'));
            }
        }

        if(!CGlobal::$user_profile && self::is_login() && in_array(EnBac::$page['name'],array('personal','message',))){
            CGlobal::$user_profile = self::$data;
        }

        if(!CGlobal::$user_profile){
            Url::access_denied();
        }
    }

    static function LoginByUserNameOrEmail($aryUserInfo = array()) {
        $user_name 	= (isset($aryUserInfo['user_name'])) ? $aryUserInfo['user_name'] : trim(EnBacLib::getParam('user'));
        $pass 		= (isset($aryUserInfo['password'])) ? $aryUserInfo['password'] : Url::get('pass');
        $aryLogin = array('current_user_name' => addslashes($user_name),);

        // check de ban IP
        $ip = EnBacLib::ip();
        $arr_badwords = EnBacLib::checkBadWord($ip,true);
        if($arr_badwords["bad"]!="" && $arr_badwords["bad_key"]!=""){
            $aryLogin['content'] = 'unsuccess';
            return "unsuccess";
        }
        // end check de ban IP

        if (strlen($user_name) <2  || strlen($user_name) >200  || !preg_match('#^[A-Za-z0-9_@.]*$#',$user_name) || strlen($pass)<6){
            $aryLogin['content'] = 'nodata';
            return 'nodata';
        }

        $user=str_replace(array('"','\\'),'_',$user_name);
        //login with user_name
        $user_data=DB::fetch('SELECT id,password,is_active,block_time FROM account WHERE user_name="'.$user.'"');

        //login with email
        if(!$user_data) {
            $user_data=DB::fetch('SELECT id,password,is_active,block_time FROM account WHERE email="'.$user.'"');
        }

        if(!USER_ACTIVE_ON  && $user_data && !$user_data['is_active']){
            DB::query("UPDATE account SET is_active=1 WHERE id=".$user_data['id']);
            DB::delete('account_active','user_id='.$user_data['id']);
            self::getUser($user_data['id'],0,1);
        }

        if($user_data['block_time']==-1){
            $aryLogin['content'] = 'unsuccess';
            return "unsuccess";
        }
        elseif($user_data && ($user_data['password'] == self::encode_password($pass))){
            if(USER_ACTIVE_ON && !$user_data['is_active']){//Chưa kích hoạt
                $aryLogin['content'] = 'un_active';
                return "un_active";
            }
            else{
                if($user_data['block_time'] > TIME_NOW || $user_data['block_time']==-1){//Bị khóa hoặc khóa vĩnh viễn
                    $alert='';
                    $acc_lock=DB::select('acc_lock','user_id='.$user_data['id'].' AND type IN(0,1,3) ORDER BY id DESC');
                    if($acc_lock){
                        if($acc_lock['type']==1){//Khoá vĩnh viễn
                            self::LogOut();
                            DB::delete(_SESS_TABLE,'user_id='.$user_id,__LINE__.__FILE__);
                            exit;
                        }
                        elseif($acc_lock['type']==3){//Khoá vĩnh viễn + cookie
                            User::lock4Ever(true,$user_data['id']);
                            exit;
                        }
                        else{
                            if($acc_lock['note'])
                                $acc_lock['note']="\n".'Lý do:"'.str_replace(array('"',"'"),'',$acc_lock['note']).'"';
                            $alert='Tài khoản của bạn đang tạm khoá tới '.date('h:i, d/m/Y',$user_data['block_time']).'!'.$acc_lock['note'];
                        }
                    }
                    $_SESSION['user_lock']=true;
                }

                if(Url::get('set_cookie')=='on'){

                    $user_tmp = array('id'=>$user_data['id'],'name'=>$user,'pass'=>$user_data['password']);

                    EnBacLib::set_cookie("user_cc", serialize($user_tmp), 60 * 60 * 24 * 365 + TIME_NOW);
                }

                $_SESSION['is_load_page_first'] = 1;// dung jQueryUI de load bang thong bao

                self::LogIn($user_data['id']);

                if(isset($_SESSION['user_lock']) && $_SESSION['user_lock']){
                    $aryLogin['content'] = $alert;
                    echo $alert;
                    exit;
                }
                else{
                    $aryLogin['content'] = 'success';
                    return 'success';
                }
            }
        }
        else{
            $aryLogin['content'] = 'unsuccess';
            return "unsuccess";
        }

        $aryLogin['content'] = 'unsuccess';
        return "unsuccess";
    }

    static function hash_gold($gold, $id = 0) {
        return md5($gold.'sl'.( ($id > 0) ? $id : self::id() ));
    }


    static function hash_valid_user($id , $email) {
        return md5($email.'sl'.$id).sha1(substr($email, 2,5).$id);
    }


    /**
     * update DB and memcache
     *
     * @param array $aryData
     * @param int $user_id | =0 ==> current user
     */
    static function updateUser($aryData, $user_id = 0) {
        $user_id = ($user_id == 0) ? self::id() : $user_id;
        DB::update_id('account', $aryData, $user_id);

        //update memcache
        if(MEMCACHE_ON){
            $user_memcache = eb_memcache::do_get("user:".$user_id);
            if($user_memcache){
                eb_memcache::do_put("user:".$user_id, $aryData + $user_memcache);
            }
        }
    }
}