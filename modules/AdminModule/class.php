<?php
class AdminModule extends Module{
	function AdminModule($row){
		Module::Module($row);
		
		if(User::is_root()){
			if(Url::check(array('cmd'=>'delete_cache'))){
				EnBac::update_all_page();
				require_once ROOT_PATH.'includes/enbac/dir.php';
				empty_all_dir(PAGE_CACHE_DIR,true);
				Url::redirect_current();
			}
			else
			if(Url::check(array('cmd'=>'scan'))){
				require_once 'forms/scan.php';
				$this->add_form(new ScanModuleForm());
			}
			else
			{
				require_once 'forms/list.php';
				$this->add_form(new ListModuleAdminForm());
			}
		}
		else{
            Url::redirect('admin');
		}
	}
}
?>