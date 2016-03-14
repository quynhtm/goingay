<?php 
class AdminHome extends Module{
	function AdminHome($row){
		if(User::is_login()){
			Module::Module($row);
			require_once 'forms/AdminHome.php';
			$this->add_form(new AdminHomeForm());
		}
	}
}