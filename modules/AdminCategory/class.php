<?php

/**
 *
 * * @author Quynh_Arsenal
 *
 */
require_once ROOT_PATH.'core/lib/function.php';
class AdminCategory extends Module {
    var $table_action = TABLE_CATEGORY;
	function AdminCategory($row) {
		Module::Module($row);
		$act = Url::get('act');
        if(User::is_root()) {
            switch ($act) {
                case 'status':
                    $id = (int)Url::get('id', 0);
                    $status = (int)Url::get('status', 0);
                    if ($id) {
                        DB::update($this->table_action, array('status' => ($status == 1) ? 0 : 1), 'id=' . $id);
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
                    $this->saveCategory();
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

    function saveCategory(){
        $msg = '';
        $edit = false;
        $id = EnBacLib::getParamInt('id',0);
        $data = array();
        $data["name"] = EnBacLib::getParam('name');
        $data["linkview"] = EnBacLib::getParam('linkview');
        $data["parent_id"] = EnBacLib::getParamInt('parent_id',0);
        $data["description"] = Url::get('description','');
        $data["status"] = EnBacLib::getParamInt('status');
        $data["type"] = EnBacLib::getParamInt('type');
        $data["order"] = EnBacLib::getParamInt('order');
        // Fix up to parent Id
        if($id){
            $edit=true;
            //Get All Children of id
            $query = 'SELECT a.*  FROM '.TABLE_CATEGORY.' AS a  ORDER BY a.`order`';
            $query_id = DB::query($query);
            $pcatrows = loadObjectList($query_id);
            $arrTreeCats = array();
            foreach($pcatrows as $pcatrow) {
                $pcatrow->textTitle = addTextChildCat($pcatrow->name,$pcatrow->level);
                $arrTreeCats[$pcatrow->parent_id][] = $pcatrow->id;
            }
            $arrChildCatId = array();
            getTreeCat($id, $arrChildCatId, $arrTreeCats);
            // get Old level
            $query = 'SELECT a.level FROM '.TABLE_CATEGORY.' AS a WHERE a.id='.$id .' ORDER BY a.`order`' ;
            $oldLevel = DB::get_one($query);
        }
        //fix up value for Level
        if($data["parent_id"]){
            $query = 'SELECT a.level  FROM '.TABLE_CATEGORY.' AS a  WHERE a.id='.$data["parent_id"] . ' ORDER BY a.`order`';
            $data['level'] = DB::get_one($query) + 1;
        }
        else {
            $data['level'] = 1;
        }
        //Fix up value for Level When Edit
        if($id){
            if(count($arrChildCatId) > 0){
                for($i = 0, $count_n=count($arrChildCatId); $i < $count_n; $i++){
                    if($i!=0) {
                        $query = 'SELECT a.level  FROM '.TABLE_CATEGORY.' AS a  WHERE a.id='.$arrChildCatId[$i] . ' ORDER BY a.`order`';
                        $level = DB::get_one($query);
                        $level = $level+($data['level'] - $oldLevel);
                        DB::update(TABLE_CATEGORY, array('level'=>$level),'id = '.$arrChildCatId[$i]);
                    }
                }
            }
        }
        //Insert Category
        $imageInfor = array();
        $dataUpdate = array();
        if(!$edit){
            $data["date"] = TIME_NOW;
            $data["create_user_id"] = User::id();
            if($id = DB::insert(TABLE_CATEGORY, $data)){
                $msg='<strong style="color:#0000FF;font-size:14px;">Thêm danh mục thành công </strong>';
            }
        }
        else {
            $dataUpdate = $data;
            $imageInfor = DB::get_row("SELECT date,images FROM ".TABLE_CATEGORY." WHERE id=".$id);
        }

        if(!empty($dataUpdate)){
            $dataUpdate['update_date'] = TIME_NOW;
            $dataUpdate['update_user_id'] = User::id();
            if(DB::update(TABLE_CATEGORY, $dataUpdate,'id = '.$id)){
                if($msg==''){
                    $msg='<strong style="color:#0000FF;font-size:14px;">Sửa danh mục thành công </strong>';
                }
            }
        }
        if(EnBacLib::getParam('act') == 'apply'){
            Url::redirect_current(array('act'=>'edit','id'=>$id),'',$msg);
        }
        else {
            Url::redirect_current(array(),'',$msg);
        }
    }

}

?>