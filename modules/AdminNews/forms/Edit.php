<?php

/**
 * 
 * * @author Quynh_Arsenal
 *
 */
class EditForm extends Form {

	private $pages = array();
	function EditForm() {
		Form::Form('EditForm');

        $this->link_css('style/bootstrap/lib/datetimepicker_new/datetimepicker.css');
        $this->link_js('style/bootstrap/lib/datetimepicker_new/jquery.datetimepicker.js');
        $this->link_js('style/bootstrap/lib/dragsort/jquery.dragsort.js');

        $id = (int) Url::get('id',0);
		if ($id > 0) { //edit
			$this->pages = News::getNewsById($id);
			if (!$this->pages)
				Url::redirect_current();
		}
		include_once ROOT_PATH . 'includes/editor/ckeditor/ckeditor.php';
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
		$optionStatus = EnbacLib::getOption($arrStatus, (isset($this->pages ['status']) ? $this->pages ['status'] : 2));
		$display->add('optionStatus', $optionStatus);

		//option status
		$arrHot = array(1 => 'Có', 0 => "Không");
		$optionHot = EnbacLib::getOption($arrHot, (isset($this->pages ['hot_news']) ? $this->pages ['hot_news'] : 0));
		$display->add('optionHot', $optionHot);

		//option loại tin
		require_once ROOT_PATH . 'core/lib/function.php';
		//$menu = buildMenuHeader();
		$optionTypeNew = EnbacLib::getOption( array(0=>'----Chọn mục tin----')+CGlobal::$arrCatgoryNew, (isset($this->pages ['cat_new_id']) ? $this->pages ['cat_new_id'] : CGlobal::TIN_TUC_CHUNG));
		$display->add('optionTypeNew', $optionTypeNew);

		//Miêu tả ngắn
		$editor_description_new = getEditor('description_new', Url::get('description_new', (isset($this->pages ['description']) ? strip_tags($this->pages ['description']) : '')),'99%','300px');
		$display->add('editor_description_new', $editor_description_new);

		//Noi dung tin bài
		$editor_content_new = getEditor('content', Url::get('content', (isset($this->pages ['content']) ?str_replace('\"','"',$this->pages ['content'])  : '')),'99%','700px');
		$display->add('editor_content_new', $editor_content_new);

		//list ảnh khác của tin tưc
		if (isset($this->pages ['images_other']) && $this->pages ['images_other'] != '') {
			$tempImagesOther = unserialize($this->pages ['images_other']);
			$arrImagesOther = array();
			if (count($tempImagesOther) and ($tempImagesOther)) {
				foreach ($tempImagesOther as $key => $value) {
                    $tmpImg['name_img'] = $value;
                    $tmpImg['id_key'] = $key;

                    //dung de chen vao content
                    /*$tmpImg['src_700'] = SvImg::getImageBySize($value, CGlobal::size_image_700, $this->pages ['id'], SvImg::FOLDER_NEWS, OPT_GET_IMAGE);
                    $tmpImg['src_80'] = $tmpImg['src'] = SvImg::getImageBySize($value, CGlobal::size_image_80, $this->pages ['id'], SvImg::FOLDER_NEWS, OPT_GET_IMAGE);*/

                    $tmpImg['src_700'] = SvImg::getThumbImage($value,$this->pages ['id'],SvImg::FOLDER_NEWS);
                    $tmpImg['src_80'] = $tmpImg['src'] = SvImg::getThumbImage($value,$this->pages ['id'],SvImg::FOLDER_NEWS,80,80);;
                    $arrImagesOther[] = $tmpImg;
				}
			}
			$display->add('images_other', $arrImagesOther);
		}

		if (Url::get('act') == 'edit') {
            $display->add('image_primary', $this->pages ['images']);
			$display->add('title_news', Url::get('title_news', $this->pages ['name']));
			$display->add('order_news', Url::get('order_news', $this->pages ['order']));
			$display->add('start_time', Url::get('start_time', ($this->pages ['start_time'] > 0) ? date('d-m-Y H:i', $this->pages ['start_time']) : '' ));
			$display->add('end_time', Url::get('end_time', ($this->pages ['end_time'] > 0) ? date('d-m-Y H:i', $this->pages ['end_time']) : '' ));
		}
		$display->add('page', Url::get('page'));
		$display->output('Edit'); // hien thi template
		$this->endForm();
	}

}

?>