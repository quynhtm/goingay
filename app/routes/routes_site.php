<?php
/*
* @Created by: DUYNX
* @Author    : nguyenduypt86@gmail.com
* @Date      : 11/2016
* @Version   : 1.0
*/

//Home
Route::any('/', array('as' => 'site.home','uses' => 'SiteHomeController@index'));
Route::get('404.html',array('as' => 'site.page404','uses' =>'SiteHomeController@page404'));

//Register - Login
Route::match(['GET','POST'],'dang-ky.html', array('as' => 'customer.pageRegister','uses' => 'SiteUserCustomerController@pageRegister'));
Route::match(['GET','POST'],'kich-hoat-tai-khoan.html', array('as' => 'customer.pageActiveRegister','uses' => 'SiteUserCustomerController@pageActiveRegister'));

Route::match(['GET','POST'],'dang-nhap.html', array('as' => 'customer.pageLogin','uses' => 'SiteUserCustomerController@pageLogin'));
Route::match(['GET','POST'],'thanh-vien-thoat.html', array('as' => 'customer.logout','uses' => 'SiteUserCustomerController@logout'));
Route::match(['GET','POST'],'quen-mat-khau.html', array('as' => 'customer.pageForgetPass','uses' => 'SiteUserCustomerController@pageForgetPass'));
//Login Facebook - Google
Route::match(['GET','POST'], 'facebooklogin', array('as' => 'customer.loginFacebook','uses' => 'SiteUserCustomerController@loginFacebook'));
Route::match(['GET','POST'], 'googlelogin', array('as' => '.customer.loginGoogle','uses' => 'SiteUserCustomerController@loginGoogle'));

//list tin theo danh muc Category
Route::get('{name}-{id}.html',array('as' => 'Site.pageCategory','uses' =>'SiteHomeController@pageCategory'))->where('name', '[A-Z0-9a-z_\-]+')->where('id', '[0-9]+');

//list tin dang cua nguoi dung
Route::get('tin-rao-da-dang/{customer_name}-c-{customer_id}.html',array('as' => 'Site.pageListItemCustomer','uses' =>'SiteHomeController@pageListItemCustomer'))->where('customer_name', '[A-Z0-9a-z_\-]+')->where('customer_id', '[0-9]+');

//chi tiet tin rao vat
Route::get('{item_name}-cat{item_category_id}-tin{item_id}.html',array('as' => 'Site.pageDetailItem','uses' =>'SiteHomeController@pageDetailItem'))->where('item_name', '[A-Z0-9a-z_\-]+')->where('item_category_id', '[0-9]+')->where('item_id', '[0-9]+');

//tin tuc
Route::get('tin-tuc.html',array('as' => 'Site.pageNews','uses' =>'SiteHomeController@pageNews'));
Route::get('chi-tiet/tin-tuc-{new_id}/{news_title}.html',array('as' => 'Site.pageDetailNew','uses' =>'SiteHomeController@pageDetailNew'))->where('new_id', '[0-9]+')->where('news_title', '[A-Z0-9a-z_\-]+');



/******************************************************************************************************************************
 * Thao tac co phan dang nh?p cua Kh�ch h�ng
//Quan ly tin dang
 * /***************************************************************************************************************************
 * */
Route::get('quan-ly-tin-dang.html',array('as' => 'customer.ItemsList','uses' =>'SiteUserCustomerController@itemsList'));
Route::get('dang-tin.html',array('as' => 'customer.ItemsAdd','uses' =>'SiteUserCustomerController@getAddItem'));
Route::get('cap-nhat-tin-dang/t-{item_id}.html',array('as' => 'customer.ItemsEdit','uses' =>'SiteUserCustomerController@getEditItem'))->where('item_id', '[0-9]+');
Route::post('cap-nhat-tin-dang/t-{item_id}.html',array('as' => 'customer.ItemsEdit','uses' =>'SiteUserCustomerController@postEditItem'))->where('item_id', '[0-9]+');
Route::post('up-top-tin-dang.html',array('as' => 'customer.setTopItems','uses' =>'SiteUserCustomerController@setTopItems'));
Route::post('xoa-tin-dang.html',array('as' => 'customer.removeItems','uses' =>'SiteUserCustomerController@removeItems'));
Route::post('getAllImageItem',array('as' => 'customer.getAllImageItem','uses' =>'SiteUserCustomerController@getAllImageItem'));
Route::post('removeImage',array('as' => 'customer.removeImage','uses' =>'SiteUserCustomerController@removeImage'));

//sua thong tin KH
Route::match(['GET','POST'],'thay-doi-thong-tin.html', array('as' => 'customer.pageChageInfo','uses' => 'SiteUserCustomerController@pageChageInfo'));
Route::match(['GET','POST'],'thay-doi-mat-khau.html', array('as' => 'customer.pageChagePass','uses' => 'SiteUserCustomerController@pageChagePass'));
Route::post('thong-tin-quan-huyen-cua-khach.html',array('as' => 'customer.getDistrictCustomer','uses' =>'SiteUserCustomerController@getDistrictCustomer'));



