/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : db_tin

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2017-02-04 12:13:30
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for group_user
-- ----------------------------
DROP TABLE IF EXISTS `group_user`;
CREATE TABLE `group_user` (
  `group_user_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id nhom nguoi dung',
  `group_user_name` varchar(50) NOT NULL COMMENT 'Ten nhom nguoi dung',
  `group_user_status` int(1) NOT NULL DEFAULT '1' COMMENT '1 : hiá»‡n , 0 : áº©n',
  `group_user_type` int(1) NOT NULL DEFAULT '1' COMMENT '1:admin;2:shop',
  PRIMARY KEY (`group_user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of group_user
-- ----------------------------
INSERT INTO `group_user` VALUES ('1', 'Root', '1', '1');
INSERT INTO `group_user` VALUES ('2', 'Quyền xem lượt Share', '1', '1');

-- ----------------------------
-- Table structure for group_user_permission
-- ----------------------------
DROP TABLE IF EXISTS `group_user_permission`;
CREATE TABLE `group_user_permission` (
  `group_user_id` int(11) NOT NULL COMMENT 'id nhÃ³m',
  `permission_id` int(11) NOT NULL COMMENT 'id quyÃ¨n'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of group_user_permission
-- ----------------------------
INSERT INTO `group_user_permission` VALUES ('1', '1');
INSERT INTO `group_user_permission` VALUES ('2', '43');

-- ----------------------------
-- Table structure for permission
-- ----------------------------
DROP TABLE IF EXISTS `permission`;
CREATE TABLE `permission` (
  `permission_id` int(11) NOT NULL AUTO_INCREMENT,
  `permission_code` varchar(50) NOT NULL COMMENT 'MÃ£ quyá»n',
  `permission_name` varchar(50) NOT NULL COMMENT 'TÃªn quyá»n',
  `permission_status` int(1) NOT NULL DEFAULT '1' COMMENT '1:hiá»‡n , 0:áº©n',
  `permission_group_name` varchar(255) DEFAULT NULL COMMENT 'group ten controller',
  PRIMARY KEY (`permission_id`)
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of permission
-- ----------------------------
INSERT INTO `permission` VALUES ('1', 'root', 'Root', '1', 'Root');
INSERT INTO `permission` VALUES ('2', 'user_view', 'Xem danh sách user Admin', '1', 'Tài khoản Admin');
INSERT INTO `permission` VALUES ('3', 'user_create', 'Tạo user Admin', '1', 'Tài khoản Admin');
INSERT INTO `permission` VALUES ('4', 'user_edit', 'Sửa user Admin', '1', 'Tài khoản Admin');
INSERT INTO `permission` VALUES ('5', 'user_change_pass', 'Thay đổi user Admin', '1', 'Tài khoản Admin');
INSERT INTO `permission` VALUES ('6', 'user_remove', 'Xóa user Admin', '1', 'Tài khoản Admin');
INSERT INTO `permission` VALUES ('7', 'group_user_view', 'Xem nhóm quyền', '1', 'Nhóm quyền');
INSERT INTO `permission` VALUES ('8', 'group_user_create', 'Tạo nhóm quyền', '1', 'Nhóm quyền');
INSERT INTO `permission` VALUES ('9', 'group_user_edit', 'Sửa nhóm quyền', '1', 'Nhóm quyền');
INSERT INTO `permission` VALUES ('10', 'permission_full', 'Full tạo quyền', '1', 'Tạo quyền');
INSERT INTO `permission` VALUES ('11', 'permission_create', 'Tạo tạo quyền', '1', 'Tạo quyền');
INSERT INTO `permission` VALUES ('12', 'permission_edit', 'Sửa tạo quyền', '1', 'Tạo quyền');
INSERT INTO `permission` VALUES ('13', 'banner_full', 'Full quảng cáo', '1', 'Quyền quảng cáo');
INSERT INTO `permission` VALUES ('14', 'banner_view', 'Xem quảng cáo', '1', 'Quyền quảng cáo');
INSERT INTO `permission` VALUES ('15', 'banner_delete', 'Xóa quảng cáo', '1', 'Quyền quảng cáo');
INSERT INTO `permission` VALUES ('16', 'banner_create', 'Tạo quảng cáo', '1', 'Quyền quảng cáo');
INSERT INTO `permission` VALUES ('17', 'banner_edit', 'Sửa quảng cáo', '1', 'Quyền quảng cáo');
INSERT INTO `permission` VALUES ('18', 'category_full', 'Full danh mục', '1', 'Quyền danh mục');
INSERT INTO `permission` VALUES ('19', 'category_view', 'Xem danh mục', '1', 'Quyền danh mục');
INSERT INTO `permission` VALUES ('20', 'category_delete', 'Xóa danh mục', '1', 'Quyền danh mục');
INSERT INTO `permission` VALUES ('21', 'category_create', 'Tạo danh mục', '1', 'Quyền danh mục');
INSERT INTO `permission` VALUES ('22', 'category_edit', 'Sửa danh mục', '1', 'Quyền danh mục');
INSERT INTO `permission` VALUES ('23', 'items_full', 'Full tin rao', '1', 'Quyền tin rao');
INSERT INTO `permission` VALUES ('24', 'items_view', 'Xem tin rao', '1', 'Quyền tin rao');
INSERT INTO `permission` VALUES ('25', 'items_delete', 'Xóa tin rao', '1', 'Quyền tin rao');
INSERT INTO `permission` VALUES ('26', 'items_create', 'Tạo tin rao', '1', 'Quyền tin rao');
INSERT INTO `permission` VALUES ('27', 'items_edit', 'Sửa tin rao', '1', 'Quyền tin rao');
INSERT INTO `permission` VALUES ('28', 'news_full', 'Full tin tức', '1', 'Quyền tin tức');
INSERT INTO `permission` VALUES ('29', 'news_view', 'Xem tin tức', '1', 'Quyền tin tức');
INSERT INTO `permission` VALUES ('30', 'news_delete', 'Xóa tin tức', '1', 'Quyền tin tức');
INSERT INTO `permission` VALUES ('31', 'news_create', 'Tạo tin tức', '1', 'Quyền tin tức');
INSERT INTO `permission` VALUES ('32', 'news_edit', 'Sửa tin tức', '1', 'Quyền tin tức');
INSERT INTO `permission` VALUES ('33', 'province_full', 'Full tỉnh thành', '1', 'Quyền tỉnh thành');
INSERT INTO `permission` VALUES ('34', 'province_view', 'Xem tỉnh thành', '1', 'Quyền tỉnh thành');
INSERT INTO `permission` VALUES ('35', 'province_delete', 'Xóa tỉnh thành', '1', 'Quyền tỉnh thành');
INSERT INTO `permission` VALUES ('36', 'province_create', 'Tạo tỉnh thành', '1', 'Quyền tỉnh thành');
INSERT INTO `permission` VALUES ('37', 'province_edit', 'Sửa tỉnh thành', '1', 'Quyền tỉnh thành');
INSERT INTO `permission` VALUES ('38', 'user_customer_full', 'Full khách hàng', '1', 'Quyền khách hàng');
INSERT INTO `permission` VALUES ('39', 'user_customer_view', 'Xem khách hàng', '1', 'Quyền khách hàng');
INSERT INTO `permission` VALUES ('40', 'user_customer_delete', 'Xóa khách hàng', '1', 'Quyền khách hàng');
INSERT INTO `permission` VALUES ('41', 'user_customer_create', 'Tạo khách hàng', '1', 'Quyền khách hàng');
INSERT INTO `permission` VALUES ('42', 'user_customer_edit', 'Sửa khách hàng', '1', 'Quyền khách hàng');
INSERT INTO `permission` VALUES ('43', 'toolsCommon_full', 'Full quyền', '1', 'Full quyền Share link');

-- ----------------------------
-- Table structure for user
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
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
  `user_updated` int(11) DEFAULT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES ('2', 'admin', 'eef828faf0754495136af05c051766cb', 'Root', '', null, '1', '1', '1486107292', '::1', null, null, null, null, null, null);
INSERT INTO `user` VALUES ('19', 'tech_code', '7eb3b9aba1960c22aa9bc8d1f27ebfb9', 'Tech code 3555', '', '', '1', '2', '1481772767', '::1', null, null, '2', 'admin', null, '1481772561');
INSERT INTO `user` VALUES ('20', 'svquynhtm', 'a1f54bbcea29cf49935e0a5ead5a3dfa', 'Trương Mạnh Quỳnh', 'manhquynh1984@gmail.com', '0938413368', '1', '2', '1482826054', '::1', '2', 'admin', '2', 'admin', '1482823830', '1482824272');

-- ----------------------------
-- Table structure for web_banner
-- ----------------------------
DROP TABLE IF EXISTS `web_banner`;
CREATE TABLE `web_banner` (
  `banner_id` int(11) NOT NULL AUTO_INCREMENT,
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
  `banner_update_time` int(11) DEFAULT '0',
  PRIMARY KEY (`banner_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of web_banner
-- ----------------------------
INSERT INTO `web_banner` VALUES ('4', 'hiển thị banner không có ảnh', '', 'http://localhost/goingay/admin/banner/edit/3', '0', '3', '0', '0', '1', '3', '3', '1', '0', '1', '0', '0', '0', '0', '1482380269', '0', '1482998790');
INSERT INTO `web_banner` VALUES ('5', 'hiển thị banner không có ảnh', '', 'http://localhost/goingay/admin/banner/edit/3', '0', '5', '0', '0', '1', '7', '13', '1', '0', '1', '0', '0', '0', '0', '1482998971', '0', '0');

-- ----------------------------
-- Table structure for web_category
-- ----------------------------
DROP TABLE IF EXISTS `web_category`;
CREATE TABLE `web_category` (
  `category_id` int(10) NOT NULL AUTO_INCREMENT,
  `category_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `category_parent_id` smallint(5) unsigned DEFAULT '0',
  `category_content_front` tinyint(2) DEFAULT '0',
  `category_content_front_order` tinyint(5) DEFAULT '0' COMMENT 'vị trí hiển thị ngoài trang chủ',
  `category_status` tinyint(1) DEFAULT '0',
  `category_image_background` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `category_icons` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `category_order` tinyint(5) DEFAULT '0',
  PRIMARY KEY (`category_id`),
  KEY `status` (`category_status`) USING BTREE,
  KEY `id_parrent` (`category_parent_id`,`category_status`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=265 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of web_category
-- ----------------------------
INSERT INTO `web_category` VALUES ('253', 'Mua bán nhà đất', '0', '1', '1', '1', null, 'fa fa-building', '1');
INSERT INTO `web_category` VALUES ('254', 'Thuê nhà đất', '0', '1', '2', '1', null, 'fa fa-building-o', '2');
INSERT INTO `web_category` VALUES ('255', 'Ôtô', '0', '1', '3', '1', null, 'fa fa-car', '3');
INSERT INTO `web_category` VALUES ('256', 'Xe máy - Xe đạp', '0', '1', '4', '1', null, 'fa fa-bicycle', '4');
INSERT INTO `web_category` VALUES ('257', 'Tuyển sinh - Tuyển dụng', '0', '0', '5', '1', null, 'fa fa-mortar-board', '5');
INSERT INTO `web_category` VALUES ('258', 'Điện thoại - Sim', '0', '1', '6', '1', null, 'fa fa-mobile-phone', '6');
INSERT INTO `web_category` VALUES ('259', 'PC - Laptop', '0', '1', '7', '1', null, 'fa fa-laptop', '7');
INSERT INTO `web_category` VALUES ('260', 'Điện tử - Kỹ thuật số', '0', '1', '8', '1', '576568_579794885409422_1412382588_n.jpg', 'fa fa-desktop', '8');
INSERT INTO `web_category` VALUES ('261', 'Thời trang - Làm đẹp', '0', '1', '9', '1', null, 'fa fa-child', '9');
INSERT INTO `web_category` VALUES ('262', 'Ẩm thực - Du lịch', '0', '0', '10', '1', null, 'fa fa-cutlery', '10');
INSERT INTO `web_category` VALUES ('263', 'Dịch vụ', '0', '0', '11', '1', null, 'fa fa-dropbox', '11');
INSERT INTO `web_category` VALUES ('264', 'Khác', '0', '1', '12', '1', '573cb4258e810763aa000001.jpg', 'fa fa-asterisk', '12');

-- ----------------------------
-- Table structure for web_click_share
-- ----------------------------
DROP TABLE IF EXISTS `web_click_share`;
CREATE TABLE `web_click_share` (
  `share_id` int(11) NOT NULL AUTO_INCREMENT,
  `object_id` int(11) DEFAULT '0' COMMENT 'banner id được click',
  `object_name` varchar(255) DEFAULT NULL,
  `share_ip` varchar(255) DEFAULT NULL COMMENT 'Địa chỉ IP click',
  `share_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`share_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of web_click_share
-- ----------------------------
INSERT INTO `web_click_share` VALUES ('1', '20', 'svquynhtm', '::1', '1482826370');
INSERT INTO `web_click_share` VALUES ('2', '20', 'svquynhtm', '::1', '1482826399');
INSERT INTO `web_click_share` VALUES ('3', '20', 'svquynhtm', '::1', '1482826433');

-- ----------------------------
-- Table structure for web_contact
-- ----------------------------
DROP TABLE IF EXISTS `web_contact`;
CREATE TABLE `web_contact` (
  `contact_id` int(11) NOT NULL AUTO_INCREMENT,
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
  `contact_time_update` int(11) DEFAULT NULL,
  PRIMARY KEY (`contact_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of web_contact
-- ----------------------------

-- ----------------------------
-- Table structure for web_customer
-- ----------------------------
DROP TABLE IF EXISTS `web_customer`;
CREATE TABLE `web_customer` (
  `customer_id` int(11) NOT NULL AUTO_INCREMENT,
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
  `time_end_vip` int(12) DEFAULT NULL COMMENT 'Ngày hết hạn vip',
  PRIMARY KEY (`customer_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of web_customer
-- ----------------------------
INSERT INTO `web_customer` VALUES ('1', 'Trương Mạnh Quỳnh', '99afcc19f7ced142819fb2d355ff7b63', '0938413368', 'Việt Hưng - Long Biên - Hà Nội', 'manhquynh1984@gmail.com', '0', '0', '', '22', '2', '', '1', '1480063953', '1480069302', '1478594509', '1', '1', '0', null, null, '4', '1', '0', '25-11-2016', '0', '0');

-- ----------------------------
-- Table structure for web_districts
-- ----------------------------
DROP TABLE IF EXISTS `web_districts`;
CREATE TABLE `web_districts` (
  `district_id` int(3) NOT NULL AUTO_INCREMENT,
  `district_name` varchar(225) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `district_province_id` int(10) NOT NULL DEFAULT '0',
  `district_status` tinyint(1) NOT NULL DEFAULT '1',
  `district_position` tinyint(2) DEFAULT '50',
  PRIMARY KEY (`district_id`),
  KEY `id_citiesfather` (`district_province_id`),
  KEY `Idx_id_citiesfather_orders_name` (`district_province_id`,`district_name`)
) ENGINE=InnoDB AUTO_INCREMENT=860 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of web_districts
-- ----------------------------
INSERT INTO `web_districts` VALUES ('1', 'Ba Đình', '22', '1', '50');
INSERT INTO `web_districts` VALUES ('2', 'Long Biên', '22', '1', '50');
INSERT INTO `web_districts` VALUES ('3', 'Sóc Sơn', '22', '1', '50');
INSERT INTO `web_districts` VALUES ('4', 'Đông Anh', '22', '1', '50');
INSERT INTO `web_districts` VALUES ('5', 'TP Thủ Dầu Một', '8', '1', '50');
INSERT INTO `web_districts` VALUES ('7', 'Thị xã Đồng Xoài', '10', '1', '50');
INSERT INTO `web_districts` VALUES ('10', 'Bến Cát', '8', '1', '50');
INSERT INTO `web_districts` VALUES ('12', 'Tân Uyên', '8', '1', '50');
INSERT INTO `web_districts` VALUES ('16', 'Thuận An', '8', '1', '50');
INSERT INTO `web_districts` VALUES ('18', 'TP Dĩ An', '8', '1', '50');
INSERT INTO `web_districts` VALUES ('20', 'Phú Giáo', '8', '1', '50');
INSERT INTO `web_districts` VALUES ('22', 'Dầu Tiếng', '8', '1', '50');
INSERT INTO `web_districts` VALUES ('28', 'Đồng Xoài', '10', '1', '50');
INSERT INTO `web_districts` VALUES ('31', 'Đồng Phú', '10', '1', '50');
INSERT INTO `web_districts` VALUES ('33', 'Chơn Thành', '10', '1', '50');
INSERT INTO `web_districts` VALUES ('35', 'Bình Long', '10', '1', '50');
INSERT INTO `web_districts` VALUES ('36', 'Lộc Ninh', '10', '1', '50');
INSERT INTO `web_districts` VALUES ('39', 'Bù Đốp', '10', '1', '50');
INSERT INTO `web_districts` VALUES ('40', 'Thành phố Phan Rang - Tháp Chàm', '41', '1', '50');
INSERT INTO `web_districts` VALUES ('42', 'Việt Trì', '42', '1', '50');
INSERT INTO `web_districts` VALUES ('43', 'Phước Long', '10', '1', '50');
INSERT INTO `web_districts` VALUES ('44', 'Huyện Ninh Sơn', '41', '1', '50');
INSERT INTO `web_districts` VALUES ('45', 'Huyện Ninh Hải', '41', '1', '50');
INSERT INTO `web_districts` VALUES ('46', 'Bù Đăng', '10', '1', '50');
INSERT INTO `web_districts` VALUES ('47', 'Huyện Ninh Phước', '41', '1', '50');
INSERT INTO `web_districts` VALUES ('48', 'Hớn Quản', '10', '1', '50');
INSERT INTO `web_districts` VALUES ('49', 'Bác Ái', '41', '1', '50');
INSERT INTO `web_districts` VALUES ('50', 'Bù Gia Mập', '10', '1', '50');
INSERT INTO `web_districts` VALUES ('51', 'Hoàn Kiếm', '22', '1', '50');
INSERT INTO `web_districts` VALUES ('52', 'Huyện Thuận Bắc', '41', '1', '50');
INSERT INTO `web_districts` VALUES ('53', 'Hai Bà Trưng', '22', '1', '50');
INSERT INTO `web_districts` VALUES ('54', 'Huyện Thuận Nam', '41', '1', '50');
INSERT INTO `web_districts` VALUES ('55', 'Đống Đa', '22', '1', '50');
INSERT INTO `web_districts` VALUES ('57', 'Tây Hồ', '22', '1', '50');
INSERT INTO `web_districts` VALUES ('58', 'Đà Lạt', '36', '1', '50');
INSERT INTO `web_districts` VALUES ('60', 'Cầu Giấy', '22', '1', '50');
INSERT INTO `web_districts` VALUES ('61', 'Bảo Lộc', '36', '1', '50');
INSERT INTO `web_districts` VALUES ('62', 'Thị xã Tây Ninh', '51', '1', '50');
INSERT INTO `web_districts` VALUES ('63', 'Thanh Xuân', '22', '1', '50');
INSERT INTO `web_districts` VALUES ('64', 'Huyện Tân Biên', '51', '1', '50');
INSERT INTO `web_districts` VALUES ('65', 'Đức Trọng', '36', '1', '50');
INSERT INTO `web_districts` VALUES ('66', 'Huyện Tân Châu', '51', '1', '50');
INSERT INTO `web_districts` VALUES ('67', 'Huyện Dương Minh Châu', '51', '1', '50');
INSERT INTO `web_districts` VALUES ('68', 'Di Linh', '36', '1', '50');
INSERT INTO `web_districts` VALUES ('69', 'Huyện Châu Thành', '51', '1', '50');
INSERT INTO `web_districts` VALUES ('70', 'Hoàng Mai', '22', '1', '50');
INSERT INTO `web_districts` VALUES ('71', 'Đơn Dương', '36', '1', '50');
INSERT INTO `web_districts` VALUES ('72', 'Huyện Hoà Thành', '51', '1', '50');
INSERT INTO `web_districts` VALUES ('73', 'Huyện Bến Cầu', '51', '1', '50');
INSERT INTO `web_districts` VALUES ('74', 'Lạc Dương', '36', '1', '50');
INSERT INTO `web_districts` VALUES ('75', 'Đoan Hùng', '42', '1', '50');
INSERT INTO `web_districts` VALUES ('76', 'Đạ Huoai', '36', '1', '50');
INSERT INTO `web_districts` VALUES ('77', 'Huyện Gò Dầu', '51', '1', '50');
INSERT INTO `web_districts` VALUES ('78', 'Huyện Trảng Bàng', '51', '1', '50');
INSERT INTO `web_districts` VALUES ('79', 'Đạ Tẻh', '36', '1', '50');
INSERT INTO `web_districts` VALUES ('80', 'Thanh Ba', '42', '1', '50');
INSERT INTO `web_districts` VALUES ('81', 'Cát Tiên', '36', '1', '50');
INSERT INTO `web_districts` VALUES ('83', 'Lâm Hà', '36', '1', '50');
INSERT INTO `web_districts` VALUES ('84', 'Thành phố Phan Thiết', '11', '1', '50');
INSERT INTO `web_districts` VALUES ('85', 'Huyện Tuy Phong', '11', '1', '50');
INSERT INTO `web_districts` VALUES ('86', 'Bảo Lâm', '36', '1', '50');
INSERT INTO `web_districts` VALUES ('87', 'Nam Từ Liêm', '22', '1', '50');
INSERT INTO `web_districts` VALUES ('88', 'Huyện Bắc Bình', '11', '1', '50');
INSERT INTO `web_districts` VALUES ('89', 'Đam Rông', '36', '1', '50');
INSERT INTO `web_districts` VALUES ('91', 'Thanh Trì', '22', '1', '50');
INSERT INTO `web_districts` VALUES ('92', 'Hàm Thuận Bắc', '11', '1', '50');
INSERT INTO `web_districts` VALUES ('93', 'Gia Lâm', '22', '1', '50');
INSERT INTO `web_districts` VALUES ('95', 'Hàm Thuận Nam', '11', '1', '50');
INSERT INTO `web_districts` VALUES ('96', 'Nha Trang', '30', '1', '50');
INSERT INTO `web_districts` VALUES ('97', 'Tuyên Quang', '58', '1', '50');
INSERT INTO `web_districts` VALUES ('98', 'Huyện Hàm Tân', '11', '1', '50');
INSERT INTO `web_districts` VALUES ('99', 'Vạn Ninh', '30', '1', '50');
INSERT INTO `web_districts` VALUES ('100', 'Huyện Đức Linh', '11', '1', '50');
INSERT INTO `web_districts` VALUES ('101', 'Na Hang', '58', '1', '50');
INSERT INTO `web_districts` VALUES ('102', 'Huyện Tánh Linh', '11', '1', '50');
INSERT INTO `web_districts` VALUES ('103', 'Ninh Hoà', '30', '1', '50');
INSERT INTO `web_districts` VALUES ('104', 'Huyện đảo Phú Quý', '11', '1', '50');
INSERT INTO `web_districts` VALUES ('105', 'Chiêm Hoá', '58', '1', '50');
INSERT INTO `web_districts` VALUES ('106', 'Thị xã La Gi', '11', '1', '50');
INSERT INTO `web_districts` VALUES ('107', 'Diên Khánh', '30', '1', '50');
INSERT INTO `web_districts` VALUES ('108', 'Hàm Yên', '58', '1', '50');
INSERT INTO `web_districts` VALUES ('109', 'Yên Sơn', '58', '1', '50');
INSERT INTO `web_districts` VALUES ('110', 'Khánh Vĩnh', '30', '1', '50');
INSERT INTO `web_districts` VALUES ('111', 'Cam Ranh', '30', '1', '50');
INSERT INTO `web_districts` VALUES ('112', 'Sơn Dương', '58', '1', '50');
INSERT INTO `web_districts` VALUES ('113', 'Hà Đông', '22', '1', '50');
INSERT INTO `web_districts` VALUES ('115', 'Khánh Sơn', '30', '1', '50');
INSERT INTO `web_districts` VALUES ('116', 'Sơn Tây', '22', '1', '50');
INSERT INTO `web_districts` VALUES ('117', 'Ba Vì', '22', '1', '50');
INSERT INTO `web_districts` VALUES ('118', 'Trường Sa', '30', '1', '50');
INSERT INTO `web_districts` VALUES ('119', 'Thành phố Biên Hoà', '17', '1', '50');
INSERT INTO `web_districts` VALUES ('120', 'Phúc Thọ', '22', '1', '50');
INSERT INTO `web_districts` VALUES ('121', 'Huyện Vĩnh Cửu', '17', '1', '50');
INSERT INTO `web_districts` VALUES ('122', 'Cam Lâm', '30', '1', '50');
INSERT INTO `web_districts` VALUES ('123', 'Thạch Thất', '22', '1', '50');
INSERT INTO `web_districts` VALUES ('124', 'Quốc Oai', '22', '1', '50');
INSERT INTO `web_districts` VALUES ('127', 'Chương Mỹ', '22', '1', '50');
INSERT INTO `web_districts` VALUES ('128', 'Lạng Sơn', '34', '1', '50');
INSERT INTO `web_districts` VALUES ('129', 'Buôn Ma Thuột', '16', '1', '50');
INSERT INTO `web_districts` VALUES ('130', 'Đan Phượng', '22', '1', '50');
INSERT INTO `web_districts` VALUES ('131', 'Tràng Định', '34', '1', '50');
INSERT INTO `web_districts` VALUES ('132', 'Hoài Đức', '22', '1', '50');
INSERT INTO `web_districts` VALUES ('133', 'Ea H Leo', '16', '1', '50');
INSERT INTO `web_districts` VALUES ('134', 'Bình Gia', '34', '1', '50');
INSERT INTO `web_districts` VALUES ('135', 'Krông Buk', '16', '1', '50');
INSERT INTO `web_districts` VALUES ('136', 'Thanh Oai', '22', '1', '50');
INSERT INTO `web_districts` VALUES ('137', 'Huyện Định Quán', '17', '1', '50');
INSERT INTO `web_districts` VALUES ('138', 'Văn Lãng', '34', '1', '50');
INSERT INTO `web_districts` VALUES ('139', 'Mỹ Đức', '22', '1', '50');
INSERT INTO `web_districts` VALUES ('140', 'Krông Năng', '72', '1', '50');
INSERT INTO `web_districts` VALUES ('141', 'Bắc Sơn', '34', '1', '50');
INSERT INTO `web_districts` VALUES ('142', 'Ứng Hoà', '22', '1', '50');
INSERT INTO `web_districts` VALUES ('143', 'Ea Súp', '16', '1', '50');
INSERT INTO `web_districts` VALUES ('144', 'Thống Nhất', '17', '1', '50');
INSERT INTO `web_districts` VALUES ('145', 'Thường Tín', '22', '1', '50');
INSERT INTO `web_districts` VALUES ('148', 'Phú Xuyên', '22', '1', '50');
INSERT INTO `web_districts` VALUES ('149', 'Văn Quan', '34', '1', '50');
INSERT INTO `web_districts` VALUES ('150', 'Mê Linh', '22', '1', '50');
INSERT INTO `web_districts` VALUES ('151', 'Thị xã Long Khánh', '17', '1', '50');
INSERT INTO `web_districts` VALUES ('152', 'Krông Pắc', '72', '1', '50');
INSERT INTO `web_districts` VALUES ('153', 'Huyện Long Thành', '17', '1', '50');
INSERT INTO `web_districts` VALUES ('154', 'Ea Kar', '72', '1', '50');
INSERT INTO `web_districts` VALUES ('155', 'Huyện Nhơn Trạch', '17', '1', '50');
INSERT INTO `web_districts` VALUES ('156', 'M&#39;Đrăk', '16', '1', '50');
INSERT INTO `web_districts` VALUES ('157', 'Huyện Trảng Bom', '17', '1', '50');
INSERT INTO `web_districts` VALUES ('158', 'Krông Ana', '72', '1', '50');
INSERT INTO `web_districts` VALUES ('160', 'Krông Bông', '72', '1', '50');
INSERT INTO `web_districts` VALUES ('161', 'Quận 1', '29', '1', '50');
INSERT INTO `web_districts` VALUES ('162', 'Cao Lộc', '34', '1', '50');
INSERT INTO `web_districts` VALUES ('163', 'Quận 2', '29', '1', '50');
INSERT INTO `web_districts` VALUES ('164', 'Lăk', '72', '1', '50');
INSERT INTO `web_districts` VALUES ('165', 'Quận 3', '29', '1', '50');
INSERT INTO `web_districts` VALUES ('166', 'Quận 4', '29', '1', '50');
INSERT INTO `web_districts` VALUES ('167', 'Quận 5', '29', '1', '50');
INSERT INTO `web_districts` VALUES ('168', 'Quận 6', '29', '1', '50');
INSERT INTO `web_districts` VALUES ('169', 'Lộc Bình', '34', '1', '50');
INSERT INTO `web_districts` VALUES ('170', 'Quận 7', '29', '1', '50');
INSERT INTO `web_districts` VALUES ('171', 'Chi Lăng', '34', '1', '50');
INSERT INTO `web_districts` VALUES ('172', 'Quận 8', '29', '1', '50');
INSERT INTO `web_districts` VALUES ('173', 'Đình Lập', '34', '1', '50');
INSERT INTO `web_districts` VALUES ('174', 'Quận 9', '29', '1', '50');
INSERT INTO `web_districts` VALUES ('175', 'Hữu Lũng', '34', '1', '50');
INSERT INTO `web_districts` VALUES ('176', 'Quận 10', '29', '1', '50');
INSERT INTO `web_districts` VALUES ('177', 'Quận 11', '29', '1', '50');
INSERT INTO `web_districts` VALUES ('178', 'Quận 12', '29', '1', '50');
INSERT INTO `web_districts` VALUES ('179', 'Huyện Tân Phú', '17', '1', '50');
INSERT INTO `web_districts` VALUES ('180', 'Gò Vấp', '29', '1', '50');
INSERT INTO `web_districts` VALUES ('181', 'Buôn Đôn', '72', '1', '50');
INSERT INTO `web_districts` VALUES ('182', 'Tân Bình', '29', '1', '50');
INSERT INTO `web_districts` VALUES ('183', 'Xuân Lộc', '17', '1', '50');
INSERT INTO `web_districts` VALUES ('185', 'Tân Phú', '29', '1', '50');
INSERT INTO `web_districts` VALUES ('186', 'Cẩm Mỹ', '17', '1', '50');
INSERT INTO `web_districts` VALUES ('187', 'Buôn Hồ', '16', '1', '50');
INSERT INTO `web_districts` VALUES ('188', 'Bình Thạnh', '29', '1', '50');
INSERT INTO `web_districts` VALUES ('189', 'Phú Nhuận', '29', '1', '50');
INSERT INTO `web_districts` VALUES ('191', 'Tân An', '37', '1', '50');
INSERT INTO `web_districts` VALUES ('192', 'Vĩnh Hưng', '37', '1', '50');
INSERT INTO `web_districts` VALUES ('194', 'Mộc Hoá', '37', '1', '50');
INSERT INTO `web_districts` VALUES ('195', 'Tuy Hoà', '43', '1', '50');
INSERT INTO `web_districts` VALUES ('196', 'Đồng Xuân', '43', '1', '50');
INSERT INTO `web_districts` VALUES ('197', 'Sông Cầu', '43', '1', '50');
INSERT INTO `web_districts` VALUES ('198', 'Tuy An', '43', '1', '50');
INSERT INTO `web_districts` VALUES ('199', 'Sơn Hoà', '43', '1', '50');
INSERT INTO `web_districts` VALUES ('200', 'Tân Thạnh', '37', '1', '50');
INSERT INTO `web_districts` VALUES ('201', 'Sông Hinh', '43', '1', '50');
INSERT INTO `web_districts` VALUES ('202', 'Đông Hoà', '43', '1', '50');
INSERT INTO `web_districts` VALUES ('203', 'Phú Hoà', '43', '1', '50');
INSERT INTO `web_districts` VALUES ('204', 'Đức Huệ', '37', '1', '50');
INSERT INTO `web_districts` VALUES ('205', 'Tây Hoà', '43', '1', '50');
INSERT INTO `web_districts` VALUES ('206', 'Đức Hoà', '37', '1', '50');
INSERT INTO `web_districts` VALUES ('207', 'Bến Lức', '37', '1', '50');
INSERT INTO `web_districts` VALUES ('208', 'Thủ Thừa', '37', '1', '50');
INSERT INTO `web_districts` VALUES ('209', 'Châu Thành', '37', '1', '50');
INSERT INTO `web_districts` VALUES ('212', 'Tân Trụ', '37', '1', '50');
INSERT INTO `web_districts` VALUES ('213', 'Thái Nguyên', '53', '1', '50');
INSERT INTO `web_districts` VALUES ('214', 'Sông Công', '53', '1', '50');
INSERT INTO `web_districts` VALUES ('215', 'Cần Đước', '37', '1', '50');
INSERT INTO `web_districts` VALUES ('216', 'Định Hoá', '53', '1', '50');
INSERT INTO `web_districts` VALUES ('217', 'Cần Giuộc', '37', '1', '50');
INSERT INTO `web_districts` VALUES ('218', 'Phú Lương', '53', '1', '50');
INSERT INTO `web_districts` VALUES ('219', 'Tân Hưng', '37', '1', '50');
INSERT INTO `web_districts` VALUES ('220', 'Võ Nhai', '53', '1', '50');
INSERT INTO `web_districts` VALUES ('222', 'Đại Từ', '53', '1', '50');
INSERT INTO `web_districts` VALUES ('223', 'TP Cao Lãnh', '18', '1', '50');
INSERT INTO `web_districts` VALUES ('224', 'Đồng Hỷ', '53', '1', '50');
INSERT INTO `web_districts` VALUES ('225', 'Sa Đéc', '18', '1', '50');
INSERT INTO `web_districts` VALUES ('226', 'Phú Bình', '53', '1', '50');
INSERT INTO `web_districts` VALUES ('227', 'Tân Hồng', '18', '1', '50');
INSERT INTO `web_districts` VALUES ('228', 'Phổ Yên', '53', '1', '50');
INSERT INTO `web_districts` VALUES ('229', 'Hồng Ngự', '18', '1', '50');
INSERT INTO `web_districts` VALUES ('230', 'Tam Nông', '18', '1', '50');
INSERT INTO `web_districts` VALUES ('231', 'Thanh Bình', '18', '1', '50');
INSERT INTO `web_districts` VALUES ('233', 'Yên Bái', '61', '1', '50');
INSERT INTO `web_districts` VALUES ('234', 'Lấp Vò', '18', '1', '50');
INSERT INTO `web_districts` VALUES ('235', 'Nghĩa Lộ', '61', '1', '50');
INSERT INTO `web_districts` VALUES ('236', 'Tháp Mười', '18', '1', '50');
INSERT INTO `web_districts` VALUES ('237', 'Văn Yên', '61', '1', '50');
INSERT INTO `web_districts` VALUES ('238', 'Lai Vung', '18', '1', '50');
INSERT INTO `web_districts` VALUES ('239', 'Pleiku', '19', '1', '50');
INSERT INTO `web_districts` VALUES ('240', 'Yên Bình', '61', '1', '50');
INSERT INTO `web_districts` VALUES ('241', 'Châu Thành', '18', '1', '50');
INSERT INTO `web_districts` VALUES ('242', 'Mù Cang Chải', '61', '1', '50');
INSERT INTO `web_districts` VALUES ('243', 'Chư Păh', '19', '1', '50');
INSERT INTO `web_districts` VALUES ('244', 'Văn Chấn', '61', '1', '50');
INSERT INTO `web_districts` VALUES ('245', 'Mang Yang', '19', '1', '50');
INSERT INTO `web_districts` VALUES ('246', 'Trấn Yên', '61', '1', '50');
INSERT INTO `web_districts` VALUES ('247', 'Kông Chro', '19', '1', '50');
INSERT INTO `web_districts` VALUES ('249', 'Đức Cơ', '19', '1', '50');
INSERT INTO `web_districts` VALUES ('250', 'Long Xuyên', '66', '1', '50');
INSERT INTO `web_districts` VALUES ('251', 'Châu Đốc', '66', '1', '50');
INSERT INTO `web_districts` VALUES ('252', 'Chư Prông', '19', '1', '50');
INSERT INTO `web_districts` VALUES ('253', 'Trạm Tấu', '61', '1', '50');
INSERT INTO `web_districts` VALUES ('254', 'An Phú', '66', '1', '50');
INSERT INTO `web_districts` VALUES ('255', 'Chư Sê', '19', '1', '50');
INSERT INTO `web_districts` VALUES ('256', 'Tân Châu', '66', '1', '50');
INSERT INTO `web_districts` VALUES ('257', 'Ia Grai', '19', '1', '50');
INSERT INTO `web_districts` VALUES ('258', 'Phú Tân', '66', '1', '50');
INSERT INTO `web_districts` VALUES ('259', 'Tịnh Biên', '66', '1', '50');
INSERT INTO `web_districts` VALUES ('260', 'Đăk Đoa', '19', '1', '50');
INSERT INTO `web_districts` VALUES ('261', 'Tri Tôn', '66', '1', '50');
INSERT INTO `web_districts` VALUES ('262', 'Ia Pa', '19', '1', '50');
INSERT INTO `web_districts` VALUES ('263', 'Châu Phú', '66', '1', '50');
INSERT INTO `web_districts` VALUES ('264', 'Đăk Pơ', '19', '1', '50');
INSERT INTO `web_districts` VALUES ('265', 'Chợ Mới', '66', '1', '50');
INSERT INTO `web_districts` VALUES ('266', 'K’Bang', '19', '1', '50');
INSERT INTO `web_districts` VALUES ('267', 'An Khê', '19', '1', '50');
INSERT INTO `web_districts` VALUES ('268', 'Ayun Pa', '19', '1', '50');
INSERT INTO `web_districts` VALUES ('269', 'Châu Thành', '66', '1', '50');
INSERT INTO `web_districts` VALUES ('270', 'Krông Pa', '19', '1', '50');
INSERT INTO `web_districts` VALUES ('271', 'Thủ Đức', '29', '1', '50');
INSERT INTO `web_districts` VALUES ('272', 'Phú Thiện', '19', '1', '50');
INSERT INTO `web_districts` VALUES ('273', 'Thoại Sơn', '66', '1', '50');
INSERT INTO `web_districts` VALUES ('274', 'Bình Tân', '29', '1', '50');
INSERT INTO `web_districts` VALUES ('275', 'Lục Yên', '61', '1', '50');
INSERT INTO `web_districts` VALUES ('276', 'Chư Pưh', '19', '1', '50');
INSERT INTO `web_districts` VALUES ('277', 'Bình Chánh', '29', '1', '50');
INSERT INTO `web_districts` VALUES ('278', 'Củ Chi', '29', '1', '50');
INSERT INTO `web_districts` VALUES ('280', 'Quy Nhơn', '9', '1', '50');
INSERT INTO `web_districts` VALUES ('281', 'Hóc Môn', '29', '1', '50');
INSERT INTO `web_districts` VALUES ('282', 'Nhà Bè', '29', '1', '50');
INSERT INTO `web_districts` VALUES ('283', 'An Lão', '9', '1', '50');
INSERT INTO `web_districts` VALUES ('285', 'Cần Giờ', '29', '1', '50');
INSERT INTO `web_districts` VALUES ('286', 'Hoài Ân', '9', '1', '50');
INSERT INTO `web_districts` VALUES ('287', 'Vũng Tàu', '67', '1', '50');
INSERT INTO `web_districts` VALUES ('288', 'Bà Rịa', '67', '1', '50');
INSERT INTO `web_districts` VALUES ('289', 'Hoài Nhơn', '9', '1', '50');
INSERT INTO `web_districts` VALUES ('290', 'Xuyên Mộc', '67', '1', '50');
INSERT INTO `web_districts` VALUES ('291', 'Long Điền', '67', '1', '50');
INSERT INTO `web_districts` VALUES ('292', 'Phù Mỹ', '9', '1', '50');
INSERT INTO `web_districts` VALUES ('293', 'Phù Cát', '9', '1', '50');
INSERT INTO `web_districts` VALUES ('294', 'Côn Đảo', '67', '1', '50');
INSERT INTO `web_districts` VALUES ('295', 'Vĩnh Thạnh', '9', '1', '50');
INSERT INTO `web_districts` VALUES ('296', 'Tân Thành', '67', '1', '50');
INSERT INTO `web_districts` VALUES ('297', 'Châu Đức', '67', '1', '50');
INSERT INTO `web_districts` VALUES ('298', 'Tây Sơn', '9', '1', '50');
INSERT INTO `web_districts` VALUES ('300', 'Đất Đỏ', '67', '1', '50');
INSERT INTO `web_districts` VALUES ('301', 'Sơn La', '50', '1', '50');
INSERT INTO `web_districts` VALUES ('302', 'Vân Canh', '9', '1', '50');
INSERT INTO `web_districts` VALUES ('303', 'Quỳnh Nhai', '50', '1', '50');
INSERT INTO `web_districts` VALUES ('305', 'Mường La', '50', '1', '50');
INSERT INTO `web_districts` VALUES ('306', 'An Nhơn', '9', '1', '50');
INSERT INTO `web_districts` VALUES ('307', 'Mỹ Tho', '56', '1', '50');
INSERT INTO `web_districts` VALUES ('308', 'Thuận Châu', '50', '1', '50');
INSERT INTO `web_districts` VALUES ('309', 'Tuy Phước', '9', '1', '50');
INSERT INTO `web_districts` VALUES ('310', 'Bắc Yên', '50', '1', '50');
INSERT INTO `web_districts` VALUES ('311', 'Gò Công', '56', '1', '50');
INSERT INTO `web_districts` VALUES ('313', 'Cái Bè', '56', '1', '50');
INSERT INTO `web_districts` VALUES ('314', 'Phù Yên', '50', '1', '50');
INSERT INTO `web_districts` VALUES ('315', 'KonTum', '32', '1', '50');
INSERT INTO `web_districts` VALUES ('316', 'Mai Sơn', '50', '1', '50');
INSERT INTO `web_districts` VALUES ('317', 'Cai Lậy', '56', '1', '50');
INSERT INTO `web_districts` VALUES ('318', 'Đăk Glei', '32', '1', '50');
INSERT INTO `web_districts` VALUES ('319', 'Yên Châu', '50', '1', '50');
INSERT INTO `web_districts` VALUES ('320', 'Châu Thành', '56', '1', '50');
INSERT INTO `web_districts` VALUES ('321', 'Ngọc Hồi', '32', '1', '50');
INSERT INTO `web_districts` VALUES ('322', 'Sông Mã', '50', '1', '50');
INSERT INTO `web_districts` VALUES ('323', 'Mộc Châu', '50', '1', '50');
INSERT INTO `web_districts` VALUES ('324', 'Đăk Tô', '32', '1', '50');
INSERT INTO `web_districts` VALUES ('325', 'Chợ Gạo', '56', '1', '50');
INSERT INTO `web_districts` VALUES ('326', 'Sa Thầy', '32', '1', '50');
INSERT INTO `web_districts` VALUES ('327', 'Sốp Cộp', '50', '1', '50');
INSERT INTO `web_districts` VALUES ('328', 'Gò Công Tây', '56', '1', '50');
INSERT INTO `web_districts` VALUES ('329', 'Kon Plong', '32', '1', '50');
INSERT INTO `web_districts` VALUES ('330', 'Đăk Hà', '32', '1', '50');
INSERT INTO `web_districts` VALUES ('331', 'Gò Công Đông', '56', '1', '50');
INSERT INTO `web_districts` VALUES ('332', 'Kon Rẫy', '32', '1', '50');
INSERT INTO `web_districts` VALUES ('333', 'Tu Mơ Rông', '32', '1', '50');
INSERT INTO `web_districts` VALUES ('335', 'Tân Phước', '56', '1', '50');
INSERT INTO `web_districts` VALUES ('337', 'Bắc Kạn', '4', '1', '50');
INSERT INTO `web_districts` VALUES ('339', 'Quảng Ngãi', '46', '1', '50');
INSERT INTO `web_districts` VALUES ('340', 'Chợ Đồn', '4', '1', '50');
INSERT INTO `web_districts` VALUES ('341', 'Lý Sơn', '46', '1', '50');
INSERT INTO `web_districts` VALUES ('342', 'Bạch Thông', '4', '1', '50');
INSERT INTO `web_districts` VALUES ('343', 'Bình Sơn', '46', '1', '50');
INSERT INTO `web_districts` VALUES ('344', 'Trà Bồng', '46', '1', '50');
INSERT INTO `web_districts` VALUES ('345', 'Sơn Tịnh', '46', '1', '50');
INSERT INTO `web_districts` VALUES ('346', 'Na Rì', '4', '1', '50');
INSERT INTO `web_districts` VALUES ('347', 'Sơn Hà', '46', '1', '50');
INSERT INTO `web_districts` VALUES ('348', 'Tân Phú Đông', '56', '1', '50');
INSERT INTO `web_districts` VALUES ('349', 'Tư Nghĩa', '46', '1', '50');
INSERT INTO `web_districts` VALUES ('350', 'Nghĩa Hành', '46', '1', '50');
INSERT INTO `web_districts` VALUES ('351', 'Ngân Sơn', '4', '1', '50');
INSERT INTO `web_districts` VALUES ('353', 'Minh Long', '46', '1', '50');
INSERT INTO `web_districts` VALUES ('354', 'Ba Bể', '4', '1', '50');
INSERT INTO `web_districts` VALUES ('355', 'Rạch Giá', '31', '1', '50');
INSERT INTO `web_districts` VALUES ('356', 'Chợ Mới', '4', '1', '50');
INSERT INTO `web_districts` VALUES ('357', 'Mộ Đức', '46', '1', '50');
INSERT INTO `web_districts` VALUES ('358', 'Hà Tiên', '31', '1', '50');
INSERT INTO `web_districts` VALUES ('359', 'Pác Nặm', '4', '1', '50');
INSERT INTO `web_districts` VALUES ('360', 'Đức Phổ', '46', '1', '50');
INSERT INTO `web_districts` VALUES ('361', 'Kiên Lương', '31', '1', '50');
INSERT INTO `web_districts` VALUES ('362', 'Hòn Đất', '31', '1', '50');
INSERT INTO `web_districts` VALUES ('363', 'Ba Tơ', '46', '1', '50');
INSERT INTO `web_districts` VALUES ('364', 'Phú Thọ', '42', '1', '50');
INSERT INTO `web_districts` VALUES ('365', 'Tân Hiệp', '31', '1', '50');
INSERT INTO `web_districts` VALUES ('366', 'Sơn Tây', '46', '1', '50');
INSERT INTO `web_districts` VALUES ('367', 'Châu Thành', '31', '1', '50');
INSERT INTO `web_districts` VALUES ('368', 'Tây Trà', '46', '1', '50');
INSERT INTO `web_districts` VALUES ('369', 'Giồng Riềng', '31', '1', '50');
INSERT INTO `web_districts` VALUES ('370', 'Hạ Hoà', '42', '1', '50');
INSERT INTO `web_districts` VALUES ('371', 'Gò Quao', '31', '1', '50');
INSERT INTO `web_districts` VALUES ('372', 'Cẩm Khê', '42', '1', '50');
INSERT INTO `web_districts` VALUES ('374', 'An Biên', '31', '1', '50');
INSERT INTO `web_districts` VALUES ('375', 'Yên Lập', '42', '1', '50');
INSERT INTO `web_districts` VALUES ('376', 'An Minh', '31', '1', '50');
INSERT INTO `web_districts` VALUES ('377', 'Thanh Sơn', '42', '1', '50');
INSERT INTO `web_districts` VALUES ('378', 'Vĩnh Thuận', '31', '1', '50');
INSERT INTO `web_districts` VALUES ('379', 'Tam Kỳ', '45', '1', '50');
INSERT INTO `web_districts` VALUES ('380', 'Phù Ninh', '42', '1', '50');
INSERT INTO `web_districts` VALUES ('381', 'Phú Quốc', '31', '1', '50');
INSERT INTO `web_districts` VALUES ('382', 'Hội An', '45', '1', '50');
INSERT INTO `web_districts` VALUES ('383', 'Lâm Thao', '42', '1', '50');
INSERT INTO `web_districts` VALUES ('384', 'Kiên Hải', '31', '1', '50');
INSERT INTO `web_districts` VALUES ('385', 'Tam Nông', '42', '1', '50');
INSERT INTO `web_districts` VALUES ('386', 'U Minh Thượng', '31', '1', '50');
INSERT INTO `web_districts` VALUES ('387', 'Duy Xuyên', '45', '1', '50');
INSERT INTO `web_districts` VALUES ('388', 'Thanh Thủy', '42', '1', '50');
INSERT INTO `web_districts` VALUES ('389', 'Điện Bàn', '45', '1', '50');
INSERT INTO `web_districts` VALUES ('390', 'Tân Sơn', '42', '1', '50');
INSERT INTO `web_districts` VALUES ('391', 'Giang Thành', '31', '1', '50');
INSERT INTO `web_districts` VALUES ('392', 'Đại Lộc', '45', '1', '50');
INSERT INTO `web_districts` VALUES ('394', 'Quế Sơn', '45', '1', '50');
INSERT INTO `web_districts` VALUES ('395', 'Ninh Kiều', '14', '1', '50');
INSERT INTO `web_districts` VALUES ('396', 'Hiệp Đức', '45', '1', '50');
INSERT INTO `web_districts` VALUES ('397', 'Bình Thuỷ', '14', '1', '50');
INSERT INTO `web_districts` VALUES ('398', 'Thăng Bình', '45', '1', '50');
INSERT INTO `web_districts` VALUES ('399', 'Cái Răng', '14', '1', '50');
INSERT INTO `web_districts` VALUES ('400', 'Ô Môn', '14', '1', '50');
INSERT INTO `web_districts` VALUES ('401', 'Núi Thành', '45', '1', '50');
INSERT INTO `web_districts` VALUES ('402', 'Phong Điền', '14', '1', '50');
INSERT INTO `web_districts` VALUES ('403', 'Tiên Phước', '45', '1', '50');
INSERT INTO `web_districts` VALUES ('404', 'Cờ Đỏ', '14', '1', '50');
INSERT INTO `web_districts` VALUES ('405', 'Bắc Trà My', '45', '1', '50');
INSERT INTO `web_districts` VALUES ('406', 'Vĩnh Thạnh', '14', '1', '50');
INSERT INTO `web_districts` VALUES ('407', 'Thốt Nốt', '14', '1', '50');
INSERT INTO `web_districts` VALUES ('408', 'Đông Giang', '45', '1', '50');
INSERT INTO `web_districts` VALUES ('409', 'Thới Lai', '14', '1', '50');
INSERT INTO `web_districts` VALUES ('410', 'Nam Giang', '45', '1', '50');
INSERT INTO `web_districts` VALUES ('412', 'Phước Sơn', '45', '1', '50');
INSERT INTO `web_districts` VALUES ('413', 'Nam Trà My', '45', '1', '50');
INSERT INTO `web_districts` VALUES ('414', 'Bến Tre', '7', '1', '50');
INSERT INTO `web_districts` VALUES ('415', 'Tây Giang', '45', '1', '50');
INSERT INTO `web_districts` VALUES ('416', 'Phú Ninh', '45', '1', '50');
INSERT INTO `web_districts` VALUES ('417', 'Nông Sơn', '45', '1', '50');
INSERT INTO `web_districts` VALUES ('418', 'Châu Thành', '7', '1', '50');
INSERT INTO `web_districts` VALUES ('420', 'Chợ Lách', '7', '1', '50');
INSERT INTO `web_districts` VALUES ('421', 'Mỏ Cày Bắc', '7', '1', '50');
INSERT INTO `web_districts` VALUES ('423', 'Giồng Trôm', '7', '1', '50');
INSERT INTO `web_districts` VALUES ('424', 'Huế', '55', '1', '50');
INSERT INTO `web_districts` VALUES ('425', 'Hồng Bàng', '26', '1', '50');
INSERT INTO `web_districts` VALUES ('426', 'Bình Đại', '7', '1', '50');
INSERT INTO `web_districts` VALUES ('427', 'Phong Điền', '55', '1', '50');
INSERT INTO `web_districts` VALUES ('428', 'Quảng Điền', '55', '1', '50');
INSERT INTO `web_districts` VALUES ('429', 'Ba Tri', '7', '1', '50');
INSERT INTO `web_districts` VALUES ('430', 'Thạnh Phú', '7', '1', '50');
INSERT INTO `web_districts` VALUES ('431', 'Hương Trà', '55', '1', '50');
INSERT INTO `web_districts` VALUES ('432', 'Mỏ Cày Nam', '7', '1', '50');
INSERT INTO `web_districts` VALUES ('433', 'Lê Chân', '26', '1', '50');
INSERT INTO `web_districts` VALUES ('434', 'Phú Vang', '55', '1', '50');
INSERT INTO `web_districts` VALUES ('435', 'Ngô Quyền', '26', '1', '50');
INSERT INTO `web_districts` VALUES ('436', 'Hương Thuỷ', '55', '1', '50');
INSERT INTO `web_districts` VALUES ('438', 'Kiến An', '26', '1', '50');
INSERT INTO `web_districts` VALUES ('439', 'Phú Lộc', '55', '1', '50');
INSERT INTO `web_districts` VALUES ('440', 'Vĩnh Long', '59', '1', '50');
INSERT INTO `web_districts` VALUES ('442', 'Long Hồ', '59', '1', '50');
INSERT INTO `web_districts` VALUES ('443', 'Nam Đông', '55', '1', '50');
INSERT INTO `web_districts` VALUES ('444', 'Hải An', '26', '1', '50');
INSERT INTO `web_districts` VALUES ('445', 'Mang Thít', '59', '1', '50');
INSERT INTO `web_districts` VALUES ('446', 'A Lưới', '55', '1', '50');
INSERT INTO `web_districts` VALUES ('447', 'Đồ Sơn', '26', '1', '50');
INSERT INTO `web_districts` VALUES ('448', 'Bình Minh', '59', '1', '50');
INSERT INTO `web_districts` VALUES ('449', 'An Lão', '26', '1', '50');
INSERT INTO `web_districts` VALUES ('450', 'Tam Bình', '59', '1', '50');
INSERT INTO `web_districts` VALUES ('452', 'Kiến Thụy', '26', '1', '50');
INSERT INTO `web_districts` VALUES ('453', 'Trà Ôn', '59', '1', '50');
INSERT INTO `web_districts` VALUES ('454', 'Đông Hà', '48', '1', '50');
INSERT INTO `web_districts` VALUES ('455', 'Thủy Nguyên', '26', '1', '50');
INSERT INTO `web_districts` VALUES ('456', 'An Dương', '26', '1', '50');
INSERT INTO `web_districts` VALUES ('458', 'Tiên Lãng', '26', '1', '50');
INSERT INTO `web_districts` VALUES ('459', 'Vĩnh Linh', '48', '1', '50');
INSERT INTO `web_districts` VALUES ('460', 'Vĩnh Bảo', '26', '1', '50');
INSERT INTO `web_districts` VALUES ('461', 'Gio Linh', '48', '1', '50');
INSERT INTO `web_districts` VALUES ('462', 'Cam Lộ', '48', '1', '50');
INSERT INTO `web_districts` VALUES ('463', 'Triệu Phong', '48', '1', '50');
INSERT INTO `web_districts` VALUES ('464', 'Hải Lăng', '48', '1', '50');
INSERT INTO `web_districts` VALUES ('465', 'Hướng Hoá', '48', '1', '50');
INSERT INTO `web_districts` VALUES ('466', 'Đăk Rông', '48', '1', '50');
INSERT INTO `web_districts` VALUES ('467', 'Cồn Cỏ', '48', '1', '50');
INSERT INTO `web_districts` VALUES ('469', 'Đồng Hới', '44', '1', '50');
INSERT INTO `web_districts` VALUES ('470', 'Vũng Liêm', '59', '1', '50');
INSERT INTO `web_districts` VALUES ('471', 'Tuyên Hoá', '44', '1', '50');
INSERT INTO `web_districts` VALUES ('472', 'Bình Tân', '59', '1', '50');
INSERT INTO `web_districts` VALUES ('473', 'Minh Hoá', '44', '1', '50');
INSERT INTO `web_districts` VALUES ('474', 'Quảng Trạch', '44', '1', '50');
INSERT INTO `web_districts` VALUES ('476', 'Trà Vinh', '57', '1', '50');
INSERT INTO `web_districts` VALUES ('477', 'Bố Trạch', '44', '1', '50');
INSERT INTO `web_districts` VALUES ('478', 'Càng Long', '57', '1', '50');
INSERT INTO `web_districts` VALUES ('479', 'Cầu Kè', '57', '1', '50');
INSERT INTO `web_districts` VALUES ('480', 'Quảng Ninh', '44', '1', '50');
INSERT INTO `web_districts` VALUES ('481', 'Tiểu Cần', '57', '1', '50');
INSERT INTO `web_districts` VALUES ('482', 'Lệ Thuỷ', '44', '1', '50');
INSERT INTO `web_districts` VALUES ('483', 'Châu Thành', '57', '1', '50');
INSERT INTO `web_districts` VALUES ('484', 'Trà Cú', '57', '1', '50');
INSERT INTO `web_districts` VALUES ('485', 'Cầu Ngang', '57', '1', '50');
INSERT INTO `web_districts` VALUES ('487', 'Duyên Hải', '57', '1', '50');
INSERT INTO `web_districts` VALUES ('488', 'Hà Tĩnh', '24', '1', '50');
INSERT INTO `web_districts` VALUES ('489', 'Hồng Lĩnh', '24', '1', '50');
INSERT INTO `web_districts` VALUES ('490', 'Cát Hải', '26', '1', '50');
INSERT INTO `web_districts` VALUES ('492', 'Hương Sơn', '24', '1', '50');
INSERT INTO `web_districts` VALUES ('493', 'Sóc Trăng', '49', '1', '50');
INSERT INTO `web_districts` VALUES ('494', 'Bạch Long Vĩ', '26', '1', '50');
INSERT INTO `web_districts` VALUES ('495', 'Đức Thọ', '24', '1', '50');
INSERT INTO `web_districts` VALUES ('496', 'Mỹ Xuyên', '49', '1', '50');
INSERT INTO `web_districts` VALUES ('497', 'Dương Kinh', '26', '1', '50');
INSERT INTO `web_districts` VALUES ('498', 'Thạnh Trị', '49', '1', '50');
INSERT INTO `web_districts` VALUES ('499', 'Nghi Xuân', '24', '1', '50');
INSERT INTO `web_districts` VALUES ('500', 'Can Lộc', '24', '1', '50');
INSERT INTO `web_districts` VALUES ('501', 'Cù Lao Dung', '49', '1', '50');
INSERT INTO `web_districts` VALUES ('502', 'Ngã Năm', '49', '1', '50');
INSERT INTO `web_districts` VALUES ('503', 'Hương Khê', '24', '1', '50');
INSERT INTO `web_districts` VALUES ('505', 'Thạch Hà', '24', '1', '50');
INSERT INTO `web_districts` VALUES ('506', 'Kế Sách', '49', '1', '50');
INSERT INTO `web_districts` VALUES ('507', 'Cẩm Xuyên', '24', '1', '50');
INSERT INTO `web_districts` VALUES ('508', 'Mỹ Tú', '49', '1', '50');
INSERT INTO `web_districts` VALUES ('509', 'Thị Xã Kỳ Anh', '24', '1', '50');
INSERT INTO `web_districts` VALUES ('510', 'Hải Châu', '15', '1', '50');
INSERT INTO `web_districts` VALUES ('511', 'Long Phú', '49', '1', '50');
INSERT INTO `web_districts` VALUES ('512', 'Vũ Quang', '24', '1', '50');
INSERT INTO `web_districts` VALUES ('513', 'Vĩnh Châu', '49', '1', '50');
INSERT INTO `web_districts` VALUES ('514', 'Thanh Khê', '15', '1', '50');
INSERT INTO `web_districts` VALUES ('515', 'Lộc Hà', '24', '1', '50');
INSERT INTO `web_districts` VALUES ('516', 'Châu Thành', '49', '1', '50');
INSERT INTO `web_districts` VALUES ('517', 'Sơn Trà', '15', '1', '50');
INSERT INTO `web_districts` VALUES ('518', 'Trần Đề', '49', '1', '50');
INSERT INTO `web_districts` VALUES ('519', 'Ngũ Hành Sơn', '15', '1', '50');
INSERT INTO `web_districts` VALUES ('521', 'Liên Chiểu', '15', '1', '50');
INSERT INTO `web_districts` VALUES ('522', 'Vinh', '39', '1', '50');
INSERT INTO `web_districts` VALUES ('524', 'Hoà Vang', '15', '1', '50');
INSERT INTO `web_districts` VALUES ('525', 'Cửa Lò', '39', '1', '50');
INSERT INTO `web_districts` VALUES ('526', 'Bạc Liêu', '3', '1', '50');
INSERT INTO `web_districts` VALUES ('527', 'Vĩnh Lợi', '3', '1', '50');
INSERT INTO `web_districts` VALUES ('528', 'Quỳ Châu', '39', '1', '50');
INSERT INTO `web_districts` VALUES ('529', 'Hồng Dân', '3', '1', '50');
INSERT INTO `web_districts` VALUES ('530', 'Quỳ Hợp', '39', '1', '50');
INSERT INTO `web_districts` VALUES ('531', 'Giá Rai', '3', '1', '50');
INSERT INTO `web_districts` VALUES ('532', 'Nghĩa Đàn', '39', '1', '50');
INSERT INTO `web_districts` VALUES ('533', 'Cẩm Lệ', '15', '1', '50');
INSERT INTO `web_districts` VALUES ('534', 'Phước Long', '3', '1', '50');
INSERT INTO `web_districts` VALUES ('535', 'Quỳnh Lưu', '39', '1', '50');
INSERT INTO `web_districts` VALUES ('536', 'Đông Hải', '3', '1', '50');
INSERT INTO `web_districts` VALUES ('537', 'Kỳ Sơn', '39', '1', '50');
INSERT INTO `web_districts` VALUES ('538', 'Hoà Bình', '3', '1', '50');
INSERT INTO `web_districts` VALUES ('539', 'Tương Dương', '39', '1', '50');
INSERT INTO `web_districts` VALUES ('540', 'Con Cuông', '39', '1', '50');
INSERT INTO `web_districts` VALUES ('542', 'Tân Kỳ', '39', '1', '50');
INSERT INTO `web_districts` VALUES ('543', 'Yên Thành', '39', '1', '50');
INSERT INTO `web_districts` VALUES ('544', 'Diễn Châu', '39', '1', '50');
INSERT INTO `web_districts` VALUES ('545', 'Anh Sơn', '39', '1', '50');
INSERT INTO `web_districts` VALUES ('546', 'Đô Lương', '39', '1', '50');
INSERT INTO `web_districts` VALUES ('547', 'Thanh Chương', '39', '1', '50');
INSERT INTO `web_districts` VALUES ('548', 'Nghi Lộc', '39', '1', '50');
INSERT INTO `web_districts` VALUES ('549', 'Đồng Văn', '20', '1', '50');
INSERT INTO `web_districts` VALUES ('550', 'Mèo Vạc', '20', '1', '50');
INSERT INTO `web_districts` VALUES ('551', 'Nam Đàn', '39', '1', '50');
INSERT INTO `web_districts` VALUES ('553', 'Yên Minh', '20', '1', '50');
INSERT INTO `web_districts` VALUES ('554', 'Hưng Nguyên', '39', '1', '50');
INSERT INTO `web_districts` VALUES ('555', 'Quản Bạ', '20', '1', '50');
INSERT INTO `web_districts` VALUES ('556', 'Vị Xuyên', '20', '1', '50');
INSERT INTO `web_districts` VALUES ('557', 'Quế Phong', '39', '1', '50');
INSERT INTO `web_districts` VALUES ('558', 'Bắc Mê', '20', '1', '50');
INSERT INTO `web_districts` VALUES ('559', 'Thị xã Thái Hòa', '39', '1', '50');
INSERT INTO `web_districts` VALUES ('560', 'Hoàng Su Phì', '20', '1', '50');
INSERT INTO `web_districts` VALUES ('561', 'Cà Mau', '12', '1', '50');
INSERT INTO `web_districts` VALUES ('563', 'Xín Mần', '20', '1', '50');
INSERT INTO `web_districts` VALUES ('564', 'Thới Bình', '12', '1', '50');
INSERT INTO `web_districts` VALUES ('565', 'Thanh Hoá', '54', '1', '50');
INSERT INTO `web_districts` VALUES ('566', 'U Minh', '12', '1', '50');
INSERT INTO `web_districts` VALUES ('567', 'Bắc Quang', '20', '1', '50');
INSERT INTO `web_districts` VALUES ('568', 'Bỉm Sơn', '54', '1', '50');
INSERT INTO `web_districts` VALUES ('569', 'Trần Văn Thời', '12', '1', '50');
INSERT INTO `web_districts` VALUES ('570', 'Sầm Sơn', '54', '1', '50');
INSERT INTO `web_districts` VALUES ('571', 'Quang Bình', '20', '1', '50');
INSERT INTO `web_districts` VALUES ('572', 'Cái Nước', '12', '1', '50');
INSERT INTO `web_districts` VALUES ('573', 'Quan Hoá', '54', '1', '50');
INSERT INTO `web_districts` VALUES ('574', 'Quan Sơn', '54', '1', '50');
INSERT INTO `web_districts` VALUES ('575', 'Mường Lát', '54', '1', '50');
INSERT INTO `web_districts` VALUES ('577', 'Bá Thước', '54', '1', '50');
INSERT INTO `web_districts` VALUES ('578', 'Cao Bằng', '13', '1', '50');
INSERT INTO `web_districts` VALUES ('579', 'Thường Xuân', '54', '1', '50');
INSERT INTO `web_districts` VALUES ('580', 'Bảo Lạc', '13', '1', '50');
INSERT INTO `web_districts` VALUES ('581', 'Thông Nông', '13', '1', '50');
INSERT INTO `web_districts` VALUES ('582', 'Như Xuân', '54', '1', '50');
INSERT INTO `web_districts` VALUES ('583', 'Như Thanh', '54', '1', '50');
INSERT INTO `web_districts` VALUES ('584', 'Lang Chánh', '54', '1', '50');
INSERT INTO `web_districts` VALUES ('585', 'Ngọc Lặc', '54', '1', '50');
INSERT INTO `web_districts` VALUES ('586', 'Thạch Thành', '54', '1', '50');
INSERT INTO `web_districts` VALUES ('587', 'Cẩm Thủy', '54', '1', '50');
INSERT INTO `web_districts` VALUES ('588', 'Hà Quảng', '13', '1', '50');
INSERT INTO `web_districts` VALUES ('589', 'Thọ Xuân', '54', '1', '50');
INSERT INTO `web_districts` VALUES ('590', 'Trà Lĩnh', '13', '1', '50');
INSERT INTO `web_districts` VALUES ('591', 'Vĩnh Lộc', '54', '1', '50');
INSERT INTO `web_districts` VALUES ('592', 'Thiệu Hoá', '54', '1', '50');
INSERT INTO `web_districts` VALUES ('593', 'Triệu Sơn', '54', '1', '50');
INSERT INTO `web_districts` VALUES ('594', 'Đầm Dơi', '12', '1', '50');
INSERT INTO `web_districts` VALUES ('595', 'Nông Cống', '54', '1', '50');
INSERT INTO `web_districts` VALUES ('596', 'Ngọc Hiển', '12', '1', '50');
INSERT INTO `web_districts` VALUES ('597', 'Đông Sơn', '54', '1', '50');
INSERT INTO `web_districts` VALUES ('598', 'Năm Căn', '12', '1', '50');
INSERT INTO `web_districts` VALUES ('599', 'Hà Trung', '54', '1', '50');
INSERT INTO `web_districts` VALUES ('600', 'Phú Tân', '12', '1', '50');
INSERT INTO `web_districts` VALUES ('601', 'Hoằng Hoá', '54', '1', '50');
INSERT INTO `web_districts` VALUES ('603', 'Nga Sơn', '54', '1', '50');
INSERT INTO `web_districts` VALUES ('604', 'Điện Biên Phủ', '69', '1', '1');
INSERT INTO `web_districts` VALUES ('605', 'Hậu Lộc', '54', '1', '50');
INSERT INTO `web_districts` VALUES ('606', 'Mường Lay', '69', '1', '2');
INSERT INTO `web_districts` VALUES ('607', 'Quảng Xương', '54', '1', '50');
INSERT INTO `web_districts` VALUES ('608', 'Điện Biên', '69', '1', '50');
INSERT INTO `web_districts` VALUES ('609', 'Tĩnh Gia', '54', '1', '50');
INSERT INTO `web_districts` VALUES ('610', 'Tuần Giáo', '69', '1', '50');
INSERT INTO `web_districts` VALUES ('611', 'Yên Định', '54', '1', '50');
INSERT INTO `web_districts` VALUES ('612', 'Trùng Khánh', '13', '1', '50');
INSERT INTO `web_districts` VALUES ('613', 'Mường Chà', '69', '1', '50');
INSERT INTO `web_districts` VALUES ('614', 'Tủa Chùa', '69', '1', '50');
INSERT INTO `web_districts` VALUES ('615', 'Nguyên Bình', '13', '1', '50');
INSERT INTO `web_districts` VALUES ('616', 'Điện Biên Đông', '69', '1', '50');
INSERT INTO `web_districts` VALUES ('618', 'Mường Nhé', '69', '1', '50');
INSERT INTO `web_districts` VALUES ('619', 'Thành phố Ninh Bình', '40', '1', '50');
INSERT INTO `web_districts` VALUES ('620', 'Mường Ảng', '69', '1', '50');
INSERT INTO `web_districts` VALUES ('622', 'Tam Điệp', '40', '1', '50');
INSERT INTO `web_districts` VALUES ('623', 'Nho Quan', '40', '1', '50');
INSERT INTO `web_districts` VALUES ('624', 'Gia Viễn', '40', '1', '50');
INSERT INTO `web_districts` VALUES ('625', 'Hoa Lư', '40', '1', '50');
INSERT INTO `web_districts` VALUES ('626', 'Yên Mô', '40', '1', '50');
INSERT INTO `web_districts` VALUES ('628', 'Kim Sơn', '40', '1', '50');
INSERT INTO `web_districts` VALUES ('629', 'Gia Nghĩa', '71', '1', '50');
INSERT INTO `web_districts` VALUES ('630', 'Yên Khánh', '40', '1', '50');
INSERT INTO `web_districts` VALUES ('631', 'Dăk RLấp', '71', '1', '50');
INSERT INTO `web_districts` VALUES ('632', 'Dăk Mil', '71', '1', '50');
INSERT INTO `web_districts` VALUES ('633', 'Cư Jút', '71', '1', '50');
INSERT INTO `web_districts` VALUES ('635', 'Hoà An', '13', '1', '50');
INSERT INTO `web_districts` VALUES ('636', 'Dăk Song', '71', '1', '50');
INSERT INTO `web_districts` VALUES ('637', 'Thái Bình', '52', '1', '50');
INSERT INTO `web_districts` VALUES ('638', 'Quảng Uyên', '13', '1', '50');
INSERT INTO `web_districts` VALUES ('639', 'Krông Nô', '71', '1', '50');
INSERT INTO `web_districts` VALUES ('640', 'Thạch An', '13', '1', '50');
INSERT INTO `web_districts` VALUES ('641', 'Quỳnh Phụ', '52', '1', '50');
INSERT INTO `web_districts` VALUES ('642', 'Dăk GLong', '71', '1', '50');
INSERT INTO `web_districts` VALUES ('643', 'Hạ Lang', '13', '1', '50');
INSERT INTO `web_districts` VALUES ('644', 'Hưng Hà', '52', '1', '50');
INSERT INTO `web_districts` VALUES ('645', 'Tuy Đức', '71', '1', '50');
INSERT INTO `web_districts` VALUES ('646', 'Bảo Lâm', '13', '1', '50');
INSERT INTO `web_districts` VALUES ('647', 'Đông Hưng', '52', '1', '50');
INSERT INTO `web_districts` VALUES ('648', 'Phục Hoà', '13', '1', '50');
INSERT INTO `web_districts` VALUES ('649', 'Vũ Thư', '52', '1', '50');
INSERT INTO `web_districts` VALUES ('651', 'Kiến Xương', '52', '1', '50');
INSERT INTO `web_districts` VALUES ('652', 'Vị Thanh', '70', '1', '50');
INSERT INTO `web_districts` VALUES ('654', 'Vị Thuỷ', '70', '1', '50');
INSERT INTO `web_districts` VALUES ('655', 'Tiền Hải', '52', '1', '50');
INSERT INTO `web_districts` VALUES ('656', 'Lai Châu', '33', '1', '50');
INSERT INTO `web_districts` VALUES ('657', 'Long Mỹ', '70', '1', '50');
INSERT INTO `web_districts` VALUES ('658', 'Thái Thuỵ', '52', '1', '50');
INSERT INTO `web_districts` VALUES ('659', 'Phụng Hiệp', '70', '1', '50');
INSERT INTO `web_districts` VALUES ('660', 'Tam Đường', '33', '1', '50');
INSERT INTO `web_districts` VALUES ('661', 'Châu Thành', '70', '1', '50');
INSERT INTO `web_districts` VALUES ('662', 'Phong Thổ', '33', '1', '50');
INSERT INTO `web_districts` VALUES ('663', 'Châu Thành A', '70', '1', '50');
INSERT INTO `web_districts` VALUES ('665', 'Sìn Hồ', '33', '1', '50');
INSERT INTO `web_districts` VALUES ('666', 'Ngã Bảy', '70', '1', '50');
INSERT INTO `web_districts` VALUES ('667', 'Nam Định', '38', '1', '50');
INSERT INTO `web_districts` VALUES ('668', 'Mường Tè', '33', '1', '50');
INSERT INTO `web_districts` VALUES ('669', 'Mỹ Lộc', '38', '1', '50');
INSERT INTO `web_districts` VALUES ('670', 'Than Uyên', '33', '1', '50');
INSERT INTO `web_districts` VALUES ('671', 'Xuân Trường', '38', '1', '50');
INSERT INTO `web_districts` VALUES ('672', 'Tân Uyên', '33', '1', '50');
INSERT INTO `web_districts` VALUES ('673', 'Giao Thủy', '38', '1', '50');
INSERT INTO `web_districts` VALUES ('674', 'Ý Yên', '38', '1', '50');
INSERT INTO `web_districts` VALUES ('676', 'Vụ Bản', '38', '1', '50');
INSERT INTO `web_districts` VALUES ('677', 'Lào Cai', '35', '1', '50');
INSERT INTO `web_districts` VALUES ('678', 'Nam Trực', '38', '1', '50');
INSERT INTO `web_districts` VALUES ('679', 'Xi Ma Cai', '35', '1', '50');
INSERT INTO `web_districts` VALUES ('680', 'Trực Ninh', '38', '1', '50');
INSERT INTO `web_districts` VALUES ('681', 'Bát Xát', '35', '1', '50');
INSERT INTO `web_districts` VALUES ('682', 'Nghĩa Hưng', '38', '1', '50');
INSERT INTO `web_districts` VALUES ('683', 'Bảo Thắng', '35', '1', '50');
INSERT INTO `web_districts` VALUES ('684', 'Hải Hậu', '38', '1', '50');
INSERT INTO `web_districts` VALUES ('685', 'Sa Pa', '35', '1', '50');
INSERT INTO `web_districts` VALUES ('686', 'Văn Bàn', '35', '1', '50');
INSERT INTO `web_districts` VALUES ('688', 'Phủ Lý', '21', '1', '50');
INSERT INTO `web_districts` VALUES ('689', 'Duy Tiên', '21', '1', '50');
INSERT INTO `web_districts` VALUES ('690', 'Bảo Yên', '35', '1', '50');
INSERT INTO `web_districts` VALUES ('691', 'Kim Bảng', '21', '1', '50');
INSERT INTO `web_districts` VALUES ('692', 'Bắc Hà', '35', '1', '50');
INSERT INTO `web_districts` VALUES ('693', 'Lý Nhân', '21', '1', '50');
INSERT INTO `web_districts` VALUES ('694', 'Mường Khương', '35', '1', '50');
INSERT INTO `web_districts` VALUES ('695', 'Thanh Liêm', '21', '1', '50');
INSERT INTO `web_districts` VALUES ('696', 'Bình Lục', '21', '1', '50');
INSERT INTO `web_districts` VALUES ('698', 'Hoà Bình', '27', '1', '50');
INSERT INTO `web_districts` VALUES ('699', 'Đà Bắc', '27', '1', '50');
INSERT INTO `web_districts` VALUES ('700', 'Mai Châu', '27', '1', '50');
INSERT INTO `web_districts` VALUES ('701', 'Tân Lạc', '27', '1', '50');
INSERT INTO `web_districts` VALUES ('702', 'Lạc Sơn', '27', '1', '50');
INSERT INTO `web_districts` VALUES ('703', 'Kỳ Sơn', '27', '1', '50');
INSERT INTO `web_districts` VALUES ('704', 'Lương Sơn', '27', '1', '50');
INSERT INTO `web_districts` VALUES ('705', 'Kim Bôi', '27', '1', '50');
INSERT INTO `web_districts` VALUES ('706', 'Lạc Thuỷ', '27', '1', '50');
INSERT INTO `web_districts` VALUES ('707', 'Yên Thuỷ', '27', '1', '50');
INSERT INTO `web_districts` VALUES ('708', 'Cao Phong', '27', '1', '50');
INSERT INTO `web_districts` VALUES ('710', 'Hưng Yên', '28', '1', '50');
INSERT INTO `web_districts` VALUES ('711', 'Kim Động', '28', '1', '50');
INSERT INTO `web_districts` VALUES ('712', 'Ân Thi', '28', '1', '50');
INSERT INTO `web_districts` VALUES ('713', 'Khoái Châu', '28', '1', '50');
INSERT INTO `web_districts` VALUES ('714', 'Yên Mỹ', '28', '1', '50');
INSERT INTO `web_districts` VALUES ('715', 'Tiên Lữ', '28', '1', '50');
INSERT INTO `web_districts` VALUES ('716', 'Phù Cừ', '28', '1', '50');
INSERT INTO `web_districts` VALUES ('717', 'Mỹ Hào', '28', '1', '50');
INSERT INTO `web_districts` VALUES ('718', 'Văn Lâm', '28', '1', '50');
INSERT INTO `web_districts` VALUES ('719', 'Văn Giang', '28', '1', '50');
INSERT INTO `web_districts` VALUES ('721', 'Hải Dương', '25', '1', '50');
INSERT INTO `web_districts` VALUES ('722', 'Chí Linh', '25', '1', '50');
INSERT INTO `web_districts` VALUES ('723', 'Nam Sách', '25', '1', '50');
INSERT INTO `web_districts` VALUES ('724', 'Kinh Môn', '25', '1', '50');
INSERT INTO `web_districts` VALUES ('725', 'Gia Lộc', '25', '1', '50');
INSERT INTO `web_districts` VALUES ('726', 'Tứ Kỳ', '25', '1', '50');
INSERT INTO `web_districts` VALUES ('727', 'Thanh Miện', '25', '1', '50');
INSERT INTO `web_districts` VALUES ('728', 'Ninh Giang', '25', '1', '50');
INSERT INTO `web_districts` VALUES ('729', 'Cẩm Giàng', '25', '1', '50');
INSERT INTO `web_districts` VALUES ('730', 'Thanh Hà', '25', '1', '50');
INSERT INTO `web_districts` VALUES ('731', 'Kim Thành', '25', '1', '50');
INSERT INTO `web_districts` VALUES ('732', 'Bình Giang', '25', '1', '50');
INSERT INTO `web_districts` VALUES ('734', 'Bắc Ninh', '6', '1', '50');
INSERT INTO `web_districts` VALUES ('735', 'Yên Phong', '6', '1', '50');
INSERT INTO `web_districts` VALUES ('736', 'Quế Võ', '6', '1', '50');
INSERT INTO `web_districts` VALUES ('737', 'Tiên Du', '6', '1', '50');
INSERT INTO `web_districts` VALUES ('738', 'Từ  Sơn', '6', '1', '50');
INSERT INTO `web_districts` VALUES ('739', 'Thuận Thành', '6', '1', '50');
INSERT INTO `web_districts` VALUES ('740', 'Gia Bình', '6', '1', '50');
INSERT INTO `web_districts` VALUES ('741', 'Lương Tài', '6', '1', '50');
INSERT INTO `web_districts` VALUES ('743', 'Bắc Giang', '5', '1', '50');
INSERT INTO `web_districts` VALUES ('744', 'Yên Thế', '5', '1', '50');
INSERT INTO `web_districts` VALUES ('745', 'Lục Ngạn', '5', '1', '50');
INSERT INTO `web_districts` VALUES ('746', 'Sơn Động', '5', '1', '50');
INSERT INTO `web_districts` VALUES ('747', 'Lục Nam', '5', '1', '50');
INSERT INTO `web_districts` VALUES ('748', 'Tân Yên', '5', '1', '50');
INSERT INTO `web_districts` VALUES ('749', 'Hiệp Hoà', '5', '1', '50');
INSERT INTO `web_districts` VALUES ('750', 'Lạng Giang', '5', '1', '50');
INSERT INTO `web_districts` VALUES ('751', 'Việt Yên', '5', '1', '50');
INSERT INTO `web_districts` VALUES ('752', 'Yên Dũng', '5', '1', '50');
INSERT INTO `web_districts` VALUES ('754', 'Hạ Long', '47', '1', '50');
INSERT INTO `web_districts` VALUES ('755', 'Cẩm Phả', '47', '1', '50');
INSERT INTO `web_districts` VALUES ('756', 'Uông Bí', '47', '1', '50');
INSERT INTO `web_districts` VALUES ('757', 'Móng Cái', '47', '1', '50');
INSERT INTO `web_districts` VALUES ('758', 'Bình Liêu', '47', '1', '50');
INSERT INTO `web_districts` VALUES ('759', 'Đầm Hà', '47', '1', '50');
INSERT INTO `web_districts` VALUES ('760', 'Hải Hà', '47', '1', '50');
INSERT INTO `web_districts` VALUES ('761', 'Tiên Yên', '47', '1', '50');
INSERT INTO `web_districts` VALUES ('762', 'Ba Chẽ', '47', '1', '50');
INSERT INTO `web_districts` VALUES ('763', 'Đông Triều', '47', '1', '50');
INSERT INTO `web_districts` VALUES ('764', 'Yên Hưng', '47', '1', '50');
INSERT INTO `web_districts` VALUES ('765', 'Hoành Bồ', '47', '1', '50');
INSERT INTO `web_districts` VALUES ('766', 'Vân Đồn', '47', '1', '50');
INSERT INTO `web_districts` VALUES ('767', 'Cô Tô', '47', '1', '50');
INSERT INTO `web_districts` VALUES ('769', 'Vĩnh Yên', '60', '1', '50');
INSERT INTO `web_districts` VALUES ('770', 'Tam Dương', '60', '1', '50');
INSERT INTO `web_districts` VALUES ('771', 'Lập Thạch', '60', '1', '50');
INSERT INTO `web_districts` VALUES ('772', 'Vĩnh Tường', '60', '1', '50');
INSERT INTO `web_districts` VALUES ('773', 'Yên Lạc', '60', '1', '50');
INSERT INTO `web_districts` VALUES ('774', 'Bình Xuyên', '60', '1', '50');
INSERT INTO `web_districts` VALUES ('775', 'Sông Lô', '60', '1', '50');
INSERT INTO `web_districts` VALUES ('776', 'Phúc Yên', '60', '1', '50');
INSERT INTO `web_districts` VALUES ('777', 'Tam Đảo', '60', '1', '50');
INSERT INTO `web_districts` VALUES ('778', 'Thành phố Nha Trang', '68', '1', '50');
INSERT INTO `web_districts` VALUES ('779', 'Huyện Vạn Ninh', '68', '1', '50');
INSERT INTO `web_districts` VALUES ('780', 'Huyện Ninh Hoà', '68', '1', '50');
INSERT INTO `web_districts` VALUES ('781', 'Huyện Diên Khánh', '68', '1', '50');
INSERT INTO `web_districts` VALUES ('782', 'Huyện Khánh Vĩnh', '68', '1', '50');
INSERT INTO `web_districts` VALUES ('783', 'Thị xã Cam Ranh', '68', '1', '50');
INSERT INTO `web_districts` VALUES ('784', 'Huyện Khánh Sơn', '68', '1', '50');
INSERT INTO `web_districts` VALUES ('785', 'Huyện đảo Trường Sa', '68', '1', '50');
INSERT INTO `web_districts` VALUES ('786', 'Huyện Cam Lâm', '68', '1', '50');
INSERT INTO `web_districts` VALUES ('787', 'Hoàng Sa', '15', '1', '50');
INSERT INTO `web_districts` VALUES ('789', 'Ban Mê Thuột', '72', '1', '50');
INSERT INTO `web_districts` VALUES ('790', 'Lạc Thiện', '72', '1', '50');
INSERT INTO `web_districts` VALUES ('791', 'Đắk Song', '72', '1', '50');
INSERT INTO `web_districts` VALUES ('792', 'Buôn Hồ', '72', '1', '50');
INSERT INTO `web_districts` VALUES ('793', 'M&#39;Đrak', '72', '1', '50');
INSERT INTO `web_districts` VALUES ('794', 'Phường Vĩnh Hải', '68', '1', '50');
INSERT INTO `web_districts` VALUES ('795', 'Phường Vĩnh Phước', '68', '1', '50');
INSERT INTO `web_districts` VALUES ('796', 'Phường Vĩnh Thọ', '68', '1', '50');
INSERT INTO `web_districts` VALUES ('797', 'Phường Xương Huân', '68', '1', '50');
INSERT INTO `web_districts` VALUES ('798', 'Phường Vạn Thắng', '68', '1', '50');
INSERT INTO `web_districts` VALUES ('799', 'Phường Vạn Thạnh', '68', '1', '50');
INSERT INTO `web_districts` VALUES ('800', 'Phường Phương Sài', '68', '1', '50');
INSERT INTO `web_districts` VALUES ('801', 'Phường Phương Sơn', '68', '1', '50');
INSERT INTO `web_districts` VALUES ('802', 'Phường Ngọc Hiệp', '68', '1', '50');
INSERT INTO `web_districts` VALUES ('803', 'Phường Phước Hoà', '68', '1', '50');
INSERT INTO `web_districts` VALUES ('804', 'Phường Phước Tân', '68', '1', '50');
INSERT INTO `web_districts` VALUES ('805', 'Phường Phước Tiến', '68', '1', '50');
INSERT INTO `web_districts` VALUES ('806', 'Phường Phước Hải', '68', '1', '50');
INSERT INTO `web_districts` VALUES ('807', 'Phường Lộc Thọ', '68', '1', '50');
INSERT INTO `web_districts` VALUES ('808', 'Phường Tân Lập', '68', '1', '50');
INSERT INTO `web_districts` VALUES ('809', 'Phường Vĩnh Nguyên', '68', '1', '50');
INSERT INTO `web_districts` VALUES ('810', 'Phường Vĩnh Trường', '68', '1', '50');
INSERT INTO `web_districts` VALUES ('811', 'Phường Phước Long', '68', '1', '50');
INSERT INTO `web_districts` VALUES ('812', 'Phường Vĩnh Hoà', '68', '1', '50');
INSERT INTO `web_districts` VALUES ('813', 'Phường 1', '67', '1', '50');
INSERT INTO `web_districts` VALUES ('814', 'Phường 2', '67', '1', '50');
INSERT INTO `web_districts` VALUES ('815', 'Phường 3', '67', '1', '50');
INSERT INTO `web_districts` VALUES ('816', 'Phường 4', '67', '1', '50');
INSERT INTO `web_districts` VALUES ('817', 'Phường 5', '67', '1', '50');
INSERT INTO `web_districts` VALUES ('818', 'Phường 6', '67', '1', '50');
INSERT INTO `web_districts` VALUES ('819', 'Phường 7', '67', '1', '50');
INSERT INTO `web_districts` VALUES ('820', 'Phường 8', '67', '1', '50');
INSERT INTO `web_districts` VALUES ('821', 'Phường 9', '67', '1', '50');
INSERT INTO `web_districts` VALUES ('822', 'Phường 10', '67', '1', '50');
INSERT INTO `web_districts` VALUES ('823', 'Phường 11', '67', '1', '50');
INSERT INTO `web_districts` VALUES ('824', 'Phường 12', '67', '1', '50');
INSERT INTO `web_districts` VALUES ('827', 'Bắc Từ Liêm', '22', '1', '50');
INSERT INTO `web_districts` VALUES ('829', 'Bàu Bàng', '8', '1', '50');
INSERT INTO `web_districts` VALUES ('831', 'Bắc Tân Uyên', '8', '1', '50');
INSERT INTO `web_districts` VALUES ('833', 'Cư M&#39;gaR', '72', '1', '50');
INSERT INTO `web_districts` VALUES ('835', 'Cư Kuin', '72', '1', '50');
INSERT INTO `web_districts` VALUES ('837', 'Ea H&#39;leo', '72', '1', '50');
INSERT INTO `web_districts` VALUES ('839', 'Thạch Hóa', '37', '1', '50');
INSERT INTO `web_districts` VALUES ('841', 'Kiến Tường', '37', '1', '50');
INSERT INTO `web_districts` VALUES ('843', 'Thị xã Ba Đồn', '44', '1', '50');
INSERT INTO `web_districts` VALUES ('845', 'Thành phố Hà Giang', '20', '1', '50');
INSERT INTO `web_districts` VALUES ('847', 'Nậm Nhùm', '33', '1', '50');
INSERT INTO `web_districts` VALUES ('849', 'Huyện Cao Lãnh', '18', '1', '50');
INSERT INTO `web_districts` VALUES ('851', 'Thị xã Quảng Trị', '48', '1', '50');
INSERT INTO `web_districts` VALUES ('853', 'Thị xã Hoàng Mai', '39', '1', '50');
INSERT INTO `web_districts` VALUES ('855', 'Thị xã Quảng Yên', '47', '1', '50');
INSERT INTO `web_districts` VALUES ('857', 'Lâm Bình', '58', '1', '50');
INSERT INTO `web_districts` VALUES ('859', 'Huyện Kỳ Anh', '24', '1', '50');

-- ----------------------------
-- Table structure for web_hostting
-- ----------------------------
DROP TABLE IF EXISTS `web_hostting`;
CREATE TABLE `web_hostting` (
  `web_id` int(11) NOT NULL AUTO_INCREMENT,
  `web_name` varchar(255) DEFAULT NULL,
  `web_price` int(12) DEFAULT NULL,
  `web_infor` mediumtext COMMENT 'thông tin thêm của web',
  `web_time_start` int(12) DEFAULT NULL,
  `web_time_end` int(12) DEFAULT NULL,
  `web_status` tinyint(5) DEFAULT NULL,
  `web_is_return` tinyint(5) DEFAULT '0' COMMENT '0: làm mới, 1: là gia hạn',
  `web_is_hostting` tinyint(5) DEFAULT '1' COMMENT '0: dung hosting ngoài, 1: dùng hosting của minh',
  `web_note` mediumtext,
  `web_domain` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`web_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of web_hostting
-- ----------------------------
INSERT INTO `web_hostting` VALUES ('1', 'ádasd', '312312', 'a:7:{s:10:\"infor_name\";s:7:\"quỳnh\";s:11:\"infor_stand\";s:11:\"giám đôc\";s:11:\"infor_email\";s:15:\"quynh@gmail.com\";s:13:\"infor_address\";s:9:\"Hà nội\";s:18:\"infor_price_domain\";s:16:\"2.313.123.123 đ\";s:16:\"infor_price_host\";s:14:\"123.123.123 đ\";s:11:\"infor_phone\";s:10:\"0938413368\";}', '1485882000', '1486573199', '1', '0', '1', 'sada', 'ádasd');
INSERT INTO `web_hostting` VALUES ('2', 'truyền thông lào design', '5000000', 'a:7:{s:10:\"infor_name\";s:7:\"quỳnh\";s:11:\"infor_stand\";s:11:\"giám đôc\";s:11:\"infor_email\";s:15:\"quynh@gmail.com\";s:13:\"infor_address\";s:9:\"Hà nội\";s:15:\"infor_bank_code\";s:8:\"01234567\";s:18:\"infor_bank_address\";s:7:\"vp bank\";s:11:\"infor_phone\";s:10:\"0938413368\";}', '1485882000', '1488301199', '1', '0', '1', '', 'laostylead.com');

-- ----------------------------
-- Table structure for web_info
-- ----------------------------
DROP TABLE IF EXISTS `web_info`;
CREATE TABLE `web_info` (
  `info_id` int(11) NOT NULL AUTO_INCREMENT,
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
  `meta_description` text COMMENT 'Meta description',
  PRIMARY KEY (`info_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='Stores news content.';

-- ----------------------------
-- Records of web_info
-- ----------------------------
INSERT INTO `web_info` VALUES ('1', null, 'Thông tin chân trang bên trái', 'SITE_FOOTER_LEFT', '', '<p><strong>T&ecirc;n đăng k&yacute;: </strong>C&ocirc;ng ty Cổ truyền th&ocirc;ng raovat30s</p>\r\n\r\n<p><strong>T&ecirc;n giao dịch: </strong>Raovat30s Online JSC</p>\r\n\r\n<p><strong>Địa chỉ trụ sở: </strong>Tầng 2, T&ograve;a nh&agrave; CT2A - KĐT Nghĩa Đ&ocirc;, Ho&agrave;ng Quốc Việt, Cầu Giấy, H&agrave; Nội.</p>\r\n\r\n<p><strong>Điện thoại: </strong>0913.922.986</p>\r\n\r\n<p><strong>Email: </strong>raovat@raovat30s.vn</p>\r\n\r\n<p><strong>Giấy chứng nhận đăng k&yacute; kinh doanh số 0305056245 do Sở Kế hoạch v&agrave; Đầu tư Th&agrave;nh phố H&agrave; Nội cấp ng&agrave;y 22/12/2016</strong></p>\r\n', '1481877283-573cb4258e810763aa000001.jpg', '1447794727', '1', '1', '', '', '');

-- ----------------------------
-- Table structure for web_items
-- ----------------------------
DROP TABLE IF EXISTS `web_items`;
CREATE TABLE `web_items` (
  `item_id` int(11) NOT NULL AUTO_INCREMENT,
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
  `item_infor_contract` varchar(255) DEFAULT NULL COMMENT 'Liên hệ của tin đăng',
  `customer_id` int(11) DEFAULT '0' COMMENT 'id khách đăng tin',
  `customer_name` varchar(255) DEFAULT NULL COMMENT 'Tên khách đăng tin',
  `is_customer` tinyint(5) DEFAULT '0' COMMENT '0:tin thường, 1: tin vip',
  `time_ontop` int(11) DEFAULT '0' COMMENT 'thời gian để ontop tin',
  `time_created` int(11) DEFAULT '0',
  `time_update` int(11) DEFAULT '0',
  PRIMARY KEY (`item_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of web_items
-- ----------------------------
INSERT INTO `web_items` VALUES ('1', 'tin thứ 1', '1', '1', '3234324', '0', '<p>&aacute;dasdasd<br />\r\n&nbsp;</p>\r\n', '1480492436-1401002910598828940672831075709428n.jpg', 'a:1:{i:0;s:50:\"1480492436-1401002910598828940672831075709428n.jpg\";}', '253', 'Mua bán nhà đất', '100', '0', '0', '1', '0', '1', '22', null, '2', null, null, '1', 'Trương Mạnh Quỳnh', '1', '1480063979', '1480061746', '1480492477');
INSERT INTO `web_items` VALUES ('2', 'tin thứ 2', '1', '1', '250000', '0', '', '1480998156-573cb4258e810763aa000001.jpg', 'a:1:{i:0;s:39:\"1480998156-573cb4258e810763aa000001.jpg\";}', '254', 'Thuê nhà đất', '100', '0', '0', '1', '0', '1', '22', null, '2', null, null, '1', 'Trương Mạnh Quỳnh', '1', '1480063979', '1480063979', '1480998160');
INSERT INTO `web_items` VALUES ('3', 'tin thứ 3', '1', '1', '320000', '0', '', '1480998169-57355c1302b01f7898000001.jpg', 'a:1:{i:0;s:39:\"1480998169-57355c1302b01f7898000001.jpg\";}', '255', 'Ôtô', '100', '0', '0', '1', '0', '1', '22', null, '2', null, null, '1', 'Trương Mạnh Quỳnh', '1', '1480063979', '1480063979', '1480998171');
INSERT INTO `web_items` VALUES ('4', 'mỹ phẩm làm đẹp', '1', '1', '0', '0', '', '1480998189-957158d02c3c80.jpg', 'a:1:{i:0;s:29:\"1480998189-957158d02c3c80.jpg\";}', '254', 'Thuê nhà đất', '100', '0', '0', '1', '0', '1', '22', null, '2', null, null, '1', 'Trương Mạnh Quỳnh', '1', '0', '1480998189', '1480998200');
INSERT INTO `web_items` VALUES ('5', 'sdaasd', '1', '2', '0', '0', '<p>Tho&aacute;ng!</p>\r\n\r\n<p>Thu đ&atilde; qua rồi, em cũng xa,<br />\r\nChỉ c&oacute; m&ugrave;a đ&ocirc;ng bước v&agrave;o nh&agrave;,<br />\r\nVới ch&uacute;t nắng phai c&ograve;n ngơ ngẩn,<br />\r\nLạc lối l&agrave;m xanh ngắt l&ograve;ng tr&agrave;!</p>\r\n', '1480999210-c6cf7704ba9e447d51a3fc60ef8e66f9cropnorth.jpg', 'a:1:{i:0;s:56:\"1480999210-c6cf7704ba9e447d51a3fc60ef8e66f9cropnorth.jpg\";}', '254', 'Thuê nhà đất', '100', '0', '0', '1', '0', '1', '22', null, '2', null, null, '1', 'Trương Mạnh Quỳnh', '1', '1480999194', '1480999194', '1480999213');
INSERT INTO `web_items` VALUES ('6', 'làm đẹp', '1', '1', '0', '0', '<p>Tho&aacute;ng!</p>\r\n\r\n<p>Thu đ&atilde; qua rồi, em cũng xa,<br />\r\nChỉ c&oacute; m&ugrave;a đ&ocirc;ng bước v&agrave;o nh&agrave;,<br />\r\nVới ch&uacute;t nắng phai c&ograve;n ngơ ngẩn,<br />\r\nLạc lối l&agrave;m xanh ngắt l&ograve;ng tr&agrave;!<img alt=\"undefined\" src=\"http://localhost/goingay/uploads/thumbs/product/6/600x600/1480999231-9572042c1a3f27.jpg\" /></p>\r\n', '1480999231-9572042c1a3f27.jpg', 'a:1:{i:0;s:29:\"1480999231-9572042c1a3f27.jpg\";}', '255', 'Ôtô', '100', '0', '0', '1', '0', '1', '22', null, '2', null, null, '1', 'Trương Mạnh Quỳnh', '1', '1480999231', '1480999231', '1480999242');
INSERT INTO `web_items` VALUES ('7', 'tin đăng ko có ảnh', '1', '2', '0', '0', '<p>xem c&oacute; hiển thị ảnh ko</p>\r\n', '', null, '260', 'Điện tử - Kỹ thuật số', '100', '0', '0', '1', '0', '1', '15', 'Đà Nẵng', '2', null, 'sdfsdfsdf', '1', 'Trương Mạnh Quỳnh', '1', '1483438739', '1483438739', '1484107818');

-- ----------------------------
-- Table structure for web_news
-- ----------------------------
DROP TABLE IF EXISTS `web_news`;
CREATE TABLE `web_news` (
  `news_id` int(11) NOT NULL AUTO_INCREMENT,
  `news_title` varchar(255) DEFAULT NULL,
  `news_desc_sort` text,
  `news_content` text,
  `news_image` varchar(255) DEFAULT NULL COMMENT 'ảnh đại diện của bài viết',
  `news_image_other` varchar(255) DEFAULT NULL COMMENT 'Lưu ảnh của bài viết',
  `news_type` tinyint(5) DEFAULT '1' COMMENT 'Kiểu tin',
  `news_category` int(11) DEFAULT NULL,
  `news_status` tinyint(5) DEFAULT NULL,
  `news_create` int(11) DEFAULT NULL,
  PRIMARY KEY (`news_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of web_news
-- ----------------------------
INSERT INTO `web_news` VALUES ('1', 'tin tức hàng ngày', 'Hôm nay (5/12) sẽ là thời điểm điều chỉnh giá xăng dầu của chu kỳ mới. Theo dữ liệu giá thành phẩm trên thị trường Singapore được Bộ Công Thương công bố, bình quân giá xăng RON 92 ở mức 58 USD một thùng, tăng 5,4% so với chu kỳ trước (55 USD một thùng). Đáng chú ý, những ngày gần đây giá xăng tăng lên gần 60 USD một thùng.', '<p>H&ocirc;m nay (5/12) sẽ l&agrave; thời điểm điều chỉnh gi&aacute; xăng dầu của chu kỳ mới.&nbsp;Theo dữ liệu gi&aacute; th&agrave;nh phẩm tr&ecirc;n thị trường Singapore được Bộ C&ocirc;ng&nbsp;Thương c&ocirc;ng bố, b&igrave;nh qu&acirc;n gi&aacute; xăng RON 92 ở mức 58 USD một th&ugrave;ng, tăng 5,4% so với chu kỳ trước (55 USD một th&ugrave;ng). Đ&aacute;ng ch&uacute; &yacute;, những ng&agrave;y gần đ&acirc;y gi&aacute; xăng tăng l&ecirc;n gần 60 USD một th&ugrave;ng.</p>\r\n\r\n<p>Chia sẻ với <em>VnExpress</em>, nhiều doanh nghiệp đầu mối ở TP HCM cho biết, những ng&agrave;y qua gi&aacute; xăng thế giới lại tiếp tục tăng, do vậy tại chu kỳ điều chỉnh mới xăng sẽ đứng trước &aacute;p lực tăng gi&aacute; mạnh.</p>\r\n\r\n<table align=\"center\" border=\"0\" cellpadding=\"3\" cellspacing=\"0\" class=\"tplCaption\" style=\"width:100%\">\r\n	<tbody>\r\n		<tr>\r\n			<td><img alt=\"xang-co-the-tang-gia-manh-hom-nay\" src=\"http://img.f25.kinhdoanh.vnecdn.net/2016/12/04/xang-6751-1480822899.jpg\" /></td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p>Gi&aacute; xăng c&oacute; thể tăng mạnh ng&agrave;y mai theo gi&aacute; thế giới.&nbsp;</p>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n\r\n<p>L&atilde;nh đạo 2 doanh nghiệp đầu mối ở TP HCM cho biết, cơ quan quản l&yacute; c&oacute; thể kết hợp song song biện ph&aacute;p vừa sử dụng quỹ b&igrave;nh ổn vừa tăng gi&aacute;. Đối với trường hợp n&agrave;y, gi&aacute; xăng c&oacute; thể chỉ tăng quanh mức 200-400 đồng một l&iacute;t v&agrave; gi&aacute; dầu cũng được điều chỉnh tăng ở mức tương tự.</p>\r\n\r\n<p>&ldquo;B&ecirc;n cạnh đ&oacute;, nếu cơ quan quản l&yacute; kh&ocirc;ng sử dụng quỹ b&igrave;nh ổn th&igrave; gi&aacute; xăng c&oacute; thể tăng 500-600 đồng một l&iacute;t. Đ&acirc;y cũng l&agrave; kỳ điều chỉnh khiến gi&aacute; b&aacute;n lẻ c&oacute; thể quay về mốc của kỳ điều chỉnh đầu th&aacute;ng 11&rdquo;, l&atilde;nh đạo doanh nghiệp đầu mối ở Thủ Đức n&oacute;i.</p>\r\n\r\n<p>Tại kỳ điều chỉnh trước, gi&aacute; cơ sở mỗi l&iacute;t xăng RON 92 được y&ecirc;u cầu giảm 521 đồng, khiến gi&aacute; b&aacute;n lẻ kh&ocirc;ng được cao hơn 16.371 đồng. Xăng E5 giảm 355 đồng, xuống mức tối đa l&agrave; 16.221 đồng một l&iacute;t. Gi&aacute; dầu diesel cũng giảm 514 đồng, trong khi dầu hỏa v&agrave; mad&uacute;t lần lượt giảm 578 v&agrave; 373 đồng một l&iacute;t, kg.</p>\r\n\r\n<p>Từ đầu năm đến nay, mặt h&agrave;ng n&agrave;y trải qua 21 lần điều chỉnh, với 11 lần tăng v&agrave; 10 lần giảm.</p>\r\n', '1480910791-573cb4258e810763aa000001.jpg', 'a:1:{i:0;s:39:\"1480910791-573cb4258e810763aa000001.jpg\";}', '3', '7', '1', '1480910791');
INSERT INTO `web_news` VALUES ('2', 'dang test 333', 'Trong thời gian hồ thủy lợi Phú Ninh (Quảng Nam) xả lũ, nhiều người dùng lưới chắn phía trên cống đón cá mè chui vào lồng và bắt được 2-3 tấn/ngày.', '<p>Ng&agrave;y 23/11, với tr&ecirc;n 95% đại biểu t&aacute;n th&agrave;nh, Quốc hội đ&atilde; th&ocirc;ng qua Nghị quyết về chất vấn v&agrave; trả lời chất vấn tại kỳ họp thứ 2, Quốc hội kh&oacute;a 14.</p>\r\n\r\n<p>Theo đ&oacute;, Quốc hội ph&ecirc; ph&aacute;n nghi&ecirc;m khắc &ocirc;ng Vũ Huy Ho&agrave;ng, Bộ trưởng C&ocirc;ng Thương nhiệm kỳ 2011-2016, do đ&atilde; c&oacute; những vi phạm về c&ocirc;ng t&aacute;c c&aacute;n bộ trong thời gian đảm nhiệm chức vụ n&ecirc;u tr&ecirc;n, g&acirc;y hậu quả nghi&ecirc;m trọng, ảnh hưởng xấu đến uy t&iacute;n của Đảng, Nh&agrave; nước, Bộ C&ocirc;ng Thương, g&acirc;y bức x&uacute;c trong x&atilde; hội.</p>\r\n\r\n<p>Quốc hội giao Ủy ban Thường vụ Quốc hội, Ch&iacute;nh phủ, c&aacute;c cơ quan bảo vệ ph&aacute;p luật tiếp tục l&agrave;m r&otilde; v&agrave; xử l&yacute; theo quy định của ph&aacute;p luật những vi phạm của cựu Bộ trưởng Vũ Huy Ho&agrave;ng. Đồng thời, tăng cường c&ocirc;ng t&aacute;c gi&aacute;m s&aacute;t, quản l&yacute; c&aacute;n bộ; tạo cơ sở ph&aacute;p l&yacute; đồng bộ để xử l&yacute; c&ocirc;ng bằng v&agrave; nghi&ecirc;m minh c&aacute;c h&agrave;nh vi vi phạm của c&aacute;n bộ, c&ocirc;ng chức, vi&ecirc;n chức, kể cả khi đ&atilde; chuyển c&ocirc;ng t&aacute;c hoặc nghỉ hưu.</p>\r\n\r\n<table align=\"center\" border=\"0\" cellpadding=\"3\" cellspacing=\"0\" class=\"tplCaption\" style=\"width:100%\">\r\n	<tbody>\r\n		<tr>\r\n			<td><img alt=\"quoc-hoi-yeu-cau-lam-ro-vi-pham-cua-ong-vu-huy-hoang\" src=\"http://img.f29.vnecdn.net/2016/11/23/ky-thu-2-quoc-hoi-4930-1479103-5305-4580-1479869719.jpg\" /></td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n			<p>Quốc hội ph&ecirc; ph&aacute;n cựu Bộ trưởng C&ocirc;ng Thương Vũ Huy Ho&agrave;ng. Ảnh minh họa: <em>Giang Huy</em></p>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n\r\n<p>Quốc hội cũng y&ecirc;u cầu rà soát, đánh giá t&ocirc;̉ng th&ecirc;̉ về thực trạng, mức đ&ocirc;̣ thi&ecirc;̣t hại, khẩn trương xử lý dứt điểm đ&ocirc;́i với các dự án thua lỗ, kém hi&ecirc;̣u quả, kh&ocirc;ng đ&ecirc;̉ tiếp tục kéo dài g&acirc;y thi&ecirc;̣t hại cho Nhà nước. Đồng thời, xác định rõ trách nhi&ecirc;̣m v&agrave; xử l&yacute; nghi&ecirc;m đối với c&aacute;c cơ quan, tổ chức, c&aacute; nh&acirc;n có sai phạm trong qu&aacute; tr&igrave;nh đầu tư.</p>\r\n\r\n<p>Trước đ&oacute;, nhiều đại biểu đ&atilde; chất vấn Bộ trưởng C&ocirc;ng Thương Trần Tuấn Anh về 5 dự &aacute;n ngh&igrave;n tỷ thua lỗ, nguy cơ ph&aacute; sản, gồm: Nh&agrave; m&aacute;y sản xuất xơ sợi Đ&igrave;nh Vũ; nh&agrave; m&aacute;y Nhi&ecirc;n liệu sinh học Bio-Ethanol Dung Quất; nh&agrave; m&aacute;y gang th&eacute;p Th&aacute;i Nguy&ecirc;n giai đoạn 2; nh&agrave; m&aacute;y bột giấy Phương Nam, tỉnh Long An; nh&agrave; m&aacute;y Đạm Ninh B&igrave;nh.</p>\r\n\r\n<p>Trong lĩnh vực t&agrave;i nguy&ecirc;n m&ocirc;i trường, Quốc hội y&ecirc;u cầu gi&aacute;m s&aacute;t chặt chẽ c&aacute;c t&aacute;c nh&acirc;n g&acirc;y &ocirc; nhiễm m&ocirc;i trường của dự &aacute;n Formosa H&agrave; Tĩnh, theo d&otilde;i v&agrave; c&oacute; biện ph&aacute;p phục hồi m&ocirc;i trường biển, thực hiện c&oacute; hiệu quả c&ocirc;ng t&aacute;c bồi thường, sớm ổn định sản xuất v&agrave; đời sống của người d&acirc;n trong v&ugrave;ng bị thiệt hại ở c&aacute;c tỉnh miền Trung.</p>\r\n\r\n<p>&quot;Bảo đảm thực hiện đầy đủ c&aacute;c cam kết của chủ dự &aacute;n trước khi đi v&agrave;o sản xuất&quot;, Nghị quyết n&ecirc;u r&otilde;.</p>\r\n\r\n<p>Phi&ecirc;n chất vấn của kỳ họp thứ 2, Quốc hội kh&oacute;a 14 diễn ra trong 2,5 ng&agrave;y (từ 15 đến s&aacute;ng 17/11), với 4 Bộ trưởng: C&ocirc;ng Thương; T&agrave;i nguy&ecirc;n M&ocirc;i trường; Gi&aacute;o dục Đ&agrave;o tạo; Nội vụ v&agrave; Thủ tướng đ&atilde; đăng đ&agrave;n.</p>\r\n', '1480921480-57355c1302b01f7898000001.jpg', 'a:1:{i:0;s:39:\"1480921480-57355c1302b01f7898000001.jpg\";}', '3', '7', '1', '1480921480');

-- ----------------------------
-- Table structure for web_province
-- ----------------------------
DROP TABLE IF EXISTS `web_province`;
CREATE TABLE `web_province` (
  `province_id` int(11) NOT NULL AUTO_INCREMENT,
  `province_name` varchar(255) NOT NULL,
  `province_position` tinyint(4) NOT NULL,
  `province_status` varchar(20) NOT NULL,
  `province_area` tinyint(4) NOT NULL COMMENT 'Vùng miền của tỉnh thành',
  PRIMARY KEY (`province_id`),
  KEY `position` (`province_position`),
  KEY `status` (`province_status`)
) ENGINE=InnoDB AUTO_INCREMENT=71 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of web_province
-- ----------------------------
INSERT INTO `web_province` VALUES ('3', 'Bạc Liêu', '6', '1', '3');
INSERT INTO `web_province` VALUES ('4', 'Bắc Cạn', '7', '1', '1');
INSERT INTO `web_province` VALUES ('5', 'Bắc Giang', '6', '1', '1');
INSERT INTO `web_province` VALUES ('6', 'Bắc Ninh', '7', '1', '1');
INSERT INTO `web_province` VALUES ('7', 'Bến Tre', '8', '1', '3');
INSERT INTO `web_province` VALUES ('8', 'Bình Dương', '9', '1', '3');
INSERT INTO `web_province` VALUES ('9', 'Bình Định', '10', '1', '2');
INSERT INTO `web_province` VALUES ('10', 'Bình Phước', '11', '1', '2');
INSERT INTO `web_province` VALUES ('11', 'Bình Thuận', '12', '1', '2');
INSERT INTO `web_province` VALUES ('12', 'Cà Mau', '13', '1', '3');
INSERT INTO `web_province` VALUES ('13', 'Cao Bằng', '14', '1', '1');
INSERT INTO `web_province` VALUES ('14', 'Cần Thơ', '8', '1', '3');
INSERT INTO `web_province` VALUES ('15', 'Đà Nẵng', '3', '1', '2');
INSERT INTO `web_province` VALUES ('17', 'Đồng Nai', '18', '1', '3');
INSERT INTO `web_province` VALUES ('18', 'Đồng Tháp', '19', '1', '3');
INSERT INTO `web_province` VALUES ('19', 'Gia Lai', '20', '1', '2');
INSERT INTO `web_province` VALUES ('20', 'Hà Giang', '21', '1', '1');
INSERT INTO `web_province` VALUES ('21', 'Hà Nam', '22', '1', '1');
INSERT INTO `web_province` VALUES ('22', 'Hà Nội', '1', '1', '1');
INSERT INTO `web_province` VALUES ('23', 'Hà Tây', '24', '1', '1');
INSERT INTO `web_province` VALUES ('24', 'Hà Tĩnh', '25', '1', '2');
INSERT INTO `web_province` VALUES ('25', 'Hải Dương', '26', '1', '1');
INSERT INTO `web_province` VALUES ('26', 'Hải Phòng', '5', '1', '1');
INSERT INTO `web_province` VALUES ('27', 'Hòa Bình', '28', '1', '1');
INSERT INTO `web_province` VALUES ('28', 'Hưng Yên', '29', '1', '1');
INSERT INTO `web_province` VALUES ('29', 'TP Hồ Chí Minh', '2', '1', '3');
INSERT INTO `web_province` VALUES ('30', 'Khánh Hòa', '31', '1', '2');
INSERT INTO `web_province` VALUES ('31', 'Kiên Giang', '32', '1', '3');
INSERT INTO `web_province` VALUES ('32', 'Kon Tum', '33', '1', '2');
INSERT INTO `web_province` VALUES ('33', 'Lai Châu', '34', '1', '1');
INSERT INTO `web_province` VALUES ('34', 'Lạng Sơn', '35', '1', '1');
INSERT INTO `web_province` VALUES ('35', 'Lào Cai', '36', '1', '1');
INSERT INTO `web_province` VALUES ('36', 'Lâm Đồng', '37', '1', '2');
INSERT INTO `web_province` VALUES ('37', 'Long An', '38', '1', '3');
INSERT INTO `web_province` VALUES ('38', 'Nam Định', '39', '1', '1');
INSERT INTO `web_province` VALUES ('39', 'Nghệ An', '40', '1', '2');
INSERT INTO `web_province` VALUES ('40', 'Ninh Bình', '41', '1', '1');
INSERT INTO `web_province` VALUES ('41', 'Ninh Thuận', '42', '1', '2');
INSERT INTO `web_province` VALUES ('42', 'Phú Thọ', '43', '1', '1');
INSERT INTO `web_province` VALUES ('43', 'Phú Yên', '44', '1', '2');
INSERT INTO `web_province` VALUES ('44', 'Quảng Bình', '45', '1', '2');
INSERT INTO `web_province` VALUES ('45', 'Quảng Nam', '46', '1', '2');
INSERT INTO `web_province` VALUES ('46', 'Quảng Ngãi', '47', '1', '2');
INSERT INTO `web_province` VALUES ('47', 'Quảng Ninh', '7', '1', '1');
INSERT INTO `web_province` VALUES ('48', 'Quảng Trị', '49', '1', '2');
INSERT INTO `web_province` VALUES ('49', 'Sóc Trăng', '50', '1', '3');
INSERT INTO `web_province` VALUES ('50', 'Sơn La', '51', '1', '1');
INSERT INTO `web_province` VALUES ('51', 'Tây Ninh', '52', '1', '3');
INSERT INTO `web_province` VALUES ('52', 'Thái Bình', '53', '1', '1');
INSERT INTO `web_province` VALUES ('53', 'Thái Nguyên', '54', '1', '1');
INSERT INTO `web_province` VALUES ('54', 'Thanh Hóa', '55', '1', '1');
INSERT INTO `web_province` VALUES ('55', 'Thừa Thiên Huế', '56', '1', '2');
INSERT INTO `web_province` VALUES ('56', 'Tiền Giang', '57', '1', '3');
INSERT INTO `web_province` VALUES ('57', 'Trà Vinh', '58', '1', '3');
INSERT INTO `web_province` VALUES ('58', 'Tuyên Quang', '59', '1', '1');
INSERT INTO `web_province` VALUES ('59', 'Vĩnh Long', '60', '1', '3');
INSERT INTO `web_province` VALUES ('60', 'Vĩnh Phúc', '61', '1', '1');
INSERT INTO `web_province` VALUES ('61', 'Yên Bái', '62', '1', '1');
INSERT INTO `web_province` VALUES ('66', 'An giang', '62', '1', '3');
INSERT INTO `web_province` VALUES ('67', 'Vũng Tàu', '6', '1', '3');
INSERT INTO `web_province` VALUES ('68', 'Nha Trang', '4', '1', '0');
INSERT INTO `web_province` VALUES ('69', 'Điện Biên', '0', '0', '0');
INSERT INTO `web_province` VALUES ('70', 'Hậu Giang', '15', '1', '0');

-- ----------------------------
-- Table structure for web_trash
-- ----------------------------
DROP TABLE IF EXISTS `web_trash`;
CREATE TABLE `web_trash` (
  `trash_id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL,
  `trash_obj_id` int(11) DEFAULT NULL,
  `trash_title` varchar(255) DEFAULT NULL,
  `trash_class` varchar(255) DEFAULT NULL,
  `trash_content` longtext,
  `trash_image` longtext,
  `trash_image_other` longtext,
  `trash_folder` varchar(255) DEFAULT NULL,
  `trash_created` int(12) DEFAULT NULL,
  PRIMARY KEY (`trash_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of web_trash
-- ----------------------------
INSERT INTO `web_trash` VALUES ('1', null, '4', 'Thông tin liên hệ', 'Info', 'a:12:{s:7:\"info_id\";i:4;s:10:\"info_title\";s:21:\"Thông tin liên hệ\";s:12:\"info_keyword\";s:12:\"SITE_CONTACT\";s:10:\"info_intro\";N;s:12:\"info_content\";s:557:\"<p>X&atilde; hội ng&agrave;y c&agrave;ng ph&aacute;t triển, cuộc sống ng&agrave;y c&agrave;ng được n&acirc;ng cao, v&agrave; những nhu cầu tiện nghi cho cuộc sống con người cũng v&igrave; thế m&agrave; n&acirc;ng l&ecirc;n, k&egrave;m theo đ&oacute; l&agrave; những th&uacute; vui sưu tầm v&agrave; sở hữu những sản phẩm phục vụ cho cuộc sống ng&agrave;y c&agrave;ng lớn. SanPhamReDep.COM l&agrave; nơi cung cấp v&agrave; phục vụ tốt nhất về c&aacute;c loại sản phẩm n&agrave;y.</p>\r\n\";s:8:\"info_img\";N;s:12:\"info_created\";s:10:\"1441430633\";s:13:\"info_order_no\";i:1;s:11:\"info_status\";i:1;s:10:\"meta_title\";s:21:\"Thông tin liên hệ\";s:13:\"meta_keywords\";s:21:\"Thông tin liên hệ\";s:16:\"meta_description\";s:21:\"Thông tin liên hệ\";}', '', 'a:0:{}', '', '1478450941');
