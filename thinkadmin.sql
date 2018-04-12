/*
Navicat MySQL Data Transfer

Source Server         : 127.0.0.1
Source Server Version : 50540
Source Host           : 127.0.0.1:3306
Source Database       : thinkadmin

Target Server Type    : MYSQL
Target Server Version : 50540
File Encoding         : 65001

Date: 2018-04-12 22:27:56
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `think_auth_group`
-- ----------------------------
DROP TABLE IF EXISTS `think_auth_group`;
CREATE TABLE `think_auth_group` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `title` char(100) NOT NULL DEFAULT '',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `rules` char(80) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='用户组表';

-- ----------------------------
-- Records of think_auth_group
-- ----------------------------
INSERT INTO `think_auth_group` VALUES ('1', '管理组', '1', '1,2');

-- ----------------------------
-- Table structure for `think_auth_group_access`
-- ----------------------------
DROP TABLE IF EXISTS `think_auth_group_access`;
CREATE TABLE `think_auth_group_access` (
  `uid` mediumint(8) unsigned NOT NULL,
  `group_id` mediumint(8) unsigned NOT NULL,
  UNIQUE KEY `uid_group_id` (`uid`,`group_id`),
  KEY `uid` (`uid`),
  KEY `group_id` (`group_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='用户组明细表';

-- ----------------------------
-- Records of think_auth_group_access
-- ----------------------------
INSERT INTO `think_auth_group_access` VALUES ('1', '1');
INSERT INTO `think_auth_group_access` VALUES ('1', '2');

-- ----------------------------
-- Table structure for `think_auth_rule`
-- ----------------------------
DROP TABLE IF EXISTS `think_auth_rule`;
CREATE TABLE `think_auth_rule` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` mediumint(9) DEFAULT '0',
  `pth` varchar(30) DEFAULT '' COMMENT '记录菜单的层级关系',
  `name` char(80) NOT NULL DEFAULT '',
  `title` char(20) NOT NULL DEFAULT '',
  `type` tinyint(1) NOT NULL DEFAULT '1',
  `sort` tinyint(4) DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1:显示 0:隐藏',
  `condition` char(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=33 DEFAULT CHARSET=utf8 COMMENT='规则表';

-- ----------------------------
-- Records of think_auth_rule
-- ----------------------------
INSERT INTO `think_auth_rule` VALUES ('1', '0', '0,1', '', '控制台', '1', '0', '1', '');
INSERT INTO `think_auth_rule` VALUES ('2', '1', '0,1,2', 'adminer/index/welcome', '欢迎', '1', '0', '1', '');
INSERT INTO `think_auth_rule` VALUES ('3', '1', '0,1,3', '', '缓存', '1', '0', '1', '');
INSERT INTO `think_auth_rule` VALUES ('4', '1', '0,1,4', '', '报表', '1', '0', '1', '');
INSERT INTO `think_auth_rule` VALUES ('5', '1', '0,1,5', '', '备份', '1', '0', '1', '');
INSERT INTO `think_auth_rule` VALUES ('6', '0', '0,6', '', '站务管理', '1', '1', '1', '');
INSERT INTO `think_auth_rule` VALUES ('7', '6', '0,6,7', '', '网站菜单', '1', '0', '1', '');
INSERT INTO `think_auth_rule` VALUES ('8', '6', '0,6,8', '', '新闻', '1', '0', '1', '');
INSERT INTO `think_auth_rule` VALUES ('9', '6', '0,6,9', '', '广告', '1', '0', '1', '');
INSERT INTO `think_auth_rule` VALUES ('10', '6', '0,6,10', '', '友链', '1', '0', '1', '');
INSERT INTO `think_auth_rule` VALUES ('11', '0', '0,11', '', '会员服务', '1', '2', '1', '');
INSERT INTO `think_auth_rule` VALUES ('12', '11', '0,11,12', '', '用户管理', '1', '0', '1', '');
INSERT INTO `think_auth_rule` VALUES ('13', '11', '0,11,13', '', '短信管理', '1', '0', '1', '');
INSERT INTO `think_auth_rule` VALUES ('14', '0', '0,14', '', '系统', '1', '3', '1', '');
INSERT INTO `think_auth_rule` VALUES ('15', '14', '0,14,15', '', '设置', '1', '0', '1', '');
INSERT INTO `think_auth_rule` VALUES ('16', '14', '0,14,16', 'adminer/system/menuList', '菜单', '1', '0', '1', '');
INSERT INTO `think_auth_rule` VALUES ('17', '14', '0,14,17', '', '权限', '1', '0', '1', '');
INSERT INTO `think_auth_rule` VALUES ('18', '17', '0,14,17,18', 'adminer/member/index', '管理员', '1', '0', '1', '');
INSERT INTO `think_auth_rule` VALUES ('19', '14', '0,14,19', '', '日志', '1', '0', '1', '');
INSERT INTO `think_auth_rule` VALUES ('20', '1', '0,1,20', '', '运维', '1', '0', '1', '');
INSERT INTO `think_auth_rule` VALUES ('21', '0', '0,21', '', '其他', '1', '4', '1', '');
INSERT INTO `think_auth_rule` VALUES ('22', '21', '0,21,22', '', '游戏', '1', '0', '1', '');
INSERT INTO `think_auth_rule` VALUES ('23', '22', '0,21,22,23', '', '小转盘', '1', '0', '1', '');
INSERT INTO `think_auth_rule` VALUES ('24', '22', '0,21,22,24', '', '大转盘', '1', '0', '1', '');
INSERT INTO `think_auth_rule` VALUES ('32', '17', '0,14,17,32', 'adminer/group/index', '角色', '1', '0', '1', '');

-- ----------------------------
-- Table structure for `think_auth_user`
-- ----------------------------
DROP TABLE IF EXISTS `think_auth_user`;
CREATE TABLE `think_auth_user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` char(32) NOT NULL,
  `phone` char(11) NOT NULL COMMENT '操作管理员的手机号码',
  `salt` varchar(8) NOT NULL DEFAULT '' COMMENT '随机因子',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '状态 1:启用 0:禁止',
  `super` tinyint(1) DEFAULT '0' COMMENT '1:超级管理员 0:普通管理员',
  `remark` varchar(255) NOT NULL COMMENT '备注说明',
  `create_at` datetime DEFAULT NULL COMMENT '创建时间',
  `last_login_time` datetime NOT NULL COMMENT '最后登录时间',
  `last_login_ip` varchar(15) NOT NULL DEFAULT '0' COMMENT '最后登录IP',
  `last_location` varchar(100) NOT NULL DEFAULT '0' COMMENT '最后登录位置',
  PRIMARY KEY (`id`),
  KEY `username` (`username`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='AUTH-权限管理-后台管理员用户表';

-- ----------------------------
-- Records of think_auth_user
-- ----------------------------
INSERT INTO `think_auth_user` VALUES ('1', 'admin', '1fd94b7170dc92c3a7bb642446fc5d30', '', 'AQ2re5', '1', '1', '超级管理员', '2018-04-12 20:27:20', '0000-00-00 00:00:00', '0', '0');
