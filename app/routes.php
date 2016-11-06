<?php

//Used for dev by Quynh
$isDev = Request::get('is_debug','');
if($isDev == 'tech_code'){
    Session::put('is_debug_of_tech', '13031984');
    Config::set('compile.debug',true);
}
if(Session::has('is_debug_of_tech')){
    Config::set('compile.debug',true);
}

//Router Frontend
Route::group(array('prefix' => '/', 'before' => ''), function () {
    require app_path().'/routes/site.php';
});

//Router login admin
Route::get('quan-tri.html', array('as' => 'admin.login','uses' => 'LoginController@loginInfo'));
Route::post('quan-tri.html', array('as' => 'admin.login','uses' => 'LoginController@login'));
//Router Backend
Route::group(array('prefix' => 'admin', 'before' => ''), function(){
	require app_path().'/routes/admin.php';
});

//Router cho cronjobs
Route::group(array('prefix' => 'cronjobs', 'before' => ''), function () {
    Route::get('runJobs', array('as' => 'cronjobs.runJobs','uses' => 'CronjobsController@runJobs'));//cap nhật lại link ảnh trong content
});

//Router cho Ajax
Route::group(array('prefix' => 'ajax', 'before' => ''), function () {
    Route::post('uploadImage', array('as' => 'ajax.uploadImage','uses' => 'AjaxCommonController@uploadImage'));
    Route::post('removeImageCommon', array('as' => 'ajax.removeImageCommon','uses' => 'AjaxCommonController@removeImageCommon'));
    Route::post('getImageContentCommon', array('as' => 'ajax.getImageContentCommon','uses' => 'AjaxCommonController@getImageContentCommon'));
    Route::get('sendEmail', array('as' => 'ajax.sendEmail','uses' => 'AjaxCommonController@sendEmail'));
	Route::match(['GET','POST'],'ajax-get-product-other-site', array('as' => 'ajax.getProductFromOther','uses' => 'AjaxCommonController@getProductFromOtherSite'));
});
