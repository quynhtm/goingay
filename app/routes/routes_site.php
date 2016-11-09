<?php
/*
* @Created by: DUYNX
* @Author    : nguyenduypt86@gmail.com
* @Date      : 11/2016
* @Version   : 1.0
*/

/*home*/
Route::any('/', array('as' => 'site.home','uses' => 'SiteHomeController@index'));
Route::get('404.html',array('as' => 'site.page404','uses' =>'SiteHomeController@page404'));

//Register - Login
Route::match(['GET','POST'],'dang-ky.html', array('as' => 'customer.pageRegister','uses' => 'SiteUserCustomerController@pageRegister'));
Route::match(['GET','POST'],'kich-hoat-tai-khoan.html', array('as' => 'customer.pageActiveRegister','uses' => 'SiteUserCustomerController@pageActiveRegister'));

Route::match(['GET','POST'],'dang-nhap.html', array('as' => 'customer.pageLogin','uses' => 'SiteUserCustomerController@pageLogin'));
Route::match(['GET','POST'],'thanh-vien-thoat.html', array('as' => 'customer.logout','uses' => 'SiteUserCustomerController@logout'));
Route::match(['GET','POST'],'quen-mat-khau.html', array('as' => 'customer.pageForgetPass','uses' => 'SiteUserCustomerController@pageForgetPass'));
Route::match(['GET','POST'],'quen-mat-khau', array('as' => 'customer.pageGetForgetPass','uses' => 'SiteUserCustomerController@pageGetForgetPass'));

Route::match(['GET','POST'],'thay-doi-thong-tin.html', array('as' => 'customer.pageChageInfo','uses' => 'SiteUserCustomerController@pageChageInfo'));
Route::match(['GET','POST'],'thay-doi-mat-khau.html', array('as' => 'customer.pageChagePass','uses' => 'SiteUserCustomerController@pageChagePass'));
Route::match(['GET','POST'],'lich-su-mua-hang.html', array('as' => 'customer.pageHistoryOrder','uses' => 'SiteUserCustomerController@pageHistoryOrder'));
Route::match(['GET','POST'],'chi-tiet-don-hang.html', array('as' => 'customer.pageHistoryViewOrder','uses' => 'SiteUserCustomerController@pageHistoryViewOrder'));
