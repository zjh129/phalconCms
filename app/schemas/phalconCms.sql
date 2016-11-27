/*
Navicat MySQL Data Transfer

Source Server         : utf8
Source Server Version : 80000
Source Host           : 172.17.0.2:3306
Source Database       : phalconCms

Target Server Type    : MYSQL
Target Server Version : 80000
File Encoding         : 65001

Date: 2016-11-17 10:56:07
*/

SET FOREIGN_KEY_CHECKS=0;

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
INSERT INTO `users` VALUES ('1', 'admin', '$2y$12$WjZHZ2MzZUwvazFFTFdqQO82xTjo5N2VOwemsou.zzBdo5WnLq54m', '千寻', 'zhaojianhui129@163.com', '', 'W', '0', '1', '0', '2016-10-18 07:27:38', '2016-10-18 15:12:21');
SET FOREIGN_KEY_CHECKS=1;
