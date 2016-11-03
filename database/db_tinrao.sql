/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : db_tin

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2016-11-03 15:27:53
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
INSERT INTO `user` VALUES ('2', 'admin', 'eef828faf0754495136af05c051766cb', 'Root', '', null, '1', '1', '1478161192', '::1', null, null, null, null, null, null);
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
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of web_banner
-- ----------------------------

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
-- Table structure for web_items
-- ----------------------------
DROP TABLE IF EXISTS `web_items`;
CREATE TABLE `web_items` (
  `product_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_code` varchar(255) DEFAULT NULL,
  `product_name` varchar(255) DEFAULT NULL,
  `product_price_sell` int(11) DEFAULT '0' COMMENT 'Giá bán',
  `product_price_market` int(11) DEFAULT '0' COMMENT 'Giá thị trường',
  `product_price_input` int(11) DEFAULT '0' COMMENT 'giá nhập',
  `product_type_price` tinyint(5) DEFAULT '1' COMMENT 'Kiểu hiển thị giá bán: 1:hiển thị giá số, 2: hiển thị giá liên hệ',
  `product_selloff` varchar(255) DEFAULT NULL COMMENT 'text thông báo thông tin giảm giá, sp dinh kèm, khuyến mại...',
  `product_is_hot` tinyint(5) DEFAULT '0' COMMENT '0: SP bthuong,1:sản phẩm nổi bật,2:sản phẩm giảm giá....',
  `product_sort_desc` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci COMMENT 'mô tả ngắn',
  `product_content` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci COMMENT 'nội dung sản phẩm',
  `product_image` varchar(255) DEFAULT NULL COMMENT 'ảnh SP chính ',
  `product_image_hover` varchar(255) DEFAULT NULL COMMENT 'ảnh khi hover chuột vào SP',
  `product_image_other` longtext COMMENT 'danh sach ảnh khác',
  `product_order` int(10) DEFAULT '100' COMMENT 'sắp xếp hiển thị sản phẩm ở trang list',
  `category_id` int(11) DEFAULT NULL,
  `category_name` varchar(255) DEFAULT NULL,
  `quality_input` int(11) DEFAULT '0' COMMENT 'Số lượng nhập hàng',
  `quality_out` int(11) DEFAULT '0' COMMENT 'Số lượng đã xuất',
  `product_status` tinyint(5) DEFAULT '1' COMMENT '0:ẩn, 1:hiện,',
  `is_block` tinyint(5) DEFAULT '1' COMMENT '0: bị khóa, 1: không bị khóa',
  `user_shop_id` int(11) DEFAULT '0' COMMENT 'Id user shop',
  `user_shop_name` varchar(255) DEFAULT NULL COMMENT 'Tên shop tạo sản phẩm',
  `is_shop` tinyint(5) DEFAULT '0' COMMENT '0: sp của shop thường, 1: sản phẩm của shop vip',
  `is_sale` tinyint(2) DEFAULT '1' COMMENT '0: hết hàng: 1 còn hàng',
  `provider_id` int(11) DEFAULT NULL COMMENT 'ID nhà cung cấp',
  `shop_province` int(10) DEFAULT NULL COMMENT 'Tỉnh thành của shop',
  `time_created` int(11) DEFAULT NULL,
  `time_update` int(11) DEFAULT NULL,
  PRIMARY KEY (`product_id`)
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
) ENGINE=InnoDB AUTO_INCREMENT=73 DEFAULT CHARSET=utf8;

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
INSERT INTO `web_province` VALUES ('70', 'Hậu Giang', '0', '0', '0');
INSERT INTO `web_province` VALUES ('71', 'Đắk Nông', '0', '0', '0');
INSERT INTO `web_province` VALUES ('72', 'Đắk Lắc', '0', '0', '0');
