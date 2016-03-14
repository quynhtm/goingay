<?php
/**
 * Created by PhpStorm.
 * User: QuynhTM
 * Date: 21/10/2015
 * Time: 9:39 AM
 */

class Product {
    static $table = TABLE_PRODUCT;
    static $primaryKey = 'id';

    public static function getProductById($id){
        $product = array();
        if(MEMCACHE_ON){
            $product =  Cache::do_get(Cache::CACHE_PRODUCT.$id);
            if($product == false){
                $product = DB::select(self::$table, self::$primaryKey.'='.$id);
                Cache::do_put(Cache::CACHE_PRODUCT.$id, $product, Cache::CACHE_TIME_TO_LIVE_ONE_WEEK);
            }
        }else{
            $product = DB::select(self::$table, self::$primaryKey.'='.$id);
        }
        return $product;
    }

    public static function checkProductActionById($id){
        $product = self::getProductById($id);
        if(!empty($product)){
            if(isset($product['status']) && $product['status'] == 0 ){
                return true;
            }
        }
        return false;
    }

    public static function getProductByCondition($getField = '*',$condition = '',$is_select = true){
        $condition = ($condition != '')? $condition : self::$primaryKey.' > 0';
        if($is_select){
            $query = DB::select(self::$table, $condition, $getField);
        }else{
            $query = DB::fetch_all('SELECT '.$getField.' FROM  ' . self::$table . ' WHERE ' . $condition);
        }
        return $query;
    }

    public static function updateProduct($arrUpdate,$condition){
        if(!empty($arrUpdate) && $condition != ''){
            return DB::update(self::$table, $arrUpdate, $condition);
        }
        return false;
    }

    public static function deleteItem($item){
        if(!empty($item)){
            DB::delete_id(self::$table, $item['id']);
            if (isset($item['images']) && $item['images'] != '') {
                SvImg::deleteImage($item['images'], CGlobal::$image_product, $item['id'], SvImg::FOLDER_PRODUCT,true, OPT_DELETE_IMAGE);
            }
            if(isset($item['images_other_temp']) && $item['images_other_temp'] != '') {
                $aryTempImages = unserialize($item['images_other_temp']);
                if(is_array($aryTempImages) && count($aryTempImages) > 0) {
                    foreach ($aryTempImages as $k2 => $v2) {
                        SvImg::deleteImage($v2, CGlobal::$image_product, $item['id'], SvImg::FOLDER_PRODUCT, OPT_DELETE_IMAGE);
                    }
                }
            }
        }
    }

    public static function deleteCacheProduct($id = 0 ){
        if($id > 0){
            Cache::do_remove(Cache::CACHE_PRODUCT.$id);
        }
        Cache::do_remove(Cache::CACHE_LIST_PRODUCT_HOME);
        Cache::do_remove(Cache::CACHE_LIST_PRODUCT_HOT);
    }
}