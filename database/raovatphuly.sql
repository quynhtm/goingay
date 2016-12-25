-- phpMyAdmin SQL Dump
-- version 4.6.5.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 25, 2016 at 08:27 PM
-- Server version: 5.1.73
-- PHP Version: 5.6.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `raovatphuly`
--

-- --------------------------------------------------------

--
-- Table structure for table `group_user`
--

CREATE TABLE `group_user` (
  `group_user_id` int(11) NOT NULL COMMENT 'id nhom nguoi dung',
  `group_user_name` varchar(50) NOT NULL COMMENT 'Ten nhom nguoi dung',
  `group_user_status` int(1) NOT NULL DEFAULT '1' COMMENT '1 : hiá»‡n , 0 : áº©n',
  `group_user_type` int(1) NOT NULL DEFAULT '1' COMMENT '1:admin;2:shop'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `group_user`
--

INSERT INTO `group_user` (`group_user_id`, `group_user_name`, `group_user_status`, `group_user_type`) VALUES
(1, 'Root', 1, 1),
(2, 'Tech code', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `group_user_permission`
--

CREATE TABLE `group_user_permission` (
  `group_user_id` int(11) NOT NULL COMMENT 'id nhÃ³m',
  `permission_id` int(11) NOT NULL COMMENT 'id quyÃ¨n'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `group_user_permission`
--

INSERT INTO `group_user_permission` (`group_user_id`, `permission_id`) VALUES
(1, 1),
(2, 13),
(2, 18),
(2, 23),
(2, 28),
(2, 33),
(2, 38),
(2, 41),
(2, 42);

-- --------------------------------------------------------

--
-- Table structure for table `permission`
--

CREATE TABLE `permission` (
  `permission_id` int(11) NOT NULL,
  `permission_code` varchar(50) NOT NULL COMMENT 'MÃ£ quyá»n',
  `permission_name` varchar(50) NOT NULL COMMENT 'TÃªn quyá»n',
  `permission_status` int(1) NOT NULL DEFAULT '1' COMMENT '1:hiá»‡n , 0:áº©n',
  `permission_group_name` varchar(255) DEFAULT NULL COMMENT 'group ten controller'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `permission`
--

INSERT INTO `permission` (`permission_id`, `permission_code`, `permission_name`, `permission_status`, `permission_group_name`) VALUES
(1, 'root', 'Root', 1, 'Root'),
(2, 'user_view', 'Xem danh sách user Admin', 1, 'Tài khoản Admin'),
(3, 'user_create', 'Tạo user Admin', 1, 'Tài khoản Admin'),
(4, 'user_edit', 'Sửa user Admin', 1, 'Tài khoản Admin'),
(5, 'user_change_pass', 'Thay đổi user Admin', 1, 'Tài khoản Admin'),
(6, 'user_remove', 'Xóa user Admin', 1, 'Tài khoản Admin'),
(7, 'group_user_view', 'Xem nhóm quyền', 1, 'Nhóm quyền'),
(8, 'group_user_create', 'Tạo nhóm quyền', 1, 'Nhóm quyền'),
(9, 'group_user_edit', 'Sửa nhóm quyền', 1, 'Nhóm quyền'),
(10, 'permission_full', 'Full tạo quyền', 1, 'Tạo quyền'),
(11, 'permission_create', 'Tạo tạo quyền', 1, 'Tạo quyền'),
(12, 'permission_edit', 'Sửa tạo quyền', 1, 'Tạo quyền'),
(13, 'banner_full', 'Full quảng cáo', 1, 'Quyền quảng cáo'),
(14, 'banner_view', 'Xem quảng cáo', 1, 'Quyền quảng cáo'),
(15, 'banner_delete', 'Xóa quảng cáo', 1, 'Quyền quảng cáo'),
(16, 'banner_create', 'Tạo quảng cáo', 1, 'Quyền quảng cáo'),
(17, 'banner_edit', 'Sửa quảng cáo', 1, 'Quyền quảng cáo'),
(18, 'category_full', 'Full danh mục', 1, 'Quyền danh mục'),
(19, 'category_view', 'Xem danh mục', 1, 'Quyền danh mục'),
(20, 'category_delete', 'Xóa danh mục', 1, 'Quyền danh mục'),
(21, 'category_create', 'Tạo danh mục', 1, 'Quyền danh mục'),
(22, 'category_edit', 'Sửa danh mục', 1, 'Quyền danh mục'),
(23, 'items_full', 'Full tin rao', 1, 'Quyền tin rao'),
(24, 'items_view', 'Xem tin rao', 1, 'Quyền tin rao'),
(25, 'items_delete', 'Xóa tin rao', 1, 'Quyền tin rao'),
(26, 'items_create', 'Tạo tin rao', 1, 'Quyền tin rao'),
(27, 'items_edit', 'Sửa tin rao', 1, 'Quyền tin rao'),
(28, 'news_full', 'Full tin tức', 1, 'Quyền tin tức'),
(29, 'news_view', 'Xem tin tức', 1, 'Quyền tin tức'),
(30, 'news_delete', 'Xóa tin tức', 1, 'Quyền tin tức'),
(31, 'news_create', 'Tạo tin tức', 1, 'Quyền tin tức'),
(32, 'news_edit', 'Sửa tin tức', 1, 'Quyền tin tức'),
(33, 'province_full', 'Full tỉnh thành', 1, 'Quyền tỉnh thành'),
(34, 'province_view', 'Xem tỉnh thành', 1, 'Quyền tỉnh thành'),
(35, 'province_delete', 'Xóa tỉnh thành', 1, 'Quyền tỉnh thành'),
(36, 'province_create', 'Tạo tỉnh thành', 1, 'Quyền tỉnh thành'),
(37, 'province_edit', 'Sửa tỉnh thành', 1, 'Quyền tỉnh thành'),
(38, 'user_customer_full', 'Full khách hàng', 1, 'Quyền khách hàng'),
(39, 'user_customer_view', 'Xem khách hàng', 1, 'Quyền khách hàng'),
(40, 'user_customer_delete', 'Xóa khách hàng', 1, 'Quyền khách hàng'),
(41, 'user_customer_create', 'Tạo khách hàng', 1, 'Quyền khách hàng'),
(42, 'user_customer_edit', 'Sửa khách hàng', 1, 'Quyền khách hàng');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `user_password` varchar(255) NOT NULL,
  `user_full_name` varchar(255) NOT NULL,
  `user_email` varchar(255) DEFAULT NULL,
  `user_phone` varchar(11) DEFAULT NULL,
  `user_status` int(2) NOT NULL DEFAULT '1' COMMENT '-1: xÃ³a , 1: active',
  `user_group` varchar(255) DEFAULT NULL,
  `user_last_login` int(11) DEFAULT NULL,
  `user_last_ip` varchar(15) DEFAULT NULL,
  `user_create_id` int(11) DEFAULT NULL,
  `user_create_name` varchar(255) DEFAULT NULL,
  `user_edit_id` int(11) DEFAULT NULL,
  `user_edit_name` varchar(255) DEFAULT NULL,
  `user_created` int(11) DEFAULT NULL,
  `user_updated` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `user_name`, `user_password`, `user_full_name`, `user_email`, `user_phone`, `user_status`, `user_group`, `user_last_login`, `user_last_ip`, `user_create_id`, `user_create_name`, `user_edit_id`, `user_edit_name`, `user_created`, `user_updated`) VALUES
(2, 'admin', 'eef828faf0754495136af05c051766cb', 'Root', '', '', 1, '1', 1482671660, '116.104.82.123', NULL, NULL, 2, 'admin', NULL, 1481774382),
(19, 'tech_code', 'd4314191093057400673fa85b088a07c', 'Tech rao vặt', '', '', 1, '2', 1481774973, '117.4.252.45', NULL, NULL, 2, 'admin', NULL, 1481774790);

-- --------------------------------------------------------

--
-- Table structure for table `web_banner`
--

CREATE TABLE `web_banner` (
  `banner_id` int(11) NOT NULL,
  `banner_name` varchar(255) DEFAULT NULL,
  `banner_image` varchar(255) DEFAULT NULL,
  `banner_link` varchar(255) DEFAULT NULL,
  `banner_page` tinyint(5) DEFAULT '0' COMMENT '1: trang chủ, 2: trang list,3: trang detail, 4: trang list danh mục',
  `banner_type` tinyint(5) DEFAULT '0' COMMENT '1:banner home to, 2: banner home nhỏ,3: banner trái, 4 banner phải',
  `banner_province_id` int(11) DEFAULT '0' COMMENT 'tỉnh thành hiển thị',
  `banner_category_id` int(11) DEFAULT '0',
  `banner_order` tinyint(5) DEFAULT '1' COMMENT 'thứ tự hiển thị',
  `banner_position` tinyint(2) DEFAULT '1' COMMENT 'Vị trí hiển thị banner 1;top, 2:center,3Bottom',
  `banner_parent_id` int(11) DEFAULT '0' COMMENT 'Lưu id banner cha để lấy ảnh của banner cha hiển thị',
  `banner_is_target` tinyint(5) DEFAULT '0' COMMENT '0: Không mở tab mới, 1: mở tab mới',
  `banner_is_rel` tinyint(5) DEFAULT '0' COMMENT '0:nofollow, 1:follow',
  `banner_status` tinyint(5) DEFAULT '0',
  `banner_is_run_time` tinyint(5) DEFAULT '0' COMMENT '0: không có time chay,1: có thời gian chạy quảng cáo',
  `banner_start_time` int(11) DEFAULT '0',
  `banner_end_time` int(11) DEFAULT '0',
  `banner_total_click` int(11) DEFAULT '0' COMMENT 'lượt click banner theo id',
  `banner_create_time` int(11) DEFAULT '0',
  `banner_time_click` int(11) DEFAULT '0' COMMENT 'Time click gần nhất',
  `banner_update_time` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `web_banner`
--

INSERT INTO `web_banner` (`banner_id`, `banner_name`, `banner_image`, `banner_link`, `banner_page`, `banner_type`, `banner_province_id`, `banner_category_id`, `banner_order`, `banner_position`, `banner_parent_id`, `banner_is_target`, `banner_is_rel`, `banner_status`, `banner_is_run_time`, `banner_start_time`, `banner_end_time`, `banner_total_click`, `banner_create_time`, `banner_time_click`, `banner_update_time`) VALUES
(3, 'Linh chi Nhật An 1', '1481518205-leftbaner.png', 'http://www.namdalat.com/', 0, 3, 0, 0, 1, 3, 0, 1, 0, 1, 0, 0, 0, 0, 1478768319, 0, 1482592497),
(5, 'Siêu thị gia đình', '1482245306-banner-sieu-thi-online.png', 'http://shopcuatui.com.vn/shop-55/Sieu-thi-gia-dinh.html', 0, 1, 0, 0, 1, 1, 0, 1, 0, 1, 0, 0, 0, 0, 1480398898, 0, 1482246656),
(6, 'Spa Thảo Dược Hà Vy', '1481381830-1539779812416609192372082124512703o.jpg', 'https://www.facebook.com/spathaoduochavy/?pnref=story.unseen-section', 0, 1, 0, 0, 2, 1, 0, 1, 0, 1, 0, 0, 0, 0, 1480398920, 0, 1481384323),
(7, 'Phụ kiện thời trang', '1482246631-phu-kien.jpg', 'http://shopcuatui.com.vn/shop-70/Phu-kien-thoi-trang.html', 0, 1, 0, 0, 3, 1, 0, 1, 0, 1, 0, 0, 0, 0, 1480402071, 0, 1482555166),
(8, 'Linh chi Nhật An 2', '', 'http://www.namdalat.com/', 0, 2, 0, 0, 1, 3, 3, 1, 0, 1, 0, 0, 0, 0, 1482382207, 0, 1482599622),
(9, 'Mua sắm online - shopcuatui', '1482599717-muahangonline-3-300x156.jpg', 'http://shopcuatui.com.vn/', 0, 2, 0, 0, 1, 1, 0, 1, 0, 1, 0, 0, 0, 0, 1482554879, 0, 1482599721),
(10, 'Giảm giá tẹt ga - shopcuatui', '1482556933-3.jpg', 'http://shopcuatui.com.vn/shop-55/Sieu-thi-gia-dinh.html', 0, 2, 0, 0, 1, 2, 0, 1, 0, 1, 0, 0, 0, 0, 1482555045, 0, 1482599602),
(11, 'Mua sắm online - shopcuatui', '', 'http://shopcuatui.com.vn/', 0, 3, 0, 0, 0, 1, 9, 1, 0, 1, 0, 0, 0, 0, 1482557652, 0, 0),
(12, 'Giảm giá tẹt ga - shopcuatui', '', 'http://shopcuatui.com.vn/', 0, 3, 0, 0, 0, 1, 10, 1, 0, 0, 0, 0, 0, 0, 1482557721, 0, 1482592962);

-- --------------------------------------------------------

--
-- Table structure for table `web_category`
--

CREATE TABLE `web_category` (
  `category_id` int(10) NOT NULL,
  `category_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `category_parent_id` smallint(5) UNSIGNED DEFAULT '0',
  `category_content_front` tinyint(2) DEFAULT '0',
  `category_content_front_order` tinyint(5) DEFAULT '0' COMMENT 'vị trí hiển thị ngoài trang chủ',
  `category_status` tinyint(1) DEFAULT '0',
  `category_image_background` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `category_icons` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `category_order` tinyint(5) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=COMPACT;

--
-- Dumping data for table `web_category`
--

INSERT INTO `web_category` (`category_id`, `category_name`, `category_parent_id`, `category_content_front`, `category_content_front_order`, `category_status`, `category_image_background`, `category_icons`, `category_order`) VALUES
(253, 'Mua bán nhà đất', 0, 1, 1, 1, NULL, 'fa fa-building', 1),
(254, 'Thuê nhà đất', 0, 1, 2, 1, NULL, 'fa fa-building-o', 2),
(255, 'Ôtô', 0, 1, 3, 1, NULL, 'fa fa-car', 3),
(256, 'Xe máy - Xe đạp', 0, 1, 4, 1, NULL, 'fa fa-bicycle', 4),
(257, 'Tuyển sinh - Tuyển dụng', 0, 1, 5, 1, NULL, 'fa fa-mortar-board', 5),
(258, 'Điện thoại - Sim', 0, 1, 6, 1, NULL, 'fa fa-mobile-phone', 6),
(259, 'PC - Laptop', 0, 1, 7, 1, NULL, 'fa fa-laptop', 7),
(260, 'Điện tử - Kỹ thuật số', 0, 1, 10, 1, NULL, 'fa fa-desktop', 10),
(261, 'Thời trang - Làm đẹp', 0, 1, 9, 1, NULL, 'fa fa-child', 9),
(262, 'Ẩm thực - Du lịch', 0, 1, 8, 1, NULL, 'fa fa-cutlery', 8),
(263, 'Vật nuôi - cây cảnh', 0, 0, 11, 1, NULL, 'fa fa-pagelines', 11),
(264, 'Tin rao khác', 0, 1, 12, 1, NULL, 'fa fa-asterisk', 12);

-- --------------------------------------------------------

--
-- Table structure for table `web_click_share`
--

CREATE TABLE `web_click_share` (
  `share_id` int(11) NOT NULL,
  `object_id` int(11) DEFAULT '0' COMMENT 'banner id được click',
  `object_name` varchar(255) DEFAULT NULL,
  `share_ip` varchar(255) DEFAULT NULL COMMENT 'Địa chỉ IP click',
  `share_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `web_contact`
--

CREATE TABLE `web_contact` (
  `contact_id` int(11) NOT NULL,
  `contact_title` varchar(255) DEFAULT NULL COMMENT 'tên liên hệ',
  `contact_content` mediumtext,
  `contact_content_reply` mediumtext,
  `contact_user_id_send` int(11) DEFAULT '0' COMMENT '0: khách vãng lai gửi, > 0 shop gửi liên hệ',
  `contact_user_name_send` varchar(255) DEFAULT NULL,
  `contact_phone_send` varchar(255) DEFAULT NULL,
  `contact_email_send` varchar(255) DEFAULT NULL,
  `contact_type` tinyint(5) DEFAULT '1' COMMENT '1:loại gửi , 2: loại nhận',
  `contact_reason` tinyint(5) DEFAULT '1' COMMENT 'Lý do gửi liên hệ: 1: liên hệ ở ngoài site, 2: shop liên hệ với quản trị',
  `contact_status` tinyint(5) DEFAULT '1' COMMENT '1: liên hệ mới, 2: đã xác nhận,3: đã xử lý',
  `contact_time_creater` int(11) DEFAULT NULL,
  `contact_user_id_update` int(11) DEFAULT NULL COMMENT 'Người xử lý liên hệ',
  `contact_user_name_update` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `contact_time_update` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `web_customer`
--

CREATE TABLE `web_customer` (
  `customer_id` int(11) NOT NULL,
  `customer_name` varchar(250) DEFAULT NULL COMMENT 'Tên shop, cửa hàng hiển thị',
  `customer_password` varchar(100) DEFAULT NULL,
  `customer_phone` varchar(20) DEFAULT NULL,
  `customer_address` varchar(255) DEFAULT NULL,
  `customer_email` longtext,
  `customer_show_email` tinyint(2) DEFAULT '0' COMMENT '0: không hiển thị email, 1: có hiển thị',
  `customer_gender` tinyint(2) DEFAULT '0' COMMENT '0:nữ:1nam',
  `customer_birthday` varchar(50) DEFAULT NULL,
  `customer_province_id` int(10) DEFAULT NULL COMMENT 'tinh thanh',
  `customer_district_id` int(11) DEFAULT NULL,
  `customer_about` text COMMENT 'gioi thieu shop',
  `customer_status` tinyint(1) DEFAULT '0' COMMENT '0-an, 1-hoat dong, 2-khoa',
  `customer_time_login` int(12) DEFAULT NULL,
  `customer_time_logout` int(12) DEFAULT NULL,
  `customer_time_created` int(12) DEFAULT NULL COMMENT 'Ngày tạo',
  `customer_time_active` int(12) DEFAULT '0' COMMENT 'Ngày active',
  `is_customer` tinyint(1) DEFAULT '0' COMMENT '0-thuong, 1-vip',
  `is_login` tinyint(1) DEFAULT '0' COMMENT '0:not login, 1:login',
  `customer_id_facebook` varchar(255) DEFAULT NULL,
  `customer_id_google` varchar(255) DEFAULT NULL,
  `customer_up_item` int(11) DEFAULT '0' COMMENT 'số lượt dang tin',
  `customer_number_ontop_in_day` int(6) DEFAULT '0' COMMENT 'Số lượng ontop tin trong 1 ngày',
  `customer_number_share` int(12) DEFAULT '0' COMMENT 'lươt share',
  `customer_date_ontop` varchar(50) NOT NULL DEFAULT '0' COMMENT 'Ngày ontop tin đăng',
  `time_start_vip` int(12) DEFAULT NULL COMMENT 'Ngày bắt đầu vip',
  `time_end_vip` int(12) DEFAULT NULL COMMENT 'Ngày hết hạn vip'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `web_customer`
--

INSERT INTO `web_customer` (`customer_id`, `customer_name`, `customer_password`, `customer_phone`, `customer_address`, `customer_email`, `customer_show_email`, `customer_gender`, `customer_birthday`, `customer_province_id`, `customer_district_id`, `customer_about`, `customer_status`, `customer_time_login`, `customer_time_logout`, `customer_time_created`, `customer_time_active`, `is_customer`, `is_login`, `customer_id_facebook`, `customer_id_google`, `customer_up_item`, `customer_number_ontop_in_day`, `customer_number_share`, `customer_date_ontop`, `time_start_vip`, `time_end_vip`) VALUES
(1, 'RichPlus', '99afcc19f7ced142819fb2d355ff7b63', '0913922986 ', 'Việt Hưng - Long Biên - Hà Nội', 'nguyenduypt86@gmail.com', 0, 0, '', 22, 2, '', 1, 1480063953, 1481384925, 1478594509, 1, 1, 0, '676719779160475', NULL, 2, 1, 0, '25-11-2016', 0, 0),
(2, 'Trương Mạnh Quỳnh', NULL, '0938413368', 'Long Biên - Hà Nội', 'manhquynh1984@gmail.com', 0, 1, '13/03/1984', 22, 2, '', 1, 1480493646, 1481374834, 1480493646, 0, 1, 0, '1144001348988770', NULL, 0, 0, 0, '0', 0, 0),
(3, 'Huyền Trang', 'a42f4d67b4950249fcc7e59b5b534f59', '094.11.99.656', '483 Nguyễn Khang, Cầu Giấy, Hà Nội', 'pt.soleil@gmail.com', 1, 0, '10/10/1997', 22, 60, '', 1, 1481380369, 1482288465, 1481378591, 0, 1, 0, '251074348641723', NULL, 3, 0, 0, '0', 0, 0),
(5, 'trịnh thị Hà', '4a4214ca327be3c4aa2a43050e5135f6', '01203623686', 'số 18 bạch thái bưởi- văn quán- hà đông', 'glassrose02@gmail.com', 0, 0, NULL, 22, 113, '', 1, NULL, NULL, 1481380002, 0, 1, 0, NULL, NULL, 1, 0, 0, '0', 0, 0),
(6, 'Andy Ngô', NULL, '', '', 'ngodangduc@gmail.com', 0, 1, NULL, NULL, NULL, NULL, 1, 1481380305, NULL, 1481380305, 0, 1, 0, '1375011882509661', NULL, 0, 0, 0, '0', NULL, NULL),
(7, 'Gian Hàng Của Tôi', NULL, '0985101026', 'Long Biên - Hà Nội', 'shoponlinecuatui@gmail.com', 0, 0, '', 22, 2, 'Gọi điện trực tiếp 24h/7', 1, 1481386789, 1482303256, 1481386789, 0, 1, 0, '224652407946488', NULL, 12, 0, 0, '0', NULL, NULL),
(8, 'Anh Nguyên Bùi', NULL, '0946146565', 'Phường 11 Nam Hồ', 'trungnguyensamac@gmail.com', 0, 1, '02071985', 36, 58, 'Phường 11 Nam Hồ', 1, 1481507600, NULL, 1481507600, 0, 1, 0, '1287088004692041', NULL, 2, 0, 0, '0', NULL, NULL),
(9, 'Nguyễn Minh Đức', '274be170375b3d9641cdfd4c283a45d3', '0911580123', 'Hà Nội', 'duc.qtm@gmail.com', 0, 0, NULL, 22, 0, '', 1, 1482303334, 1482303359, 1482150523, 0, 1, 0, NULL, NULL, 0, 0, 0, '0', 0, 0),
(10, 'Mèo con', '0d59917ef526c09e88a752f63f6b4c30', '0936410887', 'Long Biên, Hà Nội', 'dieulinh10887@gmail.com', 0, 0, NULL, 0, 0, '', 1, 1482392522, NULL, 1482392342, 0, 1, 0, NULL, NULL, 0, 0, 0, '0', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `web_districts`
--

CREATE TABLE `web_districts` (
  `district_id` int(3) NOT NULL,
  `district_name` varchar(225) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `district_province_id` int(10) NOT NULL DEFAULT '0',
  `district_status` tinyint(1) NOT NULL DEFAULT '1',
  `district_position` tinyint(2) DEFAULT '50'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `web_districts`
--

INSERT INTO `web_districts` (`district_id`, `district_name`, `district_province_id`, `district_status`, `district_position`) VALUES
(1, 'Ba Đình', 22, 1, 50),
(2, 'Long Biên', 22, 1, 50),
(3, 'Sóc Sơn', 22, 1, 50),
(4, 'Đông Anh', 22, 1, 50),
(5, 'TP Thủ Dầu Một', 8, 1, 50),
(7, 'Thị xã Đồng Xoài', 10, 1, 50),
(10, 'Bến Cát', 8, 1, 50),
(12, 'Tân Uyên', 8, 1, 50),
(16, 'Thuận An', 8, 1, 50),
(18, 'TP Dĩ An', 8, 1, 50),
(20, 'Phú Giáo', 8, 1, 50),
(22, 'Dầu Tiếng', 8, 1, 50),
(28, 'Đồng Xoài', 10, 1, 50),
(31, 'Đồng Phú', 10, 1, 50),
(33, 'Chơn Thành', 10, 1, 50),
(35, 'Bình Long', 10, 1, 50),
(36, 'Lộc Ninh', 10, 1, 50),
(39, 'Bù Đốp', 10, 1, 50),
(40, 'Thành phố Phan Rang - Tháp Chàm', 41, 1, 50),
(42, 'Việt Trì', 42, 1, 50),
(43, 'Phước Long', 10, 1, 50),
(44, 'Huyện Ninh Sơn', 41, 1, 50),
(45, 'Huyện Ninh Hải', 41, 1, 50),
(46, 'Bù Đăng', 10, 1, 50),
(47, 'Huyện Ninh Phước', 41, 1, 50),
(48, 'Hớn Quản', 10, 1, 50),
(49, 'Bác Ái', 41, 1, 50),
(50, 'Bù Gia Mập', 10, 1, 50),
(51, 'Hoàn Kiếm', 22, 1, 50),
(52, 'Huyện Thuận Bắc', 41, 1, 50),
(53, 'Hai Bà Trưng', 22, 1, 50),
(54, 'Huyện Thuận Nam', 41, 1, 50),
(55, 'Đống Đa', 22, 1, 50),
(57, 'Tây Hồ', 22, 1, 50),
(58, 'Đà Lạt', 36, 1, 50),
(60, 'Cầu Giấy', 22, 1, 50),
(61, 'Bảo Lộc', 36, 1, 50),
(62, 'Thị xã Tây Ninh', 51, 1, 50),
(63, 'Thanh Xuân', 22, 1, 50),
(64, 'Huyện Tân Biên', 51, 1, 50),
(65, 'Đức Trọng', 36, 1, 50),
(66, 'Huyện Tân Châu', 51, 1, 50),
(67, 'Huyện Dương Minh Châu', 51, 1, 50),
(68, 'Di Linh', 36, 1, 50),
(69, 'Huyện Châu Thành', 51, 1, 50),
(70, 'Hoàng Mai', 22, 1, 50),
(71, 'Đơn Dương', 36, 1, 50),
(72, 'Huyện Hoà Thành', 51, 1, 50),
(73, 'Huyện Bến Cầu', 51, 1, 50),
(74, 'Lạc Dương', 36, 1, 50),
(75, 'Đoan Hùng', 42, 1, 50),
(76, 'Đạ Huoai', 36, 1, 50),
(77, 'Huyện Gò Dầu', 51, 1, 50),
(78, 'Huyện Trảng Bàng', 51, 1, 50),
(79, 'Đạ Tẻh', 36, 1, 50),
(80, 'Thanh Ba', 42, 1, 50),
(81, 'Cát Tiên', 36, 1, 50),
(83, 'Lâm Hà', 36, 1, 50),
(84, 'Thành phố Phan Thiết', 11, 1, 50),
(85, 'Huyện Tuy Phong', 11, 1, 50),
(86, 'Bảo Lâm', 36, 1, 50),
(87, 'Nam Từ Liêm', 22, 1, 50),
(88, 'Huyện Bắc Bình', 11, 1, 50),
(89, 'Đam Rông', 36, 1, 50),
(91, 'Thanh Trì', 22, 1, 50),
(92, 'Hàm Thuận Bắc', 11, 1, 50),
(93, 'Gia Lâm', 22, 1, 50),
(95, 'Hàm Thuận Nam', 11, 1, 50),
(96, 'Nha Trang', 30, 1, 50),
(97, 'Tuyên Quang', 58, 1, 50),
(98, 'Huyện Hàm Tân', 11, 1, 50),
(99, 'Vạn Ninh', 30, 1, 50),
(100, 'Huyện Đức Linh', 11, 1, 50),
(101, 'Na Hang', 58, 1, 50),
(102, 'Huyện Tánh Linh', 11, 1, 50),
(103, 'Ninh Hoà', 30, 1, 50),
(104, 'Huyện đảo Phú Quý', 11, 1, 50),
(105, 'Chiêm Hoá', 58, 1, 50),
(106, 'Thị xã La Gi', 11, 1, 50),
(107, 'Diên Khánh', 30, 1, 50),
(108, 'Hàm Yên', 58, 1, 50),
(109, 'Yên Sơn', 58, 1, 50),
(110, 'Khánh Vĩnh', 30, 1, 50),
(111, 'Cam Ranh', 30, 1, 50),
(112, 'Sơn Dương', 58, 1, 50),
(113, 'Hà Đông', 22, 1, 50),
(115, 'Khánh Sơn', 30, 1, 50),
(116, 'Sơn Tây', 22, 1, 50),
(117, 'Ba Vì', 22, 1, 50),
(118, 'Trường Sa', 30, 1, 50),
(119, 'Thành phố Biên Hoà', 17, 1, 50),
(120, 'Phúc Thọ', 22, 1, 50),
(121, 'Huyện Vĩnh Cửu', 17, 1, 50),
(122, 'Cam Lâm', 30, 1, 50),
(123, 'Thạch Thất', 22, 1, 50),
(124, 'Quốc Oai', 22, 1, 50),
(127, 'Chương Mỹ', 22, 1, 50),
(128, 'Lạng Sơn', 34, 1, 50),
(129, 'Buôn Ma Thuột', 16, 1, 50),
(130, 'Đan Phượng', 22, 1, 50),
(131, 'Tràng Định', 34, 1, 50),
(132, 'Hoài Đức', 22, 1, 50),
(133, 'Ea H Leo', 16, 1, 50),
(134, 'Bình Gia', 34, 1, 50),
(135, 'Krông Buk', 16, 1, 50),
(136, 'Thanh Oai', 22, 1, 50),
(137, 'Huyện Định Quán', 17, 1, 50),
(138, 'Văn Lãng', 34, 1, 50),
(139, 'Mỹ Đức', 22, 1, 50),
(140, 'Krông Năng', 72, 1, 50),
(141, 'Bắc Sơn', 34, 1, 50),
(142, 'Ứng Hoà', 22, 1, 50),
(143, 'Ea Súp', 16, 1, 50),
(144, 'Thống Nhất', 17, 1, 50),
(145, 'Thường Tín', 22, 1, 50),
(148, 'Phú Xuyên', 22, 1, 50),
(149, 'Văn Quan', 34, 1, 50),
(150, 'Mê Linh', 22, 1, 50),
(151, 'Thị xã Long Khánh', 17, 1, 50),
(152, 'Krông Pắc', 72, 1, 50),
(153, 'Huyện Long Thành', 17, 1, 50),
(154, 'Ea Kar', 72, 1, 50),
(155, 'Huyện Nhơn Trạch', 17, 1, 50),
(156, 'M&#39;Đrăk', 16, 1, 50),
(157, 'Huyện Trảng Bom', 17, 1, 50),
(158, 'Krông Ana', 72, 1, 50),
(160, 'Krông Bông', 72, 1, 50),
(161, 'Quận 1', 29, 1, 50),
(162, 'Cao Lộc', 34, 1, 50),
(163, 'Quận 2', 29, 1, 50),
(164, 'Lăk', 72, 1, 50),
(165, 'Quận 3', 29, 1, 50),
(166, 'Quận 4', 29, 1, 50),
(167, 'Quận 5', 29, 1, 50),
(168, 'Quận 6', 29, 1, 50),
(169, 'Lộc Bình', 34, 1, 50),
(170, 'Quận 7', 29, 1, 50),
(171, 'Chi Lăng', 34, 1, 50),
(172, 'Quận 8', 29, 1, 50),
(173, 'Đình Lập', 34, 1, 50),
(174, 'Quận 9', 29, 1, 50),
(175, 'Hữu Lũng', 34, 1, 50),
(176, 'Quận 10', 29, 1, 50),
(177, 'Quận 11', 29, 1, 50),
(178, 'Quận 12', 29, 1, 50),
(179, 'Huyện Tân Phú', 17, 1, 50),
(180, 'Gò Vấp', 29, 1, 50),
(181, 'Buôn Đôn', 72, 1, 50),
(182, 'Tân Bình', 29, 1, 50),
(183, 'Xuân Lộc', 17, 1, 50),
(185, 'Tân Phú', 29, 1, 50),
(186, 'Cẩm Mỹ', 17, 1, 50),
(187, 'Buôn Hồ', 16, 1, 50),
(188, 'Bình Thạnh', 29, 1, 50),
(189, 'Phú Nhuận', 29, 1, 50),
(191, 'Tân An', 37, 1, 50),
(192, 'Vĩnh Hưng', 37, 1, 50),
(194, 'Mộc Hoá', 37, 1, 50),
(195, 'Tuy Hoà', 43, 1, 50),
(196, 'Đồng Xuân', 43, 1, 50),
(197, 'Sông Cầu', 43, 1, 50),
(198, 'Tuy An', 43, 1, 50),
(199, 'Sơn Hoà', 43, 1, 50),
(200, 'Tân Thạnh', 37, 1, 50),
(201, 'Sông Hinh', 43, 1, 50),
(202, 'Đông Hoà', 43, 1, 50),
(203, 'Phú Hoà', 43, 1, 50),
(204, 'Đức Huệ', 37, 1, 50),
(205, 'Tây Hoà', 43, 1, 50),
(206, 'Đức Hoà', 37, 1, 50),
(207, 'Bến Lức', 37, 1, 50),
(208, 'Thủ Thừa', 37, 1, 50),
(209, 'Châu Thành', 37, 1, 50),
(212, 'Tân Trụ', 37, 1, 50),
(213, 'Thái Nguyên', 53, 1, 50),
(214, 'Sông Công', 53, 1, 50),
(215, 'Cần Đước', 37, 1, 50),
(216, 'Định Hoá', 53, 1, 50),
(217, 'Cần Giuộc', 37, 1, 50),
(218, 'Phú Lương', 53, 1, 50),
(219, 'Tân Hưng', 37, 1, 50),
(220, 'Võ Nhai', 53, 1, 50),
(222, 'Đại Từ', 53, 1, 50),
(223, 'TP Cao Lãnh', 18, 1, 50),
(224, 'Đồng Hỷ', 53, 1, 50),
(225, 'Sa Đéc', 18, 1, 50),
(226, 'Phú Bình', 53, 1, 50),
(227, 'Tân Hồng', 18, 1, 50),
(228, 'Phổ Yên', 53, 1, 50),
(229, 'Hồng Ngự', 18, 1, 50),
(230, 'Tam Nông', 18, 1, 50),
(231, 'Thanh Bình', 18, 1, 50),
(233, 'Yên Bái', 61, 1, 50),
(234, 'Lấp Vò', 18, 1, 50),
(235, 'Nghĩa Lộ', 61, 1, 50),
(236, 'Tháp Mười', 18, 1, 50),
(237, 'Văn Yên', 61, 1, 50),
(238, 'Lai Vung', 18, 1, 50),
(239, 'Pleiku', 19, 1, 50),
(240, 'Yên Bình', 61, 1, 50),
(241, 'Châu Thành', 18, 1, 50),
(242, 'Mù Cang Chải', 61, 1, 50),
(243, 'Chư Păh', 19, 1, 50),
(244, 'Văn Chấn', 61, 1, 50),
(245, 'Mang Yang', 19, 1, 50),
(246, 'Trấn Yên', 61, 1, 50),
(247, 'Kông Chro', 19, 1, 50),
(249, 'Đức Cơ', 19, 1, 50),
(250, 'Long Xuyên', 66, 1, 50),
(251, 'Châu Đốc', 66, 1, 50),
(252, 'Chư Prông', 19, 1, 50),
(253, 'Trạm Tấu', 61, 1, 50),
(254, 'An Phú', 66, 1, 50),
(255, 'Chư Sê', 19, 1, 50),
(256, 'Tân Châu', 66, 1, 50),
(257, 'Ia Grai', 19, 1, 50),
(258, 'Phú Tân', 66, 1, 50),
(259, 'Tịnh Biên', 66, 1, 50),
(260, 'Đăk Đoa', 19, 1, 50),
(261, 'Tri Tôn', 66, 1, 50),
(262, 'Ia Pa', 19, 1, 50),
(263, 'Châu Phú', 66, 1, 50),
(264, 'Đăk Pơ', 19, 1, 50),
(265, 'Chợ Mới', 66, 1, 50),
(266, 'K’Bang', 19, 1, 50),
(267, 'An Khê', 19, 1, 50),
(268, 'Ayun Pa', 19, 1, 50),
(269, 'Châu Thành', 66, 1, 50),
(270, 'Krông Pa', 19, 1, 50),
(271, 'Thủ Đức', 29, 1, 50),
(272, 'Phú Thiện', 19, 1, 50),
(273, 'Thoại Sơn', 66, 1, 50),
(274, 'Bình Tân', 29, 1, 50),
(275, 'Lục Yên', 61, 1, 50),
(276, 'Chư Pưh', 19, 1, 50),
(277, 'Bình Chánh', 29, 1, 50),
(278, 'Củ Chi', 29, 1, 50),
(280, 'Quy Nhơn', 9, 1, 50),
(281, 'Hóc Môn', 29, 1, 50),
(282, 'Nhà Bè', 29, 1, 50),
(283, 'An Lão', 9, 1, 50),
(285, 'Cần Giờ', 29, 1, 50),
(286, 'Hoài Ân', 9, 1, 50),
(287, 'Vũng Tàu', 67, 1, 50),
(288, 'Bà Rịa', 67, 1, 50),
(289, 'Hoài Nhơn', 9, 1, 50),
(290, 'Xuyên Mộc', 67, 1, 50),
(291, 'Long Điền', 67, 1, 50),
(292, 'Phù Mỹ', 9, 1, 50),
(293, 'Phù Cát', 9, 1, 50),
(294, 'Côn Đảo', 67, 1, 50),
(295, 'Vĩnh Thạnh', 9, 1, 50),
(296, 'Tân Thành', 67, 1, 50),
(297, 'Châu Đức', 67, 1, 50),
(298, 'Tây Sơn', 9, 1, 50),
(300, 'Đất Đỏ', 67, 1, 50),
(301, 'Sơn La', 50, 1, 50),
(302, 'Vân Canh', 9, 1, 50),
(303, 'Quỳnh Nhai', 50, 1, 50),
(305, 'Mường La', 50, 1, 50),
(306, 'An Nhơn', 9, 1, 50),
(307, 'Mỹ Tho', 56, 1, 50),
(308, 'Thuận Châu', 50, 1, 50),
(309, 'Tuy Phước', 9, 1, 50),
(310, 'Bắc Yên', 50, 1, 50),
(311, 'Gò Công', 56, 1, 50),
(313, 'Cái Bè', 56, 1, 50),
(314, 'Phù Yên', 50, 1, 50),
(315, 'KonTum', 32, 1, 50),
(316, 'Mai Sơn', 50, 1, 50),
(317, 'Cai Lậy', 56, 1, 50),
(318, 'Đăk Glei', 32, 1, 50),
(319, 'Yên Châu', 50, 1, 50),
(320, 'Châu Thành', 56, 1, 50),
(321, 'Ngọc Hồi', 32, 1, 50),
(322, 'Sông Mã', 50, 1, 50),
(323, 'Mộc Châu', 50, 1, 50),
(324, 'Đăk Tô', 32, 1, 50),
(325, 'Chợ Gạo', 56, 1, 50),
(326, 'Sa Thầy', 32, 1, 50),
(327, 'Sốp Cộp', 50, 1, 50),
(328, 'Gò Công Tây', 56, 1, 50),
(329, 'Kon Plong', 32, 1, 50),
(330, 'Đăk Hà', 32, 1, 50),
(331, 'Gò Công Đông', 56, 1, 50),
(332, 'Kon Rẫy', 32, 1, 50),
(333, 'Tu Mơ Rông', 32, 1, 50),
(335, 'Tân Phước', 56, 1, 50),
(337, 'Bắc Kạn', 4, 1, 50),
(339, 'Quảng Ngãi', 46, 1, 50),
(340, 'Chợ Đồn', 4, 1, 50),
(341, 'Lý Sơn', 46, 1, 50),
(342, 'Bạch Thông', 4, 1, 50),
(343, 'Bình Sơn', 46, 1, 50),
(344, 'Trà Bồng', 46, 1, 50),
(345, 'Sơn Tịnh', 46, 1, 50),
(346, 'Na Rì', 4, 1, 50),
(347, 'Sơn Hà', 46, 1, 50),
(348, 'Tân Phú Đông', 56, 1, 50),
(349, 'Tư Nghĩa', 46, 1, 50),
(350, 'Nghĩa Hành', 46, 1, 50),
(351, 'Ngân Sơn', 4, 1, 50),
(353, 'Minh Long', 46, 1, 50),
(354, 'Ba Bể', 4, 1, 50),
(355, 'Rạch Giá', 31, 1, 50),
(356, 'Chợ Mới', 4, 1, 50),
(357, 'Mộ Đức', 46, 1, 50),
(358, 'Hà Tiên', 31, 1, 50),
(359, 'Pác Nặm', 4, 1, 50),
(360, 'Đức Phổ', 46, 1, 50),
(361, 'Kiên Lương', 31, 1, 50),
(362, 'Hòn Đất', 31, 1, 50),
(363, 'Ba Tơ', 46, 1, 50),
(364, 'Phú Thọ', 42, 1, 50),
(365, 'Tân Hiệp', 31, 1, 50),
(366, 'Sơn Tây', 46, 1, 50),
(367, 'Châu Thành', 31, 1, 50),
(368, 'Tây Trà', 46, 1, 50),
(369, 'Giồng Riềng', 31, 1, 50),
(370, 'Hạ Hoà', 42, 1, 50),
(371, 'Gò Quao', 31, 1, 50),
(372, 'Cẩm Khê', 42, 1, 50),
(374, 'An Biên', 31, 1, 50),
(375, 'Yên Lập', 42, 1, 50),
(376, 'An Minh', 31, 1, 50),
(377, 'Thanh Sơn', 42, 1, 50),
(378, 'Vĩnh Thuận', 31, 1, 50),
(379, 'Tam Kỳ', 45, 1, 50),
(380, 'Phù Ninh', 42, 1, 50),
(381, 'Phú Quốc', 31, 1, 50),
(382, 'Hội An', 45, 1, 50),
(383, 'Lâm Thao', 42, 1, 50),
(384, 'Kiên Hải', 31, 1, 50),
(385, 'Tam Nông', 42, 1, 50),
(386, 'U Minh Thượng', 31, 1, 50),
(387, 'Duy Xuyên', 45, 1, 50),
(388, 'Thanh Thủy', 42, 1, 50),
(389, 'Điện Bàn', 45, 1, 50),
(390, 'Tân Sơn', 42, 1, 50),
(391, 'Giang Thành', 31, 1, 50),
(392, 'Đại Lộc', 45, 1, 50),
(394, 'Quế Sơn', 45, 1, 50),
(395, 'Ninh Kiều', 14, 1, 50),
(396, 'Hiệp Đức', 45, 1, 50),
(397, 'Bình Thuỷ', 14, 1, 50),
(398, 'Thăng Bình', 45, 1, 50),
(399, 'Cái Răng', 14, 1, 50),
(400, 'Ô Môn', 14, 1, 50),
(401, 'Núi Thành', 45, 1, 50),
(402, 'Phong Điền', 14, 1, 50),
(403, 'Tiên Phước', 45, 1, 50),
(404, 'Cờ Đỏ', 14, 1, 50),
(405, 'Bắc Trà My', 45, 1, 50),
(406, 'Vĩnh Thạnh', 14, 1, 50),
(407, 'Thốt Nốt', 14, 1, 50),
(408, 'Đông Giang', 45, 1, 50),
(409, 'Thới Lai', 14, 1, 50),
(410, 'Nam Giang', 45, 1, 50),
(412, 'Phước Sơn', 45, 1, 50),
(413, 'Nam Trà My', 45, 1, 50),
(414, 'Bến Tre', 7, 1, 50),
(415, 'Tây Giang', 45, 1, 50),
(416, 'Phú Ninh', 45, 1, 50),
(417, 'Nông Sơn', 45, 1, 50),
(418, 'Châu Thành', 7, 1, 50),
(420, 'Chợ Lách', 7, 1, 50),
(421, 'Mỏ Cày Bắc', 7, 1, 50),
(423, 'Giồng Trôm', 7, 1, 50),
(424, 'Huế', 55, 1, 50),
(425, 'Hồng Bàng', 26, 1, 50),
(426, 'Bình Đại', 7, 1, 50),
(427, 'Phong Điền', 55, 1, 50),
(428, 'Quảng Điền', 55, 1, 50),
(429, 'Ba Tri', 7, 1, 50),
(430, 'Thạnh Phú', 7, 1, 50),
(431, 'Hương Trà', 55, 1, 50),
(432, 'Mỏ Cày Nam', 7, 1, 50),
(433, 'Lê Chân', 26, 1, 50),
(434, 'Phú Vang', 55, 1, 50),
(435, 'Ngô Quyền', 26, 1, 50),
(436, 'Hương Thuỷ', 55, 1, 50),
(438, 'Kiến An', 26, 1, 50),
(439, 'Phú Lộc', 55, 1, 50),
(440, 'Vĩnh Long', 59, 1, 50),
(442, 'Long Hồ', 59, 1, 50),
(443, 'Nam Đông', 55, 1, 50),
(444, 'Hải An', 26, 1, 50),
(445, 'Mang Thít', 59, 1, 50),
(446, 'A Lưới', 55, 1, 50),
(447, 'Đồ Sơn', 26, 1, 50),
(448, 'Bình Minh', 59, 1, 50),
(449, 'An Lão', 26, 1, 50),
(450, 'Tam Bình', 59, 1, 50),
(452, 'Kiến Thụy', 26, 1, 50),
(453, 'Trà Ôn', 59, 1, 50),
(454, 'Đông Hà', 48, 1, 50),
(455, 'Thủy Nguyên', 26, 1, 50),
(456, 'An Dương', 26, 1, 50),
(458, 'Tiên Lãng', 26, 1, 50),
(459, 'Vĩnh Linh', 48, 1, 50),
(460, 'Vĩnh Bảo', 26, 1, 50),
(461, 'Gio Linh', 48, 1, 50),
(462, 'Cam Lộ', 48, 1, 50),
(463, 'Triệu Phong', 48, 1, 50),
(464, 'Hải Lăng', 48, 1, 50),
(465, 'Hướng Hoá', 48, 1, 50),
(466, 'Đăk Rông', 48, 1, 50),
(467, 'Cồn Cỏ', 48, 1, 50),
(469, 'Đồng Hới', 44, 1, 50),
(470, 'Vũng Liêm', 59, 1, 50),
(471, 'Tuyên Hoá', 44, 1, 50),
(472, 'Bình Tân', 59, 1, 50),
(473, 'Minh Hoá', 44, 1, 50),
(474, 'Quảng Trạch', 44, 1, 50),
(476, 'Trà Vinh', 57, 1, 50),
(477, 'Bố Trạch', 44, 1, 50),
(478, 'Càng Long', 57, 1, 50),
(479, 'Cầu Kè', 57, 1, 50),
(480, 'Quảng Ninh', 44, 1, 50),
(481, 'Tiểu Cần', 57, 1, 50),
(482, 'Lệ Thuỷ', 44, 1, 50),
(483, 'Châu Thành', 57, 1, 50),
(484, 'Trà Cú', 57, 1, 50),
(485, 'Cầu Ngang', 57, 1, 50),
(487, 'Duyên Hải', 57, 1, 50),
(488, 'Hà Tĩnh', 24, 1, 50),
(489, 'Hồng Lĩnh', 24, 1, 50),
(490, 'Cát Hải', 26, 1, 50),
(492, 'Hương Sơn', 24, 1, 50),
(493, 'Sóc Trăng', 49, 1, 50),
(494, 'Bạch Long Vĩ', 26, 1, 50),
(495, 'Đức Thọ', 24, 1, 50),
(496, 'Mỹ Xuyên', 49, 1, 50),
(497, 'Dương Kinh', 26, 1, 50),
(498, 'Thạnh Trị', 49, 1, 50),
(499, 'Nghi Xuân', 24, 1, 50),
(500, 'Can Lộc', 24, 1, 50),
(501, 'Cù Lao Dung', 49, 1, 50),
(502, 'Ngã Năm', 49, 1, 50),
(503, 'Hương Khê', 24, 1, 50),
(505, 'Thạch Hà', 24, 1, 50),
(506, 'Kế Sách', 49, 1, 50),
(507, 'Cẩm Xuyên', 24, 1, 50),
(508, 'Mỹ Tú', 49, 1, 50),
(509, 'Thị Xã Kỳ Anh', 24, 1, 50),
(510, 'Hải Châu', 15, 1, 50),
(511, 'Long Phú', 49, 1, 50),
(512, 'Vũ Quang', 24, 1, 50),
(513, 'Vĩnh Châu', 49, 1, 50),
(514, 'Thanh Khê', 15, 1, 50),
(515, 'Lộc Hà', 24, 1, 50),
(516, 'Châu Thành', 49, 1, 50),
(517, 'Sơn Trà', 15, 1, 50),
(518, 'Trần Đề', 49, 1, 50),
(519, 'Ngũ Hành Sơn', 15, 1, 50),
(521, 'Liên Chiểu', 15, 1, 50),
(522, 'Vinh', 39, 1, 50),
(524, 'Hoà Vang', 15, 1, 50),
(525, 'Cửa Lò', 39, 1, 50),
(526, 'Bạc Liêu', 3, 1, 50),
(527, 'Vĩnh Lợi', 3, 1, 50),
(528, 'Quỳ Châu', 39, 1, 50),
(529, 'Hồng Dân', 3, 1, 50),
(530, 'Quỳ Hợp', 39, 1, 50),
(531, 'Giá Rai', 3, 1, 50),
(532, 'Nghĩa Đàn', 39, 1, 50),
(533, 'Cẩm Lệ', 15, 1, 50),
(534, 'Phước Long', 3, 1, 50),
(535, 'Quỳnh Lưu', 39, 1, 50),
(536, 'Đông Hải', 3, 1, 50),
(537, 'Kỳ Sơn', 39, 1, 50),
(538, 'Hoà Bình', 3, 1, 50),
(539, 'Tương Dương', 39, 1, 50),
(540, 'Con Cuông', 39, 1, 50),
(542, 'Tân Kỳ', 39, 1, 50),
(543, 'Yên Thành', 39, 1, 50),
(544, 'Diễn Châu', 39, 1, 50),
(545, 'Anh Sơn', 39, 1, 50),
(546, 'Đô Lương', 39, 1, 50),
(547, 'Thanh Chương', 39, 1, 50),
(548, 'Nghi Lộc', 39, 1, 50),
(549, 'Đồng Văn', 20, 1, 50),
(550, 'Mèo Vạc', 20, 1, 50),
(551, 'Nam Đàn', 39, 1, 50),
(553, 'Yên Minh', 20, 1, 50),
(554, 'Hưng Nguyên', 39, 1, 50),
(555, 'Quản Bạ', 20, 1, 50),
(556, 'Vị Xuyên', 20, 1, 50),
(557, 'Quế Phong', 39, 1, 50),
(558, 'Bắc Mê', 20, 1, 50),
(559, 'Thị xã Thái Hòa', 39, 1, 50),
(560, 'Hoàng Su Phì', 20, 1, 50),
(561, 'Cà Mau', 12, 1, 50),
(563, 'Xín Mần', 20, 1, 50),
(564, 'Thới Bình', 12, 1, 50),
(565, 'Thanh Hoá', 54, 1, 50),
(566, 'U Minh', 12, 1, 50),
(567, 'Bắc Quang', 20, 1, 50),
(568, 'Bỉm Sơn', 54, 1, 50),
(569, 'Trần Văn Thời', 12, 1, 50),
(570, 'Sầm Sơn', 54, 1, 50),
(571, 'Quang Bình', 20, 1, 50),
(572, 'Cái Nước', 12, 1, 50),
(573, 'Quan Hoá', 54, 1, 50),
(574, 'Quan Sơn', 54, 1, 50),
(575, 'Mường Lát', 54, 1, 50),
(577, 'Bá Thước', 54, 1, 50),
(578, 'Cao Bằng', 13, 1, 50),
(579, 'Thường Xuân', 54, 1, 50),
(580, 'Bảo Lạc', 13, 1, 50),
(581, 'Thông Nông', 13, 1, 50),
(582, 'Như Xuân', 54, 1, 50),
(583, 'Như Thanh', 54, 1, 50),
(584, 'Lang Chánh', 54, 1, 50),
(585, 'Ngọc Lặc', 54, 1, 50),
(586, 'Thạch Thành', 54, 1, 50),
(587, 'Cẩm Thủy', 54, 1, 50),
(588, 'Hà Quảng', 13, 1, 50),
(589, 'Thọ Xuân', 54, 1, 50),
(590, 'Trà Lĩnh', 13, 1, 50),
(591, 'Vĩnh Lộc', 54, 1, 50),
(592, 'Thiệu Hoá', 54, 1, 50),
(593, 'Triệu Sơn', 54, 1, 50),
(594, 'Đầm Dơi', 12, 1, 50),
(595, 'Nông Cống', 54, 1, 50),
(596, 'Ngọc Hiển', 12, 1, 50),
(597, 'Đông Sơn', 54, 1, 50),
(598, 'Năm Căn', 12, 1, 50),
(599, 'Hà Trung', 54, 1, 50),
(600, 'Phú Tân', 12, 1, 50),
(601, 'Hoằng Hoá', 54, 1, 50),
(603, 'Nga Sơn', 54, 1, 50),
(604, 'Điện Biên Phủ', 69, 1, 1),
(605, 'Hậu Lộc', 54, 1, 50),
(606, 'Mường Lay', 69, 1, 2),
(607, 'Quảng Xương', 54, 1, 50),
(608, 'Điện Biên', 69, 1, 50),
(609, 'Tĩnh Gia', 54, 1, 50),
(610, 'Tuần Giáo', 69, 1, 50),
(611, 'Yên Định', 54, 1, 50),
(612, 'Trùng Khánh', 13, 1, 50),
(613, 'Mường Chà', 69, 1, 50),
(614, 'Tủa Chùa', 69, 1, 50),
(615, 'Nguyên Bình', 13, 1, 50),
(616, 'Điện Biên Đông', 69, 1, 50),
(618, 'Mường Nhé', 69, 1, 50),
(619, 'Thành phố Ninh Bình', 40, 1, 50),
(620, 'Mường Ảng', 69, 1, 50),
(622, 'Tam Điệp', 40, 1, 50),
(623, 'Nho Quan', 40, 1, 50),
(624, 'Gia Viễn', 40, 1, 50),
(625, 'Hoa Lư', 40, 1, 50),
(626, 'Yên Mô', 40, 1, 50),
(628, 'Kim Sơn', 40, 1, 50),
(629, 'Gia Nghĩa', 71, 1, 50),
(630, 'Yên Khánh', 40, 1, 50),
(631, 'Dăk RLấp', 71, 1, 50),
(632, 'Dăk Mil', 71, 1, 50),
(633, 'Cư Jút', 71, 1, 50),
(635, 'Hoà An', 13, 1, 50),
(636, 'Dăk Song', 71, 1, 50),
(637, 'Thái Bình', 52, 1, 50),
(638, 'Quảng Uyên', 13, 1, 50),
(639, 'Krông Nô', 71, 1, 50),
(640, 'Thạch An', 13, 1, 50),
(641, 'Quỳnh Phụ', 52, 1, 50),
(642, 'Dăk GLong', 71, 1, 50),
(643, 'Hạ Lang', 13, 1, 50),
(644, 'Hưng Hà', 52, 1, 50),
(645, 'Tuy Đức', 71, 1, 50),
(646, 'Bảo Lâm', 13, 1, 50),
(647, 'Đông Hưng', 52, 1, 50),
(648, 'Phục Hoà', 13, 1, 50),
(649, 'Vũ Thư', 52, 1, 50),
(651, 'Kiến Xương', 52, 1, 50),
(652, 'Vị Thanh', 70, 1, 50),
(654, 'Vị Thuỷ', 70, 1, 50),
(655, 'Tiền Hải', 52, 1, 50),
(656, 'Lai Châu', 33, 1, 50),
(657, 'Long Mỹ', 70, 1, 50),
(658, 'Thái Thuỵ', 52, 1, 50),
(659, 'Phụng Hiệp', 70, 1, 50),
(660, 'Tam Đường', 33, 1, 50),
(661, 'Châu Thành', 70, 1, 50),
(662, 'Phong Thổ', 33, 1, 50),
(663, 'Châu Thành A', 70, 1, 50),
(665, 'Sìn Hồ', 33, 1, 50),
(666, 'Ngã Bảy', 70, 1, 50),
(667, 'Nam Định', 38, 1, 50),
(668, 'Mường Tè', 33, 1, 50),
(669, 'Mỹ Lộc', 38, 1, 50),
(670, 'Than Uyên', 33, 1, 50),
(671, 'Xuân Trường', 38, 1, 50),
(672, 'Tân Uyên', 33, 1, 50),
(673, 'Giao Thủy', 38, 1, 50),
(674, 'Ý Yên', 38, 1, 50),
(676, 'Vụ Bản', 38, 1, 50),
(677, 'Lào Cai', 35, 1, 50),
(678, 'Nam Trực', 38, 1, 50),
(679, 'Xi Ma Cai', 35, 1, 50),
(680, 'Trực Ninh', 38, 1, 50),
(681, 'Bát Xát', 35, 1, 50),
(682, 'Nghĩa Hưng', 38, 1, 50),
(683, 'Bảo Thắng', 35, 1, 50),
(684, 'Hải Hậu', 38, 1, 50),
(685, 'Sa Pa', 35, 1, 50),
(686, 'Văn Bàn', 35, 1, 50),
(688, 'Phủ Lý', 21, 1, 50),
(689, 'Duy Tiên', 21, 1, 50),
(690, 'Bảo Yên', 35, 1, 50),
(691, 'Kim Bảng', 21, 1, 50),
(692, 'Bắc Hà', 35, 1, 50),
(693, 'Lý Nhân', 21, 1, 50),
(694, 'Mường Khương', 35, 1, 50),
(695, 'Thanh Liêm', 21, 1, 50),
(696, 'Bình Lục', 21, 1, 50),
(698, 'Hoà Bình', 27, 1, 50),
(699, 'Đà Bắc', 27, 1, 50),
(700, 'Mai Châu', 27, 1, 50),
(701, 'Tân Lạc', 27, 1, 50),
(702, 'Lạc Sơn', 27, 1, 50),
(703, 'Kỳ Sơn', 27, 1, 50),
(704, 'Lương Sơn', 27, 1, 50),
(705, 'Kim Bôi', 27, 1, 50),
(706, 'Lạc Thuỷ', 27, 1, 50),
(707, 'Yên Thuỷ', 27, 1, 50),
(708, 'Cao Phong', 27, 1, 50),
(710, 'Hưng Yên', 28, 1, 50),
(711, 'Kim Động', 28, 1, 50),
(712, 'Ân Thi', 28, 1, 50),
(713, 'Khoái Châu', 28, 1, 50),
(714, 'Yên Mỹ', 28, 1, 50),
(715, 'Tiên Lữ', 28, 1, 50),
(716, 'Phù Cừ', 28, 1, 50),
(717, 'Mỹ Hào', 28, 1, 50),
(718, 'Văn Lâm', 28, 1, 50),
(719, 'Văn Giang', 28, 1, 50),
(721, 'Hải Dương', 25, 1, 50),
(722, 'Chí Linh', 25, 1, 50),
(723, 'Nam Sách', 25, 1, 50),
(724, 'Kinh Môn', 25, 1, 50),
(725, 'Gia Lộc', 25, 1, 50),
(726, 'Tứ Kỳ', 25, 1, 50),
(727, 'Thanh Miện', 25, 1, 50),
(728, 'Ninh Giang', 25, 1, 50),
(729, 'Cẩm Giàng', 25, 1, 50),
(730, 'Thanh Hà', 25, 1, 50),
(731, 'Kim Thành', 25, 1, 50),
(732, 'Bình Giang', 25, 1, 50),
(734, 'Bắc Ninh', 6, 1, 50),
(735, 'Yên Phong', 6, 1, 50),
(736, 'Quế Võ', 6, 1, 50),
(737, 'Tiên Du', 6, 1, 50),
(738, 'Từ  Sơn', 6, 1, 50),
(739, 'Thuận Thành', 6, 1, 50),
(740, 'Gia Bình', 6, 1, 50),
(741, 'Lương Tài', 6, 1, 50),
(743, 'Bắc Giang', 5, 1, 50),
(744, 'Yên Thế', 5, 1, 50),
(745, 'Lục Ngạn', 5, 1, 50),
(746, 'Sơn Động', 5, 1, 50),
(747, 'Lục Nam', 5, 1, 50),
(748, 'Tân Yên', 5, 1, 50),
(749, 'Hiệp Hoà', 5, 1, 50),
(750, 'Lạng Giang', 5, 1, 50),
(751, 'Việt Yên', 5, 1, 50),
(752, 'Yên Dũng', 5, 1, 50),
(754, 'Hạ Long', 47, 1, 50),
(755, 'Cẩm Phả', 47, 1, 50),
(756, 'Uông Bí', 47, 1, 50),
(757, 'Móng Cái', 47, 1, 50),
(758, 'Bình Liêu', 47, 1, 50),
(759, 'Đầm Hà', 47, 1, 50),
(760, 'Hải Hà', 47, 1, 50),
(761, 'Tiên Yên', 47, 1, 50),
(762, 'Ba Chẽ', 47, 1, 50),
(763, 'Đông Triều', 47, 1, 50),
(764, 'Yên Hưng', 47, 1, 50),
(765, 'Hoành Bồ', 47, 1, 50),
(766, 'Vân Đồn', 47, 1, 50),
(767, 'Cô Tô', 47, 1, 50),
(769, 'Vĩnh Yên', 60, 1, 50),
(770, 'Tam Dương', 60, 1, 50),
(771, 'Lập Thạch', 60, 1, 50),
(772, 'Vĩnh Tường', 60, 1, 50),
(773, 'Yên Lạc', 60, 1, 50),
(774, 'Bình Xuyên', 60, 1, 50),
(775, 'Sông Lô', 60, 1, 50),
(776, 'Phúc Yên', 60, 1, 50),
(777, 'Tam Đảo', 60, 1, 50),
(778, 'Thành phố Nha Trang', 68, 1, 50),
(779, 'Huyện Vạn Ninh', 68, 1, 50),
(780, 'Huyện Ninh Hoà', 68, 1, 50),
(781, 'Huyện Diên Khánh', 68, 1, 50),
(782, 'Huyện Khánh Vĩnh', 68, 1, 50),
(783, 'Thị xã Cam Ranh', 68, 1, 50),
(784, 'Huyện Khánh Sơn', 68, 1, 50),
(785, 'Huyện đảo Trường Sa', 68, 1, 50),
(786, 'Huyện Cam Lâm', 68, 1, 50),
(787, 'Hoàng Sa', 15, 1, 50),
(789, 'Ban Mê Thuột', 72, 1, 50),
(790, 'Lạc Thiện', 72, 1, 50),
(791, 'Đắk Song', 72, 1, 50),
(792, 'Buôn Hồ', 72, 1, 50),
(793, 'M&#39;Đrak', 72, 1, 50),
(794, 'Phường Vĩnh Hải', 68, 1, 50),
(795, 'Phường Vĩnh Phước', 68, 1, 50),
(796, 'Phường Vĩnh Thọ', 68, 1, 50),
(797, 'Phường Xương Huân', 68, 1, 50),
(798, 'Phường Vạn Thắng', 68, 1, 50),
(799, 'Phường Vạn Thạnh', 68, 1, 50),
(800, 'Phường Phương Sài', 68, 1, 50),
(801, 'Phường Phương Sơn', 68, 1, 50),
(802, 'Phường Ngọc Hiệp', 68, 1, 50),
(803, 'Phường Phước Hoà', 68, 1, 50),
(804, 'Phường Phước Tân', 68, 1, 50),
(805, 'Phường Phước Tiến', 68, 1, 50),
(806, 'Phường Phước Hải', 68, 1, 50),
(807, 'Phường Lộc Thọ', 68, 1, 50),
(808, 'Phường Tân Lập', 68, 1, 50),
(809, 'Phường Vĩnh Nguyên', 68, 1, 50),
(810, 'Phường Vĩnh Trường', 68, 1, 50),
(811, 'Phường Phước Long', 68, 1, 50),
(812, 'Phường Vĩnh Hoà', 68, 1, 50),
(813, 'Phường 1', 67, 1, 50),
(814, 'Phường 2', 67, 1, 50),
(815, 'Phường 3', 67, 1, 50),
(816, 'Phường 4', 67, 1, 50),
(817, 'Phường 5', 67, 1, 50),
(818, 'Phường 6', 67, 1, 50),
(819, 'Phường 7', 67, 1, 50),
(820, 'Phường 8', 67, 1, 50),
(821, 'Phường 9', 67, 1, 50),
(822, 'Phường 10', 67, 1, 50),
(823, 'Phường 11', 67, 1, 50),
(824, 'Phường 12', 67, 1, 50),
(827, 'Bắc Từ Liêm', 22, 1, 50),
(829, 'Bàu Bàng', 8, 1, 50),
(831, 'Bắc Tân Uyên', 8, 1, 50),
(833, 'Cư M&#39;gaR', 72, 1, 50),
(835, 'Cư Kuin', 72, 1, 50),
(837, 'Ea H&#39;leo', 72, 1, 50),
(839, 'Thạch Hóa', 37, 1, 50),
(841, 'Kiến Tường', 37, 1, 50),
(843, 'Thị xã Ba Đồn', 44, 1, 50),
(845, 'Thành phố Hà Giang', 20, 1, 50),
(847, 'Nậm Nhùm', 33, 1, 50),
(849, 'Huyện Cao Lãnh', 18, 1, 50),
(851, 'Thị xã Quảng Trị', 48, 1, 50),
(853, 'Thị xã Hoàng Mai', 39, 1, 50),
(855, 'Thị xã Quảng Yên', 47, 1, 50),
(857, 'Lâm Bình', 58, 1, 50),
(859, 'Huyện Kỳ Anh', 24, 1, 50);

-- --------------------------------------------------------

--
-- Table structure for table `web_info`
--

CREATE TABLE `web_info` (
  `info_id` int(11) NOT NULL,
  `uid` int(11) DEFAULT NULL,
  `info_title` varchar(255) DEFAULT NULL,
  `info_keyword` varchar(255) DEFAULT NULL COMMENT 'keyword',
  `info_intro` longtext,
  `info_content` longtext,
  `info_img` varchar(255) DEFAULT NULL,
  `info_created` varchar(15) DEFAULT NULL,
  `info_order_no` int(11) DEFAULT '0',
  `info_status` tinyint(4) DEFAULT '0' COMMENT 'Item enabled status (1 = enabled, 0 = disabled)',
  `meta_title` text COMMENT 'Meta title',
  `meta_keywords` text COMMENT 'Meta keywords',
  `meta_description` text COMMENT 'Meta description'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Stores news content.';

--
-- Dumping data for table `web_info`
--

INSERT INTO `web_info` (`info_id`, `uid`, `info_title`, `info_keyword`, `info_intro`, `info_content`, `info_img`, `info_created`, `info_order_no`, `info_status`, `meta_title`, `meta_keywords`, `meta_description`) VALUES
(1, NULL, 'Thông tin chân trang bên trái', 'SITE_FOOTER_LEFT', '', '<p><strong>T&ecirc;n đăng k&yacute;: </strong>C&ocirc;ng ty Cổ truyền th&ocirc;ng raovat30s</p>\\r\\n\\r\\n<p><strong>T&ecirc;n giao dịch: </strong>Raovat30s Online JSC</p>\\r\\n\\r\\n<p><strong>Địa chỉ trụ sở: </strong>Tầng 2, T&ograve;a nh&agrave; CT2A - KĐT Nghĩa Đ&ocirc;, Ho&agrave;ng Quốc Việt, Cầu Giấy, H&agrave; Nội.</p>\\r\\n\\r\\n<p><strong>Điện thoại: </strong>0913.922.986</p>\\r\\n\\r\\n<p><strong>Email: </strong>raovat@raovat30s.vn</p>\\r\\n\\r\\n<p><strong>Giấy chứng nhận đăng k&yacute; kinh doanh số 0305056245 do Sở Kế hoạch v&agrave; Đầu tư Th&agrave;nh phố H&agrave; Nội cấp ng&agrave;y 22/12/2016</strong></p>\\r\\n\\r\\n<p>&nbsp;</p>\\r\\n', '', '1447794727', 1, 0, '', '', ''),
(2, NULL, 'Thông tin giới thiệu', 'SITE_INTRO', '', '', NULL, '1441430611', 1, 1, '', '', ''),
(9, NULL, 'Nội dung meta SEO trang chủ', 'SITE_SEO_HOME', '', '<p>Kh&ocirc;ng cần để nội dung...</p>\\r\\n', '1482386969-default.jpg', '1437450080', 1, 1, 'Raovat30s.vn', 'Raovat30s.vn: Rao vặt, mua bán nhà đất, máy tính, máy tính xách tay, laptop, điện tử, kỹ thuật số, sim, xe máy, xe đạp, ôtô, điện lạnh, điện máy, mua sắm, nội thất, thuê, cho thuê, thời trang, mỹ phẩm, dịch vụ, dịch vụ tận nhà, dịch vụ doanh nghiệp, dịch vụ cá nhân, lao động, lao động phổ thông, lao động trí óc, du lịch, cơ hội giao thương, giao thương, tổng hợp', 'Raovat30s.vn: Rao vặt toàn quốc miễn phí đăng tin, lượt up top tin');

-- --------------------------------------------------------

--
-- Table structure for table `web_items`
--

CREATE TABLE `web_items` (
  `item_id` int(11) NOT NULL,
  `item_name` varchar(255) DEFAULT NULL,
  `item_type_action` tinyint(1) DEFAULT '1' COMMENT '1: Cần bán/ Tuyển sinh, 2:Cần mua/ Tuyển dụng',
  `item_type_price` tinyint(2) DEFAULT '0' COMMENT '0:liên hệ, 1:có giá bán',
  `item_price_sell` int(11) DEFAULT '0' COMMENT 'Giá bán',
  `item_area_price` int(11) DEFAULT '0' COMMENT 'Khoảng giá của tin đăng',
  `item_content` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci COMMENT 'nội dung sản phẩm',
  `item_image` varchar(255) DEFAULT NULL COMMENT 'ảnh SP chính ',
  `item_image_other` longtext COMMENT 'danh sach ảnh khác',
  `item_category_id` int(11) DEFAULT NULL COMMENT 'danh mục tin',
  `item_category_name` varchar(255) DEFAULT NULL,
  `item_category_parent_id` int(11) DEFAULT '100' COMMENT 'danh mục cha',
  `item_category_parent_name` varchar(255) DEFAULT '0',
  `item_number_view` int(11) DEFAULT '0' COMMENT 'Lượt xem',
  `item_status` tinyint(5) DEFAULT '1' COMMENT '0:ẩn, 1:hiện,',
  `item_is_hot` tinyint(5) DEFAULT '0' COMMENT '0: tin thường, 1: tin nổi bật, 2',
  `item_block` tinyint(5) DEFAULT '1' COMMENT '0: bị khóa, 1: không bị khóa',
  `item_province_id` int(10) DEFAULT '0' COMMENT 'tỉnh thành đăng tin',
  `item_province_name` varchar(50) DEFAULT NULL,
  `item_district_id` int(10) DEFAULT '0' COMMENT 'Quân./huyện',
  `item_district_name` varchar(50) DEFAULT NULL,
  `customer_id` int(11) DEFAULT '0' COMMENT 'id khách đăng tin',
  `customer_name` varchar(255) DEFAULT NULL COMMENT 'Tên khách đăng tin',
  `is_customer` tinyint(5) DEFAULT '0' COMMENT '0:tin thường, 1: tin vip',
  `time_ontop` int(11) DEFAULT '0' COMMENT 'thời gian để ontop tin',
  `time_created` int(11) DEFAULT '0',
  `time_update` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `web_items`
--

INSERT INTO `web_items` (`item_id`, `item_name`, `item_type_action`, `item_type_price`, `item_price_sell`, `item_area_price`, `item_content`, `item_image`, `item_image_other`, `item_category_id`, `item_category_name`, `item_category_parent_id`, `item_category_parent_name`, `item_number_view`, `item_status`, `item_is_hot`, `item_block`, `item_province_id`, `item_province_name`, `item_district_id`, `item_district_name`, `customer_id`, `customer_name`, `is_customer`, `time_ontop`, `time_created`, `time_update`) VALUES
(1, 'Sở hữu căn hộ đẹp nhất Hà Nội chỉ từ 1,8 tỷ', 1, 1, 1800000000, 0, '<div class=\"width_common box_category\">\\r\\n<div class=\"fck_detail width_common\">\\r\\n<p>HOTLINE: 0902.138.985 - 0981.555.638 (Ms Thu - Ph&ograve;ng B&aacute;n h&agrave;ng dự &aacute;n Imperial Plaza - 360 Giải Ph&oacute;ng)</p>\\r\\n\\r\\n<p><strong>Chi tiết dự &aacute;n:</strong></p>\\r\\n\\r\\n<p>Dự &aacute;n IMPERIAL PLAZA &ndash; 360 Giải Ph&oacute;ng c&oacute; c&aacute;c căn hộ diện t&iacute;ch: từ 62m2 đến 134m2&nbsp;(từ 2 đến 4&nbsp;ph&ograve;ng ngủ)</p>\\r\\n\\r\\n<p>&nbsp;</p>\\r\\n\\r\\n<table align=\"center\" border=\"0\" cellpadding=\"3\" cellspacing=\"0\" class=\"tplCaption\">\\r\\n	<tbody>\\r\\n		<tr>\\r\\n			<td><img alt=\"\" src=\"http://img.f4.raovat.vnecdn.net/images/2016/11/29/583d3d2e9850e-Ph-i-c-nh-Imperial-plaza_600x0.jpg\" /></td>\\r\\n		</tr>\\r\\n	</tbody>\\r\\n</table>\\r\\n\\r\\n<p>&nbsp;</p>\\r\\n\\r\\n<p>&nbsp;</p>\\r\\n\\r\\n<p>Gi&aacute; b&aacute;n từ 25.5 triệu/m2 (Gồm VAT v&agrave; b&agrave;n giao nội thất cơ bản).</p>\\r\\n\\r\\n<p>Ng&acirc;n h&agrave;ng t&agrave;i trợ vốn: PVCombank hỗ trợ l&atilde;i suất 6,9% trong 12 th&aacute;ng, tối đa 85% gi&aacute; trị căn hộ trong thời gian 20 năm.</p>\\r\\n\\r\\n<p>&nbsp;</p>\\r\\n\\r\\n<table align=\"center\" border=\"0\" cellpadding=\"3\" cellspacing=\"0\" class=\"tplCaption\">\\r\\n	<tbody>\\r\\n		<tr>\\r\\n			<td><img alt=\"\" src=\"http://img.f2.raovat.vnecdn.net/images/2016/11/29/583d3d91b8ae1-H-nh-nh-c-n-h-m-u_600x0.JPG\" /></td>\\r\\n		</tr>\\r\\n	</tbody>\\r\\n</table>\\r\\n\\r\\n<p>&nbsp;</p>\\r\\n\\r\\n<p><strong><span style=\"font-family:arial,sans-serif; font-size:9pt\">I. Tổng quan dự &aacute;n Imperial Plaza</span></strong><br />\\r\\n<span style=\"font-family:arial,sans-serif; font-size:9pt\">- Chủ đầu tư: C&ocirc;ng ty Cổ phần Tập đo&agrave;n Đầu tư v&agrave; Thương mại Thăng Long (TINCOM)</span></p>\\r\\n\\r\\n<p><span style=\"font-family:arial,sans-serif; font-size:9pt\">- C&ocirc;ng ty thiết kế: C&ocirc;ng ty Cổ phần Ecoland.</span></p>\\r\\n\\r\\n<p><span style=\"font-family:arial,sans-serif; font-size:9pt\">- Đơn vị thi c&ocirc;ng: C&ocirc;ng ty CP đầu tư v&agrave; x&acirc;y dựng Xu&acirc;n Mai.<br />\\r\\n- Tổng diện t&iacute;ch đất: 36.702m2.<br />\\r\\n- Năm ho&agrave;n th&agrave;nh: Dự kiến qu&yacute; IV/2017.</span></p>\\r\\n\\r\\n<p>Dự &aacute;n chung cư Imperial Plaza 360&nbsp;Giải Ph&oacute;ng gồm tổ hợp 3 t&ograve;a nh&agrave; ở cao tầng kết hợp thương mại dịch vụ, văn ph&ograve;ng với chiều cao 29 tầng, 3 tầng hầm.</p>\\r\\n\\r\\n<p>Trong đ&oacute;, dự kiến ra mắt t&ograve;a IP3 v&agrave;o đầu th&aacute;ng 12 - t&ograve;a Hoa kh&ocirc;i của dự &aacute;n với chiều&nbsp;cao 29 tầng. Trong đ&oacute;:<br />\\r\\n- Tầng 1: Khu vực lễ t&acirc;n, dịch vụ, si&ecirc;u thị, trung t&acirc;m thương mại.<br />\\r\\n- Tầng 2: Ph&ograve;ng sinh hoạt cộng đồng v&agrave; quản l&yacute; t&ograve;a nh&agrave;.<br />\\r\\n- Tầng 3: Khu chức năng dịch vụ: Gym, spa, khu vui chơi trẻ em,...<br />\\r\\n- Tầng 5-7: Bố tr&iacute; chức năng văn ph&ograve;ng.<br />\\r\\n- Tầng 8-29 bố tr&iacute; c&aacute;c căn hộ để ở: 220 căn hộ.</p>\\r\\n\\r\\n<p><strong>II. Tiện &iacute;ch vượt trội của Imperial Plaza</strong><br />\\r\\nChung cư Imperial Plaza &ndash; 360 Giải Ph&oacute;ng: Với gần 30 tiện &iacute;ch cảnh quan v&agrave; dịch vụ đa dạng, phong ph&uacute;, chắc chắn sẽ đảm bảo cho to&agrave;n bộ cư d&acirc;n nơi đ&acirc;y một kh&ocirc;ng gian sống ho&agrave;n mỹ.</p>\\r\\n\\r\\n<p>&nbsp;</p>\\r\\n\\r\\n<table align=\"center\" border=\"0\" cellpadding=\"3\" cellspacing=\"0\" class=\"tplCaption\">\\r\\n	<tbody>\\r\\n		<tr>\\r\\n			<td><img alt=\"\" src=\"http://img.f2.raovat.vnecdn.net/images/2016/11/29/583d3dc592ff7-ti-n-ch_600x0.png\" /></td>\\r\\n		</tr>\\r\\n	</tbody>\\r\\n</table>\\r\\n\\r\\n<p>&nbsp;</p>\\r\\n\\r\\n<p><strong>III. Tiến độ thanh to&aacute;n &ndash; ch&iacute;nh s&aacute;ch b&aacute;n h&agrave;ng</strong><br />\\r\\nChung cư Imperial Plaza - 360 Giải Ph&oacute;ng đảm bảo quyền lợi tối ưu cho kh&aacute;ch h&agrave;ng, với tiến độ thanh to&aacute;n linh hoạt theo tiến độ x&acirc;y dựng của c&ocirc;ng tr&igrave;nh:<br />\\r\\nĐợt 1: Đ&oacute;ng 30% tổng gi&aacute; trị căn hộ trong v&ograve;ng 7 ng&agrave;y sau khi k&yacute; HĐMB.<br />\\r\\nĐợt 2: Đ&oacute;ng 10% tổng gi&aacute; trị căn hộ sau khi đổ s&agrave;n tầng 5.<br />\\r\\nĐợt 3: Đ&oacute;ng 10% tổng gi&aacute; trị căn hộ sau khi đổ s&agrave;n tầng 15.<br />\\r\\nĐợt 4: Đ&oacute;ng 10% tổng gi&aacute; trị căn hộ sau khi đổ s&agrave;n tầng 22.<br />\\r\\nĐợt 5: Đ&oacute;ng 10% tổng gi&aacute; trị căn hộ sau khi cất n&oacute;c dự &aacute;n.<br />\\r\\nĐợt 6: Đ&oacute;ng 25% + 2% hết to&agrave;n bộ phần gi&aacute; trị c&ograve;n lại khi b&agrave;n giao nh&agrave; v&agrave; ph&iacute; bảo tr&igrave;.<br />\\r\\nĐợt 7: Đ&oacute;ng 5% khi nhận giấy chứng nhận quyền sở hữu (l&acirc;u d&agrave;i).</p>\\r\\n\\r\\n<p>NHỮNG L&Yacute; DO N&Ecirc;N MUA CHUNG CƯ DỰ &Aacute;N IMPERIAL PLAZA:</p>\\r\\n\\r\\n<p>1. Kh&ocirc;ng gian sống đẳng cấp, sang trọng</p>\\r\\n\\r\\n<p>2. Vị tr&iacute; hiếm hom duy nhất tr&ecirc;n trục đường Giải Ph&oacute;ng, li&ecirc;n kết 2 mặt đường Giải Ph&oacute;ng - Định C&ocirc;ng.</p>\\r\\n\\r\\n<p>3. T&agrave;i sản đầu tư tiềm năng: với gi&aacute; chỉ từ 25.5 triệu/m2</p>\\r\\n\\r\\n<p>4. An ninh biệt lập bậc nhất, 3 lớp đảm bảo an to&agrave;n tuyệt đối 24/24h</p>\\r\\n\\r\\n<p>5. Cộng đồng d&acirc;n cư thượng lưu: l&agrave; nơi hội tụ c&ocirc;ng chức, tr&iacute; thức, chủ doanh nghiệp&hellip;</p>\\r\\n\\r\\n<p>&nbsp;</p>\\r\\n\\r\\n<p>Li&ecirc;n hệ nhận th&ocirc;ng tin dự &aacute;n v&agrave; tư vấn miễn ph&iacute;:</p>\\r\\n\\r\\n<p>C&ocirc;ng ty CP Dịch vụ v&agrave; Địa ốc Đất Xanh Miền Bắc</p>\\r\\n\\r\\n<p><strong>Ms Thu:&nbsp;0902.138.985 - 0981.555.638&nbsp;</strong></p>\\r\\n</div>\\r\\n</div>\\r\\n', '1480485172-1.jpg', 'a:5:{i:0;s:16:\"1480484952-1.jpg\";i:1;s:26:\"1480485295-banner-zalo.jpg\";i:2;s:16:\"1480485172-1.jpg\";i:3;s:16:\"1480491799-1.jpg\";i:4;s:16:\"1480491955-1.jpg\";}', 253, 'Mua bán nhà đất', 100, '0', 0, 1, 0, 1, 22, 'Hà Nội', 2, NULL, 1, 'RichPlus', 1, 1480063979, 1480061746, 1481350526),
(2, 'Xuân Mai Riverside - Trung tâm Q. Hà Đông, 1.1 tỷ', 1, 2, 0, 0, '<p>Chuẩn bị mở b&aacute;n đợt tiếp theo dự &aacute;n Xu&acirc;n Mai Riverside &ndash; 150&nbsp;Thanh B&igrave;nh&nbsp;gi&aacute; cả v&ocirc; c&ugrave;ng hấp dẫn chỉ từ 1.1 tỷ/căn (s&agrave;n gỗ, thạch cao, tủ bếp, v&aacute;ch tắm đứng..).<br />\\r\\n<br />\\r\\n* Vị tr&iacute; dự &aacute;n l&agrave; 1 lợi thế:<br />\\r\\n- Nằm trong KĐT Mỗ Lao - L&agrave;ng Việt Kiều Ch&acirc;u &Acirc;u - khu d&acirc;n cư với tr&igrave;nh độ d&acirc;n tr&iacute; cao, đ&atilde; hiện hữu, cơ sở hạ tầng đồng bộ c&oacute; sẵn v&agrave; đ&atilde; đưa v&agrave;o sử dụng: Chợ, bệnh viện, trường học,...<br />\\r\\n- Đầu đường L&ecirc; Văn Lương k&eacute;o d&agrave;i &ndash; v&agrave;o nội th&agrave;nh kh&ocirc;ng qu&aacute; 30p đi xe m&aacute;y.<br />\\r\\n- Kh&ocirc;ng nằm tại mặt đường (ồn &agrave;o, bụi bặm,&hellip;.) m&agrave; nằm giữa 2 trục đường lớn Tố Hữu - Trần Ph&uacute;, Nguyễn Tr&atilde;i. Vẫn đảm bảo được về đi lại + c&oacute; kh&ocirc;ng gian sống trong l&agrave;nh.<br />\\r\\n- Gần hồ điều h&ograve;a Trung Văn - kh&ocirc;ng gian sống đựơc đảm bảo.<br />\\r\\n<br />\\r\\n* Chương tr&igrave;nh ưu đ&atilde;i:<br />\\r\\n- Miễn ph&iacute; 12 th&aacute;ng ph&iacute; quản l&yacute; chung cư cho kh&aacute;ch h&agrave;ng đăng k&yacute; mua trong th&aacute;ng n&agrave;y.<br />\\r\\n- Qu&agrave; tặng 20 triệu &aacute;p dụng với căn số 01 v&agrave; 10.<br />\\r\\n- Chiết khấu 5% căn hộ l&ecirc;n đến 103 triệu khi kh&aacute;ch h&agrave;ng thanh to&aacute;n 01 lần (95%).<br />\\r\\n- Ng&acirc;n h&agrave;ng Li&ecirc;n Việt giải ng&acirc;n đến 70% Gi&aacute; trị căn hộ trong thời gian 20 năm với l&atilde;i suất si&ecirc;u ưu đ&atilde;i.<br />\\r\\n- Tặng ngay 10 triệu đồng khi mua căn hộ 02.<br />\\r\\n<br />\\r\\n<strong>I. Th&ocirc;ng tin dự &aacute;n</strong><br />\\r\\n- Chủ đầu tư: C&ocirc;ng ty CP Đầu tư v&agrave; X&acirc;y Dựng Xu&acirc;n Mai.<br />\\r\\n- Vị tr&iacute; dự &aacute;n: 150 đường Thanh B&igrave;nh, Mỗ Lao, H&agrave; Đ&ocirc;ng (gần L&agrave;ng Việt Kiều Ch&acirc;u &Acirc;u).<br />\\r\\n- Quy m&ocirc; dự &aacute;n: 33 tầng nổi trong đ&oacute;:<br />\\r\\n- Tầng dịch vụ: Từ tầng 1- 6: Tầng để xe, tầng kỹ thuật, nh&agrave; trẻ, si&ecirc;u thị, sinh hoạt cộng đồng,...<br />\\r\\n- Tầng căn hộ: Từ tầng 7 - 33.<br />\\r\\n- Mặt bằng căn hộ: 10 căn/s&agrave;n với 4 thang m&aacute;y v&agrave; 2 thang bộ.<br />\\r\\n- Diện t&iacute;ch căn hộ: Từ 49,14m2 - 98,41m2 gồm c&aacute;c căn 2 PN, 3PN.<br />\\r\\n- Gi&aacute; b&aacute;n căn hộ: Từ 20 - 22 triệu/m2, tổng gi&aacute; trị căn hộ từ 1,1 - 2 tỷ (đ&atilde; bao gồm thuế VAT v&agrave; nội thất cơ bản + tủ bếp).<br />\\r\\n- B&agrave;n giao căn hộ: Th&aacute;ng 12 năm 2017.<br />\\r\\n<br />\\r\\n<strong>II. Thiết kế căn hộ &amp; nội thất đi k&egrave;m</strong><br />\\r\\nG&oacute;i nội thất đi k&egrave;m:<br />\\r\\n&bull; Cửa ch&iacute;nh gỗ tự nhi&ecirc;n Malaysia, cửa gỗ c&ocirc;ng nghiệp th&ocirc;ng ph&ograve;ng.<br />\\r\\n&bull; Thiết bị WC cao cấp nh&atilde;n hiệu ToTo.<br />\\r\\n&bull; Trần thạch cao to&agrave;n bộ ph&ograve;ng.<br />\\r\\n&bull; S&agrave;n gỗ nhập khẩu từ Đức.<br />\\r\\n&bull; Tủ bếp tr&ecirc;n v&agrave; dưới, b&agrave;n bếp, vời rửa v&agrave; chậu rửa.<br />\\r\\n&bull; V&aacute;ch tắm đứng.<br />\\r\\n<br />\\r\\n<strong>III. Tiến độ thanh to&aacute;n</strong>: Đặt cọc 50 triệu<br />\\r\\n- Đợt 1: 20% khi k&yacute; HĐMB (đ&atilde; bao gồm tiền đặt cọc).<br />\\r\\n- Đợt 2: 20% khi xong tầng 12.<br />\\r\\n- Đợt 3: 15% khi xong tầng 22.<br />\\r\\n- Đợt 4: 15% khi cất n&oacute;c.<br />\\r\\n- Đợt 5: 30% khi nhận nh&agrave; + 2% ph&iacute; bảo tr&igrave;.<br />\\r\\n<br />\\r\\nKh&aacute;ch h&agrave;ng quan t&acirc;m xin li&ecirc;n hệ để mua căn hộ v&agrave; đặt chỗ cho đợt ra h&agrave;ng tiếp theo để chọn được căn tầng đẹp + Gi&aacute; cả hợp l&yacute;.</p>\\r\\n\\r\\n<p><strong>Ph&ograve;ng b&aacute;n h&agrave;ng của CĐT: 0915 84 6465 - 093 177 4286</strong></p>\\r\\n', '1481375495-1.jpg', 'a:1:{i:0;s:16:\"1481375495-1.jpg\";}', 253, 'Mua bán nhà đất', 100, '0', 0, 1, 0, 1, 22, 'Hà Nội', 2, NULL, 1, 'RichPlus', 1, 1481375490, 1481375490, 1481375529),
(3, 'CCCC nhất Ngoại Giao Đoàn, Giá chỉ 26tr/m2(VAT+NT)', 1, 2, 0, 0, '<div class=\"width_common box_category\">\\r\\n<div class=\"fck_detail width_common\">\\r\\n<p>Chung cư Ngoại Giao Đo&agrave;n, Khu Ngoại Giao Đo&agrave;n, Bắc Từ Li&ecirc;m, H&agrave; Nội</p>\\r\\n\\r\\n<p><strong>Sở hữu căn hộ cao cấp tại Ngoại Giao Đo&agrave;n chỉ từ 26 triệu /m2, diện t&iacute;ch đa dạng, vị tr&iacute; cực đẹp, thiết kế ti&ecirc;u chuẩn kh&ocirc;ng gian xanh. Đặt mua ngay căn hộ thời điểm n&agrave;y để nhận ngay ưu đ&atilde;i cực lớn:</strong></p>\\r\\n\\r\\n<p>- Tặng 3 năm ph&iacute; dịch vụ.</p>\\r\\n\\r\\n<p>- Chiết khấu ngay 4%.</p>\\r\\n\\r\\n<p>- Ng&acirc;n h&agrave;ng hỗ trợ l&atilde;i suất 0% trong v&ograve;ng 12 th&aacute;ng.</p>\\r\\n\\r\\n<p>Hơn hết l&agrave; được sở hữu căn hộ tại kh&ocirc;ng gian đ&aacute;ng sống nhất giao th&ocirc;ng đến mọi nơi thuận tiện nhất tại thủ đ&ocirc; H&agrave; Nội.</p>\\r\\n\\r\\n<p>&nbsp;</p>\\r\\n\\r\\n<p>Li&ecirc;n hệ ngay:<strong> Mr Th&aacute;i: 0961 003 662/ 09345 80 469</strong></p>\\r\\n\\r\\n<p>Mail : <strong>Hoangthai.bds@gmail.com</strong></p>\\r\\n\\r\\n<p>&nbsp;</p>\\r\\n\\r\\n<table align=\"center\" border=\"0\" cellpadding=\"3\" cellspacing=\"0\" class=\"tplCaption\">\\r\\n	<tbody>\\r\\n		<tr>\\r\\n			<td><img alt=\"\" src=\"http://img.f2.raovat.vnecdn.net/images/2016/08/23/57bbd743e8f50-toa-n03-t3-t4-chung-cu-ngoai-giao-doan_600x0.jpg\" /></td>\\r\\n		</tr>\\r\\n	</tbody>\\r\\n</table>\\r\\n\\r\\n<p>&nbsp;</p>\\r\\n\\r\\n<p><strong>1. TH&Ocirc;NG TIN DỰ &Aacute;N</strong></p>\\r\\n\\r\\n<p>- Chủ đầu tư: C&ocirc;ng ty cổ phần x&acirc;y dựng &amp; Kỹ thuật Việt Nam (VINAENCO)</p>\\r\\n\\r\\n<p>- Vị tr&iacute;: <strong>T&ograve;a T3 &amp; T4 &ndash; N03, Khu Ngoại Giao Đo&agrave;n</strong>, Từ Li&ecirc;m, H&agrave; Nội</p>\\r\\n\\r\\n<p>- Cảnh quan v&ocirc; c&ugrave;ng đẹp với hướng view thẳng CV &amp; hồ điều h&ograve;a, tr&aacute;i tim của Ngoại Giao Đo&agrave;n.</p>\\r\\n\\r\\n<p>- Nằm tr&ecirc;n trục đường ch&iacute;nh Nguyễn Văn Huy&ecirc;n 50m, kết nối Từ Cầu giấy đến Khu đ&ocirc; thị Nam Thăng Long, dự &aacute;n nằm cạnh đường V&otilde; Ch&iacute; C&ocirc;ng &amp; Phạm Văn Đồng n&ecirc;n chỉ mất 20 ph&uacute;t đến S&acirc;n Bay nội b&agrave;i, 5 ph&uacute;t v&agrave;o trung t&acirc;m Q.Ba Đ&igrave;nh, 2 Ph&uacute;t tới Hồ T&acirc;y lộng gi&oacute;</p>\\r\\n\\r\\n<p>- Dự &aacute;n nằm trong tổng thể khu ngoại giao đo&agrave;n, an ninh, vệ sinh, d&acirc;n tr&iacute; cao được đảm bảo, hạ tầng đầu tư đồng bộ</p>\\r\\n\\r\\n<p>&nbsp;</p>\\r\\n\\r\\n<p><strong>2. QUY M&Ocirc; DỰ &Aacute;N</strong></p>\\r\\n\\r\\n<p>- Tham gia ph&aacute;t triển dự &aacute;n bởi c&aacute;c đơn vị quốc tế c&oacute; t&ecirc;n tuổi: DP Architects PTE (Singapore), Aurecon (&Uacute;c), Artelia (Ph&aacute;p)</p>\\r\\n\\r\\n<p>- Diện t&iacute;ch x&acirc;y dựng: 3.681m2, mật động XD 30%</p>\\r\\n\\r\\n<p>- Chiều cao: 25 Tầng nổi + 2 Tầng hầm cao 6m (c&oacute; thể cải tiến th&ecirc;m tầng để xe nữa), tầng 1-3 l&agrave;m TTTM&amp; DV, tầng 5-25 l&agrave; tầng căn hộ</p>\\r\\n\\r\\n<p>- Dự kiến b&agrave;n giao: Qu&yacute; 3-2017</p>\\r\\n\\r\\n<p>- Tiến độ thi c&ocirc;ng hiện tại: Đ&atilde; thi c&ocirc;ng vượt bậc đến s&agrave;n tầng 18</p>\\r\\n\\r\\n<p>&nbsp;</p>\\r\\n\\r\\n<table align=\"center\" border=\"0\" cellpadding=\"3\" cellspacing=\"0\" class=\"tplCaption\">\\r\\n	<tbody>\\r\\n		<tr>\\r\\n			<td><img alt=\"\" src=\"http://img.f2.raovat.vnecdn.net/images/2016/08/23/57bbd7696e584-chung-cu-ngoai-giao-doan-n03-t3-t4-vi-tri_600x0.png\" /></td>\\r\\n		</tr>\\r\\n	</tbody>\\r\\n</table>\\r\\n\\r\\n<p>&nbsp;</p>\\r\\n\\r\\n<p><strong>3. THIẾT KẾ QUY HOẠCH</strong></p>\\r\\n\\r\\n<p>- Căn hộ 2-3 Ph&ograve;ng ngủ c&oacute; diện t&iacute;ch từ 103m2 &ndash; 157m2</p>\\r\\n\\r\\n<p>- Được thiết kế bởi DPA Singapore đảm bảo &aacute;nh s&aacute;ng tự nhi&ecirc;n v&agrave; view cảnh quan cho all c&aacute;c ph&ograve;ng</p>\\r\\n\\r\\n<p>- Đặc biệt dự &aacute;n được x&acirc;y dựng với mang đậm chất Singapo n&ecirc;n thiết kế c&oacute; c&aacute;c vườn treo h&agrave;nh lang trong khu căn hộ, dự &aacute;n với đầy đủ tiện nghi cho cư d&acirc;n sống: Bể Bơi 4 m&ugrave;a, Gym spa, nh&agrave; h&agrave;ng &amp; caf&eacute;, v..v</p>\\r\\n\\r\\n<p>&nbsp;</p>\\r\\n\\r\\n<table align=\"center\" border=\"0\" cellpadding=\"3\" cellspacing=\"0\" class=\"tplCaption\">\\r\\n	<tbody>\\r\\n		<tr>\\r\\n			<td><img alt=\"\" src=\"http://img.f4.raovat.vnecdn.net/images/2016/08/23/57bbd7495bb23-be-boi-chung-cu-ngoai-giao-doan-n03-t3-t4_600x0.jpg\" /></td>\\r\\n		</tr>\\r\\n	</tbody>\\r\\n</table>\\r\\n\\r\\n<p>&nbsp;</p>\\r\\n\\r\\n<p><strong>4. G&Iacute;A B&Aacute;N:</strong></p>\\r\\n\\r\\n<p>Từ 26 triệu/m2 ( gi&aacute; th&ocirc;ng thủy đ&atilde; c&oacute; VAT v&agrave; nội thất cơ bản).</p>\\r\\n\\r\\n<p>Nội thất bao gồm: S&agrave;n gỗ cao cấp, thiết bị vệ sinh Toto đầy đủ, c&oacute; v&aacute;ch ngăn tắm đứng, trần thạch cao, thiết bị chiếu s&aacute;ng, cửa ch&iacute;nh, cửa ngăn ph&ograve;ng, ....</p>\\r\\n\\r\\n<p>&nbsp;</p>\\r\\n\\r\\n<p><strong>4. TIẾN ĐỘ THANH TO&Aacute;N</strong></p>\\r\\n\\r\\n<p>- Với tiến độ cực hợp l&yacute;: 7 đợt ( Đợt 1 đ&oacute;ng 25% k&yacute; HĐMB), ngo&agrave;i ra c&ograve;n c&oacute; ch&iacute;nh s&aacute;ch ưu đ&atilde;i chiết khấu d&agrave;nh cho kh&aacute;ch h&agrave;ng thanh to&aacute;n sớm.</p>\\r\\n\\r\\n<p>- Ng&acirc;n h&agrave;ng Vietcombank hỗ trợ t&agrave;i ch&iacute;nh cho vay l&atilde;i suất ưu đ&atilde;i 0% v&agrave; bảo l&atilde;nh tiến độ thanh to&aacute;n .</p>\\r\\n\\r\\n<p>&nbsp;</p>\\r\\n\\r\\n<p>Li&ecirc;n hệ ngay quản l&yacute; dự &aacute;n để nhận đầy đủ th&ocirc;ng tin chi tiết, đi xem trực tiếp dự &aacute;n v&agrave; chọn cho gia đ&igrave;nh m&igrave;nh căn tầng đẹp nhất:</p>\\r\\n\\r\\n<p><strong>Mr Th&aacute;i: 0961 003 662/ 09345 80 469</strong></p>\\r\\n\\r\\n<p><strong>Mail: Hoangthai.bds@gmail.com</strong></p>\\r\\n\\r\\n<p>Ch&acirc;n th&agrave;nh cảm ơn sự quan t&acirc;m của qu&yacute; kh&aacute;ch!</p>\\r\\n</div>\\r\\n</div>\\r\\n', '1481375603-1.jpg', 'a:1:{i:0;s:16:\"1481375603-1.jpg\";}', 253, 'Mua bán nhà đất', 100, '0', 0, 1, 0, 1, 22, 'Hà Nội', 2, NULL, 1, 'RichPlus', 1, 1481375603, 1481375603, 1481375610),
(4, 'SỞ HỮU NHÀ MẶT PHỐ - XU HƯỚNG ĐẦU TƯ AN TOÀN 2017', 1, 2, 0, 0, '<p>☎☎<strong>PH&Ograve;NG KINH DOANH : HOTLINE 0945.74.5151&ndash;0981.333.911</strong></p>\\r\\n\\r\\n<p><strong>TH&Ocirc;NG TIN DỰ TỔNG QUAN</strong></p>\\r\\n\\r\\n<p><strong>T&ecirc;n dự &aacute;n:</strong> Belleville H&agrave; Nội</p>\\r\\n\\r\\n<p><strong>Vị tr&iacute;:</strong> L&ocirc; đất B4 Nam Trung Y&ecirc;n, Cầu Giấy, H&agrave; Nội</p>\\r\\n\\r\\n<p><strong>Chủ đầu tư:</strong> Vimedimex Group</p>\\r\\n\\r\\n<p><strong>Website tham khảo</strong>: http://alonhadathanoi.com/belleville-ha-noi-b4-trung-yen/</p>\\r\\n\\r\\n<p><strong>Diện t&iacute;ch dự &aacute;n:</strong> 1.5ha</p>\\r\\n\\r\\n<p><strong>Số l&ocirc;:</strong> 66 l&ocirc;</p>\\r\\n\\r\\n<p><strong>Khởi c&ocirc;ng:</strong> 2016 - B&agrave;n giao: Qu&yacute; III 2017.</p>\\r\\n\\r\\n<p><strong>Thiết kế căn hộ</strong>: Mặt tiền rộng 6m, x&acirc;y dựng 5 tầng kiến tr&uacute;c kiểu Ph&aacute;p</p>\\r\\n\\r\\n<p><strong>Chức năng ch&iacute;nh:</strong> Nh&agrave; ở thương mại đa năng, dịch vụ thấp tầng&hellip;</p>\\r\\n\\r\\n<p><strong><em>➤➤</em></strong><strong><em>Vị tr&iacute; Liền Kề B4 Nam Trung Y&ecirc;n</em></strong></p>\\r\\n\\r\\n<p>&nbsp;</p>\\r\\n\\r\\n<table align=\"center\" border=\"0\" cellpadding=\"3\" cellspacing=\"0\" class=\"tplCaption\">\\r\\n	<tbody>\\r\\n		<tr>\\r\\n			<td><img alt=\"\" src=\"http://img.f4.raovat.vnecdn.net/images/2016/12/09/5849a00847ef9-M-t-B-ng-Ph-n-L-_600x0.png\" /></td>\\r\\n		</tr>\\r\\n	</tbody>\\r\\n</table>\\r\\n\\r\\n<p>&nbsp;</p>\\r\\n\\r\\n<p>✦Belleville H&agrave; Nội nằm tại l&ocirc; đất B4 Nam Trung Y&ecirc;n, đối diện trụ sở kiểm to&aacute;n nh&agrave; nước v&agrave; c&ocirc;ng vi&ecirc;n hồ điều h&ograve;a 9ha.</p>\\r\\n\\r\\n<p>✦Dự &aacute;n nằm tr&ecirc;n đường Nguy&ecirc;̃n Chánh giao với Mạc Th&aacute;i Tổ, với vị tr&iacute; trung t&acirc;m KĐT Nam Trung Y&ecirc;n, thuận tiện kinh doanh v&agrave; tận hưởng cuộc sống.</p>\\r\\n\\r\\n<p>+ Ph&iacute;a ĐB: Gi&aacute;p đường Nguyễn Ch&aacute;nh 35 m.</p>\\r\\n\\r\\n<p>+ Ph&iacute;a ĐN: Gi&aacute;p Đường Y&ecirc;n H&ograve;a 3 v&agrave; THCS Nam Trung Y&ecirc;n.</p>\\r\\n\\r\\n<p>+ Ph&iacute;a TB: Gi&aacute;p đường Mạc Th&aacute;i Tổ 40 m.</p>\\r\\n\\r\\n<p>+ Ph&iacute;a TN: Gi&aacute;p đường 30m nh&igrave;n chung cư cao tầng B3.</p>\\r\\n\\r\\n<p>✦Belleville H&agrave; Nội thuận tiện di chuyển ra c&aacute;c tuyến đường lớn: Nguyễn Ch&aacute;nh, Trần Duy Hưng, Ho&agrave;ng Minh Gi&aacute;m, Phạm H&ugrave;ng, Trung K&iacute;nh, Mạc Th&aacute;i Tổ.</p>\\r\\n\\r\\n<p>✦Dễ d&agrave;ng tiếp cận c&aacute;c dự &aacute;n lớn: Keangnam, KĐT Sudico, Golden Palace, Vimeco, FLC Phạm H&ugrave;ng, Dophin Plaza, Indochina Plaza, The Garden.</p>\\r\\n\\r\\n<p>✦Gần c&aacute;c TTVH-CT: TT Hội nghị Quốc Gia, Bảo T&agrave;ng H&agrave; Nội, Kiểm to&aacute;n nh&agrave; nước, T&ograve;a &aacute;n nh&acirc;n d&acirc;n tối cao.</p>\\r\\n\\r\\n<p><strong><em>➤➤</em></strong><strong><em>TIỆN &Iacute;CH DỰ &Aacute;N B4 NAM TRUNG Y&Ecirc;N</em></strong></p>\\r\\n\\r\\n<p>&nbsp;</p>\\r\\n\\r\\n<table align=\"center\" border=\"0\" cellpadding=\"3\" cellspacing=\"0\" class=\"tplCaption\">\\r\\n	<tbody>\\r\\n		<tr>\\r\\n			<td><img alt=\"\" src=\"http://img.f3.raovat.vnecdn.net/images/2016/12/09/5849a007e88c9-14962688_960807080691521_7479190090978252891_n_600x0.jpg\" /></td>\\r\\n		</tr>\\r\\n	</tbody>\\r\\n</table>\\r\\n\\r\\n<p>&nbsp;</p>\\r\\n\\r\\n<p>✦Nam Trung Y&ecirc;n l&agrave; KĐT mới sở hữu hạ tầng được x&acirc;y dựng ho&agrave;n thiện v&agrave; đưa v&agrave;o sử dụng từ trước tạo n&ecirc;n sự đồng nhất về tiện &iacute;ch v&agrave; cảnh quan.</p>\\r\\n\\r\\n<p>✦Trường học Trung H&ograve;a, Trung Y&ecirc;n, trường Nguyễn Si&ecirc;u</p>\\r\\n\\r\\n<p>✦ BV Hồng Ngọc, BV 198, Đại si&ecirc;u thị Big C, C&ocirc;ng vi&ecirc;n 9ha, &hellip;</p>\\r\\n\\r\\n<p>✦B&atilde;i gửi xe th&ocirc;ng minh, vườn hoa nội khu 5000m2.</p>\\r\\n\\r\\n<p><strong><em>➤➤</em></strong><strong><em> PH&Acirc;N T&Iacute;CH TIỀM NĂNG ĐẦU TƯ</em></strong></p>\\r\\n\\r\\n<p>&nbsp;</p>\\r\\n\\r\\n<table align=\"center\" border=\"0\" cellpadding=\"3\" cellspacing=\"0\" class=\"tplCaption\">\\r\\n	<tbody>\\r\\n		<tr>\\r\\n			<td><img alt=\"\" src=\"http://img.f2.raovat.vnecdn.net/images/2016/12/09/5849a0093f133-V-tr-B4---Nam-Trung-Y-n_600x0.jpg\" /></td>\\r\\n		</tr>\\r\\n	</tbody>\\r\\n</table>\\r\\n\\r\\n<p>&nbsp;</p>\\r\\n\\r\\n<p>✦Quanh B4 Nam Trung Y&ecirc;n c&oacute; tr&ecirc;n 10 t&ograve;a chung cư tr&ecirc;n 30 tầng</p>\\r\\n\\r\\n<p>✦B&aacute;n k&iacute;nh 1,5km l&agrave; c&aacute;c KĐT: Keangnam, The Mannor, Vinhomes Skylake, Khu BT Y&ecirc;n H&ograve;a, D&rsquo;Capitale, Mardarin Garden, Vinhomes Mễ Tr&igrave;&hellip;</p>\\r\\n\\r\\n<p>✦Đối diện l&agrave; c&ocirc;ng vi&ecirc;n hồ điều h&ograve;a gần 10ha sắp được triển khai.</p>\\r\\n\\r\\n<p>✦Thiết kế Shophouse chuy&ecirc;n để kinh doanh với diện t&iacute;ch lớn. Mặt tiền 6m, x&acirc;y 5 tầng với 450m2 sử dụng.</p>\\r\\n\\r\\n<p>✦Tiếp gi&aacute;p 2 con đường lớn Nguyễn Ch&aacute;nh v&agrave; Mạc Th&aacute;i Tổ c&oacute; mật độ giao th&ocirc;ng cao.</p>\\r\\n\\r\\n<p><strong><em>➤➤</em></strong><strong><em> MUA NH&Agrave; PHỐ B4 NAM TRUNG Y&Ecirc;N ĐỂ L&Agrave;M G&Igrave;</em></strong></p>\\r\\n\\r\\n<p>1. Mua để giữ tiền, đầu tư cho thu&ecirc; sinh lời cao bền vững&hellip;</p>\\r\\n\\r\\n<p>2. Tổ hợp Nh&agrave; h&agrave;ng Ẩm Thực, dvụ Karaoke, Masage, Games Center, Kh&aacute;ch sạn&hellip;</p>\\r\\n\\r\\n<p>3. Trụ sở ch&iacute;nh, văn ph&ograve;ng đại diện c&ocirc;ng ty.</p>\\r\\n\\r\\n<p>4. Nh&agrave; trẻ, c&aacute;c tường tư thục, ngoại ngữ,&hellip;</p>\\r\\n\\r\\n<p>5. Để ở với c&aacute;c căn view c&ocirc;ng vi&ecirc;n cực đẹp.</p>\\r\\n\\r\\n<p>6. Rất rất nhiều ng&agrave;nh nghề kh&aacute;c c&oacute; thể kinh doanh tại B4 với vị tr&iacute; đắc địa giao th&ocirc;ng hạ tầng đồng bộ.</p>\\r\\n\\r\\n<p>&nbsp;</p>\\r\\n\\r\\n<table align=\"center\" border=\"0\" cellpadding=\"3\" cellspacing=\"0\" class=\"tplCaption\">\\r\\n	<tbody>\\r\\n		<tr>\\r\\n			<td><img alt=\"\" src=\"http://img.f4.raovat.vnecdn.net/images/2016/12/09/5849a008aeafe-Ph-i-c-nh-B4-Nam-Trung-Y-n_600x0.png\" /></td>\\r\\n		</tr>\\r\\n	</tbody>\\r\\n</table>\\r\\n\\r\\n<p>&nbsp;</p>\\r\\n\\r\\n<p>☎☎ ĐỂ NHẬN BẢNG GI&Aacute; QU&Yacute; KH&Aacute;CH VUI LONG GỌI</p>\\r\\n\\r\\n<p>HOTLINE: 0945.74.5151- 0981.333.911</p>\\r\\n', '1481375674-3.jpg', 'a:1:{i:0;s:16:\"1481375674-3.jpg\";}', 253, 'Mua bán nhà đất', 100, '0', 0, 1, 0, 1, 22, 'Hà Nội', 2, NULL, 1, 'RichPlus', 1, 1481375674, 1481375674, 1481375679),
(5, 'Vhinhomes Skylake- Free 3 năm DV, vay 65%,CK4-9,5% ', 1, 2, 0, 0, '<div class=\"width_common box_category\">\\r\\n<div class=\"fck_detail width_common\">\\r\\n<p>HOT! HOT! HOT! Đ&atilde; c&oacute; ch&iacute;nh s&aacute;ch b&aacute;n h&agrave;ng si&ecirc;u hấp dẫn Vinhomes Skylake Phạm H&ugrave;ng.<br />\\r\\nVHS- Đơn vị ph&acirc;n phối ch&iacute;nh thức : Ms.Ngọc 0965 302 393 - 0934 196 331 (24/7)</p>\\r\\n\\r\\n<p>&nbsp;</p>\\r\\n\\r\\n<table align=\"center\" border=\"0\" cellpadding=\"3\" cellspacing=\"0\" class=\"tplCaption\">\\r\\n	<tbody>\\r\\n		<tr>\\r\\n			<td><img alt=\"\" src=\"http://img.f4.raovat.vnecdn.net/images/2016/12/10/584be500733bc-20161206143930-5338_wm_600x0.jpg\" /></td>\\r\\n		</tr>\\r\\n	</tbody>\\r\\n</table>\\r\\n\\r\\n<p>&nbsp;</p>\\r\\n\\r\\n<p><br />\\r\\nCH&Iacute;NH S&Aacute;CH B&Aacute;N H&Agrave;NG SI&Ecirc;U HẤP DẪN:<br />\\r\\n1. Miễn ph&iacute; 3 năm ph&iacute; dịch vụ.<br />\\r\\n2. Tặng Voucher Vinschool: trị gi&aacute; 50tr (KH sẽ được nhận trong 30 ng&agrave;y kể từ ng&agrave;y K&yacute; HDMB). Nếu kh&aacute;ch kh&ocirc;ng nhận voucher th&igrave; sẽ được trừ 45tr tr&ecirc;n gi&aacute; trước VAT v&agrave; KPBT.<br />\\r\\n3. Đại hỉ vi xu&acirc;n ( VinID):<br />\\r\\n- KH mua 1 hoặc nhiều căn c&oacute; tổng GT dưới 5 tỷ (chưa VAT+KPBT) kh&aacute;ch h&agrave;ng sẽ được tặng 1 thẻ th&acirc;n thiết + 1 thẻ th&acirc;n thiết cho người th&acirc;n thiết cho người th&acirc;n được chỉ định.<br />\\r\\n- KH mua 1 hoặc nhiều căn c&oacute; tổng GT tr&ecirc;n 5 tỷ (chưa VAT+KPBT) KH sẽ đc tặng 01 thẻ VIP+02 thẻ th&acirc;n thiết cho người th&acirc;n được chỉ định.</p>\\r\\n\\r\\n<p>&nbsp;</p>\\r\\n\\r\\n<table align=\"center\" border=\"0\" cellpadding=\"3\" cellspacing=\"0\" class=\"tplCaption\">\\r\\n	<tbody>\\r\\n		<tr>\\r\\n			<td><img alt=\"\" src=\"http://img.f3.raovat.vnecdn.net/images/2016/12/10/584be52391039-a2_600x0.jpg\" /></td>\\r\\n		</tr>\\r\\n	</tbody>\\r\\n</table>\\r\\n\\r\\n<p>&nbsp;</p>\\r\\n\\r\\n<p><br />\\r\\n4. KH kh&ocirc;ng VV sẽ được CK 4% GTCH (chỉ AD cho KH thanh to&aacute;n bằng vốn tự c&oacute;)<br />\\r\\n- KH thanh to&aacute;n sớm theo từng đợt sẽ được CK 7%/ năm.<br />\\r\\n- KH thanh to&aacute;n sớm trước 95% sẽ được CK 9.5%/ năm</p>\\r\\n\\r\\n<p>&nbsp;</p>\\r\\n\\r\\n<table align=\"center\" border=\"0\" cellpadding=\"3\" cellspacing=\"0\" class=\"tplCaption\">\\r\\n	<tbody>\\r\\n		<tr>\\r\\n			<td><img alt=\"\" src=\"http://img.f1.raovat.vnecdn.net/images/2016/12/10/584be5464f351-5840d45360a39-f5f00cfa7801798937becdbb2cc9897a_600x0_600x0.jpg\" /></td>\\r\\n		</tr>\\r\\n	</tbody>\\r\\n</table>\\r\\n\\r\\n<p>&nbsp;</p>\\r\\n\\r\\n<p><br />\\r\\nCH&Iacute;NH S&Aacute;CH HỖ TRỢ L&Atilde;I SUẤT:<br />\\r\\n- Tỷ lệ khoản vay tối đa: 65% GTCH đ&atilde; bao gồm VAT<br />\\r\\n- LSVV: 0% trong thời gian HTLS. Sau thời gian HTLS th&igrave; t&iacute;nh theo QD của NH<br />\\r\\n-Thời gian HTLS: kể từ ng&agrave;y giải ng&acirc;n. Ko chậm hơn 31/7/2019<br />\\r\\n- &Acirc;n hạn l&atilde;i suất: KH đc &acirc;n hạn l&atilde;i suất trong TG HTLS.<br />\\r\\n- Miễn ph&iacute; trả trước hạn.</p>\\r\\n\\r\\n<p>&nbsp;</p>\\r\\n\\r\\n<table align=\"center\" border=\"0\" cellpadding=\"3\" cellspacing=\"0\" class=\"tplCaption\">\\r\\n	<tbody>\\r\\n		<tr>\\r\\n			<td><img alt=\"\" src=\"http://img.f3.raovat.vnecdn.net/images/2016/12/10/584be556cbed0-tong-quan_600x0.jpg\" /></td>\\r\\n		</tr>\\r\\n	</tbody>\\r\\n</table>\\r\\n\\r\\n<p>&nbsp;</p>\\r\\n\\r\\n<p><br />\\r\\nI/ TH&Ocirc;NG TIN DỰ &Aacute;N:<br />\\r\\n- T&ecirc;n dự &aacute;n: Vinhomes SkyLake.<br />\\r\\n&ndash; Chủ đầu tư: Tập đo&agrave;n Vingroup.<br />\\r\\n&ndash; Vận h&agrave;nh quản l&yacute;: Vinhomes.<br />\\r\\n&ndash; Vị tr&iacute;: L&ocirc; đất E1,3 Cầu Giấy, Đường Phạm H&ugrave;ng, Từ Li&ecirc;m, H&agrave; Nội.<br />\\r\\n&ndash; Diện t&iacute;ch đất dự &aacute;n: 2.31 ha.<br />\\r\\n&ndash; Mật độ x&acirc;y dựng: 49,94%, 26,24% (khối th&aacute;p).<br />\\r\\n&ndash; Dự &aacute;n gồm c&oacute;: CHCC, Penhouse &amp; Sky Villa</p>\\r\\n\\r\\n<p>&nbsp;</p>\\r\\n\\r\\n<table align=\"center\" border=\"0\" cellpadding=\"3\" cellspacing=\"0\" class=\"tplCaption\">\\r\\n	<tbody>\\r\\n		<tr>\\r\\n			<td><img alt=\"\" src=\"http://img.f3.raovat.vnecdn.net/images/2016/12/10/584be5639c7e5-a1_600x0.jpg\" /></td>\\r\\n		</tr>\\r\\n	</tbody>\\r\\n</table>\\r\\n\\r\\n<p>&nbsp;</p>\\r\\n\\r\\n<p><br />\\r\\nII/ THIẾT KẾ VINHOMES SKYLAKE PHẠM H&Ugrave;NG:<br />\\r\\nVinhomes SkyLake bao gồm 3 t&ograve;a S1, S2, S3:<br />\\r\\n+ Tầng hầm: 3 tầng hầm.<br />\\r\\n+ 3 Tầng TTTM<br />\\r\\nThiết kế chung cư tầng 4- 39 Vinhomes SkyLake:<br />\\r\\n- Căn 1 ngủ: 49 &ndash; 53m2.<br />\\r\\n- Căn 2 ngủ: 68m2 &ndash; 81m2.<br />\\r\\n- Căn 3 ngủ: 95m2 &ndash; 133m2.<br />\\r\\n- Căn 4 ngủ: 155m2 - 157m2.<br />\\r\\n- Mặt bằng t&ograve;a S1:<br />\\r\\nCao 37 tầng, tổng 384 căn, 12 căn/ s&agrave;n, 8 thang m&aacute;y/s&agrave;n.<br />\\r\\n- Mặt bằng t&ograve;a S2, S3:<br />\\r\\nCao 42 tầng, 715 căn/t&ograve;a, 20 căn hộ/s&agrave;n, 13 thang m&aacute;y/s&agrave;n.</p>\\r\\n\\r\\n<p>&nbsp;</p>\\r\\n\\r\\n<table align=\"center\" border=\"0\" cellpadding=\"3\" cellspacing=\"0\" class=\"tplCaption\">\\r\\n	<tbody>\\r\\n		<tr>\\r\\n			<td><img alt=\"\" src=\"http://img.f1.raovat.vnecdn.net/images/2016/12/10/584be577eb6e8-pc_600x0.jpg\" /></td>\\r\\n		</tr>\\r\\n	</tbody>\\r\\n</table>\\r\\n\\r\\n<p>&nbsp;</p>\\r\\n\\r\\n<p>Để nhận B&aacute;o gi&aacute; v&agrave; tư vấn chi tiết Q&uacute;y KH vui l&ograve;ng li&ecirc;n hệ<br />\\r\\nVHS- Đơn vị ph&acirc;n phối ch&iacute;nh thức: Ms.Ngọc 0965 302 393 &ndash; 0934 196 331</p>\\r\\n</div>\\r\\n</div>\\r\\n', '1481375798-4.jpg', 'a:1:{i:0;s:16:\"1481375798-4.jpg\";}', 253, 'Mua bán nhà đất', 100, '0', 0, 1, 0, 1, 22, 'Hà Nội', 2, NULL, 1, 'RichPlus', 1, 1481375798, 1481375798, 1481375804),
(6, 'Đón giáng sinh 2016 cùng BMW (tặng trước bạ+++) ', 1, 2, 0, 0, '<div class=\"width_common box_category\">\\r\\n<div class=\"fck_detail width_common\">\\r\\n<p>B&aacute;n BMW đủ model, đủ m&agrave;u giao xe ngay 2016.</p>\\r\\n\\r\\n<p>BMW hiện c&oacute;:</p>\\r\\n\\r\\n<p>- 320i-320i (100 năm) -330i-320iGT</p>\\r\\n\\r\\n<p>- 520i-528i-528iGT</p>\\r\\n\\r\\n<p>- 420iGC-428iGC-420Cab-428iCab-430GC</p>\\r\\n\\r\\n<p>- 640iGC</p>\\r\\n\\r\\n<p>- 730Li-740Li</p>\\r\\n\\r\\n<p>- X1-X3-X4-X5-X6</p>\\r\\n\\r\\n<p>- M2-M3-M4-Z4</p>\\r\\n\\r\\n<p>Xe mới 100% nhập khẩu nguy&ecirc;n chiếc từ Đức v&agrave; Mỹ.</p>\\r\\n\\r\\n<p>- Phi&ecirc;n bản nhiệt đới h&oacute;a: Radio, nhi&ecirc;n liệu, chassi, điều h&ograve;a, giảm s&oacute;c ph&ugrave; hợp với địa h&igrave;nh v&agrave; kh&iacute; hậu Việt Nam - xe chạy &ecirc;m, điều h&ograve;a lạnh s&acirc;u;</p>\\r\\n\\r\\n<p>- H&oacute;a đơn xuất đủ 100% theo gi&aacute; trị Hợp đồng mua b&aacute;n;</p>\\r\\n\\r\\n<p>- Xe được bảo h&agrave;nh 02 năm kh&ocirc;ng giới hạn km sử dụng (theo ti&ecirc;u chuẩn BMW tr&ecirc;n to&agrave;n cầu), kh&aacute;ch h&agrave;ng c&oacute; thể lựa chọn tham gia g&oacute;i &ldquo;ra hạn bảo h&agrave;nh cho xe l&ecirc;n đến 6 năm hoặc 150,000 km&rdquo;.</p>\\r\\n\\r\\n<p>- Dịch vụ đậu xe miễn ph&iacute; tại TT Thủ đ&ocirc; H&agrave; Nội v&agrave; TT TP HCM;</p>\\r\\n\\r\\n<p>- Giao xe tại nh&agrave; kh&aacute;ch h&agrave;ng (miễn ph&iacute; vận chuyển);</p>\\r\\n\\r\\n<p>- Hỗ trợ thủ tục mua trả g&oacute;p qua Ng&acirc;n h&agrave;ng, thu&ecirc; mua t&agrave;i ch&iacute;nh, l&atilde;i suất thấp nhất.</p>\\r\\n\\r\\n<p>- Hỗ trợ l&agrave;m thủ tục đăng k&yacute;, đăng kiểm xe;</p>\\r\\n\\r\\n<p>- Tư vấn trao đổi xe cũ mới c&aacute;c loại (miễn ph&iacute;).</p>\\r\\n\\r\\n<p>&nbsp;</p>\\r\\n\\r\\n<p><strong>Hotline: 0983856688 H&agrave; (Mr) - BMW&nbsp;</strong></p>\\r\\n</div>\\r\\n</div>\\r\\n', '1481375971-5.jpg', 'a:1:{i:0;s:16:\"1481375971-5.jpg\";}', 255, 'Ôtô', 100, '0', 0, 1, 0, 1, 22, 'Hà Nội', 2, NULL, 1, 'RichPlus', 1, 1481375971, 1481375971, 1481375976),
(7, 'Bán xe Mitsubishi Pajero màu bạc, sản xuất 2003 ', 1, 2, 0, 0, '<p>B&aacute;n xe Mitsubishi Pajero m&agrave;u bạc, sản xuất 2003, biển số H&agrave; Nội, xe 2 cầu, 7 chỗ, lốp treo, xe gia đ&igrave;nh n&ecirc;n c&ograve;n mới, ch&iacute;nh chủ sử dụng</p>\\r\\n', '1481376082-3.jpg', 'a:4:{i:0;s:16:\"1481376069-1.jpg\";i:1;s:16:\"1481376076-1.jpg\";i:2;s:16:\"1481376076-2.jpg\";i:3;s:16:\"1481376082-3.jpg\";}', 255, 'Ôtô', 100, '0', 0, 1, 0, 1, 22, 'Hà Nội', 2, NULL, 1, 'RichPlus', 1, 1482304522, 1481376069, 1481376087),
(8, 'Bán GLk 220 sport , máy dầu , sx 2014', 1, 2, 0, 0, '<p>B&aacute;n GLk 220 sport, m&aacute;y dầu, sx 2014 , xe chạy rất &iacute;t ,gần như l&agrave; mới nguy&ecirc;n, cam kết l&agrave; xe kh&ocirc;ng đ&acirc;m đụng ngập nước.</p>\\r\\n\\r\\n<p><img alt=\"undefined\" src=\"http://dev.sanphamredep.com/uploads/thumbs/product/8/600x600/1481376200-1.png\" /></p>\\r\\n', '1481376200-1.png', 'a:2:{i:0;s:16:\"1481376153-3.png\";i:1;s:16:\"1481376200-1.png\";}', 255, 'Ôtô', 100, '0', 0, 1, 0, 1, 22, 'Hà Nội', 2, NULL, 1, 'RichPlus', 1, 1482304522, 1481376153, 1481376217),
(9, 'Toyota Thanh Xuân bán Altis 2016 - 0916568362', 1, 2, 0, 0, '<p>Toyota Thanh Xu&acirc;n - C&ocirc;ng ty TNHH Toyota Thanh Xu&acirc;n - Đại l&yacute; Toyota ch&iacute;nh h&atilde;ng<br />\\r\\nĐịa chỉ: 315 Trường Chinh - Thanh Xu&acirc;n - H&agrave; Nội<br />\\r\\nHotline Đại diện kinh doanh: 0916568362</p>\\r\\n\\r\\n<p>Toyota Corolla Altis 2015 - Xe Toyota b&aacute;n chạy nhất mọi thời đại</p>\\r\\n\\r\\n<p>B&aacute;n Corolla Altis thế hệ đột ph&aacute; 2016 - Gi&aacute; xe Toyota Corolla Altis 2016 - Xe Toyota Altis 2016<br />\\r\\nToyota Altis 2016 gi&aacute; tốt nhất - Corolla Altis 2016 gi&aacute; tốt - Mua Altis 2016 ở đ&acirc;u?</p>\\r\\n\\r\\n<p>1. Corolla Altis 2.0 CVT-i: 932.000.000 VNĐ</p>\\r\\n\\r\\n<p>2. Corolla Altis 1.8 CVT: 800.000.000 VNĐ</p>\\r\\n\\r\\n<p>3. Corolla Altis 1.8 MT: 755.000.000 VNĐ</p>\\r\\n\\r\\n<p>M&agrave;u sắc: Đen, Bạc, N&acirc;u &aacute;nh đồng, Ghi &aacute;nh xanh</p>\\r\\n\\r\\n<p>Giao xe ngay, giảm tiền mặt, khuyến mại lắp đặt phụ kiện ch&iacute;nh h&atilde;ng, giảm 30% bảo hiểm vật chất, tặng camera l&ugrave;i, tặng phiếu thay dầu miễn ph&iacute;, tặng nước hoa cao cấp, hỗ trợ đăng k&yacute; đăng kiểm...</p>\\r\\n\\r\\n<p>Hỗ trợ trả g&oacute;p, l&atilde;i suất tốt nhất, thủ tục đơn giản, nhanh ch&oacute;ng...</p>\\r\\n\\r\\n<p>Qu&yacute; kh&aacute;ch c&oacute; nhu cầu t&igrave;m hiểu hoặc mua xe Toyota Corolla Altis 2016, xin vui l&ograve;ng li&ecirc;n hệ Hotline Đại diện kinh doanh Toyota Thanh Xu&acirc;n: 0916568362 để được hỗ trợ, tư vấn v&agrave; b&aacute;o gi&aacute; tốt nhất.</p>\\r\\n\\r\\n<p>Toyota Thanh Xu&acirc;n - B&aacute;o gi&aacute; xe Toyota - Gi&aacute; xe Toyota 2016 - Toyota Việt Nam - Gi&aacute; xe Toyota Altis 2016 - Toyota Altis 2016 gi&aacute; tốt - Gi&aacute; xe Altis 2016 - Corolla Altis 2016</p>\\r\\n\\r\\n<p>Website C&ocirc;ng ty TNHH Toyota Thanh Xu&acirc;n: http://xetoyotathanhxuan.com</p>\\r\\n', '1481376269-1.jpg', 'a:1:{i:0;s:16:\"1481376269-1.jpg\";}', 255, 'Ôtô', 100, '0', 0, 1, 0, 1, 22, 'Hà Nội', 2, NULL, 1, 'RichPlus', 1, 1482304522, 1481376269, 1481376273),
(10, 'Chỉ với 100tr sở hữu ngay Ranger wildtrak 2016', 1, 2, 0, 0, '<p>Sốc... Sốc... Chỉ với 100tr sở hữu ngay Ranger mới 2016</p>\\r\\n\\r\\n<p>- Hỗ trợ mua xe trả g&oacute;p l&ecirc;n tới 90%</p>\\r\\n\\r\\n<p>- Hỗ trợ mọi thủ tục đăng k&iacute; đăng kiểm ra biển</p>\\r\\n\\r\\n<p>- Giao&nbsp;xe tận nơi tr&ecirc;n to&agrave;n quốc</p>\\r\\n', '1481376345-1.jpg', 'a:1:{i:0;s:16:\"1481376345-1.jpg\";}', 255, 'Ôtô', 100, '0', 0, 1, 0, 1, 22, 'Hà Nội', 2, NULL, 1, 'RichPlus', 1, 1482304522, 1481376345, 1481417771),
(11, 'Đồng hồ GUTE GU-250 - Dòng sản phẩm độc quyền từ Mỹ', 1, 1, 310000, 0, '<p>Thiết kế đầy c&aacute; t&iacute;nh, đậm chất thời trang, tinh tế, thể hiện sự trẻ trung, hiện đại.</p>\\r\\n\\r\\n<p>Đ&acirc;y ch&iacute;nh l&agrave; điểm mới mẻ, đặc biệt trong kiểu d&aacute;ng sản phẩm đồng hồ nam d&acirc;y da GUTE GU-250</p>\\r\\n\\r\\n<p>Kh&ocirc;ng chỉ với chức năng đơn thuần để coi giờ, đồng hồ c&ograve;n l&agrave; một trong những ti&ecirc;u chuẩn để đ&aacute;nh gi&aacute; đẳng cấp thời trang, phong c&aacute;ch s&agrave;nh điệu cũng như tạo sự nổi bật cho bạn khi xuất hiện ở bất k&igrave; đ&acirc;u.</p>\\r\\n\\r\\n<p><img src=\"http://sanphamredep.com/uploads/thumbs/product/265/800x800/10-55-03-28-09-2016-1.jpg\" /></p>\\r\\n', '1481378842-1.jpg', 'a:2:{i:0;s:16:\"1481378842-1.jpg\";i:1;s:16:\"1481378859-2.jpg\";}', 261, 'Thời trang - Làm đẹp', 100, '0', 0, 1, 0, 1, 22, 'Hà Nội', 60, NULL, 3, 'Huyền Trang', 1, 1481378842, 1481378842, 1481378906),
(12, 'Đồng hồ Fedylon FE-245- Phong cách chỉnh chu sành điệu cho anh chàng công sở', 1, 1, 245000, 0, '<div class=\"item-tab ttct act\">\\r\\n<div class=\"show-tab show-tab-1 act\">\\r\\n<p>Một trong những mẫu đồng hồ c&oacute; thể to&aacute;t l&ecirc;n vẻ lịch l&atilde;m, chỉnh chu cho nam giới đ&oacute; ch&iacute;nh l&agrave; mẫu đồng hồ Frdylon FE-245.<br />\\r\\nVới thiết kế d&acirc;y da c&ugrave;ng th&ocirc;ng số r&otilde; r&agrave;ng, FE-245 kh&ocirc;ng chỉ gi&uacute;p bạn dễ d&agrave;ng xem giờ nhanh ch&oacute;ng m&agrave; c&ograve;n l&agrave; phụ kiện tuyệt vời hỗ trợ bạn trong việc ghi điểm với c&aacute;c n&agrave;ng. Nhiều khảo s&aacute;t cho th&acirc;y phụ nữ th&iacute;ch nửa kia của m&igrave;nh sở hữu chiếc đồng hồ đeo tay hơn.</p>\\r\\n\\r\\n<p><img src=\"http://sanphamredep.com/uploads/thumbs/product/261/800x800/10-17-47-22-09-2016-2.jpg\" /></p>\\r\\n\\r\\n<p><br />\\r\\nV&igrave; vậy, kh&ocirc;ng c&oacute; l&yacute; do g&igrave; để kh&ocirc;ng sở hữu chiếc đồng hồ FE-245 si&ecirc;u ấn tượng n&agrave;y nhỉ!</p>\\r\\n\\r\\n<p><strong>Th&ocirc;ng số kỹ thuật:</strong></p>\\r\\n\\r\\n<p>Nh&atilde;n hiệu : Fedylon<br />\\r\\nKiểu m&aacute;y : Classic<br />\\r\\nĐồng hồ d&agrave;nh cho : Nam<br />\\r\\nK&iacute;ch cỡ : 38 mm<br />\\r\\nĐộ d&agrave;y : 8 mm<br />\\r\\nChất liệu vỏ : Th&eacute;p kh&ocirc;ng gỉ 316L<br />\\r\\nChất liệu d&acirc;y : d&acirc;y da cao cấp<br />\\r\\nChất liệu k&iacute;nh : Sapphire Crystal<br />\\r\\nĐộ chịu nước : 3 ATM<br />\\r\\nBảo h&agrave;nh : 3 th&aacute;ng</p>\\r\\n</div>\\r\\n</div>\\r\\n', '1481379088-2.jpg', 'a:3:{i:0;s:16:\"1481379088-2.jpg\";i:1;s:16:\"1481379094-1.jpg\";i:2;s:16:\"1481379094-3.jpg\";}', 261, 'Thời trang - Làm đẹp', 100, '0', 0, 1, 0, 1, 22, 'Hà Nội', 60, NULL, 3, 'Huyền Trang', 1, 1481379088, 1481379088, 1481379127),
(13, ' Đồng hồ Fedylon FES-399 - Đẳng cấp sang trọng cho phái mạnh', 1, 1, 399000, 0, '<div class=\"item-tab ttct act\">\\r\\n<p>Chất liệu: khung đồng hồ bằng th&eacute;p sang trọng kết hợp với d&acirc;y da b&oacute;ng.<br />\\r\\nMặt đồng hồ tr&ograve;n, đường k&iacute;nh lớn, mang vẻ đẹp trẻ trung, hiện đại.<br />\\r\\nĐồng hồ c&oacute; khả năng chống nước nhẹ, hỗ trợ xem lịch.<br />\\r\\nNhững chi tiết nhỏ si&ecirc;u độc đ&aacute;o, gia c&ocirc;ng tinh xảo đ&atilde; tạo n&ecirc;n sự &quot;c&aacute; t&iacute;nh vượt bậc, phong th&aacute;i lịch l&atilde;m&quot; cho người đeo.</p>\\r\\n\\r\\n<p><img src=\"http://sanphamredep.com/uploads/thumbs/product/258/800x800/10-04-19-22-09-2016-1.jpg\" /></p>\\r\\n\\r\\n<p>- Nh&atilde;n hiệu : FEDYLON<br />\\r\\n- Kiểu m&aacute;y : Classic<br />\\r\\n- Đồng hồ d&agrave;nh cho : Nam<br />\\r\\n- K&iacute;ch cỡ : 40 mm<br />\\r\\n- Độ d&agrave;y : 8 mm<br />\\r\\n- Trọng lượng : 90 g<br />\\r\\n- Chất liệu vỏ : Th&eacute;p kh&ocirc;ng gỉ 316L<br />\\r\\n- Chất liệu d&acirc;y : Th&eacute;p kh&ocirc;ng gỉ 316L<br />\\r\\n- Chất liệu k&iacute;nh : Sapphire Crystal<br />\\r\\n- Độ chịu nước : 3 ATM<br />\\r\\n- Bảo h&agrave;nh : 3 th&aacute;ng</p>\\r\\n</div>\\r\\n', '1481379182-1.jpg', 'a:1:{i:0;s:16:\"1481379182-1.jpg\";}', 261, 'Thời trang - Làm đẹp', 100, '0', 0, 1, 0, 1, 22, 'Hà Nội', 60, NULL, 3, 'Huyền Trang', 1, 1482543746, 1481379182, 1481379198),
(14, 'Đồng Hồ Thời Trang Nam EYD-399 Sành Điệu Đẳng Cấp', 1, 1, 399000, 0, '<div class=\"item-tab ttct act\">\\r\\n<p>EYD-399 kiểu d&aacute;ng mạnh mẽ chất lượng cao với khả năng chống nước tuyệt vời l&ecirc;n đến 5ATM cho ph&eacute;p người d&ugrave;ng tiếp x&uacute;c đồng hồ với nước trong nhiều giờ li&ecirc;n tục- đi&ecirc;u m&agrave; kh&ocirc;ng phải bất cứ mẫu đồng hồ n&agrave;o cũng c&oacute; thể l&agrave;m được. Đồng hồ EYD-399 chắc chắn sẽ l&agrave; sự lựa chọn l&yacute; tưởng gi&uacute;p t&ocirc;n th&ecirc;m vẻ hiện đại, đẳng cấp v&agrave; sang trọng cho c&aacute;c đấng m&agrave;y r&acirc;u.</p>\\r\\n\\r\\n<p>- Size: 40mm<br />\\r\\n- D&agrave;y: 6mm<br />\\r\\n- Chống nước 5ATM ng&acirc;m nước tắm thoải m&aacute;i<br />\\r\\n- Chất liệu mặt: k&iacute;nh cường lực chống xước<br />\\r\\n- Chất liệu d&acirc;y: Kim loại<br />\\r\\n- Bảo h&agrave;nh: 3 th&aacute;ng</p>\\r\\n\\r\\n<p><img src=\"http://sanphamredep.com/uploads/thumbs/product/266/800x800/10-58-10-28-09-2016-1.jpg\" /></p>\\r\\n</div>\\r\\n', '1481379297-1.jpg', 'a:1:{i:0;s:16:\"1481379297-1.jpg\";}', 261, 'Thời trang - Làm đẹp', 100, '0', 0, 1, 0, 1, 22, 'Hà Nội', 60, NULL, 3, 'Huyền Trang', 1, 1482543746, 1481379297, 1481379327),
(15, 'Đồng Hồ Nam Sành Điệu DT-120', 1, 1, 245000, 0, '<div class=\"item-tab ttct act\">\\r\\n<p>Với thiết kế hiện đại, sang trọng nhưng cũng kh&ocirc;ng k&eacute;m phần trẻ trung đồng hồ DT-120 nhanh ch&oacute;ng nhận được sự đ&oacute;n nhận lớn của kh&aacute;ch h&agrave;ng v&agrave; được đ&aacute;nh gi&aacute; l&agrave; sản phẩm c&oacute; chất lượng tốt cho ph&eacute;p người d&ugrave;ng đi mưa, tiếp x&uacute;c với nước thoải m&aacute;i cũng như sở hữu vẻ đẹp c&aacute; t&iacute;nh gi&uacute;p c&aacute;c ch&agrave;ng thể hiện được c&aacute; t&iacute;nh cũng như địa vị của m&igrave;nh.</p>\\r\\n\\r\\n<p>&nbsp;</p>\\r\\n\\r\\n<p><img src=\"http://sanphamredep.com/uploads/thumbs/product/268/800x800/11-36-57-28-09-2016-11-04-20-28-09-2016-1.jpg\" /></p>\\r\\n\\r\\n<p>- Chống nước 3ATM rửa tay đi mưa<br />\\r\\n- Chất liệu mặt: k&iacute;nh cường lực chống xước<br />\\r\\n- Chất liệu d&acirc;y: Kim loại</p>\\r\\n</div>\\r\\n', '1481379536-1.jpg', 'a:1:{i:0;s:16:\"1481379536-1.jpg\";}', 261, 'Thời trang - Làm đẹp', 100, '0', 0, 1, 0, 1, 22, 'Hà Nội', 60, NULL, 3, 'Huyền Trang', 1, 1482543746, 1481379536, 1481379542),
(16, 'Spa Thảo Dược Hà Vy - khuyến mại lớn nhân mừng sinh nhật', 1, 2, 0, 0, '<p>UP DATE C&Aacute;I N&Agrave;O. QU&Aacute; NHIU KH&Aacute;CH KHỎI MỤN DA ĐẸP. NHƯNG H&Ocirc;M NAY GẶP E N&Agrave;Y TH&Igrave; BỊ BẤT NGỜ QU&Aacute; LU&Ocirc;N &Yacute;.<br />\\r\\n\\r\\nKO NHẬN RA E NỮA HẾT MỤN HẾT TH&Acirc;M DA TRẮNG HỒNG . SAU LIỆU TR&Igrave;NH Đ TRỊ MỤN TẠI SPA THẢO DƯỢC H&Agrave; VY.</p>\\r\\n\\r\\n<p>\\r\\n\\r\\n</p>\\r\\n\\r\\n<p><img alt=\"undefined\" src=\"http://raovatphuly.vn/uploads/thumbs/product/16/600x600/1481384759-1526756711770128290561558404952054071671415n.jpg\" /><br />\\r\\n\\r\\nKO 360 ĐỘ NH&Eacute; .<br />\\r\\n\\r\\nL&Agrave;M E LẠI C&Oacute; ĐỘNG LỰC ĐỂ UP FREE BACK KH&Aacute;CH SAU Đ TR&Igrave; TỰ TIN HẲN DA ĐẸP HẲN<br />\\r\\n\\r\\n------------------------------------------------------<br />\\r\\n\\r\\n* Trị Mụn Thảo Dược Đ&ocirc;ng y. AN TO&Agrave;N, Hiệu quả. kết quả th&igrave; mọi người đ&atilde; biết rồi nh&eacute;.</p>\\r\\n\\r\\n<p>\\r\\n\\r\\n</p>\\r\\n\\r\\n<p><img alt=\"undefined\" src=\"http://raovatphuly.vn/uploads/thumbs/product/16/600x600/1481384772-1499187711678503833057338704771275037393415n.jpg\" /></p>\\r\\n\\r\\n<p>\\r\\n\\r\\n</p>\\r\\n\\r\\n<div class=\"text_exposed_show\">\\r\\n\\r\\n<p>* Rất nhiều mặt mụn đ&atilde; được chữa khỏi trả lại sự tự tin cho kh&aacute;ch h&agrave;ng. Gi&aacute; cho cả liệu tr&igrave;nh hợp l&yacute; nh&eacute;, v&igrave; NGUY&Ecirc;N LIỆU ho&agrave;n to&agrave;n bằng THẢO DƯỢC TỰ NHI&Ecirc;N CỦA VIỆT NAM.</p>\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n<p><img alt=\"undefined\" src=\"http://raovatphuly.vn/uploads/thumbs/product/16/600x600/1481384772-1517117411678504066390644210265227451797268n.jpg\" /></p>\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n<p>BẠN N&Agrave;O ĐANG KHỔ V&Igrave; MỤN li&ecirc;n hệ để được tư vấn miễn ph&iacute; v&agrave; dc soi da , kh&aacute;m da miễn ph&iacute;.</p>\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n<p><img alt=\"undefined\" src=\"http://raovatphuly.vn/uploads/thumbs/product/16/600x600/1481384773-1535579411770128390561548581959487521858857n.jpg\" /></p>\\r\\n\\r\\n\\r\\n\\r\\n\\r\\n<p>ĐỊA CHỈ LI&Ecirc;N HỆ: SPA THẢO DƯỢC H&Agrave; VY<br />\\r\\n\\r\\nSỐ 18 PHỐ BẠCH THẢI BƯỞI , VĂN QU&Aacute;N , H&Agrave; Đ&Ocirc;NG , HN<br />\\r\\n\\r\\nHOTLINE; 0120 3623686</p>\\r\\n</div>\\r\\n', '1481384759-1526756711770128290561558404952054071671415n.jpg', 'a:4:{i:0;s:59:\"1481384759-1526756711770128290561558404952054071671415n.jpg\";i:1;s:59:\"1481384772-1499187711678503833057338704771275037393415n.jpg\";i:2;s:59:\"1481384772-1517117411678504066390644210265227451797268n.jpg\";i:3;s:59:\"1481384773-1535579411770128390561548581959487521858857n.jpg\";}', 262, 'Ẩm thực - Du lịch', 100, '0', 0, 1, 0, 1, 22, 'Hà Nội', 113, NULL, 5, 'trịnh thị Hà', 1, 1481384759, 1481384759, 1481524170);
INSERT INTO `web_items` (`item_id`, `item_name`, `item_type_action`, `item_type_price`, `item_price_sell`, `item_area_price`, `item_content`, `item_image`, `item_image_other`, `item_category_id`, `item_category_name`, `item_category_parent_id`, `item_category_parent_name`, `item_number_view`, `item_status`, `item_is_hot`, `item_block`, `item_province_id`, `item_province_name`, `item_district_id`, `item_district_name`, `customer_id`, `customer_name`, `is_customer`, `time_ontop`, `time_created`, `time_update`) VALUES
(17, 'Hồng chi rừng (Nấm Hồng Linh Chi , xích chi, linh chi đỏ)', 1, 1, 600000, 0, '<p><strong>Sản phẩm nấm&nbsp;nguy&ecirc;n tai đảm bảo 100% tự nhi&ecirc;n từ n&uacute;i rừng t&acirc;y nguy&ecirc;n v&agrave; d&atilde;y Trường Sơn</strong><br />\\r\\n\\r\\n<strong>Quy c&aacute;ch đ&oacute;ng g&oacute;i: &nbsp;0.5Kg/G&oacute;i đ&atilde; h&uacute;t ch&acirc;n kh&ocirc;ng</strong><br />\\r\\n\\r\\n<strong>Thời hạn bảo quản: 12 th&aacute;ng kể tử ng&agrave;y mua h&agrave;ng</strong></p>\\r\\n\\r\\n<p>\\r\\n\\r\\n</p>\\r\\n\\r\\n<p><span style=\"color:rgb(102, 102, 102); font-family:sans-serif; font-size:12px\">- Dược l&yacute;, cơ chế t&aacute;c dụng v&agrave; ứng dụng l&acirc;m s&agrave;ng</span><br />\\r\\n\\r\\n<span style=\"color:rgb(102, 102, 102); font-family:sans-serif; font-size:12px\">- Điều tiết hệ thần kinh trung ương-</span><br />\\r\\n\\r\\n<span style=\"color:rgb(102, 102, 102); font-family:sans-serif; font-size:12px\">&nbsp;Tăng khả năng miễn dịch, hạn chế bệnh tật do l&agrave;m giatăng sản sinh số lượng cũng như hoạt ho&aacute; tế b&agrave;o miễn dịch lympho T, l&agrave;m tăng khả năng thực b&agrave;o.</span><br />\\r\\n\\r\\n<span style=\"color:rgb(102, 102, 102); font-family:sans-serif; font-size:12px\">&nbsp;- Cải thiện chức năng nội mạc, giảm h&agrave;m lượng triglycerid v&agrave; lipoprotein kh&ocirc;ng tốt (LDLc), đồng thời tăng h&agrave;m lượng lipoprotein tốt (HDLc), từ đ&oacute; gi&uacute;p điều chỉnh rối loạn lipid m&aacute;u, ngăn ngừa xơ vữa động mạch, ức chế kết tập tiểu cầu n&ecirc;n ngăn ngừa huyết khối g&acirc;y tắc mạch m&aacute;u.</span><br />\\r\\n\\r\\n<span style=\"color:rgb(102, 102, 102); font-family:sans-serif; font-size:12px\">&nbsp;- Điều ho&agrave; huyết &aacute;p, l&agrave;m bền th&agrave;nh mạch, tăng sức co b&oacute;p cơ tim m&agrave; kh&ocirc;ng l&agrave;m tăng nhu cầu oxy cơ tim, lợi cho bệnh nh&acirc;n mạch v&agrave;nh, nhồi m&aacute;u cơ tim.</span><br />\\r\\n\\r\\n<span style=\"color:rgb(102, 102, 102); font-family:sans-serif; font-size:12px\">&nbsp;- Chống l&atilde;o ho&aacute; do trung ho&agrave; kịp thời c&aacute;c gốc tự do trong cơ thể từ c&aacute;c qu&aacute; tr&igrave;nh sinh học hay c&aacute;c căng thẳng m&ocirc;i trường t&aacute;c động.</span><br />\\r\\n\\r\\n<span style=\"color:rgb(102, 102, 102); font-family:sans-serif; font-size:12px\">&nbsp;- Bảo vệ tế b&agrave;o, tăng cường tr&iacute; nhớ do tăng tuần ho&agrave;n v&agrave; ngăn chặn qu&aacute; tr&igrave;nh chết tế b&agrave;o diễn ra trong cơ thể.</span><br />\\r\\n\\r\\n<span style=\"color:rgb(102, 102, 102); font-family:sans-serif; font-size:12px\">&nbsp;- Ngăn ngừa v&agrave; hỗ trợ điều trị c&aacute;c cơn hen suyễn m&atilde;n t&iacute;nh do Linh chi c&oacute; khả năng gi&atilde;n cơ trơn phế quản, ức chế c&aacute;c phản ứng kh&aacute;ng nguy&ecirc;n kh&aacute;ng thể, l&agrave;m ổn định m&agrave;ng tế b&agrave;o mast để hạn chế giải ph&oacute;ng c&aacute;c chất trung gian ho&aacute; học g&acirc;y ra vi&ecirc;m v&agrave; hen.</span><br />\\r\\n\\r\\n<span style=\"color:rgb(102, 102, 102); font-family:sans-serif; font-size:12px\">&nbsp;- Tăng cường chuyển ho&aacute; c&aacute;c chất trong cơ thể nhờ v&agrave;o vai tr&ograve; c&aacute;c nguy&ecirc;n tố vi lượng trong Linh chi, đ&atilde; x&aacute;c định r&otilde; vai tr&ograve; của germani, tham gia x&uacute;c t&aacute;c chuỗi phản ứng ho&aacute; sinh trong cơ thể.</span><br />\\r\\n\\r\\n<span style=\"color:rgb(102, 102, 102); font-family:sans-serif; font-size:12px\">&nbsp;- Tăng khả năng tổng hợp c&aacute;c acid nucleic nh&acirc;n tế b&agrave;o (ADN, ARN), sinh tổng hợp protein n&ecirc;n c&oacute; khả năng k&iacute;ch th&iacute;ch cơ thể tạo ra tế b&agrave;o mới thay thế những tế b&agrave;o cũ của cơ thể đ&atilde; bị gi&agrave; nua.</span><br />\\r\\n\\r\\n<span style=\"color:rgb(102, 102, 102); font-family:sans-serif; font-size:12px\">&nbsp;- L&agrave;m chậm, l&agrave;m ti&ecirc;u giảm c&aacute;c tế b&agrave;o khối u.</span><br />\\r\\n\\r\\n<span style=\"color:rgb(102, 102, 102); font-family:sans-serif; font-size:12px\">&nbsp;- Một th&agrave;nh phần của polysaccharid trong Linh chi l&agrave; oligosaccharid c&oacute; t&aacute;c dụng cải thiện hệ tuần ho&agrave;n ngoại vi ở da, tăng lưu th&ocirc;ng trao đổi chất, tăng khả năng vận chuyển oxy của huyết cầu tố (hemoglobin).Ngo&agrave;i ra, Linh chi c&ograve;n c&oacute; c&aacute;c t&aacute;c dụng kh&aacute;c như l&agrave;m tăng sức lọc cầu thận.C&aacute;ch nấu :1.Th&aacute;i l&aacute;t (Đ&acirc;y l&agrave; c&aacute;ch phổ biến nhất hiện n&agrave;y được đại đa số người ti&ecirc;u d&ugrave;ng lựa chọn)</span><br />\\r\\n\\r\\n<span style=\"color:rgb(102, 102, 102); font-family:sans-serif; font-size:12px\">&nbsp;- Cho 20-30g Linh chi v&agrave;o ấm đun c&ugrave;ng với 1.000cc nước, đun khoảng 10 ph&uacute;t rồi tắt lửa. Để ng&acirc;m như vậy trong v&ograve;ng 5 ph&uacute;t rồi đun tiếp khoảng 30 ph&uacute;t bằng lửa nhỏ. Đun đến khi nước cạn c&ograve;n khoảng 600cc th&igrave; ta được nước đầu ti&ecirc;n. Sau khi được nước đầu lấy l&aacute;t Linh chi ra ,d&ugrave;ng k&eacute;o cắt nhỏ (khoảng 1cm) rồi cho 800cc nước &nbsp;v&agrave;o ,đun nước 2 v&agrave; 3 như khi lấy nước đầu.-Sau đ&oacute; đổ lẫn nước đầu, nước 2 v&agrave; nước 3 v&agrave;o h&ograve;a chung với nhau , rồi cho v&agrave;o b&igrave;nh v&agrave; bảo quản trong tủ lạnh để uống l&agrave;m nhiều lần trong ng&agrave;y.2. Xay th&agrave;nh bột.</span><br />\\r\\n\\r\\n<span style=\"color:rgb(102, 102, 102); font-family:sans-serif; font-size:12px\">&nbsp;-Lấy 15-25gr bột linh chi &nbsp;c&ugrave;ng 800cc nước &nbsp;v&agrave;o nấu s&ocirc;i &nbsp;khoảng 15 ph&uacute;t rồi chiết nước &nbsp;ra d&ugrave;ng ,c&oacute; thể nấu th&ecirc;m 1 lần nữa cho ra hết chất.</span><br />\\r\\n\\r\\n<span style=\"color:rgb(102, 102, 102); font-family:sans-serif; font-size:12px\">&nbsp;Lưu &yacute; - Cần uống nhiều nước khi d&ugrave;ng Nấm Linh Chi để thải ra những độc tố lưu lại trong cơ thể, v&agrave; tốt nhất n&ecirc;n uống ch&uacute;ng v&agrave;o buổi s&aacute;ng l&uacute;c bụng đ&oacute;i.</span><br />\\r\\n\\r\\n<span style=\"color:rgb(102, 102, 102); font-family:sans-serif; font-size:12px\">&nbsp;- Những người qu&aacute; nhạy cảm cũng c&oacute; thể gặp một v&agrave;i triệu chứng như cảm thấy hơi kh&oacute; ti&ecirc;u, ch&oacute;ng mặt, hay ngứa ngo&agrave;i da trong thời gian đầu d&ugrave;ng Nấm Linh Chi. T&igrave;nh trạng n&agrave;y xảy ra do phản ứng mạnh của cơ thể b&agrave;i tiết những độc tố c&oacute; trong cơ thể v&agrave; chứng tỏ t&aacute;c dụng tốt của Nấm Linh Chi. Những người n&agrave;y sẽ trở lại b&igrave;nh thường sau một thời gian.</span><br />\\r\\n\\r\\n<span style=\"color:rgb(102, 102, 102); font-family:sans-serif; font-size:12px\">&nbsp;- Nấm Linh Chi l&agrave; dược chất thi&ecirc;n nhi&ecirc;n bổ sung cho sức khỏe, kh&ocirc;ng c&oacute; chống chỉ định.-Tuy nhi&ecirc;n, cẩn thận hơn cho những bệnh nh&acirc;n đang cấy gh&eacute;p nội tạng v&agrave; đang dung thuốc chống miễn dịch. N&ecirc;n hỏi &yacute; kiến thầy thuốc trước khi d&ugrave;ng bất cứ dược thảo bổ sung n&agrave;o trong qu&aacute; tr&igrave;nh điều trị bệnh.</span></p>\\r\\n\\r\\n<p>\\r\\n\\r\\n</p>\\r\\n\\r\\n<p><a href=\"http://www.namdalat.com/index.php?route=product/product&amp;product_id=75\">http://www.namdalat.com/index.php?route=product/product&amp;product_id=75</a></p>\\r\\n\\r\\n<p>\\r\\n</p>\\r\\n', '1481507786-nam-linh-chi-nhat-pham-thai-lat-4.jpg', 'a:1:{i:0;s:48:\"1481507786-nam-linh-chi-nhat-pham-thai-lat-4.jpg\";}', 264, 'Khác', 100, '0', 0, 1, 0, 1, 36, 'Lâm Đồng', 58, NULL, 8, 'Anh Nguyên Bùi', 1, 1481507786, 1481507786, 1482630802),
(18, 'Đồ dùng nước ngoài xách tay - Đức, Nga, Úc...', 1, 2, 0, 0, '<p>Đợt gom h&agrave;ng Đức lần n&agrave;y c&oacute; mẹ n&agrave;o cần mua th&ecirc;m g&igrave; kh&ocirc;ng th&igrave; b&aacute;o em nh&eacute;! Sắp tới sẽ c&oacute; nhiều sp của b&eacute; c&ugrave;ng về để c&aacute;c mẹ lựa chọn: sữa tắm , kem chống hăm, dầu massage, thuộc trị con tr&ugrave;ng, kem nẻ , bột ăn dặm,...Ngo&agrave;i ra mẹ n&agrave;o c&oacute; nhu cầu sữa Aptamil th&igrave; em sẽ đặt giúp. <img alt=\"undefined\" src=\"http://raovatphuly.vn/uploads/thumbs/product/18/600x600/1482054837-3.jpg\" /></p>\\r\\n\\r\\n<p>V&igrave; sữa ở đấy theo gi&aacute; shop em t&iacute;nh ra đ&atilde; ngang gi&aacute; ở Việt Nam rồi. N&ecirc;n mẹ n&agrave;o cần th&igrave; đặt em mua tầm 9.1 h&agrave;ng về, chậm ch&uacute;t do lịch nghỉ tết.</p>\\r\\n\\r\\n<p><img alt=\"undefined\" src=\"http://raovatphuly.vn/uploads/thumbs/product/18/600x600/1482054844-1.jpg\" /></p>\\r\\n\\r\\n<p><img alt=\"undefined\" src=\"http://raovatphuly.vn/uploads/thumbs/product/18/600x600/1482054844-4.jpg\" /></p>\\r\\n\\r\\n<p><img alt=\"undefined\" src=\"http://raovatphuly.vn/uploads/thumbs/product/18/600x600/1482054845-2.jpg\" /></p>\\r\\n\\r\\n<p><img alt=\"\" height=\"16\" src=\"https://www.facebook.com/images/emoji.php/v6/f22/1/16/260e.png\" width=\"16\" />☎️ 0985101026 hoặc comment, ib em nh&eacute;!</p>\\r\\n', '1482054837-3.jpg', 'a:4:{i:0;s:16:\"1482054837-3.jpg\";i:1;s:16:\"1482054844-1.jpg\";i:2;s:16:\"1482054844-4.jpg\";i:3;s:16:\"1482054845-2.jpg\";}', 261, 'Thời trang - Làm đẹp', 100, '0', 0, 1, 0, 1, 22, 'Hà Nội', 2, NULL, 7, 'Gian Hàng Của Tôi', 1, 1482054837, 1482054837, 1482055057),
(19, 'BÁNH KẸO NHẬP KHẨU phục vụ Tết 2017', 1, 2, 0, 0, '<p><img alt=\"undefined\" src=\"http://raovatphuly.vn/uploads/thumbs/product/19/600x600/1482228770-4.jpg\" /><img alt=\"undefined\" src=\"http://raovatphuly.vn/uploads/thumbs/product/19/600x600/1482228777-1.jpg\" /><img alt=\"undefined\" src=\"http://raovatphuly.vn/uploads/thumbs/product/19/600x600/1482228778-2.jpg\" /><img alt=\"undefined\" src=\"http://raovatphuly.vn/uploads/thumbs/product/19/600x600/1482228778-3.jpg\" /><img alt=\"undefined\" src=\"http://raovatphuly.vn/uploads/thumbs/product/19/600x600/1482228778-5.jpg\" /></p>\\r\\n', '1482228770-4.jpg', 'a:5:{i:0;s:16:\"1482228770-4.jpg\";i:1;s:16:\"1482228777-1.jpg\";i:2;s:16:\"1482228778-2.jpg\";i:3;s:16:\"1482228778-3.jpg\";i:4;s:16:\"1482228778-5.jpg\";}', 262, 'Ẩm thực - Du lịch', 100, '0', 0, 1, 0, 1, 22, 'Hà Nội', 2, NULL, 7, 'Gian Hàng Của Tôi', 1, 1482228770, 1482228770, 1482244701),
(20, 'Trà sâm Hàn quốc', 1, 1, 250000, 0, '<p>&nbsp;Tr&agrave; s&acirc;m H&agrave;n quốc</p>\\r\\n\\r\\n<p>Gi&uacute;p tăng tuần ho&agrave;n n&atilde;o, tăng cường tr&iacute; nhớ v&agrave; sức đề kh&aacute;ng, ngo&agrave;i ra tr&agrave; s&acirc;m c&ograve;n gi&uacute;p m&aacute;t gan, ph&ograve;ng ngừa ung thư v&agrave; tốt cho ti&ecirc;u h&oacute;a...</p>\\r\\n\\r\\n<p><img alt=\"undefined\" src=\"http://raovatphuly.vn/uploads/thumbs/product/20/600x600/1482228889-1.jpg\" /><br />\\r\\nBạn sẽ thấy sảng kho&aacute;i v&agrave; khỏe mạnh hơn chỉ với 2.5k mỗi ng&agrave;y.<br />\\r\\nHộp 100 g&oacute;i ( 100gr)<br />\\r\\nGi&aacute; 250k</p>\\r\\n', '1482228889-1.jpg', 'a:1:{i:0;s:16:\"1482228889-1.jpg\";}', 262, 'Ẩm thực - Du lịch', 100, '0', 0, 1, 0, 1, 22, 'Hà Nội', 2, NULL, 7, 'Gian Hàng Của Tôi', 1, 1482228889, 1482228889, 1482230752),
(21, 'Nồi hấp nhập khẩu', 1, 2, 0, 0, '<p>Hấp l&agrave; phương ph&aacute;p l&agrave;m ch&iacute;n thức ăn đảm bảo kh&ocirc;ng mất chất dưỡng nhất . Tuy nhi&ecirc;n c&aacute;c Nồi hấp th&ocirc;ng thường kh&oacute; c&oacute; thể l&agrave;m đồ ăn ch&iacute;n nhanh v&agrave; đều được . Sản phẩm Russel Hobbs rất ph&ugrave; hợp với những gia đ&igrave;nh hiện đại v&agrave; kh&aacute;c phục mọi điểm yếu của nồi hấp th&ocirc;ng thường Phục vụ cho c&aacute;c m&oacute;n hấp giữ được độ đẹp của thực phẩm cũng như chất dinh dưỡng vẫn được đảm bảo. Mẹ n&agrave;o c&oacute; nhu cầu inbox nh&eacute;.</p>\\r\\n\\r\\n<p><img alt=\"undefined\" src=\"http://raovatphuly.vn/uploads/thumbs/product/21/600x600/1482229029-4.jpg\" /><img alt=\"undefined\" src=\"http://raovatphuly.vn/uploads/thumbs/product/21/600x600/1482229030-3.jpg\" /><img alt=\"undefined\" src=\"http://raovatphuly.vn/uploads/thumbs/product/21/600x600/1482229028-2.jpg\" /><img alt=\"undefined\" src=\"http://raovatphuly.vn/uploads/thumbs/product/21/600x600/1482229020-5.jpg\" /></p>\\r\\n\\r\\n<p><img alt=\"\" height=\"16\" src=\"https://www.facebook.com/images/emoji.php/v6/f22/1/16/260e.png\" width=\"16\" />☎️ 0985101026</p>\\r\\n', '1482229029-4.jpg', 'a:4:{i:0;s:16:\"1482229020-5.jpg\";i:1;s:16:\"1482229028-2.jpg\";i:2;s:16:\"1482229029-4.jpg\";i:3;s:16:\"1482229030-3.jpg\";}', 260, 'Điện tử - Kỹ thuật số', 100, '0', 0, 1, 0, 1, 22, 'Hà Nội', 2, NULL, 7, 'Gian Hàng Của Tôi', 1, 1482229020, 1482229020, 1482229631),
(22, 'Sữa Đức cho bé nhập khẩu', 1, 2, 0, 0, '<p>&nbsp;Đợt gom h&agrave;ng Đức lần n&agrave;y c&oacute; mẹ n&agrave;o cần mua th&ecirc;m g&igrave; kh&ocirc;ng th&igrave; b&aacute;o em nh&eacute;! Sắp tới sẽ c&oacute; nhiều sp của b&eacute; c&ugrave;ng về để c&aacute;c mẹ lựa chọn: sữa tắm , kem chống hăm, dầu massage, thuộc trị con tr&ugrave;ng, kem nẻ , bột ăn dặm,...Ngo&agrave;i ra mẹ n&agrave;o c&oacute; nhu cầu sữa Aptamil th&igrave; em sẽ đặt giúp. V&igrave; sữa ở đấy theo gi&aacute; shop em t&iacute;nh ra đ&atilde; ngang gi&aacute; ở Việt Nam rồi. N&ecirc;n mẹ n&agrave;o cần th&igrave; đặt em mua tầm 9.1 h&agrave;ng về, chậm ch&uacute;t do lịch nghỉ tết.</p>\\r\\n\\r\\n<p><img alt=\"\" height=\"16\" src=\"https://www.facebook.com/images/emoji.php/v6/f22/1/16/260e.png\" width=\"16\" />☎️ 0985101026 hoặc comment, ib em nh&eacute;!</p>\\r\\n\\r\\n<p><img alt=\"undefined\" src=\"http://raovatphuly.vn/uploads/thumbs/product/22/600x600/1482229251-1.jpg\" /><img alt=\"undefined\" src=\"http://raovatphuly.vn/uploads/thumbs/product/22/600x600/1482229256-2.jpg\" /><img alt=\"undefined\" src=\"http://raovatphuly.vn/uploads/thumbs/product/22/600x600/1482229257-3.jpg\" /><img alt=\"undefined\" src=\"http://raovatphuly.vn/uploads/thumbs/product/22/600x600/1482229257-4.jpg\" /></p>\\r\\n', '1482229251-1.jpg', 'a:4:{i:0;s:16:\"1482229251-1.jpg\";i:1;s:16:\"1482229256-2.jpg\";i:2;s:16:\"1482229257-3.jpg\";i:3;s:16:\"1482229257-4.jpg\";}', 262, 'Ẩm thực - Du lịch', 100, '0', 0, 1, 0, 1, 22, 'Hà Nội', 2, NULL, 7, 'Gian Hàng Của Tôi', 1, 1482229251, 1482229251, 1482229302),
(23, 'Quạt sưởi điện SILVERCREST', 1, 2, 0, 0, '<p>Quạt sưởi điện SILVERCREST h&agrave;ng đ&atilde; về c&oacute; sẵn. C&aacute;c bố mẹ lựa chọn cho c&aacute;c b&eacute; y&ecirc;u nha</p>\\r\\n\\r\\n<div class=\"text_exposed_show\">\\r\\n<p><img alt=\"\" height=\"16\" src=\"https://www.facebook.com/images/emoji.php/v6/f33/1/16/2705.png\" width=\"16\" />✅ Silvercrest l&agrave; h&atilde;ng nội địa Đức được đ&aacute;nh gi&aacute; rất cao m&agrave; gi&aacute; th&agrave;nh hợp l&yacute; v&ocirc; c&ugrave;ng<br />\\r\\n<img alt=\"\" height=\"16\" src=\"https://www.facebook.com/images/emoji.php/v6/f33/1/16/2705.png\" width=\"16\" />✅ Rating 4,4/5 *<br />\\r\\n<img alt=\"\" height=\"16\" src=\"https://www.facebook.com/images/emoji.php/v6/f33/1/16/2705.png\" width=\"16\" />✅ Ưu điểm :<br />\\r\\n- Điều khiển từ xa<br />\\r\\n- L&agrave;m ấm nhanh khu vực xung quanh bằng gi&oacute; ấm<br />\\r\\n- C&agrave;i đặt mức nhiệt độ ph&ugrave; hợp từ 6 đ&ecirc;n 38 độ C, thời gian sưởi nhiệt tới 23 tiếng 59 ph&uacute;t li&ecirc;n tục<br />\\r\\n- M&agrave;n h&igrave;nh hiển thị LC cho biết nhiệt độ xung quanh khu vực sưởi đạt nhiệt độ bao nhi&ecirc;u<br />\\r\\n- Tự động tắt an to&agrave;n khi c&oacute; sự cố điện<br />\\r\\n- Hai mức c&ocirc;ng suất để lựa chọn : 1000 watt v&agrave; 2000 watt<br />\\r\\n- AN TO&Agrave;N<br />\\r\\n- K&iacute;ch thước : 22 x 33 x 15 cm</p>\\r\\n</div>\\r\\n', '1482229543-3.jpg', 'a:3:{i:0;s:16:\"1482229543-3.jpg\";i:1;s:16:\"1482229548-1.jpg\";i:2;s:16:\"1482229549-2.jpg\";}', 260, 'Điện tử - Kỹ thuật số', 100, '0', 0, 1, 0, 1, 22, 'Hà Nội', 2, NULL, 7, 'Gian Hàng Của Tôi', 1, 1482229543, 1482229543, 1482250149),
(24, 'Hoa chuẩn bị tết đinh dậu 2017', 1, 2, 0, 0, '<p>Chuy&ecirc;n cung cấp :<br />\\r\\n+ hoa lan : địa lan, lan hồ điệp, lan vũ nữ, delro,...<br />\\r\\n+hoa ly: hồng &ugrave; sorbone, v&agrave;ng &ugrave; concador, hồng &ugrave; marlon, đỏ &ugrave; robina,...<br />\\r\\n+tulip : đủ c&aacute;c m&agrave;u<br />\\r\\n+ c&aacute;c loại hoa #: lavender chậu, hương thảo chậu, kim ph&aacute;t t&agrave;i chậu<br />\\r\\nRất h&acirc;n hạnh phục vụ qu&yacute; kh&aacute;ch !!!</p>\\r\\n\\r\\n<p><img alt=\"undefined\" src=\"http://raovatphuly.vn/uploads/thumbs/product/24/600x600/1482286471-3.jpg\" /></p>\\r\\n\\r\\n<p><img alt=\"undefined\" src=\"http://raovatphuly.vn/uploads/thumbs/product/24/600x600/1482286476-1.jpg\" /></p>\\r\\n\\r\\n<p><img alt=\"undefined\" src=\"http://raovatphuly.vn/uploads/thumbs/product/24/600x600/1482286477-4.jpg\" /></p>\\r\\n\\r\\n<p><img alt=\"undefined\" src=\"http://raovatphuly.vn/uploads/thumbs/product/24/600x600/1482286477-2.jpg\" /></p>\\r\\n\\r\\n<p>&nbsp;</p>\\r\\n', '1482286477-4.jpg', 'a:4:{i:0;s:16:\"1482286471-3.jpg\";i:1;s:16:\"1482286476-1.jpg\";i:2;s:16:\"1482286477-4.jpg\";i:3;s:16:\"1482286477-2.jpg\";}', 264, 'Khác', 100, '0', 0, 1, 0, 1, 36, 'Lâm Đồng', 58, NULL, 8, 'Anh Nguyên Bùi', 1, 1482286471, 1482286471, 1482630784),
(25, 'Sữa Ensure Đức xách tay 400g - hương Vanilla', 1, 2, 0, 0, '<p>&nbsp;Ensure Đức x&aacute;ch tay 400g - hương Vanilla</p>\\r\\n\\r\\n<p>Sữa Ensure nh&eacute; c&aacute;c mẹ. Sữa Ensure d&ugrave;ng được cho mọi lứa tuổi, đặc biệt l&agrave; đối với: người cao tuổi; người ốm; người bị suy dinh dưỡng; suy nhược cơ thể,.. (kh&ocirc;ng n&ecirc;n d&ugrave;ng cho Trẻ dưới 3 tuổi - Đối với c&aacute;c B&eacute;, n&ecirc;n d&ugrave;ng c&aacute;c loại d&agrave;nh ri&ecirc;ng cho từng th&aacute;ng tuổi sẽ ph&ugrave; hợp với hệ ti&ecirc;u h&oacute;a của B&eacute;).</p>\\r\\n\\r\\n<p>Gi&aacute; lẻ 350k. Bu&ocirc;n cả th&ugrave;ng 24 hộp gi&aacute; 320k/ hộp. H&agrave;ng về 16.1 nha!</p>\\r\\n\\r\\n<p>Ai quan t&acirc;m, vui l&ograve;ng Tel.: 0985101026, comment hoặc ib em nh&eacute;!</p>\\r\\n\\r\\n<p><img alt=\"undefined\" src=\"http://raovatphuly.vn/uploads/thumbs/product/25/600x600/1482301104-4.jpg\" /></p>\\r\\n\\r\\n<p><img alt=\"undefined\" src=\"http://raovatphuly.vn/uploads/thumbs/product/25/600x600/1482301380-1.jpg\" /></p>\\r\\n\\r\\n<p><img alt=\"undefined\" src=\"http://raovatphuly.vn/uploads/thumbs/product/25/600x600/1482301381-3.jpg\" /></p>\\r\\n\\r\\n<p><img alt=\"undefined\" src=\"http://raovatphuly.vn/uploads/thumbs/product/25/600x600/1482301381-2.jpg\" /></p>\\r\\n\\r\\n<p>&nbsp;</p>\\r\\n', '1482301380-1.jpg', 'a:4:{i:0;s:16:\"1482301104-4.jpg\";i:1;s:16:\"1482301380-1.jpg\";i:2;s:16:\"1482301381-3.jpg\";i:3;s:16:\"1482301381-2.jpg\";}', 262, 'Ẩm thực - Du lịch', 100, '0', 0, 1, 0, 1, 22, 'Hà Nội', 2, NULL, 7, 'Gian Hàng Của Tôi', 1, 1482301104, 1482301104, 1482302281),
(26, 'Máy lọc nước tại vòi BRITA của Đức', 1, 2, 0, 0, '<p>&nbsp;M&aacute;y lọc nước tại v&ograve;i BRITA của Đức =&gt;&gt;&gt; rất ph&ugrave; hợp với thời đại &quot;&ocirc; nhiễm nguồn nước&quot; kh&aacute; nặng như hiện nay để bảo vệ sức khỏe.</p>\\r\\n\\r\\n<p><img alt=\"undefined\" src=\"http://raovatphuly.vn/uploads/thumbs/product/26/600x600/1482488663-5.jpg\" /></p>\\r\\n\\r\\n<p>1. Kh&ocirc;ng cần lắp đặt, người d&ugrave;ng c&oacute; thể tự th&aacute;o lắp dễ d&agrave;ng v&agrave; ph&ugrave; hợp với c&aacute;c loại v&ograve;i ở bồn rửa ch&eacute;n b&aacute;t</p>\\r\\n\\r\\n<p><img alt=\"undefined\" src=\"http://raovatphuly.vn/uploads/thumbs/product/26/600x600/1482488674-2.jpg\" /></p>\\r\\n\\r\\n<div class=\"text_exposed_show\">\\r\\n<p>2. Kh&ocirc;ng sử dụng điện n&ecirc;n mất điện vẫn c&oacute; nước lọc b&igrave;nh thường</p>\\r\\n\\r\\n<p><img alt=\"undefined\" src=\"http://raovatphuly.vn/uploads/thumbs/product/26/600x600/1482488674-3.jpg\" /></p>\\r\\n\\r\\n<p>3. Mỗi hộp lọc lọc d&ugrave;ng được từ 5- 8 th&aacute;ng t&ugrave;y thuộc lượng nước lọc, lượng nước lọc tối đa 1200 l&iacute;t. Tr&ecirc;n m&aacute;y lọc c&oacute; đ&egrave;n b&aacute;o hiệu khi n&agrave;o th&igrave; cần thay l&otilde;i lọc mới</p>\\r\\n\\r\\n<p><img alt=\"undefined\" src=\"http://raovatphuly.vn/uploads/thumbs/product/26/600x600/1482488673-4.jpg\" /></p>\\r\\n\\r\\n<p>4. M&aacute;y lọc c&oacute; c&ocirc;ng tắc 2 chế độ để bạn điều chỉnh khi sử dụng gồm chế độ LỌC v&agrave; KH&Ocirc;NG LỌC. Chỉ cần thao t&aacute;c d&ugrave;ng tay vặn c&ocirc;ng tắc l&agrave; c&oacute; thể chuyển đổi giữa 2 chế độ n&agrave;y, đ&acirc;y l&agrave; t&iacute;nh năng v&ocirc; c&ugrave;ng tiện dụng.</p>\\r\\n\\r\\n<p><img alt=\"undefined\" src=\"http://raovatphuly.vn/uploads/thumbs/product/26/600x600/1482488673-1.jpg\" /></p>\\r\\n\\r\\n<p>5. Chất liệu sản phẩm Bria l&agrave; nhựa nguy&ecirc;n sinh kh&ocirc;ng chứa chất BPA (chất BPA l&agrave; hợp chất rất độc để l&agrave;m cứng nhựa trong qu&aacute; tr&igrave;nh sản xuất v&agrave; dễ bị phơi nhiễm trong qu&aacute; tr&igrave;nh sử dụng, l&agrave; t&aacute;c nh&acirc;n g&acirc;y ung thư v&agrave; c&aacute;c loại bệnh&hellip;)</p>\\r\\n\\r\\n<p>&nbsp;</p>\\r\\n</div>\\r\\n', '1482488663-5.jpg', 'a:5:{i:0;s:16:\"1482488663-5.jpg\";i:1;s:16:\"1482488673-1.jpg\";i:2;s:16:\"1482488673-4.jpg\";i:3;s:16:\"1482488674-2.jpg\";i:4;s:16:\"1482488674-3.jpg\";}', 260, 'Điện tử - Kỹ thuật số', 100, '0', 0, 1, 0, 1, 22, 'Hà Nội', 2, NULL, 7, 'Gian Hàng Của Tôi', 1, 1482488663, 1482488663, 1482488774),
(27, 'Kem dưỡng ẩm nivea intensive pflege', 1, 2, 0, 0, '<p>&nbsp;Kem dưỡng ẩm nivea intensive pflege: với c&ocirc;ng thức Hydro grow ho&agrave; trộn ngay khi thoa l&ecirc;n da , duy tr&igrave; cho da mặt c&ugrave;ng cơ thể với chế độ đặc biệt. C&aacute;c kết cấu hấp thu nhanh kh&ocirc;ng g&acirc;y nhờn , l&agrave;m da sẽ trở n&ecirc;n mịn m&agrave;ng v&agrave; dẻo dai sau khi sử dụng. Ph&ugrave; hợp mọi loại da kể cả da nhạy cảm. Bạn c&oacute; thể sử dụng đều đặn h&agrave;ng ng&agrave;y 2 lần s&aacute;ng, tối</p>\\r\\n\\r\\n<p>H&agrave;ng sẵn <img alt=\"\" height=\"16\" src=\"https://www.facebook.com/images/emoji.php/v6/f5a/1/16/1f4b0.png\" width=\"16\" />', '1482494035-1.jpg', 'a:3:{i:0;s:16:\"1482494035-1.jpg\";i:1;s:16:\"1482494040-2.jpg\";i:2;s:16:\"1482494041-3.jpg\";}', 261, 'Thời trang - Làm đẹp', 100, '0', 0, 1, 0, 1, 22, 'Hà Nội', 2, NULL, 7, 'Gian Hàng Của Tôi', 1, 1482494035, 1482494035, 1482494065),
(28, 'Xách Tay Hàn Quốc : Sâm - Táo Đỏ Sấy Khô', 1, 2, 0, 0, '<p>Cảm ơn cả nh&agrave; ủng hộ, đợt h&agrave;ng T&aacute;o đỏ (kh&ocirc;ng phải 10kg m&agrave; l&agrave; 15kg) v&agrave; s&acirc;m tươi được người quen nh&agrave; em x&aacute;ch b&ecirc;n H&agrave;n vừa về đ&atilde; hết sạch!!!</p>\\r\\n\\r\\n<p>V&igrave; nhu cầu đặt h&agrave;ng cho Tết kh&aacute; lớn, em mạnh dạn nhờ người quen tiếp tục nhận order đến 15/1 để 20/1 h&agrave;ng kịp về Tết phục vụ b&agrave; con!</p>\\r\\n\\r\\n<div class=\"text_exposed_show\">\\r\\n<p>KHUYẾN M&Atilde;I NH&Acirc;N DỊP TẾT:</p>\\r\\n\\r\\n<p><img alt=\"undefined\" src=\"http://raovatphuly.vn/uploads/thumbs/product/28/600x600/1482630684-1.jpg\" /></p>\\r\\n\\r\\n<p><img alt=\"undefined\" src=\"http://raovatphuly.vn/uploads/thumbs/product/28/600x600/1482630691-2.jpg\" /></p>\\r\\n\\r\\n<p><img alt=\"undefined\" src=\"http://raovatphuly.vn/uploads/thumbs/product/28/600x600/1482630691-4.jpg\" /></p>\\r\\n\\r\\n<p><img alt=\"undefined\" src=\"http://raovatphuly.vn/uploads/thumbs/product/28/600x600/1482630692-3.jpg\" /></p>\\r\\n\\r\\n<p><img alt=\"undefined\" src=\"http://raovatphuly.vn/uploads/thumbs/product/28/600x600/1482630692-5.jpg\" /></p>\\r\\n\\r\\n<p>&nbsp;</p>\\r\\n</div>\\r\\n', '1482630684-1.jpg', 'a:5:{i:0;s:16:\"1482630684-1.jpg\";i:1;s:16:\"1482630691-2.jpg\";i:2;s:16:\"1482630691-4.jpg\";i:3;s:16:\"1482630692-3.jpg\";i:4;s:16:\"1482630692-5.jpg\";}', 264, 'Tin rao khác', 100, '0', 0, 1, 0, 1, 22, 'Hà Nội', 2, NULL, 7, 'Gian Hàng Của Tôi', 1, 1482630684, 1482630684, 1482631474),
(29, 'Xách Tay Đức - Phấn không chì', 1, 2, 0, 0, '<p>Phấn KH&Ocirc;NG CH&Igrave; tội g&igrave; kh&ocirc;ng đ&aacute;nh. D&agrave;nh cho những n&agrave;ng thường xuy&ecirc;n phải trang điểm kh&ocirc;ng lo hại da, d&agrave;nh cho những n&agrave;ng cần một sản phẩm thật mịn, thật tự nhi&ecirc;n, kiềm dầu, tho&aacute;ng da. Chỉ c&oacute; thể l&agrave; phấn Đức Mousse th&ocirc;iiiiii <img alt=\"\" height=\"16\" src=\"https://www.facebook.com/images/emoji.php/v6/f75/1/16/1f618.png\" width=\"16\" /></p>\\r\\n\\r\\n<p><img alt=\"undefined\" src=\"http://raovatphuly.vn/uploads/thumbs/product/29/600x600/1482631119-1.jpg\" /></p>\\r\\n\\r\\n<p><img alt=\"undefined\" src=\"http://raovatphuly.vn/uploads/thumbs/product/29/600x600/1482631125-2.jpg\" /></p>\\r\\n\\r\\n<p><img alt=\"undefined\" src=\"http://raovatphuly.vn/uploads/thumbs/product/29/600x600/1482631125-3.jpg\" /></p>\\r\\n\\r\\n<p>&nbsp;</p>\\r\\n', '1482631119-1.jpg', 'a:3:{i:0;s:16:\"1482631119-1.jpg\";i:1;s:16:\"1482631125-2.jpg\";i:2;s:16:\"1482631125-3.jpg\";}', 264, 'Tin rao khác', 100, '0', 0, 1, 0, 1, 22, 'Hà Nội', 2, NULL, 7, 'Gian Hàng Của Tôi', 1, 1482631119, 1482631119, 1482631519),
(30, 'Xách Tay Đức - Đèn Led phòng ngủ cho trẻ', 1, 2, 0, 0, '<p>B&aacute;n đồ Đức nh&igrave;n c&aacute;i g&igrave; cũng muốn nh&agrave; d&ugrave;ng thử hết ấy c&aacute;c chị ah.</p>\\r\\n\\r\\n<p>C&aacute;i đ&egrave;n n&agrave;y bạn em đang định lấy về cho b&eacute; nh&agrave; d&ugrave;ng, đăng l&ecirc;n đ&acirc;y cho c&aacute;c mẹ c&oacute; nhu cầu order c&ugrave;ng nh&eacute;, c&oacute; đ&egrave;n n&agrave;y đảm bảo c&aacute;c bạn ấy sẽ chịu ra ngủ ri&ecirc;ng lu&ocirc;n ấy</p>\\r\\n\\r\\n<div class=\"text_exposed_show\">\\r\\n<p>Đ&egrave;n chiếu trong ph&ograve;ng ngủ:<br />\\r\\n- &Aacute;nh s&aacute;ng LED dịu nhẹ, tự động bật khi ph&ograve;ng tối nhờ v&agrave;o bộ phận cảm ứng của đ&egrave;n<br />\\r\\n- H&igrave;nh chiếu nhiều motiv dễ thương sinh động (đ&egrave;n gồm 6 h&igrave;nh để c&aacute;c b&eacute; lựa chọn, mỗi tối 1 h&igrave;nh l&agrave; đủ cả tuần)<br />\\r\\n- Điềi khiển vị tr&iacute; chiếu h&igrave;nh 360 độ (tr&ecirc;n trần nh&agrave;, tr&ecirc;n tường ...)</p>\\r\\n</div>\\r\\n\\r\\n<p>&nbsp;<img alt=\"undefined\" src=\"http://raovatphuly.vn/uploads/thumbs/product/30/600x600/1482631286-4.jpg\" /></p>\\r\\n\\r\\n<p><img alt=\"undefined\" src=\"http://raovatphuly.vn/uploads/thumbs/product/30/600x600/1482631292-1.jpg\" /></p>\\r\\n\\r\\n<p><img alt=\"undefined\" src=\"http://raovatphuly.vn/uploads/thumbs/product/30/600x600/1482631292-3.jpg\" /></p>\\r\\n\\r\\n<p><img alt=\"undefined\" src=\"http://raovatphuly.vn/uploads/thumbs/product/30/600x600/1482631293-2.jpg\" /></p>\\r\\n', '1482631286-4.jpg', 'a:4:{i:0;s:16:\"1482631286-4.jpg\";i:1;s:16:\"1482631292-1.jpg\";i:2;s:16:\"1482631292-3.jpg\";i:3;s:16:\"1482631293-2.jpg\";}', 260, 'Điện tử - Kỹ thuật số', 100, '0', 0, 1, 0, 1, 22, 'Hà Nội', 2, NULL, 7, 'Gian Hàng Của Tôi', 1, 1482631286, 1482631286, 1482631573);

-- --------------------------------------------------------

--
-- Table structure for table `web_news`
--

CREATE TABLE `web_news` (
  `news_id` int(11) NOT NULL,
  `news_title` varchar(255) DEFAULT NULL,
  `news_desc_sort` text,
  `news_content` text,
  `news_image` varchar(255) DEFAULT NULL COMMENT 'ảnh đại diện của bài viết',
  `news_image_other` varchar(255) DEFAULT NULL COMMENT 'Lưu ảnh của bài viết',
  `news_type` tinyint(5) DEFAULT '1' COMMENT 'Kiểu tin',
  `news_category` int(11) DEFAULT NULL,
  `news_status` tinyint(5) DEFAULT NULL,
  `news_create` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `web_news`
--

INSERT INTO `web_news` (`news_id`, `news_title`, `news_desc_sort`, `news_content`, `news_image`, `news_image_other`, `news_type`, `news_category`, `news_status`, `news_create`) VALUES
(1, 'Quy chế đăng tin', '', '<p><strong>a. Đối tượng đăng tin:</strong></p>\\r\\n\\r\\n<p>- C&aacute; nh&acirc;n c&oacute; quyền hợp ph&aacute;p tham gia c&aacute;c thỏa thuận/hợp đồng mua b&aacute;n ở Việt Nam, v&agrave; b&aacute;n h&agrave;ng kh&ocirc;ng v&igrave; mục đ&iacute;ch kinh doanh. Người sử dụng phải tr&ecirc;n 18t, nếu dưới th&igrave; phải c&oacute; sự gi&aacute;m s&aacute;t của cha mẹ hoặc người gi&aacute;m hộ hợp ph&aacute;p.</p>\\r\\n\\r\\n<p>- C&aacute; nh&acirc;n/tổ chức bao gồm cửa h&agrave;ng, doanh nghiệp, m&ocirc;i giới, hộ gia đ&igrave;nh c&oacute; quyền hợp ph&aacute;p tham gia c&aacute;c thỏa thuận/hợp đồng mua b&aacute;n ở Việt Nam.</p>\\r\\n\\r\\n<p><strong>b. Quy định cơ bản:</strong></p>\\r\\n\\r\\n<p>- Đăng tin đ&uacute;ng chuy&ecirc;n mục với sản phẩm muốn b&aacute;n v&agrave; phải chịu tr&aacute;ch nhiệm về nội dung v&agrave; th&ocirc;ng tin đăng tr&ecirc;n <strong>raovatphuly.vn</strong>.</p>\\r\\n\\r\\n<p>- Kh&aacute;ch h&agrave;ng kh&ocirc;ng được đăng tin b&aacute;n c&aacute;c mặt h&agrave;ng cấm kinh doanh theo quy định của nh&agrave; nước Việt Nam.</p>\\r\\n\\r\\n<p>- Ph&iacute; đăng tin t&ugrave;y thuộc v&agrave;o c&aacute;c chuy&ecirc;n mục kh&aacute;c nhau theo quy định của <strong>raovatphuly.vn</strong></p>\\r\\n\\r\\n<p>- Nội dung tin đăng cần c&oacute; đầy đủ th&ocirc;ng tin để người mua c&oacute; thể quyết định mua h&agrave;ng.</p>\\r\\n\\r\\n<p>- Người mua v&agrave; người b&aacute;n tự chịu tr&aacute;ch nhiệm về giao dịch, nếu bạn thắc mắc về quy định giao dịch an to&agrave;n th&igrave; c&oacute; thể t&igrave;m hiểu th&ecirc;m</p>\\r\\n\\r\\n<p><strong>c. Th&ocirc;ng tin li&ecirc;n hệ:</strong></p>\\r\\n\\r\\n<p>- Người đăng tin phải bắt buộc cung cấp đầy đủ, ch&iacute;nh x&aacute;c th&ocirc;ng tin về t&ecirc;n thật của người b&aacute;n, số điện thoại, địa chỉ email, địa chỉ. Người b&aacute;n phải c&oacute; chịu mọi tr&aacute;ch nhiệm nếu như đưa th&ocirc;ng tin li&ecirc;n hệ sai.</p>\\r\\n\\r\\n<p><strong>d. Ti&ecirc;u đề tin đăng:</strong></p>\\r\\n\\r\\n<p>- Ti&ecirc;u đề bao gồm tối đa 50 k&yacute; tự mi&ecirc;u tả về sản phẩm v&agrave; dịch vụ muốn b&aacute;n bao gồm t&ecirc;n, model, t&igrave;nh trạng. Đối với tin đăng về bất động sản cần bổ sung th&ecirc;m loại nh&agrave; đất, địa chỉ, số ph&ograve;ng ngủ.</p>\\r\\n\\r\\n<p><strong>e. H&igrave;nh ảnh:</strong></p>\\r\\n\\r\\n<p>- Mỗi tin đăng được tối đa 6 h&igrave;nh ảnh thể hiện ch&acirc;n thực về sản phẩm hoặc dịch vụ. Ch&uacute;ng t&ocirc;i c&oacute; quyền loại bỏ những tin đăng sai quy định về h&igrave;nh ảnh.</p>\\r\\n\\r\\n<p><strong>f. Nội dung:</strong></p>\\r\\n\\r\\n<p><strong>- Bất động sản:</strong> loại nh&agrave; đất, t&ecirc;n đường, diện t&iacute;ch, số ph&ograve;ng ngủ, hướng nh&agrave;.</p>\\r\\n\\r\\n<p><strong>- &Ocirc;t&ocirc;:</strong> h&atilde;ng xe, mẫu xe, loại xe, số km đ&atilde; đi, xuất xứ, t&igrave;nh trạng.</p>\\r\\n\\r\\n<p><strong>- C&aacute;c mục kh&aacute;c:</strong> t&ecirc;n sản phẩm, model, t&igrave;nh trạng.</p>\\r\\n\\r\\n<p>- Nghi&ecirc;m cấm nội dung th&ocirc;ng tin li&ecirc;n quan đến sex, ch&iacute;nh trị, t&ocirc;n gi&aacute;o; c&aacute;c th&ocirc;ng tin vi phạm ph&aacute;p luật, thuần phong, mỹ tục n&oacute;i chung, bao gồm nhưng kh&ocirc;ng giới hạn, c&aacute;c th&ocirc;ng tin quảng c&aacute;o, rao vặt về rượu, thuốc l&aacute;, thịt th&uacute; rừng, vũ kh&iacute; c&aacute;c loại, c&aacute;c sản phẩm nh&aacute;i hoặc c&aacute;c sản phẩm giả của c&aacute;c h&agrave;ng ho&aacute; kh&aacute;c, c&aacute;c mặt h&agrave;ng kh&ocirc;ng được quảng c&aacute;o, hoặc c&aacute;c sản phẩm quốc cấm kh&aacute;c. Nếu c&oacute; tồn tại bất kỳ th&ocirc;ng tin n&agrave;o như vậy tr&ecirc;n website, Ban quản trị v&agrave; ban bi&ecirc;n tập Website sẽ s&agrave;ng lọc v&agrave; loại bỏ, x&oacute;a khỏi hệ thống c&aacute;c th&ocirc;ng tin như vậy m&agrave; kh&ocirc;ng cần th&ocirc;ng b&aacute;o trước.</p>\\r\\n\\r\\n<p><strong>g. Gi&aacute;:</strong></p>\\r\\n\\r\\n<p>- Gi&aacute; tr&ecirc;n trang <strong>raovatphuly.vn</strong> được ni&ecirc;m yết bằng Việt Nam Đồng (VNĐ). Mọi sản phẩm/dịch vụ đều phải cung cấp gi&aacute;. Theo ph&aacute;p lệnh của nh&agrave; nước, mọi tin đăng c&oacute; gi&aacute; l&agrave; ngoại tệ đều bị từ chối v&agrave; x&oacute;a bỏ.</p>\\r\\n\\r\\n<p><strong>h. Ng&ocirc;n ngữ:</strong></p>\\r\\n\\r\\n<p>-<strong> raovatphuly.vn</strong> chấp nhận sử dụng tiếng Việt c&oacute; dấu v&agrave; tiếng Anh.</p>\\r\\n', NULL, NULL, 2, 2, 1, NULL),
(2, 'Chính sách bảo mật', '', '<div class=\"iterm_htro\">\\r\\n<p>&nbsp;</p>\\r\\n\\r\\n<h2>1. Bảo mật th&ocirc;ng tin người d&ugrave;ng:</h2>\\r\\n\\r\\n<p>- Khi kh&aacute;ch h&agrave;ng thực hiện giao dịch v&agrave;/hoặc đăng k&yacute;, đăng nhập tr&ecirc;n <strong>raovatphuly.vn</strong>, t&ugrave;y từng trường hợp, kh&aacute;ch h&agrave;ng cần cung cấp một số th&ocirc;ng tin cần thiết cho c&aacute;c việc tr&ecirc;n. Kh&aacute;ch h&agrave;ng cần đảm bảo c&aacute;c th&ocirc;ng tin cung cấp l&agrave; ch&iacute;nh x&aacute;c. Trong mọi trường hợp ph&aacute;t sinh tranh chấp v&agrave;/hoặc khiếu nại, <strong>raovatphuly.vn</strong> sẽ kh&ocirc;ng chịu tr&aacute;ch nhiệm giải quyết nếu c&aacute;c th&ocirc;ng tin kh&aacute;ch h&agrave;ng cung cấp l&agrave; kh&ocirc;ng ch&iacute;nh x&aacute;c hoặc giả mạo.</p>\\r\\n\\r\\n<p>- Mọi th&ocirc;ng tin kh&aacute;ch h&agrave;ng cũng như c&aacute;c th&ocirc;ng tin trao đổi giữa kh&aacute;ch h&agrave;ng v&agrave; <strong>raovatphuly.vn</strong> đều được <strong>raovatphuly.vn</strong> lưu giữ, bảo mật v&agrave; cung cấp kh&ocirc;ng tiết lộ c&aacute;c th&ocirc;ng tin n&agrave;y cho bất kỳ b&ecirc;n thứ ba n&agrave;o, trừ trường hợp cung cấp với mục đ&iacute;ch ph&acirc;n t&iacute;ch dữ liệu, tiếp thị v&agrave; hỗ trợ dịch vụ kh&aacute;ch h&agrave;ng.</p>\\r\\n\\r\\n<h2>2. Bảo mật thanh to&aacute;n:</h2>\\r\\n\\r\\n<p>- <strong>raovatphuly.vn</strong> c&oacute; c&aacute;c ti&ecirc;u chuẩn bảo mật thanh to&aacute;n ri&ecirc;ng đảm bảo th&ocirc;ng tin thanh to&aacute;n của kh&aacute;ch h&agrave;ng được lưu giữ tuyệt đối an to&agrave;n. Ngo&agrave;i ra, hệ thống thanh to&aacute;n tr&ecirc;n <strong>raovatphuly.vn</strong> được kết nối với c&aacute;c đối t&aacute;c thứ ba như SenPay, theo đ&oacute;, tu&acirc;n theo to&agrave;n bộ c&aacute;c ti&ecirc;u chuẩn bảo mật của cổng thanh to&aacute;n n&agrave;y.</p>\\r\\n\\r\\n<p>- C&aacute;c ti&ecirc;u chuẩn bảo mật thanh to&aacute;n trực tuyến bằng thẻ nội địa v&agrave; thẻ quốc tế được thực hiện th&ocirc;ng qua kết nối SenPay đảm bảo tu&acirc;n thủ c&aacute;c ti&ecirc;u chuẩn bảo mật của SenPay gồm:</p>\\r\\n\\r\\n<p>+ Ti&ecirc;u chuẩn bảo mật dữ liệu tr&ecirc;n internet SSL (Secure Sockets Layer) do GlobalSign cấp.</p>\\r\\n\\r\\n<p>+ Chứng nhận ti&ecirc;u chuẩn bảo mật dữ liệu th&ocirc;ng tin thanh to&aacute;n PCI do Control Case cấp.</p>\\r\\n\\r\\n<p>- Th&ocirc;ng tin thẻ ng&acirc;n h&agrave;ng của kh&aacute;ch h&agrave;ng kh&ocirc;ng được lưu tr&ecirc;n hệ thống của <strong>raovatphuly.vn</strong>. Khi kh&aacute;ch h&agrave;ng sử dụng thẻ ng&acirc;n h&agrave;ng để thanh to&aacute;n đơn h&agrave;ng tr&ecirc;n <strong>raovatphuly.vn</strong>, th&ocirc;ng tin thẻ sẽ được nhập tr&ecirc;n website Cổng thanh to&aacute;n SenPay.</p>\\r\\n</div>\\r\\n', NULL, NULL, 2, 2, 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `web_province`
--

CREATE TABLE `web_province` (
  `province_id` int(11) NOT NULL,
  `province_name` varchar(255) NOT NULL,
  `province_position` tinyint(4) NOT NULL,
  `province_status` varchar(20) NOT NULL,
  `province_area` tinyint(4) NOT NULL COMMENT 'Vùng miền của tỉnh thành'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `web_province`
--

INSERT INTO `web_province` (`province_id`, `province_name`, `province_position`, `province_status`, `province_area`) VALUES
(3, 'Bạc Liêu', 6, '1', 3),
(4, 'Bắc Cạn', 7, '1', 1),
(5, 'Bắc Giang', 6, '1', 1),
(6, 'Bắc Ninh', 7, '1', 1),
(7, 'Bến Tre', 8, '1', 3),
(8, 'Bình Dương', 9, '1', 3),
(9, 'Bình Định', 10, '1', 2),
(10, 'Bình Phước', 11, '1', 2),
(11, 'Bình Thuận', 12, '1', 2),
(12, 'Cà Mau', 13, '1', 3),
(13, 'Cao Bằng', 14, '1', 1),
(14, 'Cần Thơ', 8, '1', 3),
(15, 'Đà Nẵng', 3, '1', 2),
(17, 'Đồng Nai', 18, '1', 3),
(18, 'Đồng Tháp', 19, '1', 3),
(19, 'Gia Lai', 20, '1', 2),
(20, 'Hà Giang', 21, '1', 1),
(21, 'Hà Nam', 22, '1', 1),
(22, 'Hà Nội', 1, '1', 1),
(23, 'Hà Tây', 24, '1', 1),
(24, 'Hà Tĩnh', 25, '1', 2),
(25, 'Hải Dương', 26, '1', 1),
(26, 'Hải Phòng', 5, '1', 1),
(27, 'Hòa Bình', 28, '1', 1),
(28, 'Hưng Yên', 29, '1', 1),
(29, 'TP Hồ Chí Minh', 2, '1', 3),
(30, 'Khánh Hòa', 31, '1', 2),
(31, 'Kiên Giang', 32, '1', 3),
(32, 'Kon Tum', 33, '1', 2),
(33, 'Lai Châu', 34, '1', 1),
(34, 'Lạng Sơn', 35, '1', 1),
(35, 'Lào Cai', 36, '1', 1),
(36, 'Lâm Đồng', 37, '1', 2),
(37, 'Long An', 38, '1', 3),
(38, 'Nam Định', 39, '1', 1),
(39, 'Nghệ An', 40, '1', 2),
(40, 'Ninh Bình', 41, '1', 1),
(41, 'Ninh Thuận', 42, '1', 2),
(42, 'Phú Thọ', 43, '1', 1),
(43, 'Phú Yên', 44, '1', 2),
(44, 'Quảng Bình', 45, '1', 2),
(45, 'Quảng Nam', 46, '1', 2),
(46, 'Quảng Ngãi', 47, '1', 2),
(47, 'Quảng Ninh', 7, '1', 1),
(48, 'Quảng Trị', 49, '1', 2),
(49, 'Sóc Trăng', 50, '1', 3),
(50, 'Sơn La', 51, '1', 1),
(51, 'Tây Ninh', 52, '1', 3),
(52, 'Thái Bình', 53, '1', 1),
(53, 'Thái Nguyên', 54, '1', 1),
(54, 'Thanh Hóa', 55, '1', 1),
(55, 'Thừa Thiên Huế', 56, '1', 2),
(56, 'Tiền Giang', 57, '1', 3),
(57, 'Trà Vinh', 58, '1', 3),
(58, 'Tuyên Quang', 59, '1', 1),
(59, 'Vĩnh Long', 60, '1', 3),
(60, 'Vĩnh Phúc', 61, '1', 1),
(61, 'Yên Bái', 62, '1', 1),
(66, 'An giang', 62, '1', 3),
(67, 'Vũng Tàu', 6, '1', 3),
(68, 'Nha Trang', 4, '1', 0),
(69, 'Điện Biên', 0, '0', 0),
(70, 'Hậu Giang', 15, '1', 0);

-- --------------------------------------------------------

--
-- Table structure for table `web_trash`
--

CREATE TABLE `web_trash` (
  `trash_id` int(11) NOT NULL,
  `uid` int(11) DEFAULT NULL,
  `trash_obj_id` int(11) DEFAULT NULL,
  `trash_title` varchar(255) DEFAULT NULL,
  `trash_class` varchar(255) DEFAULT NULL,
  `trash_content` longtext,
  `trash_image` longtext,
  `trash_image_other` longtext,
  `trash_folder` varchar(255) DEFAULT NULL,
  `trash_created` int(12) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `web_trash`
--

INSERT INTO `web_trash` (`trash_id`, `uid`, `trash_obj_id`, `trash_title`, `trash_class`, `trash_content`, `trash_image`, `trash_image_other`, `trash_folder`, `trash_created`) VALUES
(1, NULL, 4, 'Thông tin liên hệ', 'Info', 'a:12:{s:7:\"info_id\";i:4;s:10:\"info_title\";s:21:\"Thông tin liên hệ\";s:12:\"info_keyword\";s:12:\"SITE_CONTACT\";s:10:\"info_intro\";N;s:12:\"info_content\";s:557:\"<p>X&atilde; hội ng&agrave;y c&agrave;ng ph&aacute;t triển, cuộc sống ng&agrave;y c&agrave;ng được n&acirc;ng cao, v&agrave; những nhu cầu tiện nghi cho cuộc sống con người cũng v&igrave; thế m&agrave; n&acirc;ng l&ecirc;n, k&egrave;m theo đ&oacute; l&agrave; những th&uacute; vui sưu tầm v&agrave; sở hữu những sản phẩm phục vụ cho cuộc sống ng&agrave;y c&agrave;ng lớn. SanPhamReDep.COM l&agrave; nơi cung cấp v&agrave; phục vụ tốt nhất về c&aacute;c loại sản phẩm n&agrave;y.</p>\\r\\n\";s:8:\"info_img\";N;s:12:\"info_created\";s:10:\"1441430633\";s:13:\"info_order_no\";i:1;s:11:\"info_status\";i:1;s:10:\"meta_title\";s:21:\"Thông tin liên hệ\";s:13:\"meta_keywords\";s:21:\"Thông tin liên hệ\";s:16:\"meta_description\";s:21:\"Thông tin liên hệ\";}', '', 'a:0:{}', '', 1478450941);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `group_user`
--
ALTER TABLE `group_user`
  ADD PRIMARY KEY (`group_user_id`);

--
-- Indexes for table `permission`
--
ALTER TABLE `permission`
  ADD PRIMARY KEY (`permission_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `web_banner`
--
ALTER TABLE `web_banner`
  ADD PRIMARY KEY (`banner_id`);

--
-- Indexes for table `web_category`
--
ALTER TABLE `web_category`
  ADD PRIMARY KEY (`category_id`),
  ADD KEY `status` (`category_status`) USING BTREE,
  ADD KEY `id_parrent` (`category_parent_id`,`category_status`) USING BTREE;

--
-- Indexes for table `web_click_share`
--
ALTER TABLE `web_click_share`
  ADD PRIMARY KEY (`share_id`);

--
-- Indexes for table `web_contact`
--
ALTER TABLE `web_contact`
  ADD PRIMARY KEY (`contact_id`);

--
-- Indexes for table `web_customer`
--
ALTER TABLE `web_customer`
  ADD PRIMARY KEY (`customer_id`);

--
-- Indexes for table `web_districts`
--
ALTER TABLE `web_districts`
  ADD PRIMARY KEY (`district_id`),
  ADD KEY `id_citiesfather` (`district_province_id`),
  ADD KEY `Idx_id_citiesfather_orders_name` (`district_province_id`,`district_name`);

--
-- Indexes for table `web_info`
--
ALTER TABLE `web_info`
  ADD PRIMARY KEY (`info_id`);

--
-- Indexes for table `web_items`
--
ALTER TABLE `web_items`
  ADD PRIMARY KEY (`item_id`);

--
-- Indexes for table `web_news`
--
ALTER TABLE `web_news`
  ADD PRIMARY KEY (`news_id`);

--
-- Indexes for table `web_province`
--
ALTER TABLE `web_province`
  ADD PRIMARY KEY (`province_id`),
  ADD KEY `position` (`province_position`),
  ADD KEY `status` (`province_status`);

--
-- Indexes for table `web_trash`
--
ALTER TABLE `web_trash`
  ADD PRIMARY KEY (`trash_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `group_user`
--
ALTER TABLE `group_user`
  MODIFY `group_user_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id nhom nguoi dung', AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `permission`
--
ALTER TABLE `permission`
  MODIFY `permission_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT for table `web_banner`
--
ALTER TABLE `web_banner`
  MODIFY `banner_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `web_category`
--
ALTER TABLE `web_category`
  MODIFY `category_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=265;
--
-- AUTO_INCREMENT for table `web_click_share`
--
ALTER TABLE `web_click_share`
  MODIFY `share_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `web_contact`
--
ALTER TABLE `web_contact`
  MODIFY `contact_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `web_customer`
--
ALTER TABLE `web_customer`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `web_districts`
--
ALTER TABLE `web_districts`
  MODIFY `district_id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=860;
--
-- AUTO_INCREMENT for table `web_info`
--
ALTER TABLE `web_info`
  MODIFY `info_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `web_items`
--
ALTER TABLE `web_items`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;
--
-- AUTO_INCREMENT for table `web_news`
--
ALTER TABLE `web_news`
  MODIFY `news_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `web_province`
--
ALTER TABLE `web_province`
  MODIFY `province_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;
--
-- AUTO_INCREMENT for table `web_trash`
--
ALTER TABLE `web_trash`
  MODIFY `trash_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
