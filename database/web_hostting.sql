/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : db_tin

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2017-02-03 11:32:35
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
  `web_note` mediumtext,
  `web_domain` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`web_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of web_hostting
-- ----------------------------
