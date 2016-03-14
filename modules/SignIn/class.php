<?php
class SignIn extends Module{
	function SignIn($row){
		Module::Module($row);
       // echo 'id='.User::is_login(); die;
        if(!User::is_login()){
			require_once 'forms/SignIn.php';
			$this->add_form(new SignInForm);
		}
        else{
			$href = Url::get('href');
			$href = base64_decode($href);
			if($href){				
				$href = str_replace('SID='.$_COOKIE['PHPSESSID'],'',$href);
				Url::redirect_url($href);
			}
			else{
				Url::redirect('admin');
			}			
		}
	}
}