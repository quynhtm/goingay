<?php
/**
 * Created by PhpStorm.
 * User: QuynhTM
 * Date: 21/10/2015
 * Time: 9:39 AM
 */

class News {
    static $table = TABLE_NEWS;
    static $primaryKey = 'id';

    public static function getNewsById($id){
        $news = array();
        if(MEMCACHE_ON){
            $news =  Cache::do_get(Cache::CACHE_NEWS.$id);
            if($news == false){
                $news = DB::select(self::$table, self::$primaryKey.'='.$id);
                Cache::do_put(Cache::CACHE_NEWS.$id, $news, Cache::CACHE_TIME_TO_LIVE_ONE_WEEK);
            }
        }else{
            $news = DB::select(self::$table, self::$primaryKey.'='.$id);
        }
        return $news;
    }

    public static function checkNewsActionById($id){
        $news = self::getNewsById($id);
        if(!empty($news)){
            if(isset($news['status']) && $news['status'] == 0 ){
                return true;
            }
        }
        return false;
    }

    public static function deleteCacheNews($id){
        Cache::do_remove(Cache::CACHE_NEWS.$id);
    }
}