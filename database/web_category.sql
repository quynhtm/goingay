/*
Navicat MySQL Data Transfer

Source Server         : LOCALHOST
Source Server Version : 50625
Source Host           : localhost:3306
Source Database       : db_tin

Target Server Type    : MYSQL
Target Server Version : 50625
File Encoding         : 65001

Date: 2016-11-29 16:15:45
*/

SET FOREIGN_KEY_CHECKS=0;

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
INSERT INTO `web_category` VALUES ('257', 'Tuyển sinh - Tuyển dụng', '0', '1', '5', '1', null, 'fa fa-mortar-board', '5');
INSERT INTO `web_category` VALUES ('258', 'Điện thoại - Sim', '0', '1', '6', '1', null, 'fa fa-mobile-phone', '6');
INSERT INTO `web_category` VALUES ('259', 'PC - Laptop', '0', '1', '7', '1', null, 'fa fa-laptop', '7');
INSERT INTO `web_category` VALUES ('260', 'Điện tử - Kỹ thuật số', '0', '1', '8', '1', null, 'fa fa-desktop', '8');
INSERT INTO `web_category` VALUES ('261', 'Thời trang - Làm đẹp', '0', '1', '9', '1', null, 'fa fa-child', '9');
INSERT INTO `web_category` VALUES ('262', 'Ẩm thực - Du lịch', '0', '1', '10', '1', null, 'fa fa-cutlery', '10');
INSERT INTO `web_category` VALUES ('263', 'Dịch vụ', '0', '1', '11', '1', null, 'fa fa-dropbox', '11');
INSERT INTO `web_category` VALUES ('264', 'Khác', '0', '1', '12', '1', null, 'fa fa-asterisk', '12');
