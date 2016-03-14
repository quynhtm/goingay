<?php
/**
 * Created by PhpStorm.
 * User: QuynhTM
 * Date: 21/10/2015
 * Time: 9:39 AM
 */

class Account {
    static $table = TABLE_ACCOUNT;
    static $primaryKey = 'id';

    public static function getAccountById($id){
        $account = array();
        if(MEMCACHE_ON){
            $account =  Cache::do_get(Cache::CACHE_ACCOUNT.$id);
            if($account == false){
                $account = DB::select(self::$table, self::$primaryKey.'='.$id);
                Cache::do_put(Cache::CACHE_ACCOUNT.$id, $account, Cache::CACHE_TIME_TO_LIVE_ONE_WEEK);
            }
        }else{
            $account = DB::select(self::$table, self::$primaryKey.'='.$id);
        }
        return $account;
    }

    public static function checkAccountActionById($id){
        $account = self::getAccountById($id);
        if(!$account){
            if(isset($account['status']) && $account['status'] == 0 ){
                return true;
            }
            if(isset($account['clock_user']) && $account['clock_user'] == 0 ){
                return true;
            }
        }
        return false;
    }

    public static function deleteCacheAccount($id){
        Cache::do_remove(Cache::CACHE_ACCOUNT.$id);
    }
}