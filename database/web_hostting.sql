/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : db_tin

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2017-02-03 17:29:13
*/

SET FOREIGN_KEY_CHECKS=0;

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
