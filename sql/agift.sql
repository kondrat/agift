# HeidiSQL Dump 
#
# --------------------------------------------------------
# Host:                         127.0.0.1
# Database:                     agift
# Server version:               5.0.6-beta-nt
# Server OS:                    Win32
# Target compatibility:         HeidiSQL w/ MySQL Server 4.0
# Target max_allowed_packet:    1048576
# HeidiSQL version:             4.0 RC3
# Date/time:                    2009-03-01 14:27:17
# --------------------------------------------------------

/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;*/


#
# Database structure for database 'agift'
#

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `agift` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `agift`;


#
# Table structure for table 'artest'
#

CREATE TABLE /*!32312 IF NOT EXISTS*/ `artest` (
  `id` tinyint(3) unsigned NOT NULL auto_increment,
  `title` varchar(200) default NULL,
  `body` text,
  PRIMARY KEY  (`id`),
  FULLTEXT KEY `NewIndex` (`body`,`title`)
) TYPE=MyISAM;



#
# Table structure for table 'categories'
#

CREATE TABLE /*!32312 IF NOT EXISTS*/ `categories` (
  `id` int(5) NOT NULL auto_increment,
  `parent_id` int(10) NOT NULL default '0',
  `lft` int(10) unsigned default NULL,
  `rght` int(10) unsigned default NULL,
  `active` tinyint(1) NOT NULL default '1',
  `supplier` int(3) unsigned NOT NULL default '0',
  `name` varchar(250) NOT NULL default '',
  `description` varchar(250) default NULL,
  `images` text,
  `page` int(10) unsigned default NULL,
  `created` datetime default NULL,
  `modified` datetime default NULL,
  PRIMARY KEY  (`id`)
) TYPE=InnoDB;



#
# Table structure for table 'categories_gifts'
#

CREATE TABLE /*!32312 IF NOT EXISTS*/ `categories_gifts` (
  `category_id` int(10) unsigned NOT NULL,
  `gift_id` int(10) unsigned NOT NULL
) TYPE=InnoDB;



#
# Table structure for table 'file_uploads'
#

CREATE TABLE /*!32312 IF NOT EXISTS*/ `file_uploads` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `file_name` varchar(250) NOT NULL,
  `mime_type` varchar(32) NOT NULL,
  `file_size` varchar(50) NOT NULL,
  `subdir` varchar(25) NOT NULL,
  `order_id` int(10) default NULL,
  `session_id` int(10) unsigned default NULL,
  `created` datetime default NULL,
  `modified` datetime default NULL,
  PRIMARY KEY  (`id`)
) TYPE=InnoDB;



#
# Table structure for table 'gift_attachments'
#

CREATE TABLE /*!32312 IF NOT EXISTS*/ `gift_attachments` (
  `id` tinyint(3) unsigned NOT NULL auto_increment,
  `gift_id` int(10) unsigned NOT NULL,
  `file` varchar(250) default NULL,
  `marking_note` varchar(250) default NULL,
  PRIMARY KEY  (`id`)
) TYPE=InnoDB;



#
# Table structure for table 'gifts'
#

CREATE TABLE /*!32312 IF NOT EXISTS*/ `gifts` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `code` varchar(50) NOT NULL,
  `supplier` int(9) unsigned NOT NULL,
  `name` text,
  `color` varchar(50) default NULL,
  `material` text,
  `size` text,
  `packsize` varchar(150) default NULL,
  `packqty` int(10) unsigned default NULL,
  `packtype` varchar(150) default NULL,
  `weight` float unsigned default NULL,
  `content1` text,
  `content2` text,
  `price` float(9,2) unsigned default '0.00',
  `old_id` int(10) unsigned default NULL,
  `created` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `code` (`code`,`supplier`)
) TYPE=MyISAM;



#
# Table structure for table 'groups'
#

CREATE TABLE /*!32312 IF NOT EXISTS*/ `groups` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(64) character set utf8 collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`id`)
) TYPE=InnoDB;



#
# Table structure for table 'images'
#

CREATE TABLE /*!32312 IF NOT EXISTS*/ `images` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `gift_id` int(10) unsigned NOT NULL,
  `img` varchar(250) default NULL,
  PRIMARY KEY  (`id`),
  KEY `img` (`img`)
) TYPE=InnoDB;



#
# Table structure for table 'line_items'
#

CREATE TABLE /*!32312 IF NOT EXISTS*/ `line_items` (
  `id` int(11) NOT NULL auto_increment,
  `order_id` int(11) NOT NULL default '0',
  `gift_id` int(11) NOT NULL default '0',
  `product` varchar(255) NOT NULL default '',
  `quantity` int(11) NOT NULL default '1',
  `price` decimal(19,8) default '0.00000000',
  `created` datetime default NULL,
  `modified` datetime default NULL,
  PRIMARY KEY  (`id`)
) TYPE=InnoDB;



#
# Table structure for table 'news'
#

CREATE TABLE /*!32312 IF NOT EXISTS*/ `news` (
  `id` tinyint(3) unsigned NOT NULL auto_increment,
  `name` varchar(150) NOT NULL,
  `shortbody` text NOT NULL,
  `mainbody` text,
  `created` datetime NOT NULL,
  PRIMARY KEY  (`id`)
) TYPE=InnoDB;



#
# Table structure for table 'orders'
#

CREATE TABLE /*!32312 IF NOT EXISTS*/ `orders` (
  `id` int(11) NOT NULL auto_increment,
  `status` int(3) unsigned default NULL,
  `user_id` int(11) default NULL,
  `session_id` varchar(250) default NULL,
  `number` int(11) default '0',
  `ip` varchar(100) default NULL,
  `firstname` varchar(64) default '',
  `email` varchar(64) default '',
  `phone` varchar(32) default '',
  `addInfo` text,
  `total_price` decimal(19,8) default NULL,
  `line_item_count` int(10) unsigned default NULL,
  `created` datetime default NULL,
  `modified` datetime default NULL,
  PRIMARY KEY  (`id`)
) TYPE=InnoDB;



#
# Table structure for table 'users'
#

CREATE TABLE /*!32312 IF NOT EXISTS*/ `users` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `username` varchar(64) character set utf8 collate utf8_unicode_ci NOT NULL default '',
  `group_id` int(11) NOT NULL default '0',
  `password` varchar(64) character set utf8 collate utf8_unicode_ci NOT NULL default '',
  `email` varchar(100) character set utf8 collate utf8_unicode_ci NOT NULL default '',
  `contact` varchar(50) default NULL,
  `phone` varchar(50) default NULL,
  `company` varchar(50) default NULL,
  `business` text,
  `fax` varchar(50) default NULL,
  `website` varchar(250) default NULL,
  `address1` text,
  `address2` text,
  `bank_detail` text,
  `active` tinyint(1) unsigned NOT NULL default '0',
  `created` datetime default NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `username` (`username`)
) TYPE=InnoDB;

/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;*/
