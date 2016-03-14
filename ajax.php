<?php
require_once 'core/config.php';//System Config...
require_once 'core/Debug.php'; //System Debug...
require_once 'core/Init.php';  //System Init...
//System process & output for ajax request
if(is_debug()) {
	$debug = new Debug();
}
$choice = array(
            "index"      	=>        "index",
			"admin"    	 	=>        "ajax_admin",
			"upload_image"  =>        "ajax_upload_image",
			"user"       	=>        "ajax_user",
			"register"      =>    	  "ajax_register",
			'att_product'   =>        'ajax_product',
			'mng_images'    =>        'ajax_sv_mng_images',
			"profile_edit"  =>        "ajax_profile_edit",
			"faqs_list"  	=>        "ajax_faqs_list",
			"list_detail"   =>    	  "ajax_list_detail",
			"province"      =>        "ajax_so_province"
		);
		$action = EnBacLib::getParam('act');
		if (!isset($choice[$action])) {
			$choice[$action] = "index";
		}
		require_once(ROOT_PATH."includes/ajax/".$choice[$action].".ajax.php");
		$run_me = new $choice[$action]();
		$run_me->playme();