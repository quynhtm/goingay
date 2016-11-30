<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Quynhtm
 */
class Items extends Eloquent
{
    protected $table = 'web_items';
    protected $primaryKey = 'item_id';
    public $timestamps = false;

    //cac truong trong DB
    protected $fillable = array('item_id','item_name', 'item_type_price', 'item_price_sell', 'item_area_price', 'item_content',
        'item_image', 'item_image_other', 'item_category_id','item_category_name','item_category_parent_id','item_category_parent_name',
        'item_number_view', 'item_status','item_is_hot','item_block','item_province_id','item_province_name',
        'item_district_id','item_district_name','customer_id','customer_name','is_customer',
        'time_ontop', 'time_created', 'time_update');

    /**
     * @param $item_id
     * @return array
     */
    public static function getItemsByID($item_id) {
        $item = (Memcache::CACHE_ON)? Cache::get(Memcache::CACHE_ITEM_ID.$item_id) : array();
        if (sizeof($item) == 0) {
            $item = Items::where('item_id', $item_id)->first();
            if($item && Memcache::CACHE_ON){
                Cache::put(Memcache::CACHE_ITEM_ID.$item_id, $item, Memcache::CACHE_TIME_TO_LIVE_ONE_MONTH);
            }
        }
        return $item;
    }

    public static function getItemByCustomerId($customer_id,$item_id) {
        if($item_id > 0){
            $item = Items::getItemsByID($item_id);
            if (sizeof($item) > 0) {
                if(isset($item->customer_id) && (int)$item->customer_id == $customer_id){
                    return $item;
                }
            }
        }
        return array();
    }

    public static function getListItemsOfCustomerId($customer_id = 0, $field_get = array()) {
        if($customer_id > 0){
            $query = Items::where('customer_id','=',$customer_id);
            return $result = (!empty($field_get)) ? $query->get($field_get) : $query->get();
        }
        return array();
    }

