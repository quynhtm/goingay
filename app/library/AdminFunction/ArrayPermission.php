<?php
/**
 * Created by JetBrains PhpStorm.
 * User: QuynhTM
 */
class ArrayPermission{
    public static $arrPermit = array(
        'user_view' => array('name_permit'=>'Xem danh sách user Admin','group_permit'=>'Tài khoản Admin'),
        'user_create' => array('name_permit'=>'Tạo user Admin','group_permit'=>'Tài khoản Admin'),
        'user_edit' => array('name_permit'=>'Sửa user Admin','group_permit'=>'Tài khoản Admin'),
        'user_change_pass' => array('name_permit'=>'Thay đổi user Admin','group_permit'=>'Tài khoản Admin'),
        'user_remove' => array('name_permit'=>'Xóa user Admin','group_permit'=>'Tài khoản Admin'),

        'group_user_view' => array('name_permit'=>'Xem nhóm quyền','group_permit'=>'Nhóm quyền'),
        'group_user_create' => array('name_permit'=>'Tạo nhóm quyền','group_permit'=>'Nhóm quyền'),
        'group_user_edit' => array('name_permit'=>'Sửa nhóm quyền','group_permit'=>'Nhóm quyền'),

        'permission_full' => array('name_permit'=>'Full tạo quyền','group_permit'=>'Tạo quyền'),
        'permission_create' => array('name_permit'=>'Tạo tạo quyền','group_permit'=>'Tạo quyền'),
        'permission_edit' => array('name_permit'=>'Sửa tạo quyền','group_permit'=>'Tạo quyền'),

        'banner_full' => array('name_permit'=>'Full quảng cáo','group_permit'=>'Quyền quảng cáo'),
        'banner_view' => array('name_permit'=>'Xem quảng cáo','group_permit'=>'Quyền quảng cáo'),
        'banner_delete' => array('name_permit'=>'Xóa quảng cáo','group_permit'=>'Quyền quảng cáo'),
        'banner_create' => array('name_permit'=>'Tạo quảng cáo','group_permit'=>'Quyền quảng cáo'),
        'banner_edit' => array('name_permit'=>'Sửa quảng cáo','group_permit'=>'Quyền quảng cáo'),

        'category_full' => array('name_permit'=>'Full danh mục','group_permit'=>'Quyền danh mục'),
        'category_view' => array('name_permit'=>'Xem danh mục','group_permit'=>'Quyền danh mục'),
        'category_delete' => array('name_permit'=>'Xóa danh mục','group_permit'=>'Quyền danh mục'),
        'category_create' => array('name_permit'=>'Tạo danh mục','group_permit'=>'Quyền danh mục'),
        'category_edit' => array('name_permit'=>'Sửa danh mục','group_permit'=>'Quyền danh mục'),

        'news_full' => array('name_permit'=>'Full tin tức','group_permit'=>'Quyền tin tức'),
        'news_view' => array('name_permit'=>'Xem tin tức','group_permit'=>'Quyền tin tức'),
        'news_delete' => array('name_permit'=>'Xóa tin tức','group_permit'=>'Quyền tin tức'),
        'news_create' => array('name_permit'=>'Tạo tin tức','group_permit'=>'Quyền tin tức'),
        'news_edit' => array('name_permit'=>'Sửa tin tức','group_permit'=>'Quyền tin tức'),

        'province_full' => array('name_permit'=>'Full tỉnh thành','group_permit'=>'Quyền tỉnh thành'),
        'province_view' => array('name_permit'=>'Xem tỉnh thành','group_permit'=>'Quyền tỉnh thành'),
        'province_delete' => array('name_permit'=>'Xóa tỉnh thành','group_permit'=>'Quyền tỉnh thành'),
        'province_create' => array('name_permit'=>'Tạo tỉnh thành','group_permit'=>'Quyền tỉnh thành'),
        'province_edit' => array('name_permit'=>'Sửa tỉnh thành','group_permit'=>'Quyền tỉnh thành'),

        'user_customer_full' => array('name_permit'=>'Full khách hàng','group_permit'=>'Quyền khách hàng'),
        'user_customer_view' => array('name_permit'=>'Xem khách hàng','group_permit'=>'Quyền khách hàng'),
        'user_customer_delete' => array('name_permit'=>'Xóa khách hàng','group_permit'=>'Quyền khách hàng'),
        'user_customer_create' => array('name_permit'=>'Tạo khách hàng','group_permit'=>'Quyền khách hàng'),
        'user_customer_edit' => array('name_permit'=>'Sửa khách hàng','group_permit'=>'Quyền khách hàng'),

    );

}