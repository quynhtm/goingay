<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Quynhtm
 */
class UserCustomer extends Eloquent
{
    protected $table = 'web_customer';
    protected $primaryKey = 'customer_id';
    public $timestamps = false;

    //cac truong trong DB
    protected $fillable = array('customer_id','customer_name','customer_email','customer_phone',
        'customer_address','customer_password','customer_province','customer_about','customer_status',
        'customer_up_item','customer_time_login','customer_time_logout','customer_time_created','customer_time_active',
        'is_customer','is_login','time_start_vip','time_end_vip');

    public static function getByID($id) {
        $data = (Memcache::CACHE_ON)? Cache::get(Memcache::CACHE_USER_SHOP_ID.$id) : array();
        if($id > 0){
            if (sizeof($data) == 0) {
                $data = UserCustomer::where('customer_id', $id)->first();
                if($data && Memcache::CACHE_ON){
                    Cache::put(Memcache::CACHE_USER_SHOP_ID.$id, $data, Memcache::CACHE_TIME_TO_LIVE_ONE_MONTH);
                }
            }
        }
        return $data;
    }

    public static function getShopAll() {
        $data = (Memcache::CACHE_ON)? Cache::get(Memcache::CACHE_ALL_USER_SHOP) : array();
        if (sizeof($data) == 0) {
            $customer = UserCustomer::where('customer_id', '>', 0)->where('customer_status', CGlobal::status_show)->get();
            foreach($customer as $itm) {
                $data[$itm['customer_id']] = $itm['customer_name'];
            }
            if(!empty($data) && Memcache::CACHE_ON){
                Cache::put(Memcache::CACHE_ALL_USER_SHOP, $data, Memcache::CACHE_TIME_TO_LIVE_ONE_MONTH);
            }
        }
        return $data;
    }

    public static function getCustomerByPhone($customer_phone){
        $customer = UserCustomer::where('customer_phone', $customer_phone)->first();
        return $customer;
    }
    public static function getUserCustomerByEmail($customer_email){
        $customer = UserCustomer::where('customer_email', $customer_email)->first();
        return $customer;
    }
    public static function isLogin(){
        $result = false;
        if (Session::has('user_customer')) {
            $result = true;
        }
        return $result;
    }
    public static function user_login(){
        $user_customer = array();
        if(Session::has('user_customer')){
            return $user_customer = Session::get('user_customer');
        }
        return $user_customer;
    }

    public static function updateLogin($customer = array()){
        if($customer){
            $customer->customer_time_login = time();
            $customer->save();
        }
    }

    //cap nhat nhung shop da het session
    public static function updateShopLogout(){
        $yesterday = time() - (60 * 60);
        $query = UserCustomer::where('customer_id','>',0)->where('is_login','=',1);
        $query->where('customer_time_login', '<=', $yesterday);
        $result = $query->get();
        if($result){
            foreach($result as $k =>$customer){
                $dataInput = array('is_login'=>0,'customer_time_logout'=>$customer->customer_time_logout);
                $customer->update($dataInput);
            }
        }
    }
    public static function searchByCondition($dataSearch = array(), $limit =0, $offset=0, &$total){
        try{
            $query = UserCustomer::where('customer_id','>',0);
            if (isset($dataSearch['customer_name']) && $dataSearch['customer_name'] != '') {
                $query->where('customer_name','LIKE', '%' . $dataSearch['customer_name'] . '%');
            }
            if (isset($dataSearch['customer_email']) && $dataSearch['customer_email'] != '') {
                $query->where('customer_email','LIKE', '%' . $dataSearch['customer_email'] . '%');
            }
            if (isset($dataSearch['customer_id']) && $dataSearch['customer_id'] > 0) {
                $query->where('customer_id', $dataSearch['customer_id']);
            }
            if (isset($dataSearch['customer_phone']) && $dataSearch['customer_phone'] > 0) {
                $query->where('customer_phone', $dataSearch['customer_phone']);
            }
            if (isset($dataSearch['customer_id']) && $dataSearch['customer_id'] > 0) {
                $query->where('customer_id', $dataSearch['customer_id']);
            }
            if (isset($dataSearch['customer_status']) && $dataSearch['customer_status'] > -1) {
                $query->where('customer_status', $dataSearch['customer_status']);
            }
            if (isset($dataSearch['is_customer']) && $dataSearch['is_customer'] > -1) {
                $query->where('is_customer', $dataSearch['is_customer']);
            }
            $total = $query->count();
            $query->orderBy('customer_time_login', 'desc')->orderBy('customer_time_logout', 'desc');

            //get field can lay du lieu
            $fields = (isset($dataSearch['field_get']) && trim($dataSearch['field_get']) != '') ? explode(',',trim($dataSearch['field_get'])): array();
            if(!empty($fields)){
                $result = $query->take($limit)->skip($offset)->get($fields);
            }else{
                $result = $query->take($limit)->skip($offset)->get();
            }
            return $result;

        }catch (PDOException $e){
            throw new PDOException();
        }
    }

    /**
     * @desc: Tao Data.
     * @param $data
     * @return bool
     * @throws PDOException
     */
    public static function addData($dataInput)
    {
        try {
            DB::connection()->getPdo()->beginTransaction();
            $data = new UserCustomer();
            if (is_array($dataInput) && count($dataInput) > 0) {
                foreach ($dataInput as $k => $v) {
                    $data->$k = $v;
                }
            }
            if ($data->save()) {
                DB::connection()->getPdo()->commit();
                if(isset($data->customer_id) && $data->customer_id > 0){
                    self::removeCache($data->customer_id);
                }
                return $data->customer_id;
            }
            DB::connection()->getPdo()->commit();
            return false;
        } catch (PDOException $e) {
            DB::connection()->getPdo()->rollBack();
            throw new PDOException();
        }
    }

    /**
     * @desc: Update du lieu
     * @param $id
     * @param $data
     * @return bool
     * @throws PDOException
     */
    public static  function updateData($id, $dataInput)
    {
        try {
            DB::connection()->getPdo()->beginTransaction();
            $dataSave = UserCustomer::find($id);
            if (!empty($dataInput)){
                $dataSave->update($dataInput);
            }
            DB::connection()->getPdo()->commit();
            if(isset($dataSave->customer_id) && $dataSave->customer_id > 0){
                self::removeCache($dataSave->customer_id);
            }
            return true;
        } catch (PDOException $e) {
            DB::connection()->getPdo()->rollBack();
            throw new PDOException();
        }
    }


    /**
     * @desc: Update Data.
     * @param $id
     * @param $status
     * @return bool
     * @throws PDOException
     */
    public static function deleteData($id){
        try {
            DB::connection()->getPdo()->beginTransaction();
            $dataSave = UserCustomer::find($id);
            $dataSave->delete();
            DB::connection()->getPdo()->commit();
            if(isset($dataSave->customer_id) && $dataSave->customer_id > 0){
                self::removeCache($dataSave->customer_id);
            }
            return true;
        } catch (PDOException $e) {
            DB::connection()->getPdo()->rollBack();
            throw new PDOException();
        }
    }

    /**
     * @param int $id
     */
    public static function removeCache($id = 0){
        if($id > 0){
            Cache::forget(Memcache::CACHE_USER_SHOP_ID.$id);
            Cache::forget(Memcache::CACHE_CATEGORY_SHOP_ID.$id);
        }
        Cache::forget(Memcache::CACHE_ALL_USER_SHOP);
    }
	
    //SITE: Duy add
    public static function encode_password($password){
    	return md5(md5($password));
    }
}