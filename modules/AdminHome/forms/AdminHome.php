<?php
class AdminHomeForm extends Form{
	function AdminHomeForm(){
		Form::Form('AdminHomeForm');
        $this->link_css('style/bootstrap/css/bootstrap.css');
        $this->link_css('style/bootstrap/css/main.css');
        $this->link_css('style/bootstrap/css/font-awesome.min.css');
	}
	function draw(){
		global $display;

        $display->add('is_root',(User::is_root())? 1: 0);
        $display->add('is_manager',(User::is_manager())? 1: 0);
        $display->add('is_admin',(User::is_admin())? 1: 0);

        $display->add('check_permit_product',(User::check_permit_product())? 1: 0);

		$display->output('AdminHome');
	}
}
?>