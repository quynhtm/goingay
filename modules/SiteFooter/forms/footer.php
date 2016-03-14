<?php
class SiteFooterForm extends Form{
	function __construct(){
		Form::Form('FooterForm');
		$this->link_css('style/so_sprite.css');
	}
	function draw(){
		global $display;
		$display->add('my_save', (User::is_login()) ? Url::build('account'):"javascript: Bm.show_popup_message('Bạn phải đăng nhập mới được thực hiện chức năng này.','Thông báo',-1); ");
		$display->add('is_login',User::is_login());
        $display->output("Footer");
	}
}