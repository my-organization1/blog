/*
Navicat MySQL Data Transfer

Source Server         : 127.0.0.1
Source Server Version : 50611
Source Host           : localhost:3306
Source Database       : blog

Target Server Type    : MYSQL
Target Server Version : 50611
File Encoding         : 65001

Date: 2015-07-21 10:19:29
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for think_admin
-- ----------------------------
DROP TABLE IF EXISTS `think_admin`;
CREATE TABLE `think_admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '性别 1-男 2-女 3-保密',
  `group_id` int(11) DEFAULT NULL,
  `username` varchar(64) NOT NULL,
  `nickname` varchar(64) DEFAULT NULL,
  `password` varchar(64) NOT NULL,
  `salt` varchar(64) DEFAULT NULL,
  `name` varchar(64) DEFAULT NULL,
  `sex` int(11) DEFAULT NULL,
  `age` int(11) DEFAULT '0' COMMENT '年龄',
  `mobile` char(11) DEFAULT NULL COMMENT '手机号',
  `email` varchar(64) DEFAULT NULL,
  `is_enable` int(11) DEFAULT '1' COMMENT '是否启用 1-正常 0-禁用',
  `create_time` datetime NOT NULL,
  `modification_time` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username_unique` (`username`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of think_admin
-- ----------------------------
INSERT INTO `think_admin` VALUES ('1', '1', 'admin', '?????', 'e1d69adf8630db95c12e4c41ae23bf0f', '55a13d98c7852', null, '1', '10', '18000000000', null, '1', '2015-07-12 00:00:54', '2015-07-12 00:00:56');

-- ----------------------------
-- Table structure for think_article
-- ----------------------------
DROP TABLE IF EXISTS `think_article`;
CREATE TABLE `think_article` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `catalog_id` int(11) NOT NULL COMMENT '分类ID',
  `admin_id` int(11) NOT NULL COMMENT '后台发布人id',
  `link_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL COMMENT '文章标题',
  `writer` varchar(64) NOT NULL COMMENT '作者',
  `source` varchar(64) NOT NULL COMMENT '来源',
  `thumb` varchar(512) DEFAULT NULL,
  `view_count` int(11) NOT NULL DEFAULT '0' COMMENT '浏览次数',
  `content` text NOT NULL COMMENT '文章内容',
  `status` varchar(255) NOT NULL DEFAULT '1' COMMENT '状态 1-正常发布 0-不显示 -1 回收站',
  `create_time` datetime NOT NULL,
  `modification_time` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of think_article
-- ----------------------------
INSERT INTO `think_article` VALUES ('2', '1', '1', '0', '????', '??', '??', './111.jpg', '0', '????', '1', '2015-07-20 14:40:48', '2015-07-20 14:40:48');
INSERT INTO `think_article` VALUES ('3', '1', '1', '0', '????', '??', '??', './111.jpg', '0', '????', '1', '2015-07-20 14:43:15', '2015-07-20 14:43:15');
INSERT INTO `think_article` VALUES ('4', '1', '1', '0', '????', '??', '??', './111.jpg', '0', '????', '1', '2015-07-20 14:43:46', '2015-07-20 14:43:46');
INSERT INTO `think_article` VALUES ('5', '1', '1', '0', '????', '??', '??', './111.jpg', '0', '????', '1', '2015-07-20 14:44:36', '2015-07-20 14:44:36');
INSERT INTO `think_article` VALUES ('7', '1', '1', '0', '????', '??', '??', './111.jpg', '0', '????', '1', '2015-07-20 14:46:25', '2015-07-20 14:56:59');
INSERT INTO `think_article` VALUES ('8', '1', '1', '0', '????', '??', '??', './111.jpg', '0', '????', '1', '2015-07-20 14:47:02', '2015-07-20 14:47:02');

-- ----------------------------
-- Table structure for think_article_tag_map
-- ----------------------------
DROP TABLE IF EXISTS `think_article_tag_map`;
CREATE TABLE `think_article_tag_map` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `article_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED COMMENT='????????';

-- ----------------------------
-- Records of think_article_tag_map
-- ----------------------------
INSERT INTO `think_article_tag_map` VALUES ('2', '8', '24');
INSERT INTO `think_article_tag_map` VALUES ('7', '0', '27');
INSERT INTO `think_article_tag_map` VALUES ('8', '0', '26');
INSERT INTO `think_article_tag_map` VALUES ('9', '0', '24');
INSERT INTO `think_article_tag_map` VALUES ('10', '7', '27');
INSERT INTO `think_article_tag_map` VALUES ('11', '7', '26');
INSERT INTO `think_article_tag_map` VALUES ('12', '7', '24');

-- ----------------------------
-- Table structure for think_catalog
-- ----------------------------
DROP TABLE IF EXISTS `think_catalog`;
CREATE TABLE `think_catalog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pid` int(11) NOT NULL DEFAULT '0' COMMENT '父级分类',
  `link_id` int(11) NOT NULL,
  `name` varchar(64) NOT NULL COMMENT '分类名称',
  `link` varchar(255) NOT NULL COMMENT '访问链接，不加网址',
  `sort` int(11) NOT NULL DEFAULT '1' COMMENT '排序',
  `title` varchar(64) DEFAULT NULL COMMENT '分类标题',
  `keywords` varchar(400) DEFAULT NULL COMMENT '关键词,SEO使用',
  `description` varchar(500) DEFAULT NULL COMMENT '描述，SEO',
  `is_show` int(11) NOT NULL DEFAULT '1' COMMENT '是否显示 1-显示 0-不显示',
  `list_tpl` varchar(255) NOT NULL COMMENT '列表页模板',
  `content_tpl` varchar(255) NOT NULL COMMENT '内容页模板',
  `create_time` datetime NOT NULL,
  `modification_time` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='?????';

-- ----------------------------
-- Records of think_catalog
-- ----------------------------
INSERT INTO `think_catalog` VALUES ('1', '0', '0', 'PHP', 'php', '1', 'PHP', 'php', null, '1', 'list', 'content', '2015-07-20 14:35:18', '2015-07-20 14:35:18');

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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of think_group
-- ----------------------------
INSERT INTO `think_group` VALUES ('1', '超级管理员组', '超级管理员组', '2015-07-12 00:00:00', '2015-07-12 00:00:02');

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
-- Table structure for think_link
-- ----------------------------
DROP TABLE IF EXISTS `think_link`;
CREATE TABLE `think_link` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url` varchar(255) NOT NULL COMMENT '访问URL',
  `link` varchar(255) NOT NULL COMMENT '指向URL',
  `create_time` datetime NOT NULL,
  `modification_time` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of think_link
-- ----------------------------

-- ----------------------------
-- Table structure for think_login_log
-- ----------------------------
DROP TABLE IF EXISTS `think_login_log`;
CREATE TABLE `think_login_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(64) NOT NULL,
  `password` varchar(64) DEFAULT NULL,
  `is_success` int(11) NOT NULL COMMENT '是否登陆成功 1-成功 0-失败',
  `create_time` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of think_login_log
-- ----------------------------
INSERT INTO `think_login_log` VALUES ('1', 'admin', null, '1', '2015-07-12 09:10:15');
INSERT INTO `think_login_log` VALUES ('2', 'admin', null, '1', '2015-07-12 09:27:18');
INSERT INTO `think_login_log` VALUES ('3', 'admin', null, '1', '2015-07-12 09:28:54');
INSERT INTO `think_login_log` VALUES ('4', 'admin', null, '1', '2015-07-12 09:29:26');
INSERT INTO `think_login_log` VALUES ('5', 'admin', null, '1', '2015-07-12 09:30:04');
INSERT INTO `think_login_log` VALUES ('6', 'admin', null, '1', '2015-07-12 09:30:42');
INSERT INTO `think_login_log` VALUES ('7', 'admin', null, '1', '2015-07-12 09:37:01');
INSERT INTO `think_login_log` VALUES ('8', 'admin', null, '1', '2015-07-12 09:37:48');
INSERT INTO `think_login_log` VALUES ('9', 'admin', null, '1', '2015-07-12 09:38:51');
INSERT INTO `think_login_log` VALUES ('10', 'admin', null, '1', '2015-07-12 09:39:12');
INSERT INTO `think_login_log` VALUES ('11', 'admin', null, '1', '2015-07-12 09:41:02');
INSERT INTO `think_login_log` VALUES ('12', 'admin', null, '1', '2015-07-12 09:41:52');
INSERT INTO `think_login_log` VALUES ('13', 'admin', null, '1', '2015-07-13 21:43:01');
INSERT INTO `think_login_log` VALUES ('14', 'admin', null, '1', '2015-07-13 22:06:34');
INSERT INTO `think_login_log` VALUES ('15', 'admin', null, '1', '2015-07-14 22:27:04');

-- ----------------------------
-- Table structure for think_node
-- ----------------------------
DROP TABLE IF EXISTS `think_node`;
CREATE TABLE `think_node` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pid` int(11) DEFAULT NULL,
  `node` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `is_show` int(11) NOT NULL DEFAULT '1' COMMENT '是否显示在左侧菜单 1-显示 0-不显示',
  `create_time` datetime NOT NULL,
  `modification_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of think_node
-- ----------------------------
INSERT INTO `think_node` VALUES ('1', '0', 'Index/index', '后台首页', '1', '2015-07-12 09:10:41', '2015-07-12 09:10:43');
INSERT INTO `think_node` VALUES ('2', '0', 'Catalog/index', '分类管理', '1', '2015-07-12 09:13:59', '2015-07-12 09:14:01');
INSERT INTO `think_node` VALUES ('3', '0', 'Article/index', '文章管理', '1', '2015-07-12 09:14:19', '2015-07-12 09:14:20');
INSERT INTO `think_node` VALUES ('4', '0', 'Review/index', '评论管理', '1', '2015-07-12 09:14:39', '2015-07-12 09:14:42');
INSERT INTO `think_node` VALUES ('5', '0', 'System/index', '系统设置', '1', '2015-07-12 09:15:06', '2015-07-12 09:15:07');
INSERT INTO `think_node` VALUES ('6', '5', 'Admin/index', '管理员', '1', '2015-07-12 09:15:23', '2015-07-12 09:15:25');
INSERT INTO `think_node` VALUES ('7', '5', 'Group/index', '管理组', '1', '2015-07-12 09:15:40', '2015-07-12 09:15:42');
INSERT INTO `think_node` VALUES ('8', '5', 'Node/index', '节点管理', '1', '2015-07-12 09:15:55', '2015-07-12 09:15:56');
INSERT INTO `think_node` VALUES ('9', '2', 'Catalog/add', '新增分类', '0', '2015-07-12 09:38:31', '2015-07-12 09:38:33');

-- ----------------------------
-- Table structure for think_review
-- ----------------------------
DROP TABLE IF EXISTS `think_review`;
CREATE TABLE `think_review` (
  `id` int(11) NOT NULL DEFAULT '0',
  `pid` int(11) DEFAULT NULL,
  `article_id` int(11) DEFAULT NULL,
  `nickname` varchar(255) DEFAULT NULL COMMENT '评论人昵称',
  `content` varchar(500) DEFAULT NULL COMMENT '评论内容',
  `ip` char(15) DEFAULT NULL COMMENT '评论人ip',
  `create_time` datetime DEFAULT NULL,
  `modification_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of think_review
-- ----------------------------

-- ----------------------------
-- Table structure for think_stats
-- ----------------------------
DROP TABLE IF EXISTS `think_stats`;
CREATE TABLE `think_stats` (
  `id` int(11) NOT NULL DEFAULT '0',
  `link` varchar(500) DEFAULT NULL COMMENT '访问的链接',
  `ip` char(15) DEFAULT NULL COMMENT ' 访问的ip',
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
  `name` varchar(64) NOT NULL COMMENT '标签名称',
  `create_time` datetime NOT NULL,
  `modification_time` datetime NOT NULL,
  `is_enable` int(11) NOT NULL DEFAULT '1' COMMENT '是否启用标签 1-启用 0-禁用',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8 COMMENT='标签表,\r\n提取文章中的标签,插入标签表';

-- ----------------------------
-- Records of think_tag
-- ----------------------------
INSERT INTO `think_tag` VALUES ('22', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '1');
INSERT INTO `think_tag` VALUES ('23', 'php', '2015-07-20 14:46:25', '2015-07-20 14:46:25', '1');
INSERT INTO `think_tag` VALUES ('24', 'thinkphp', '2015-07-20 14:47:02', '2015-07-20 14:47:02', '1');
INSERT INTO `think_tag` VALUES ('25', '', '2015-07-20 14:48:13', '2015-07-20 14:48:13', '1');
INSERT INTO `think_tag` VALUES ('26', 'thinkphp', '2015-07-20 14:49:15', '2015-07-20 14:49:15', '1');
INSERT INTO `think_tag` VALUES ('27', 'thinkphp', '2015-07-20 14:49:50', '2015-07-20 14:49:50', '1');
