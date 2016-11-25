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

Route::match(['GET','POST'],'thay-doi-thong-tin.html', array('as' => 'customer.pageChageInfo','uses' => 'SiteUserCustomerController@pageChageInfo'));
Route::match(['GET','POST'],'thay-doi-mat-khau.html', array('as' => 'customer.pageChagePass','uses' => 'SiteUserCustomerController@pageChagePass'));
Route::post('thong-tin-quan-huyen-cua-khach.html',array('as' => 'customer.getDistrictCustomer','uses' =>'SiteUserCustomerController@getDistrictCustomer'));


//Category
Route::get('{name}-{id}.html',array('as' => 'SiteHomeController.pageCategory','uses' =>'SiteHomeController@pageCategory'))->where('name', '[A-Z0-9a-z_\-]+')->where('id', '[0-9]+');
Route::get('chi-tiet.html',array('as' => 'SiteHomeController.pageProductView','uses' =>'SiteHomeController@pageProductView'));

//Quan ly tin dang
Route::get('quan-ly-tin-dang.html',array('as' => 'customer.ItemsList','uses' =>'SiteUserCustomerController@itemsList'));
Route::get('dang-tin.html',array('as' => 'customer.ItemsAdd','uses' =>'SiteUserCustomerController@getAddItem'));
Route::get('cap-nhat-tin-dang/t-{item_id}.html',array('as' => 'customer.ItemsEdit','uses' =>'SiteUserCustomerController@getEditItem'))->where('item_id', '[0-9]+');
Route::post('cap-nhat-tin-dang/t-{item_id}.html',array('as' => 'customer.ItemsEdit','uses' =>'SiteUserCustomerController@postEditItem'))->where('item_id', '[0-9]+');
Route::post('up-top-tin-dang.html',array('as' => 'customer.setTopItems','uses' =>'SiteUserCustomerController@setTopItems'));


