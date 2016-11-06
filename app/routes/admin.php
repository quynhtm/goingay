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

    /*Quản lý danh sách shop*/
    Route::get('userShop/view',array('as' => 'admin.userShop_list','uses' => 'UserShopController@view'));
    Route::get('userShop/getUserShop/{id?}', array('as' => 'admin.userShop_edit','uses' => 'UserShopController@getUserShop'))->where('id', '[0-9]+');
    Route::post('userShop/postUserShop/{id?}', array('as' => 'admin.userShop_edit_post','uses' => 'UserShopController@postUserShop'))->where('id', '[0-9]+');
    Route::post('userShop/deleteUserShop', array('as' => 'admin.deltete_userShop_post','uses' => 'UserShopController@deleteUserShop'));//ajax
    Route::get('userShop/loginToShop/{id?}', array('as' => 'admin.loginToShop','uses' => 'UserShopController@loginToShop'))->where('id', '[0-9]+');
    Route::post('userShop/updateStatusUserShop', array('as' => 'admin.status_userShop_post','uses' => 'UserShopController@updateStatusUserShop'));//ajax
    Route::post('userShop/setIsShop', array('as' => 'admin.setIsShop','uses' => 'UserShopController@setIsShop'));//ajax

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
    
    //Quản lý nhà cung cấp
    Route::get('provider/view',array('as' => 'admin.provider_list','uses' => 'ProviderController@view'));
    Route::get('provider/edit/{id?}', array('as' => 'admin.provider_edit','uses' => 'ProviderController@getProvider'))->where('id', '[0-9]+');
    Route::post('provider/edit/{id?}', array('as' => 'admin.provider_edit','uses' => 'ProviderController@postProvider'))->where('id', '[0-9]+');
    Route::post('provider/deleteProvider', array('as' => 'admin.deltete_provider','uses' => 'ProviderController@deleteProvider'));//ajax

    /*Quản lý San Pham*/
    Route::get('product/view',array('as' => 'admin.product_list','uses' => 'ProductController@view'));
    Route::get('product/getProduct/{id}', array('as' => 'admin.product_edit','uses' => 'ProductController@getProduct'))->where('id', '[0-9]+');
    Route::post('product/postProduct/{id}', array('as' => 'admin.product_edit_post','uses' => 'ProductController@postProduct'))->where('id', '[0-9]+');
    Route::post('product/setStastusBlockProduct', array('as' => 'admin.setStastusBlockProduct','uses' => 'ProductController@setStastusBlockProduct'));//ajax
    Route::post('product/deleteMultiProduct', array('as' => 'admin.deleteMultiProduct','uses' => 'ProductController@deleteMultiProduct'));//ajax

    /*Quản lý tin tức*/
    Route::get('news/view',array('as' => 'admin.news_list','uses' => 'NewsController@view'));
    Route::get('news/edit/{id?}', array('as' => 'admin.news_edit','uses' => 'NewsController@getNews'))->where('id', '[0-9]+');
    Route::post('news/edit/{id?}', array('as' => 'admin.news_edit','uses' => 'NewsController@postNews'))->where('id', '[0-9]+');
    Route::post('news/deleteNews', array('as' => 'admin.deltete_news_post','uses' => 'NewsController@deleteNews'));//ajax

    //*Quản lý Liên hệ*/
    Route::get('contact/view',array('as' => 'admin.contact_list','uses' => 'ContactController@view'));
    Route::get('contact/edit/{id?}', array('as' => 'admin.contact_edit','uses' => 'ContactController@getContact'))->where('id', '[0-9]+');
    Route::post('contact/edit/{id?}', array('as' => 'admin.contact_edit','uses' => 'ContactController@postContact'))->where('id', '[0-9]+');
    Route::post('contact/deleteContact', array('as' => 'admin.deltete_contact','uses' => 'ContactController@deleteContact'));//ajax

    /*Quản lý banner*/
    Route::any('banner/view',array('as' => 'admin.banner_list','uses' => 'BannerController@view'));
    Route::get('banner/edit/{id?}', array('as' => 'admin.banner_edit','uses' => 'BannerController@getBanner'))->where('id', '[0-9]+');
    Route::post('banner/edit/{id?}', array('as' => 'admin.banner_edit','uses' => 'BannerController@postBanner'))->where('id', '[0-9]+');
    Route::post('banner/deleteBanner', array('as' => 'admin.deleteBanner','uses' => 'BannerController@deleteBanner'));//ajax

    /*Quan Ly Don Hang*/
    Route::get('order/view',array('as' => 'admin.order_list','uses' => 'OrderController@view'));
    Route::post('order/deleteOrderShop', array('as' => 'admin.deleteOrderShop','uses' => 'OrderController@deleteOrderShop'));
    
    /*Quan Ly danh sach khach hang va gui mail*/
    Route::get('customeremail/view',array('as' => 'admin.customeremail_list','uses' => 'CustomerEmailController@view'));
    Route::get('customeremail/edit/{id?}', array('as' => 'admin.customeremail_edit','uses' => 'CustomerEmailController@getCustomerEmail'))->where('id', '[0-9]+');
    Route::post('customeremail/edit/{id?}', array('as' => 'admin.customeremail_edit_post','uses' => 'CustomerEmailController@postCustomerEmail'))->where('id', '[0-9]+');
    Route::post('customeremail/deleteCustomerEmail', array('as' => 'admin.deltete_customeremail_post','uses' => 'CustomerEmailController@deleteCustomerEmail'));
    Route::post('customeremail/deleteMultiCustomerEmail', array('as' => 'admin.deleteMultiCustomerEmail','uses' => 'CustomerEmailController@deleteMultiCustomerEmail'));//ajax
	
    /*Quan Ly danh sach nha cung cap va gui mail*/
    Route::get('provideremail/view',array('as' => 'admin.provideremail_list','uses' => 'ProviderEmailController@view'));
    Route::get('provideremail/edit/{id?}', array('as' => 'admin.provideremail_edit','uses' => 'ProviderEmailController@getProviderEmail'))->where('id', '[0-9]+');
    Route::post('provideremail/edit/{id?}', array('as' => 'admin.provideremail_edit_post','uses' => 'ProviderEmailController@postProviderEmail'))->where('id', '[0-9]+');
    Route::post('provideremail/deleteProviderEmail', array('as' => 'admin.deltete_provideremail_post','uses' => 'ProviderEmailController@deleteProviderEmail'));
    Route::post('provideremail/deleteMultiProviderEmail', array('as' => 'admin.deleteMultiProviderEmail','uses' => 'ProviderEmailController@deleteMultiProviderEmail'));//ajax
    
    
	

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