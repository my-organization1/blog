/*
Navicat MySQL Data Transfer

Source Server         : 127.0.0.1
Source Server Version : 50611
Source Host           : localhost:3306
Source Database       : blog

Target Server Type    : MYSQL
Target Server Version : 50611
File Encoding         : 65001

Date: 2015-07-27 17:53:38
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for think_admin
-- ----------------------------
DROP TABLE IF EXISTS `think_admin`;
CREATE TABLE `think_admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'æ€§åˆ« 1-ç”· 2-å¥³ 3-ä¿å¯†',
  `group_id` int(11) DEFAULT NULL,
  `username` varchar(64) NOT NULL,
  `nickname` varchar(64) DEFAULT NULL,
  `password` varchar(64) NOT NULL,
  `salt` varchar(64) DEFAULT NULL,
  `name` varchar(64) DEFAULT NULL,
  `sex` int(11) DEFAULT NULL,
  `age` int(11) DEFAULT '0' COMMENT 'å¹´é¾„',
  `mobile` char(11) DEFAULT NULL COMMENT 'æ‰‹æœºå·',
  `email` varchar(64) DEFAULT NULL,
  `is_enable` int(11) DEFAULT '1' COMMENT 'æ˜¯å¦å¯ç”¨ 1-æ­£å¸¸ 0-ç¦ç”¨',
  `create_time` datetime NOT NULL,
  `modification_time` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username_unique` (`username`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of think_admin
-- ----------------------------
INSERT INTO `think_admin` VALUES ('1', '1', 'admin', '超级管理员', '5a374e2822774fe385702021715c85f6', '55b5dd9f833f2', null, null, '0', null, null, '1', '2015-07-27 15:30:00', '2015-07-27 15:30:06');

-- ----------------------------
-- Table structure for think_article
-- ----------------------------
DROP TABLE IF EXISTS `think_article`;
CREATE TABLE `think_article` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `catalog_id` int(11) NOT NULL COMMENT 'åˆ†ç±»ID',
  `admin_id` int(11) NOT NULL COMMENT 'åŽå°å‘å¸ƒäººid',
  `router_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL COMMENT 'æ–‡ç« æ ‡é¢˜',
  `writer` varchar(64) NOT NULL COMMENT 'ä½œè€…',
  `source` varchar(64) NOT NULL COMMENT 'æ¥æº',
  `thumb` varchar(512) DEFAULT NULL,
  `view_count` int(11) NOT NULL DEFAULT '0' COMMENT 'æµè§ˆæ¬¡æ•°',
  `content` text NOT NULL COMMENT 'æ–‡ç« å†…å®¹',
  `status` varchar(255) NOT NULL DEFAULT '1' COMMENT 'çŠ¶æ€ 1-æ­£å¸¸å‘å¸ƒ 0-ä¸æ˜¾ç¤º -1 å›žæ”¶ç«™',
  `create_time` datetime NOT NULL,
  `modification_time` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_router_id` (`router_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of think_article
-- ----------------------------

-- ----------------------------
-- Table structure for think_article_tag_map
-- ----------------------------
DROP TABLE IF EXISTS `think_article_tag_map`;
CREATE TABLE `think_article_tag_map` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `article_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_key` (`article_id`,`tag_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED COMMENT='文章和标签对应表';

-- ----------------------------
-- Records of think_article_tag_map
-- ----------------------------

-- ----------------------------
-- Table structure for think_catalog
-- ----------------------------
DROP TABLE IF EXISTS `think_catalog`;
CREATE TABLE `think_catalog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pid` int(11) NOT NULL DEFAULT '0' COMMENT 'çˆ¶çº§åˆ†ç±»',
  `router_id` int(11) NOT NULL,
  `name` varchar(64) NOT NULL COMMENT 'åˆ†ç±»åç§°',
  `sort` int(11) NOT NULL DEFAULT '1' COMMENT 'æŽ’åº',
  `title` varchar(64) DEFAULT NULL COMMENT 'åˆ†ç±»æ ‡é¢˜',
  `keywords` varchar(400) DEFAULT NULL COMMENT 'å…³é”®è¯,SEOä½¿ç”¨',
  `description` varchar(500) DEFAULT NULL COMMENT 'æè¿°ï¼ŒSEO',
  `is_show` int(11) NOT NULL DEFAULT '1' COMMENT 'æ˜¯å¦æ˜¾ç¤º 1-æ˜¾ç¤º 0-ä¸æ˜¾ç¤º',
  `list_tpl` varchar(255) NOT NULL COMMENT 'åˆ—è¡¨é¡µæ¨¡æ¿',
  `content_tpl` varchar(255) NOT NULL COMMENT 'å†…å®¹é¡µæ¨¡æ¿',
  `create_time` datetime NOT NULL,
  `modification_time` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_router_id` (`router_id`) USING BTREE,
  UNIQUE KEY `unique_title` (`title`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='文章分类表';

-- ----------------------------
-- Records of think_catalog
-- ----------------------------

-- ----------------------------
-- Table structure for think_group
-- ----------------------------
DROP TABLE IF EXISTS `think_group`;
CREATE TABLE `think_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) NOT NULL,
  `remark` text,
  `create_time` datetime NOT NULL,
  `modification_time` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_name` (`name`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of think_group
-- ----------------------------
INSERT INTO `think_group` VALUES ('1', '超级管理员组', null, '2015-07-27 15:28:49', '2015-07-27 15:28:56');

-- ----------------------------
-- Table structure for think_group_node_map
-- ----------------------------
DROP TABLE IF EXISTS `think_group_node_map`;
CREATE TABLE `think_group_node_map` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_id` int(11) DEFAULT NULL,
  `node_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `group_id_node_id_unique` (`group_id`,`node_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED;

-- ----------------------------
-- Records of think_group_node_map
-- ----------------------------

-- ----------------------------
-- Table structure for think_login_log
-- ----------------------------
DROP TABLE IF EXISTS `think_login_log`;
CREATE TABLE `think_login_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(64) NOT NULL,
  `password` varchar(64) DEFAULT NULL,
  `is_success` int(11) NOT NULL COMMENT 'æ˜¯å¦ç™»é™†æˆåŠŸ 1-æˆåŠŸ 0-å¤±è´¥',
  `create_time` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of think_login_log
-- ----------------------------

-- ----------------------------
-- Table structure for think_node
-- ----------------------------
DROP TABLE IF EXISTS `think_node`;
CREATE TABLE `think_node` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pid` int(11) DEFAULT NULL,
  `node` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `is_show` int(11) NOT NULL DEFAULT '1' COMMENT 'æ˜¯å¦æ˜¾ç¤ºåœ¨å·¦ä¾§èœå• 1-æ˜¾ç¤º 0-ä¸æ˜¾ç¤º',
  `create_time` datetime NOT NULL,
  `modification_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_node` (`node`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of think_node
-- ----------------------------
INSERT INTO `think_node` VALUES ('1', '0', 'Index/index', '后台首页', '1', '2015-07-27 15:19:30', '2015-07-27 15:19:37');
INSERT INTO `think_node` VALUES ('2', '0', 'Catalog/index', '分类管理', '1', '2015-07-27 15:19:30', '2015-07-27 15:19:37');
INSERT INTO `think_node` VALUES ('3', '0', 'Article/index', '文章管理', '1', '2015-07-27 15:19:30', '2015-07-27 15:19:37');
INSERT INTO `think_node` VALUES ('4', '0', 'System/index', '系统设置', '1', '2015-07-27 15:19:30', '2015-07-27 15:19:30');
INSERT INTO `think_node` VALUES ('5', '4', 'Admin/index', '管理员', '1', '2015-07-27 15:19:30', '2015-07-27 15:19:30');
INSERT INTO `think_node` VALUES ('11', '4', 'Group/index', '管理组', '1', '2015-07-27 15:19:30', '2015-07-27 15:19:30');
INSERT INTO `think_node` VALUES ('12', '4', 'Node/index', '节点管理', '1', '2015-07-27 15:19:30', '2015-07-27 15:19:30');

-- ----------------------------
-- Table structure for think_review
-- ----------------------------
DROP TABLE IF EXISTS `think_review`;
CREATE TABLE `think_review` (
  `id` int(11) NOT NULL DEFAULT '0',
  `pid` int(11) DEFAULT NULL,
  `article_id` int(11) DEFAULT NULL,
  `nickname` varchar(255) DEFAULT NULL COMMENT 'è¯„è®ºäººæ˜µç§°',
  `content` varchar(500) DEFAULT NULL COMMENT 'è¯„è®ºå†…å®¹',
  `ip` char(15) DEFAULT NULL COMMENT 'è¯„è®ºäººip',
  `create_time` datetime DEFAULT NULL,
  `modification_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of think_review
-- ----------------------------

-- ----------------------------
-- Table structure for think_router
-- ----------------------------
DROP TABLE IF EXISTS `think_router`;
CREATE TABLE `think_router` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `rule` varchar(255) NOT NULL,
  `link` varchar(255) NOT NULL,
  `create_time` datetime NOT NULL,
  `modification_time` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_rule` (`rule`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of think_router
-- ----------------------------

-- ----------------------------
-- Table structure for think_stats
-- ----------------------------
DROP TABLE IF EXISTS `think_stats`;
CREATE TABLE `think_stats` (
  `id` int(11) NOT NULL DEFAULT '0',
  `link` varchar(500) DEFAULT NULL COMMENT 'è®¿é—®çš„é“¾æŽ¥',
  `ip` char(15) DEFAULT NULL COMMENT ' è®¿é—®çš„ip',
  `create_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of think_stats
-- ----------------------------

-- ----------------------------
-- Table structure for think_tag
-- ----------------------------
DROP TABLE IF EXISTS `think_tag`;
CREATE TABLE `think_tag` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) NOT NULL COMMENT 'æ ‡ç­¾åç§°',
  `create_time` datetime NOT NULL,
  `modification_time` datetime NOT NULL,
  `is_enable` int(11) NOT NULL DEFAULT '1' COMMENT 'æ˜¯å¦å¯ç”¨æ ‡ç­¾ 1-å¯ç”¨ 0-ç¦ç”¨',
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_name` (`name`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='æ ‡ç­¾è¡¨,\r\næå–æ–‡ç« ä¸­çš„æ ‡ç­¾,æ’å…¥æ ‡ç­¾è¡¨';

-- ----------------------------
-- Records of think_tag
-- ----------------------------
