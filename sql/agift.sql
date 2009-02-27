# HeidiSQL Dump 
#
# --------------------------------------------------------
# Host:                         127.0.0.1
# Database:                     agift
# Server version:               5.1.23-rc-community
# Server OS:                    Win32
# Target compatibility:         mysqldump+mysqlcli 5.0
# Target max_allowed_packet:    1048576
# HeidiSQL version:             4.0 RC3
# Date/time:                    2009-02-27 21:36:51
# --------------------------------------------------------

/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0*/;


#
# Database structure for database 'agift'
#

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `agift` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `agift`;


#
# Table structure for table 'categories'
#

CREATE TABLE /*!32312 IF NOT EXISTS*/ `categories` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `parent_id` int(10) NOT NULL DEFAULT '0',
  `lft` int(10) unsigned DEFAULT NULL,
  `rght` int(10) unsigned DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `supplier` int(3) unsigned NOT NULL DEFAULT '0',
  `name` varchar(250) NOT NULL DEFAULT '',
  `description` varchar(250) DEFAULT NULL,
  `images` text,
  `page` int(10) unsigned DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=237 DEFAULT CHARSET=utf8;



#
# Table structure for table 'categories_gifts'
#

CREATE TABLE /*!32312 IF NOT EXISTS*/ `categories_gifts` (
  `category_id` int(10) unsigned NOT NULL,
  `gift_id` int(10) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



#
# Table structure for table 'file_uploads'
#

CREATE TABLE /*!32312 IF NOT EXISTS*/ `file_uploads` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `file_name` varchar(250) NOT NULL,
  `mime_type` varchar(32) NOT NULL,
  `file_size` varchar(50) NOT NULL,
  `subdir` varchar(25) NOT NULL,
  `order_id` int(10) DEFAULT NULL,
  `session_id` int(10) unsigned DEFAULT NULL,
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=104 DEFAULT CHARSET=utf8;



#
# Table structure for table 'gift_attachments'
#

CREATE TABLE /*!32312 IF NOT EXISTS*/ `gift_attachments` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `gift_id` int(10) unsigned NOT NULL,
  `file` varchar(250) DEFAULT NULL,
  `marking_note` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



#
# Table structure for table 'gifts'
#

CREATE TABLE /*!32312 IF NOT EXISTS*/ `gifts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(50) NOT NULL,
  `supplier` int(9) unsigned NOT NULL,
  `name` text,
  `color` varchar(50) DEFAULT NULL,
  `material` text,
  `size` text,
  `packsize` varchar(150) DEFAULT NULL,
  `packqty` int(10) unsigned DEFAULT NULL,
  `packtype` varchar(150) DEFAULT NULL,
  `weight` float unsigned DEFAULT NULL,
  `content1` text,
  `content2` text,
  `price` float(9,2) unsigned DEFAULT '0.00',
  `old_id` int(10) unsigned DEFAULT NULL,
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`,`supplier`)
) ENGINE=MyISAM AUTO_INCREMENT=9398 DEFAULT CHARSET=utf8;



#
# Table structure for table 'groups'
#

CREATE TABLE /*!32312 IF NOT EXISTS*/ `groups` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;



#
# Table structure for table 'images'
#

CREATE TABLE /*!32312 IF NOT EXISTS*/ `images` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `gift_id` int(10) unsigned NOT NULL,
  `img` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `img` (`img`)
) ENGINE=InnoDB AUTO_INCREMENT=11652 DEFAULT CHARSET=utf8;



#
# Table structure for table 'line_items'
#

CREATE TABLE /*!32312 IF NOT EXISTS*/ `line_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL DEFAULT '0',
  `gift_id` int(11) NOT NULL DEFAULT '0',
  `product` varchar(255) NOT NULL DEFAULT '',
  `quantity` int(11) NOT NULL DEFAULT '1',
  `price` decimal(19,8) DEFAULT '0.00000000',
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=193 DEFAULT CHARSET=utf8;



#
# Table structure for table 'news'
#

CREATE TABLE /*!32312 IF NOT EXISTS*/ `news` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  `shortbody` text NOT NULL,
  `mainbody` text,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;



#
# Table structure for table 'orders'
#

CREATE TABLE /*!32312 IF NOT EXISTS*/ `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status` int(3) unsigned DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `session_id` varchar(250) DEFAULT NULL,
  `number` int(11) DEFAULT '0',
  `ip` varchar(100) DEFAULT NULL,
  `firstname` varchar(64) DEFAULT '',
  `email` varchar(64) DEFAULT '',
  `phone` varchar(32) DEFAULT '',
  `addInfo` text,
  `total_price` decimal(19,8) DEFAULT NULL,
  `line_item_count` int(10) unsigned DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=153 DEFAULT CHARSET=utf8;



#
# Table structure for table 'users'
#

CREATE TABLE /*!32312 IF NOT EXISTS*/ `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `group_id` int(11) NOT NULL DEFAULT '0',
  `password` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `email` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `contact` varchar(50) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `company` varchar(50) DEFAULT NULL,
  `business` text,
  `website` varchar(250) DEFAULT NULL,
  `address1` text,
  `address2` text,
  `bank_detail` text,
  `active` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `birthday` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS*/;
