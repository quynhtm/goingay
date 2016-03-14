<?php

/**
 *
 * * @author Quynh_Arsenal
 *
 */
class AdminNews extends Module {
    var $table_action = TABLE_NEWS;
	function AdminNews($row) {
		Module::Module($row);
		$act = Url::get('act');
        if(User::is_manager() || User::is_manager_new()) {
            switch ($act) {
                //dùng cho xóa nhiều item cùng lúc
                case 'remove':
                    if (isset($_POST['selected_ids'])) {
                        $cid = $_POST['selected_ids'] ? $_POST['selected_ids'] : array();
                        if (!empty($cid)) {
                            $where = " WHERE id IN (".implode(',', $cid).")";
                            $aryAllNew = DB::fetch_all("SELECT images,id,images_other_temp FROM  " . $this->table_action . ' ' . $where);
                            $len = count($cid);
                            for ($i = 0; $i < $len; $i++) {
                                $aryNew = $aryAllNew[$cid[$i]];
                                if (!empty($aryNew)) {
                                    $this->deleteItem($aryNew);
                                }
                            }
                        }
                    }
                    Url::redirect_current();
                    break;
                //xóa từng 1 item
                case 'delete':
                    $id = (int) Url::get('id', 0);
                    if($id <= 0) break;
                    $aryAllNew = DB::fetch_all("SELECT images,id,images_other_temp FROM  " . $this->table_action . ' WHERE id=' . $id);
                    $aryNew = $aryAllNew[$id];
                    if (!empty($aryNew)) {
                        $this->deleteItem($aryNew);
                    }

                    Url::redirect_current();
                    break;
                case 'status':
                    $id = (int) Url::get('id', 0);
                    $status = (int) Url::get('status', 0);
                    if ($id) {
                        DB::update($this->table_action, array('status' => ($status == 1) ? 0 : 1), 'id=' . $id);
                        News::deleteCacheNews($id);
                    }
                    Url::redirect_current();
                    break;
                case 'publishAll':
                case 'unpublishAll':
                    if (isset($_POST['selected_ids'])) {
                        $cid = $_POST['selected_ids'] ? $_POST['selected_ids'] : array();
                        if (!empty($cid)) {
                            $value = ($act == 'publishAll') ? 1 : 0;
                            $len = count($cid);
                            for ($i = 0; $i < $len; $i++) {
                                DB::update($this->table_action, array('status' => $value), 'id=' . $cid[$i]);
                                News::deleteCacheNews($cid[$i]);
                            }
                        }
                    }
                    Url::redirect_current();
                    break;
                case 'edit':
                case 'add':
                    require_once 'forms/Edit.php';
                    $this->add_form(new EditForm());
                    break;
                case 'copy':
                    require_once 'forms/Copy.php';
                    $this->add_form(new CopyForm());
                    break;
                case 'apply':
                case 'save':
                    $this->saveItem();
                    break;
                default:
                    require_once 'forms/List.php';
                    $this->add_form(new ListForm());
                    break;
            }
        }else{
            Url::redirect('admin');
        }
	}

    function saveItem(){
        require_once ROOT_PATH.'core/lib/function.php';
        $new_row = array();
        $title_news = Url::tget('title_news');
        $content_new = Url::tget('content');
        $description_new = Url::tget('description_new');
        $cat_new_id = Url::tget('cat_new_id', 0);
        $status = Url::tget('status', 0);
        $order = Url::tget('order_news', 0);
        $hot_news = Url::tget('hot_news', 0);
        $start_time = Url::tget('start_time', 0);
        $end_time = Url::tget('end_time', 0);

        //ảnh chính
        $images = Url::tget('image_primary','');
        $new_row = array('name' => $title_news,
            'content' => str_replace('\"','"',$content_new),
            'description' => strip_tags($description_new),
            'cat_new_id' => $cat_new_id,
            'cat_news_name' => '',
            'status' => $status,
            'images' => $images,
            'order' => $order,
            'start_time' => strtotime($start_time),
            'end_time' => strtotime($end_time),
            'hot_news' => $hot_news);
        //them mới

        $id = (int) Url::get('id',0);
        if ($id == 0) {
            $new_row['create_time'] = TIME_NOW;
            $new_row['modify_time'] = TIME_NOW;
            $id = DB::insert($this->table_action, $new_row);
        } else {
            $new_row['modify_time'] = TIME_NOW;
        }

        //ảnh khác
        $arrInputImgOther = array();
        $getImgOther = Url::get('img_other',array());
        //SvLib::FunctionDebug($getImgOther);
        if(!empty($getImgOther)){
            foreach($getImgOther as $k=>$val){
                if($val !=''){
                    $arrInputImgOther[] = $val;
                }
            }
        }
        if (!empty($arrInputImgOther) && count($arrInputImgOther) > 0) {
            if($images == ''){
                $new_row['images'] = $arrInputImgOther[0];
            }
            $new_row['images_other'] = serialize($arrInputImgOther);
        }

        DB::update($this->table_action, $new_row, 'id=' . $id);
        News::deleteCacheNews($id);
        //SvLib::FunctionDebug($new_row);

        if(EnBacLib::getParam('act') == 'apply'){
            Url::redirect_current(array('act'=>'edit','id'=>$id));
        }
        else {
            Url::redirect_current();
        }
    }

    function deleteItem($item){
        if(!empty($item)){
            DB::delete_id($this->table_action, $item['id']);
            News::deleteCacheNews($item['id']);
            if ($item['images'] != '') {
                SvImg::deleteImage($item['images'], CGlobal::$image_news, $item['id'], SvImg::FOLDER_NEWS,true, OPT_DELETE_IMAGE);
            }
            if($item['images_other_temp'] != '') {
                $aryTempImages = unserialize($item['images_other_temp']);
                if(is_array($aryTempImages) && count($aryTempImages) > 0) {
                    foreach ($aryTempImages as $k2 => $v2) {
                        SvImg::deleteImage($v2, CGlobal::$image_news, $item['id'], SvImg::FOLDER_NEWS, OPT_DELETE_IMAGE);
                    }
                }
            }
        }
    }

}

?>