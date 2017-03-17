/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : db_tin

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2017-02-25 12:05:58
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for web_money
-- ----------------------------
DROP TABLE IF EXISTS `web_money`;
CREATE TABLE `web_money` (
  `money_id` int(11) NOT NULL AUTO_INCREMENT,
  `money_id_first` int(11) DEFAULT '0',
  `money_name` varchar(255) DEFAULT NULL,
  `money_price` int(12) DEFAULT NULL,
  `money_total_price` int(12) DEFAULT '0' COMMENT 'Tiền còn lại',
  `money_type` tinyint(2) DEFAULT '1' COMMENT '1: nhập ,2: xuất',
  `money_infor` mediumtext COMMENT 'thông tin thêm của web',
  `money_time_creater` int(12) DEFAULT NULL,
  `money_time_update` int(12) DEFAULT NULL,
  `money_log` text,
  PRIMARY KEY (`money_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of web_money
-- ----------------------------
