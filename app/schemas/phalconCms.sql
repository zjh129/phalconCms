/*
Navicat MySQL Data Transfer

Source Server         : local-utf8
Source Server Version : 80000
Source Host           : 172.17.0.2:3306
Source Database       : phalconCms

Target Server Type    : MYSQL
Target Server Version : 80000
File Encoding         : 65001

Date: 2016-12-23 15:00:46
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for files
-- ----------------------------
DROP TABLE IF EXISTS `files`;
CREATE TABLE `files` (
  `file_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '文件序号',
  `user_id` int(11) NOT NULL COMMENT '用户ID',
  `type` varchar(10) NOT NULL COMMENT '文件类别',
  `uploadType` varchar(10) NOT NULL COMMENT '文件上传方式',
  `url` varchar(200) NOT NULL COMMENT '访问路径',
  `fileName` varchar(100) NOT NULL COMMENT '新文件名',
  `oriName` varchar(100) NOT NULL COMMENT '文件原名',
  `fileExt` varchar(10) NOT NULL COMMENT '文件扩展名',
  `size` int(5) NOT NULL COMMENT '文件大小',
  `create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '上传时间\r\n',
  PRIMARY KEY (`file_id`),
  UNIQUE KEY `id` (`file_id`),
  KEY `fileListIndex` (`user_id`,`type`,`create_at`) USING BTREE COMMENT '文件管理列表索引\r\n'
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=utf8 COMMENT='文件信息表';

-- ----------------------------
-- Records of files
-- ----------------------------
INSERT INTO `files` VALUES ('31', '1', 'image', 'qiniu', 'http://ofcalqdk5.bkt.clouddn.com/ueditor/php/upload/image/20161223/1482463973697788.jpg', 'ueditor/php/upload/image/20161223/1482463973697788.jpg', '174233_IJ0T_1428332.jpg', '.jpg', '65800', '2016-12-23 03:32:53');
INSERT INTO `files` VALUES ('32', '1', 'image', 'qiniu', 'http://ofcalqdk5.bkt.clouddn.com/ueditor/php/upload/image/20161223/1482463973320149.jpg', 'ueditor/php/upload/image/20161223/1482463973320149.jpg', '173210_huVR_1428332.jpg', '.jpg', '71997', '2016-12-23 03:32:53');
INSERT INTO `files` VALUES ('33', '1', 'image', 'qiniu', 'http://ofcalqdk5.bkt.clouddn.com/ueditor/php/upload/image/20161223/1482463973465494.jpg', 'ueditor/php/upload/image/20161223/1482463973465494.jpg', '190741_wdZi_1428332.jpg', '.jpg', '140146', '2016-12-23 03:32:53');
INSERT INTO `files` VALUES ('34', '1', 'image', 'qiniu', 'http://ofcalqdk5.bkt.clouddn.com/ueditor/php/upload/image/20161223/1482463973896880.jpg', 'ueditor/php/upload/image/20161223/1482463973896880.jpg', '192326_7hjm_1428332.jpg', '.jpg', '76021', '2016-12-23 03:32:53');
INSERT INTO `files` VALUES ('35', '1', 'image', 'qiniu', 'http://ofcalqdk5.bkt.clouddn.com/ueditor/php/upload/image/20161223/1482463973318370.jpg', 'ueditor/php/upload/image/20161223/1482463973318370.jpg', '194238_rgNV_229201.jpg', '.jpg', '104141', '2016-12-23 03:32:53');
INSERT INTO `files` VALUES ('36', '1', 'image', 'qiniu', 'http://ofcalqdk5.bkt.clouddn.com/ueditor/php/upload/image/20161223/1482463973553709.jpg', 'ueditor/php/upload/image/20161223/1482463973553709.jpg', '194733_5vXt_1428332.jpg', '.jpg', '213541', '2016-12-23 03:32:53');
INSERT INTO `files` VALUES ('37', '1', 'image', 'qiniu', 'http://ofcalqdk5.bkt.clouddn.com/ueditor/php/upload/image/20161223/1482463973865674.jpg', 'ueditor/php/upload/image/20161223/1482463973865674.jpg', '202033_fkug_1428332.jpg', '.jpg', '83499', '2016-12-23 03:32:54');
INSERT INTO `files` VALUES ('38', '1', 'image', 'qiniu', 'http://ofcalqdk5.bkt.clouddn.com/ueditor/php/upload/image/20161223/1482463973551701.jpg', 'ueditor/php/upload/image/20161223/1482463973551701.jpg', '210058_1Z5G_1428332.jpg', '.jpg', '67347', '2016-12-23 03:32:54');
INSERT INTO `files` VALUES ('39', '1', 'image', 'qiniu', 'http://ofcalqdk5.bkt.clouddn.com/ueditor/php/upload/image/20161223/1482463973540082.jpg', 'ueditor/php/upload/image/20161223/1482463973540082.jpg', '204011_DFwc_1428332.jpg', '.jpg', '273175', '2016-12-23 03:32:55');
INSERT INTO `files` VALUES ('40', '1', 'video', 'qiniu', 'http://ofcalqdk5.bkt.clouddn.com/ueditor/php/upload/video/20161223/1482464020848695.rmvb', 'ueditor/php/upload/video/20161223/1482464020848695.rmvb', '112.rmvb', '.rmvb', '115176047', '2016-12-23 03:39:08');
INSERT INTO `files` VALUES ('41', '1', 'file', 'qiniu', 'http://ofcalqdk5.bkt.clouddn.com/ueditor/php/upload/file/20161223/1482464467376646.xls', 'ueditor/php/upload/file/20161223/1482464467376646.xls', '赵建辉_工作计划_2016-12-12.xls', '.xls', '22016', '2016-12-23 03:41:07');
INSERT INTO `files` VALUES ('42', '1', 'file', 'qiniu', 'http://ofcalqdk5.bkt.clouddn.com/ueditor/php/upload/file/20161223/1482464467196494.xls', 'ueditor/php/upload/file/20161223/1482464467196494.xls', '赵建辉_工作计划_2016-12-19.xls', '.xls', '15360', '2016-12-23 03:41:07');
INSERT INTO `files` VALUES ('43', '1', 'file', 'qiniu', 'http://ofcalqdk5.bkt.clouddn.com/ueditor/php/upload/file/20161223/1482464551559030.jpg', 'ueditor/php/upload/file/20161223/1482464551559030.jpg', '字根.jpg', '.jpg', '661895', '2016-12-23 03:42:32');
INSERT INTO `files` VALUES ('44', '1', 'image', 'qiniu', 'http://ofcalqdk5.bkt.clouddn.com/ueditor/php/upload/image/20161223/1482464584233016.png', '1482464584233016.png', 'scrawl.png', '.png', '9806', '2016-12-23 03:43:04');
INSERT INTO `files` VALUES ('45', '1', 'image', 'qiniu', 'http://ofcalqdk5.bkt.clouddn.com/ueditor/php/upload/image/20161223/1482464833845063.jpg', '1482464833845063.jpg', '192326_7hjm_1428332.jpg', '.jpg', '76021', '2016-12-23 03:47:13');
INSERT INTO `files` VALUES ('46', '1', 'image', 'qiniu', 'http://ofcalqdk5.bkt.clouddn.com/ueditor/php/upload/image/20161223/1482473354458840.jpg', '1482473354458840.jpg', '194238_rgNV_229201.jpg', '.jpg', '104141', '2016-12-23 06:09:14');
INSERT INTO `files` VALUES ('47', '1', 'image', 'qiniu', 'http://ofcalqdk5.bkt.clouddn.com/ueditor/php/upload/image/20161223/1482473359521258.jpg', '1482473359521258.jpg', '210058_1Z5G_1428332.jpg', '.jpg', '67347', '2016-12-23 06:09:19');

-- ----------------------------
-- Table structure for menus
-- ----------------------------
DROP TABLE IF EXISTS `menus`;
CREATE TABLE `menus` (
  `menu_id` int(10) NOT NULL AUTO_INCREMENT COMMENT '菜单ID',
  `parent_id` int(10) NOT NULL DEFAULT '0' COMMENT '父级菜单ID',
  `module_name` varchar(20) NOT NULL COMMENT '模块名称',
  `resource_id` int(10) NOT NULL DEFAULT '0' COMMENT '绑定资源ID',
  `order_num` tinyint(2) NOT NULL COMMENT '排序',
  `create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`menu_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='菜单表';

-- ----------------------------
-- Records of menus
-- ----------------------------

-- ----------------------------
-- Table structure for resources
-- ----------------------------
DROP TABLE IF EXISTS `resources`;
CREATE TABLE `resources` (
  `resource_id` int(10) NOT NULL AUTO_INCREMENT COMMENT '资源ID',
  `parent_id` int(10) NOT NULL DEFAULT '0' COMMENT '父资源ID',
  `module_name` varchar(20) NOT NULL COMMENT '模块名称',
  `resource_name` varchar(20) NOT NULL COMMENT '资源名称',
  `resource_key` varchar(50) NOT NULL COMMENT '资源KEY',
  `icon_class` varchar(30) NOT NULL COMMENT '资源icon样式',
  `url` varchar(50) NOT NULL COMMENT '访问路径',
  `type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '资源类别(1:资源，2:操作)',
  `is_public` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否',
  `order_num` tinyint(2) NOT NULL DEFAULT '0' COMMENT '排序',
  `create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`resource_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='访问资源表';

-- ----------------------------
-- Records of resources
-- ----------------------------

-- ----------------------------
-- Table structure for roles
-- ----------------------------
DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles` (
  `role_id` int(10) NOT NULL AUTO_INCREMENT COMMENT '角色ID',
  `role_name` varchar(50) NOT NULL COMMENT '角色名',
  `role_key` varchar(20) NOT NULL COMMENT '角色KEY',
  `create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '时间时间',
  PRIMARY KEY (`role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='角色表';

-- ----------------------------
-- Records of roles
-- ----------------------------
INSERT INTO `roles` VALUES ('1', '超级管理员', 'supperAdmin', '2016-11-11 10:45:38');

-- ----------------------------
-- Table structure for user_logs
-- ----------------------------
DROP TABLE IF EXISTS `user_logs`;
CREATE TABLE `user_logs` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `user_id` int(10) NOT NULL,
  `account` varchar(50) NOT NULL COMMENT '用户账号',
  `login_ip` varchar(40) NOT NULL COMMENT '登录IP',
  `login_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '登录时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户登录日志表';

-- ----------------------------
-- Records of user_logs
-- ----------------------------

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `user_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户ID',
  `account` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT '用户账号',
  `password` varchar(100) COLLATE utf8_unicode_ci NOT NULL COMMENT '密码',
  `nick_name` varchar(120) COLLATE utf8_unicode_ci NOT NULL COMMENT '用户名称',
  `email` varchar(70) COLLATE utf8_unicode_ci NOT NULL COMMENT '邮箱',
  `phone` varchar(20) COLLATE utf8_unicode_ci NOT NULL COMMENT '手机号',
  `user_image` varchar(150) COLLATE utf8_unicode_ci NOT NULL COMMENT '用户头像',
  `login_error_times` tinyint(1) NOT NULL DEFAULT '0' COMMENT '登录错误次数',
  `active` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否激活',
  `role_id` tinyint(2) NOT NULL DEFAULT '0' COMMENT '用户角色ID',
  `modify_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '修改时间',
  `create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `accountIndex` (`account`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='用户信息表';

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES ('1', 'admin', '$2y$12$b2VYRHNlL25jMEkxSFBPZOdWaG3KC.HOrJjBv5EhOV4OWLdxcPvXC', '千寻', 'zhaojianhui129@163.com', '', 'W', '0', '1', '0', '2016-12-04 12:41:51', '2016-10-18 15:12:21');
SET FOREIGN_KEY_CHECKS=1;
