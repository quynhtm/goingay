<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Quynhtm
 */
class Hostting extends Eloquent
{
    protected $table = 'web_hostting';
    protected $primaryKey = 'web_id';
    public $timestamps = false;

    //cac truong trong DB
    protected $fillable = array('web_id','web_name', 'web_time_start','web_status','web_time_end'
    ,'web_note','web_domain','web_infor','web_price','web_is_hostting','web_is_return');

    public static function getByID($id) {
    	$result = (Memcache::CACHE_ON)? Cache::get(Memcache::CACHE_HOSTTING_ID.$id) : array();
    	if (sizeof($result) == 0) {
    		$result = Hostting::where('web_id','=', $id)->first();
    		if($result && Memcache::CACHE_ON){
    			Cache::put(Memcache::CACHE_HOSTTING_ID.$id, $result, Memcache::CACHE_TIME_TO_LIVE_ONE_MONTH);
    		}
    	}
    	return $result;
    }

    public static function searchByCondition($dataSearch = array(), $limit =0, $offset=0, &$total){
        try{
            $query = Hostting::where('web_id','>',0);
            if (isset($dataSearch['web_name']) && $dataSearch['web_name'] != '') {
                $query->where('web_name','LIKE', '%' . $dataSearch['web_name'] . '%');
            }
            if (isset($dataSearch['web_domain']) && $dataSearch['web_domain'] != '') {
                $query->where('web_domain','LIKE', '%' . $dataSearch['web_domain'] . '%');
            }
            if (isset($dataSearch['web_id']) && $dataSearch['web_id'] > 0) {
                $query->where('web_id', $dataSearch['web_id']);
            }
            if (isset($dataSearch['web_status']) && $dataSearch['web_status'] > -1) {
                $query->where('web_status', $dataSearch['web_status']);
            }
            if (isset($dataSearch['web_is_hostting']) && $dataSearch['web_is_hostting'] > -1) {
                $query->where('web_is_hostting', $dataSearch['web_is_hostting']);
            }
            if (isset($dataSearch['web_is_return']) && $dataSearch['web_is_return'] > -1) {
                $query->where('web_is_return', $dataSearch['web_is_return']);
            }

            //ngày b?t ??u
            if (isset($dataSearch['from_start_time']) && $dataSearch['from_start_time'] > 0) {
                $query->where('web_time_start','>=',$dataSearch['from_start_time']);
            }
            if (isset($dataSearch['to_start_time']) && $dataSearch['to_start_time'] > 0) {
                $query->where('web_time_start','<',$dataSearch['to_start_time']);
            }

            //ngày k?t thúc
            if (isset($dataSearch['from_end_time']) && $dataSearch['from_end_time'] > 0) {
                $query->where('web_time_end','>=',$dataSearch['from_end_time']);
            }
            if (isset($dataSearch['to_end_time']) && $dataSearch['to_end_time'] > 0) {
                $query->where('web_time_end','<',$dataSearch['to_end_time']);
            }

            $total = $query->count();
            $query->orderBy('web_id', 'desc');

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
            $data = new Hostting();
            if (is_array($dataInput) && count($dataInput) > 0) {
                foreach ($dataInput as $k => $v) {
                    $data->$k = $v;
                }
            }
            if ($data->save()) {
                DB::connection()->getPdo()->commit();
                if(isset($data->web_id) && $data->web_id > 0){
                    self::removeCache($data->web_id);
                }
                return $data->web_id;
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
            $dataSave = Hostting::find($id);
            if (!empty($dataInput)){
                $dataSave->update($dataInput);
            }
            DB::connection()->getPdo()->commit();
            if(isset($dataSave->web_id) && $dataSave->web_id > 0){
                self::removeCache($dataSave->web_id);
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
            $dataSave = Hostting::find($id);
            $dataSave->delete();
            DB::connection()->getPdo()->commit();
            if(isset($dataSave->web_id) && $dataSave->web_id > 0){
                self::removeCache($dataSave->web_id);
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
            Cache::forget(Memcache::CACHE_HOSTTING_ID.$id);
        }
    }

}