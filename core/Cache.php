<?php
/**
 * QuynhTM add
 */
require_once(ROOT_PATH ."phpfastcache-final/phpfastcache.php");
class Cache {
    const CACHE_TIME_TO_LIVE_15 = 900; //Time cache 15 phut
    const CACHE_TIME_TO_LIVE_ONE_DAY = 86400; //Time cache 1 ngay
    const CACHE_TIME_TO_LIVE_ONE_WEEK = 604800; //Time cache 1 tuan
    const CACHE_TIME_TO_LIVE_30 = 1800; //Time cache 30 phut
    const CACHE_TIME_TO_LIVE_60 = 3600; //Time cache 60 phut

    //Dang dùng các cache này
    const CACHE_ACCOUNT = 'cache_account_id_';
    const CACHE_NEWS = 'cache_news_id_';
    const CACHE_PRODUCT = 'cache_product_id_';


    const CACHE_MENU_HOME_LEFT = 'cache_menu_home_left';
    const CACHE_LIST_PRODUCT_HOME = 'cache_list_product_home';
    const CACHE_LIST_PRODUCT_HOT = 'cache_list_product_hot';
    const CACHE_LIST_NEW_HOME = 'cache_list_new_home';
    const CACHE_LIST_NEW_GROUP = 'cache_list_new_group';

	static function do_put( $key, $value, $time = 0 ){
        //if $time = 0: mac dinh la 5nam (^_^)
        $cache = phpFastCache();
        return $cache->set($key,$value,$time);
    }
	static function do_get( $key ){
        $cache = phpFastCache();
        return $cache->get($key);
    }
	static function do_remove( $key ){
        $cache = phpFastCache();
        return $cache->delete($key);
    }

    //static function Cache(){}
    static function connect(){ }
    static function disconnect(){}
    static function stats(){}
	static function clear(){}
    static function encode($data){}
    static function decode($data){}
}