    public static function searchByCondition($dataSearch = array(), $limit =0, $offset=0, &$total){
        try{
            $query = Items::where('item_id','>',0);
            if (isset($dataSearch['item_name']) && $dataSearch['item_name'] != '') {
                $query->where('item_name','LIKE', '%' . $dataSearch['item_name'] . '%');
            }

            if (isset($dataSearch['item_block']) && $dataSearch['item_block'] != -1) {
                $query->where('item_block', $dataSearch['item_block']);
            }
            if (isset($dataSearch['item_status']) && $dataSearch['item_status'] != -1) {
                $query->where('item_status', $dataSearch['item_status']);
            }
            if (isset($dataSearch['item_category_id']) && $dataSearch['item_category_id'] != -1) {
                $query->where('item_category_id', $dataSearch['item_category_id']);
            }
            if (isset($dataSearch['item_category_parent_id']) && $dataSearch['item_category_parent_id'] != -1) {
                $query->where('item_category_parent_id', $dataSearch['item_category_parent_id']);
            }
            if (isset($dataSearch['item_province_id']) && $dataSearch['item_province_id'] != -1) {
                $query->where('item_province_id', $dataSearch['item_province_id']);
            }
            if (isset($dataSearch['customer_id']) && $dataSearch['customer_id'] != -1) {
                $query->where('customer_id', $dataSearch['customer_id']);
            }

            if (isset($dataSearch['item_id'])) {
                if (is_array($dataSearch['item_id'])) {
                    $query->whereIn('item_id', $dataSearch['item_id']);
                }
                elseif ((int)$dataSearch['item_id'] > 0) {
                    $query->where('item_id','=', (int)$dataSearch['item_id']);
                }
            }

            if (isset($dataSearch['item_is_hot']) && $dataSearch['item_is_hot'] > 0) {
                $query->where('item_is_hot', $dataSearch['item_is_hot']);
            }
            //lay theo id SP truyen vào và sap xep theo vi tri đã truyề vào
            if(isset($dataSearch['str_item_id']) && $dataSearch['str_item_id'] != ''){
                $arrItemsId = explode(',', trim($dataSearch['str_item_id']));
                $query->whereIn('item_id', $arrItemsId);
                $query->orderByRaw(DB::raw("FIELD(item_id, ".trim($dataSearch['str_item_id'])." )"));

            }else{
                $query->orderBy('item_id', 'desc');
            }

            $total = $query->count();
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

    public static function getItemsSite($dataSearch = array(), $limit =0, $offset=0, &$total){
        try{
            $query = Items::where('item_id','>',0);
            $query->where('item_block', '=',CGlobal::ITEMS_NOT_BLOCK);
            $query->where('item_status', '=',CGlobal::status_show);

            if (isset($dataSearch['item_name']) && $dataSearch['item_name'] != '') {
                $query->where('item_name','LIKE', '%' . $dataSearch['item_name'] . '%');
            }

            if (isset($dataSearch['item_category_id']) && $dataSearch['item_category_id'] != -1) {
                $query->where('item_category_id', $dataSearch['item_category_id']);
            }

            if (isset($dataSearch['item_province_id']) && $dataSearch['item_province_id'] != -1) {
                $query->where('item_province_id', $dataSearch['item_province_id']);
            }
            if (isset($dataSearch['item_district_id']) && $dataSearch['item_district_id'] != -1) {
                $query->where('item_district_id', $dataSearch['item_district_id']);
            }

            if (isset($dataSearch['customer_id']) && $dataSearch['customer_id'] != -1) {
                $query->where('customer_id', $dataSearch['customer_id']);
            }

            //tim tin đăng có ảnh đại dien
            if (isset($dataSearch['item_image']) && $dataSearch['item_image'] == 1) {
                $query->where('item_image', '!=','');
            }

            if (isset($dataSearch['item_id'])) {
                if (is_array($dataSearch['item_id'])) {
                    $query->whereIn('item_id', $dataSearch['item_id']);
                }
                elseif ((int)$dataSearch['item_id'] > 0) {
                    $query->where('item_id','=', (int)$dataSearch['item_id']);
                }
            }

            if (isset($dataSearch['item_is_hot']) && $dataSearch['item_is_hot'] > 0) {
                $query->where('item_is_hot', $dataSearch['item_is_hot']);
            }

            //lay theo id SP truyen vào và sap xep theo vi tri đã truyề vào
            if(isset($dataSearch['str_item_id']) && $dataSearch['str_item_id'] != ''){
                $arrItemsId = explode(',', trim($dataSearch['str_item_id']));
                $query->whereIn('item_id', $arrItemsId);
                $query->orderByRaw(DB::raw("FIELD(item_id, ".trim($dataSearch['str_item_id'])." )"));

            }else{
                $query->orderBy('is_customer', 'desc')->orderBy('time_ontop', 'desc')->orderBy('item_id', 'desc');
            }

            $total = $query->count();
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
            $data = new Items();
            if (is_array($dataInput) && count($dataInput) > 0) {
                foreach ($dataInput as $k => $v) {
                    $data->$k = $v;
                }
            }
            if ($data->save()) {
                DB::connection()->getPdo()->commit();
                if(isset($data->item_id) && $data->item_id > 0){
                    self::removeCache($data->item_id);
                }
                return $data->item_id;
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
            $dataSave = Items::getItemsByID($id);
            if (!empty($dataInput)){
                $dataSave->update($dataInput);
                if(isset($dataSave->item_id) && $dataSave->item_id > 0){
                    self::removeCache($dataSave->item_id);
                }
            }
            DB::connection()->getPdo()->commit();
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
            $dataSave = Items::find($id);
            $dataSave->delete();
            //xoa anh san pham
            if($dataSave->item_image_other != ''){
                $aryImages = unserialize($dataSave->item_image_other);
                if(sizeof($aryImages) > 0){
                    //xoa anh chinh
                    foreach($aryImages as $ki => $name_img){
                        FunctionLib::deleteFileUpload($name_img,$dataSave->item_id,CGlobal::FOLDER_PRODUCT);
                    }
                    //xoa anh thumb
                    $arrSizeThumb = CGlobal::$arrSizeImage;
                    foreach($aryImages as $kii => $name_img){
                        foreach($arrSizeThumb as $k=>$size){
                            $sizeThumb = $size['w'].'x'.$size['h'];
                            FunctionLib::deleteFileThumb($name_img,$dataSave->item_id,CGlobal::FOLDER_PRODUCT,$sizeThumb);
                        }
                    }
                }
            }
            if(isset($dataSave->item_id) && $dataSave->item_id > 0){
                self::removeCache($dataSave->item_id);
            }
            DB::connection()->getPdo()->commit();
            return true;
        } catch (PDOException $e) {
            DB::connection()->getPdo()->rollBack();
            throw new PDOException();
        }
    }

    public static function removeCache($id = 0){
        if($id > 0){
            Cache::forget(Memcache::CACHE_ITEM_ID.$id);
        }
    }
}