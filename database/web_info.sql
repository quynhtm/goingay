/*
Navicat MySQL Data Transfer

Source Server         : LOCALHOST
Source Server Version : 50625
Source Host           : localhost:3306
Source Database       : db_tin

Target Server Type    : MYSQL
Target Server Version : 50625
File Encoding         : 65001

Date: 2016-11-05 13:03:30
*/

SET FOREIGN_KEY_CHECKS=0;

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
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8 COMMENT='Stores news content.';

-- ----------------------------
-- Records of web_info
-- ----------------------------
INSERT INTO `web_info` VALUES ('1', '1', 'Thông tin chân trang bên trái', 'SITE_FOOTER_LEFT', null, '<p><strong>Tên đăng ký: </strong>Công ty Cổ truyền thông raovat30s</p>\r\n<p><strong>Tên giao dịch: </strong>Raovat30s Online JSC</p>\r\n<p><strong>Địa chỉ trụ sở: </strong>Tầng 2, Tòa nhà CT2A - KĐT Nghĩa Đô, Hoàng Quốc Việt, Cầu Giấy, Hà Nội.</p>\r\n<p><strong>Điện thoại: </strong>0913.922.986</p>\r\n<p><strong>Email: </strong><a href=\"mailto:raovat@raovat30s.vn\">raovat@raovat30s.vn</a></p>\r\n						<p><strong>Giấy chứng nhận đăng ký kinh doanh số 0305056245 do Sở Kế hoạch và Đầu tư Thành phố Hà Nội cấp ngày 22/12/2016</strong></p>\r\n', null, '1447794727', '1', '1', '', '', '');
INSERT INTO `web_info` VALUES ('2', '1', 'Thông tin giới thiệu', 'SITE_INTRO', null, '<p>X&atilde; hội ng&agrave;y c&agrave;ng ph&aacute;t triển, cuộc sống ng&agrave;y c&agrave;ng được n&acirc;ng cao, v&agrave; những nhu cầu tiện nghi cho cuộc sống con người cũng v&igrave; thế m&agrave; n&acirc;ng l&ecirc;n, k&egrave;m theo đ&oacute; l&agrave; những th&uacute; vui sưu tầm v&agrave; sở hữu những gi&aacute; trị nghệ thuật ng&agrave;y c&agrave;ng lớn. Phụ kiện thời trang từ xưa đến nay lu&ocirc;n l&agrave; biểu tượng của thời gian. SanPhamReDep.COM l&agrave; nơi cung cấp v&agrave; phục vụ tốt nhất về c&aacute;c loại sản phẩm gi&uacute;p kh&aacute;ch h&agrave;ng trang bị cho m&igrave;nh phụ kiện thời trang ho&agrave;n mỹ nhất.</p>\r\n\r\n<p><strong>Mọi th&ocirc;ng tin chi tiết vui l&ograve;ng li&ecirc;n hệ về:</strong></p>\r\n\r\n<p>Email hợp t&aacute;c: cskh@sanphamredep.com<br />\r\nĐịa chỉ: Số 10 - Khu đ&ocirc; thị Nam Cường - Cổ Nhuế - H&agrave; Nội<br />\r\nLi&ecirc;n hệ: 094.11.99.656(Mr.Anh)</p>\r\n', null, '1441430611', '1', '1', '', '', '');
INSERT INTO `web_info` VALUES ('4', '1', 'Thông tin liên hệ', 'SITE_CONTACT', null, '<p>X&atilde; hội ng&agrave;y c&agrave;ng ph&aacute;t triển, cuộc sống ng&agrave;y c&agrave;ng được n&acirc;ng cao, v&agrave; những nhu cầu tiện nghi cho cuộc sống con người cũng v&igrave; thế m&agrave; n&acirc;ng l&ecirc;n, k&egrave;m theo đ&oacute; l&agrave; những th&uacute; vui sưu tầm v&agrave; sở hữu những sản phẩm phục vụ cho cuộc sống ng&agrave;y c&agrave;ng lớn. SanPhamReDep.COM l&agrave; nơi cung cấp v&agrave; phục vụ tốt nhất về c&aacute;c loại sản phẩm n&agrave;y.</p>\r\n', null, '1441430633', '1', '1', 'Thông tin liên hệ', 'Thông tin liên hệ', 'Thông tin liên hệ');
INSERT INTO `web_info` VALUES ('9', '1', 'Nội dung meta SEO trang chủ', 'SITE_SEO_HOME', null, '<p>Kh&ocirc;ng cần để nội dung...</p>\r\n', '', '1437450080', '1', '1', 'Thời trang nam, thời trang nữ, thời trang trẻ em, phụ kiện thời trang, đồ gia dụng', 'Thời trang nam, thời trang nữ, thời trang trẻ em, phụ kiện thời trang, đồ gia dụng', 'Thời trang nam, thời trang nữ, thời trang trẻ em, phụ kiện thời trang, đồ gia dụng');
