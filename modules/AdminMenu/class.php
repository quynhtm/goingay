<?php 
class AdminMenu extends Module{
	function AdminMenu($row){
		Module::Module($row);
		if(User::is_login()){
			require_once 'forms/AdminMenu.php';
			$this->add_form(new AdminMenuForm());			
		} 
		else {
            Url::redirect('sign_in');
		}
	}
}