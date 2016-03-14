<?php

define('CURRENCY_USD', 1); // USD
define('CURRENCY_EUR', 2); // EURO

define('USD_VND', 20000); // define default

//phongct defined group permission
define('G_ROOT', 9);
define('G_ADMIN', 1);
define('G_MOD',	 2);
define('G_MEMBER', 3);
define('G_SHOP', 4);

define('ADMIN_USER', 1);
define('ADMIN_ITEM', 2);
define('ADMIN_PRODUCT',	 3);
define('ADMIN_NEWS', 4);
define('ADMIN_LOGIN_AS', 5);

define('CHECK_SHOP', 0); //kiểm tra có dùng cho shop ko, check theo account shop

//Quynh định nghĩa quyền mới
define('PERMIT_ROOT', 1); //Root
define('PERMIT_ADMIN', 2);
define('PERMIT_MEMBER', 3);
define('PERMIT_SETUP_PERMIT', 7);//quyền phân quyên cho các user
define('PERMIT_SHOP', 8);//Shop
define('PERMIT_MEMBER_SHOP', 9);//member cua shop nao do

define('PERMIT_SALE', 4);//bán hàng, hóa đơn
define('PERMIT_INPUT_STORE', 5);//nhập kho
define('PERMIT_LOG_STORE', 6);//Log nhập xuất kho

define('PERMIT_FULL_PRODUCTS', 10);//Full quyền cho phần quản trị sản phẩm bao gồm các thao tác : Thêm , sửa , xóa, phê duyệt
define('PERMIT_VIEW_PRODUCT', 11); //xem sản phẩm
define('PERMIT_EDIT_PRODUCT', 12); //thêm && Sửa sản phẩm
define('PERMIT_DELETE_PRODUCT', 13); //Xóa sản phẩm
define('PERMIT_APPROVE_PRODUCT', 14); //Phê duyệt sản phẩm

define('PERMIT_FULL_NEWS', 20);//Full quyền cho phần quản trị tin tức bao gồm các thao tác : Thêm , sửa , xóa, phê duyệt
define('PERMIT_ADD_NEWS', 21); //Thêm tin tức
define('PERMIT_EDIT_NEWS', 22); //Sửa tin tức
define('PERMIT_DELETE_NEWS', 23); //Xóa tin tức
define('PERMIT_APPROVE_NEWS', 24); //Phê duyệt tin tức



//Thong tin account
define('PERMIT_EDIT_ACCOUNT', 26); //Sửa đổi thông tin acccount mật khẩu, avatar
//Gio hang
define('PERMIT_SHOP_CART', 27); //Giỏ hàng
define('ADMIN_PERMISSION', 	53); // dungbt add them de them chuc nang phan quyen
define('ACC_NOMAL', 1);// Status của account la thanh vien thuong
define('ACC_SHOP', 2);// Status của account la gian hang

//Color mouse_hover
define('COLOR_MOUSE_HOVER', '#EBD8EB');

define('OPT_UPLOAD_IMAGE', 			0);
define('OPT_GET_IMAGE', 			1);
define('OPT_DELETE_IMAGE', 			2);

//Kieu sap xep
define('SORT_TYPE_ASC', 1); //Tăng dần
define('SORT_TYPE_DESC', 2);//Giảm dần

#BEGIN define TABLE of projects
define('TABLE_MODULE', 'module');
define('TABLE_PAGE', 'page');
define('TABLE_BLOCK', 'block');
define('TABLE_ACCOUNT', 'account');
define('TABLE_ACCOUNT_PERMIT', 'account_permit');
define('TABLE_ACCOUNT_ACTIVE', 'account_active');
define('TABLE_ACCOUNT_LOCK', 'acc_lock');
define('TABLE_CATEGORY', 'slm_category');
define('TABLE_PRODUCT', 'slm_products');
define('TABLE_CART', 'slm_cart');
define('TABLE_NEWS', 'slm_news');
define('TABLE_ADVERTISE', 'sim_adver');
define('TABLE_YAHOO', 'sim_yahoo');
define('TABLE_LOG', 'log_action');

#End define TABLE of projects
