<?php

/**
 * 
 * * @author Quynh_Arsenal
 *
 */
class CopyForm extends Form {
	private $item = array();
    var $table_action = TABLE_PRODUCT;
	function CopyForm() {
		Form::Form('EditForm');
        $this->link_css('style/bootstrap/lib/datetimepicker_new/datetimepicker.css');
        $this->link_js('style/bootstrap/lib/datetimepicker_new/jquery.datetimepicker.js');
        $this->link_js('style/bootstrap/lib/dragsort/jquery.dragsort.js');
        $this->link_js('style/bootstrap/js/autoNumeric.js');
		include_once ROOT_PATH . 'includes/editor/ckeditor/ckeditor.php';

        $id = (int) Url::get('id',0);
        if ($id > 0) { //edit
            //lay SP nguoi tao san pham
            $condition = Product::$primaryKey.'='.$id;
            if(!User::is_root()){
                $condition .= ' and create_user_id = '. User::id() .' ';
            }
            $this->item = Product::getProductByCondition('*',$condition);
            //FunctionLib::debug($this->item);
            if (!$this->item)
                Url::redirect_current();
        }
	}

	function draw() {
		global $display;
		$this->beginForm(true);
        /*if ($_REQUEST['act']=='copy'){
            $id = EnBacLib::getParamInt('id', 0);
            if($id > 0) {
                $condition = Product::$primaryKey.'='.$id;
                if(!User::is_root()){
                    $condition .= ' and create_user_id = '. User::id() .' ';
                }
                $this->item = Product::getProductByCondition('*',$condition);
                if(empty($this->item)){
                    Url::redirect_current(array("act"=>"add"));
                }
            }
        }*/
		$display->add('mode', "Copy ");
		$display->add('msg', $this->showFormErrorMessages(1));
		$display->add('id', 0);

        //option status
        $arrStatus = array(2 => '-- Chọn Ẩn/hiện --', 1 => 'Hiện', 0 => "Ẩn");
        $optionStatus = EnbacLib::getOption($arrStatus, (isset($this->item ['status']) ? $this->item ['status'] : 0));
        $display->add('optionStatus', $optionStatus);

        //option nổi bật
        $arrHot = array(2 => '-- Chọn nổi bật --', 1 => 'Nổi bật', 0 => "Không");
        $optionHot = EnbacLib::getOption($arrHot, (isset($this->item ['hot']) ? $this->item ['hot'] : 0));
        $display->add('optionHot', $optionHot);

        //option danh mục
        $arrCategoryLists = getTreeCatAll();
        $arrListOption = array();
        $arrListOption[0] = '--- ROOT ---';
        foreach($arrCategoryLists as $arrCategoryList){
            $arrListOption[$arrCategoryList->id] = $arrCategoryList->textTitle;
        }
        $selected = isset($this->item ['category_id']) ? $this->item ['category_id'] : 0;
        $optionCategory = EnBacLib::getOption($arrListOption, $selected);
        $display->add('optionCategory', $optionCategory);

        //Miêu tả ngắn
        $editor_description_new = getEditor('description', Url::get('description', (isset($this->item ['description']) ? strip_tags($this->item ['description']) : '')),'99%','300px');
        $display->add('editor_description', $editor_description_new);

        //Noi dung tin bài
        $editor_content_new = getEditor('content', Url::get('content', (isset($this->item ['content']) ?str_replace('\"','"',$this->item ['content'])  : '')),'99%','700px');
        $display->add('editor_content', $editor_content_new);

        $display->add('item', $this->item);
        $display->add('page', Url::get('page'));
        $display->output('Copy'); // hien thi template
        $this->endForm();
    }

}

?>

