<?php

/**
 * 
 * * @author Quynh_Arsenal
 *
 */
class EditForm extends Form {
    var $table_action = TABLE_CATEGORY;
	private $pages = array();
	function EditForm() {
		Form::Form('EditForm');
        $this->link_css('style/bootstrap/lib/datetimepicker_new/datetimepicker.css');
        $this->link_js('style/bootstrap/lib/datetimepicker_new/jquery.datetimepicker.js');
        $this->link_js('style/bootstrap/lib/dragsort/jquery.dragsort.js');
        $this->link_js('style/bootstrap/js/autoNumeric.js');

        $id = (int) Url::get('id',0);
		if ($id > 0) { //edit
            //lay SP nguoi tao san pham
            $condition = 'id ='.$id;
			$this->pages = DB::select($this->table_action, $condition);
			if (!$this->pages)
				Url::redirect_current();
		}
		include_once ROOT_PATH . 'includes/editor/ckeditor/ckeditor.php';
        require_once ROOT_PATH.'core/lib/arrayhelper.php';
	}

	function draw() {
        global $display;
        $this->beginForm('true');
        if ($_REQUEST['act'] == 'edit'){
            if(EnBacLib::getParamInt('id',0)) {
                $cid[0] = EnBacLib::getParamInt('id');
            }
            else{
                if(isset($_POST['selected_ids'])){
                    $cid = $_POST['selected_ids'] ? $_POST['selected_ids'] : '0';
                }
            }
            ArrayHelper::toInteger($cid, 0);
            if($cid[0]){
                $query = 'SELECT a.*  FROM '.TABLE_CATEGORY.' AS a  WHERE a.id='.$cid[0]. ' ORDER BY a.`order`';
                $row = DB::fetch($query);
            }
        }
        $arrCategoryLists = getTreeCatAll();
        $arrListOption = array();
        $arrListOption[0]='--- ROOT ---';
        foreach($arrCategoryLists as $arrCategoryList){
            $arrListOption[$arrCategoryList->id]=$arrCategoryList->textTitle;
        }
        $selected = isset($row['parent_id'])?$row['parent_id']:0;
        if(isset($row)){
            //Get All Children of id
            $query = 'SELECT a.*  FROM '.TABLE_CATEGORY.' AS a ORDER BY a.`order`';
            $query_id = DB::query($query);
            $pcatrows = loadObjectList($query_id);
            $arrTreeCats = array();
            foreach($pcatrows as $pcatrow) {
                $arrTreeCats[$pcatrow->parent_id][] = $pcatrow->id;
            }
            $arrChildCatId = array();
            getTreeCat($row['id'],$arrChildCatId,$arrTreeCats);
            $input='';
            if ($arrListOption){
                foreach($arrListOption as $key=>$text){
                    $input .= '<option value="'.$key.'"';
                    if(in_array($key,$arrChildCatId)){
                        $input .=  ' disabled="disabled"';
                    }
                    if($key === '' && $selected === '') {
                        $input .=  ' selected';
                    }
                    else if( $selected !== '' && $key == $selected ) {
                        $input .=  ' selected';
                    }
                    $input .= '>'.$text.'</option>';
                }
                $lists['option_cat']=$input;
            }
        }
        else {
            $lists['option_cat'] = EnBacLib::getOption($arrListOption, $selected);
        }

        $selected = isset($row['status']) ? $row['status'] : '1';
        $lists['option_status']= EnBacLib::getOption(array('1'=>'Hiện','0'=>'Ẩn'), $selected);
        $lists['description'] = isset($row['description'])?$row['description']:'';
        $lists['name'] = isset($row['name'])?$row['name']:'';
        $lists['linkview'] = isset($row['linkview'])? $row['linkview']:'';
        $lists['id'] = isset($row['id'])?$row['id']:'';
        $lists['row'] = isset($row)?$row:'';
        $lists['editor']= getEditor('description',$lists['description']);

        $display->add('mode', (Url::get('act')=='edit') ? "Sửa" : "Thêm");
        $display->add('page',$_REQUEST['page']);
        $display->add('msg', Url::getMsg());

        $display->add('lists',$lists);
		$display->add('page', Url::get('page'));
		$display->output('Edit'); // hien thi template
		$this->endForm();
	}

}

?>