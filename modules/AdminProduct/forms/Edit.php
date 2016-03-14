<?php

/**
 * 
 * * @author Quynh_Arsenal
 *
 */
class EditForm extends Form {
	private $item = array();
	function EditForm() {
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
		if (Url::get('act') == 'edit')
			$display->add('mode', "Sửa ");
		else
			$display->add('mode', "Thêm ");
		$display->add('msg', $this->showFormErrorMessages(1)); //thong bao loi khi co

		$id = (int) Url::get('id', 0);
		$display->add('id', $id);

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

		//list ảnh khác
		if (isset($this->item ['images_other']) && $this->item ['images_other'] != '') {
			$tempImagesOther = unserialize($this->item ['images_other']);
			$arrImagesOther = array();
			if (count($tempImagesOther) and ($tempImagesOther)) {
				foreach ($tempImagesOther as $key => $value) {
                    $tmpImg['name_img'] = $value;
                    $tmpImg['id_key'] = $key;
                    //dung de chen vao content
                    $tmpImg['src_700'] = SvImg::getThumbImage($value,$this->item ['id'],SvImg::FOLDER_PRODUCT);
                    $tmpImg['src_80'] = $tmpImg['src'] = SvImg::getThumbImage($value,$this->item ['id'],SvImg::FOLDER_PRODUCT,80,80);;
                    $arrImagesOther[] = $tmpImg;
				}
			}
			$display->add('images_other', $arrImagesOther);
		}

        //FunctionLib::debug($this->item);
		$display->add('item', $this->item);
		$display->add('page', Url::get('page'));
		$display->output('Edit'); // hien thi template
		$this->endForm();
	}

}

?>