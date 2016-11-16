/*
Navicat MySQL Data Transfer

Source Server         : LOCALHOST
Source Server Version : 50625
Source Host           : localhost:3306
Source Database       : db_tin

Target Server Type    : MYSQL
Target Server Version : 50625
File Encoding         : 65001

Date: 2016-11-06 20:34:57
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for web_provice
-- ----------------------------
DROP TABLE IF EXISTS `web_provice`;
CREATE TABLE `web_provice` (
  `provice_id` int(10) NOT NULL AUTO_INCREMENT,
  `provice_title` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `provice_created` int(10) DEFAULT NULL,
  `provice_order_no` int(10) DEFAULT NULL,
  `provice_status` tinyint(2) DEFAULT NULL,
  PRIMARY KEY (`provice_id`)
) ENGINE=MyISAM AUTO_INCREMENT=247 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ----------------------------
-- Records of web_provice
-- ----------------------------
INSERT INTO `web_provice` VALUES ('31', 'Hồ Chí Minh', '1447081074', '2', '1');
INSERT INTO `web_provice` VALUES ('56', 'Hải Phòng', '1448631842', '3', '1');
INSERT INTO `web_provice` VALUES ('72', 'Phú Thọ', '1448631819', '4', '1');
INSERT INTO `web_provice` VALUES ('87', 'Bình Dương', '1448631151', '5', '1');
INSERT INTO `web_provice` VALUES ('96', 'Đà Nẵng', '1447080350', '6', '1');
INSERT INTO `web_provice` VALUES ('105', 'Long an', '1448631805', '7', '1');
INSERT INTO `web_provice` VALUES ('121', 'Bà Rịa Vũng Tàu', '1448631876', '8', '1');
INSERT INTO `web_provice` VALUES ('130', 'An Giang', '1448631021', '9', '1');
INSERT INTO `web_provice` VALUES ('142', 'Bắc Giang', '1448631059', '10', '1');
INSERT INTO `web_provice` VALUES ('153', 'Bắc Kạn', '1448631088', '11', '1');
INSERT INTO `web_provice` VALUES ('162', 'Bạc Liêu', '1448631099', '11', '1');
INSERT INTO `web_provice` VALUES ('170', 'Bắc Ninh', '1448631116', '13', '1');
INSERT INTO `web_provice` VALUES ('179', 'Bến Tre', '1448631127', '14', '1');
INSERT INTO `web_provice` VALUES ('189', 'Bình Định', '1448631164', '15', '1');
INSERT INTO `web_provice` VALUES ('194', 'Bình Phước', '1448631187', '16', '1');
INSERT INTO `web_provice` VALUES ('195', 'Bình Thuận', '1448631196', '17', '1');
INSERT INTO `web_provice` VALUES ('196', 'Cà Mau', '1448631205', '18', '1');
INSERT INTO `web_provice` VALUES ('197', 'Cần Thơ', '1448631214', '19', '1');
INSERT INTO `web_provice` VALUES ('198', 'Cao Bằng', '1448631222', '20', '1');
INSERT INTO `web_provice` VALUES ('199', 'Đắk Lắk', '1448631231', '21', '1');
INSERT INTO `web_provice` VALUES ('200', 'Đắk Nông', '1448631241', '22', '1');
INSERT INTO `web_provice` VALUES ('201', 'Điện Biên', '1448631250', '23', '1');
INSERT INTO `web_provice` VALUES ('202', 'Đồng Nai', '1448631259', '24', '1');
INSERT INTO `web_provice` VALUES ('203', 'Đồng Tháp', '1448631348', '25', '1');
INSERT INTO `web_provice` VALUES ('204', 'Gia Lai', '1448631355', '26', '1');
INSERT INTO `web_provice` VALUES ('205', 'Hà Giang', '1448631364', '27', '1');
INSERT INTO `web_provice` VALUES ('206', 'Hà Nam', '1448631947', '28', '1');
INSERT INTO `web_provice` VALUES ('207', 'Hà Tĩnh', '1448631388', '29', '1');
INSERT INTO `web_provice` VALUES ('208', 'Hải Dương', '1448631399', '30', '1');
INSERT INTO `web_provice` VALUES ('209', 'Hậu Giang', '1448631424', '31', '1');
INSERT INTO `web_provice` VALUES ('210', 'Hòa Bình', '1448631434', '32', '1');
INSERT INTO `web_provice` VALUES ('211', 'Hưng Yên', '1448631443', '33', '1');
INSERT INTO `web_provice` VALUES ('212', 'Khánh Hòa', '1448631451', '34', '1');
INSERT INTO `web_provice` VALUES ('213', 'Kiên Giang', '1448631459', '35', '1');
INSERT INTO `web_provice` VALUES ('214', 'Kon Tum', '1448631468', '36', '1');
INSERT INTO `web_provice` VALUES ('215', 'Lai Châu', '1448631476', '37', '1');
INSERT INTO `web_provice` VALUES ('216', 'Lâm Đồng', '1448631485', '38', '1');
INSERT INTO `web_provice` VALUES ('217', 'Lạng Sơn', '1448631495', '39', '1');
INSERT INTO `web_provice` VALUES ('218', 'Lào Cai', '1448631504', '40', '1');
INSERT INTO `web_provice` VALUES ('219', 'Nam Định', '1448631526', '41', '1');
INSERT INTO `web_provice` VALUES ('220', 'Nghệ An', '1448631535', '42', '1');
INSERT INTO `web_provice` VALUES ('221', 'Ninh Bình', '1448631543', '43', '1');
INSERT INTO `web_provice` VALUES ('222', 'Ninh Thuận', '1448631552', '44', '1');
INSERT INTO `web_provice` VALUES ('223', 'Phú Yên', '1448631561', '45', '1');
INSERT INTO `web_provice` VALUES ('224', 'Quảng Bình', '1448631586', '46', '1');
INSERT INTO `web_provice` VALUES ('225', 'Quảng Nam', '1448631593', '47', '1');
INSERT INTO `web_provice` VALUES ('226', 'Quảng Ngãi', '1448631603', '48', '1');
INSERT INTO `web_provice` VALUES ('227', 'Quảng Ninh', '1448631611', '49', '1');
INSERT INTO `web_provice` VALUES ('228', 'Quảng Trị', '1448631973', '50', '1');
INSERT INTO `web_provice` VALUES ('229', 'Sóc Trăng', '1448631620', '51', '1');
INSERT INTO `web_provice` VALUES ('230', 'Sơn La', '1457152307', '52', '1');
INSERT INTO `web_provice` VALUES ('231', 'Tây Ninh', '1448631639', '54', '1');
INSERT INTO `web_provice` VALUES ('232', 'Thái Bình', '1448631647', '55', '1');
INSERT INTO `web_provice` VALUES ('233', 'Thái Nguyên', '1448631655', '56', '1');
INSERT INTO `web_provice` VALUES ('234', 'Thanh Hóa', '1448631676', '57', '1');
INSERT INTO `web_provice` VALUES ('235', 'Thừa Thiên Huế', '1448631685', '58', '1');
INSERT INTO `web_provice` VALUES ('236', 'Tiền Giang', '1448631693', '59', '1');
INSERT INTO `web_provice` VALUES ('237', 'Trà Vinh', '1448631701', '60', '1');
INSERT INTO `web_provice` VALUES ('238', 'Tuyên Quang', '1448631724', '61', '1');
INSERT INTO `web_provice` VALUES ('239', 'Vĩnh Long', '1448631747', '62', '1');
INSERT INTO `web_provice` VALUES ('240', 'Vĩnh Phúc', '1448631756', '63', '1');
INSERT INTO `web_provice` VALUES ('241', 'Yên Bái', '1448631765', '64', '1');
INSERT INTO `web_provice` VALUES ('1', 'Hà Nội', '1448631909', '1', '1');
