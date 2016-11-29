<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/
// used for dev by Quynh
$isDev = Request::get('is_debug','');
if($isDev == 'tech_code'){
    Session::put('is_debug_of_tech', '13031984');
    Config::set('compile.debug',true);
}
if(Session::has('is_debug_of_tech')){
    Config::set('compile.debug',true);
}


/*
 * router cho phan Site
 *
 * */
Route::group(array('prefix' => '/', 'before' => ''), function () {
    require app_path() . '/routes/routes_site.php';
});

/*
 * router cho cronjobs
 *
 * */
Route::group(array('prefix' => 'cronjobs', 'before' => ''), function () {
    Route::get('runJobs', array('as' => 'cronjobs.runJobs','uses' => 'CronjobsController@runJobs'));//cap nhật lại link ảnh trong content
});

/*
 * router cho Ajax
 *
 * */
Route::group(array('prefix' => 'ajax', 'before' => ''), function () {
    Route::post('uploadImage', array('as' => 'ajax.uploadImage','uses' => 'AjaxCommonController@uploadImage'));
    Route::post('removeImageCommon', array('as' => 'ajax.removeImageCommon','uses' => 'AjaxCommonController@removeImageCommon'));
    Route::post('getImageContentCommon', array('as' => 'ajax.getImageContentCommon','uses' => 'AjaxCommonController@getImageContentCommon'));
    Route::get('sendEmail', array('as' => 'ajax.sendEmail','uses' => 'AjaxCommonController@sendEmail'));
    
	Route::match(['GET','POST'],'ajax-get-product-other-site', array('as' => 'ajax.getProductFromOther','uses' => 'AjaxCommonController@getProductFromOtherSite'));
});

/*
 * router cho phan Admin
 *
 * */
