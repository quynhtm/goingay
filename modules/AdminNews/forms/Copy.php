<?php

/**
 * 
 * * @author Quynh_Arsenal
 *
 */
class CopyForm extends Form {
	private $pages = array();
	function CopyForm() {
		Form::Form('EditForm');

        $this->link_css('style/bootstrap/lib/datetimepicker_new/datetimepicker.css');
        $this->link_js('style/bootstrap/lib/datetimepicker_new/jquery.datetimepicker.js');
        $this->link_js('style/bootstrap/lib/dragsort/jquery.dragsort.js');
		include_once ROOT_PATH . 'includes/editor/ckeditor/ckeditor.php';
	}

	function draw() {
		global $display;
		$this->beginForm(true);
        if ($_REQUEST['act']=='copy'){
            $id = EnBacLib::getParamInt('id', 0);
            if($id > 0) {
				$this->pages = News::getNewsById($id);
                if(empty($this->pages)){
                    Url::redirect_current(array("act"=>"add"));
                }
            }
        }
		$display->add('mode', "Copy ");
		$display->add('msg', $this->showFormErrorMessages(1));
		$display->add('id', 0);

		//option status
		$arrStatus = array(2 => '-- Chọn Ẩn/hiện --', 1 => 'Hiện', 0 => "Ẩn");
		$optionStatus = EnbacLib::getOption($arrStatus, (isset($this->pages ['status']) ? $this->pages ['status'] : 2));
		$display->add('optionStatus', $optionStatus);

		//option status
		$arrHot = array(1 => 'Có', 0 => "Không");
		$optionHot = EnbacLib::getOption($arrHot, (isset($this->pages ['hot_news']) ? $this->pages ['hot_news'] : 0));
		$display->add('optionHot', $optionHot);

		//option loại tin
		$optionTypeNew = EnbacLib::getOption( array(0=>'----Chọn mục tin----')+CGlobal::$arrCatgoryNew, (isset($this->pages ['cat_new_id']) ? $this->pages ['cat_new_id'] : CGlobal::TIN_TUC_CHUNG));
		$display->add('optionTypeNew', $optionTypeNew);

		//Miêu tả ngắn
		$editor_description_new = getEditor('description_new', Url::get('description_new', (isset($this->pages ['description']) ? strip_tags($this->pages ['description']) : '')),'99%','300px');
		$display->add('editor_description_new', $editor_description_new);

		//Noi dung tin bài
		$editor_content_new = getEditor('content', Url::get('content', (isset($this->pages ['content']) ?str_replace('\"','"',$this->pages ['content'])  : '')),'99%','700px');
		$display->add('editor_content_new', $editor_content_new);

        $display->add('image_primary', $this->pages ['images']);
        $display->add('title_news', Url::get('title_news', $this->pages ['name']));
        $display->add('order_news', Url::get('order_news', $this->pages ['order']));
        $display->add('start_time', Url::get('start_time', ($this->pages ['start_time'] > 0) ? date('d-m-Y H:i', $this->pages ['start_time']) : '' ));
        $display->add('end_time', Url::get('end_time', ($this->pages ['end_time'] > 0) ? date('d-m-Y H:i', $this->pages ['end_time']) : '' ));
		$display->add('page', Url::get('page'));

		$display->output('Copy'); // hien thi template
		$this->endForm();
	}

}

?>