<?php
	Route::get('logout', array('as' => 'admin.logout','uses' => 'LoginController@logout'));
    /*Man hinh chinh*/
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
    Route::get('customer/getEditCustomer/{id?}', array('as' => 'admin.customerEdit','uses' => 'UserCustomerController@getEditCustomer'))->where('id', '[0-9]+');
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
	Route::post('trash/edit/{id?}', array('as' => 'admin.trash_edit','uses' => 'TrashController@getItem'))->where('id', '[0-9]+');
	Route::match(['GET','POST'],'trash/delete', array('as' => 'admin.trash_delete','uses' => 'TrashController@delete'));
	Route::match(['GET','POST'],'trash/restore', array('as' => 'admin.trash_delete','uses' => 'TrashController@restore'));
	//Tinh thanh
	Route::get('provice', array('as' => 'admin.provice','uses' => 'ProviceController@listView'));
	Route::get('provice/edit/{id?}', array('as' => 'admin.provice_edit','uses' => 'ProviceController@getItem'))->where('id', '[0-9]+');
	Route::post('provice/edit/{id?}', array('as' => 'admin.provice_edit','uses' => 'ProviceController@postItem'))->where('id', '[0-9]+');
	Route::match(['GET','POST'],'provice/delete', array('as' => 'admin.provice_delete','uses' => 'ProviceController@delete'));

    //Tools quản lý các page khác nhau
    Route::get('toolsCommon/viewShopShare',array('as' => 'admin.viewShopShare','uses' => 'ToolsCommonController@viewShopShare'));
    //quan ly noi dung gui email
    Route::get('toolsCommon/viewContentSendEmail',array('as' => 'admin.contentSendEmail_list','uses' => 'ToolsCommonController@viewContentSendEmail'));
    Route::get('toolsCommon/edit/{id?}', array('as' => 'admin.contentSendEmail_edit','uses' => 'ToolsCommonController@getContentSendEmail'))->where('id', '[0-9]+');
    Route::post('toolsCommon/edit/{id?}', array('as' => 'admin.contentSendEmail_edit','uses' => 'ToolsCommonController@postContentSendEmail'))->where('id', '[0-9]+');
    Route::post('toolsCommon/deleteContentSendEmail', array('as' => 'admin.deltete_provider','uses' => 'ToolsCommonController@deleteContentSendEmail'));//ajax
    //Gửi email tới khách hàng
    Route::post('toolsCommon/sendEmailContentToCustomer',array('as' => 'admin.sendEmailContentToCustomer','uses' => 'ToolsCommonController@sendEmailContentToCustomer'));
    //Gui Email toi nha cung cap mo shop
    Route::post('toolsCommon/sendEmailInviteToSupplier',array('as' => 'admin.sendEmailInviteToSupplier','uses' => 'ToolsCommonController@sendEmailInviteToSupplier'));