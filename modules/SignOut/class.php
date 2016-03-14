<?php
class SignOut{
	function __construct(){
		if(User::is_login()){
			User::LogOut();
		}
        Url::redirect('sign_in');
	}
}