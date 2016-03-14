<?php

/**
 * 
 * * @author Quynh_Arsenal
 *
 */
class EditForm extends Form {
    var $table_action = TABLE_ACCOUNT;
	private $pages = array();
	function EditForm() {
		Form::Form('EditForm');
        $this->link_css('style/bootstrap/lib/datetimepicker_new/datetimepicker.css');
        $this->link_js('style/bootstrap/lib/datetimepicker_new/jquery.datetimepicker.js');

        $id = (int) Url::get('id',0);
        $id_online = (int)User::$data['id'];
        if($id === $id_online || User::is_root()){
            if ($id > 0) { //edit
                $this->pages = DB::select($this->table_action, 'id=' . $id);
                if (!$this->pages)
                    Url::redirect_current();
            }
        }
		else{
            Url::redirect('admin');
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

        //arr quyền
        $arrPermit = CGlobal::$arrPermit;
        $display->add('arrPermit', $arrPermit);
        $display->add('arr_permit_user',isset($this->pages ['permit_action'])? explode(',',$this->pages ['permit_action']): array());

		if (Url::get('act') == 'edit') {
			$display->add('user_name', $this->pages ['user_name']);
			$display->add('full_name', $this->pages ['full_name']);
			//$display->add('password', $this->pages ['password']);
			$display->add('email', $this->pages ['email']);
			$display->add('mobile_phone', $this->pages ['mobile_phone']);
			$display->add('address', $this->pages ['address']);

		}
		$display->add('act_edit', (Url::get('act') == 'edit')? 1:0);
		$display->add('is_root', (User::is_root())? 1: 0);
		$display->add('page', Url::get('page'));
		$display->output('Edit'); // hien thi template
		$this->endForm();
	}

}

?>