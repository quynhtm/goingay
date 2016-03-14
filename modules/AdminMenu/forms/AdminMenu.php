<?php
class AdminMenuForm extends Form{
	function AdminMenuForm(){
		Form::Form('AdminMenuForm');
        $this->link_css('style/bootstrap/css/bootstrap.css');
        $this->link_css('style/bootstrap/css/common_admin.css');
        $this->link_css('style/bootstrap/lib/upload/cssUpload.css');

        $this->link_js('style/bootstrap/js/jquery.min.js');
        $this->link_js('style/bootstrap/js/common_admin.js');
        $this->link_js('style/bootstrap/lib/upload/jquery.uploadfile.js');

	}
	function draw(){
		global $display;
		$display->add('is_root',(User::is_root())? 1: 0);
		$display->add('is_shop',(User::is_shop())? 1: 0);
		$display->add('is_manager',(User::is_manager())? 1: 0);
		$display->add('is_admin',(User::is_admin())? 1: 0);
		$display->add('is_manager_product',(User::is_manager_product())? 1: 0);
		$display->add('is_manager_new',(User::is_manager_new())? 1: 0);
		$display->add('is_sale',(User::is_sale())? 1: 0);
		$display->add('is_setup_permit',(User::is_setup_permit())? 1: 0);

        $display->add('page_action', Url::get('page'));

		$display->add('admin_user',User::$data['user_name']);
		$display->add('domain_site',CGlobal::$domain_site);
		$display->add('id_user',base64_encode('user_admin_'.User::$data['id']));
		$display->output('AdminMenu');
	}
}
?>