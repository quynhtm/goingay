<?php

/**
 * 
 * * @author Quynh_Arsenal
 *
 */
class EditForm extends Form {
    var $table_action = TABLE_ACCOUNT;
	private $item = array();
    private $id = 0;
	function EditForm() {
		Form::Form('EditForm');
        $this->link_css('style/bootstrap/lib/datetimepicker_new/datetimepicker.css');
        $this->link_js('style/bootstrap/lib/datetimepicker_new/jquery.datetimepicker.js');

        $string_id_input = Url::get('id',0);
        $string_id = base64_decode($string_id_input);
        $pos = strrpos($string_id, "_");
        $this->id = (int)substr($string_id, ($pos + 1), strlen($string_id));

        $id_online = (int)User::$data['id'];
        if($this->id === $id_online || User::is_setup_permit()){
            if ($this->id > 0) { //edit
                $this->item = Account::getAccountById($this->id);
                if (!$this->item)
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
        $id_online = (int)User::$data['id'];

        //arr quyền
        $arrPermit = CGlobal::$arrPermitAuthen;
        if(!User::is_root()){
            unset($arrPermit[0]);//bo quyen root khi khong phai la ROOT
        }
        $display->add('arrPermit', $arrPermit);
        $display->add('arr_permit_user',isset($this->item ['permit_action'])? explode(',',$this->item ['permit_action']): array());

        //kiểu shop
        $arrTypeShop = array(-1 => '-- Chọn shop --', CGlobal::IS_SHOP => 'Shop', CGlobal::IS_MEMBER => "Acount thường");
        $optionTypeShop = EnbacLib::getOption($arrTypeShop, (isset($this->item ['is_shop']) ? $this->item ['is_shop'] : 1));
        $display->add('optionTypeShop', $optionTypeShop);

        // SL danh sach SP của shop
        $arrLimitProduct = CGlobal::$arrLimitProductShop;
        $optionLimitProduct = EnbacLib::getOption($arrLimitProduct, (isset($this->item ['limit_shop_product']) ? $this->item ['limit_shop_product'] : CGlobal::NUMBER_PRODUCT_SHOP_0));
        $display->add('optionLimitProduct', $optionLimitProduct);

        //Ảnh avartar
        $images = ($this->item ['avatar'] != '') ? SvImg::getThumbImage($this->item ['avatar'],$this->item ['id'],SvImg::FOLDER_AVATAR_SHOP,600,200):'';
        $display->add ( 'avatar', Url::get ( 'avatar',(!empty($images))? $images:'') );
        $display->add ( 'avatar_src',(!empty($images))? $images:'');

        //giới thiệu của shop
        $editor_contact = getEditor('contact', Url::get('contact', (isset($this->item ['contact']) ? strip_tags($this->item ['contact']) : '')),'99%','300px');
        $display->add('editor_contact', $editor_contact);

        $display->add('id', $this->id);
        $display->add('item', $this->item);
        $display->add('id_online', $id_online);

		$display->add('act_edit', (Url::get('act') == 'edit')? 1:0);
		$display->add('is_root', (User::is_root())? 1: 0);
		$display->add('is_permit', (User::is_setup_permit())? 1: 0);
		$display->add('page', Url::get('page'));
		$display->output('Edit'); // hien thi template
		$this->endForm();
	}
}

?>