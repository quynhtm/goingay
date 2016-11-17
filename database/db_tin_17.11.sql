/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : db_tin

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2016-11-17 14:35:59
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
INSERT INTO `group_user` VALUES ('2', 'Xem chung', '1', '1');

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
INSERT INTO `group_user_permission` VALUES ('4', '1');
INSERT INTO `group_user_permission` VALUES ('4', '2');
INSERT INTO `group_user_permission` VALUES ('4', '3');
INSERT INTO `group_user_permission` VALUES ('4', '4');
INSERT INTO `group_user_permission` VALUES ('4', '8');
INSERT INTO `group_user_permission` VALUES ('4', '9');
INSERT INTO `group_user_permission` VALUES ('4', '10');
INSERT INTO `group_user_permission` VALUES ('4', '11');
INSERT INTO `group_user_permission` VALUES ('4', '12');
INSERT INTO `group_user_permission` VALUES ('4', '13');
INSERT INTO `group_user_permission` VALUES ('4', '32');
INSERT INTO `group_user_permission` VALUES ('4', '33');
INSERT INTO `group_user_permission` VALUES ('4', '14');
INSERT INTO `group_user_permission` VALUES ('4', '15');
INSERT INTO `group_user_permission` VALUES ('4', '16');
INSERT INTO `group_user_permission` VALUES ('4', '17');
INSERT INTO `group_user_permission` VALUES ('4', '18');
INSERT INTO `group_user_permission` VALUES ('4', '19');
INSERT INTO `group_user_permission` VALUES ('4', '20');
INSERT INTO `group_user_permission` VALUES ('4', '26');
INSERT INTO `group_user_permission` VALUES ('4', '27');
INSERT INTO `group_user_permission` VALUES ('4', '34');
INSERT INTO `group_user_permission` VALUES ('4', '35');
INSERT INTO `group_user_permission` VALUES ('4', '36');
INSERT INTO `group_user_permission` VALUES ('4', '37');
INSERT INTO `group_user_permission` VALUES ('4', '38');
INSERT INTO `group_user_permission` VALUES ('4', '40');
INSERT INTO `group_user_permission` VALUES ('3', '8');
INSERT INTO `group_user_permission` VALUES ('3', '9');
INSERT INTO `group_user_permission` VALUES ('3', '10');
INSERT INTO `group_user_permission` VALUES ('3', '11');
INSERT INTO `group_user_permission` VALUES ('3', '12');
INSERT INTO `group_user_permission` VALUES ('3', '13');
INSERT INTO `group_user_permission` VALUES ('3', '32');
INSERT INTO `group_user_permission` VALUES ('3', '33');
INSERT INTO `group_user_permission` VALUES ('3', '51');
INSERT INTO `group_user_permission` VALUES ('3', '14');
INSERT INTO `group_user_permission` VALUES ('3', '15');
INSERT INTO `group_user_permission` VALUES ('3', '16');
INSERT INTO `group_user_permission` VALUES ('3', '17');
INSERT INTO `group_user_permission` VALUES ('3', '18');
INSERT INTO `group_user_permission` VALUES ('3', '19');
INSERT INTO `group_user_permission` VALUES ('3', '20');
INSERT INTO `group_user_permission` VALUES ('3', '21');
INSERT INTO `group_user_permission` VALUES ('3', '22');
INSERT INTO `group_user_permission` VALUES ('3', '30');
INSERT INTO `group_user_permission` VALUES ('3', '23');
INSERT INTO `group_user_permission` VALUES ('3', '24');
INSERT INTO `group_user_permission` VALUES ('3', '25');
INSERT INTO `group_user_permission` VALUES ('3', '45');
INSERT INTO `group_user_permission` VALUES ('3', '26');
INSERT INTO `group_user_permission` VALUES ('3', '27');
INSERT INTO `group_user_permission` VALUES ('3', '28');
INSERT INTO `group_user_permission` VALUES ('3', '34');
INSERT INTO `group_user_permission` VALUES ('3', '35');
INSERT INTO `group_user_permission` VALUES ('3', '36');
INSERT INTO `group_user_permission` VALUES ('3', '37');
INSERT INTO `group_user_permission` VALUES ('3', '38');
INSERT INTO `group_user_permission` VALUES ('3', '40');
INSERT INTO `group_user_permission` VALUES ('3', '42');
INSERT INTO `group_user_permission` VALUES ('3', '43');
INSERT INTO `group_user_permission` VALUES ('3', '44');
INSERT INTO `group_user_permission` VALUES ('3', '46');
INSERT INTO `group_user_permission` VALUES ('3', '47');
INSERT INTO `group_user_permission` VALUES ('3', '48');
INSERT INTO `group_user_permission` VALUES ('3', '49');
INSERT INTO `group_user_permission` VALUES ('3', '50');
INSERT INTO `group_user_permission` VALUES ('5', '1');
INSERT INTO `group_user_permission` VALUES ('5', '2');
INSERT INTO `group_user_permission` VALUES ('5', '3');
INSERT INTO `group_user_permission` VALUES ('5', '4');
INSERT INTO `group_user_permission` VALUES ('5', '41');
INSERT INTO `group_user_permission` VALUES ('5', '5');
INSERT INTO `group_user_permission` VALUES ('5', '8');
INSERT INTO `group_user_permission` VALUES ('5', '9');
INSERT INTO `group_user_permission` VALUES ('5', '10');
INSERT INTO `group_user_permission` VALUES ('5', '11');
INSERT INTO `group_user_permission` VALUES ('5', '12');
INSERT INTO `group_user_permission` VALUES ('5', '13');
INSERT INTO `group_user_permission` VALUES ('5', '32');
INSERT INTO `group_user_permission` VALUES ('5', '33');
INSERT INTO `group_user_permission` VALUES ('5', '51');
INSERT INTO `group_user_permission` VALUES ('5', '14');
INSERT INTO `group_user_permission` VALUES ('5', '15');
INSERT INTO `group_user_permission` VALUES ('5', '16');
INSERT INTO `group_user_permission` VALUES ('5', '17');
INSERT INTO `group_user_permission` VALUES ('5', '18');
INSERT INTO `group_user_permission` VALUES ('5', '19');
INSERT INTO `group_user_permission` VALUES ('5', '20');
INSERT INTO `group_user_permission` VALUES ('5', '21');
INSERT INTO `group_user_permission` VALUES ('5', '26');
INSERT INTO `group_user_permission` VALUES ('5', '27');
INSERT INTO `group_user_permission` VALUES ('5', '28');
INSERT INTO `group_user_permission` VALUES ('5', '34');
INSERT INTO `group_user_permission` VALUES ('5', '35');
INSERT INTO `group_user_permission` VALUES ('5', '37');
INSERT INTO `group_user_permission` VALUES ('5', '38');
INSERT INTO `group_user_permission` VALUES ('5', '40');
INSERT INTO `group_user_permission` VALUES ('5', '42');
INSERT INTO `group_user_permission` VALUES ('2', '8');
INSERT INTO `group_user_permission` VALUES ('2', '11');
INSERT INTO `group_user_permission` VALUES ('2', '14');
INSERT INTO `group_user_permission` VALUES ('2', '17');
INSERT INTO `group_user_permission` VALUES ('2', '26');
INSERT INTO `group_user_permission` VALUES ('2', '34');
INSERT INTO `group_user_permission` VALUES ('2', '42');
INSERT INTO `group_user_permission` VALUES ('2', '46');
INSERT INTO `group_user_permission` VALUES ('2', '49');
INSERT INTO `group_user_permission` VALUES ('2', '50');
INSERT INTO `group_user_permission` VALUES ('1', '1');
INSERT INTO `group_user_permission` VALUES ('1', '2');
INSERT INTO `group_user_permission` VALUES ('1', '3');
INSERT INTO `group_user_permission` VALUES ('1', '4');
INSERT INTO `group_user_permission` VALUES ('1', '41');
INSERT INTO `group_user_permission` VALUES ('1', '5');
INSERT INTO `group_user_permission` VALUES ('1', '6');
INSERT INTO `group_user_permission` VALUES ('1', '7');
INSERT INTO `group_user_permission` VALUES ('1', '19');

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
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of permission
-- ----------------------------
INSERT INTO `permission` VALUES ('1', 'root', 'Quyền root', '1', 'Root');
INSERT INTO `permission` VALUES ('2', 'user_create', 'Tạo tài khoản', '1', 'Tài khoản');
INSERT INTO `permission` VALUES ('3', 'user_edit', 'Sửa tài khoản', '1', 'Tài khoản');
INSERT INTO `permission` VALUES ('4', 'user_change_pass', 'Đổi mật khẩu', '1', 'Tài khoản');
INSERT INTO `permission` VALUES ('5', 'group_user_view', 'Xem danh sách nhóm quyền', '1', 'Nhóm quyền');
INSERT INTO `permission` VALUES ('6', 'group_user_create', 'Tạo nhóm quyền', '1', 'Nhóm quyền');
INSERT INTO `permission` VALUES ('7', 'group_user_edit', 'Sửa thông tin nhóm quyền', '1', 'Nhóm quyền');
INSERT INTO `permission` VALUES ('8', 'categories_view', 'Xem danh mục', '1', 'Danh mục sản phẩm');
INSERT INTO `permission` VALUES ('9', 'categories_create', 'Tạo danh mục', '1', 'Danh mục sản phẩm');
INSERT INTO `permission` VALUES ('10', 'categories_edit', 'Sửa danh mục', '1', 'Danh mục sản phẩm');
INSERT INTO `permission` VALUES ('11', 'customers_view', 'Xem danh sách khách hàng', '1', 'Khách hàng');
INSERT INTO `permission` VALUES ('12', 'customers_create', 'Thêm mới khách hàng', '1', 'Khách hàng');
INSERT INTO `permission` VALUES ('13', 'customers_edit', 'Sửa thông tin khách hàng', '1', 'Khách hàng');
INSERT INTO `permission` VALUES ('14', 'personnel_view', 'Xem dach sách nhân viên', '1', 'Nhân viên');
INSERT INTO `permission` VALUES ('15', 'personnel_create', 'Thêm nhân viên', '1', 'Nhân viên');
INSERT INTO `permission` VALUES ('16', 'personnel_edit', 'Sửa thông tin nhân viên', '1', 'Nhân viên');
INSERT INTO `permission` VALUES ('17', 'product_view', 'Xem thông tin sản phẩm', '1', 'Sản phẩm');
INSERT INTO `permission` VALUES ('18', 'product_create', 'Tạo sản phẩm', '1', 'Sản phẩm');
INSERT INTO `permission` VALUES ('19', 'product_edit', 'Sửa sản phẩm', '1', 'Sản phẩm');
INSERT INTO `permission` VALUES ('20', 'providers_view', 'Xem danh sách ncc', '1', 'Nhà cung cấp');
INSERT INTO `permission` VALUES ('21', 'providers_create', 'Thêm nhà cung cấp', '1', 'Nhà cung cấp');
INSERT INTO `permission` VALUES ('22', 'providers_edit', 'Sửa thông tin ncc', '1', 'Nhà cung cấp');
INSERT INTO `permission` VALUES ('23', 'import_view', 'Xem phiếu nhập', '1', 'Nhập kho');
INSERT INTO `permission` VALUES ('24', 'import_create', 'Lập phiếu nhập', '1', 'Nhập kho');
INSERT INTO `permission` VALUES ('25', 'import_edit', 'Hủy phiếu nhập', '1', 'Nhập kho');
INSERT INTO `permission` VALUES ('26', 'export_view', 'Xem phiếu xuất', '1', 'Xuất kho');
INSERT INTO `permission` VALUES ('27', 'export_create', 'Lập phiếu xuất', '1', 'Xuất kho');
INSERT INTO `permission` VALUES ('28', 'export_edit', 'Hủy phiếu xuất', '1', 'Xuất kho');
INSERT INTO `permission` VALUES ('29', 'categories_delete', 'Xóa danh mục', '1', 'Danh mục sản phẩm');
INSERT INTO `permission` VALUES ('30', 'providers_delete', 'Xóa nhà cung cấp', '1', 'Nhà cung cấp');
INSERT INTO `permission` VALUES ('31', 'product_delete', 'Xóa sản phẩm', '1', 'Sản phẩm');
INSERT INTO `permission` VALUES ('32', 'discountCustomer_view', 'Xem chiết khấu cho khách', '1', 'Khách hàng');
INSERT INTO `permission` VALUES ('33', 'discountCustomer_edit', 'Cập nhật chiết khấu cho khách', '1', 'Khách hàng');
INSERT INTO `permission` VALUES ('34', 'report_customer', 'Thống kê khách mua hàng', '1', 'Thống kê');
INSERT INTO `permission` VALUES ('35', 'report_product_hot', 'Thống kê hàng bán chạy', '1', 'Thống kê');
INSERT INTO `permission` VALUES ('36', 'report_import', 'Thống kê nhập hàng', '1', 'Thống kê');
INSERT INTO `permission` VALUES ('37', 'report_export', 'Thống kê xuất', '1', 'Thống kê');
INSERT INTO `permission` VALUES ('38', 'report_discount', 'Thống kê chiết khấu', '1', 'Thống kê');
INSERT INTO `permission` VALUES ('39', 'report_sale_list', 'Bảng kê bán hàng', '-1', 'Thống kê');
INSERT INTO `permission` VALUES ('40', 'report_store', 'Thống kê tồn', '1', 'Thống kê');
INSERT INTO `permission` VALUES ('41', 'user_remove', 'Xóa tài khoản', '1', 'Tài khoản');
INSERT INTO `permission` VALUES ('42', 'ticket_view', 'Xem phiếu thu chi', '1', 'Phiếu thu chi');
INSERT INTO `permission` VALUES ('43', 'ticket_edit', 'Sửa phiếu thu chi', '1', 'Phiếu thu chi');
INSERT INTO `permission` VALUES ('44', 'ticket_create', 'Tạo phiếu thu chi', '1', 'Phiếu thu chi');
INSERT INTO `permission` VALUES ('45', 'import_update_payment', 'Cập nhật thanh toán', '1', 'Nhập kho');
INSERT INTO `permission` VALUES ('46', 'sale_list_view', 'Xem bảng kê', '1', 'Bảng kê');
INSERT INTO `permission` VALUES ('47', 'sale_list_create', 'Tạo bảng kê', '1', 'Bảng kê');
INSERT INTO `permission` VALUES ('48', 'sale_list_update_payment', 'Cập nhật thanh toán', '1', 'Bảng kê');
INSERT INTO `permission` VALUES ('49', 'liaCustomer_view', 'Xem công nợ khách hàng', '1', 'Công nợ');
INSERT INTO `permission` VALUES ('50', 'liaProvider_view', 'Xem công nợ ncc', '1', 'Công nợ');
INSERT INTO `permission` VALUES ('51', 'customer_price_list', 'Lập báo giá', '1', 'Khách hàng');

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
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES ('2', 'admin', 'eef828faf0754495136af05c051766cb', 'Root', '', null, '1', '1', '1479267098', '::1', null, null, null, null, null, null);
INSERT INTO `user` VALUES ('19', 'tech_code', 'eef828faf0754495136af05c051766cb', 'Tech code 3555', '', '', '1', '2', '1464324115', '::1', null, null, '2', 'admin', null, '1470042647');