/*login logout*/
Route::get('quan-tri.html', array('as' => 'admin.login','uses' => 'LoginController@loginInfo'));
Route::post('quan-tri.html', array('as' => 'admin.login','uses' => 'LoginController@login'));
Route::group(array('prefix' => 'admin', 'before' => ''), function()
{
    Route::get('logout', array('as' => 'admin.logout','uses' => 'LoginController@logout'));
    /*màn hình chính*/
    Route::get('dashboard', array('as' => 'admin.dashboard','uses' => 'DashBoardController@dashboard'));
    Route::get('convert', array('as' => 'admin.convert','uses' => 'BaseAdminController@convert'));

    /*thông tin tài khoản*/
    Route::get('user/view',array('as' => 'admin.user_view','uses' => 'UserController@view'));
    Route::get('user/create',array('as' => 'admin.user_create','uses' => 'UserController@createInfo'));
    Route::post('user/create',array('as' => 'admin.user_create','uses' => 'UserController@create'));
    Route::get('user/edit/{id}',array('as' => 'admin.user_edit','uses' => 'UserController@editInfo'))->where('id', '[0-9]+');
    Route::post('user/edit/{id}',array('as' => 'admin.user_edit','uses' => 'UserController@edit'))->where('id', '[0-9]+');
    Route::get('user/change/{id}',array('as' => 'admin.user_change','uses' => 'UserController@changePassInfo'));
    Route::post('user/change/{id}',array('as' => 'admin.user_change','uses' => 'UserController@changePass'));
    Route::post('user/remove/{id}',array('as' => 'admin.user_remove','uses' => 'UserController@remove'));

    /*thông tin quyền*/
    Route::get('permission/view',array('as' => 'admin.permission_view','uses' => 'PermissionController@view'));
    Route::get('permission/create',array('as' => 'admin.permission_create','uses' => 'PermissionController@createInfo'));
    Route::post('permission/create',array('as' => 'admin.permission_create','uses' => 'PermissionController@create'));
    Route::get('permission/edit/{id}',array('as' => 'admin.permission_edit','uses' => 'PermissionController@editInfo'))->where('id', '[0-9]+');
    Route::post('permission/edit/{id}',array('as' => 'admin.permission_edit','uses' => 'PermissionController@edit'))->where('id', '[0-9]+');
    Route::post('permission/deletePermission', array('as' => 'admin.deletePermission','uses' => 'PermissionController@deletePermission'));//ajax

    /*thông tin nhóm quyền*/
    Route::get('groupUser/view',array('as' => 'admin.groupUser_view','uses' => 'GroupUserController@view'));
    Route::get('groupUser/create',array('as' => 'admin.groupUser_create','uses' => 'GroupUserController@createInfo'));
    Route::post('groupUser/create',array('as' => 'admin.groupUser_create','uses' => 'GroupUserController@create'));
    Route::get('groupUser/edit/{id}',array('as' => 'admin.groupUser_edit','uses' => 'GroupUserController@editInfo'))->where('id', '[0-9]+');
    Route::post('groupUser/edit/{id}',array('as' => 'admin.groupUser_edit','uses' => 'GroupUserController@edit'))->where('id', '[0-9]+');

    /*Quản lý danh mục SP*/
    Route::get('category/view',array('as' => 'admin.category_list','uses' => 'CategoryController@view'));
    Route::get('category/getCategroy/{id?}', array('as' => 'admin.category_edit','uses' => 'CategoryController@getCategroy'))->where('id', '[0-9]+');
    Route::post('category/postCategory/{id?}', array('as' => 'admin.category_edit_post','uses' => 'CategoryController@postCategory'))->where('id', '[0-9]+');
    Route::post('category/deleteCategory', array('as' => 'admin.deltete_category_post','uses' => 'CategoryController@deleteCategory'));//ajax
    Route::post('category/updateStatusCategory', array('as' => 'admin.status_category_post','uses' => 'CategoryController@updateStatusCategory'));//ajax

    /*Quản lý danh sách khách hàng đăng tin*/
    Route::get('customer/view',array('as' => 'admin.customerView','uses' => 'UserCustomerController@view'));
    Route::get('customer/getEditCustomer/{id?}', array('as' => 'admin.getCustomerEdit','uses' => 'UserCustomerController@getEditCustomer'))->where('id', '[0-9]+');
    Route::post('customer/postEditCustomer/{id?}', array('as' => 'admin.customerEdit','uses' => 'UserCustomerController@postEditCustomer'))->where('id', '[0-9]+');
    Route::post('customer/deleteCustomer', array('as' => 'admin.deleteCustomer','uses' => 'UserCustomerController@deleteCustomer'));//ajax
    Route::get('customer/loginToCustomer/{id?}', array('as' => 'admin.loginToCustomer','uses' => 'UserCustomerController@loginToCustomer'))->where('id', '[0-9]+');
    Route::post('customer/updateStatusCustomer', array('as' => 'admin.customerStatus','uses' => 'UserCustomerController@updateStatusCustomer'));//ajax
    Route::post('customer/setIsCustomer', array('as' => 'admin.setIsCustomer','uses' => 'UserCustomerController@setIsCustomer'));//ajax

    /*Quản lý tin đăng*/
    Route::get('items/view',array('as' => 'admin.itemsView','uses' => 'ItemsController@view'));
    Route::get('items/getItems/{id}', array('as' => 'admin.itemsEdit','uses' => 'ItemsController@getItems'))->where('id', '[0-9]+');
    Route::post('items/postItems/{id}', array('as' => 'admin.itemsEdit','uses' => 'ItemsController@postItems'))->where('id', '[0-9]+');
    Route::post('items/setStastusBlockItems', array('as' => 'admin.setStastusBlockItems','uses' => 'ItemsController@setStastusBlockItems'));//ajax
    Route::post('items/deleteMultiItems', array('as' => 'admin.deleteMultiItems','uses' => 'ItemsController@deleteMultiItems'));//ajax

    /*Quản lý tin tức*/
    Route::get('news/view',array('as' => 'admin.newsView','uses' => 'NewsController@view'));
    Route::get('news/edit/{id?}', array('as' => 'admin.newsEdit','uses' => 'NewsController@getNews'))->where('id', '[0-9]+');
    Route::post('news/edit/{id?}', array('as' => 'admin.newsEdit','uses' => 'NewsController@postNews'))->where('id', '[0-9]+');
    Route::post('news/deleteNews', array('as' => 'admin.delteteNews','uses' => 'NewsController@deleteNews'));//ajax

    /*Quản lý banner*/
    Route::any('banner/view',array('as' => 'admin.bannerView','uses' => 'BannerController@view'));
    Route::get('banner/edit/{id?}', array('as' => 'admin.bannerEdit','uses' => 'BannerController@getBanner'))->where('id', '[0-9]+');
    Route::post('banner/edit/{id?}', array('as' => 'admin.bannerEdit','uses' => 'BannerController@postBanner'))->where('id', '[0-9]+');
    Route::post('banner/deleteBanner', array('as' => 'admin.deleteBanner','uses' => 'BannerController@deleteBanner'));//ajax

    //Thong tin cau hinh chung: hotline, thong tin chan trang...
    Route::get('info', array('as' => 'admin.info','uses' => 'InfoController@listView'));
    Route::get('info/edit/{id?}', array('as' => 'admin.info_edit','uses' => 'InfoController@getItem'))->where('id', '[0-9]+');
    Route::post('info/edit/{id?}', array('as' => 'admin.info_edit','uses' => 'InfoController@postItem'))->where('id', '[0-9]+');
    Route::match(['GET','POST'],'info/delete', array('as' => 'admin.info_delete','uses' => 'InfoController@delete'));
    //Thung rac
    Route::get('trash', array('as' => 'admin.trash','uses' => 'TrashController@listView'));
    Route::get('trash/edit/{id?}', array('as' => 'admin.trash_edit','uses' => 'TrashController@getItem'))->where('id', '[0-9]+');
    Route::post('trash/edit/{id?}', array('as' => 'admin.trash_edit','uses' => 'TrashController@postItem'))->where('id', '[0-9]+');
    Route::match(['GET','POST'],'trash/delete', array('as' => 'admin.trash_delete','uses' => 'TrashController@delete'));
    Route::match(['GET','POST'],'trash/restore', array('as' => 'admin.trash_delete','uses' => 'TrashController@restore'));
    //Tinh thanh
    Route::get('province/view', array('as' => 'admin.province','uses' => 'ProvinceController@listView'));
    Route::get('province/edit/{id?}', array('as' => 'admin.provinceEdit','uses' => 'ProvinceController@getItem'))->where('id', '[0-9]+');
    Route::post('province/edit/{id?}', array('as' => 'admin.provinceEdit','uses' => 'ProvinceController@postItem'))->where('id', '[0-9]+');
    Route::post('province/deleteProvince', array('as' => 'admin.deleteProvince','uses' => 'ProvinceController@deleteProvince'));//ajax
    Route::get('province/getInforDistrictOfProvince',array('as'=>'getInforDistrictOfProvince','uses'=>'ProvinceController@getInforDistrictOfProvince'));// thong tin quan huyen
    Route::post('province/submitInforDistrictOfProvince',array('as'=>'submitInforDistrictOfProvince','uses'=>'ProvinceController@submitInforDistrictOfProvince'));// thong tin quan huyen

    //Tools quản lý các page khác nhau
    Route::get('toolsCommon/viewClickShare',array('as' => 'admin.viewClickShare','uses' => 'ToolsCommonController@viewClickShare'));
    //quan ly noi dung gui email
    Route::get('toolsCommon/viewContentSendEmail',array('as' => 'admin.contentSendEmail_list','uses' => 'ToolsCommonController@viewContentSendEmail'));
    Route::get('toolsCommon/edit/{id?}', array('as' => 'admin.contentSendEmail_edit','uses' => 'ToolsCommonController@getContentSendEmail'))->where('id', '[0-9]+');
    Route::post('toolsCommon/edit/{id?}', array('as' => 'admin.contentSendEmail_edit','uses' => 'ToolsCommonController@postContentSendEmail'))->where('id', '[0-9]+');
    Route::post('toolsCommon/deleteContentSendEmail', array('as' => 'admin.deltete_provider','uses' => 'ToolsCommonController@deleteContentSendEmail'));//ajax
});
