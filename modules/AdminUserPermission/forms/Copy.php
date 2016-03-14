<?php

/**
 * 
 * * @author Quynh_Arsenal
 *
 */
class CopyForm extends Form {
	private $pages = array();
    var $table_action = TABLE_ACCOUNT;
	function CopyForm() {
		Form::Form('EditForm');
        $this->link_css('style/bootstrap/lib/datetimepicker_new/datetimepicker.css');
        $this->link_js('style/bootstrap/lib/datetimepicker_new/jquery.datetimepicker.js');
        $this->link_js('style/bootstrap/lib/dragsort/jquery.dragsort.js');
        $this->link_js('style/bootstrap/js/autoNumeric.js');
		include_once ROOT_PATH . 'includes/editor/ckeditor/ckeditor.php';
	}

	function draw() {
		global $display;
		$this->beginForm(true);
        if ($_REQUEST['act']=='copy'){
            $id = EnBacLib::getParamInt('id', 0);
            if($id > 0) {
                $query = 'SELECT * FROM '.$this->table_action.' WHERE id='.$id;
                $this->pages = DB::get_row($query);
                if(empty($this->pages)){
                    Url::redirect_current(array("act"=>"add"));
                }
            }
        }
		$display->add('mode', "Copy ");
		$display->add('msg', $this->showFormErrorMessages(1));
		$display->add('id', 0);

        //arr quyền
        $arrPermit = CGlobal::$arrPermit;
        $display->add('arrPermit', $arrPermit);
        $display->add('arr_permit_user',isset($this->pages ['permit_action'])? explode(',',$this->pages ['permit_action']): array());
        $display->add('user_name', $this->pages ['user_name'].'_copy');
        $display->add('full_name', $this->pages ['full_name']);
        $display->add('email', $this->pages ['email']);
        $display->add('mobile_phone', $this->pages ['mobile_phone']);
        $display->add('address', $this->pages ['address']);

        $display->add('page', Url::get('page'));
		$display->output('Copy'); // hien thi template
		$this->endForm();
	}

}

?>