-- ----------------------------
-- Table structure for web_banner
-- ----------------------------
DROP TABLE IF EXISTS `web_banner`;
CREATE TABLE `web_banner` (
  `banner_id` int(11) NOT NULL AUTO_INCREMENT,
  `banner_name` varchar(255) DEFAULT NULL,
  `banner_image` varchar(255) DEFAULT NULL,
  `banner_link` varchar(255) DEFAULT NULL,
  `banner_order` tinyint(5) DEFAULT '1' COMMENT 'thứ tự hiển thị',
  `banner_total_click` int(11) DEFAULT '0' COMMENT 'lượt click banner theo id',
  `banner_time_click` int(11) DEFAULT '0' COMMENT 'Time click gần nhất',
  `banner_is_target` tinyint(5) DEFAULT '0' COMMENT '0: Không mở tab mới, 1: mở tab mới',
  `banner_is_rel` tinyint(5) DEFAULT '0' COMMENT '0:nofollow, 1:follow',
  `banner_type` tinyint(5) DEFAULT '0' COMMENT '1:banner home to, 2: banner home nhỏ,3: banner trái, 4 banner phải',
  `banner_page` tinyint(5) DEFAULT '0' COMMENT '1: trang chủ, 2: trang list,3: trang detail, 4: trang list danh mục',
  `banner_category_id` int(11) DEFAULT '0',
  `banner_status` tinyint(5) DEFAULT '0',
  `banner_is_run_time` tinyint(5) DEFAULT '0' COMMENT '0: không có time chay,1: có thời gian chạy quảng cáo',
  `banner_start_time` int(11) DEFAULT '0',
  `banner_end_time` int(11) DEFAULT '0',
  `banner_is_shop` tinyint(5) DEFAULT '0' COMMENT '0: Không phải banner shop,1: quảng cáo banner của shop',
  `banner_shop_id` int(11) DEFAULT '0',
  `banner_create_time` int(11) DEFAULT '0',
  `banner_update_time` int(11) DEFAULT '0',
  PRIMARY KEY (`banner_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of web_banner
-- ----------------------------
INSERT INTO `web_banner` VALUES ('3', 'sdfsdf', '1478768319-957158d02c3c80.jpg', 'sdfsdf', '0', '0', '0', '1', '0', '-1', '-1', '0', '1', '0', '0', '0', '0', '0', '1478768319', '0');

-- ----------------------------
-- Table structure for web_category
-- ----------------------------
DROP TABLE IF EXISTS `web_category`;
CREATE TABLE `web_category` (
  `category_id` smallint(5) NOT NULL AUTO_INCREMENT,
  `category_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `category_parent_id` smallint(5) unsigned NOT NULL DEFAULT '0',
  `category_content_front` tinyint(2) DEFAULT '0',
  `category_content_front_order` tinyint(5) DEFAULT '0' COMMENT 'vị trí hiển thị ngoài trang chủ',
  `category_status` tinyint(1) NOT NULL DEFAULT '0',
  `category_image_background` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `category_icons` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `category_order` tinyint(5) NOT NULL DEFAULT '0',
  PRIMARY KEY (`category_id`),
  KEY `status` (`category_status`) USING BTREE,
  KEY `id_parrent` (`category_parent_id`,`category_status`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=253 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of web_category
-- ----------------------------
INSERT INTO `web_category` VALUES ('5', 'Phụ kiện công nghệ', '43', '0', '0', '1', null, null, '0');
INSERT INTO `web_category` VALUES ('26', 'test danhmuc', '21', '0', '0', '0', null, null, '0');
INSERT INTO `web_category` VALUES ('27', 'Đồ điện gia dụng', '86', '0', '0', '1', null, null, '0');
INSERT INTO `web_category` VALUES ('41', 'Mẹ và bé', '0', '1', '4', '1', null, null, '4');
INSERT INTO `web_category` VALUES ('42', 'Điện máy', '43', '0', '0', '1', null, null, '0');
INSERT INTO `web_category` VALUES ('43', 'Điện tử công nghệ', '0', '1', '3', '1', null, null, '3');
INSERT INTO `web_category` VALUES ('44', 'Điện thoại', '43', '0', '0', '1', null, null, '0');
INSERT INTO `web_category` VALUES ('50', 'Điện lạnh', '86', '0', '0', '1', null, null, '0');
INSERT INTO `web_category` VALUES ('53', 'Đồ dùng cho mẹ', '41', '1', '0', '1', null, null, '11');
INSERT INTO `web_category` VALUES ('56', 'Dinh dưỡng cho mẹ', '41', '1', '0', '1', null, null, '10');
INSERT INTO `web_category` VALUES ('81', 'Tivi, Video & Âm thanh', '43', '0', '0', '1', null, null, '0');
INSERT INTO `web_category` VALUES ('86', 'Đồ gia dụng & Nội thất', '0', '0', '6', '1', null, null, '6');
INSERT INTO `web_category` VALUES ('89', 'Nội thất phòng tắm', '86', '0', '0', '1', null, null, '0');
INSERT INTO `web_category` VALUES ('90', 'Thực phẩm', '0', '1', '5', '1', null, null, '0');
INSERT INTO `web_category` VALUES ('91', 'Thực phẩm chế biến sẵn', '90', '1', '0', '1', null, null, '5');
INSERT INTO `web_category` VALUES ('92', 'Vật dụng nhà bếp', '86', '0', '0', '1', null, null, '0');
INSERT INTO `web_category` VALUES ('93', 'Thực phẩm khô', '90', '1', '0', '1', null, null, '4');
INSERT INTO `web_category` VALUES ('94', 'Thực phẩm tươi sống', '90', '1', '0', '1', null, null, '2');
INSERT INTO `web_category` VALUES ('95', 'Rau - Củ - Quả', '90', '1', '0', '1', null, null, '1');
INSERT INTO `web_category` VALUES ('97', 'Thời trang', '0', '1', '2', '1', null, null, '0');
INSERT INTO `web_category` VALUES ('98', 'Áo sơmi nam', '97', '1', '0', '1', null, null, '2');
INSERT INTO `web_category` VALUES ('99', 'Áo khoác, Vest nam', '97', '1', '0', '1', null, null, '3');
INSERT INTO `web_category` VALUES ('102', 'Quần và Áo phông nam', '97', '0', '0', '1', null, null, '4');
INSERT INTO `web_category` VALUES ('103', 'Đồ lót, Đồ bơi nam', '97', '1', '0', '1', null, null, '5');
INSERT INTO `web_category` VALUES ('104', 'Đồ thể thao, mặc nhà nam', '97', '1', '0', '1', null, null, '6');
INSERT INTO `web_category` VALUES ('105', 'Quần áo - đồ sơ sinh', '41', '1', '0', '1', null, null, '9');
INSERT INTO `web_category` VALUES ('106', 'Đầm, váy Nữ', '97', '1', '0', '1', null, null, '11');
INSERT INTO `web_category` VALUES ('107', 'Áo sơ mi nữ', '97', '1', '0', '1', null, null, '7');
INSERT INTO `web_category` VALUES ('108', 'Áo Khoác và Vest Nữ', '97', '1', '0', '1', null, null, '8');
INSERT INTO `web_category` VALUES ('110', 'Đồ lót, đồ bơi nữ', '97', '1', '0', '1', null, null, '9');
INSERT INTO `web_category` VALUES ('111', 'Đồ thể thao, mặc nhà nữ', '97', '1', '0', '1', null, null, '10');
INSERT INTO `web_category` VALUES ('113', 'Quần & chân váy nữ', '97', '1', '0', '1', null, null, '12');
INSERT INTO `web_category` VALUES ('115', 'Phụ kiện thời trang Nữ', '97', '1', '0', '1', null, null, '14');
INSERT INTO `web_category` VALUES ('116', 'Phụ kiện thời trang trẻ em', '97', '1', '0', '1', null, null, '15');
INSERT INTO `web_category` VALUES ('119', 'Phụ kiện thời trang Nam', '97', '1', '0', '1', null, null, '13');
INSERT INTO `web_category` VALUES ('122', 'Giày dép, túi xách trẻ em', '97', '1', '0', '1', null, null, '18');
INSERT INTO `web_category` VALUES ('127', 'Giày dép, túi xách Nữ', '97', '1', '0', '1', null, null, '17');
INSERT INTO `web_category` VALUES ('134', 'Thời trang bé trai', '133', '0', '0', '0', null, null, '0');
INSERT INTO `web_category` VALUES ('135', 'Thời trang bé gái', '133', '0', '0', '0', null, null, '0');
INSERT INTO `web_category` VALUES ('139', 'Giày dép, túi sách Nam', '97', '1', '0', '1', null, null, '16');
INSERT INTO `web_category` VALUES ('140', 'Máy tính, laptop', '43', '0', '0', '1', null, null, '0');
INSERT INTO `web_category` VALUES ('141', 'Máy tính bảng', '43', '0', '0', '1', null, null, '0');
INSERT INTO `web_category` VALUES ('143', 'Máy in', '43', '0', '0', '1', null, null, '0');
INSERT INTO `web_category` VALUES ('144', 'Màn hình', '43', '0', '0', '1', null, null, '0');
INSERT INTO `web_category` VALUES ('145', 'Máy ảnh - Máy quay', '43', '0', '0', '1', null, null, '0');
INSERT INTO `web_category` VALUES ('146', 'Mỹ phẩm nam', '96', '0', '0', '0', null, null, '0');
INSERT INTO `web_category` VALUES ('147', 'Thiết bị an ninh', '43', '0', '0', '1', null, null, '0');
INSERT INTO `web_category` VALUES ('148', 'Tivi - Âm thanh - Thiết bị Số', '43', '0', '0', '1', null, null, '0');
INSERT INTO `web_category` VALUES ('151', 'Xe máy và phụ kiện', '207', '0', '0', '1', null, null, '2');
INSERT INTO `web_category` VALUES ('153', 'Dụng cụ nhà bếp', '86', '0', '0', '1', null, null, '0');
INSERT INTO `web_category` VALUES ('154', 'Đồ điện gia dụng', '86', '0', '0', '1', null, null, '0');
INSERT INTO `web_category` VALUES ('155', 'Sản phẩm tiện ích', '86', '0', '0', '1', null, null, '0');
INSERT INTO `web_category` VALUES ('156', 'Dây - cáp điện', '86', '0', '0', '1', null, null, '0');
INSERT INTO `web_category` VALUES ('157', 'Nội thất và trang trí nhà ở', '86', '0', '0', '1', null, null, '0');
INSERT INTO `web_category` VALUES ('164', 'Mỹ phẩm - làm đẹp', '0', '1', '1', '1', null, null, '0');
INSERT INTO `web_category` VALUES ('165', 'Trang điểm - phụ kiện', '164', '1', '0', '1', null, null, '2');
INSERT INTO `web_category` VALUES ('166', 'Chăm sóc cơ thể', '164', '1', '0', '1', null, null, '6');
INSERT INTO `web_category` VALUES ('167', 'Chăm sóc tóc', '164', '0', '0', '1', null, null, '5');
INSERT INTO `web_category` VALUES ('168', 'Chăm sóc mặt', '164', '1', '0', '1', null, null, '4');
INSERT INTO `web_category` VALUES ('170', 'Bé học và chơi', '41', '1', '0', '1', null, null, '7');
INSERT INTO `web_category` VALUES ('171', 'Giường - nôi - xe cho bé', '41', '1', '0', '1', null, null, '6');
INSERT INTO `web_category` VALUES ('172', 'Đồ dùng chăm sóc bé', '41', '1', '0', '1', null, null, '5');
INSERT INTO `web_category` VALUES ('173', 'Dinh dưỡng cho bé', '41', '1', '0', '1', null, null, '4');
INSERT INTO `web_category` VALUES ('174', 'Sữa & Bột', '41', '1', '0', '1', null, null, '3');
INSERT INTO `web_category` VALUES ('175', 'Tã bỉm', '41', '1', '0', '1', null, null, '2');
INSERT INTO `web_category` VALUES ('176', 'Thiết bị, phụ kiện làm đẹp', '164', '1', '0', '1', null, null, '17');
INSERT INTO `web_category` VALUES ('177', 'Chăm sóc cho mẹ', '41', '1', '0', '1', null, null, '13');
INSERT INTO `web_category` VALUES ('178', 'Y tế cho mẹ & bé', '41', '1', '0', '1', null, null, '12');
INSERT INTO `web_category` VALUES ('179', 'Thời trang bầu - sau sinh', '41', '1', '0', '1', null, null, '12');
INSERT INTO `web_category` VALUES ('180', 'Thời trang Tween & Teen', '97', '1', '0', '1', null, null, '19');
INSERT INTO `web_category` VALUES ('181', 'Thời trang trẻ em', '97', '1', '0', '1', null, null, '20');
INSERT INTO `web_category` VALUES ('182', 'Thời trang painting - handmade', '97', '1', '0', '1', null, null, '21');
INSERT INTO `web_category` VALUES ('183', 'Nước hoa,chất tạo hương', '164', '1', '0', '1', null, null, '3');
INSERT INTO `web_category` VALUES ('184', 'Khóa học - đào tạo', '0', '0', '0', '1', null, null, '6');
INSERT INTO `web_category` VALUES ('185', 'Khóa chính quy - dài hạn', '184', '1', '0', '1', null, null, '1');
INSERT INTO `web_category` VALUES ('186', 'Khóa học ngoại ngữ', '184', '0', '0', '1', null, null, '2');
INSERT INTO `web_category` VALUES ('187', 'Khóa ngắn hạn - khóa hè', '184', '1', '0', '1', null, null, '3');
INSERT INTO `web_category` VALUES ('188', 'Ngoại khóa - Kỹ năng sống', '184', '1', '0', '1', null, null, '4');
INSERT INTO `web_category` VALUES ('189', 'Đào tạo Online - Trực tuyến', '184', '1', '0', '1', null, null, '5');
INSERT INTO `web_category` VALUES ('190', 'Gia Sư - Phụ đạo', '184', '1', '0', '1', null, null, '6');
INSERT INTO `web_category` VALUES ('191', 'Du học', '184', '1', '0', '1', null, null, '7');
INSERT INTO `web_category` VALUES ('192', 'Thực phẩm đông lạnh', '90', '1', '0', '1', null, null, '6');
INSERT INTO `web_category` VALUES ('193', 'Bia rượu - giải khát', '90', '1', '0', '1', null, null, '7');
INSERT INTO `web_category` VALUES ('194', 'Gia vị - tạp hóa', '90', '1', '0', '1', null, null, '3');
INSERT INTO `web_category` VALUES ('195', 'Bánh kẹo - đồ ăn vặt', '90', '1', '0', '1', null, null, '8');
INSERT INTO `web_category` VALUES ('196', 'Thực phẩm chức năng', '90', '1', '0', '1', null, null, '9');
INSERT INTO `web_category` VALUES ('197', 'Thực phẩm cho thú yêu', '90', '1', '0', '1', null, null, '10');
INSERT INTO `web_category` VALUES ('198', 'Mỹ phẩm cho nam giới', '164', '1', '0', '1', null, null, '11');
INSERT INTO `web_category` VALUES ('199', 'Chăm sóc móng, tay, chân', '164', '1', '0', '1', null, null, '8');
INSERT INTO `web_category` VALUES ('200', 'Chăm sóc da', '164', '1', '0', '1', null, null, '9');
INSERT INTO `web_category` VALUES ('201', 'Chăm sóc sức khỏe', '164', '1', '0', '1', null, null, '10');
INSERT INTO `web_category` VALUES ('202', 'Mỹ phẩm cho trẻ em', '164', '1', '0', '1', null, null, '12');
INSERT INTO `web_category` VALUES ('203', 'Mỹ phẩm xách tay', '164', '1', '0', '1', null, null, '13');
INSERT INTO `web_category` VALUES ('204', 'Mỹ phẩm tự chế', '164', '1', '0', '1', null, null, '14');
INSERT INTO `web_category` VALUES ('205', 'Spa & Massage', '164', '1', '0', '1', null, null, '15');
INSERT INTO `web_category` VALUES ('206', 'Dịch vụ trang điểm', '164', '1', '0', '1', null, null, '16');
INSERT INTO `web_category` VALUES ('207', 'Xe và phụ kiện', '0', '1', '7', '1', null, null, '7');
INSERT INTO `web_category` VALUES ('208', 'Ô tô và phụ kiện', '207', '0', '2', '1', null, null, '1');
INSERT INTO `web_category` VALUES ('209', 'Xe điện & Phụ kiện', '207', '1', '0', '1', null, null, '3');
INSERT INTO `web_category` VALUES ('210', 'Xe đạp & phụ kiện', '207', '1', '0', '1', null, null, '4');
INSERT INTO `web_category` VALUES ('211', 'Xe trẻ em & phụ kiện', '207', '1', '0', '1', null, null, '5');
INSERT INTO `web_category` VALUES ('212', 'Sửa & Làm mới xe', '207', '1', '0', '1', null, null, '6');
INSERT INTO `web_category` VALUES ('213', 'Thực phẩm chay', '90', '0', '0', '1', null, null, '1');
INSERT INTO `web_category` VALUES ('214', 'Nhà sạch - nhà đẹp', '0', '0', '0', '1', null, null, '0');
INSERT INTO `web_category` VALUES ('215', 'Nội thất phòng khách', '214', '1', '0', '1', null, null, '2');
INSERT INTO `web_category` VALUES ('216', 'Nội thất phòng ngủ', '214', '1', '0', '1', null, null, '3');
INSERT INTO `web_category` VALUES ('217', 'Nội thất phòng tắm', '214', '1', '0', '1', null, null, '4');
INSERT INTO `web_category` VALUES ('218', 'Nội thất phòng ăn - bếp', '214', '1', '0', '1', null, null, '5');
INSERT INTO `web_category` VALUES ('219', 'Sân - vườn ', '214', '1', '0', '1', null, null, '6');
INSERT INTO `web_category` VALUES ('220', 'Vật liệu tân trang nhà', '214', '1', '0', '1', null, null, '7');
INSERT INTO `web_category` VALUES ('221', 'Hóa phẩm - chất giặt tẩy', '214', '1', '0', '1', null, null, '8');
INSERT INTO `web_category` VALUES ('222', 'Đơn vị thi công - sửa chữa nhà', '214', '1', '0', '1', null, null, '9');
INSERT INTO `web_category` VALUES ('223', 'Dịch vụ lau - dọn nhà', '214', '1', '0', '1', null, null, '10');
INSERT INTO `web_category` VALUES ('224', 'Vật liệu xây dựng', '214', '1', '0', '1', null, null, '11');
INSERT INTO `web_category` VALUES ('225', 'Ẩm thực - Giải trí', '0', '0', '0', '1', null, null, '0');
INSERT INTO `web_category` VALUES ('226', 'Buffet', '225', '1', '0', '1', null, null, '2');
INSERT INTO `web_category` VALUES ('227', 'Nhà hàng', '225', '1', '0', '1', null, null, '3');
INSERT INTO `web_category` VALUES ('228', 'Quán xá - ăn vặt', '225', '1', '0', '1', null, null, '4');
INSERT INTO `web_category` VALUES ('229', 'Xem gì đây?', '225', '1', '0', '1', null, null, '5');
INSERT INTO `web_category` VALUES ('230', 'Nghe gì đây?', '225', '1', '0', '1', null, null, '6');
INSERT INTO `web_category` VALUES ('231', 'Chơi gì đây?', '225', '1', '0', '1', null, null, '7');
INSERT INTO `web_category` VALUES ('232', 'Du lịch - Nghỉ dưỡng', '0', '0', '0', '0', null, null, '0');
INSERT INTO `web_category` VALUES ('233', 'Tour Du lịch', '232', '0', '0', '1', null, null, '2');
INSERT INTO `web_category` VALUES ('234', 'Resort', '232', '0', '0', '1', null, null, '3');
INSERT INTO `web_category` VALUES ('235', 'Trang trại - Điền viên', '232', '0', '0', '1', null, null, '4');
INSERT INTO `web_category` VALUES ('236', 'Khách sạn - Nhà nghỉ', '232', '0', '0', '1', null, null, '5');
INSERT INTO `web_category` VALUES ('237', 'Vé máy bay - tàu - xe', '232', '0', '0', '1', null, null, '6');
INSERT INTO `web_category` VALUES ('238', 'Thuê xe ', '232', '0', '0', '1', null, null, '7');
INSERT INTO `web_category` VALUES ('239', 'Văn phòng phẩm - Sách báo', '0', '0', '0', '1', null, null, '0');
INSERT INTO `web_category` VALUES ('240', 'Sách - Truyện ', '239', '0', '0', '1', null, null, '2');
INSERT INTO `web_category` VALUES ('241', 'Tạp chí - Báo', '239', '0', '0', '1', null, null, '3');
INSERT INTO `web_category` VALUES ('242', 'Văn phòng phẩm', '239', '0', '0', '1', null, null, '4');
INSERT INTO `web_category` VALUES ('243', 'Đồ dùng học sinh', '239', '0', '0', '1', null, null, '5');
INSERT INTO `web_category` VALUES ('244', 'Quà tặng', '239', '0', '0', '1', null, null, '6');
INSERT INTO `web_category` VALUES ('245', 'Đồ Hànmade', '239', '0', '0', '1', null, null, '7');
INSERT INTO `web_category` VALUES ('246', 'Dịch vụ', '0', '0', '0', '1', null, null, '0');
INSERT INTO `web_category` VALUES ('247', 'Nấu cỗ', '246', '0', '0', '1', null, null, '2');
INSERT INTO `web_category` VALUES ('248', 'Đám hỏi - Đám cưới', '246', '0', '0', '1', null, null, '3');
INSERT INTO `web_category` VALUES ('249', 'Đám hiếu', '246', '0', '0', '1', null, null, '4');
INSERT INTO `web_category` VALUES ('250', 'Ô sin - giúp việc', '246', '0', '0', '1', null, null, '5');
INSERT INTO `web_category` VALUES ('251', 'Chụp ảnh', '246', '0', '0', '1', null, null, '6');
INSERT INTO `web_category` VALUES ('252', 'Biên - phiên dịch', '246', '0', '0', '1', null, null, '7');

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
  `customer_up_item` int(11) DEFAULT '0' COMMENT 'số lượt dang tin',
  `customer_time_login` int(12) DEFAULT NULL,
  `customer_time_logout` int(12) DEFAULT NULL,
  `customer_time_created` int(12) DEFAULT NULL COMMENT 'Ngày tạo',
  `customer_time_active` int(12) DEFAULT '0' COMMENT 'Ngày active',
  `is_customer` tinyint(1) DEFAULT '0' COMMENT '0-thuong, 1-vip',
  `is_login` tinyint(1) DEFAULT '0' COMMENT '0:not login, 1:login',
  `time_start_vip` int(12) DEFAULT NULL COMMENT 'Ngày bắt đầu vip',
  `time_end_vip` int(12) DEFAULT NULL COMMENT 'Ngày hết hạn vip',
  PRIMARY KEY (`customer_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of web_customer
-- ----------------------------
INSERT INTO `web_customer` VALUES ('1', 'Trương Mạnh Quỳnh', 'eef828faf0754495136af05c051766cb', '0938413368', 'Việt Hưng - Long Biên - Hà Nội', 'manhquynh1984@gmail.com', '0', '0', '', '0', '0', 'Việt Hưng - Long Biên - Hà Nội', '1', '0', '1479357345', '1479286613', '1478594509', '1', '0', '1', null, null);

-- ----------------------------
-- Table structure for web_districts
-- ----------------------------
DROP TABLE IF EXISTS `web_districts`;
CREATE TABLE `web_districts` (
  `district_id` int(3) NOT NULL AUTO_INCREMENT,
  `district_name` varchar(225) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `district_status` tinyint(1) NOT NULL DEFAULT '1',
  `district_city_id` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`district_id`),
  KEY `id_citiesfather` (`district_city_id`),
  KEY `Idx_id_citiesfather_orders_name` (`district_city_id`,`district_name`)
) ENGINE=InnoDB AUTO_INCREMENT=860 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of web_districts
-- ----------------------------
INSERT INTO `web_districts` VALUES ('1', 'Ba Đình', '1', '22');
INSERT INTO `web_districts` VALUES ('2', 'Long Biên', '1', '22');
INSERT INTO `web_districts` VALUES ('3', 'Sóc Sơn', '1', '22');
INSERT INTO `web_districts` VALUES ('4', 'Đông Anh', '1', '22');
INSERT INTO `web_districts` VALUES ('5', 'TP Thủ Dầu Một', '1', '8');
INSERT INTO `web_districts` VALUES ('7', 'Thị xã Đồng Xoài', '1', '10');
INSERT INTO `web_districts` VALUES ('10', 'Bến Cát', '1', '8');
INSERT INTO `web_districts` VALUES ('12', 'Tân Uyên', '1', '8');
INSERT INTO `web_districts` VALUES ('16', 'Thuận An', '1', '8');
INSERT INTO `web_districts` VALUES ('18', 'TP Dĩ An', '1', '8');
INSERT INTO `web_districts` VALUES ('20', 'Phú Giáo', '1', '8');
INSERT INTO `web_districts` VALUES ('22', 'Dầu Tiếng', '1', '8');
INSERT INTO `web_districts` VALUES ('28', 'Đồng Xoài', '1', '10');
INSERT INTO `web_districts` VALUES ('31', 'Đồng Phú', '1', '10');
INSERT INTO `web_districts` VALUES ('33', 'Chơn Thành', '1', '10');
INSERT INTO `web_districts` VALUES ('35', 'Bình Long', '1', '10');
INSERT INTO `web_districts` VALUES ('36', 'Lộc Ninh', '1', '10');
INSERT INTO `web_districts` VALUES ('39', 'Bù Đốp', '1', '10');
INSERT INTO `web_districts` VALUES ('40', 'Thành phố Phan Rang - Tháp Chàm', '1', '41');
INSERT INTO `web_districts` VALUES ('42', 'Việt Trì', '1', '42');
INSERT INTO `web_districts` VALUES ('43', 'Phước Long', '1', '10');
INSERT INTO `web_districts` VALUES ('44', 'Huyện Ninh Sơn', '1', '41');
INSERT INTO `web_districts` VALUES ('45', 'Huyện Ninh Hải', '1', '41');
INSERT INTO `web_districts` VALUES ('46', 'Bù Đăng', '1', '10');
INSERT INTO `web_districts` VALUES ('47', 'Huyện Ninh Phước', '1', '41');
INSERT INTO `web_districts` VALUES ('48', 'Hớn Quản', '1', '10');
INSERT INTO `web_districts` VALUES ('49', 'Bác Ái', '1', '41');
INSERT INTO `web_districts` VALUES ('50', 'Bù Gia Mập', '1', '10');
INSERT INTO `web_districts` VALUES ('51', 'Hoàn Kiếm', '1', '22');
INSERT INTO `web_districts` VALUES ('52', 'Huyện Thuận Bắc', '1', '41');
INSERT INTO `web_districts` VALUES ('53', 'Hai Bà Trưng', '1', '22');
INSERT INTO `web_districts` VALUES ('54', 'Huyện Thuận Nam', '1', '41');
INSERT INTO `web_districts` VALUES ('55', 'Đống Đa', '1', '22');
INSERT INTO `web_districts` VALUES ('57', 'Tây Hồ', '1', '22');
INSERT INTO `web_districts` VALUES ('58', 'Đà Lạt', '1', '36');
INSERT INTO `web_districts` VALUES ('60', 'Cầu Giấy', '1', '22');
INSERT INTO `web_districts` VALUES ('61', 'Bảo Lộc', '1', '36');
INSERT INTO `web_districts` VALUES ('62', 'Thị xã Tây Ninh', '1', '51');
INSERT INTO `web_districts` VALUES ('63', 'Thanh Xuân', '1', '22');
INSERT INTO `web_districts` VALUES ('64', 'Huyện Tân Biên', '1', '51');
INSERT INTO `web_districts` VALUES ('65', 'Đức Trọng', '1', '36');
INSERT INTO `web_districts` VALUES ('66', 'Huyện Tân Châu', '1', '51');
INSERT INTO `web_districts` VALUES ('67', 'Huyện Dương Minh Châu', '1', '51');
INSERT INTO `web_districts` VALUES ('68', 'Di Linh', '1', '36');
INSERT INTO `web_districts` VALUES ('69', 'Huyện Châu Thành', '1', '51');
INSERT INTO `web_districts` VALUES ('70', 'Hoàng Mai', '1', '22');
INSERT INTO `web_districts` VALUES ('71', 'Đơn Dương', '1', '36');
INSERT INTO `web_districts` VALUES ('72', 'Huyện Hoà Thành', '1', '51');
INSERT INTO `web_districts` VALUES ('73', 'Huyện Bến Cầu', '1', '51');
INSERT INTO `web_districts` VALUES ('74', 'Lạc Dương', '1', '36');
INSERT INTO `web_districts` VALUES ('75', 'Đoan Hùng', '1', '42');
INSERT INTO `web_districts` VALUES ('76', 'Đạ Huoai', '1', '36');
INSERT INTO `web_districts` VALUES ('77', 'Huyện Gò Dầu', '1', '51');
INSERT INTO `web_districts` VALUES ('78', 'Huyện Trảng Bàng', '1', '51');
INSERT INTO `web_districts` VALUES ('79', 'Đạ Tẻh', '1', '36');
INSERT INTO `web_districts` VALUES ('80', 'Thanh Ba', '1', '42');
INSERT INTO `web_districts` VALUES ('81', 'Cát Tiên', '1', '36');
INSERT INTO `web_districts` VALUES ('83', 'Lâm Hà', '1', '36');
INSERT INTO `web_districts` VALUES ('84', 'Thành phố Phan Thiết', '1', '11');
INSERT INTO `web_districts` VALUES ('85', 'Huyện Tuy Phong', '1', '11');
INSERT INTO `web_districts` VALUES ('86', 'Bảo Lâm', '1', '36');
INSERT INTO `web_districts` VALUES ('87', 'Nam Từ Liêm', '1', '22');
INSERT INTO `web_districts` VALUES ('88', 'Huyện Bắc Bình', '1', '11');
INSERT INTO `web_districts` VALUES ('89', 'Đam Rông', '1', '36');
INSERT INTO `web_districts` VALUES ('91', 'Thanh Trì', '1', '22');
INSERT INTO `web_districts` VALUES ('92', 'Hàm Thuận Bắc', '1', '11');
INSERT INTO `web_districts` VALUES ('93', 'Gia Lâm', '1', '22');
INSERT INTO `web_districts` VALUES ('95', 'Hàm Thuận Nam', '1', '11');
INSERT INTO `web_districts` VALUES ('96', 'Nha Trang', '1', '30');
INSERT INTO `web_districts` VALUES ('97', 'Tuyên Quang', '1', '58');
INSERT INTO `web_districts` VALUES ('98', 'Huyện Hàm Tân', '1', '11');
INSERT INTO `web_districts` VALUES ('99', 'Vạn Ninh', '1', '30');
INSERT INTO `web_districts` VALUES ('100', 'Huyện Đức Linh', '1', '11');
INSERT INTO `web_districts` VALUES ('101', 'Na Hang', '1', '58');
INSERT INTO `web_districts` VALUES ('102', 'Huyện Tánh Linh', '1', '11');
INSERT INTO `web_districts` VALUES ('103', 'Ninh Hoà', '1', '30');
INSERT INTO `web_districts` VALUES ('104', 'Huyện đảo Phú Quý', '1', '11');
INSERT INTO `web_districts` VALUES ('105', 'Chiêm Hoá', '1', '58');
INSERT INTO `web_districts` VALUES ('106', 'Thị xã La Gi', '1', '11');
INSERT INTO `web_districts` VALUES ('107', 'Diên Khánh', '1', '30');
INSERT INTO `web_districts` VALUES ('108', 'Hàm Yên', '1', '58');
INSERT INTO `web_districts` VALUES ('109', 'Yên Sơn', '1', '58');
INSERT INTO `web_districts` VALUES ('110', 'Khánh Vĩnh', '1', '30');
INSERT INTO `web_districts` VALUES ('111', 'Cam Ranh', '1', '30');
INSERT INTO `web_districts` VALUES ('112', 'Sơn Dương', '1', '58');
INSERT INTO `web_districts` VALUES ('113', 'Hà Đông', '1', '22');
INSERT INTO `web_districts` VALUES ('115', 'Khánh Sơn', '1', '30');
INSERT INTO `web_districts` VALUES ('116', 'Sơn Tây', '1', '22');
INSERT INTO `web_districts` VALUES ('117', 'Ba Vì', '1', '22');
INSERT INTO `web_districts` VALUES ('118', 'Trường Sa', '1', '30');
INSERT INTO `web_districts` VALUES ('119', 'Thành phố Biên Hoà', '1', '17');
INSERT INTO `web_districts` VALUES ('120', 'Phúc Thọ', '1', '22');
INSERT INTO `web_districts` VALUES ('121', 'Huyện Vĩnh Cửu', '1', '17');
INSERT INTO `web_districts` VALUES ('122', 'Cam Lâm', '1', '30');
INSERT INTO `web_districts` VALUES ('123', 'Thạch Thất', '1', '22');
INSERT INTO `web_districts` VALUES ('124', 'Quốc Oai', '1', '22');
INSERT INTO `web_districts` VALUES ('127', 'Chương Mỹ', '1', '22');
INSERT INTO `web_districts` VALUES ('128', 'Lạng Sơn', '1', '34');
INSERT INTO `web_districts` VALUES ('129', 'Buôn Ma Thuột', '1', '16');
INSERT INTO `web_districts` VALUES ('130', 'Đan Phượng', '1', '22');
INSERT INTO `web_districts` VALUES ('131', 'Tràng Định', '1', '34');
INSERT INTO `web_districts` VALUES ('132', 'Hoài Đức', '1', '22');
INSERT INTO `web_districts` VALUES ('133', 'Ea H Leo', '1', '16');
INSERT INTO `web_districts` VALUES ('134', 'Bình Gia', '1', '34');
INSERT INTO `web_districts` VALUES ('135', 'Krông Buk', '1', '16');
INSERT INTO `web_districts` VALUES ('136', 'Thanh Oai', '1', '22');
INSERT INTO `web_districts` VALUES ('137', 'Huyện Định Quán', '1', '17');
INSERT INTO `web_districts` VALUES ('138', 'Văn Lãng', '1', '34');
INSERT INTO `web_districts` VALUES ('139', 'Mỹ Đức', '1', '22');
INSERT INTO `web_districts` VALUES ('140', 'Krông Năng', '1', '72');
INSERT INTO `web_districts` VALUES ('141', 'Bắc Sơn', '1', '34');
INSERT INTO `web_districts` VALUES ('142', 'Ứng Hoà', '1', '22');
INSERT INTO `web_districts` VALUES ('143', 'Ea Súp', '1', '16');
INSERT INTO `web_districts` VALUES ('144', 'Thống Nhất', '1', '17');
INSERT INTO `web_districts` VALUES ('145', 'Thường Tín', '1', '22');
INSERT INTO `web_districts` VALUES ('148', 'Phú Xuyên', '1', '22');
INSERT INTO `web_districts` VALUES ('149', 'Văn Quan', '1', '34');
INSERT INTO `web_districts` VALUES ('150', 'Mê Linh', '1', '22');
INSERT INTO `web_districts` VALUES ('151', 'Thị xã Long Khánh', '1', '17');
INSERT INTO `web_districts` VALUES ('152', 'Krông Pắc', '1', '72');
INSERT INTO `web_districts` VALUES ('153', 'Huyện Long Thành', '1', '17');
INSERT INTO `web_districts` VALUES ('154', 'Ea Kar', '1', '72');
INSERT INTO `web_districts` VALUES ('155', 'Huyện Nhơn Trạch', '1', '17');
INSERT INTO `web_districts` VALUES ('156', 'M&#39;Đrăk', '1', '16');
INSERT INTO `web_districts` VALUES ('157', 'Huyện Trảng Bom', '1', '17');
INSERT INTO `web_districts` VALUES ('158', 'Krông Ana', '1', '72');
INSERT INTO `web_districts` VALUES ('160', 'Krông Bông', '1', '72');
INSERT INTO `web_districts` VALUES ('161', 'Quận 1', '1', '29');
INSERT INTO `web_districts` VALUES ('162', 'Cao Lộc', '1', '34');
INSERT INTO `web_districts` VALUES ('163', 'Quận 2', '1', '29');
INSERT INTO `web_districts` VALUES ('164', 'Lăk', '1', '72');
INSERT INTO `web_districts` VALUES ('165', 'Quận 3', '1', '29');
INSERT INTO `web_districts` VALUES ('166', 'Quận 4', '1', '29');
INSERT INTO `web_districts` VALUES ('167', 'Quận 5', '1', '29');
INSERT INTO `web_districts` VALUES ('168', 'Quận 6', '1', '29');
INSERT INTO `web_districts` VALUES ('169', 'Lộc Bình', '1', '34');
INSERT INTO `web_districts` VALUES ('170', 'Quận 7', '1', '29');
INSERT INTO `web_districts` VALUES ('171', 'Chi Lăng', '1', '34');
INSERT INTO `web_districts` VALUES ('172', 'Quận 8', '1', '29');
INSERT INTO `web_districts` VALUES ('173', 'Đình Lập', '1', '34');
INSERT INTO `web_districts` VALUES ('174', 'Quận 9', '1', '29');
INSERT INTO `web_districts` VALUES ('175', 'Hữu Lũng', '1', '34');
INSERT INTO `web_districts` VALUES ('176', 'Quận 10', '1', '29');
INSERT INTO `web_districts` VALUES ('177', 'Quận 11', '1', '29');
INSERT INTO `web_districts` VALUES ('178', 'Quận 12', '1', '29');
INSERT INTO `web_districts` VALUES ('179', 'Huyện Tân Phú', '1', '17');
INSERT INTO `web_districts` VALUES ('180', 'Gò Vấp', '1', '29');
INSERT INTO `web_districts` VALUES ('181', 'Buôn Đôn', '1', '72');
INSERT INTO `web_districts` VALUES ('182', 'Tân Bình', '1', '29');
INSERT INTO `web_districts` VALUES ('183', 'Xuân Lộc', '1', '17');
INSERT INTO `web_districts` VALUES ('185', 'Tân Phú', '1', '29');
INSERT INTO `web_districts` VALUES ('186', 'Cẩm Mỹ', '1', '17');
INSERT INTO `web_districts` VALUES ('187', 'Buôn Hồ', '1', '16');
INSERT INTO `web_districts` VALUES ('188', 'Bình Thạnh', '1', '29');
INSERT INTO `web_districts` VALUES ('189', 'Phú Nhuận', '1', '29');
INSERT INTO `web_districts` VALUES ('191', 'Tân An', '1', '37');
INSERT INTO `web_districts` VALUES ('192', 'Vĩnh Hưng', '1', '37');
INSERT INTO `web_districts` VALUES ('194', 'Mộc Hoá', '1', '37');
INSERT INTO `web_districts` VALUES ('195', 'Tuy Hoà', '1', '43');
INSERT INTO `web_districts` VALUES ('196', 'Đồng Xuân', '1', '43');
INSERT INTO `web_districts` VALUES ('197', 'Sông Cầu', '1', '43');
INSERT INTO `web_districts` VALUES ('198', 'Tuy An', '1', '43');
INSERT INTO `web_districts` VALUES ('199', 'Sơn Hoà', '1', '43');
INSERT INTO `web_districts` VALUES ('200', 'Tân Thạnh', '1', '37');
INSERT INTO `web_districts` VALUES ('201', 'Sông Hinh', '1', '43');
INSERT INTO `web_districts` VALUES ('202', 'Đông Hoà', '1', '43');
INSERT INTO `web_districts` VALUES ('203', 'Phú Hoà', '1', '43');
INSERT INTO `web_districts` VALUES ('204', 'Đức Huệ', '1', '37');
INSERT INTO `web_districts` VALUES ('205', 'Tây Hoà', '1', '43');
INSERT INTO `web_districts` VALUES ('206', 'Đức Hoà', '1', '37');
INSERT INTO `web_districts` VALUES ('207', 'Bến Lức', '1', '37');
INSERT INTO `web_districts` VALUES ('208', 'Thủ Thừa', '1', '37');
INSERT INTO `web_districts` VALUES ('209', 'Châu Thành', '1', '37');
INSERT INTO `web_districts` VALUES ('212', 'Tân Trụ', '1', '37');
INSERT INTO `web_districts` VALUES ('213', 'Thái Nguyên', '1', '53');
INSERT INTO `web_districts` VALUES ('214', 'Sông Công', '1', '53');
INSERT INTO `web_districts` VALUES ('215', 'Cần Đước', '1', '37');
INSERT INTO `web_districts` VALUES ('216', 'Định Hoá', '1', '53');
INSERT INTO `web_districts` VALUES ('217', 'Cần Giuộc', '1', '37');
INSERT INTO `web_districts` VALUES ('218', 'Phú Lương', '1', '53');
INSERT INTO `web_districts` VALUES ('219', 'Tân Hưng', '1', '37');
INSERT INTO `web_districts` VALUES ('220', 'Võ Nhai', '1', '53');
INSERT INTO `web_districts` VALUES ('222', 'Đại Từ', '1', '53');
INSERT INTO `web_districts` VALUES ('223', 'TP Cao Lãnh', '1', '18');
INSERT INTO `web_districts` VALUES ('224', 'Đồng Hỷ', '1', '53');
INSERT INTO `web_districts` VALUES ('225', 'Sa Đéc', '1', '18');
INSERT INTO `web_districts` VALUES ('226', 'Phú Bình', '1', '53');
INSERT INTO `web_districts` VALUES ('227', 'Tân Hồng', '1', '18');
INSERT INTO `web_districts` VALUES ('228', 'Phổ Yên', '1', '53');
INSERT INTO `web_districts` VALUES ('229', 'Hồng Ngự', '1', '18');
INSERT INTO `web_districts` VALUES ('230', 'Tam Nông', '1', '18');
INSERT INTO `web_districts` VALUES ('231', 'Thanh Bình', '1', '18');
INSERT INTO `web_districts` VALUES ('233', 'Yên Bái', '1', '61');
INSERT INTO `web_districts` VALUES ('234', 'Lấp Vò', '1', '18');
INSERT INTO `web_districts` VALUES ('235', 'Nghĩa Lộ', '1', '61');
INSERT INTO `web_districts` VALUES ('236', 'Tháp Mười', '1', '18');
INSERT INTO `web_districts` VALUES ('237', 'Văn Yên', '1', '61');
INSERT INTO `web_districts` VALUES ('238', 'Lai Vung', '1', '18');
INSERT INTO `web_districts` VALUES ('239', 'Pleiku', '1', '19');
INSERT INTO `web_districts` VALUES ('240', 'Yên Bình', '1', '61');
INSERT INTO `web_districts` VALUES ('241', 'Châu Thành', '1', '18');
INSERT INTO `web_districts` VALUES ('242', 'Mù Cang Chải', '1', '61');
INSERT INTO `web_districts` VALUES ('243', 'Chư Păh', '1', '19');
INSERT INTO `web_districts` VALUES ('244', 'Văn Chấn', '1', '61');
INSERT INTO `web_districts` VALUES ('245', 'Mang Yang', '1', '19');
INSERT INTO `web_districts` VALUES ('246', 'Trấn Yên', '1', '61');
INSERT INTO `web_districts` VALUES ('247', 'Kông Chro', '1', '19');
INSERT INTO `web_districts` VALUES ('249', 'Đức Cơ', '1', '19');
INSERT INTO `web_districts` VALUES ('250', 'Long Xuyên', '1', '66');
INSERT INTO `web_districts` VALUES ('251', 'Châu Đốc', '1', '66');
INSERT INTO `web_districts` VALUES ('252', 'Chư Prông', '1', '19');
INSERT INTO `web_districts` VALUES ('253', 'Trạm Tấu', '1', '61');
INSERT INTO `web_districts` VALUES ('254', 'An Phú', '1', '66');
INSERT INTO `web_districts` VALUES ('255', 'Chư Sê', '1', '19');
INSERT INTO `web_districts` VALUES ('256', 'Tân Châu', '1', '66');
INSERT INTO `web_districts` VALUES ('257', 'Ia Grai', '1', '19');
INSERT INTO `web_districts` VALUES ('258', 'Phú Tân', '1', '66');
INSERT INTO `web_districts` VALUES ('259', 'Tịnh Biên', '1', '66');
INSERT INTO `web_districts` VALUES ('260', 'Đăk Đoa', '1', '19');
INSERT INTO `web_districts` VALUES ('261', 'Tri Tôn', '1', '66');
INSERT INTO `web_districts` VALUES ('262', 'Ia Pa', '1', '19');
INSERT INTO `web_districts` VALUES ('263', 'Châu Phú', '1', '66');
INSERT INTO `web_districts` VALUES ('264', 'Đăk Pơ', '1', '19');
INSERT INTO `web_districts` VALUES ('265', 'Chợ Mới', '1', '66');
INSERT INTO `web_districts` VALUES ('266', 'K’Bang', '1', '19');
INSERT INTO `web_districts` VALUES ('267', 'An Khê', '1', '19');
INSERT INTO `web_districts` VALUES ('268', 'Ayun Pa', '1', '19');
INSERT INTO `web_districts` VALUES ('269', 'Châu Thành', '1', '66');
INSERT INTO `web_districts` VALUES ('270', 'Krông Pa', '1', '19');
INSERT INTO `web_districts` VALUES ('271', 'Thủ Đức', '1', '29');
INSERT INTO `web_districts` VALUES ('272', 'Phú Thiện', '1', '19');
INSERT INTO `web_districts` VALUES ('273', 'Thoại Sơn', '1', '66');
INSERT INTO `web_districts` VALUES ('274', 'Bình Tân', '1', '29');
INSERT INTO `web_districts` VALUES ('275', 'Lục Yên', '1', '61');
INSERT INTO `web_districts` VALUES ('276', 'Chư Pưh', '1', '19');
INSERT INTO `web_districts` VALUES ('277', 'Bình Chánh', '1', '29');
INSERT INTO `web_districts` VALUES ('278', 'Củ Chi', '1', '29');
INSERT INTO `web_districts` VALUES ('280', 'Quy Nhơn', '1', '9');
INSERT INTO `web_districts` VALUES ('281', 'Hóc Môn', '1', '29');
INSERT INTO `web_districts` VALUES ('282', 'Nhà Bè', '1', '29');
INSERT INTO `web_districts` VALUES ('283', 'An Lão', '1', '9');
INSERT INTO `web_districts` VALUES ('285', 'Cần Giờ', '1', '29');
INSERT INTO `web_districts` VALUES ('286', 'Hoài Ân', '1', '9');
INSERT INTO `web_districts` VALUES ('287', 'Vũng Tàu', '1', '67');
INSERT INTO `web_districts` VALUES ('288', 'Bà Rịa', '1', '67');
INSERT INTO `web_districts` VALUES ('289', 'Hoài Nhơn', '1', '9');
INSERT INTO `web_districts` VALUES ('290', 'Xuyên Mộc', '1', '67');
INSERT INTO `web_districts` VALUES ('291', 'Long Điền', '1', '67');
INSERT INTO `web_districts` VALUES ('292', 'Phù Mỹ', '1', '9');
INSERT INTO `web_districts` VALUES ('293', 'Phù Cát', '1', '9');
INSERT INTO `web_districts` VALUES ('294', 'Côn Đảo', '1', '67');
INSERT INTO `web_districts` VALUES ('295', 'Vĩnh Thạnh', '1', '9');
INSERT INTO `web_districts` VALUES ('296', 'Tân Thành', '1', '67');
INSERT INTO `web_districts` VALUES ('297', 'Châu Đức', '1', '67');
INSERT INTO `web_districts` VALUES ('298', 'Tây Sơn', '1', '9');
INSERT INTO `web_districts` VALUES ('300', 'Đất Đỏ', '1', '67');
INSERT INTO `web_districts` VALUES ('301', 'Sơn La', '1', '50');
INSERT INTO `web_districts` VALUES ('302', 'Vân Canh', '1', '9');
INSERT INTO `web_districts` VALUES ('303', 'Quỳnh Nhai', '1', '50');
INSERT INTO `web_districts` VALUES ('305', 'Mường La', '1', '50');
INSERT INTO `web_districts` VALUES ('306', 'An Nhơn', '1', '9');
INSERT INTO `web_districts` VALUES ('307', 'Mỹ Tho', '1', '56');
INSERT INTO `web_districts` VALUES ('308', 'Thuận Châu', '1', '50');
INSERT INTO `web_districts` VALUES ('309', 'Tuy Phước', '1', '9');
INSERT INTO `web_districts` VALUES ('310', 'Bắc Yên', '1', '50');
INSERT INTO `web_districts` VALUES ('311', 'Gò Công', '1', '56');
INSERT INTO `web_districts` VALUES ('313', 'Cái Bè', '1', '56');
INSERT INTO `web_districts` VALUES ('314', 'Phù Yên', '1', '50');
INSERT INTO `web_districts` VALUES ('315', 'KonTum', '1', '32');
INSERT INTO `web_districts` VALUES ('316', 'Mai Sơn', '1', '50');
INSERT INTO `web_districts` VALUES ('317', 'Cai Lậy', '1', '56');
INSERT INTO `web_districts` VALUES ('318', 'Đăk Glei', '1', '32');
INSERT INTO `web_districts` VALUES ('319', 'Yên Châu', '1', '50');
INSERT INTO `web_districts` VALUES ('320', 'Châu Thành', '1', '56');
INSERT INTO `web_districts` VALUES ('321', 'Ngọc Hồi', '1', '32');
INSERT INTO `web_districts` VALUES ('322', 'Sông Mã', '1', '50');
INSERT INTO `web_districts` VALUES ('323', 'Mộc Châu', '1', '50');
INSERT INTO `web_districts` VALUES ('324', 'Đăk Tô', '1', '32');
INSERT INTO `web_districts` VALUES ('325', 'Chợ Gạo', '1', '56');
INSERT INTO `web_districts` VALUES ('326', 'Sa Thầy', '1', '32');
INSERT INTO `web_districts` VALUES ('327', 'Sốp Cộp', '1', '50');
INSERT INTO `web_districts` VALUES ('328', 'Gò Công Tây', '1', '56');
INSERT INTO `web_districts` VALUES ('329', 'Kon Plong', '1', '32');
INSERT INTO `web_districts` VALUES ('330', 'Đăk Hà', '1', '32');
INSERT INTO `web_districts` VALUES ('331', 'Gò Công Đông', '1', '56');
INSERT INTO `web_districts` VALUES ('332', 'Kon Rẫy', '1', '32');
INSERT INTO `web_districts` VALUES ('333', 'Tu Mơ Rông', '1', '32');
INSERT INTO `web_districts` VALUES ('335', 'Tân Phước', '1', '56');
INSERT INTO `web_districts` VALUES ('337', 'Bắc Kạn', '1', '4');
INSERT INTO `web_districts` VALUES ('339', 'Quảng Ngãi', '1', '46');
INSERT INTO `web_districts` VALUES ('340', 'Chợ Đồn', '1', '4');
INSERT INTO `web_districts` VALUES ('341', 'Lý Sơn', '1', '46');
INSERT INTO `web_districts` VALUES ('342', 'Bạch Thông', '1', '4');
INSERT INTO `web_districts` VALUES ('343', 'Bình Sơn', '1', '46');
INSERT INTO `web_districts` VALUES ('344', 'Trà Bồng', '1', '46');
INSERT INTO `web_districts` VALUES ('345', 'Sơn Tịnh', '1', '46');
INSERT INTO `web_districts` VALUES ('346', 'Na Rì', '1', '4');
INSERT INTO `web_districts` VALUES ('347', 'Sơn Hà', '1', '46');
INSERT INTO `web_districts` VALUES ('348', 'Tân Phú Đông', '1', '56');
INSERT INTO `web_districts` VALUES ('349', 'Tư Nghĩa', '1', '46');
INSERT INTO `web_districts` VALUES ('350', 'Nghĩa Hành', '1', '46');
INSERT INTO `web_districts` VALUES ('351', 'Ngân Sơn', '1', '4');
INSERT INTO `web_districts` VALUES ('353', 'Minh Long', '1', '46');
INSERT INTO `web_districts` VALUES ('354', 'Ba Bể', '1', '4');
INSERT INTO `web_districts` VALUES ('355', 'Rạch Giá', '1', '31');
INSERT INTO `web_districts` VALUES ('356', 'Chợ Mới', '1', '4');
INSERT INTO `web_districts` VALUES ('357', 'Mộ Đức', '1', '46');
INSERT INTO `web_districts` VALUES ('358', 'Hà Tiên', '1', '31');
INSERT INTO `web_districts` VALUES ('359', 'Pác Nặm', '1', '4');
INSERT INTO `web_districts` VALUES ('360', 'Đức Phổ', '1', '46');
INSERT INTO `web_districts` VALUES ('361', 'Kiên Lương', '1', '31');
INSERT INTO `web_districts` VALUES ('362', 'Hòn Đất', '1', '31');
INSERT INTO `web_districts` VALUES ('363', 'Ba Tơ', '1', '46');
INSERT INTO `web_districts` VALUES ('364', 'Phú Thọ', '1', '42');
INSERT INTO `web_districts` VALUES ('365', 'Tân Hiệp', '1', '31');
INSERT INTO `web_districts` VALUES ('366', 'Sơn Tây', '1', '46');
INSERT INTO `web_districts` VALUES ('367', 'Châu Thành', '1', '31');
INSERT INTO `web_districts` VALUES ('368', 'Tây Trà', '1', '46');
INSERT INTO `web_districts` VALUES ('369', 'Giồng Riềng', '1', '31');
INSERT INTO `web_districts` VALUES ('370', 'Hạ Hoà', '1', '42');
INSERT INTO `web_districts` VALUES ('371', 'Gò Quao', '1', '31');
INSERT INTO `web_districts` VALUES ('372', 'Cẩm Khê', '1', '42');
INSERT INTO `web_districts` VALUES ('374', 'An Biên', '1', '31');
INSERT INTO `web_districts` VALUES ('375', 'Yên Lập', '1', '42');
INSERT INTO `web_districts` VALUES ('376', 'An Minh', '1', '31');
INSERT INTO `web_districts` VALUES ('377', 'Thanh Sơn', '1', '42');
INSERT INTO `web_districts` VALUES ('378', 'Vĩnh Thuận', '1', '31');
INSERT INTO `web_districts` VALUES ('379', 'Tam Kỳ', '1', '45');
INSERT INTO `web_districts` VALUES ('380', 'Phù Ninh', '1', '42');
INSERT INTO `web_districts` VALUES ('381', 'Phú Quốc', '1', '31');
INSERT INTO `web_districts` VALUES ('382', 'Hội An', '1', '45');
INSERT INTO `web_districts` VALUES ('383', 'Lâm Thao', '1', '42');
INSERT INTO `web_districts` VALUES ('384', 'Kiên Hải', '1', '31');
INSERT INTO `web_districts` VALUES ('385', 'Tam Nông', '1', '42');
INSERT INTO `web_districts` VALUES ('386', 'U Minh Thượng', '1', '31');
INSERT INTO `web_districts` VALUES ('387', 'Duy Xuyên', '1', '45');
INSERT INTO `web_districts` VALUES ('388', 'Thanh Thủy', '1', '42');
INSERT INTO `web_districts` VALUES ('389', 'Điện Bàn', '1', '45');
INSERT INTO `web_districts` VALUES ('390', 'Tân Sơn', '1', '42');
INSERT INTO `web_districts` VALUES ('391', 'Giang Thành', '1', '31');
INSERT INTO `web_districts` VALUES ('392', 'Đại Lộc', '1', '45');
INSERT INTO `web_districts` VALUES ('394', 'Quế Sơn', '1', '45');
INSERT INTO `web_districts` VALUES ('395', 'Ninh Kiều', '1', '14');
INSERT INTO `web_districts` VALUES ('396', 'Hiệp Đức', '1', '45');
INSERT INTO `web_districts` VALUES ('397', 'Bình Thuỷ', '1', '14');
INSERT INTO `web_districts` VALUES ('398', 'Thăng Bình', '1', '45');
INSERT INTO `web_districts` VALUES ('399', 'Cái Răng', '1', '14');
INSERT INTO `web_districts` VALUES ('400', 'Ô Môn', '1', '14');
INSERT INTO `web_districts` VALUES ('401', 'Núi Thành', '1', '45');
INSERT INTO `web_districts` VALUES ('402', 'Phong Điền', '1', '14');
INSERT INTO `web_districts` VALUES ('403', 'Tiên Phước', '1', '45');
INSERT INTO `web_districts` VALUES ('404', 'Cờ Đỏ', '1', '14');
INSERT INTO `web_districts` VALUES ('405', 'Bắc Trà My', '1', '45');
INSERT INTO `web_districts` VALUES ('406', 'Vĩnh Thạnh', '1', '14');
INSERT INTO `web_districts` VALUES ('407', 'Thốt Nốt', '1', '14');
INSERT INTO `web_districts` VALUES ('408', 'Đông Giang', '1', '45');
INSERT INTO `web_districts` VALUES ('409', 'Thới Lai', '1', '14');
INSERT INTO `web_districts` VALUES ('410', 'Nam Giang', '1', '45');
INSERT INTO `web_districts` VALUES ('412', 'Phước Sơn', '1', '45');
INSERT INTO `web_districts` VALUES ('413', 'Nam Trà My', '1', '45');
INSERT INTO `web_districts` VALUES ('414', 'Bến Tre', '1', '7');
INSERT INTO `web_districts` VALUES ('415', 'Tây Giang', '1', '45');
INSERT INTO `web_districts` VALUES ('416', 'Phú Ninh', '1', '45');
INSERT INTO `web_districts` VALUES ('417', 'Nông Sơn', '1', '45');
INSERT INTO `web_districts` VALUES ('418', 'Châu Thành', '1', '7');
INSERT INTO `web_districts` VALUES ('420', 'Chợ Lách', '1', '7');
INSERT INTO `web_districts` VALUES ('421', 'Mỏ Cày Bắc', '1', '7');
INSERT INTO `web_districts` VALUES ('423', 'Giồng Trôm', '1', '7');
INSERT INTO `web_districts` VALUES ('424', 'Huế', '1', '55');
INSERT INTO `web_districts` VALUES ('425', 'Hồng Bàng', '1', '26');
INSERT INTO `web_districts` VALUES ('426', 'Bình Đại', '1', '7');
INSERT INTO `web_districts` VALUES ('427', 'Phong Điền', '1', '55');
INSERT INTO `web_districts` VALUES ('428', 'Quảng Điền', '1', '55');
INSERT INTO `web_districts` VALUES ('429', 'Ba Tri', '1', '7');
INSERT INTO `web_districts` VALUES ('430', 'Thạnh Phú', '1', '7');
INSERT INTO `web_districts` VALUES ('431', 'Hương Trà', '1', '55');
INSERT INTO `web_districts` VALUES ('432', 'Mỏ Cày Nam', '1', '7');
INSERT INTO `web_districts` VALUES ('433', 'Lê Chân', '1', '26');
INSERT INTO `web_districts` VALUES ('434', 'Phú Vang', '1', '55');
INSERT INTO `web_districts` VALUES ('435', 'Ngô Quyền', '1', '26');
INSERT INTO `web_districts` VALUES ('436', 'Hương Thuỷ', '1', '55');
INSERT INTO `web_districts` VALUES ('438', 'Kiến An', '1', '26');
INSERT INTO `web_districts` VALUES ('439', 'Phú Lộc', '1', '55');
INSERT INTO `web_districts` VALUES ('440', 'Vĩnh Long', '1', '59');
INSERT INTO `web_districts` VALUES ('442', 'Long Hồ', '1', '59');
INSERT INTO `web_districts` VALUES ('443', 'Nam Đông', '1', '55');
INSERT INTO `web_districts` VALUES ('444', 'Hải An', '1', '26');
INSERT INTO `web_districts` VALUES ('445', 'Mang Thít', '1', '59');
INSERT INTO `web_districts` VALUES ('446', 'A Lưới', '1', '55');
INSERT INTO `web_districts` VALUES ('447', 'Đồ Sơn', '1', '26');
INSERT INTO `web_districts` VALUES ('448', 'Bình Minh', '1', '59');
INSERT INTO `web_districts` VALUES ('449', 'An Lão', '1', '26');
INSERT INTO `web_districts` VALUES ('450', 'Tam Bình', '1', '59');
INSERT INTO `web_districts` VALUES ('452', 'Kiến Thụy', '1', '26');
INSERT INTO `web_districts` VALUES ('453', 'Trà Ôn', '1', '59');
INSERT INTO `web_districts` VALUES ('454', 'Đông Hà', '1', '48');
INSERT INTO `web_districts` VALUES ('455', 'Thủy Nguyên', '1', '26');
INSERT INTO `web_districts` VALUES ('456', 'An Dương', '1', '26');
INSERT INTO `web_districts` VALUES ('458', 'Tiên Lãng', '1', '26');
INSERT INTO `web_districts` VALUES ('459', 'Vĩnh Linh', '1', '48');
INSERT INTO `web_districts` VALUES ('460', 'Vĩnh Bảo', '1', '26');
INSERT INTO `web_districts` VALUES ('461', 'Gio Linh', '1', '48');
INSERT INTO `web_districts` VALUES ('462', 'Cam Lộ', '1', '48');
INSERT INTO `web_districts` VALUES ('463', 'Triệu Phong', '1', '48');
INSERT INTO `web_districts` VALUES ('464', 'Hải Lăng', '1', '48');
INSERT INTO `web_districts` VALUES ('465', 'Hướng Hoá', '1', '48');
INSERT INTO `web_districts` VALUES ('466', 'Đăk Rông', '1', '48');
INSERT INTO `web_districts` VALUES ('467', 'Cồn Cỏ', '1', '48');
INSERT INTO `web_districts` VALUES ('469', 'Đồng Hới', '1', '44');
INSERT INTO `web_districts` VALUES ('470', 'Vũng Liêm', '1', '59');
INSERT INTO `web_districts` VALUES ('471', 'Tuyên Hoá', '1', '44');
INSERT INTO `web_districts` VALUES ('472', 'Bình Tân', '1', '59');
INSERT INTO `web_districts` VALUES ('473', 'Minh Hoá', '1', '44');
INSERT INTO `web_districts` VALUES ('474', 'Quảng Trạch', '1', '44');
INSERT INTO `web_districts` VALUES ('476', 'Trà Vinh', '1', '57');
INSERT INTO `web_districts` VALUES ('477', 'Bố Trạch', '1', '44');
INSERT INTO `web_districts` VALUES ('478', 'Càng Long', '1', '57');
INSERT INTO `web_districts` VALUES ('479', 'Cầu Kè', '1', '57');
INSERT INTO `web_districts` VALUES ('480', 'Quảng Ninh', '1', '44');
INSERT INTO `web_districts` VALUES ('481', 'Tiểu Cần', '1', '57');
INSERT INTO `web_districts` VALUES ('482', 'Lệ Thuỷ', '1', '44');
INSERT INTO `web_districts` VALUES ('483', 'Châu Thành', '1', '57');
INSERT INTO `web_districts` VALUES ('484', 'Trà Cú', '1', '57');
INSERT INTO `web_districts` VALUES ('485', 'Cầu Ngang', '1', '57');
INSERT INTO `web_districts` VALUES ('487', 'Duyên Hải', '1', '57');
INSERT INTO `web_districts` VALUES ('488', 'Hà Tĩnh', '1', '24');
INSERT INTO `web_districts` VALUES ('489', 'Hồng Lĩnh', '1', '24');
INSERT INTO `web_districts` VALUES ('490', 'Cát Hải', '1', '26');
INSERT INTO `web_districts` VALUES ('492', 'Hương Sơn', '1', '24');
INSERT INTO `web_districts` VALUES ('493', 'Sóc Trăng', '1', '49');
INSERT INTO `web_districts` VALUES ('494', 'Bạch Long Vĩ', '1', '26');
INSERT INTO `web_districts` VALUES ('495', 'Đức Thọ', '1', '24');
INSERT INTO `web_districts` VALUES ('496', 'Mỹ Xuyên', '1', '49');
INSERT INTO `web_districts` VALUES ('497', 'Dương Kinh', '1', '26');
INSERT INTO `web_districts` VALUES ('498', 'Thạnh Trị', '1', '49');
INSERT INTO `web_districts` VALUES ('499', 'Nghi Xuân', '1', '24');
INSERT INTO `web_districts` VALUES ('500', 'Can Lộc', '1', '24');
INSERT INTO `web_districts` VALUES ('501', 'Cù Lao Dung', '1', '49');
INSERT INTO `web_districts` VALUES ('502', 'Ngã Năm', '1', '49');
INSERT INTO `web_districts` VALUES ('503', 'Hương Khê', '1', '24');
INSERT INTO `web_districts` VALUES ('505', 'Thạch Hà', '1', '24');
INSERT INTO `web_districts` VALUES ('506', 'Kế Sách', '1', '49');
INSERT INTO `web_districts` VALUES ('507', 'Cẩm Xuyên', '1', '24');
INSERT INTO `web_districts` VALUES ('508', 'Mỹ Tú', '1', '49');
INSERT INTO `web_districts` VALUES ('509', 'Thị Xã Kỳ Anh', '1', '24');
INSERT INTO `web_districts` VALUES ('510', 'Hải Châu', '1', '15');
INSERT INTO `web_districts` VALUES ('511', 'Long Phú', '1', '49');
INSERT INTO `web_districts` VALUES ('512', 'Vũ Quang', '1', '24');
INSERT INTO `web_districts` VALUES ('513', 'Vĩnh Châu', '1', '49');
INSERT INTO `web_districts` VALUES ('514', 'Thanh Khê', '1', '15');
INSERT INTO `web_districts` VALUES ('515', 'Lộc Hà', '1', '24');
INSERT INTO `web_districts` VALUES ('516', 'Châu Thành', '1', '49');
INSERT INTO `web_districts` VALUES ('517', 'Sơn Trà', '1', '15');
INSERT INTO `web_districts` VALUES ('518', 'Trần Đề', '1', '49');
INSERT INTO `web_districts` VALUES ('519', 'Ngũ Hành Sơn', '1', '15');
INSERT INTO `web_districts` VALUES ('521', 'Liên Chiểu', '1', '15');
INSERT INTO `web_districts` VALUES ('522', 'Vinh', '1', '39');
INSERT INTO `web_districts` VALUES ('524', 'Hoà Vang', '1', '15');
INSERT INTO `web_districts` VALUES ('525', 'Cửa Lò', '1', '39');
INSERT INTO `web_districts` VALUES ('526', 'Bạc Liêu', '1', '3');
INSERT INTO `web_districts` VALUES ('527', 'Vĩnh Lợi', '1', '3');
INSERT INTO `web_districts` VALUES ('528', 'Quỳ Châu', '1', '39');
INSERT INTO `web_districts` VALUES ('529', 'Hồng Dân', '1', '3');
INSERT INTO `web_districts` VALUES ('530', 'Quỳ Hợp', '1', '39');
INSERT INTO `web_districts` VALUES ('531', 'Giá Rai', '1', '3');
INSERT INTO `web_districts` VALUES ('532', 'Nghĩa Đàn', '1', '39');
INSERT INTO `web_districts` VALUES ('533', 'Cẩm Lệ', '1', '15');
INSERT INTO `web_districts` VALUES ('534', 'Phước Long', '1', '3');
INSERT INTO `web_districts` VALUES ('535', 'Quỳnh Lưu', '1', '39');
INSERT INTO `web_districts` VALUES ('536', 'Đông Hải', '1', '3');
INSERT INTO `web_districts` VALUES ('537', 'Kỳ Sơn', '1', '39');
INSERT INTO `web_districts` VALUES ('538', 'Hoà Bình', '1', '3');
INSERT INTO `web_districts` VALUES ('539', 'Tương Dương', '1', '39');
INSERT INTO `web_districts` VALUES ('540', 'Con Cuông', '1', '39');
INSERT INTO `web_districts` VALUES ('542', 'Tân Kỳ', '1', '39');
INSERT INTO `web_districts` VALUES ('543', 'Yên Thành', '1', '39');
INSERT INTO `web_districts` VALUES ('544', 'Diễn Châu', '1', '39');
INSERT INTO `web_districts` VALUES ('545', 'Anh Sơn', '1', '39');
INSERT INTO `web_districts` VALUES ('546', 'Đô Lương', '1', '39');
INSERT INTO `web_districts` VALUES ('547', 'Thanh Chương', '1', '39');
INSERT INTO `web_districts` VALUES ('548', 'Nghi Lộc', '1', '39');
INSERT INTO `web_districts` VALUES ('549', 'Đồng Văn', '1', '20');
INSERT INTO `web_districts` VALUES ('550', 'Mèo Vạc', '1', '20');
INSERT INTO `web_districts` VALUES ('551', 'Nam Đàn', '1', '39');
INSERT INTO `web_districts` VALUES ('553', 'Yên Minh', '1', '20');
INSERT INTO `web_districts` VALUES ('554', 'Hưng Nguyên', '1', '39');
INSERT INTO `web_districts` VALUES ('555', 'Quản Bạ', '1', '20');
INSERT INTO `web_districts` VALUES ('556', 'Vị Xuyên', '1', '20');
INSERT INTO `web_districts` VALUES ('557', 'Quế Phong', '1', '39');
INSERT INTO `web_districts` VALUES ('558', 'Bắc Mê', '1', '20');
INSERT INTO `web_districts` VALUES ('559', 'Thị xã Thái Hòa', '1', '39');
INSERT INTO `web_districts` VALUES ('560', 'Hoàng Su Phì', '1', '20');
INSERT INTO `web_districts` VALUES ('561', 'Cà Mau', '1', '12');
INSERT INTO `web_districts` VALUES ('563', 'Xín Mần', '1', '20');
INSERT INTO `web_districts` VALUES ('564', 'Thới Bình', '1', '12');
INSERT INTO `web_districts` VALUES ('565', 'Thanh Hoá', '1', '54');
INSERT INTO `web_districts` VALUES ('566', 'U Minh', '1', '12');
INSERT INTO `web_districts` VALUES ('567', 'Bắc Quang', '1', '20');
INSERT INTO `web_districts` VALUES ('568', 'Bỉm Sơn', '1', '54');
INSERT INTO `web_districts` VALUES ('569', 'Trần Văn Thời', '1', '12');
INSERT INTO `web_districts` VALUES ('570', 'Sầm Sơn', '1', '54');
INSERT INTO `web_districts` VALUES ('571', 'Quang Bình', '1', '20');
INSERT INTO `web_districts` VALUES ('572', 'Cái Nước', '1', '12');
INSERT INTO `web_districts` VALUES ('573', 'Quan Hoá', '1', '54');
INSERT INTO `web_districts` VALUES ('574', 'Quan Sơn', '1', '54');
INSERT INTO `web_districts` VALUES ('575', 'Mường Lát', '1', '54');
INSERT INTO `web_districts` VALUES ('577', 'Bá Thước', '1', '54');
INSERT INTO `web_districts` VALUES ('578', 'Cao Bằng', '1', '13');
INSERT INTO `web_districts` VALUES ('579', 'Thường Xuân', '1', '54');
INSERT INTO `web_districts` VALUES ('580', 'Bảo Lạc', '1', '13');
INSERT INTO `web_districts` VALUES ('581', 'Thông Nông', '1', '13');
INSERT INTO `web_districts` VALUES ('582', 'Như Xuân', '1', '54');
INSERT INTO `web_districts` VALUES ('583', 'Như Thanh', '1', '54');
INSERT INTO `web_districts` VALUES ('584', 'Lang Chánh', '1', '54');
INSERT INTO `web_districts` VALUES ('585', 'Ngọc Lặc', '1', '54');
INSERT INTO `web_districts` VALUES ('586', 'Thạch Thành', '1', '54');
INSERT INTO `web_districts` VALUES ('587', 'Cẩm Thủy', '1', '54');
INSERT INTO `web_districts` VALUES ('588', 'Hà Quảng', '1', '13');
INSERT INTO `web_districts` VALUES ('589', 'Thọ Xuân', '1', '54');
INSERT INTO `web_districts` VALUES ('590', 'Trà Lĩnh', '1', '13');
INSERT INTO `web_districts` VALUES ('591', 'Vĩnh Lộc', '1', '54');
INSERT INTO `web_districts` VALUES ('592', 'Thiệu Hoá', '1', '54');
INSERT INTO `web_districts` VALUES ('593', 'Triệu Sơn', '1', '54');
INSERT INTO `web_districts` VALUES ('594', 'Đầm Dơi', '1', '12');
INSERT INTO `web_districts` VALUES ('595', 'Nông Cống', '1', '54');
INSERT INTO `web_districts` VALUES ('596', 'Ngọc Hiển', '1', '12');
INSERT INTO `web_districts` VALUES ('597', 'Đông Sơn', '1', '54');
INSERT INTO `web_districts` VALUES ('598', 'Năm Căn', '1', '12');
INSERT INTO `web_districts` VALUES ('599', 'Hà Trung', '1', '54');
INSERT INTO `web_districts` VALUES ('600', 'Phú Tân', '1', '12');
INSERT INTO `web_districts` VALUES ('601', 'Hoằng Hoá', '1', '54');
INSERT INTO `web_districts` VALUES ('603', 'Nga Sơn', '1', '54');
INSERT INTO `web_districts` VALUES ('604', 'Điện Biên Phủ', '1', '69');
INSERT INTO `web_districts` VALUES ('605', 'Hậu Lộc', '1', '54');
INSERT INTO `web_districts` VALUES ('606', 'Mường Lay', '1', '69');
INSERT INTO `web_districts` VALUES ('607', 'Quảng Xương', '1', '54');
INSERT INTO `web_districts` VALUES ('608', 'Điện Biên', '1', '69');
INSERT INTO `web_districts` VALUES ('609', 'Tĩnh Gia', '1', '54');
INSERT INTO `web_districts` VALUES ('610', 'Tuần Giáo', '1', '69');
INSERT INTO `web_districts` VALUES ('611', 'Yên Định', '1', '54');
INSERT INTO `web_districts` VALUES ('612', 'Trùng Khánh', '1', '13');
INSERT INTO `web_districts` VALUES ('613', 'Mường Chà', '1', '69');
INSERT INTO `web_districts` VALUES ('614', 'Tủa Chùa', '1', '69');
INSERT INTO `web_districts` VALUES ('615', 'Nguyên Bình', '1', '13');
INSERT INTO `web_districts` VALUES ('616', 'Điện Biên Đông', '1', '69');
INSERT INTO `web_districts` VALUES ('618', 'Mường Nhé', '1', '69');
INSERT INTO `web_districts` VALUES ('619', 'Thành phố Ninh Bình', '1', '40');
INSERT INTO `web_districts` VALUES ('620', 'Mường Ảng', '1', '69');
INSERT INTO `web_districts` VALUES ('622', 'Tam Điệp', '1', '40');
INSERT INTO `web_districts` VALUES ('623', 'Nho Quan', '1', '40');
INSERT INTO `web_districts` VALUES ('624', 'Gia Viễn', '1', '40');
INSERT INTO `web_districts` VALUES ('625', 'Hoa Lư', '1', '40');
INSERT INTO `web_districts` VALUES ('626', 'Yên Mô', '1', '40');
INSERT INTO `web_districts` VALUES ('628', 'Kim Sơn', '1', '40');
INSERT INTO `web_districts` VALUES ('629', 'Gia Nghĩa', '1', '71');
INSERT INTO `web_districts` VALUES ('630', 'Yên Khánh', '1', '40');
INSERT INTO `web_districts` VALUES ('631', 'Dăk RLấp', '1', '71');
INSERT INTO `web_districts` VALUES ('632', 'Dăk Mil', '1', '71');
INSERT INTO `web_districts` VALUES ('633', 'Cư Jút', '1', '71');
INSERT INTO `web_districts` VALUES ('635', 'Hoà An', '1', '13');
INSERT INTO `web_districts` VALUES ('636', 'Dăk Song', '1', '71');
INSERT INTO `web_districts` VALUES ('637', 'Thái Bình', '1', '52');
INSERT INTO `web_districts` VALUES ('638', 'Quảng Uyên', '1', '13');
INSERT INTO `web_districts` VALUES ('639', 'Krông Nô', '1', '71');
INSERT INTO `web_districts` VALUES ('640', 'Thạch An', '1', '13');
INSERT INTO `web_districts` VALUES ('641', 'Quỳnh Phụ', '1', '52');
INSERT INTO `web_districts` VALUES ('642', 'Dăk GLong', '1', '71');
INSERT INTO `web_districts` VALUES ('643', 'Hạ Lang', '1', '13');
INSERT INTO `web_districts` VALUES ('644', 'Hưng Hà', '1', '52');
INSERT INTO `web_districts` VALUES ('645', 'Tuy Đức', '1', '71');
INSERT INTO `web_districts` VALUES ('646', 'Bảo Lâm', '1', '13');
INSERT INTO `web_districts` VALUES ('647', 'Đông Hưng', '1', '52');
INSERT INTO `web_districts` VALUES ('648', 'Phục Hoà', '1', '13');
INSERT INTO `web_districts` VALUES ('649', 'Vũ Thư', '1', '52');
INSERT INTO `web_districts` VALUES ('651', 'Kiến Xương', '1', '52');
INSERT INTO `web_districts` VALUES ('652', 'Vị Thanh', '1', '70');
INSERT INTO `web_districts` VALUES ('654', 'Vị Thuỷ', '1', '70');
INSERT INTO `web_districts` VALUES ('655', 'Tiền Hải', '1', '52');
INSERT INTO `web_districts` VALUES ('656', 'Lai Châu', '1', '33');
INSERT INTO `web_districts` VALUES ('657', 'Long Mỹ', '1', '70');
INSERT INTO `web_districts` VALUES ('658', 'Thái Thuỵ', '1', '52');
INSERT INTO `web_districts` VALUES ('659', 'Phụng Hiệp', '1', '70');
INSERT INTO `web_districts` VALUES ('660', 'Tam Đường', '1', '33');
INSERT INTO `web_districts` VALUES ('661', 'Châu Thành', '1', '70');
INSERT INTO `web_districts` VALUES ('662', 'Phong Thổ', '1', '33');
INSERT INTO `web_districts` VALUES ('663', 'Châu Thành A', '1', '70');
INSERT INTO `web_districts` VALUES ('665', 'Sìn Hồ', '1', '33');
INSERT INTO `web_districts` VALUES ('666', 'Ngã Bảy', '1', '70');
INSERT INTO `web_districts` VALUES ('667', 'Nam Định', '1', '38');
INSERT INTO `web_districts` VALUES ('668', 'Mường Tè', '1', '33');
INSERT INTO `web_districts` VALUES ('669', 'Mỹ Lộc', '1', '38');
INSERT INTO `web_districts` VALUES ('670', 'Than Uyên', '1', '33');
INSERT INTO `web_districts` VALUES ('671', 'Xuân Trường', '1', '38');
INSERT INTO `web_districts` VALUES ('672', 'Tân Uyên', '1', '33');
INSERT INTO `web_districts` VALUES ('673', 'Giao Thủy', '1', '38');
INSERT INTO `web_districts` VALUES ('674', 'Ý Yên', '1', '38');
INSERT INTO `web_districts` VALUES ('676', 'Vụ Bản', '1', '38');
INSERT INTO `web_districts` VALUES ('677', 'Lào Cai', '1', '35');
INSERT INTO `web_districts` VALUES ('678', 'Nam Trực', '1', '38');
INSERT INTO `web_districts` VALUES ('679', 'Xi Ma Cai', '1', '35');
INSERT INTO `web_districts` VALUES ('680', 'Trực Ninh', '1', '38');
INSERT INTO `web_districts` VALUES ('681', 'Bát Xát', '1', '35');
INSERT INTO `web_districts` VALUES ('682', 'Nghĩa Hưng', '1', '38');
INSERT INTO `web_districts` VALUES ('683', 'Bảo Thắng', '1', '35');
INSERT INTO `web_districts` VALUES ('684', 'Hải Hậu', '1', '38');
INSERT INTO `web_districts` VALUES ('685', 'Sa Pa', '1', '35');
INSERT INTO `web_districts` VALUES ('686', 'Văn Bàn', '1', '35');
INSERT INTO `web_districts` VALUES ('688', 'Phủ Lý', '1', '21');
INSERT INTO `web_districts` VALUES ('689', 'Duy Tiên', '1', '21');
INSERT INTO `web_districts` VALUES ('690', 'Bảo Yên', '1', '35');
INSERT INTO `web_districts` VALUES ('691', 'Kim Bảng', '1', '21');
INSERT INTO `web_districts` VALUES ('692', 'Bắc Hà', '1', '35');
INSERT INTO `web_districts` VALUES ('693', 'Lý Nhân', '1', '21');
INSERT INTO `web_districts` VALUES ('694', 'Mường Khương', '1', '35');
INSERT INTO `web_districts` VALUES ('695', 'Thanh Liêm', '1', '21');
INSERT INTO `web_districts` VALUES ('696', 'Bình Lục', '1', '21');
INSERT INTO `web_districts` VALUES ('698', 'Hoà Bình', '1', '27');
INSERT INTO `web_districts` VALUES ('699', 'Đà Bắc', '1', '27');
INSERT INTO `web_districts` VALUES ('700', 'Mai Châu', '1', '27');
INSERT INTO `web_districts` VALUES ('701', 'Tân Lạc', '1', '27');
INSERT INTO `web_districts` VALUES ('702', 'Lạc Sơn', '1', '27');
INSERT INTO `web_districts` VALUES ('703', 'Kỳ Sơn', '1', '27');
INSERT INTO `web_districts` VALUES ('704', 'Lương Sơn', '1', '27');
INSERT INTO `web_districts` VALUES ('705', 'Kim Bôi', '1', '27');
INSERT INTO `web_districts` VALUES ('706', 'Lạc Thuỷ', '1', '27');
INSERT INTO `web_districts` VALUES ('707', 'Yên Thuỷ', '1', '27');
INSERT INTO `web_districts` VALUES ('708', 'Cao Phong', '1', '27');
INSERT INTO `web_districts` VALUES ('710', 'Hưng Yên', '1', '28');
INSERT INTO `web_districts` VALUES ('711', 'Kim Động', '1', '28');
INSERT INTO `web_districts` VALUES ('712', 'Ân Thi', '1', '28');
INSERT INTO `web_districts` VALUES ('713', 'Khoái Châu', '1', '28');
INSERT INTO `web_districts` VALUES ('714', 'Yên Mỹ', '1', '28');
INSERT INTO `web_districts` VALUES ('715', 'Tiên Lữ', '1', '28');
INSERT INTO `web_districts` VALUES ('716', 'Phù Cừ', '1', '28');
INSERT INTO `web_districts` VALUES ('717', 'Mỹ Hào', '1', '28');
INSERT INTO `web_districts` VALUES ('718', 'Văn Lâm', '1', '28');
INSERT INTO `web_districts` VALUES ('719', 'Văn Giang', '1', '28');
INSERT INTO `web_districts` VALUES ('721', 'Hải Dương', '1', '25');
INSERT INTO `web_districts` VALUES ('722', 'Chí Linh', '1', '25');
INSERT INTO `web_districts` VALUES ('723', 'Nam Sách', '1', '25');
INSERT INTO `web_districts` VALUES ('724', 'Kinh Môn', '1', '25');
INSERT INTO `web_districts` VALUES ('725', 'Gia Lộc', '1', '25');
INSERT INTO `web_districts` VALUES ('726', 'Tứ Kỳ', '1', '25');
INSERT INTO `web_districts` VALUES ('727', 'Thanh Miện', '1', '25');
INSERT INTO `web_districts` VALUES ('728', 'Ninh Giang', '1', '25');
INSERT INTO `web_districts` VALUES ('729', 'Cẩm Giàng', '1', '25');
INSERT INTO `web_districts` VALUES ('730', 'Thanh Hà', '1', '25');
INSERT INTO `web_districts` VALUES ('731', 'Kim Thành', '1', '25');
INSERT INTO `web_districts` VALUES ('732', 'Bình Giang', '1', '25');
INSERT INTO `web_districts` VALUES ('734', 'Bắc Ninh', '1', '6');
INSERT INTO `web_districts` VALUES ('735', 'Yên Phong', '1', '6');
INSERT INTO `web_districts` VALUES ('736', 'Quế Võ', '1', '6');
INSERT INTO `web_districts` VALUES ('737', 'Tiên Du', '1', '6');
INSERT INTO `web_districts` VALUES ('738', 'Từ  Sơn', '1', '6');
INSERT INTO `web_districts` VALUES ('739', 'Thuận Thành', '1', '6');
INSERT INTO `web_districts` VALUES ('740', 'Gia Bình', '1', '6');
INSERT INTO `web_districts` VALUES ('741', 'Lương Tài', '1', '6');
INSERT INTO `web_districts` VALUES ('743', 'Bắc Giang', '1', '5');
INSERT INTO `web_districts` VALUES ('744', 'Yên Thế', '1', '5');
INSERT INTO `web_districts` VALUES ('745', 'Lục Ngạn', '1', '5');
INSERT INTO `web_districts` VALUES ('746', 'Sơn Động', '1', '5');
INSERT INTO `web_districts` VALUES ('747', 'Lục Nam', '1', '5');
INSERT INTO `web_districts` VALUES ('748', 'Tân Yên', '1', '5');
INSERT INTO `web_districts` VALUES ('749', 'Hiệp Hoà', '1', '5');
INSERT INTO `web_districts` VALUES ('750', 'Lạng Giang', '1', '5');
INSERT INTO `web_districts` VALUES ('751', 'Việt Yên', '1', '5');
INSERT INTO `web_districts` VALUES ('752', 'Yên Dũng', '1', '5');
INSERT INTO `web_districts` VALUES ('754', 'Hạ Long', '1', '47');
INSERT INTO `web_districts` VALUES ('755', 'Cẩm Phả', '1', '47');
INSERT INTO `web_districts` VALUES ('756', 'Uông Bí', '1', '47');
INSERT INTO `web_districts` VALUES ('757', 'Móng Cái', '1', '47');
INSERT INTO `web_districts` VALUES ('758', 'Bình Liêu', '1', '47');
INSERT INTO `web_districts` VALUES ('759', 'Đầm Hà', '1', '47');
INSERT INTO `web_districts` VALUES ('760', 'Hải Hà', '1', '47');
INSERT INTO `web_districts` VALUES ('761', 'Tiên Yên', '1', '47');
INSERT INTO `web_districts` VALUES ('762', 'Ba Chẽ', '1', '47');
INSERT INTO `web_districts` VALUES ('763', 'Đông Triều', '1', '47');
INSERT INTO `web_districts` VALUES ('764', 'Yên Hưng', '1', '47');
INSERT INTO `web_districts` VALUES ('765', 'Hoành Bồ', '1', '47');
INSERT INTO `web_districts` VALUES ('766', 'Vân Đồn', '1', '47');
INSERT INTO `web_districts` VALUES ('767', 'Cô Tô', '1', '47');
INSERT INTO `web_districts` VALUES ('769', 'Vĩnh Yên', '1', '60');
INSERT INTO `web_districts` VALUES ('770', 'Tam Dương', '1', '60');
INSERT INTO `web_districts` VALUES ('771', 'Lập Thạch', '1', '60');
INSERT INTO `web_districts` VALUES ('772', 'Vĩnh Tường', '1', '60');
INSERT INTO `web_districts` VALUES ('773', 'Yên Lạc', '1', '60');
INSERT INTO `web_districts` VALUES ('774', 'Bình Xuyên', '1', '60');
INSERT INTO `web_districts` VALUES ('775', 'Sông Lô', '1', '60');
INSERT INTO `web_districts` VALUES ('776', 'Phúc Yên', '1', '60');
INSERT INTO `web_districts` VALUES ('777', 'Tam Đảo', '1', '60');
INSERT INTO `web_districts` VALUES ('778', 'Thành phố Nha Trang', '1', '68');
INSERT INTO `web_districts` VALUES ('779', 'Huyện Vạn Ninh', '1', '68');
INSERT INTO `web_districts` VALUES ('780', 'Huyện Ninh Hoà', '1', '68');
INSERT INTO `web_districts` VALUES ('781', 'Huyện Diên Khánh', '1', '68');
INSERT INTO `web_districts` VALUES ('782', 'Huyện Khánh Vĩnh', '1', '68');
INSERT INTO `web_districts` VALUES ('783', 'Thị xã Cam Ranh', '1', '68');
INSERT INTO `web_districts` VALUES ('784', 'Huyện Khánh Sơn', '1', '68');
INSERT INTO `web_districts` VALUES ('785', 'Huyện đảo Trường Sa', '1', '68');
INSERT INTO `web_districts` VALUES ('786', 'Huyện Cam Lâm', '1', '68');
INSERT INTO `web_districts` VALUES ('787', 'Hoàng Sa', '1', '15');
INSERT INTO `web_districts` VALUES ('789', 'Ban Mê Thuột', '1', '72');
INSERT INTO `web_districts` VALUES ('790', 'Lạc Thiện', '1', '72');
INSERT INTO `web_districts` VALUES ('791', 'Đắk Song', '1', '72');
INSERT INTO `web_districts` VALUES ('792', 'Buôn Hồ', '1', '72');
INSERT INTO `web_districts` VALUES ('793', 'M&#39;Đrak', '1', '72');
INSERT INTO `web_districts` VALUES ('794', 'Phường Vĩnh Hải', '1', '68');
INSERT INTO `web_districts` VALUES ('795', 'Phường Vĩnh Phước', '1', '68');
INSERT INTO `web_districts` VALUES ('796', 'Phường Vĩnh Thọ', '1', '68');
INSERT INTO `web_districts` VALUES ('797', 'Phường Xương Huân', '1', '68');
INSERT INTO `web_districts` VALUES ('798', 'Phường Vạn Thắng', '1', '68');
INSERT INTO `web_districts` VALUES ('799', 'Phường Vạn Thạnh', '1', '68');
INSERT INTO `web_districts` VALUES ('800', 'Phường Phương Sài', '1', '68');
INSERT INTO `web_districts` VALUES ('801', 'Phường Phương Sơn', '1', '68');
INSERT INTO `web_districts` VALUES ('802', 'Phường Ngọc Hiệp', '1', '68');
INSERT INTO `web_districts` VALUES ('803', 'Phường Phước Hoà', '1', '68');
INSERT INTO `web_districts` VALUES ('804', 'Phường Phước Tân', '1', '68');
INSERT INTO `web_districts` VALUES ('805', 'Phường Phước Tiến', '1', '68');
INSERT INTO `web_districts` VALUES ('806', 'Phường Phước Hải', '1', '68');
INSERT INTO `web_districts` VALUES ('807', 'Phường Lộc Thọ', '1', '68');
INSERT INTO `web_districts` VALUES ('808', 'Phường Tân Lập', '1', '68');
INSERT INTO `web_districts` VALUES ('809', 'Phường Vĩnh Nguyên', '1', '68');
INSERT INTO `web_districts` VALUES ('810', 'Phường Vĩnh Trường', '1', '68');
INSERT INTO `web_districts` VALUES ('811', 'Phường Phước Long', '1', '68');
INSERT INTO `web_districts` VALUES ('812', 'Phường Vĩnh Hoà', '1', '68');
INSERT INTO `web_districts` VALUES ('813', 'Phường 1', '1', '67');
INSERT INTO `web_districts` VALUES ('814', 'Phường 2', '1', '67');
INSERT INTO `web_districts` VALUES ('815', 'Phường 3', '1', '67');
INSERT INTO `web_districts` VALUES ('816', 'Phường 4', '1', '67');
INSERT INTO `web_districts` VALUES ('817', 'Phường 5', '1', '67');
INSERT INTO `web_districts` VALUES ('818', 'Phường 6', '1', '67');
INSERT INTO `web_districts` VALUES ('819', 'Phường 7', '1', '67');
INSERT INTO `web_districts` VALUES ('820', 'Phường 8', '1', '67');
INSERT INTO `web_districts` VALUES ('821', 'Phường 9', '1', '67');
INSERT INTO `web_districts` VALUES ('822', 'Phường 10', '1', '67');
INSERT INTO `web_districts` VALUES ('823', 'Phường 11', '1', '67');
INSERT INTO `web_districts` VALUES ('824', 'Phường 12', '1', '67');
INSERT INTO `web_districts` VALUES ('827', 'Bắc Từ Liêm', '1', '22');
INSERT INTO `web_districts` VALUES ('829', 'Bàu Bàng', '1', '8');
INSERT INTO `web_districts` VALUES ('831', 'Bắc Tân Uyên', '1', '8');
INSERT INTO `web_districts` VALUES ('833', 'Cư M&#39;gaR', '1', '72');
INSERT INTO `web_districts` VALUES ('835', 'Cư Kuin', '1', '72');
INSERT INTO `web_districts` VALUES ('837', 'Ea H&#39;leo', '1', '72');
INSERT INTO `web_districts` VALUES ('839', 'Thạch Hóa', '1', '37');
INSERT INTO `web_districts` VALUES ('841', 'Kiến Tường', '1', '37');
INSERT INTO `web_districts` VALUES ('843', 'Thị xã Ba Đồn', '1', '44');
INSERT INTO `web_districts` VALUES ('845', 'Thành phố Hà Giang', '1', '20');
INSERT INTO `web_districts` VALUES ('847', 'Nậm Nhùm', '1', '33');
INSERT INTO `web_districts` VALUES ('849', 'Huyện Cao Lãnh', '1', '18');
INSERT INTO `web_districts` VALUES ('851', 'Thị xã Quảng Trị', '1', '48');
INSERT INTO `web_districts` VALUES ('853', 'Thị xã Hoàng Mai', '1', '39');
INSERT INTO `web_districts` VALUES ('855', 'Thị xã Quảng Yên', '1', '47');
INSERT INTO `web_districts` VALUES ('857', 'Lâm Bình', '1', '58');
INSERT INTO `web_districts` VALUES ('859', 'Huyện Kỳ Anh', '1', '24');

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
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COMMENT='Stores news content.';

-- ----------------------------
-- Records of web_info
-- ----------------------------
INSERT INTO `web_info` VALUES ('1', null, 'Thông tin chân trang bên trái', 'SITE_FOOTER_LEFT', null, '<p><strong>Tên đăng ký: </strong>Công ty Cổ truyền thông raovat30s</p>\r\n<p><strong>Tên giao dịch: </strong>Raovat30s Online JSC</p>\r\n<p><strong>Địa chỉ trụ sở: </strong>Tầng 2, Tòa nhà CT2A - KĐT Nghĩa Đô, Hoàng Quốc Việt, Cầu Giấy, Hà Nội.</p>\r\n<p><strong>Điện thoại: </strong>0913.922.986</p>\r\n<p><strong>Email: </strong><a href=\"mailto:raovat@raovat30s.vn\">raovat@raovat30s.vn</a></p>\r\n						<p><strong>Giấy chứng nhận đăng ký kinh doanh số 0305056245 do Sở Kế hoạch và Đầu tư Thành phố Hà Nội cấp ngày 22/12/2016</strong></p>\r\n', null, '1447794727', '1', '1', '', '', '');
INSERT INTO `web_info` VALUES ('2', null, 'Thông tin giới thiệu', 'SITE_INTRO', '', '', null, '1441430611', '1', '1', '', '', '');
INSERT INTO `web_info` VALUES ('9', null, 'Nội dung meta SEO trang chủ', 'SITE_SEO_HOME', '', '<p>Kh&ocirc;ng cần để nội dung...</p>\r\n', '', '1437450080', '1', '1', 'Rao vặt nhanh', 'Rao vặt nhanh', 'Rao vặt nhanh');

-- ----------------------------
-- Table structure for web_items
-- ----------------------------
DROP TABLE IF EXISTS `web_items`;
CREATE TABLE `web_items` (
  `item_id` int(11) NOT NULL AUTO_INCREMENT,
  `item_name` varchar(255) DEFAULT NULL,
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
  `time_update` int(11) DEFAULT '0',
  PRIMARY KEY (`item_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of web_items
-- ----------------------------

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of web_news
-- ----------------------------

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
