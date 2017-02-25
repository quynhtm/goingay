<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Quynhtm
 */
class Money extends Eloquent
{
    protected $table = 'web_money';
    protected $primaryKey = 'money_id';
    public $timestamps = false;

    //cac truong trong DB
    protected $fillable = array('money_id','money_name','money_id_first', 'money_price','money_total_price','money_type'
    ,'money_infor','money_time_creater','money_time_update','money_log');

    public static function searchByCondition($dataSearch = array(), $limit =0, $offset=0, &$total){
        try{
            $query = Money::where('money_id','>',0);
            if (isset($dataSearch['money_name']) && $dataSearch['money_name'] != '') {
                $query->where('money_name','LIKE', '%' . $dataSearch['money_name'] . '%');
            }

            //ngày k?t thúc
            if (isset($dataSearch['start_time']) && $dataSearch['start_time'] > 0) {
                $query->where('money_time_creater','>=',$dataSearch['start_time']);
            }
            if (isset($dataSearch['end_time']) && $dataSearch['end_time'] > 0) {
                $query->where('money_time_creater','<',$dataSearch['end_time']);
            }

            $total = $query->count();
            $query->orderBy('money_id', 'desc')->orderBy('money_time_creater', 'asc');

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

    public static function getItemFirst($money_id){
        if($money_id > 0){
            $result = Money::where('money_id','>',0)->where('money_id','<>',$money_id)->orderBy('money_id', 'desc')->first();
        }else{
            $result = Money::where('money_id','>',0)->orderBy('money_id', 'desc')->first();
        }

        return $result;
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
            $data = new Money();
            if (is_array($dataInput) && count($dataInput) > 0) {
                foreach ($dataInput as $k => $v) {
                    $data->$k = $v;
                }
            }
            if ($data->save()) {
                DB::connection()->getPdo()->commit();
                return $data->money_id;
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
            $dataSave = Money::find($id);
            if (!empty($dataInput)){
                $dataSave->update($dataInput);
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
            $dataSave = Money::find($id);
            $dataSave->delete();
            DB::connection()->getPdo()->commit();
            return true;
        } catch (PDOException $e) {
            DB::connection()->getPdo()->rollBack();
            throw new PDOException();
        }
    }
}